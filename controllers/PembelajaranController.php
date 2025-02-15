<?php

namespace app\controllers;

use Yii;
use app\models\Pembelajaran;
use app\components\BaseController;

class PembelajaranController extends BaseController
{
    public function actionIndex()
    {
        $pembelajaran_id = Yii::$app->request->get('id', ''); // Default value jika tidak ada 'rombongan_belajar'
        $pembelajaran_id = \yii\helpers\Html::encode($pembelajaran_id); // Mencegah XSS
        try {
            $query = (new \yii\db\Query())
                ->select([
                    'pembelajaran.*',
                    'sekolah.npsn',
                    'sekolah.nama AS nama_sekolah',
                    'sekolah.bentuk_pendidikan',
                    'sekolah.status_sekolah',
                    'sekolah.kecamatan',
                    'ptk.nama AS nama_ptk',
                    'mata_pelajaran.mata_pelajaran',
                    'rombongan_belajar.nama AS nama_rombel',
                    'rombongan_belajar.jumlah_anggota_rombel',
                    'rombongan_belajar.tingkat_pendidikan',
                ])
                ->from('pembelajaran')
                ->leftJoin('sekolah', 'sekolah.npsn = pembelajaran.sekolah_id')
                ->leftJoin('ptk', 'ptk.ptk_id = pembelajaran.ptk_id')
                ->leftJoin('mata_pelajaran', 'mata_pelajaran.id = pembelajaran.mata_pelajaran_id')
                ->leftJoin('rombongan_belajar', 'rombongan_belajar.rombongan_belajar_id = pembelajaran.rombongan_belajar_id');
    
                if(Yii::$app->session->get('kode_akses')==3){
                    $query->andWhere(['sekolah.npsn' => Yii::$app->session->get('id_sekolah')]);
                }
                if (!empty(Yii::$app->request->get('bentuk_pendidikan'))) {
                    $query->andWhere(['sekolah.bentuk_pendidikan' => Yii::$app->request->get('bentuk_pendidikan')]);
                }
                if (!empty(Yii::$app->request->get('kecamatan'))) {
                    $query->andWhere(['sekolah.kecamatan' => Yii::$app->request->get('kecamatan')]);
                }
            $data = $query->all();
            return $this->render('index', ['data' => $data]);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return $this->redirect(['index']);
        }
    }

    public function actionInsert()
    {
        $model = new Pembelajaran();
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('Pembelajaran');
            var_dump($postData);
            return $this->importManual($postData);
        } else {
            return $this->render('insert', ['model' => $model]);
        }
    }

    public function actionDelete()
    {
        $pembelajaran_id = Yii::$app->request->get('id', ''); // Ambil ID dari GET request
        $pembelajaran_id = \yii\helpers\Html::encode($pembelajaran_id); // Mencegah XSS
    
        // Cek validitas pembelajaran_id dan hak akses
        if (empty($pembelajaran_id) || Yii::$app->session->get('kode_akses') != 3) {
            Yii::$app->session->setFlash('error', 'Maaf terjadi kesalahan saat meminta data. Silahkan coba kembali atau hubungi admin Aldrin Terpadu. Terima kasih.');
            return $this->redirect(['index']);
        }
    
        // Cek apakah data pembelajaran ada
        $pembelajaran = Pembelajaran::findOne($pembelajaran_id);
        if (!$pembelajaran) {
            Yii::$app->session->setFlash('error', 'Data pembelajaran tidak ditemukan.');
            return $this->redirect(['index']);
        }
    
        // Gunakan transaksi untuk keamanan
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($pembelajaran->delete() !== false) {
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Data pembelajaran berhasil dihapus.');
            } else {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Gagal menghapus data pembelajaran.');
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    
        return $this->redirect(['index']);
    }

    protected function importManual($postData)
    {
        if (
            isset($postData['ptk']) && Pembelajaran::find()->where(['ptk_id' => $postData['ptk']])->andWhere(['rombongan_belajar_id'=>$postData['rombongan_belajar_id']])->exists()
        ) {
            Yii::$app->session->setFlash('error', 'Data pembelajaran untuk PTK dan Rombel ini sudah ada.');
            return $this->redirect(['insert']);
        }

        $query = (new \yii\db\Query())
            ->select([
                'rombongan_belajar.*',
                'mata_pelajaran.mata_pelajaran',
            ])
            ->from('rombongan_belajar')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.id = rombongan_belajar.mata_pelajaran_id')
            ->andWhere(['rombongan_belajar.rombongan_belajar_id'=>$postData['rombongan_belajar_id']]);
            $data = $query->one();

        try {
            $model = new Pembelajaran();
            $model->pembelajaran_id = $this->generateUuid();
            $model->sekolah_id = Yii::$app->session->get('id_sekolah');
            $model->rombongan_belajar_id = $postData['rombongan_belajar_id'];
            $model->ptk_id = $postData['ptk_id'];
            $model->sk_mengajar = $postData['sk_mengajar'] ?? null;
            $model->tanggal_sk_mengajar = $postData['tanggal_sk_mengajar'] ?? null;
            $model->jam_mengajar_per_minggu = $postData['jam_mengajar_per_minggu'];

            $model->mata_pelajaran_id = $data['mata_pelajaran_id'] ?? null;
            $model->semester = $data['semester'] ?? null;
            $model->created_at = time();
            $model->updated_at = time();
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Data pembelajaran berhasil ditambahkan.');
            } else {
                Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat menyimpan data.');
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
