<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{

    public function actionIndex()
    {
        $session = Yii::$app->session;
        $kode_akses = $session->get('kode_akses');
    
        if (!in_array($kode_akses, [0, 1, 3])) {
            $this->layout = 'login'; // Gunakan layout khusus login
            return $this->redirect(getenv('BASE_URL') . 'login');
        }
    
        return $this->redirect(['/beranda']); // Jika sudah login dan kode akses valid, ke dashboard
    }
    
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'error',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}
