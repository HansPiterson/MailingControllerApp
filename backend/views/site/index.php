<?php
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var int $totalSurat */
/** @var int $totalDivisi */
/** @var int $totalUser */
/** @var yii\data\ActiveDataProvider $latestSuratProvider */

$this->title = 'Dashboard Admin';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Selamat Datang, Admin!</h1>
        <p class="lead">Ini adalah halaman utama untuk manajemen sistem Ekspedisi Surat Digital.</p>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Surat</div>
                    <div class="card-body">
                        <h2 class="card-title"><?= Html::encode($totalSurat) ?></h2>
                        <p class="card-text">Jumlah semua surat yang tercatat.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Divisi</div>
                    <div class="card-body">
                        <h2 class="card-title"><?= Html::encode($totalDivisi) ?></h2>
                        <p class="card-text">Jumlah semua divisi yang terdaftar.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Total User</div>
                    <div class="card-body">
                        <h2 class="card-title"><?= Html::encode($totalUser) ?></h2>
                        <p class="card-text">Jumlah semua pengguna sistem.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h2>5 Surat Terbaru</h2>
                <?= GridView::widget([
                    'dataProvider' => $latestSuratProvider,
                    'summary' => '', // Menghilangkan tulisan "Showing 1-5 of 5 items."
                    'columns' => [
                        'nomor_surat',
                        'perihal:ntext',
                        'divisiPengirim.nama_divisi',
                        'divisiTujuan.nama_divisi',
                        'tanggal_surat:date',
                        'status',
                    ],
                ]); ?>
            </div>
        </div>

    </div>
</div>
