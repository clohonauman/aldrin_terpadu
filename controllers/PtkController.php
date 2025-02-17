<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\UploadForm;
use app\models\Ptk;
use moonland\phpexcel\Excel;
use app\components\BaseController;

class PtkController extends BaseController
{
    public function actionIndex()
    {
        $ptk_id = Yii::$app->request->get('id', ''); // Default value jika tidak ada 'ptk'
        $ptk_id = \yii\helpers\Html::encode($ptk_id); // Mencegah XSS
    
        $query = (new \yii\db\Query())
            ->select([
                'ptk.*',
                'sekolah.npsn',
                'sekolah.nama AS nama_sekolah',
                'sekolah.bentuk_pendidikan',
                'sekolah.status_sekolah',
                'sekolah.kecamatan',
                'TIMESTAMPDIFF(YEAR, ptk.tanggal_lahir, CURDATE()) AS usia_sekarang' // Menghitung usia saat ini
            ])
            ->from('ptk')
            ->leftJoin('sekolah', 'sekolah.npsn = ptk.sekolah_id');
    
        if (empty($ptk_id)) {
            // Filter berdasarkan bentuk_pendidikan
            if (!empty(Yii::$app->request->get('bentuk_pendidikan'))) {
                $query->andWhere(['sekolah.bentuk_pendidikan' => Yii::$app->request->get('bentuk_pendidikan')]);
            }
    
            // Filter berdasarkan kecamatan
            if (!empty(Yii::$app->request->get('kecamatan'))) {
                $query->andWhere(['sekolah.kecamatan' => Yii::$app->request->get('kecamatan')]);
            }

            // Filter berdasarkan jenis kelamin
            if (!empty(Yii::$app->request->get('jenis_kelamin'))) {
                $query->andWhere(['ptk.jenis_kelamin' => Yii::$app->request->get('jenis_kelamin')]);
            }
    
            // Filter berdasarkan waktu pensiun
            if (!empty(Yii::$app->request->get('pensiun'))) {
                $tahun_ke_depan = (int)Yii::$app->request->get('pensiun');
                $usia_pensiun = 60; // Misalnya usia pensiun adalah 60 tahun
                $tahun_sekarang = date('Y');
    
                // Menghitung tahun lahir maksimum yang akan mencapai usia pensiun dalam X tahun
                $tahun_lahir_maks = $tahun_sekarang - ($usia_pensiun - $tahun_ke_depan);
    
                $query->andWhere(['<=', 'YEAR(ptk.tanggal_lahir)', $tahun_lahir_maks]);
            }
            
            //membatasi akses agar jika operator sekolah hanya menampilkan data di sekolahnya.
            if (Yii::$app->session->get('kode_akses')==3) {
                $query->andWhere(['sekolah.npsn' => Yii::$app->session->get('id_sekolah')]);
            }
    
            $data = $query->all();
            $this->saveLogAktivitasTerpadu('GET: PTK');
            return $this->render('index', ['data' => $data]);
        } else {
            // Filter berdasarkan ptk_id
            $query->andWhere(['ptk.ptk_id' => $ptk_id]);

            //membatasi akses agar jika operator sekolah hanya menampilkan data di sekolahnya.
            if (Yii::$app->session->get('kode_akses')==3) {
                $query->andWhere(['sekolah.npsn' => Yii::$app->session->get('id_sekolah')]);
            }
            
            $data = $query->one(); // Menggunakan `one()` karena detail seharusnya hanya satu data
    
            $this->saveLogAktivitasTerpadu('GET: PTK ('.$ptk_id.')');
            return $this->render('detail', ['data' => $data]);
        }
    }
      
