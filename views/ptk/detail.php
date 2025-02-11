<?php
/** @var yii\web\View $this */
$this->title = 'DATA PTK';

// Ambil data filter dari tabel sekolah
$bentukPendidikanList = Yii::$app->db->createCommand("SELECT DISTINCT bentuk_pendidikan FROM sekolah ORDER BY bentuk_pendidikan")->queryAll();
$kecamatanList = Yii::$app->db->createCommand("SELECT DISTINCT kecamatan FROM sekolah ORDER BY kecamatan")->queryAll();
?>

<div class="card">
    <div class="row card-header">
        <div class="col-sm-6 text-left">
            <h1>
                <i class="fa fa-user-tie icon-title"></i> DETAIL DATA PTK
            </h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="<?= Yii::$app->urlManager->createUrl(['/ptk']) ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> KEMBALI</a>
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
                            Pada bagian ini ditampilkan data PTK yang telah dimasukkan oleh pihak sekolah. 
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
                            <p><b>NIK:</b> <?= $data['nik'] ?></p>
                            <p><b>No. KK:</b> <?= $data['no_kk'] ?></p>
                            <p><b>Nama Lengkap:</b> <?= $data['nama'] ?></p>
                            <p><b>Jenis Kelamin:</b> <?= $data['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></p>
                            <p><b>Tempat, Tanggal Lahir:</b> <?= $data['tempat_lahir'] ?>, <?= $data['tanggal_lahir'] ?></p>
                            <p><b>Agama:</b> <?= $data['agama'] ?></p>
                            <p><b>Kewarganegaraan:</b> <?= $data['kewarganegaraan'] ?></p>
                            <p><b>Alamat:</b> <?= $data['alamat_jalan'] ?>, RT <?= $data['rt'] ?>, RW <?= $data['rw'] ?></p>
                            <p><b>Desa/Kelurahan:</b> <?= $data['desa_kelurahan'] ?></p>
                            <p><b>Kecamatan:</b> <?= $data['kecamatan'] ?></p>
                            <p><b>Kabupaten:</b> <?= $data['kabupaten'] ?></p>
                            <p><b>Provinsi:</b> <?= $data['provinsi'] ?></p>
                            <p><b>Kode Pos:</b> <?= $data['kode_pos'] ?></p>
                            <p><b>Status Perkawinan:</b> <?= $data['status_perkawinan'] ?></p>
                            <p><b>Nama Suami/Istri:</b> <?= $data['nama_suami_istri'] ?></p>
                            <p><b>Pekerjaan Suami/Istri:</b> <?= $data['pekerjaan_suami_istri'] ?></p>
                            <p><b>NPWP:</b> <?= $data['npwp'] ?></p>
                            <p><b>No HP:</b> <?= $data['no_hp'] ?></p>
                            <p><b>Email:</b> <?= $data['email'] ?></p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="card-header">
                        <h5><i class="fa fa-user-tie"></i> DATA KEPEGAWAIAN</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6">
                            <p><b>NIP/NIPPPK:</b> <?= $data['nip'] ?></p>
                            <p><b>Pangkat Golongan:</b> <?= $data['pangkat_golongan'] ?></p>
                            <p><b>SK CPNS:</b> <?= $data['sk_cpns'] ?></p>
                            <p><b>Tanggal CPNS:</b> <?= $data['tgl_cpns'] ?></p>
                            <p><b>SK Pengangkatan:</b> <?= $data['sk_pengangkatan'] ?></p>
                            <p><b>TMT Pengangkatan:</b> <?= $data['tmt_pengangkatan'] ?></p>
                            <p><b>Status Kepegawaian:</b> <?= $data['status_kepegawaian'] ?></p>
                            <p><b>Jenis PTK:</b> <?= $data['jenis_ptk'] ?></p>
                            <p><b>Bank:</b> <?= $data['bank'] ?> - <?= $data['rekening_bank'] ?> (<?= $data['rekening_atas_nama'] ?>)</p>
                            <p><b>Tahun Ajaran:</b> <?= $data['tahun_ajaran'] ?></p>
                            <p><b>PTK Induk:</b> <?= $data['ptk_induk'] ?></p>
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>