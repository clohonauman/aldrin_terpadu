<?php

namespace app\controllers;
use app\components\BaseController;

class BerandaController extends BaseController
{
    
    public function actionIndex()
    {
        return $this->render('index');
    }

}
