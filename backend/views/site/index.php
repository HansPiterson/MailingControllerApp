<?php
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var int $totalSurat */
/** @var int $totalDivisi */
/** @var int $totalUser */
/** @var yii\data\ActiveDataProvider $latestSuratProvider */

$this->title = 'Dashboard Ringkasan';
?>
<div class="site-index">

    <div class="row">
        <!-- Stat Cards -->
        <div class="col-md-4 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="stat-title">TOTAL SURAT</div>
                <div class="stat-value text-primary"><?= $totalSurat ?></div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="stat-title">TOTAL DIVISI</div>
                <div class="stat-value text-success"><?= $totalDivisi ?></div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card stat-card shadow-sm h-100">
                <div class="stat-title">TOTAL PENGGUNA</div>
                <div class="stat-value text-info"><?= $totalUser ?></div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-dark">5 Surat Terbaru</h6>
                </div>
                <div class="card-body">
                    <?= GridView::widget([
                        'dataProvider' => $latestSuratProvider,
                        'summary' => false,
                        'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
                        'columns' => [
                            'nomor_surat',
                            'perihal:ntext',
                            'divisiPengirim.nama',
                            'divisiTujuan.nama',
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => function($model) {
                                    return "<span class='badge bg-light text-dark border'>".strtoupper($model->status)."</span>";
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

</div>
