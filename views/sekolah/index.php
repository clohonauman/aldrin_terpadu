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
                    <a href="<?= Yii::$app->urlManager->createUrl(['/ptk/upload']) ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> DATA
                    </a>
                </div>
            </div>
            
            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>NO</th>

                            <th>SEKOLAH</th>
                            <th>BENTUK PENDIDIKAN</th>
                            <th>STATUS SEKOLAH</th>
                            <th>KECAMATAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no=0; 
                            foreach ($data as $ptk): 
                            $no++;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($no) ?></td>
                                <td><?= htmlspecialchars($ptk['nama']) ?></td>
                                <td><?= htmlspecialchars($ptk['bentuk_pendidikan']) ?></td>
                                <td><?= htmlspecialchars($ptk['status_sekolah']) ?></td>
                                <td><?= htmlspecialchars($ptk['kecamatan']) ?></td>
                                <td><a class="btn btn-primary" href="<?= Yii::$app->urlManager->createUrl('sekolah?id='.htmlspecialchars($ptk['npsn'])) ?>"><i class="fa fa-eye"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>