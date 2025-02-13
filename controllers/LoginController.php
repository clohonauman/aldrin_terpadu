<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;

class LoginController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->session->get('id_akun')) {
            return $this->redirect(['/beranda']);
        }

        $this->layout = 'login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/beranda']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }
    public function actionLogout()
    {
        Yii::$app->session->removeAll(); // Hapus semua session yang tersimpan
        return $this->redirect(['/']); // Redirect ke halaman utama
    }
    
}
