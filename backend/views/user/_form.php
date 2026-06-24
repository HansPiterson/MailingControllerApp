<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Divisi;
use yii\helpers\ArrayHelper;
use common\models\User;

$divisiList = ArrayHelper::map(Divisi::find()->all(), 'id', 'nama');
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'card shadow mb-4']
    ]); ?>
    
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= Html::encode($this->title) ?></h6>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'nama_lengkap')->textInput(['maxlength' => true]) ?>
            </div>
             <div class="col-md-6">
                <?= $form->field($model, 'password_hash')->passwordInput(['placeholder' => $model->isNewRecord ? '' : 'Kosongkan jika tidak ingin mengubah password'])->label($model->isNewRecord ? 'Password' : 'Ubah Password') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'divisi_id')->dropDownList($divisiList, ['prompt' => '- Pilih Divisi -']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'role')->dropDownList([
                    'admin' => 'Admin',
                    'operator' => 'Operator',
                    'divisi' => 'Staf Divisi',
                    'kurir' => 'Kurir',
                ], ['prompt' => '- Pilih Peran -']) ?>
            </div>
             <div class="col-md-4">
                <?= $form->field($model, 'status')->dropDownList([
                    User::STATUS_ACTIVE => 'Aktif',
                    User::STATUS_INACTIVE => 'Non-Aktif',
                ]) ?>
            </div>
        </div>
    </div>
    
    <div class="card-footer text-right">
        <?= Html::a('Batal', ['index'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Simpan Perubahan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
