<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var string $nama_divisi */
/** @var int $totalSuratMasuk */
/** @var int $totalSuratKeluar */
/** @var int $suratMenungguDiterima */

$this->title = 'Dashboard Divisi ' . Html::encode($nama_divisi);
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Dashboard Divisi <?= Html::encode($nama_divisi) ?></h1>
        <p class="lead">Selamat datang di portal ekspedisi surat digital.</p>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Total Surat Masuk</div>
                    <div class="card-body">
                        <h2 class="card-title"><?= Html::encode($totalSuratMasuk) ?></h2>
                        <p class="card-text">Jumlah semua surat yang diterima.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Total Surat Keluar</div>
                    <div class="card-body">
                        <h2 class="card-title"><?= Html::encode($totalSuratKeluar) ?></h2>
                        <p class="card-text">Jumlah semua surat yang dikirim.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card text-dark bg-light mb-3">
                    <div class="card-header">Menunggu Diterima</div>
                    <div class="card-body">
                        <h2 class="card-title"><?= Html::encode($suratMenungguDiterima) ?></h2>
                        <p class="card-text">Jumlah surat keluar yang belum diterima.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <p>
                    <?= Html::a('Lihat Semua Surat', ['/surat/index'], ['class' => 'btn btn-primary']) ?>
                </p>
            </div>
        </div>

    </div>
</div>
