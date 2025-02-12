<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'UNGGAH DATA PTK';


$sekolahList = Yii::$app->db->createCommand("SELECT npsn, nama FROM sekolah ORDER BY nama")->queryAll();
$dropdownDataSekolah = [];
foreach ($sekolahList as $sekolah) {
    $dropdownDataSekolah[$sekolah['npsn']] = $sekolah['npsn'] . ' | ' . $sekolah['nama'];
}

$statusKepegawaianList = Yii::$app->db->createCommand("SELECT DISTINCT status_kepegawaian FROM ptk")->queryAll();
$dropdownDataStatusKepegawaian = [];
foreach ($statusKepegawaianList as $statusKepegawaian) {
    $dropdownDataStatusKepegawaian[$statusKepegawaian['status_kepegawaian']] = $statusKepegawaian['status_kepegawaian'];
}
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
            <a href="<?= Yii::$app->urlManager->createUrl(['/ptk/upload']) ?>" class="btn btn-secondary"><i class="fa fa-plus"></i> DENGAN EXCEL</a>
        </div>
    </div>
    <div class="card-body">
        <?php date_default_timezone_set("Asia/Jakarta"); ?>
        <section class="content">
            <div class="row">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <hr>
                <h5>DATA DIRI</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'nik')->textInput(['maxlength' => 16, 'placeholder' => 'NIK', 'required' => true])->label('NIK') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Nama Lengkap', 'required' => true])->label('Nama Lengkap') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tempat_lahir')->textInput(['maxlength' => true, 'placeholder' => 'Tempat Lahir', 'required' => true])->label('Tempat Lahir') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tanggal_lahir')->input('date', ['required' => true])->label('Tanggal Lahir') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'jenis_kelamin')->dropDownList([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan'
                            ], ['prompt' => '-Pilih Jenis Kelamin-'], ['required'=>true])->label('Jenis Kelamin') ?>
                    </div>

                </div>
                <hr>
                <h5>DATA KEPEGAWAIAN</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'nip')->textInput(['maxlength' => 16, 'placeholder' => 'NIP'])->label('NIP') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nuptk')->textInput(['maxlength' => 16, 'placeholder' => 'NUPTK'])->label('NUPTK') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'status_kepegawaian')->widget(Select2::classname(), [
                            'data' => $dropdownDataStatusKepegawaian,
                            'options' => ['placeholder' => '- Pilih Status Kepegawaian -'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Status Kepegawaian'); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'sk_cpns')->textInput(['maxlength' => 16, 'placeholder' => 'SK CPNS'])->label('SK CPNS') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true, 'placeholder' => 'Jabatan'])->label('Jabatan') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'npsn')->widget(Select2::classname(), [
                            'data' => $dropdownDataSekolah,
                            'options' => ['placeholder' => '- Pilih Sekolah -'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Sekolah Terdaftar'); ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group">
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
                        <a href="<?= Yii::$app->urlManager->createUrl(['/ptk']) ?>" class="btn btn-secondary"> Batal</a>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>
</div>
