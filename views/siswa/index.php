<?php
/** @var yii\web\View $this */
$this->title = 'DATA SISWA';

// Ambil data filter dari tabel sekolah
$bentukPendidikanList = Yii::$app->db->createCommand("SELECT DISTINCT bentuk_pendidikan FROM sekolah ORDER BY bentuk_pendidikan")->queryAll();
$kecamatanList = Yii::$app->db->createCommand("SELECT DISTINCT kecamatan FROM sekolah ORDER BY kecamatan")->queryAll();
$jkList = Yii::$app->db->createCommand("SELECT DISTINCT jenis_kelamin FROM siswa")->queryAll();

$statusList = [
    '1' => 'Aktif',
    '2' => 'Putus Sekolah',
    '3' => 'Meninggal Dunia',
    '4' => 'Berhenti Tanpa Alasan',
    '5' => 'Pindah/Mutasi',
];

?>

<div class="card">
    <div class="card-header">
    <div class="col-sm-12">
            <h1>
                <i class="fa fa-database icon-title"></i> DATA SISWA
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
                            Pada bagian ini ditampilkan data Siswa yang telah dimasukkan oleh pihak Sekolah. 
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
                    <?php
                    if (Yii::$app->session->get('kode_akses')!=3) {
                        ?>
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
                        <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            <label><b>Jenis Kelamin</b></label>
                            <select name="jenis_kelamin" class="form-control">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <?php foreach ($jkList as $jk) : ?>
                                    <option value="<?= htmlspecialchars($jk['jenis_kelamin']) ?>" 
                                        <?= isset($_GET['jenis_kelamin']) && $_GET['jenis_kelamin'] == $jk['jenis_kelamin'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($jk['jenis_kelamin']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label><b>Status</b></label>
                            <select name="status" class="form-control">
                                <option value="">-- Pilih Status --</option>
                                <?php 
                                    foreach ($statusList as $key => $label) {
                                        $selected = (isset($_GET['status']) && $_GET['status'] == $key) ? 'selected' : '';
                                        echo "<option value='$key' $selected>$label</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label><b>Usia > ... Tahun</b></label>
                            <input  class="form-control" type="number" name="usia" value="<?= $_GET['usia'] ?? null ?>">
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
                    <h4><i class="fa fa-graduation-cap"></i> DAFTAR SISWA</h4>
                </div>
                <div class="col-md-6 text-right">
                    <?php
                    if (Yii::$app->session->get('kode_akses')==3) {
                        ?>
                        <a href="<?= Yii::$app->urlManager->createUrl(['/siswa/upload']) ?>" class="btn btn-success">
                            <i class="fa fa-plus"></i> IMPORT EXCEL
                        </a>
                        <a href="<?= Yii::$app->urlManager->createUrl(['/siswa/insert']) ?>" class="btn btn-primary">
                            <i class="fa fa-plus"></i> DATA MANUAL
                        </a>
                        <?php
                    }
                    ?>
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
                            
                            <th>NAMA SISWA</th>
                            <th>L/P</th>
                            <th>NIK</th>
                            <th>NISN</th>
                            <th>TGL LAHIR</th>
                            <th>USIA SEKARANG</th>
                            <th>TINGKAT PENDIDIKAN</th>
                            <th>STATUS SISWA</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no=0; 
                            foreach ($data as $siswa): 
                            $statusText = $statusList[$siswa['status']] ?? 'Tidak Diketahui';
                            $no++;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($no ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($siswa['nama_sekolah'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($siswa['bentuk_pendidikan'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($siswa['status_sekolah'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($siswa['kecamatan'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>

                                <td><?= htmlspecialchars($siswa['nama'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($siswa['jenis_kelamin'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($siswa['nik'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($siswa['nisn'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($siswa['tanggal_lahir'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($siswa['usia_sekarang'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($siswa['tingkat_pendidikan'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($statusText, ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <?php
                                    if (Yii::$app->session->get('kode_akses')==3 AND $siswa['status']==1) {
                                        ?>
                                        <a class="btn btn-primary" href="<?= Yii::$app->urlManager->createUrl('siswa?id='.htmlspecialchars($siswa['siswa_id'] ?? '', ENT_QUOTES, 'UTF-8')) ?>"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-warning" href="<?= Yii::$app->urlManager->createUrl('siswa/edit?id='.htmlspecialchars($siswa['siswa_id'] ?? '', ENT_QUOTES, 'UTF-8')) ?>"><i class="fa fa-edit"></i></a>
                                        <?php
                                    }else{
                                        ?>
                                        <a class="btn btn-primary" href="<?= Yii::$app->urlManager->createUrl('siswa?id='.htmlspecialchars($siswa['siswa_id'] ?? '', ENT_QUOTES, 'UTF-8')) ?>"><i class="fa fa-eye"></i></a>
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