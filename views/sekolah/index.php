<?php
/** @var yii\web\View $this */
$this->title = 'DATA SEKOLAH';

// Ambil data filter dari tabel sekolah
$bentukPendidikanList = Yii::$app->db->createCommand("SELECT DISTINCT bentuk_pendidikan FROM sekolah ORDER BY bentuk_pendidikan")->queryAll();
$kecamatanList = Yii::$app->db->createCommand("SELECT DISTINCT kecamatan FROM sekolah ORDER BY kecamatan")->queryAll();
$statusList = Yii::$app->db->createCommand("SELECT DISTINCT status_sekolah FROM sekolah ORDER BY status_sekolah")->queryAll();
?>

<div class="card">
    <div class="card-header">
    <div class="col-sm-12">
            <h1>
                <i class="fa fa-database icon-title"></i> DATA SEKOLAH
            </h1>
        </div>
    </div>
    <div class="card-body">
        <?php date_default_timezone_set("Asia/Jakarta"); ?>
        <section class="content">
            
            <!-- Form Filter -->
            <div class="row">
                <div class="col-md-6 text-left">
                    <h4><i class="fa fa-search"></i> FILTER</h4>
                </div>
            </div>
            
            <form method="GET">
                <div class="row">
                    <div class="row">
                        <div class="col-md-4">
                            <label><b>Bentuk Pendidikan</b></label>
                            <select name="bentuk_pendidikan" class="form-control">
                                <option value="">-- Pilih Bentuk Pendidikan --</option>
                                <?php foreach ($bentukPendidikanList as $bp) : ?>
                                    <option value="<?= htmlspecialchars($bp['bentuk_pendidikan']) ?>" 
                                        <?= isset($_GET['bentuk_pendidikan']) && $_GET['bentuk_pendidikan'] == $bp['bentuk_pendidikan'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($bp['bentuk_pendidikan']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label><b>Status Sekolah</b></label>
                            <select name="status" class="form-control">
                                <option value="">-- Pilih Status Sekolah --</option>
                                <?php foreach ($statusList as $sk) : ?>
                                    <option value="<?= htmlspecialchars($sk['status_sekolah']) ?>" 
                                        <?= isset($_GET['status']) && $_GET['status'] == $sk['status_sekolah'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($sk['status_sekolah']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label><b>Kecamatan</b></label>
                            <select name="kecamatan" class="form-control">
                                <option value="">-- Pilih Kecamatan --</option>
                                <?php foreach ($kecamatanList as $kc) : ?>
                                    <option value="<?= htmlspecialchars($kc['kecamatan']) ?>" 
                                        <?= isset($_GET['kecamatan']) && $_GET['kecamatan'] == $kc['kecamatan'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($kc['kecamatan']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-auto">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> CARI</button>
                        </div>
                    </div>
                </div>
            </form>

            <hr>

            <!-- Tabel Data PTK -->
            <div class="row mb-4">
                <div class="col-md-6 text-left">
                    <h4><i class="fa fa-school"></i> DAFTAR SEKOLAH</h4>
                </div>
                <div class="col-md-6 text-right">
                    <a href="<?= Yii::$app->urlManager->createUrl(['/sekolah/insert']) ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> DATA
                    </a>
                </div>
            </div>
            
            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">NO</th>
                            <th class="text-center">SEKOLAH</th>
                            <th class="text-center">BENTUK PENDIDIKAN</th>
                            <th class="text-center">STATUS SEKOLAH</th>
                            <th class="text-center">KECAMATAN</th>
                            <th class="text-center">STATUS KEAKTIFAN</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no=0; 
                            foreach ($data as $sekolah): 
                            $no++;
                            ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($no) ?></td>
                                <td class="text-left"><?= htmlspecialchars($sekolah['nama']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($sekolah['bentuk_pendidikan']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($sekolah['status_sekolah']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($sekolah['kecamatan']) ?></td>
                                <td class="text-center">
                                    <?= htmlspecialchars(
                                        ($sekolah['data_status'] === null || $sekolah['data_status'] == 0) ? 'Aktif' :
                                        ($sekolah['data_status'] == 1 ? 'Tutup' : 'Hapus Permanen')
                                    ) ?>
                                </td>

                                <td>
                                    <a class="btn btn-primary" href="<?= Yii::$app->urlManager->createUrl('sekolah?id='.htmlspecialchars($sekolah['npsn'])) ?>"><i class="fa fa-eye"></i></a>
                                    <?php
                                    if(Yii::$app->session->get('kode_akses')!=3){
                                        ?>
                                        <a class="btn btn-warning" href="<?= Yii::$app->urlManager->createUrl('sekolah/edit?id='.htmlspecialchars($sekolah['npsn'])) ?>"><i class="fa fa-edit"></i></a>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>