    public function actionUpload()
    {
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                return $this->importExcel($model->file->tempName);
            }
        } else {
            return $this->render('upload', ['model' => $model]);
        }
        
    }

    public function actionInsert()
    {
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('UploadForm');
            return $this->importManual($postData);
        } else {
            return $this->render('insert', ['model' => $model]);
        }
    }

    public function actionEdit()
    {
        $ptk_id = Yii::$app->request->get('id', ''); // Default value jika tidak ada 'ptk'
        $ptk_id = \yii\helpers\Html::encode($ptk_id); // Mencegah XSS
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('UploadForm');
            return $this->updatedManual($postData,$ptk_id);
        } else {
            if (empty($ptk_id) OR Yii::$app->session->get('kode_akses')!=3) {
                Yii::$app->session->setFlash('error', 'Maaf terjadi kesalahan saat meminta data. Silahkan coba kembali atau hubungi admin Aldrin Terpadu. Terima kasih.');
                return $this->redirect(['index']);
            } else {
                $model=new UploadForm;
                $query = (new \yii\db\Query())
                    ->select([
                        'ptk.*',
                        'sekolah.npsn',
                        'sekolah.nama AS nama_sekolah',
                        'sekolah.bentuk_pendidikan',
                        'sekolah.status_sekolah',
                        'sekolah.kecamatan',
                        'TIMESTAMPDIFF(YEAR, ptk.tanggal_lahir, CURDATE()) AS usia_sekarang' // Menghitung usia saat ini
                    ])
                    ->from('ptk')
                    ->leftJoin('sekolah', 'sekolah.npsn = ptk.sekolah_id');
                $query->andWhere(['ptk.ptk_id' => $ptk_id]);
                $query->andWhere(['sekolah.npsn' => Yii::$app->session->get('id_sekolah')]);
                $data = $query->one();
                return $this->render('edit', [
                                                'data' => $data,
                                                'model' => $model
                                            ]);
            }
        }
    }
    
    protected function importExcel($tempFilePath)
    {
        $data = Excel::import($tempFilePath, [
            'setFirstRecordAsKeys' => true,
        ]);
        $totalData=0;
        $totalSkip=0;
        foreach ($data as $row) {
            if ((isset($row['NIK']) && Ptk::find()->where(['nik' => $row['NIK']])->exists()) OR $row['Status Tugas']=='Non Induk') {
                $totalSkip++;
                $totalData++;
                continue;
            }
            $totalData++;

            $ptk = new Ptk();
            $ptk->ptk_id = $this->generateUuid();
            $ptk->nama = $row['Nama'] ?? null;
            $ptk->nik = $row['NIK'] ?? null;
            $ptk->nuptk = isset($row['NUPTK']) ? trim($row['NUPTK']) : null;
            $ptk->nip = $row['NIP'] ?? null;
            $ptk->jenis_kelamin = $row['L/P'] ?? null;
            $ptk->tempat_lahir = $row['Tempat Lahir'] ?? null;
            $ptk->tanggal_lahir = isset($row['Tanggal Lahir']) ? date('Y-m-d', strtotime($row['Tanggal Lahir'])) : null;
            $ptk->status_keaktifan = $row['Status Tugas'] ?? null;
            $ptk->sekolah_id = $row['NPSN'] ?? null;
            $ptk->kecamatan = $row['Kecamatan'] ?? null;
            $ptk->kabupaten = $row['Kabupaten/Kota'] ?? null;
            $ptk->no_hp = $row['Nomor HP'] ?? null;
            $ptk->sk_cpns = $row['SK CPNS'] ?? null;
            $ptk->tgl_cpns = isset($row['Tanggal CPNS']) ? date('Y-m-d', strtotime($row['Tanggal CPNS'])) : null;
            $ptk->sk_pengangkatan = $row['SK Pengangkatan'] ?? null;
            $ptk->tmt_pengangkatan = isset($row['TMT Pengangkatan']) ? date('Y-m-d', strtotime($row['TMT Pengangkatan'])) : null;
            $ptk->jenis_ptk = $row['Jenis PTK'] ?? null;
            $ptk->jabatan = $row['Jabatan PTK'] ?? null;
            $ptk->status_kepegawaian = $row['Status Kepegawaian'] ?? null;
            $ptk->pangkat_golongan = $row['Pangkat/Gol'] ?? null;
            $ptk->save(false);
        }
        $totalSuccess=$totalData-$totalSkip;
        if($totalSkip>0){
            $this->saveLogAktivitasTerpadu('POST: PTK using Excel File');
            Yii::$app->session->setFlash('danger', 'Total Data: '.$totalData.'<br>Berhasil: '.$totalSuccess.'<br>Gagal: '.$totalSkip.' karena NIK sudah terdaftar/PTK Non Induk.');
        }else{
            $this->saveLogAktivitasTerpadu('POST: PTK using Excel File');
            Yii::$app->session->setFlash('success', 'Total Data: '.$totalData.'<br>Berhasil: '.$totalSuccess);
        }
        return $this->redirect(['index']);
    }

    protected function importManual($postData)
    {
        if (isset($postData['nik']) && Ptk::find()->where(['nik' => $postData['nik']])->exists()) {
            Yii::$app->session->setFlash('error', 'NIK sudah terdaftar.');
            return $this->redirect(['insert']);
        }
    
        $ptk = new Ptk();
        $ptk->ptk_id = $this->generateUuid(); // Tambahkan UUID sebagai ptk_id
        $ptk->nama = $postData['nama'] ?? null;
        $ptk->nik = $postData['nik'] ?? null;
        $ptk->nuptk = isset($postData['nuptk']) ? trim($postData['nuptk']) : null;
        $ptk->nip = $postData['nip'] ?? null;
        $ptk->jenis_kelamin = $postData['jenis_kelamin'] ?? null;
        $ptk->tempat_lahir = $postData['tempat_lahir'] ?? null;
        $ptk->tanggal_lahir = isset($postData['tanggal_lahir']) ? date('Y-m-d', strtotime($postData['tanggal_lahir'])) : null;
        $ptk->status_keaktifan = $postData['status_keaktifan'] ?? null;
        $ptk->sekolah_id = $postData['npsn'] ?? null;
        $ptk->kecamatan = $postData['kecamatan'] ?? null;
        $ptk->kabupaten = $postData['kabupaten'] ?? null;
        $ptk->no_hp = $postData['no_hp'] ?? null;
        $ptk->sk_cpns = $postData['sk_cpns'] ?? null;
        $ptk->tgl_cpns = isset($postData['tgl_cpns']) ? date('Y-m-d', strtotime($postData['tgl_cpns'])) : null;
        $ptk->sk_pengangkatan = $postData['sk_pengangkatan'] ?? null;
        $ptk->tmt_pengangkatan = isset($postData['tmt_pengangkatan']) ? date('Y-m-d', strtotime($postData['tmt_pengangkatan'])) : null;
        $ptk->jenis_ptk = $postData['jenis_ptk'] ?? null;
        $ptk->jabatan = $postData['jabatan'] ?? null;
        $ptk->status_kepegawaian = $postData['status_kepegawaian'] ?? null;
        $ptk->pangkat_golongan = $postData['pangkat_golongan'] ?? null;
    
        if ($ptk->save(false)) {
            $this->saveLogAktivitasTerpadu('POST: PTK ('.$ptk->ptk_id.')');
            Yii::$app->session->setFlash('success', 'Data berhasil ditambahkan secara manual.');
            return $this->redirect(['index']);
        } else {
            $this->saveLogAktivitasTerpadu('POST: PTK (500-'.$ptk->ptk_id.')');
            Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat menyimpan data.');
            return $this->redirect(['upload']);
        }
    }

    protected function updatedManual($postData, $ptk_id)
    {
        // Cek apakah NIK sudah terdaftar dan bukan milik PTK yang sedang diperbarui
        if (isset($postData['nik']) && Ptk::find()->where(['nik' => $postData['nik']])->andWhere(['!=', 'ptk_id', $ptk_id])->exists()) {
            Yii::$app->session->setFlash('error', 'NIK sudah terdaftar.');
            return $this->redirect(['ptk']);
        }
    
        // Cari data PTK berdasarkan ID
        $ptk = Ptk::findOne($ptk_id);
        if (!$ptk) {
            Yii::$app->session->setFlash('error', 'Data PTK tidak ditemukan.');
            return $this->redirect(['index']);
        }
    
        // Update data PTK
        $ptk->nama = $postData['nama'] ?? $ptk->nama;
        $ptk->nik = $postData['nik'] ?? $ptk->nik;
        $ptk->no_kk = $postData['no_kk'] ?? $ptk->no_kk;
        $ptk->nuptk = isset($postData['nuptk']) ? trim($postData['nuptk']) : $ptk->nuptk;
        $ptk->nip = $postData['nip'] ?? $ptk->nip;
        $ptk->jenis_kelamin = $postData['jenis_kelamin'] ?? $ptk->jenis_kelamin;
        $ptk->tempat_lahir = $postData['tempat_lahir'] ?? $ptk->tempat_lahir;
        $ptk->tanggal_lahir = isset($postData['tanggal_lahir']) ? date('Y-m-d', strtotime($postData['tanggal_lahir'])) : $ptk->tanggal_lahir;
        $ptk->sekolah_id = $postData['npsn'] ?? $ptk->sekolah_id;
        $ptk->kewarganegaraan = $postData['kewarganegaraan'] ?? $ptk->kewarganegaraan;
        $ptk->rt = $postData['rt'] ?? $ptk->rt;
        $ptk->rw = $postData['rw'] ?? $ptk->rw;
        $ptk->desa_kelurahan = $postData['desa_kelurahan'] ?? $ptk->desa_kelurahan;
        $ptk->kecamatan = $postData['kecamatan'] ?? $ptk->kecamatan;
        $ptk->kabupaten = $postData['kabupaten'] ?? $ptk->kabupaten;
        $ptk->provinsi = $postData['provinsi'] ?? $ptk->provinsi;
        $ptk->no_hp = $postData['no_hp'] ?? $ptk->no_hp;
        $ptk->email = $postData['email'] ?? $ptk->email;
        $ptk->sk_cpns = $postData['sk_cpns'] ?? $ptk->sk_cpns;
        $ptk->tgl_cpns = isset($postData['tgl_cpns']) ? date('Y-m-d', strtotime($postData['tgl_cpns'])) : $ptk->tgl_cpns;
        $ptk->sk_pengangkatan = $postData['sk_pengangkatan'] ?? $ptk->sk_pengangkatan;
        $ptk->tmt_pengangkatan = isset($postData['tmt_pengangkatan']) ? date('Y-m-d', strtotime($postData['tmt_pengangkatan'])) : $ptk->tmt_pengangkatan;
        $ptk->jenis_ptk = $postData['jenis_ptk'] ?? $ptk->jenis_ptk;
        $ptk->jabatan = $postData['jabatan'] ?? $ptk->jabatan;
        $ptk->status_kepegawaian = $postData['status_kepegawaian'] ?? $ptk->status_kepegawaian;
        $ptk->pangkat_golongan = $postData['pangkat_golongan'] ?? $ptk->pangkat_golongan;
        $ptk->data_status = $postData['data_status'] ?? $ptk->data_status;
    
        if ($ptk->save()) {
            $this->saveLogAktivitasTerpadu('PATCH: PTK ('.$ptk_id.')');
            Yii::$app->session->setFlash('success', 'Data berhasil diperbarui.');
        } else {
            $this->saveLogAktivitasTerpadu('PATCH: PTK (500-'.$ptk_id.')');
            Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat menyimpan data.');
        }
        
        return $this->redirect(['index']);
    }  

    public function actionDelete()
    {
        $ptk_id = Yii::$app->request->get('id', ''); // Ambil ID dari GET request
        $ptk_id = \yii\helpers\Html::encode($ptk_id); // Mencegah XSS
    
        // Cek validitas ptk_id dan hak akses
        if (!empty($ptk_id) AND Yii::$app->session->get('kode_akses') == 0) {
            $ptk = Ptk::findOne($ptk_id);
            if (!$ptk) {
                Yii::$app->session->setFlash('error', 'Data PTK tidak ditemukan.');
                return $this->redirect(['index']);
            }
        
            // Gunakan transaksi untuk keamanan
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($ptk->delete() !== false) {
                    $transaction->commit();
                    $this->saveLogAktivitasTerpadu('DELETE: PTK ('.$ptk_id.')');
                    Yii::$app->session->setFlash('success', 'Data PTK berhasil dihapus.');
                } else {
                    $this->saveLogAktivitasTerpadu('DELETE: PTK (500-'.$ptk_id.')');
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Gagal menghapus data PTK.');
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                $this->saveLogAktivitasTerpadu('DELETE: PTK ('.$ptk_id.')-'.$e->getMessage());
                Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error', 'Maaf akses anda ditolak. Terima kasih.');
            return $this->redirect(['index']);
        }
    }
    
    private function generateUuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}
