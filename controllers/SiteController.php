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
        $id_akun = $session->get('id_akun');
    
        if (empty($id_akun)) {
            return $this->redirect(getenv('BASE_URL') . 'index');
        }else{
            return $this->redirect(['/beranda']);
        }
    
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
