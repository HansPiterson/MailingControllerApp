<?php
use common\models\SuratEkspedisi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Divisi;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var backend\models\SuratEkspedisiSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kelola Surat Ekspedisi';
$this->params['breadcrumbs'][] = $this->title;

$statusBadges = [
    SuratEkspedisi::STATUS_DRAFT => 'secondary',
    SuratEkspedisi::STATUS_TERKIRIM => 'info',
    SuratEkspedisi::STATUS_PERLU_DIULAS => 'warning',
    SuratEkspedisi::STATUS_DITERIMA => 'success',
    SuratEkspedisi::STATUS_BATAL => 'danger',
];

?>
<div class="surat-ekspedisi-index">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?= Html::a('<hero-icon name="plus" class="w-5 h-5 me-1"></hero-icon> Tambah Surat', ['create'], ['class' => 'btn btn-success d-flex align-items-center']) ?>
        </p>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nomor_surat',
            [
                'attribute' => 'divisi_pengirim_id',
                'value' => 'divisiPengirim.nama_divisi',
                'filter' => ArrayHelper::map(Divisi::find()->asArray()->all(), 'id', 'nama_divisi'),
            ],
            [
                'attribute' => 'divisi_tujuan_id',
                'value' => 'divisiTujuan.nama_divisi',
                'filter' => ArrayHelper::map(Divisi::find()->asArray()->all(), 'id', 'nama_divisi'),
            ],
            'tanggal_surat:date',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) use ($statusBadges) {
                    $badgeClass = $statusBadges[$model->status] ?? 'light';
                    return "<span class=\"badge bg-{$badgeClass}\">" . Html::encode($model->status) . "</span>";
                },
                'filter' => $statusBadges,
            ],
            [
                'class' => ActionColumn::className(),
                'header' => 'Actions',
                'template' => '{review} {view} {update} {delete}',
                'buttons' => [
                    'review' => function ($url, $model, $key) {
                        if ($model->status === SuratEkspedisi::STATUS_PERLU_DIULAS) {
                             return Html::a('<hero-icon name="magnifying-glass-circle" class="w-5 h-5"></hero-icon>', ['review', 'id' => $model->id], ['class' => 'text-warning', 'title' => 'Review']);
                        }
                        return '';
                    },
                    'view' => function ($url) {
                        return Html::a('<hero-icon name="eye" class="w-5 h-5"></hero-icon>', $url, ['class' => 'text-primary ms-2', 'title' => 'View']);
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
