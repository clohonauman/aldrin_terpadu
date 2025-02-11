<?php
/** @var yii\web\View $this */
$this->title = 'DATA PTK';

// Ambil data filter dari tabel sekolah
$bentukPendidikanList = Yii::$app->db->createCommand("SELECT DISTINCT bentuk_pendidikan FROM sekolah ORDER BY bentuk_pendidikan")->queryAll();
$kecamatanList = Yii::$app->db->createCommand("SELECT DISTINCT kecamatan FROM sekolah ORDER BY kecamatan")->queryAll();
?>

<div class="card">
    <div class="card-header">
    <div class="col-sm-12">
            <h1>
                <i class="fa fa-database icon-title"></i> DATA PTK
            </h1>
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
                        <div class="col-md-4">
                            <label><b>PENSIUN DALAM ... (TAHUN)</b></label>
                            <select name="pensiun" class="form-control">
                                <option value="">-- Pilih Tahun Kedepan --</option>
                                <?php 
                                    for ($i = 1; $i <= 5; $i++) {
                                        $selected = (isset($_GET['pensiun']) && $_GET['pensiun'] == $i) ? 'selected' : '';
                                        echo "<option value='$i' $selected>$i Tahun Kedepan</option>";
                                    }
                                ?>
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
                    <h4><i class="fa fa-user-tie"></i> DAFTAR PTK</h4>
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
                            <th>SEKOLAH</th>
                            <th>BENTUK PENDIDIKAN</th>
                            <th>STATUS SEKOLAH</th>
                            <th>KECAMATAN</th>
                            
                            <th>NAMA GURU</th>
                            <th>NIK</th>
                            <th>NUPTK</th>
                            <th>TGL LAHIR</th>
                            <th>USIA SEKARANG</th>
                            <th>STATUS KEPEGAWAIAN</th>
                            <th>JABATAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $ptk): ?>
                            <tr>
                                <td><?= htmlspecialchars($ptk['nama_sekolah']) ?></td>
                                <td><?= htmlspecialchars($ptk['bentuk_pendidikan']) ?></td>
                                <td><?= htmlspecialchars($ptk['status_sekolah']) ?></td>
                                <td><?= htmlspecialchars($ptk['kecamatan']) ?></td>

                                <td><?= htmlspecialchars($ptk['nama']) ?></td>
                                <td><?= htmlspecialchars($ptk['nik']) ?></td>
                                <td><?= htmlspecialchars($ptk['nuptk']) ?></td>
                                <td><?= htmlspecialchars($ptk['tanggal_lahir']) ?></td>
                                <td><?= htmlspecialchars($ptk['usia_sekarang']) ?></td>
                                <td><?= htmlspecialchars($ptk['status_kepegawaian']) ?></td>
                                <td><?= htmlspecialchars($ptk['jabatan']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>