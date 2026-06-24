<?php

use yii\helpers\Html;

$this->title = 'Tambah User Baru';
$this->params['breadcrumbs'][] = ['label' => 'Manajemen User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
