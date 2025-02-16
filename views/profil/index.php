<?php
use yii\helpers\Html;

$this->title = 'PROFIL';
// Fungsi untuk menentukan jabatan berdasarkan kode_akses
function getJabatan($kodeAkses= null) {
    switch ($kodeAkses) {
        case 0:
            return "Super Admin";
        case 2:
            return "Admin";
        case 3:
            return "Operator Sekolah";
        default:
            return "Tidak Diketahui";
    }
}
?>

<div class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="card-header">
                <div class="col-sm-12">
                    <h1>
                        <i class="fa fa-user-cog icon-title"></i> PENGATURAN PROFIL - <a href="<?= Yii::$app->urlManager->createUrl(['/profil/update']) ?>" title="Edit Profil"><i class="fa fa-edit"></i></a>
                    </h1>
                </div>
            </div>
            <div class="card-body">
                <?php if ($data): ?>
                    <p><strong>Nama Lengkap:</strong> <?= Html::encode($data['nama_lengkap']) ?></p>
                    <p><strong>Nama Pengguna:</strong> <?= Html::encode($data['nama_pengguna']) ?></p>
                    <p><strong>Email:</strong> <?= Html::encode($data['email']) ?></p>
                    <p><strong>Status:</strong> <?= $data['status'] ?></p>
                    <hr>
                    <?php if (!empty($data['peran'])): ?>
                        <p><strong>Jabatan:</strong> <?=getJabatan($data['peran']['kode_akses']); ?></p>
                        <p><strong>Sekolah:</strong> <?= $data['peran']['nama_sekolah'] ?  $data['peran']['id_sekolah'] .'-'. $data['peran']['nama_sekolah'] : '-'; ?></p>
                    <?php else: ?>
                        <p class="text-muted">Belum memiliki peran.</p>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="text-center text-danger">Data tidak ditemukan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
