<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'UBAH DATA PTK';


if(Yii::$app->session->get('kode_akses')==3){
    $query_tambahan='WHERE sekolah.npsn="'. yii::$app->session->get('id_sekolah') .'"';
}else{
    $query_tambahan="";
}
$sekolahList = Yii::$app->db->createCommand("SELECT npsn, nama FROM sekolah $query_tambahan ORDER BY nama")->queryAll();
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
                <i class="fa fa-edit icon-title"></i> UBAH DATA PTK
            </h1>
        </div>
    </div>
    <?php
    if (Yii::$app->session->get('kode_akses')!=3) {
        ?>
        <div class="card-header">
            <div class="col-sm-12 text-right">
                <a href="<?= Yii::$app->urlManager->createUrl(['/ptk/upload']) ?>" class="btn btn-secondary"><i class="fa fa-plus"></i> DENGAN EXCEL</a>
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
                        <?= $form->field($model, 'nik')->textInput(['value'=>$data['nik'],'maxlength' => 16, 'placeholder' => 'Masukkan NIK', 'required' => true])->label('NIK <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nokk')->textInput(['value'=>$data['no_kk'],'maxlength' => 16, 'placeholder' => 'Masukkan Nomor Kartu Keluarga'])->label('Nomor KK') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nama')->textInput(['value'=>$data['nama'],'maxlength' => true, 'placeholder' => 'Ex: Jhon Doe,S.T', 'required' => true])->label('Nama Lengkap <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tempat_lahir')->textInput(['value'=>$data['tempat_lahir'],'maxlength' => true, 'placeholder' => 'Ex: Kab. Abc', 'required' => true])->label('Tempat Lahir <span class="text-danger">*</span>') ?>
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
                        <?= $form->field($model, 'no_hp')->textInput(['value'=>$data['no_hp'],'maxlength' => 15, 'placeholder' => 'Ex: +628xxxxxxxxxx', 'required' => true])->label('No. HP <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'email')->textInput(['value'=>$data['email'],'type'=>'email','maxlength' => true, 'placeholder' => 'Ex: abc@abc.com', 'required' => true])->label('Email Aktif <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'kewarganegaraan')->dropDownList([
                                'WNI' => 'Warga Negara Indonesia (WNI)',
                                'WNA' => 'Warga Negara Asing (WNA)'
                            ], ['prompt' => '-Pilih Kewarganegaraan-',
                                'value' => $data['kewarganegaraan'] ?? ''])->label('Kewarganegaraan <span class="text-danger">*</span>') ?>
                    </div>
                </div>
                <hr>
                <h5>DATA DOMISILI</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'provinsi')->textInput(['value'=>$data['provinsi'],'placeholder' => 'Ex: Sulawesi Utara'])->label('Provinsi <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'kabupaten')->textInput(['value'=>$data['kabupaten'],'placeholder' => 'Ex: Kab. Abc'])->label('Kabupaten/Kota <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'kecamatan')->textInput(['value'=>$data['kecamatan'],'placeholder' => 'Ex: Kec. Abc'])->label('Kecamatan <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'desa_kelurahan')->textInput(['value'=>$data['desa_kelurahan'],'placeholder' => 'Ex: Kel. Abc'])->label('Desa/Keluarahan <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'rt')->textInput(['value'=>$data['rt'],'placeholder' => 'Ex: 001'])->label('RT <span class="text-danger">*</span>') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'rw')->textInput(['value'=>$data['rw'],'placeholder' => 'Ex: 001'])->label('RW <span class="text-danger">*</span>') ?>
                    </div>
                </div>
                <hr>
                <h5>DATA KEPEGAWAIAN</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'nip')->textInput(['value'=>$data['nip'],'maxlength' => 20, 'placeholder' => 'Masukkan NIP'])->label('NIP') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nuptk')->textInput(['value'=>$data['nuptk'],'maxlength' => 20, 'placeholder' => 'Masukkan NUPTK, jika tidak ada maka tidak bisa diusulkan pada Aldrin Sertifikasi'])->label('NUPTK') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'pangkat_golongan')->textInput(['value'=>$data['pangkat_golongan'],'maxlength' => 5, 'placeholder' => 'Ex: IV/A'])->label('Pangkat Golongan') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'status_kepegawaian')->widget(Select2::classname(), [
                            'data' => $dropdownDataStatusKepegawaian,
                            'options' => [
                                'placeholder' => '- Pilih Status Kepegawaian -',
                                'value' => $data['status_kepegawaian'] ?? '' // Set default value jika ada
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Status Kepegawaian <span class="text-danger">*</span>'); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'sk_cpns')->textInput(['value'=>$data['sk_cpns'],'maxlength' => 16, 'placeholder' => 'SK CPNS'])->label('SK CPNS') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tgl_cpns')->input('date',['value'=>$data['tgl_cpns']])->label('Tanggal CPNS') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'sk_pengangkatan')->textInput(['value'=>$data['sk_pengangkatan'],'maxlength' => 16, 'placeholder' => 'SK Pengangkatan'])->label('SK Pengangkatan') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tmt_pengangkatan')->input('date',['value'=>$data['tmt_pengangkatan']])->label('TMT Pengangkatan') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'jabatan')->widget(Select2::classname(), [
                            'data' => $dropdownDataJabatan,
                            'options' => [
                                'placeholder' => '- Pilih Jabatan -',
                                'value' => $data['jabatan'] ?? '' // Set default value jika ada
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Jabatan <span class="text-danger">*</span>'); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'npsn')->widget(Select2::classname(), [
                            'data' => $dropdownDataSekolah,
                            'options' => [
                                'placeholder' => '- Pilih Sekolah -',
                                'value' => $data['npsn'] ?? '' // Set default value jika ada
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Sekolah Terdaftar <span class="text-danger">*</span>'); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'jenis_ptk')->widget(Select2::classname(), [
                            'data' => $dropdownDataJenisPtk,
                            'options' => [
                                'placeholder' => '- Pilih Jenis PTK -',
                                'value' => $data['jenis_ptk'] ?? '' // Default value jika ada
                            ],
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
