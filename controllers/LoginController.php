<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\Session;

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
        $session = Yii::$app->session;
        $idAkun = $session->get('id_akun');
        $token = $session->get('token');
        Session::deleteAll(['id_akun' => $idAkun, 'token' => $token]);
        $session->removeAll();
        return $this->redirect(['/']);
    }
}
