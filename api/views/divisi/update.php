<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Divisi $model */

$this->title = 'Update Divisi: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Divisis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="divisi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
