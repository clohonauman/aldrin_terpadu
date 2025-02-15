<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'UNGGAH DATA ROMBEL';
$session = Yii::$app->session;
$session->open();
$npsn=$session->get('id_sekolah');

$ptkList = Yii::$app->db->createCommand("SELECT ptk_id, nama, jabatan FROM ptk WHERE sekolah_id='$npsn' ORDER BY nama")->queryAll();
$dropdownDataPTK = [];
foreach ($ptkList as $ptk) {
    $dropdownDataPTK[$ptk['ptk_id']] = $ptk['nama'] . ' | ' . $ptk['jabatan'];
}

$mapelList = Yii::$app->db->createCommand("SELECT id, mata_pelajaran, jam_pelajaran FROM mata_pelajaran ORDER BY mata_pelajaran")->queryAll();
$dropdownDataMapel = [];
foreach ($mapelList as $mapel) {
    $dropdownDataMapel[$mapel['id']] = $mapel['jam_pelajaran'].'JJM | '.$mapel['mata_pelajaran'];
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
        <div class="row">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <hr>
            <h5>DATA ROMBEL</h5>
            <hr>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'ptk')->widget(Select2::classname(), [
                        'data' => $dropdownDataPTK,
                        'options' => ['placeholder' => '- Pilih PTK -'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('PTK <span class="text-danger">*</span>'); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'tingkat_pendidikan')->textInput(['type'=> 'number','maxlength' => 1, 'placeholder' => 'Masukkan Tingkat Pendidikan (1 s/d 9)'])->label('Tingkat Pendidikan <span class="text-danger">*</span>') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'nama_rombel')->textInput(['maxlength' => 30, 'placeholder' => 'Masukkan Nama Rombel'])->label('Nama Rombel <span class="text-danger">*</span>') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'jumlah_pembelajaran')->textInput(['type' => 'number', 'placeholder' => 'Masukkan Jumlah Pembelajaran'])->label('Jumlah Pembelajaran <span class="text-danger">*</span>') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'jumlah_anggota_rombel')->textInput(['type' => 'number', 'placeholder' => 'Masukkan Jumlah Anggota Rombel'])->label('Jumlah Anggota Rombel') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'semester')->dropDownList(
                        ['Ganjil' => 'Ganjil', 'Genap' => 'Genap'],
                        ['prompt' => '- Pilih Semester -']
                    )->label('Semester <span class="text-danger">*</span>') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'mata_pelajaran')->widget(Select2::classname(), [
                        'data' => $dropdownDataMapel,
                        'options' => ['placeholder' => '- Pilih Mata Pelajaran -'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Mata Pelajaran <span class="text-danger">*</span>'); ?>
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
    </div>
</div>
