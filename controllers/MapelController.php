<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\MataPelajaran;
use app\models\MataPelajaranSearch;
use Yii;

class MapelController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new MataPelajaranSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
    public function actionCreate()
    {
        $model = new MataPelajaran();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Mata Pelajaran berhasil disimpan!');
            return $this->redirect(['index']); // Redirect ke halaman daftar mata pelajaran
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }
}
