<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Manajemen Divisi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="divisi-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><?= Html::encode($this->title) ?></h1>
        <?= Html::a('<hero-icon name="plus" class="w-5 h-5 me-1"></hero-icon> Tambah Divisi', ['create'], ['class' => 'btn btn-primary d-flex align-items-center shadow-sm']) ?>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'kode_divisi',
                    'nama_divisi',
                    [
                        'attribute' => 'is_active',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->is_active ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Non-Aktif</span>';
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function($url) { return Html::a('<hero-icon name="eye" class="w-5 h-5"></hero-icon>', $url, ['class' => 'text-info']); },
                            'update' => function($url) { return Html::a('<hero-icon name="pencil-square" class="w-5 h-5"></hero-icon>', $url, ['class' => 'text-warning ms-2']); },
                            'delete' => function($url) { return Html::a('<hero-icon name="trash" class="w-5 h-5"></hero-icon>', $url, ['class' => 'text-danger ms-2', 'data-method' => 'post', 'data-confirm' => 'Hapus divisi ini?']); },
                        ]
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
