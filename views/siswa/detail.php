<?php
/** @var yii\web\View $this */
$this->title = 'DATA SISWA';
$statusList = [
    '1' => 'Aktif',
    '2' => 'Putus Sekolah',
    '3' => 'Meninggal Dunia',
    '4' => 'Berhenti Tanpa Alasan',
    '5' => 'Pindah/Mutasi',
];
$statusText = $statusList[$data['status']] ?? 'Tidak Diketahui';
?>

<div class="card">
    <div class="row card-header">
        <div class="col-sm-6 text-left">
            <h1>
                <i class="fa fa-user-tie icon-title"></i> DETAIL DATA SISWA
            </h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="<?= Yii::$app->urlManager->createUrl(['/siswa']) ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> KEMBALI</a>
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
                            Pada bagian ini ditampilkan data Siswa yang telah dimasukkan oleh pihak sekolah. 
                            Jika terdapat data yang tidak lengkap, harap meminta pihak sekolah untuk segera 
                            melengkapinya. Terima kasih.
                        </p>        
                    </div>
                </div>
            </div>
            <hr>
            <!-- Tabel Data PTK -->
            <div class="card-body">
                <div class="row">
                    <div class="card-header">
                        <h5><i class="fa fa-user"></i> DATA PRIBADI</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6">
                            <p><b>NISN:</b> <?= $data['nisn'] ?></p>
                            <p><b>NIK:</b> <?= $data['nik'] ?></p>
                            <p><b>Nomor KK:</b> <?= $data['no_kk'] ?></p>
                            <p><b>Nama Lengkap:</b> <?= $data['nama'] ?></p>
                            <p><b>Jenis Kelamin:</b> <?= $data['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></p>
                            <p><b>Tempat, Tanggal Lahir:</b> <?= $data['tempat_lahir'] ?>, <?= $data['tanggal_lahir'] ?></p>
                            <p><b>Desa/Kelurahan:</b> <?= $data['desa_kelurahan'] ?></p>
                            <p><b>Kecamatan:</b> <?= $data['kecamatan'] ?></p>
                            <p><b>Kabupaten:</b> <?= $data['kabupaten'] ?></p>
                            <p><b>Provinsi:</b> <?= $data['provinsi'] ?></p>
                            <p><b>Nama Ibu Kandung:</b> <?= $data['nama_ibu_kandung'] ?></p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="card-header">
                        <h5><i class="fa fa-school"></i> DATA SEKOLAH</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6">
                            <p><b>Nama Sekolah:</b> <?= $data['nama_sekolah'] ?> <a class="btn btn-primary" href="<?= Yii::$app->urlManager->createUrl(['/sekolah?id='.$data['npsn']]) ?>"><i class="fa fa-eye"></i></a></p>
                            <p><b>Tingkat Pendidikan:</b> <?= $data['tingkat_pendidikan'] ?></p>
                            <p><b>Status:</b> <?= $statusText ?></p>
                            <p><b>Ditambahkan pada :</b> <?= date('d-m-Y H:i:s', $data['created_at']) ?></p>
                            <p><b>Terakhir di ubah pada :</b> <?= date('d-m-Y H:i:s', $data['updated_at']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>