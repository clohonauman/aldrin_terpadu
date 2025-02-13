<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'MASUK';
?>

<div class="login-container">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'nama_pengguna')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'kata_sandi')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
