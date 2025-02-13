<?php

namespace app\controllers;

use Yii;
use app\models\Rombel;
use yii\web\Controller;

class RombelController extends \yii\web\Controller
{
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
            ])
            ->from('rombongan_belajar')
            ->leftJoin('sekolah', 'sekolah.npsn = rombongan_belajar.sekolah_id');
    
        if (empty($rombongan_belajar_id)) {
            if (!empty(Yii::$app->request->get('bentuk_pendidikan'))) {
                $query->andWhere(['sekolah.bentuk_pendidikan' => Yii::$app->request->get('bentuk_pendidikan')]);
            }
            if (!empty(Yii::$app->request->get('kecamatan'))) {
                $query->andWhere(['sekolah.kecamatan' => Yii::$app->request->get('kecamatan')]);
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
            // return $this->importManual($postData);
        } else {
            return $this->render('insert', ['model' => $model]);
        }
    }

}
