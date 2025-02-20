<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'UNGGAH DATA SISWA';
?>
<div class="card">
    <div class="card-header">
        <div class="col-sm-12">
            <h1>
                <i class="fa fa-upload icon-title"></i> UNGGAH DATA SISWA
            </h1>
        </div>
    </div>
    <?php
    if (Yii::$app->session->get('kode_akses')==3) {
        ?>
        <div class="card-header">
            <div class="col-sm-12 text-right">
                <a href="<?= Yii::$app->urlManager->createUrl(['/siswa/upload']) ?>" class="btn btn-secondary"><i class="fa fa-plus"></i> DENGAN EXCEL</a>
            </div>
        </div>
        <?php
    }
    ?>
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
                        <?= $form->field($model, 'nisn')->textInput(['maxlength' => 10, 'placeholder' => 'Masukkan NISN'])->label('NISN <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nik')->textInput(['maxlength' => 20, 'placeholder' => 'Masukkan NIK'])->label('NIK') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'no_kk')->textInput(['maxlength' => 20, 'placeholder' => 'Masukkan Nomor Kartu Keluarga'])->label('Nomor KK') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Ex: Jhon Doe'])->label('Nama Lengkap <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tempat_lahir')->textInput(['maxlength' => true, 'placeholder' => 'Ex: Kab. Abc'])->label('Tempat Lahir') ?>
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
                        <?= $form->field($model, 'nama_ibu_kandung')->textInput(['maxlength' => true, 'placeholder' => 'Ex: Putry Doe'])->label('Nama Ibu Kandung <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tingkat_pendidikan')->dropDownList([
                                'Kelas 1' => 'Kelas 1',
                                'Kelas 2' => 'Kelas 2',
                                'Kelas 3' => 'Kelas 3',
                                'Kelas 4' => 'Kelas 4',
                                'Kelas 5' => 'Kelas 5',
                                'Kelas 6' => 'Kelas 6',
                                'Kelas 7' => 'Kelas 7',
                                'Kelas 8' => 'Kelas 8',
                                'Kelas 9' => 'Kelas 9',
                            ], ['prompt' => '-Pilih Kelas-'])->label('Tingkat Pendidikan <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'status')->dropDownList([
                                '1' => 'Aktif',
                                '2' => 'Putus Sekolah',
                                '3' => 'Meninggal Dunia',
                                '4' => 'Berhenti Tanpa Alasan',
                                '5' => 'Pindah/Mutasi',
                            ], ['prompt' => '-Pilih Status-'])->label('Status Siswa <span class="text-danger">*</span>') ?>
                    </div>

                </div>
                <hr>
                <h5>DATA DOMISILI</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'provinsi')->textInput(['placeholder' => 'Ex: Sulawesi Utara'])->label('Provinsi') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'kabupaten')->textInput(['placeholder' => 'Ex: Kab. Abc'])->label('Kabupaten/Kota') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'kecamatan')->textInput(['placeholder' => 'Ex: Kec. Abc'])->label('Kecamatan') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'desa_kelurahan')->textInput(['placeholder' => 'Ex: Kel. Abc'])->label('Desa/Keluarahan') ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group">
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
                        <a href="<?= Yii::$app->urlManager->createUrl(['/siswa']) ?>" class="btn btn-secondary"> Batal</a>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>
</div>
