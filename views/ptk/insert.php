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

$jenisPtkList = Yii::$app->db->createCommand("SELECT DISTINCT jenis_ptk FROM ptk")->queryAll();
$dropdownDataJenisPtk = [];
foreach ($jenisPtkList as $jenisPtk) {
    $dropdownDataJenisPtk[$jenisPtk['jenis_ptk']] = $jenisPtk['jenis_ptk'];
}

$jabatanList = Yii::$app->db->createCommand("SELECT DISTINCT jabatan FROM ptk")->queryAll();
$dropdownDataJabatan = [];
foreach ($jabatanList as $jabatan) {
    $dropdownDataJabatan[$jabatan['jabatan']] = $jabatan['jabatan'];
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
                        <?= $form->field($model, 'nik')->textInput(['maxlength' => 16, 'placeholder' => 'Masukkan NIK', 'required' => true])->label('NIK <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nokk')->textInput(['maxlength' => 16, 'placeholder' => 'Masukkan Nomor Kartu Keluarga'])->label('Nomor KK') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Ex: Jhon Doe,S.T', 'required' => true])->label('Nama Lengkap <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tempat_lahir')->textInput(['maxlength' => true, 'placeholder' => 'Ex: Kab. Abc', 'required' => true])->label('Tempat Lahir <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tanggal_lahir')->input('date')->label('Tanggal Lahir <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'jenis_kelamin')->dropDownList([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan'
                            ], ['prompt' => '-Pilih Jenis Kelamin-'])->label('Jenis Kelamin <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'no_hp')->textInput(['maxlength' => 15, 'placeholder' => 'Ex: +628xxxxxxxxxx', 'required' => true])->label('No. HP <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'email')->textInput(['type'=>'email','maxlength' => true, 'placeholder' => 'Ex: abc@abc.com', 'required' => true])->label('Email Aktif <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'kewarganegaraan')->dropDownList([
                                'WNI' => 'Warga Negara Indonesia (WNI)',
                                'WNA' => 'Warga Negara Asing (WNA)'
                            ], ['prompt' => '-Pilih Kewarganegaraan-'])->label('Kewarganegaraan <span class="text-danger">*</span>') ?>
                    </div>

                </div>
                <hr>
                <h5>DATA DOMISILI</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'provinsi')->textInput(['placeholder' => 'Ex: Sulawesi Utara'])->label('Provinsi <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'kabupaten')->textInput(['placeholder' => 'Ex: Kab. Abc'])->label('Kabupaten/Kota <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'kecamatan')->textInput(['placeholder' => 'Ex: Kec. Abc'])->label('Kecamatan <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'desa_kelurahan')->textInput(['placeholder' => 'Ex: Kel. Abc'])->label('Desa/Keluarahan <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'rt')->textInput(['placeholder' => 'Ex: 001'])->label('RT <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'rw')->textInput(['placeholder' => 'Ex: 001'])->label('RW <span class="text-danger">*</span>') ?>
                    </div>
                </div>
                <hr>
                <h5>DATA KEPEGAWAIAN</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'nip')->textInput(['maxlength' => 16, 'placeholder' => 'Masukkan NIP'])->label('NIP') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nuptk')->textInput(['maxlength' => 16, 'placeholder' => 'Masukkan NUPTK, jika tidak ada maka tidak bisa diusulkan pada Aldrin Sertifikasi'])->label('NUPTK') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'pangkat_golongan')->textInput(['maxlength' => 5, 'placeholder' => 'Ex: IV/A'])->label('Pangkat Golongan') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'status_kepegawaian')->widget(Select2::classname(), [
                            'data' => $dropdownDataStatusKepegawaian,
                            'options' => ['placeholder' => '- Pilih Status Kepegawaian -'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Status Kepegawaian <span class="text-danger">*</span>'); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'sk_cpns')->textInput(['maxlength' => 16, 'placeholder' => 'SK CPNS'])->label('SK CPNS') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tgl_cpns')->input('date')->label('Tanggal CPNS') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'sk_pengangkatan')->textInput(['maxlength' => 16, 'placeholder' => 'SK Pengangkatan'])->label('SK Pengangkatan') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tmt_pengangkatan')->input('date')->label('TMT Pengangkatan') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'jabatan')->widget(Select2::classname(), [
                            'data' => $dropdownDataJabatan,
                            'options' => ['placeholder' => '- Pilih Jabatan -'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Jabatan <span class="text-danger">*</span>'); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'npsn')->widget(Select2::classname(), [
                            'data' => $dropdownDataSekolah,
                            'options' => ['placeholder' => '- Pilih Sekolah -'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Sekolah Terdaftar <span class="text-danger">*</span>'); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'jenis_ptk')->widget(Select2::classname(), [
                            'data' => $dropdownDataJenisPtk,
                            'options' => ['placeholder' => '- Pilih Jenis PTK -'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Jenis PTK <span class="text-danger">*</span>'); ?>
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
