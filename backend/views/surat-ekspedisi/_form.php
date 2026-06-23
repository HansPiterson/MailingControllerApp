<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\SuratEkspedisi $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="surat-ekspedisi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uuid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nomor_surat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'divisi_pengirim_id')->textInput() ?>

    <?= $form->field($model, 'divisi_tujuan_id')->textInput() ?>

    <?= $form->field($model, 'nama_tujuan_orang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_surat')->textInput() ?>

    <?= $form->field($model, 'perihal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_penerima')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_penerimaan')->textInput() ?>

    <?= $form->field($model, 'foto_bukti')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'foto_alamat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'foto_latitude')->textInput() ?>

    <?= $form->field($model, 'foto_longitude')->textInput() ?>

    <?= $form->field($model, 'foto_hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
