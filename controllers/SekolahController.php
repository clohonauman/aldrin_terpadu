<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Sekolah;
use app\components\BaseController;

class SekolahController extends BaseController
{
    public function actionIndex()
    {
        $npsn = Yii::$app->request->get('id', ''); // Default value jika tidak ada 'ptk'
        $npsn = \yii\helpers\Html::encode($npsn); // Mencegah XSS
    
        $query = (new \yii\db\Query())
                    ->select(['sekolah.*'])
                    ->from('sekolah')
                    ->orderby('nama', 'asc')
                    ->andWhere(['or', ['!=', 'data_status', 2], ['is', 'data_status', null], ['=', 'data_status', 1]]);    
    
        if (Yii::$app->session->get('kode_akses')==3) {
            $query->andWhere(['sekolah.npsn' => Yii::$app->session->get('id_sekolah')]);
        }
        if (empty($npsn)) {
            if (!empty(Yii::$app->request->get('bentuk_pendidikan'))) {
                $query->andWhere(['sekolah.bentuk_pendidikan' => Yii::$app->request->get('bentuk_pendidikan')]);
            }
            if (!empty(Yii::$app->request->get('kecamatan'))) {
                $query->andWhere(['sekolah.kecamatan' => Yii::$app->request->get('kecamatan')]);
            }
            if (!empty(Yii::$app->request->get('status'))) {
                $query->andWhere(['sekolah.status_sekolah' => Yii::$app->request->get('status')]);
            }
    
            $data = $query->all();
            $this->saveLogAktivitasTerpadu('GET: Sekolah');
            return $this->render('index', ['data' => $data]);
        } else {
            $query->andWhere(['sekolah.npsn' => $npsn]);
    
            $data = $query->one();
            if(!empty($data)){
                $this->saveLogAktivitasTerpadu('GET: Sekolah ('.$npsn.')');
                return $this->render('detail', ['data' => $data]);
            }else{
                $this->saveLogAktivitasTerpadu('GET: Sekolah (404-'.$npsn.')');
                Yii::$app->session->setFlash('error', 'Maaf data tidak ditemukan. Terima kasih.');
                return $this->redirect(['index']);
            }
        }
    }

