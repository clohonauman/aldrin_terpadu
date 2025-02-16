<?php

namespace app\controllers;
use app\components\BaseController;

class Manajemen_penggunaController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
