<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'UNGGAH DATA ROMBEL';


$sekolahList = Yii::$app->db->createCommand("SELECT npsn, nama FROM sekolah ORDER BY nama")->queryAll();
$dropdownDataSekolah = [];
foreach ($sekolahList as $sekolah) {
    $dropdownDataSekolah[$sekolah['npsn']] = $sekolah['npsn'] . ' | ' . $sekolah['nama'];
}
?>
<div class="card">
    <div class="card-header">
        <div class="col-sm-12">
            <h1>
                <i class="fa fa-upload icon-title"></i> UNGGAH DATA ROMBEL
            </h1>
        </div>
    </div>
    <div class="card-body">
        <?php date_default_timezone_set("Asia/Jakarta"); ?>
        <section class="content">
            <div class="row">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <hr>
                <h5>DATA ROMBEL</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'nama_rombel')->textInput(['maxlength' => 16, 'placeholder' => 'Masukkan Nama Rombel'])->label('Nama Rombel <span class="text-danger">*</span>') ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group">
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
                        <a href="<?= Yii::$app->urlManager->createUrl(['/rombel']) ?>" class="btn btn-secondary"> Batal</a>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>
</div>
