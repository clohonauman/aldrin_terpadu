<?php
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
/** @var yii\web\View $this */
$this->title = 'EDIT SEKOLAH';
$bentukPendidikanList = Yii::$app->db->createCommand("SELECT DISTINCT bentuk_pendidikan FROM sekolah ORDER BY bentuk_pendidikan")->queryAll();
$dropdownDataBentukPendidikan = [];
foreach ($bentukPendidikanList as $bentukPendidikan) {
    $dropdownDataBentukPendidikan[$bentukPendidikan['bentuk_pendidikan']] = $bentukPendidikan['bentuk_pendidikan'];
}
$statusSekolahList = Yii::$app->db->createCommand("SELECT DISTINCT status_sekolah FROM sekolah ORDER BY status_sekolah")->queryAll();
$dropdownDataStatusSekolah = [];
foreach ($statusSekolahList as $statusSekolah) {
    $dropdownDataStatusSekolah[$statusSekolah['status_sekolah']] = $statusSekolah['status_sekolah'];
}
$statusKepemilikanList = Yii::$app->db->createCommand("SELECT DISTINCT status_kepemilikan FROM sekolah ORDER BY status_kepemilikan")->queryAll();
$dropdownDataStatusKepemilikan = [];
foreach ($statusKepemilikanList as $statusKepemilikan) {
    $dropdownDataStatusKepemilikan[$statusKepemilikan['status_kepemilikan']] = $statusKepemilikan['status_kepemilikan'];
}
$kecamatanList = Yii::$app->db->createCommand("SELECT DISTINCT kecamatan FROM sekolah ORDER BY kecamatan")->queryAll();
$dropdownDataKecamatan = [];
foreach ($kecamatanList as $kecamatan) {
    $dropdownDataKecamatan[$kecamatan['kecamatan']] = $kecamatan['kecamatan'];
}
$akreditasiList = Yii::$app->db->createCommand("SELECT DISTINCT akreditasi FROM sekolah ORDER BY akreditasi")->queryAll();
$dropdownDataAkreditasi = [];
foreach ($akreditasiList as $akreditasi) {
    $dropdownDataAkreditasi[$akreditasi['akreditasi']] = $akreditasi['akreditasi'];
}
?>

