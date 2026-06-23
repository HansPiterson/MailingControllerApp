<?php
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $suratMasukProvider */
/** @var yii\data\ActiveDataProvider $suratKeluarProvider */

$this->title = 'Daftar Surat Ekspedisi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Surat Masuk</h2>
            <?= GridView::widget([
                'dataProvider' => $suratMasukProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'nomor_surat',
                    'perihal:ntext',
                    [
                        'attribute' => 'divisi_pengirim_id',
                        'label' => 'Dari Divisi',
                        // Menggunakan relasi untuk menampilkan nama divisi
                        'value' => 'divisiPengirim.nama_divisi',
                    ],
                    'tanggal_surat:date',
                    ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
                ],
            ]); ?>
        </div>
        <div class="col-md-6">
            <h2>Surat Keluar</h2>
            <?= GridView::widget([
                'dataProvider' => $suratKeluarProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'nomor_surat',
                    'perihal:ntext',
                    [
                        'attribute' => 'divisi_tujuan_id',
                        'label' => 'Untuk Divisi',
                        // Menggunakan relasi untuk menampilkan nama divisi
                        'value' => 'divisiTujuan.nama_divisi',
                    ],
                    'tanggal_surat:date',
                    ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
                ],
            ]); ?>
        </div>
    </div>

</div>
