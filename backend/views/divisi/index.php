<?php
use common\models\Divisi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\DivisiSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kelola Divisi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="divisi-index">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?= Html::a('<hero-icon name="plus" class="w-5 h-5 me-1"></hero-icon> Tambah Divisi', ['create'], ['class' => 'btn btn-success d-flex align-items-center']) ?>
        </p>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'kode_divisi',
            'nama_divisi',
            [
                'attribute' => 'is_active',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->is_active 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-danger">Inactive</span>';
                }
            ],
            [
                'class' => ActionColumn::className(),
                'header' => 'Actions',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<hero-icon name="eye" class="w-5 h-5"></hero-icon>', $url, ['class' => 'text-primary', 'title' => 'View']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<hero-icon name="pencil-square" class="w-5 h-5"></hero-icon>', $url, ['class' => 'text-warning ms-2', 'title' => 'Update']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<hero-icon name="trash" class="w-5 h-5"></hero-icon>', $url, [
                            'class' => 'text-danger ms-2',
                            'title' => 'Delete',
                            'data-confirm' => 'Are you sure you want to delete this item?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
