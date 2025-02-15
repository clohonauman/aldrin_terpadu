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
        if (empty($pembelajaran_id)) {
            if (!empty(Yii::$app->request->get('bentuk_pendidikan'))) {
                $query->andWhere(['sekolah.bentuk_pendidikan' => Yii::$app->request->get('bentuk_pendidikan')]);
            }
            if (!empty(Yii::$app->request->get('kecamatan'))) {
                $query->andWhere(['sekolah.kecamatan' => Yii::$app->request->get('kecamatan')]);
            }
            $data = $query->all();
            return $this->render('index', ['data' => $data]);
        } else {
            $query->andWhere(['rombongan_belajar.pembelajaran_id' => $pembelajaran_id]);
    
            $data = $query->one(); // Menggunakan `one()` karena detail seharusnya hanya satu data
    
            return $this->render('detail', ['data' => $data]);
        }
        return $this->render('index');
    }

}
