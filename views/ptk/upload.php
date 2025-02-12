<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->registerCss("
    .drop-zone {
        border: 2px dashed #ccc;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .drop-zone:hover {
        background-color: #f0f0f0;
    }
    .drop-zone p {
        margin: 0;
        color: #888;
    }
");

$this->registerJs("
    let dropZone = document.getElementById('drop-zone');
    let fileInput = document.getElementById('file-input');

    dropZone.addEventListener('click', function() {
        fileInput.click();
    });

    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.style.backgroundColor = '#e9ecef';
    });

    dropZone.addEventListener('dragleave', function() {
        dropZone.style.backgroundColor = '#f9f9f9';
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.style.backgroundColor = '#f9f9f9';
        fileInput.files = e.dataTransfer.files;
    });
");

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

                <h4>Unggah Data dari Dapodik</h4>
                <div id="drop-zone" class="drop-zone">
                    <p>Tarik & Letakkan file di sini atau klik untuk memilih</p>
                </div>
                <span class="text-mute"><i>* Unggah file excel yang diunduh dari Dapodik</i></span>
                <div class="display-none">
                    <?= $form->field($model, 'file')->fileInput(['id' => 'file-input', 'style' => 'display:none;']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Unggah', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>
</div>
