<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\UploadForm;
use app\models\Ptk;
use moonland\phpexcel\Excel;
use app\components\BaseController;

class SekolahController extends BaseController
{
    public function actionIndex()
    {
        $npsn = Yii::$app->request->get('id', ''); // Default value jika tidak ada 'ptk'
        $npsn = \yii\helpers\Html::encode($npsn); // Mencegah XSS
    
        $query = (new \yii\db\Query())
            ->select([
                'sekolah.*'
            ])
            ->from('sekolah')
            ->orderby('nama', 'asc');
    
        if (empty($npsn)) {
            // Filter berdasarkan bentuk_pendidikan
            if (!empty(Yii::$app->request->get('bentuk_pendidikan'))) {
                $query->andWhere(['sekolah.bentuk_pendidikan' => Yii::$app->request->get('bentuk_pendidikan')]);
            }
    
            // Filter berdasarkan kecamatan
            if (!empty(Yii::$app->request->get('kecamatan'))) {
                $query->andWhere(['sekolah.kecamatan' => Yii::$app->request->get('kecamatan')]);
            }
    
            // Filter berdasarkan status sekolah
            if (!empty(Yii::$app->request->get('status'))) {
                $query->andWhere(['sekolah.status_sekolah' => Yii::$app->request->get('status')]);
            }
    
            $data = $query->all();
            return $this->render('index', ['data' => $data]);
        } else {
            // Filter berdasarkan npsn
            $query->andWhere(['sekolah.npsn' => $npsn]);
    
            $data = $query->one(); // Menggunakan `one()` karena detail seharusnya hanya satu data
    
            return $this->render('detail', ['data' => $data]);
        }
    }

}
