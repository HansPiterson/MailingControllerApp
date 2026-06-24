<?php

use yii\helpers\Html;

$this->title = 'Ubah User: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Manajemen User', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
