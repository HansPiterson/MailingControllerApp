<?php
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kelola Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?= Html::a('<hero-icon name="plus" class="w-5 h-5 me-1"></hero-icon> Tambah User', ['create'], ['class' => 'btn btn-success d-flex align-items-center']) ?>
        </p>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            'divisi.nama_divisi',
            [
                'attribute' => 'role',
                'format' => 'raw',
                'value' => function($model){
                    return '<span class="badge bg-secondary">' . Html::encode($model->role) . '</span>';
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->status == User::STATUS_ACTIVE 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-danger">Inactive</span>';
                },
                'filter' => [
                    User::STATUS_ACTIVE => 'Active',
                    User::STATUS_INACTIVE => 'Inactive',
                ],
            ],
            [
                'class' => ActionColumn::className(),
                'header' => 'Actions',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a('<hero-icon name="eye" class="w-5 h-5"></hero-icon>', $url, ['class' => 'text-primary', 'title' => 'View']);
                    },
                    'update' => function ($url) {
                        return Html::a('<hero-icon name="pencil-square" class="w-5 h-5"></hero-icon>', $url, ['class' => 'text-warning ms-2', 'title' => 'Update']);
                    },
                    'delete' => function ($url) {
                        return Html::a('<hero-icon name="trash" class="w-5 h-5"></hero-icon>', $url, [
                            'class' => 'text-danger ms-2',
                            'title' => 'Delete',
                            'data-confirm' => 'Are you sure?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
