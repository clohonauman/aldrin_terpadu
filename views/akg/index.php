<?php
/** @var yii\web\View $this */
$this->title = 'DATA PTK';

// Ambil data filter dari tabel sekolah
$sekolahList = Yii::$app->db->createCommand("SELECT DISTINCT npsn, nama FROM sekolah ORDER BY nama")->queryAll();
?>

<div class="card">
    <div class="card-header">
    <div class="col-sm-12">
            <h1>
                <i class="fa fa-graphic icon-title"></i> ANALISIS KEBUTUHAN GURU
            </h1>
        </div>
    </div>
    <div class="card-body">
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
                            <label><b>Sekolah</b></label>
                            <select name="id" class="form-control">
                                <option value="">-- Pilih Sekolah --</option>
                                <?php foreach ($sekolahList as $bp) : ?>
                                    <option value="<?= htmlspecialchars($bp['npsn']) ?>" 
                                        <?= isset($_GET['npsn']) && $_GET['npsn'] == $bp['npsn'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($bp['nama']) ?>
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
        <?php date_default_timezone_set("Asia/Jakarta"); ?>
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="card alert alert-danger alert-dismissable">
                        <b><i class="fa fa-warning"></i> Perhatian!</b>
                        <p style="font-size:15px">
                            Pada bagian ini ditampilkan data Analisis Kebutuhan Guru sesuai Data Pembelajaran yang telah dimasukkan oleh operator sekolah. 
                            Jika terdapat data yang tidak lengkap, harap meminta pihak sekolah untuk segera 
                            melengkapinya. Terima kasih.
                        </p>        
                    </div>
                </div>
            </div>
            <hr>
            <!-- Tabel Data PTK -->
            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Mata Pelajaran</th>
                            <?php for ($kelas = 1; $kelas <= 9; $kelas++): ?>
                                <th colspan="3" class="text-center">Tingkat <?= $kelas ?></th>
                            <?php endfor; ?>
                            <th rowspan="2">Rasio</th>
                            <th rowspan="2">Rasio Rounded</th>
                            <th colspan="4" class="text-center">Jumlah PTK (Existing)</th>
                            <th rowspan="2">Kebutuhan</th>
                            <th rowspan="2">Analisis</th>
                        </tr>
                        <tr>
                            <?php for ($kelas = 1; $kelas <= 9; $kelas++): ?>
                                <th>JJM</th>
                                <th>ROMBEL</th>
                                <th>HASIL</th>
                            <?php endfor; ?>
                            <th>PNS</th>
                            <th>PPPK</th>
                            <th>NON ASN</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach ($data as $mapel): 
                            $mataPelajaranId = $mapel['mata_pelajaran_id'];
                            $totalHasil = 0;
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $mapel['nama_mapel'] ?></td>

                                <?php for ($kelas = 1; $kelas <= 9; $kelas++): 
                                    $jjm = $mapel['jam_mengajar_per_minggu'] ?? 0;
                                    $rombel = $rombelData[$kelas][$mataPelajaranId]['jumlah_rombel'] ?? 0;
                                    $hasil = $jjm * $rombel;
                                    $totalHasil += $hasil;
                                ?>
                                    <td><?= $jjm ?></td>
                                    <td><?= $rombel ?></td>
                                    <td><?= $hasil ?></td>
                                <?php endfor; ?>

                                <?php 
                                $rasio = $totalHasil / 24;
                                $rasioRounded = round($rasio);

                                // Pastikan data PTK tidak duplikasi
                                $ptk = $ptkData[$mataPelajaranId] ?? ['pns' => 0, 'pppk' => 0, 'non_asn' => 0, 'total_ptk' => 0];
                                $kebutuhan = $rasioRounded - $ptk['total_ptk'];
                                ?>

                                <td><?= number_format($rasio, 2) ?></td>
                                <td><?= $rasioRounded ?></td>

                                <td><?= $ptk['pns'] ?></td>
                                <td><?= $ptk['pppk'] ?></td>
                                <td><?= $ptk['non_asn'] ?></td>
                                <td><?= $ptk['total_ptk'] ?></td>

                                <td><?= $kebutuhan ?></td>
                                <td class="<?= ($kebutuhan < 0) ? 'text-success' : 'text-danger' ?>">
                                    <?= ($kebutuhan < 0) ? 
                                        "Kelebihan " . abs($kebutuhan) . " PTK" : 
                                        "Kekurangan " . $kebutuhan . " PTK" ?>
                                </td>
                            </tr>
                            <?php 
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>