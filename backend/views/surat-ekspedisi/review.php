<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Review Bukti Pengiriman: ' . $model->nomor_surat;
$this->params['breadcrumbs'][] = ['label' => 'Manajemen Surat', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-ekspedisi-review">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Pengiriman</h6>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'nomor_surat',
                            'perihal:ntext',
                            'nama_penerima',
                            'tanggal_penerimaan:datetime',
                            'foto_alamat',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Foto Bukti</h6>
                </div>
                <div class="card-body text-center">
                    <?php if ($model->foto_bukti): ?>
                        <?= Html::img(['lihat-bukti', 'id' => $model->id], ['class' => 'img-fluid rounded border shadow-sm', 'style' => 'max-height: 500px;']) ?>
                    <?php else: ?>
                        <p class="text-muted">Tidak ada foto bukti.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-3">
        <?= Html::beginForm(['review', 'id' => $model->id], 'post') ?>
            <?= Html::hiddenInput('action', 'approve') ?>
            <?= Html::submitButton('<hero-icon name="check-circle" class="w-6 h-6 me-2"></hero-icon> Setujui Pengiriman', ['class' => 'btn btn-lg btn-success d-flex align-items-center']) ?>
        <?= Html::endForm() ?>

        <?= Html::beginForm(['review', 'id' => $model->id], 'post') ?>
            <?= Html::hiddenInput('action', 'reject') ?>
            <?= Html::submitButton('<hero-icon name="x-circle" class="w-6 h-6 me-2"></hero-icon> Tolak & Minta Ulang', ['class' => 'btn btn-lg btn-danger d-flex align-items-center', 'data-confirm' => 'Tolak bukti ini? Kurir harus mengupload ulang.']) ?>
        <?= Html::endForm() ?>
    </div>

</div>
