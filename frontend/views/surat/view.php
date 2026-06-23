<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\SuratEkspedisi $model */

$this->title = 'Detail Surat: ' . $model->nomor_surat;
$this->params['breadcrumbs'][] = ['label' => 'Daftar Surat', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="surat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nomor_surat',
            'tanggal_surat:date',
            'perihal:ntext',
            [
                'attribute' => 'divisi_pengirim_id',
                'label' => 'Dari Divisi',
                'value' => $model->divisiPengirim->nama_divisi,
            ],
            [
                'attribute' => 'divisi_tujuan_id',
                'label' => 'Untuk Divisi',
                'value' => $model->divisiTujuan->nama_divisi,
            ],
            'nama_tujuan_orang',
            'status',
            'nama_penerima',
            'tanggal_penerimaan:datetime',
            [
                'attribute' => 'foto_bukti',
                'format' => 'raw', // 'raw' agar tag <img> bisa dirender
                'value' => function ($model) {
                    // Nanti kita akan buat action untuk serve foto secara aman.
                    // Untuk sekarang, kita tampilkan placeholder.
                    if ($model->foto_bukti) {
                        return Html::tag('span', 'Foto bukti tersedia (akan ditampilkan di sini).', ['class' => 'text-muted']);
                        // Contoh jika foto sudah bisa diakses:
                        // return Html::img(['/path/to/secure/photo', 'id' => $model->id], ['alt' => 'Foto Bukti', 'style' => 'max-width:300px;']);
                    }
                    return 'Tidak ada foto bukti.';
                },
            ],
            [
                'label' => 'Dibuat Oleh',
                'value' => $model->pembuat->username ?? 'N/A', // Menggunakan relasi pembuat
            ],
            'created_at:datetime',
        ],
    ]) ?>

</div>
