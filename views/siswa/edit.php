<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'UBAH DATA SISWA';
?>
<div class="card">
    <div class="card-header">
        <div class="col-sm-12">
            <h1>
                <i class="fa fa-edit icon-title"></i> UBAH DATA SISWA
            </h1>
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
                        <?= $form->field($model, 'nisn')->textInput(['value'=>$data['nisn'],'maxlength' => 10, 'placeholder' => 'Masukkan NISN'])->label('NISN <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nik')->textInput(['value'=>$data['nik'],'maxlength' => 20, 'placeholder' => 'Masukkan NIK'])->label('NIK') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'no_kk')->textInput(['value'=>$data['no_kk'],'maxlength' => 20, 'placeholder' => 'Masukkan Nomor Kartu Keluarga'])->label('Nomor KK') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nama')->textInput(['value'=>$data['nama'],'maxlength' => true, 'placeholder' => 'Ex: Jhon Doe'])->label('Nama Lengkap <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tempat_lahir')->textInput(['value'=>$data['tempat_lahir'],'maxlength' => true, 'placeholder' => 'Ex: Kab. Abc'])->label('Tempat Lahir <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tanggal_lahir')->input('date',['value'=>$data['tanggal_lahir']])->label('Tanggal Lahir <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'jenis_kelamin')->dropDownList([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan'
                            ], ['prompt' => '-Pilih Jenis Kelamin-',
                                'value' => $data['jenis_kelamin'] ?? ''])->label('Jenis Kelamin <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nama_ibu_kandung')->textInput(['value'=>$data['nama_ibu_kandung'],'maxlength' => true, 'placeholder' => 'Ex: Putry Doe'])->label('Nama Ibu Kandung <span class="text-danger">*</span>') ?>
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
                            ], ['prompt' => '-Pilih Kelas-',
                                'value' => $data['tingkat_pendidikan'] ?? ''])->label('Tingkat Pendidikan <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'status')->dropDownList([
                                '1' => 'Aktif',
                                '2' => 'Putus Sekolah',
                                '3' => 'Meninggal Dunia',
                                '4' => 'Berhenti Tanpa Alasan',
                                '5' => 'Pindah/Mutasi',
                            ], ['prompt' => '-Pilih Status-',
                                'value' => $data['status'] ?? ''])->label('Status Siswa <span class="text-danger">*</span>') ?>
                    </div>
                </div>
                <hr>
                <h5>DATA DOMISILI</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'provinsi')->textInput(['value'=>$data['provinsi'],'placeholder' => 'Ex: Sulawesi Utara'])->label('Provinsi') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'kabupaten')->textInput(['value'=>$data['kabupaten'],'placeholder' => 'Ex: Kab. Abc'])->label('Kabupaten/Kota') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'kecamatan')->textInput(['value'=>$data['kecamatan'],'placeholder' => 'Ex: Kec. Abc'])->label('Kecamatan') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'desa_kelurahan')->textInput(['value'=>$data['desa_kelurahan'],'placeholder' => 'Ex: Kel. Abc'])->label('Desa/Keluarahan') ?>
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
