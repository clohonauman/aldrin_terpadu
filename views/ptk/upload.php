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
        transition: background-color 0.3s;
    }
    .drop-zone:hover {
        background-color: #f0f0f0;
    }
    .drop-zone p {
        margin: 0;
        color: #888;
    }
    .error-message {
        color: red;
        font-weight: bold;
        display: none;
    }
");

$this->registerJs("
    let dropZone = document.getElementById('drop-zone');
    let fileInput = document.getElementById('file-input');
    let errorMessage = document.getElementById('error-message');
    let dropZoneText = document.getElementById('drop-zone-text');

    // Saat klik drop zone, trigger file input
    dropZone.addEventListener('click', function() {
        fileInput.click();
    });

    // Saat drag over
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.style.backgroundColor = '#e9ecef';
    });

    // Saat drag leave
    dropZone.addEventListener('dragleave', function() {
        dropZone.style.backgroundColor = '#f9f9f9';
    });

    // Saat file di-drop
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.style.backgroundColor = '#f9f9f9';
        fileInput.files = e.dataTransfer.files;
        updateDropZoneText();
    });

    // Saat file dipilih via input
    fileInput.addEventListener('change', function() {
        updateDropZoneText();
    });

    // Fungsi untuk mengganti teks drop zone dengan nama file
    function updateDropZoneText() {
        if (fileInput.files.length > 0) {
            dropZoneText.innerText = fileInput.files[0].name;
            errorMessage.style.display = 'none'; // Sembunyikan pesan error
        } else {
            dropZoneText.innerText = 'Tarik & Letakkan file di sini atau klik untuk memilih';
        }
    }

    // Validasi sebelum submit form
    document.getElementById('upload-form').addEventListener('submit', function(event) {
        if (fileInput.files.length === 0) {
            event.preventDefault(); // Hentikan form submit
            errorMessage.style.display = 'block';
        }
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
    <div class="card-header">
        <div class="col-sm-12 text-right">
            <a href="<?= Yii::$app->urlManager->createUrl(['/ptk/insert']) ?>" class="btn btn-secondary"><i class="fa fa-plus"></i> TANPA EXCEL</a>
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
                <?php $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data', 'id' => 'upload-form']
                ]); ?>
                <?= $form->field($model, 'file')->fileInput(['id' => 'file-input', 'style' => 'display:none;'])->label('File Excel Dapodik') ?>
                <div id="drop-zone" class="drop-zone">
                    <p id="drop-zone-text">Tarik & Letakkan file excel Dapodik di sini atau klik untuk memilih</p>
                </div>
                <span class="text-mute"><i>* Unggah file excel yang diunduh dari Dapodik</i></span>
                

                <hr>
                <div class="form-group">
                    <?= Html::submitButton('Unggah', ['class' => 'btn btn-primary']) ?>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/ptk']) ?>" class="btn btn-secondary"> Batal</a>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>
</div>
