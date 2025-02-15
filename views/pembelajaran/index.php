<?php
/** @var yii\web\View $this */
$this->title = 'DATA PEMBELAJARAN';

// Ambil data filter dari tabel sekolah
$bentukPendidikanList = Yii::$app->db->createCommand("SELECT DISTINCT bentuk_pendidikan FROM sekolah ORDER BY bentuk_pendidikan")->queryAll();
$kecamatanList = Yii::$app->db->createCommand("SELECT DISTINCT kecamatan FROM sekolah ORDER BY kecamatan")->queryAll();
?>

<div class="card">
    <div class="card-header">
    <div class="col-sm-12">
            <h1>
                <i class="fa fa-database icon-title"></i> DATA PEMBELAJARAN
            </h1>
        </div>
    </div>
    <div class="card-body">
        <?php date_default_timezone_set("Asia/Jakarta"); ?>
        <section class="content">
            
            <?php
            if(Yii::$app->session->get('kode_akses')!=3){
                ?>
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
                            <div class="col-md-auto">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> CARI</button>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>
                <?php
            }
            ?>

            <!-- Tabel Data Rombel -->
            <div class="row mb-4">
                <div class="col-md-6 text-left">
                    <h4><i class="fa fa-book"></i> DAFTAR PEMBELAJARAN</h4>
                </div>
                <?php
                if(Yii::$app->session->get('kode_akses')==3){
                    ?>
                    <div class="col-md-6 text-right">
                        <a href="<?= Yii::$app->urlManager->createUrl(['/pembelajaran/insert']) ?>" class="btn btn-primary">
                            <i class="fa fa-plus"></i> DATA
                        </a>
                    </div>
                    <?php
                }
                ?>
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
                            
                            <th>NAMA ROMBEL</th>
                            <th>MAATA PELAJARAN</th>
                            <th>NAMA PTK PENGAJAR</th>
                            <th>JAM MENGAJAR / MINGGU</th>
                            <th>JUMLAH ANGGOTA (SESUAI ROMBEL)</th>
                            <th>TINGKAT PENDIDIKAN (SESUAI ROMBEL)</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no=0; 
                            foreach ($data as $pembelajaran): 
                            $no++;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($no ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($pembelajaran['nama_sekolah'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($pembelajaran['bentuk_pendidikan'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($pembelajaran['status_sekolah'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($pembelajaran['kecamatan'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>

                                <td><?= htmlspecialchars($pembelajaran['nama_rombel'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($pembelajaran['mata_pelajaran'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($pembelajaran['nama_ptk'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($pembelajaran['jam_mengajar_per_minggu'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($pembelajaran['jumlah_anggota_rombel'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($pembelajaran['tingkat_pendidikan'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <a class="btn btn-primary" href="<?= Yii::$app->urlManager->createUrl('pembelajaran?id='.htmlspecialchars($pembelajaran['rombongan_belajar_id'] ?? '', ENT_QUOTES, 'UTF-8')) ?>"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>