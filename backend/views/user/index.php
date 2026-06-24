<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;

$this->title = 'Manajemen User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= Html::encode($this->title) ?></h1>
        <?= Html::a('<i class="fas fa-plus fa-sm text-white-50"></i> Tambah User', ['create'], ['class' => 'd-none d-sm-inline-block btn btn-sm btn-primary shadow-sm']) ?>
    </div>

    <?php Pjax::begin(); ?>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'username',
                        'email:email',
                        'nama_lengkap',
                        [
                            'attribute' => 'divisi_id',
                            'value' => 'divisi.nama',
                            'label' => 'Divisi',
                        ],
                        'role',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return $model->status === User::STATUS_ACTIVE ? 'Aktif' : 'Non-Aktif';
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '<div class="d-flex">{view} {update} {delete}</div>',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-sm btn-info', 'title' => 'Lihat']);
                                },
                                'update' => function ($url, $model, $key) {
                                    return Html::a('<i class="fas fa-pencil-alt"></i>', $url, ['class' => 'btn btn-sm btn-warning mx-1', 'title' => 'Ubah']);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<i class="fas fa-trash"></i>', $url, [
                                        'class' => 'btn btn-sm btn-danger', 
                                        'title' => 'Hapus',
                                        'data-confirm' => "Apakah Anda yakin ingin menghapus user '{$model->username}'?",
                                        'data-method' => 'post',
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>

</div>
