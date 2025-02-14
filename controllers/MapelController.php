<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\MataPelajaran;
use Yii;

class MapelController extends BaseController
{
    public function actionIndex()
    {
        $queryMapel = (new \yii\db\Query())->select([
            'mata_pelajaran.*'
        ])->from('mata_pelajaran');
        $data = $queryMapel->all();

        return $this->render('index', [
            'data' => $data
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

    public function actionUpdate($id)
    {
        $model = MataPelajaran::findOne($id);
        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('Data tidak ditemukan.');
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data berhasil diperbarui.');
            return $this->redirect(['index']); // Redirect ke halaman daftar mata pelajaran
        }
        return $this->render('edit', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $mapel = MataPelajaran::findOne($id);
        if ($mapel === null) {
            throw new \yii\web\NotFoundHttpException('Data tidak ditemukan.');
        }
        if (Yii::$app->request->isPost) {
            $mapel->delete();
            Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');
            return $this->redirect(['index']);
        }
        throw new \yii\web\BadRequestHttpException('Invalid Request.');
    }
}