    public function actionEdit()
    {
        if (Yii::$app->session->get('kode_akses')==3) {
            Yii::$app->session->setFlash('error', 'Maaf terjadi kesalahan saat meminta data. Silahkan coba kembali atau hubungi admin Aldrin Terpadu. Terima kasih.');
            return $this->redirect(['index']);
        }
        $npsn = Yii::$app->request->get('id', ''); // Default value jika tidak ada 'ptk'
        $npsn = \yii\helpers\Html::encode($npsn); // Mencegah XSS
    
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('Sekolah');
            return $this->updatedManual($postData,$npsn);
        } else {
            $query = (new \yii\db\Query())
                ->select([
                    'sekolah.*'
                ])
                ->from('sekolah')
                ->orderby('nama', 'asc');
        
            if (empty($npsn)) {
                Yii::$app->session->setFlash('error', 'Maaf sekolah belum dipili. Terima kasih.');
                return $this->redirect(['index']);
            } else {
                $model=new Sekolah;
    
                $query->andWhere(['sekolah.npsn' => $npsn]);
                $data = $query->one();

                if(!empty($data['sekolah_id'])){
                    return $this->render('edit', [
                        'model' => $model,
                        'data' => $data,
                    ]);
                }else{
                    Yii::$app->session->setFlash('error', 'Maaf data tidak ditemukan. Terima kasih.');
                    return $this->redirect(['index']);
                }
            }
        }
    }

    public function actionInsert()
    {
        $model=new Sekolah;

        if (Yii::$app->session->get('kode_akses')==3) {
            Yii::$app->session->setFlash('error', 'Maaf terjadi kesalahan saat meminta data. Silahkan coba kembali atau hubungi admin Aldrin Terpadu. Terima kasih.');
            return $this->redirect(['index']);
        }
    
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('Sekolah');
            return $this->importManual($postData);
        } else {
            return $this->render('insert', [
                'model' => $model,
            ]);
        }
    }

    protected function updatedManual($postData, $npsn)
    {
        $sekolah = Sekolah::findOne(['npsn' => $npsn]);
        if (!$sekolah) {
            Yii::$app->session->setFlash('error', 'Maaf data tidak ditemukan. Terima kasih.');
            return $this->redirect(['index']);
        }
        $sekolah->nama = $postData['nama'] ?? $sekolah->nama;
        $sekolah->bentuk_pendidikan = $postData['bentuk_pendidikan'] ?? $sekolah->bentuk_pendidikan;
        $sekolah->status_sekolah = $postData['status_sekolah'] ?? $sekolah->status_sekolah;
        $sekolah->lintang = $postData['lintang'] ?? $sekolah->lintang;
        $sekolah->bujur = $postData['bujur'] ?? $sekolah->bujur;
        $sekolah->alamat_jalan = $postData['alamat_jalan'] ?? $sekolah->alamat_jalan;
        $sekolah->kecamatan = $postData['kecamatan'] ?? $sekolah->kecamatan;
        $sekolah->desa_kelurahan = $postData['desa_kelurahan'] ?? $sekolah->desa_kelurahan;
        $sekolah->kabupaten = $postData['kabupaten'] ?? $sekolah->kabupaten;
        $sekolah->provinsi = $postData['provinsi'] ?? $sekolah->provinsi;
        $sekolah->kode_pos = $postData['kode_pos'] ?? $sekolah->kode_pos;
        $sekolah->nomor_telepon = $postData['nomor_telepon'] ?? $sekolah->nomor_telepon;
        $sekolah->email = $postData['email'] ?? $sekolah->email;
        $sekolah->website = $postData['website'] ?? $sekolah->website;
        $sekolah->akreditasi = $postData['akreditasi'] ?? $sekolah->akreditasi;
        $sekolah->sk_pendirian_sekolah = $postData['sk_pendirian_sekolah'] ?? $sekolah->sk_pendirian_sekolah;
        $sekolah->tanggal_sk_pendirian = $postData['tanggal_sk_pendirian'] ?? $sekolah->tanggal_sk_pendirian;
        $sekolah->status_kepemilikan = $postData['status_kepemilikan'] ?? $sekolah->status_kepemilikan;
        $sekolah->yayasan = $postData['yayasan'] ?? $sekolah->yayasan;
        $sekolah->sk_izin_operasional = $postData['sk_izin_operasional'] ?? $sekolah->sk_izin_operasional;
        $sekolah->tanggal_sk_izin_operasional = $postData['tanggal_sk_izin_operasional'] ?? $sekolah->tanggal_sk_izin_operasional;
        $sekolah->no_rekening = $postData['no_rekening'] ?? $sekolah->no_rekening;
        $sekolah->rekening_atas_nama = $postData['rekening_atas_nama'] ?? $sekolah->rekening_atas_nama;
        $sekolah->nama_bank = $postData['nama_bank'] ?? $sekolah->nama_bank;
        $sekolah->cabang_kcp_unit = $postData['cabang_kcp_unit'] ?? $sekolah->cabang_kcp_unit;
        $sekolah->data_status = $postData['data_status'] ?? $sekolah->cabang_kcp_unit;
    
        if ($sekolah->save(false)) {
            $this->saveLogAktivitasTerpadu('PATCH: Sekolah ('. $npsn.')');
            Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
        } else {
            $this->saveLogAktivitasTerpadu('PATCH: Sekolah (500-'. $npsn.')');
            Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    
        return $this->redirect(['index']);
    }    

    protected function importManual($postData)
    {
        $sekolah = Sekolah::findOne(['npsn' => $postData['npsn']]);
        if ($sekolah) {
            Yii::$app->session->setFlash('error', 'Maaf NPSN sudah pernah terdaftar. Terima kasih.');
            return $this->redirect(['index']);
        }
        $sekolah = new Sekolah();
        $sekolah->sekolah_id = $this->generateUuid();
        $sekolah->npsn = $postData['npsn'] ?? null;
        $sekolah->nama = $postData['nama'] ?? null;
        $sekolah->bentuk_pendidikan = $postData['bentuk_pendidikan'] ?? null;
        $sekolah->status_sekolah = $postData['status_sekolah'] ?? null;
        $sekolah->lintang = $postData['lintang'] ?? null;
        $sekolah->bujur = $postData['bujur'] ?? null;
        $sekolah->alamat_jalan = $postData['alamat_jalan'] ?? null;
        $sekolah->kecamatan = $postData['kecamatan'] ?? null;
        $sekolah->desa_kelurahan = $postData['desa_kelurahan'] ?? null;
        $sekolah->kabupaten = $postData['kabupaten'] ?? null;
        $sekolah->provinsi = $postData['provinsi'] ?? null;
        $sekolah->kode_pos = $postData['kode_pos'] ?? null;
        $sekolah->nomor_telepon = $postData['nomor_telepon'] ?? null;
        $sekolah->email = $postData['email'] ?? null;
        $sekolah->website = $postData['website'] ?? null;
        $sekolah->akreditasi = $postData['akreditasi'] ?? null;
        $sekolah->sk_pendirian_sekolah = $postData['sk_pendirian_sekolah'] ?? null;
        $sekolah->tanggal_sk_pendirian = $postData['tanggal_sk_pendirian'] ?? null;
        $sekolah->status_kepemilikan = $postData['status_kepemilikan'] ?? null;
        $sekolah->yayasan = $postData['yayasan'] ?? null;
        $sekolah->sk_izin_operasional = $postData['sk_izin_operasional'] ?? null;
        $sekolah->tanggal_sk_izin_operasional = $postData['tanggal_sk_izin_operasional'] ?? null;
        $sekolah->no_rekening = $postData['no_rekening'] ?? null;
        $sekolah->rekening_atas_nama = $postData['rekening_atas_nama'] ?? null;
        $sekolah->nama_bank = $postData['nama_bank'] ?? null;
        $sekolah->cabang_kcp_unit = $postData['cabang_kcp_unit'] ?? null;
        $sekolah->data_status = $postData['data_status'] ?? 0;
        $sekolah->createdAt = date('Y-m-d H:i:s');
        $sekolah->updatedAt = date('Y-m-d H:i:s');
    
        if ($sekolah->save(false)) {
            $this->saveLogAktivitasTerpadu('POST: Sekolah ('. $npsn.')');
            Yii::$app->session->setFlash('success', 'Data berhasil disimpan.');
        } else {
            $this->saveLogAktivitasTerpadu('POST: Sekolah (500-'. $npsn.')');
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
