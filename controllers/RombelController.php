<?php

namespace app\controllers;

use Yii;
use app\models\Rombel;
use yii\web\Controller;
use app\components\BaseController;
use yii\web\ForbiddenHttpException;

class RombelController extends BaseController
{   

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['insert','index'], //kedua action wajib login terlebih dahulu
                'rules' => [
                    [
                        'allow' => false,
                        // 'actions' => ['insert','index'], // daftar action yang harus memenuhi syarat
                        'actions' => ['insert'],
                        'matchCallback' => function ($rule, $action) { // aturannya
                            $kodeAkses = Yii::$app->session->get('kode_akses');
                            if ($kodeAkses != 3) { // jika bukan operator sekolah tidak bisa menginput data
                                throw new ForbiddenHttpException('Anda tidak diizinkan mengakses halaman ini.');
                            }
                            return false;
                        },
                    ],
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->session->has('id_akun');
                        },
                    ],
                ],
            ],
        ];
    }
    

    public function actionIndex()
    {
        $rombongan_belajar_id = Yii::$app->request->get('id', ''); // Default value jika tidak ada 'rombongan_belajar'
        $rombongan_belajar_id = \yii\helpers\Html::encode($rombongan_belajar_id); // Mencegah XSS
    
        $query = (new \yii\db\Query())
            ->select([
                'rombongan_belajar.*',
                'sekolah.npsn',
                'sekolah.nama AS nama_sekolah',
                'sekolah.bentuk_pendidikan',
                'sekolah.status_sekolah',
                'sekolah.kecamatan',
                'ptk.nama AS nama_ptk',
                'mata_pelajaran.mata_pelajaran',
            ])
            ->from('rombongan_belajar')
            ->leftJoin('sekolah', 'sekolah.npsn = rombongan_belajar.sekolah_id')
            ->leftJoin('ptk', 'ptk.ptk_id = rombongan_belajar.ptk_id')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.id = rombongan_belajar.mata_pelajaran_id');
    
        if (empty($rombongan_belajar_id)) {
            if (!empty(Yii::$app->request->get('bentuk_pendidikan'))) {
                $query->andWhere(['sekolah.bentuk_pendidikan' => Yii::$app->request->get('bentuk_pendidikan')]);
            }
            if (!empty(Yii::$app->request->get('kecamatan'))) {
                $query->andWhere(['sekolah.kecamatan' => Yii::$app->request->get('kecamatan')]);
            }
            if(Yii::$app->session->get('kode_akses')==3){
                $query->andWhere(['sekolah.npsn' => Yii::$app->session->get('id_sekolah')]);
            }
            $data = $query->all();
            return $this->render('index', ['data' => $data]);
        } else {
            $query->andWhere(['rombongan_belajar.rombongan_belajar_id' => $rombongan_belajar_id]);
    
            $data = $query->one(); // Menggunakan `one()` karena detail seharusnya hanya satu data
    
            return $this->render('detail', ['data' => $data]);
        }
        return $this->render('index');
    }

    public function actionInsert()
    {
        $model = new Rombel();
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('Rombel');
            var_dump($postData);
            return $this->importManual($postData);
        } else {
            return $this->render('insert', ['model' => $model]);
        }
    }

    protected function importManual($postData)
    {
        if (
            isset($postData['ptk']) && Rombel::find()->where(['ptk_id' => $postData['ptk']])->exists()
        ) {
            Yii::$app->session->setFlash('error', 'Rombel sudah pernah ada.');
            return $this->redirect(['insert']);
        }
        try {
            $inserted = Yii::$app->db->createCommand()->insert('rombongan_belajar', [
                'rombongan_belajar_id' => $this->generateUuid(),
                'sekolah_id' => Yii::$app->session->get('id_sekolah'),
                'ptk_id' => $postData['ptk'],
                'tingkat_pendidikan' => $postData['tingkat_pendidikan'],
                'nama' => $postData['nama_rombel'],
                'jumlah_pembelajaran' => $postData['jumlah_pembelajaran'],
                'jumlah_anggota_rombel' => $postData['jumlah_anggota_rombel'],
                'mata_pelajaran_id' => $postData['mata_pelajaran'],
                'semester' => $postData['semester'],
                'createdAt' => time(),
                'updatedAt' => time(),
            ])->execute();
        
            if ($inserted) {
                Yii::$app->session->setFlash('success', 'Data berhasil ditambahkan.');
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
