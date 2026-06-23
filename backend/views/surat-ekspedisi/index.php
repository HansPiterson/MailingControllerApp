
<?php

use common\models\SuratEkspedisi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\SuratEkspedisiSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Surat Ekspedisi';
$this->params[breadcrumbs][] = $this->title;
?>
<div class="surat-ekspedisi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Surat Ekspedisi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'uuid',
            'nomor_surat',
            'divisi_pengirim_id',
            'divisi_tujuan_id',
            //'nama_tujuan_orang',
            //'tanggal_surat',
            //'perihal',
            //'nama_penerima',
            //'tanggal_penerimaan',
            //'foto_bukti',
            //'foto_alamat',
            //'foto_latitude',
            //'foto_longitude',
            //'foto_hash',
            'status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SuratEkspedisi $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
