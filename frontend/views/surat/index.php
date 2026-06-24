<?php
use kartik\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $suratMasukProvider */
/** @var yii\data\ActiveDataProvider $suratKeluarProvider */
/** @var string $nama_divisi */

$this->title = 'Laporan Surat Ekspedisi';
$this->params['breadcrumbs'][] = $this->title;

// Konfigurasi kolom yang bisa dipakai bersama
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'nomor_surat',
    'perihal:ntext',
    'tanggal_surat:date',
    'status',
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view}',
        'header' => 'Detail',
        'buttons' => [
            'view' => function ($url) {
                return Html::a('Lihat', $url, ['class' => 'btn btn-sm btn-outline-primary']);
            },
        ],
    ],
];

$exportConfig = [
    GridView::PDF => [
        'label' => 'Simpan sebagai PDF',
        'icon' => 'file-pdf',
        'config' => [
            'methods' => [
                'SetHeader' => ['Laporan Surat Ekspedisi || Dibuat pada: ' . date("d-m-Y H:i")],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]
    ],
    GridView::EXCEL => [
        'label' => 'Simpan sebagai Excel',
        'icon' => 'file-excel',
    ],
];

?>
<div class="surat-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>Gunakan tombol "Export" di pojok kanan atas setiap tabel untuk mengunduh laporan.</p>

    <div class="row">
        <div class="col-md-12">
            <?= GridView::widget([
                'dataProvider' => $suratMasukProvider,
                'columns' => array_merge([
                    [
                        'attribute' => 'divisi_pengirim_id',
                        'label' => 'Dari Divisi',
                        'value' => 'divisiPengirim.nama_divisi',
                    ],
                ], $gridColumns),
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title">Surat Masuk</h3>',
                ],
                'toolbar' => [
                    '{export}',
                ],
                'export' => [
                    'fontAwesome' => true, // Menggunakan ikon FontAwesome
                ],
                'exportConfig' => $exportConfig,
            ]); ?>
        </div>
        <div class="col-md-12 mt-4">
             <?= GridView::widget([
                'dataProvider' => $suratKeluarProvider,
                'columns' => array_merge([
                     [
                        'attribute' => 'divisi_tujuan_id',
                        'label' => 'Untuk Divisi',
                        'value' => 'divisiTujuan.nama_divisi',
                    ],
                ], $gridColumns),
                'panel' => [
                    'type' => GridView::TYPE_SUCCESS,
                    'heading' => '<h3 class="panel-title">Surat Keluar</h3>',
                ],
                'toolbar' => [
                    '{export}',
                ],
                'export' => [
                    'fontAwesome' => true,
                ],
                'exportConfig' => $exportConfig,
            ]); ?>
        </div>
    </div>
</div>
