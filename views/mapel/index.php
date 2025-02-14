<?php

use yii\helpers\Html;
use yii\helpers\Url;



/** @var yii\web\View $this */
/** @var app\models\MataPelajaranSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Daftar Mata Pelajaran';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header">
        <div class="col-sm-12">
            <h1>
                <i class="fa fa-database icon-title"></i> Data Mata Pelajaran
            </h1>
        </div>
    </div>
    <div class="card-body">
        <?php date_default_timezone_set("Asia/Jakarta"); ?>
        <!-- Tabel Data PTK -->
        <div class="row mb-4">
            <div class="col-md-6 text-left">
                <h4><i class="fa fa-book"></i> Daftar Mata Pelajaran</h4>
            </div>
            <div class="col-md-6 text-right">
                <a href="<?= Yii::$app->urlManager->createUrl(['/mapel/create']) ?>" class="btn btn-primary">
                    <i class="fa fa-plus"></i> DATA
                </a>
            </div>
        </div>
        <hr>

        <div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>MATA PELAJARAN</th>
                            <th>JAM PELAJARAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data as $mapel):
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $mapel['mata_pelajaran'] ?></td>
                                <td><?= $mapel['jam_pelajaran'] ?></td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="<?= Yii::$app->urlManager->createUrl(['/mapel/update', 'id' => $mapel['id']]) ?>" class="btn btn-warning">Edit</a>
                                        <?= Html::beginForm(Url::to(['mapel/delete', 'id' => $mapel['id']]), 'post') ?>
                                        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</button>
                                        <?= Html::endForm() ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>