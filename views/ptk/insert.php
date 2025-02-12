<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'UNGGAH DATA PTK';
?>
<div class="card">
    <div class="card-header">
        <div class="col-sm-12">
            <h1>
                <i class="fa fa-upload icon-title"></i> UNGGAH DATA PTK
            </h1>
        </div>
    </div>
    <div class="card-body">
        <?php date_default_timezone_set("Asia/Jakarta"); ?>
        <section class="content">
            <div class="row">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <h4>Lengkapi Data PTK</h4>
                
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Nama Lengkap', 'required' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nik')->textInput(['maxlength' => 16, 'placeholder' => 'NIK', 'required' => true]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'nuptk')->textInput(['maxlength' => 16, 'placeholder' => 'NUPTK']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tempat_lahir')->textInput(['maxlength' => true, 'placeholder' => 'Tempat Lahir']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'tanggal_lahir')->input('date') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true, 'placeholder' => 'Jabatan']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>
</div>
