<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="divisi-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'card shadow mb-4']]); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'kode_divisi')->textInput(['maxlength' => true, 'placeholder' => 'Contoh: IT, HRD']) ?>
            </div>
            <div class="col-md-8">
                <?= $form->field($model, 'nama_divisi')->textInput(['maxlength' => true, 'placeholder' => 'Nama Lengkap Divisi']) ?>
            </div>
        </div>
        <?= $form->field($model, 'is_active')->checkbox() ?>
    </div>
    <div class="card-footer text-end">
        <?= Html::a('Batal', ['index'], ['class' => 'btn btn-secondary me-2']) ?>
        <?= Html::submitButton('Simpan Data', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
