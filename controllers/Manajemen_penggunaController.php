<?php

namespace app\controllers;
use app\components\BaseController;

class Manajemen_penggunaController extends BaseController
{
    public function actionIndex()
    {
        $this->saveLogAktivitasTerpadu('GET: Manajemen Pengguna');
        return $this->render('index');
    }

}
