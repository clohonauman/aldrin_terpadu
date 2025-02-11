<?php
/** @var yii\web\View $this */
$this->title = 'DATA SEKOLAH';

// Ambil data filter dari tabel sekolah
$bentukPendidikanList = Yii::$app->db->createCommand("SELECT DISTINCT bentuk_pendidikan FROM sekolah ORDER BY bentuk_pendidikan")->queryAll();
$kecamatanList = Yii::$app->db->createCommand("SELECT DISTINCT kecamatan FROM sekolah ORDER BY kecamatan")->queryAll();
?>

<div class="card">
    <div class="row card-header">
        <div class="col-sm-6 text-left">
            <h1>
                <i class="fa fa-school icon-title"></i> DETAIL DATA SEKOLAH
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
                        <h5><i class="fa fa-map-marker"></i> Lokasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="mapouter">
                            <?php $location=$data['lintang'].','.$data['bujur'];?>
                            <div class="gmap_canvas"><iframe class="gmap_iframe" width="100%" height='900' frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?hl=id&amp;q=<?=$location?>&amp;t=k&amp;z=17&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe></div>
                            <style>
                                .mapouter {
                                    position: relative;
                                    text-align: right;
                                    width: 100%;
                                    height: 512px;
                                }

                                .gmap_canvas {
                                    overflow: hidden;
                                    background: none !important;
                                    width: 100%;
                                    height: 512px;
                                }

                                .gmap_iframe {
                                    height: 512px !important;
                                }
                            </style>
                        </div>
                    </div>
                    <div class="card-header">
                        <h5><i class="fa fa-school"></i> Data Sekolah</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6">
                            <p><b>NPSN:</b> <?= $data['npsn'] ?></p>
                            <p><b>Nama Sekolah:</b> <?= $data['nama'] ?></p>
                            <p><b>Bentuk Pendidikan:</b> <?= $data['bentuk_pendidikan'] ?></p>
                            <p><b>Status Sekolah:</b> <?= $data['status_sekolah'] ?></p>
                            <p><b>Alamat:</b> <?= $data['alamat_jalan'] ?></p>
                            <p><b>Kecamatan:</b> <?= $data['kecamatan'] ?></p>
                            <p><b>Desa/Kelurahan:</b> <?= $data['desa_kelurahan'] ?></p>
                            <p><b>Kabupaten/Kota:</b> <?= $data['kabupaten'] ?></p>
                            <p><b>Provinsi:</b> <?= $data['provinsi'] ?></p>
                            <p><b>Kode Pos:</b> <?= $data['kode_pos'] ?></p>
                            <p><b>Nomor Telepon:</b> <?= $data['nomor_telepon'] ?></p>
                            <p><b>Email:</b> <?= $data['email'] ?></p>
                            <p><b>Website:</b> <?= $data['website'] ?></p>
                        </div>
                        <hr>
                        <div class="col-md-6">
                            <p><b>Akreditasi:</b> <?= $data['akreditasi'] ?></p>
                            <p><b>SK Pendirian:</b> <?= $data['sk_pendirian_sekolah'] ?></p>
                            <p><b>Tanggal SK Pendirian:</b> <?= $data['tanggal_sk_pendirian'] ?></p>
                            <p><b>Status Kepemilikan:</b> <?= $data['status_kepemilikan'] ?></p>
                            <p><b>Yayasan:</b> <?= $data['yayasan'] ?></p>
                            <p><b>SK Izin Operasional:</b> <?= $data['sk_izin_operasional'] ?></p>
                            <p><b>Tanggal SK Izin Operasional:</b> <?= $data['tanggal_sk_izin_operasional'] ?></p>
                        </div>
                        <hr>
                        <div class="col-md-6">
                            <p><b>Nomor Rekening:</b> <?= $data['no_rekening'] ?></p>
                            <p><b>Rekening Atas Nama:</b> <?= $data['rekening_atas_nama'] ?></p>
                            <p><b>Bank:</b> <?= $data['nama_bank'] ?></p>
                            <p><b>Cabang/KCP Unit:</b> <?= $data['cabang_kcp_unit'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>