<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\SuratEkspedisi $model */

$this->title = $model->id;
$this->params[breadcrumbs][] = ['label' => 'Surat Ekspedisi', 'url' => ['index']];
$this->params[breadcrumbs][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="surat-ekspedisi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'uuid',
            'nomor_surat',
            'divisi_pengirim_id',
            'divisi_tujuan_id',
            'nama_tujuan_orang',
            'tanggal_surat',
            'perihal',
            'nama_penerima',
            'tanggal_penerimaan',
            'foto_bukti',
            'foto_alamat',
            'foto_latitude',
            'foto_longitude',
            'foto_hash',
            'status',
        ],
    ]) ?>

</div>
