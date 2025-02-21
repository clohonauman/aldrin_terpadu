<?php
/** @var yii\web\View $this */
$this->title='BERANDA';

$session = Yii::$app->session;
$session->open();
?>
<div class="card">
    <div class="card-header">
        <div class="col-sm-12">
            <h1>
                <i class="fa fa-home icon-title"></i> Beranda
            </h1>
        </div>
    </div>
    <div class="card-body ">
        <script type="text/javascript">
            window.onload = function() { jam(); }

            var days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

            function jam() {
                var e = document.getElementById('jam'),
                    d = new Date(),
                    h = set(d.getHours()),
                    m = set(d.getMinutes()),
                    s = set(d.getSeconds()),
                    dayName = days[d.getDay()],
                    day = set(d.getDate()),
                    monthName = months[d.getMonth()],
                    year = d.getFullYear();

                var formattedTime = dayName + ', ' + day + ' ' + monthName + ' ' + year + ' ' + h + ':' + m + ':' + s;

                e.innerHTML = formattedTime;

                setTimeout(jam, 1000);
            }

            function set(e) {
                e = e < 10 ? '0'+ e : e;
                return e;
            }
        </script>
        <?php date_default_timezone_set("Asia/jakarta"); ?>
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="card alert alert-default bg-white alert-dismissable">
                        <span id="jam"></span>
                        <p style="font-size:15px">
                            Selamat datang <?= $session->get('nama_lengkap')?> di <?= $_ENV['APP_NAME'] ?></strong>.
                        </p>        
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Charlie</td>
                                <td>charlie@example.com</td>
                                <td>Manado</td>
                            </tr>
                            <tr>
                                <td>Adi</td>
                                <td>adi@example.com</td>
                                <td>Jakarta</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> -->
        </section>
    </div>
</div>
