<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\SuratEkspedisi $model */

$this->title = 'Review Bukti Pengiriman: ' . $model->nomor_surat;
$this->params['breadcrumbs'][] = ['label' => 'Surat Ekspedisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-ekspedisi-review">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Detail Surat</h2>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'nomor_surat',
                    'perihal:ntext',
                    'divisiPengirim.nama_divisi',
                    'divisiTujuan.nama_divisi',
                    'nama_penerima',
                    'tanggal_penerimaan:datetime',
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <h2>Foto Bukti</h2>
            <?php if ($model->foto_bukti): ?>
                <?= Html::img(['lihat-bukti', 'id' => $model->id], ['class' => 'img-fluid shadow', 'alt' => 'Foto Bukti']) ?>
            <?php else: ?>
                <div class="alert alert-warning">Tidak ada foto bukti yang diunggah.</div>
            <?php endif; ?>
        </div>
    </div>

    <hr class="my-4">

    <div class="d-flex justify-content-center">
        <?= Html::beginForm(['review', 'id' => $model->id], 'post') ?>
            <?= Html::hiddenInput('action', 'approve') ?>
            <?= Html::submitButton('<hero-icon name="check-circle" class="w-5 h-5 me-1"></hero-icon> Setujui (Approve)', ['class' => 'btn btn-lg btn-success d-flex align-items-center me-3']) ?>
        <?= Html::endForm() ?>

        <?= Html::beginForm(['review', 'id' => $model->id], 'post') ?>
            <?= Html::hiddenInput('action', 'reject') ?>
            <?= Html::submitButton('<hero-icon name="x-circle" class="w-5 h-5 me-1"></hero-icon> Tolak (Reject)', ['class' => 'btn btn-lg btn-danger d-flex align-items-center', 'data-confirm' => 'Apakah Anda yakin ingin menolak bukti ini?']) ?>
        <?= Html::endForm() ?>
    </div>

</div>
