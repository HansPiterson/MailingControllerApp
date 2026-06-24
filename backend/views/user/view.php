<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

$this->title = "Detail User: " . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Manajemen User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('<i class="fas fa-pencil-alt"></i> Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])
            ?>
            <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => "Apakah Anda yakin ingin menghapus user '{$model->username}'?",
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
                    'username',
                    'email:email',
                    'nama_lengkap',
                    [
                        'attribute' => 'divisi_id',
                        'value' => $model->divisi->nama ?? '(Belum ada divisi)',
                    ],
                    'role',
                    [
                        'attribute' => 'status',
                        'value' => $model->status === User::STATUS_ACTIVE ? 'Aktif' : 'Non-Aktif',
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>

</div>
