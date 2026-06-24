<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Divisi;
use yii\helpers\ArrayHelper;
use common\models\SuratEkspedisi;

/** @var yii\web\View $this */
/** @var common\models\SuratEkspedisi $model */
/** @var yii\widgets\ActiveForm $form */

$divisiList = ArrayHelper::map(Divisi::find()->where(['is_active' => true])->all(), 'id', 'nama_divisi');
$statusList = array_combine(SuratEkspedisi::statuses(), SuratEkspedisi::statuses());
?>

<div class="surat-ekspedisi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nomor_surat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_surat')->widget(\yii\jui\DatePicker::class, [
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?= $form->field($model, 'perihal')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'divisi_pengirim_id')->dropDownList($divisiList, ['prompt' => 'Pilih Divisi Pengirim']) ?>

    <?= $form->field($model, 'divisi_tujuan_id')->dropDownList($divisiList, ['prompt' => 'Pilih Divisi Tujuan']) ?>

    <?= $form->field($model, 'nama_tujuan_orang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList($statusList, ['prompt' => 'Pilih Status']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
