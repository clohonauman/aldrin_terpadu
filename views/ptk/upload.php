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
    <div class="card-body ">
        <?php date_default_timezone_set("Asia/jakarta"); ?>
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="card alert alert-danger alert-dismissable">
                        <b><i class="fa fa-warning"></i> Perhatian!</b>
                        <p style="font-size:15px">
                            Pastikan file excel yang diunggah adalah hasil unduhan dari DAPODIK ADMIN. Terima kasih.
                        </p>        
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                
                <label for="">FILE EXCEL DARI DAPODIK</label>
                <?= $form->field($model, 'file')->fileInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Unggah', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>
</div>