<div class="card">
    <div class="row card-header">
        <div class="col-sm-6 text-left">
            <h1>
                <i class="fa fa-edit icon-title"></i> EDIT DATA SEKOLAH
            </h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="<?= Yii::$app->urlManager->createUrl(['/sekolah']) ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> KEMBALI</a>
        </div>
    </div>
    <div class="card-body">
        <?php date_default_timezone_set("Asia/Jakarta"); ?>
        <section class="content">
            <!-- Tabel Data Sekolah -->
            <div class="card-body">
                <div class="row">
                    <div class="card-header">
                        <h5><i class="fa fa-school"></i> Data Sekolah</h5>
                    </div>
                    <div class="card-body">
                        <?php $form = ActiveForm::begin(['method' => 'post']); ?>

                        <div class="card-body">
                            <div class="col-md-6">
                                <?= $form->field($model, 'nama')->textInput(['value' => $data['nama']])->label('Nama Sekolah <span class="text-danger">*</span>') ?>
                                <?= $form->field($model, 'bentuk_pendidikan')->widget(Select2::classname(), [
                                    'data' => $dropdownDataBentukPendidikan,
                                    'options' => [
                                        'placeholder' => '- Pilih Bentuk Pendidikan -',
                                        'value' => $data['bentuk_pendidikan'] ?? ''
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Bentuk Pendidikan <span class="text-danger">*</span>'); ?>
                                <?= $form->field($model, 'status_sekolah')->widget(Select2::classname(), [
                                    'data' => $dropdownDataStatusSekolah,
                                    'options' => [
                                        'placeholder' => '- Pilih Status Sekolah -',
                                        'value' => $data['status_sekolah'] ?? ''
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Status Sekolah <span class="text-danger">*</span>'); ?>
                                <?= $form->field($model, 'lintang')->textInput(['value' => $data['lintang']])->label('Lintang') ?>
                                <?= $form->field($model, 'bujur')->textInput(['value' => $data['bujur']])->label('Bujur') ?>
                                <?= $form->field($model, 'alamat_jalan')->textarea(['value' => $data['alamat_jalan']]) ?>
                                <?= $form->field($model, 'kecamatan')->widget(Select2::classname(), [
                                    'data' => $dropdownDataKecamatan,
                                    'options' => [
                                        'placeholder' => '- Pilih Kecamatan -',
                                        'value' => $data['kecamatan'] ?? ''
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Kecamatan <span class="text-danger">*</span>'); ?>
                                <?= $form->field($model, 'desa_kelurahan')->textInput(['value' => $data['desa_kelurahan']])->label('Desa/Kelurahan <span class="text-danger">*</span>') ?>
                                <?= $form->field($model, 'kabupaten')->textInput(['value' => $data['kabupaten']])->label('Kabupaten/Kota <span class="text-danger">*</span>') ?>
                                <?= $form->field($model, 'provinsi')->textInput(['value' => $data['provinsi']])->label('Provinsi <span class="text-danger">*</span>') ?>
                                <?= $form->field($model, 'kode_pos')->textInput(['value' => $data['kode_pos']]) ?>
                                <?= $form->field($model, 'nomor_telepon')->textInput(['value' => $data['nomor_telepon']])->label('NO. Telepon <span class="text-danger">*</span>') ?>
                                <?= $form->field($model, 'email')->textInput(['type' => 'email','value' => $data['email']])->label('Email <span class="text-danger">*</span>') ?>
                                <?= $form->field($model, 'website')->textInput(['type' => 'url','value' => $data['website']]) ?>
                            </div>
                            <hr>
                            <div class="col-md-6">
                                <?= $form->field($model, 'akreditasi')->widget(Select2::classname(), [
                                    'data' => $dropdownDataAkreditasi,
                                    'options' => [
                                        'placeholder' => '- Pilih Akreditasi -',
                                        'value' => $data['akreditasi'] ?? ''
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Akreditasi <span class="text-danger">*</span>'); ?>
                                <?= $form->field($model, 'sk_pendirian_sekolah')->textInput(['value' => $data['sk_pendirian_sekolah']])->label('SK Pendirian <span class="text-danger">*</span>') ?>
                                <?= $form->field($model, 'tanggal_sk_pendirian')->textInput(['value' => $data['tanggal_sk_pendirian'], 'type' => 'date'])->label('Tanggal SK Pendirian <span class="text-danger">*</span>') ?>
                                <?= $form->field($model, 'status_kepemilikan')->widget(Select2::classname(), [
                                    'data' => $dropdownDataStatusKepemilikan,
                                    'options' => [
                                        'placeholder' => '- Pilih Status Kepemilikan -',
                                        'value' => $data['status_kepemilikan'] ?? ''
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Status Kepemilikan <span class="text-danger">*</span>'); ?>
                                <?= $form->field($model, 'yayasan')->textInput(['value' => $data['yayasan']])->label('Yayasan') ?>
                                <?= $form->field($model, 'sk_izin_operasional')->textInput(['value' => $data['sk_izin_operasional']])->label('SK Izin Operasional <span class="text-danger">*</span>') ?>
                                <?= $form->field($model, 'tanggal_sk_izin_operasional')->textInput(['value' => $data['tanggal_sk_izin_operasional'], 'type' => 'date'])->label('Tanggal SK Izin Operasional <span class="text-danger">*</span>') ?>
                            </div>
                            <hr>
                            <div class="col-md-6">
                                <?= $form->field($model, 'no_rekening')->textInput(['value' => $data['no_rekening']])->label('NO. Rekening <span class="text-danger">*</span>') ?>
                                <?= $form->field($model, 'rekening_atas_nama')->textInput(['value' => $data['rekening_atas_nama']])->label('Rekening Atas Nama <span class="text-danger">*</span>') ?>
                                <?= $form->field($model, 'nama_bank')->textInput(['value' => $data['nama_bank']])->label('Nama Bank <span class="text-danger">*</span>') ?>
                                <?= $form->field($model, 'cabang_kcp_unit')->textInput(['value' => $data['cabang_kcp_unit']])->label('Nama Cabang/KCP/Unit <span class="text-danger">*</span>') ?>
                                <?= $form->field($model, 'data_status')->widget(Select2::classname(), [
                                    'data' => [
                                                    0=>'Aktif',
                                                    1=>'Tutup',
                                                    2=>'Hapus Permanen'
                                                ],
                                    'options' => [
                                        'placeholder' => '- Pilih Status Sekolah -',
                                        'value' => $data['data_status'] ?? 0
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Status Keaktivan Sekolah <span class="text-danger">*</span>'); ?>
                            </div>
                            <hr>
                            <div class="form-group">
                                <?= Html::submitButton('Ubah', ['class' => 'btn btn-primary']) ?>
                                <a href="<?= Yii::$app->urlManager->createUrl(['/sekolah']) ?>" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>