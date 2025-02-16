<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
/** @var yii\web\View $this */
$this->title = 'DATA PTK';

// Ambil data filter dari tabel sekolah
$sekolahList = Yii::$app->db->createCommand("SELECT DISTINCT npsn, nama FROM sekolah ORDER BY nama")->queryAll();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
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
                            <label><b>Sekolah <span class="text-danger">*</span></b></label>
                            <?= Select2::widget([
                                'name' => 'id',
                                'data' => ArrayHelper::map($sekolahList, 'npsn', 'nama'),
                                'options' => ['placeholder' => '- Pilih Sekolah -'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
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
                <?php if (!empty($data)) : ?>
                    <table id="myTable_akg" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center">No</th>
                                <th rowspan="2" class="text-center">Mata Pelajaran</th>
                                <?php for ($i = 1; $i <= 9; $i++) : ?>
                                    <th colspan="3" class="text-center">Tingkat <?= $i ?></th>
                                <?php endfor; ?>
                                <th rowspan="2" class="text-center">Total Hasil</th>
                                <th rowspan="2" class="text-center">Rasio</th>
                                <th rowspan="2" class="text-center">Rasio Rounded</th>
                                <th colspan="4" class="text-center">Jumlah PTK (Existing)</th>
                                <th rowspan="2" class="text-center">Kebutuhan</th>
                                <th rowspan="2" class="text-center">Analisis</th>
                            </tr>
                            <tr>
                                <?php for ($i = 1; $i <= 9; $i++) : ?>
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
                            <?php $no = 1; ?>
                            <?php foreach ($data as $mapel) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= $mapel['nama_mapel'] ?></td>
                                    <?php foreach ($mapel['tingkat_pendidikan'] as $tingkat) : ?>
                                        <td class="text-center"><?= $tingkat['total_jam_mengajar'] ?? 0; ?></td>
                                        <td class="text-center"><?= $tingkat['jumlah_rombel'] ?></td>
                                        <td class="text-center"><?= $tingkat['total_jam_mengajar'] * ($tingkat['jumlah_rombel'] ?: 1) ?></td>
                                    <?php endforeach; ?>
                                    <td class="text-center"><?= $mapel['total_hasil'] ?></td> <!-- Total Hasil -->
                                    <td class="text-center"><?= number_format($mapel['rasio'], 4) ?></td> <!-- Rasio -->
                                    <td class="text-center"><?= $mapel['rasio_rounded'] ?></td> <!-- Rasio Rounded -->
                                    <td class="text-center"><?= $mapel['pns'] ?></td> <!-- PNS -->
                                    <td class="text-center"><?= $mapel['pppk'] ?></td> <!-- PPPK -->
                                    <td class="text-center"><?= $mapel['non_asn'] ?></td> <!-- NON ASN -->
                                    <td class="text-center"><?= $mapel['total_ptk'] ?></td> <!-- TOTAL -->
                                    <td class="text-center"><?= $mapel['rasio_rounded'] - $mapel['total_ptk'] ?></td> <!-- Kebutuhan -->
                                    <td>  <!-- Analisis -->
                                        <?php 
                                            $selisih = $mapel['rasio_rounded'] - $mapel['total_ptk'];
                                            if ($selisih > 0) {
                                                echo "Kurang $selisih PTK.";
                                            } elseif ($selisih < 0) {
                                                echo "Lebih " . abs($selisih) . " PTK.";
                                            } else {
                                                echo "Sudah Sesuai.";
                                            }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p class="text-center text-danger font-weight-bold">Tidak ada data atau anda belum memilih sekolah</p>
                <?php endif; ?>
            </div>

            <button class="btn btn-success" onclick="exportToExcel()"><i class="fa fa-download"></i> XLSX</button>
            <script>
                function exportToExcel() {
                    var table = document.getElementById("myTable_akg");
                    var ws = XLSX.utils.table_to_sheet(table);
                    var wb = XLSX.utils.book_new();
                    const range = XLSX.utils.decode_range(ws['!ref']);
                    for (let R = range.s.r; R <= range.e.r; ++R) {
                        for (let C = range.s.c; C <= range.e.c; ++C) {
                            const cellAddress = XLSX.utils.encode_cell({ r: R, c: C });
                            if (!ws[cellAddress]) continue;

                            ws[cellAddress].s = {
                                border: {
                                    top: { style: "bold", color: { rgb: "000000" } },
                                    bottom: { style: "bold", color: { rgb: "000000" } },
                                    left: { style: "bold", color: { rgb: "000000" } },
                                    right: { style: "bold", color: { rgb: "000000" } }
                                },
                                alignment: {
                                    horizontal: "center",
                                    vertical: "center"
                                }
                            };
                        }
                    }
                    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
                    var timestamp = Math.floor(Date.now() / 1000);
                    var filename = "AKG_ALDRIN TERPADU-" + timestamp + ".xlsx";
                    XLSX.writeFile(wb, filename);
                }
            </script>
        </section>
    </div>
</div>