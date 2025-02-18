<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title='ALDRIN TERPADU';

?>
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-primary navbar-primary border-primary">
        <a href="#" class="navbar-brand">
            <img src="<?= Yii::getAlias('@web') ?>/app_logo.png" alt="Logo" class="brand-image w-100">
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <?= Html::a('Masuk', ['/login'], ['class' => 'btn btn-light']) ?>
                </li>
            </ul>
        </div>
    </nav>
</div>