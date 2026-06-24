<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="divisi-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'card shadow mb-4']
    ]); ?>
    
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= Html::encode($this->title) ?></h6>
    </div>
    
    <div class="card-body">
        <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="card-footer text-right">
        <?= Html::a('Batal', ['index'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Simpan Perubahan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
