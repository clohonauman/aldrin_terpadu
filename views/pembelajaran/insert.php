<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'UNGGAH DATA PEMBELAJARAN';
$session = Yii::$app->session;
$session->open();
$npsn=$session->get('id_sekolah');

$ptkList = Yii::$app->db->createCommand("SELECT ptk_id, nama, jabatan FROM ptk WHERE sekolah_id='$npsn' ORDER BY nama")->queryAll();
$dropdownDataPTK = [];
foreach ($ptkList as $ptk) {
    $dropdownDataPTK[$ptk['ptk_id']] = $ptk['nama'] . ' | ' . $ptk['jabatan'];
}
$rombelList = Yii::$app->db->createCommand("SELECT * FROM rombongan_belajar WHERE sekolah_id='$npsn' ORDER BY nama")->queryAll();
$dropdownDataRombel = [];
foreach ($rombelList as $rombel) {
    $dropdownDataRombel[$rombel['rombongan_belajar_id']] = 'Kelas ' . $rombel['tingkat_pendidikan'] . ' | ' . $rombel['nama'] . ' | ' . $rombel['semester'];
}
$mapelList = Yii::$app->db->createCommand("SELECT * FROM mata_pelajaran ORDER BY mata_pelajaran")->queryAll();
$dropdownDataMapel = [];
foreach ($mapelList as $mapel) {
    $dropdownDataMapel[$mapel['id']] = $mapel['mata_pelajaran'];
}
?>
<div class="card">
    <div class="card-header">
        <div class="col-sm-12">
            <h1>
                <i class="fa fa-upload icon-title"></i> UNGGAH DATA PEMBELAJARAN
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
                    <?= $form->field($model, 'ptk_id')->widget(Select2::classname(), [
                        'data' => $dropdownDataPTK,
                        'options' => ['placeholder' => '- Pilih PTK -'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('PTK <span class="text-danger">*</span>'); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'mata_pelajaran_id')->widget(Select2::classname(), [
                        'data' => $dropdownDataMapel,
                        'options' => ['placeholder' => '- Pilih Mapel -'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Mata Pelajaran <span class="text-danger">*</span>'); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'rombongan_belajar_id')->widget(Select2::classname(), [
                        'data' => $dropdownDataRombel,
                        'options' => ['placeholder' => '- Pilih Rombel -'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Rombongan Belajar <span class="text-danger">*</span>'); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'jam_mengajar_per_minggu')->textInput(['type' => 'number', 'placeholder' => 'Masukkan Jumlah Mengajar Per Minggu'])->label('Jumlah Mengajar Per Minggu <span class="text-danger">*</span>') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'sk_mengajar')->textInput(['type' => 'text', 'placeholder' => 'Masukkan SK Mengajar'])->label('SK Mengajar') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'tanggal_sk_mengajar')->input('date')->label('Tanggal SK Mengajar') ?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="form-group">
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/pembelajaran']) ?>" class="btn btn-secondary"> Batal</a>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
