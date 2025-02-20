<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\Siswa;
use app\models\UploadForm;
use moonland\phpexcel\Excel;
use app\components\BaseController;

class SiswaController extends BaseController
{
    public function actionIndex()
    {
        $siswa_id = Yii::$app->request->get('id', '');
        $siswa_id = \yii\helpers\Html::encode($siswa_id);
    
        $query = (new \yii\db\Query())
            ->select([
                'siswa.*',
                'sekolah.npsn',
                'sekolah.nama AS nama_sekolah',
                'sekolah.bentuk_pendidikan',
                'sekolah.status_sekolah',
                'sekolah.kecamatan',
                'TIMESTAMPDIFF(YEAR, siswa.tanggal_lahir, CURDATE()) AS usia_sekarang',
                'siswa.status',
            ])
            ->from('siswa')
            ->leftJoin('sekolah', 'sekolah.npsn = siswa.sekolah_id');
    
        if (empty($siswa_id)) {
            if (!empty(Yii::$app->request->get('bentuk_pendidikan'))) {
                $query->andWhere(['sekolah.bentuk_pendidikan' => Yii::$app->request->get('bentuk_pendidikan')]);
            }
            if (!empty(Yii::$app->request->get('kecamatan'))) {
                $query->andWhere(['sekolah.kecamatan' => Yii::$app->request->get('kecamatan')]);
            }
            if (!empty(Yii::$app->request->get('jenis_kelamin'))) {
                $query->andWhere(['siswa.jenis_kelamin' => Yii::$app->request->get('jenis_kelamin')]);
            }
            if (!empty(Yii::$app->request->get('status'))) {
                $query->andWhere(['siswa.status' => Yii::$app->request->get('status')]);
            }
            if (!empty(Yii::$app->request->get('usia'))) {
                $usia = (int) Yii::$app->request->get('usia');
                $tahun_sekarang = date('Y');
                $tahun_lahir_maks = $tahun_sekarang - $usia; // Tahun lahir maksimal untuk usia > 23
            
                $query->andWhere(['<', 'YEAR(siswa.tanggal_lahir)', $tahun_lahir_maks]);
            }            

            if (Yii::$app->session->get('kode_akses')==3) {
                $query->andWhere(['sekolah.npsn' => Yii::$app->session->get('id_sekolah')]);
            }
    
            $data = $query->all();
            $this->saveLogAktivitasTerpadu('GET: Siswa');
            return $this->render('index', ['data' => $data]);
        } else {
            $query->andWhere(['siswa.siswa_id' => $siswa_id]);
            if (Yii::$app->session->get('kode_akses')==3) {
                $query->andWhere(['sekolah.npsn' => Yii::$app->session->get('id_sekolah')]);
            }
            $data = $query->one();
    
            $this->saveLogAktivitasTerpadu('GET: PTK ('.$siswa_id.')');
            return $this->render('detail', ['data' => $data]);
        }
    }

