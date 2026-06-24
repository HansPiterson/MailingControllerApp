<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = "Detail Divisi: " . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Manajemen Divisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="divisi-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('<i class="fas fa-pencil-alt"></i> Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])
            ?>
            <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => "Apakah Anda yakin ingin menghapus divisi '{$model->nama}'?",
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'nama',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>

</div>
