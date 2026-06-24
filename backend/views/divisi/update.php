<?php

use yii\helpers\Html;

$this->title = 'Ubah Divisi: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Manajemen Divisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="divisi-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
