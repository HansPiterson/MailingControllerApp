<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SuratEkspedisi $model */

$this->title = 'Update Surat Ekspedisi: ' . $model->nomor_surat;
$this->params['breadcrumbs'][] = ['label' => 'Surat Ekspedisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nomor_surat, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="surat-ekspedisi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
