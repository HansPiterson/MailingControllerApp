<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Divisi;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */

// Ambil data divisi untuk dropdown
$divisiList = ArrayHelper::map(Divisi::find()->where(['is_active' => true])->all(), 'id', 'nama_divisi');

// Definisikan role yang tersedia
$roleList = [
    'admin' => 'Admin',
    'operator' => 'Operator',
    'divisi' => 'Divisi',
    'kurir' => 'Kurir',
];
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true, 'value' => '', 'placeholder' => 'Isi hanya jika ingin mengubah password'])->label('Password') ?>

    <?= $form->field($model, 'divisi_id')->dropDownList($divisiList, ['prompt' => 'Pilih Divisi']) ?>

    <?= $form->field($model, 'role')->dropDownList($roleList, ['prompt' => 'Pilih Role']) ?>

    <?= $form->field($model, 'status')->dropDownList([
        $model::STATUS_ACTIVE => 'Active',
        $model::STATUS_INACTIVE => 'Inactive',
        $model::STATUS_DELETED => 'Deleted',
    ], ['prompt' => 'Pilih Status']) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
