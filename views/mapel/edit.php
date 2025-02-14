<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Edit Mata Pelajaran: ' . $model->mata_pelajaran;
?>
<div class="card">
    <div class="card-header">
        <div class="col-sm-12">
            <h1>
                <i class="fa fa-database icon-title"></i> Data Mata Pelajaran
            </h1>
        </div>
    </div>
    <div class="card-body">
        <?php date_default_timezone_set("Asia/Jakarta"); ?>
        <!-- Tabel Data PTK -->
        <div class="row mb-4">
            <div class="col-md-6 text-left">
                <h4><i class="fa fa-book"></i> Tambah Mata Pelajaran</h4>
            </div>
        </div>

        <hr>

        <div class="mapel-create">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'mata_pelajaran')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'jam_pelajaran')->textInput(['maxlength' => true]) ?>
            <div class="form-group">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div><!-- mapel-create -->

    </div>
</div>