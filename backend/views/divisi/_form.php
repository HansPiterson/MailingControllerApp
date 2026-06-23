<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/** @var yii\web\View $this */
/** @var common\models\Divisi $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="divisi-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'kode_divisi')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nama_divisi')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'is_active')->checkbox() ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
