<?php

use yii\helpers\Html;

$this->title = 'Tambah Divisi Baru';
$this->params['breadcrumbs'][] = ['label' => 'Manajemen Divisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="divisi-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
