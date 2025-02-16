<?php

namespace app\components;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class BaseController extends Controller
{
    
    public function beforeAction($action)
    {
        $kode_akses = Yii::$app->session->get('kode_akses');
        if (Yii::$app->session->get('id_akun') === null OR !in_array($kode_akses, [0, 2, 3])) {
            Yii::$app->session->removeAll();
            return $this->redirect(['/login'])->send();
        }
        return parent::beforeAction($action);
    }
}
