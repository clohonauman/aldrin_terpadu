<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'EDIT PROFIL';
?>
<div class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="card-header">
                <div class="col-sm-12">
                    <h1>
                        <i class="fa fa-user-cog icon-title"></i> EDIT PROFIL
                    </h1>
                </div>
            </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>
                        <div class="col-md-6">
                            <?= $form->field($akun, 'nama_lengkap')->textInput([
                                    'value' => $data['nama_lengkap'],
                                    'readonly' => true
                                ])->label('Nama Lengkap') 
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($akun, 'nama_pengguna')->textInput([
                                    'value' => $data['nama_pengguna'],
                                    'readonly' => false
                                ])->label('Nama Pengguna <span class="text-danger">*</span>') 
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($akun, 'email')->textInput([
                                    'type' => 'email',
                                    'value' => $data['email'],
                                    'readonly' => false
                                ])->label('Email <span class="text-danger">*</span>') 
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($akun, 'kata_sandi')->textInput([
                                    'type' => 'text',
                                    'placeholder' => 'Kosongkan saja bila tidak ingin merubah',
                                    'readonly' => false
                                ])->label('Kata Sandi') 
                            ?>
                        </div>
                        <hr>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
                                <a class="btn btn-secondary" href="<?= Yii::$app->urlManager->createUrl(['/profil']) ?>">Batal</a>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
        </div>
    </div>
</div>
