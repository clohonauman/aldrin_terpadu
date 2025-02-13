<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'MASUK | ALDRIN TERPADU';
?>
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_pengguna')->textInput(['maxlength' => 35, 'placeholder' => 'Nama Pengguna'])->label(' ') ?>
    <?= $form->field($model, 'kata_sandi')->passwordInput(['maxlength' => 35, 'placeholder' => 'Kata Sandi'])->label(' ') ?>
    <hr>
    <div class="form-group">
        <?= Html::submitButton('Masuk', ['class' => 'btn btn-primary col-md-12']) ?>
    </div>

<?php ActiveForm::end(); ?>
