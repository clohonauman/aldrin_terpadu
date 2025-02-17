<?php

namespace app\controllers;
use app\components\BaseController;

class BerandaController extends BaseController
{
    
    public function actionIndex()
    {
        $this->saveLogAktivitasTerpadu('GET: Beranda');
        return $this->render('index');
    }

}