    public function actionUpload()
    {
        if(Yii::$app->session->get('kode_akses')==3){
            $model = new UploadForm();
            if (Yii::$app->request->isPost) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->file) {
                    return $this->importExcel($model->file->tempName);
                }
            } else {
                return $this->render('upload', ['model' => $model]);
            }
        }else{
            Yii::$app->session->setFlash('error', 'Maaf hanya operator sekolah yang dapat menambahkan data Siswa. Terima kasih.');
            return $this->redirect(['index']);
        }
        
    }

    public function actionInsert()
    {
        if(Yii::$app->session->get('kode_akses')==3){
            $model = new Siswa();
            if (Yii::$app->request->isPost) {
                $postData = Yii::$app->request->post('Siswa');
                return $this->importManual($postData);
            } else {
                return $this->render('insert', ['model' => $model]);
            }
        }else{
            Yii::$app->session->setFlash('error', 'Maaf hanya operator sekolah yang dapat menambahkan data Siswa. Terima kasih.');
            return $this->redirect(['index']);
        }
    }

    public function actionEdit()
    {
        if(Yii::$app->session->get('kode_akses')==3){
            $siswa_id = Yii::$app->request->get('id', ''); 
            $siswa_id = \yii\helpers\Html::encode($siswa_id);
            if (Yii::$app->request->isPost) {
                $postData = Yii::$app->request->post('Siswa');
                return $this->updatedManual($postData,$siswa_id);
            } else {
                if (empty($siswa_id) OR Yii::$app->session->get('kode_akses')!=3) {
                    Yii::$app->session->setFlash('error', 'Maaf terjadi kesalahan saat meminta data. Silahkan coba kembali atau hubungi admin Aldrin Terpadu. Terima kasih.');
                    return $this->redirect(['index']);
                } else {
                    $model=new Siswa;
                    $query = (new \yii\db\Query())
                        ->select([
                            'siswa.*',
                            'sekolah.npsn',
                            'sekolah.nama AS nama_sekolah',
                            'sekolah.bentuk_pendidikan',
                            'sekolah.status_sekolah',
                            'sekolah.kecamatan',
                            'TIMESTAMPDIFF(YEAR, siswa.tanggal_lahir, CURDATE()) AS usia_sekarang'
                        ])
                        ->from('siswa')
                        ->leftJoin('sekolah', 'sekolah.npsn = siswa.sekolah_id');
                    $query->andWhere(['siswa.siswa_id' => $siswa_id]);
                    $query->andWhere(['sekolah.npsn' => Yii::$app->session->get('id_sekolah')]);
                    $data = $query->one();
                    return $this->render('edit', [
                                                    'data' => $data,
                                                    'model' => $model
                                                ]);
                }
            }
        }else{
            Yii::$app->session->setFlash('error', 'Maaf hanya operator sekolah yang dapat menambahkan data Siswa. Terima kasih.');
            return $this->redirect(['index']);
        }
    }

    protected function importManual($postData)
    {
        if (isset($postData['nisn']) && Siswa::find()->where(['nisn' => $postData['nisn']])->andWhere(['IN', 'status', [1, 2, 3, 4]])->exists()) {
            Yii::$app->session->setFlash('error', 'NISN sudah terdaftar.');
            return $this->redirect(['insert']);
        }
    
        $siswa = new Siswa();
        $siswa_id = $this->generateUuid();
        $siswa->siswa_id = $siswa_id;
        $siswa->sekolah_id = Yii::$app->session->get('id_sekolah');
        $siswa->tingkat_pendidikan = $postData['tingkat_pendidikan'];
        $siswa->nisn = $postData['nisn'];
        $siswa->nik = $postData['nik'] ?? null;
        $siswa->no_kk = $postData['no_kk'];
        $siswa->nama = $postData['nama'];
        $siswa->desa_kelurahan = $postData['desa_kelurahan'] ?? null;
        $siswa->kecamatan = $postData['kecamatan'] ?? null;
        $siswa->kabupaten = $postData['kabupaten'] ?? null;
        $siswa->provinsi = $postData['provinsi'] ?? null;
        $siswa->nama_ibu_kandung = $postData['nama_ibu_kandung'];
        $siswa->tempat_lahir = $postData['tempat_lahir'] ?? null;
        $siswa->tanggal_lahir = $postData['tanggal_lahir'];
        $siswa->jenis_kelamin = $postData['jenis_kelamin'];
        $siswa->created_at = time();
        $siswa->updated_at = time();
        $siswa->status = $postData['status'];
    
        if ($siswa->save(false)) {
            $this->saveLogAktivitasTerpadu('POST: Siswa ('.$siswa_id.')');
            Yii::$app->session->setFlash('success', 'Data berhasil ditambahkan secara manual.');
            return $this->redirect(['index']);
        } else {
            $this->saveLogAktivitasTerpadu('POST: Siswa (500-'.$siswa_id.')');
            Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat menyimpan data.');
            return $this->redirect(['insert']);
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
            if (
                empty(trim($row['NISN'])) || $row['NISN'] === 'null' || is_null($row['NISN']) ||// Cek jika NISN kosong setelah di-trim
                Siswa::find()->where(['nisn' => $row['NISN']])
                    ->andWhere(['IN', 'status', [1, 2, 3, 4]])
                    ->exists()
            ) {
                $totalSkip++;
                $totalData++;
                continue;
            }            
            $totalData++;

            $siswa = new Siswa();
            $siswa->siswa_id = $this->generateUuid();
            $siswa->sekolah_id = Yii::$app->session->get('id_sekolah');
            $siswa->nama = $row['Nama Lengkap'] ?? null;
            $siswa->jenis_kelamin = $row['L/P'] ?? null;
            $siswa->tanggal_lahir = isset($row['Tanggal Lahir']) ? date('Y-m-d', strtotime($row['Tanggal Lahir'])) : null;
            $siswa->nama_ibu_kandung = $row['Nama Ibu Kandung'] ?? null;
            $siswa->nik = $row['NIK'] ?? null;
            $siswa->nisn = $row['NISN'] ?? null;
            $siswa->tingkat_pendidikan = $row['Tingkat'];
            $siswa->status = 1; //aktif
            $siswa->created_at = time();
            $siswa->updated_at = time();

            $siswa->save(false);
        }
        $totalSuccess=$totalData-$totalSkip;
        if($totalSkip>0){
            $this->saveLogAktivitasTerpadu('POST: Siswa using Excel File');
            Yii::$app->session->setFlash('danger', 'Total Data: '.$totalData.'<br>Berhasil: '.$totalSuccess.'<br>Gagal: '.$totalSkip.' karena NISN sudah terdaftar/NISN kosong.');
        }else{
            $this->saveLogAktivitasTerpadu('POST: Siswa using Excel File');
            Yii::$app->session->setFlash('success', 'Total Data: '.$totalData.'<br>Berhasil: '.$totalSuccess);
        }
        return $this->redirect(['index']);
    }

    protected function updatedManual($postData, $siswa_id)
    {
        if (isset($postData['nisn']) && Siswa::find()->where(['nisn' => $postData['nisn']])->andWhere(['!=', 'siswa_id', $siswa_id])->exists()) {
            Yii::$app->session->setFlash('error', 'NISN sudah terdaftar dan bukan milik siswa tersebut.');
            return $this->redirect(['siswa']);
        }
    
        $siswa = Siswa::findOne($siswa_id);
        if (!$siswa) {
            Yii::$app->session->setFlash('error', 'Data Siswa tidak ditemukan.');
            return $this->redirect(['index']);
        }
        $siswa->tingkat_pendidikan = $postData['tingkat_pendidikan'] ?? $siswa->tingkat_pendidikan;
        $siswa->nisn = $postData['nisn'] ?? $siswa->nisn;
        $siswa->nik = $postData['nik'] ?? $siswa->nik;
        $siswa->no_kk = $postData['no_kk'] ?? $siswa->no_kk;
        $siswa->nama = $postData['nama'] ?? $siswa->nama;
        $siswa->desa_kelurahan = $postData['desa_kelurahan'] ?? $siswa->desa_kelurahan;
        $siswa->kecamatan = $postData['kecamatan'] ?? $siswa->kecamatan;
        $siswa->kabupaten = $postData['kabupaten'] ?? $siswa->kabupaten;
        $siswa->provinsi = $postData['provinsi'] ?? $siswa->provinsi;
        $siswa->nama_ibu_kandung = $postData['nama_ibu_kandung'] ?? $siswa->nama_ibu_kandung;
        $siswa->tempat_lahir = $postData['tempat_lahir'] ?? $siswa->tempat_lahir;
        $siswa->tanggal_lahir = $postData['tanggal_lahir'] ?? $siswa->tanggal_lahir;
        $siswa->jenis_kelamin = $postData['jenis_kelamin'] ?? $siswa->jenis_kelamin;
        $siswa->updated_at = time();
        $siswa->status = $postData['status'] ?? $siswa->status;
    
        if ($siswa->save()) {
            $this->saveLogAktivitasTerpadu('PATCH: Siswa ('.$siswa_id.')');
            Yii::$app->session->setFlash('success', 'Data berhasil diperbarui.');
        } else {
            $this->saveLogAktivitasTerpadu('PATCH: Siswa (500-'.$siswa_id.')');
            Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat menyimpan data.');
        }
        
        return $this->redirect(['index']);
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
