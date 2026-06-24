<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\SuratEkspedisi;
use common\models\Divisi;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'Manajemen Surat Ekspedisi';
$this->params['breadcrumbs'][] = $this->title;

$divisiList = ArrayHelper::map(Divisi::find()->all(), 'id', 'nama_divisi');
?>
<div class="surat-ekspedisi-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><?= Html::encode($this->title) ?></h1>
        <?php 
            // Memastikan rute menggunakan 'surat-ekspedisi/create'
            echo Html::a('<hero-icon name="plus" class="w-5 h-5 me-1"></hero-icon> Tambah Surat', ['/surat-ekspedisi/create'], ['class' => 'btn btn-primary d-flex align-items-center shadow-sm']); 
        ?>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'nomor_surat',
                    [
                        'attribute' => 'divisi_pengirim_id',
                        'value' => 'divisiPengirim.nama_divisi',
                        'filter' => $divisiList,
                        'label' => 'Pengirim',
                    ],
                    [
                        'attribute' => 'divisi_tujuan_id',
                        'value' => 'divisiTujuan.nama_divisi',
                        'filter' => $divisiList,
                        'label' => 'Tujuan',
                    ],
                    'tanggal_surat:date',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $class = 'secondary';
                            if ($model->status === SuratEkspedisi::STATUS_DITERIMA) $class = 'success';
                            if ($model->status === SuratEkspedisi::STATUS_PERLU_DIULAS) $class = 'warning';
                            if ($model->status === SuratEkspedisi::STATUS_TERKIRIM) $class = 'info';
                            return "<span class=\"badge bg-{$class}\">" . strtoupper($model->status) . "</span>";
                        },
                        'filter' => array_combine(SuratEkspedisi::statuses(), array_map('strtoupper', SuratEkspedisi::statuses())),
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{review} {view} {update} {delete}',
                        'buttons' => [
                            'review' => function ($url, $model) {
                                if ($model->status === SuratEkspedisi::STATUS_PERLU_DIULAS) {
                                    return Html::a('<hero-icon name="clipboard-document-check" class="w-5 h-5"></hero-icon>', ['review', 'id' => $model->id], [
                                        'class' => 'text-warning',
                                        'title' => 'Review Bukti',
                                    ]);
                                }
                                return '';
                            },
                            'view' => function ($url) {
                                return Html::a('<hero-icon name="eye" class="w-5 h-5"></hero-icon>', $url, ['class' => 'text-info ms-2']);
                            },
                            'update' => function ($url) {
                                return Html::a('<hero-icon name="pencil-square" class="w-5 h-5"></hero-icon>', $url, ['class' => 'text-warning ms-2']);
                            },
                            'delete' => function ($url) {
                                return Html::a('<hero-icon name="trash" class="w-5 h-5"></hero-icon>', $url, [
                                    'class' => 'text-danger ms-2',
                                    'data-confirm' => 'Hapus data ini?',
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
