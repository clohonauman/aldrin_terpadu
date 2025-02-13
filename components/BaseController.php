<?php

namespace app\components;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class BaseController extends Controller
{
    
    public function beforeAction($action)
    {
        if (Yii::$app->session->get('id_akun') === null) {
            return $this->redirect(['/login'])->send();
        }
        return parent::beforeAction($action);
    }
}
