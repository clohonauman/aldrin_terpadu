<?php

namespace app\controllers;

class IndexController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'index'; // Menggunakan layouts/index.php
        return $this->render('index');
    }
}
