<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Login';
?>
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h1><b><?= Html::encode($this->title) ?></b></h1>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Silakan masuk untuk memulai sesi Anda</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username', [
                'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Username'],
            ])->textInput()->label(false) ?>

            <?= $form->field($model, 'password', [
                'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Password'],
            ])->passwordInput()->label(false) ?>

            <?= $form->field($model, 'rememberMe', [
                'options' => ['class' => 'form-check'],
                'template' => "<div class='form-check'>{input} {label}</div>",
            ])->checkbox(['class' => 'form-check-input'], false) ?>

            <div class="row">
                <div class="col-12">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
