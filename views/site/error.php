<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;
?>
<div class="d-flex align-items-center justify-content-center">
    <div class="text-center">
        <i class="fa fa-exclamation-triangle text-danger fa-5x mb-3"></i>
        <h1 class="fw-bold text-danger"><?= Html::encode($name) ?></h1>
        
        <div class="alert alert-danger shadow-sm p-3">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <p class="text-muted">
            Kesalahan terjadi saat server memproses permintaan Anda.
        </p>
        <p class="text-muted">
            Jika menurut Anda ini adalah kesalahan server, silakan hubungi kami.
        </p>

        <a href="<?= Yii::$app->homeUrl.'beranda' ?>" class="btn btn-primary mt-3">
            <i class="fa fa-home"></i> Kembali ke Beranda
        </a>
    </div>
</div>
