<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'MASUK | ALDRIN TERPADU';
?>
<div class="login-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= $form->field($model, 'nama_pengguna', [
            'template' => "{input}\n<div class='text-danger fst-italic'>{error}</div>",
        ])->textInput([
            'maxlength' => 50,
            'placeholder' => 'Nama Pengguna',
            'class' => 'form-control',
        ])->label(false) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'kata_sandi', [
            'template' => "{input}\n<div class='text-danger fst-italic'>{error}</div>",
        ])->passwordInput([
            'maxlength' => 50,
            'placeholder' => 'Kata Sandi',
            'class' => 'form-control',
        ])->label(false) ?>
    </div>

    <hr>

    <div class="form-group">
        <?= Html::submitButton('Masuk', ['class' => 'btn btn-light col-md-12']) ?><hr>

        <div class="card alert alert-danger alert-dismissable">
            <b><i class="fa fa-exclamation-triangle"></i> Perhatian!</b>
            <p style="font-size:15px">
                Jika anda lupa nama pengguna atau kata sandi silahkan menghubungi admin Aldrin Terpadu. Terima kasih.
            </p>        
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
