<?php
use common\models\SuratEkspedisi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Divisi;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var backend\models\SuratEkspedisiSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Surat Ekspedisi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-ekspedisi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Surat Ekspedisi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nomor_surat',
            'perihal:ntext',
            [
                'attribute' => 'divisi_pengirim_id',
                'value' => 'divisiPengirim.nama_divisi',
                'filter' => ArrayHelper::map(Divisi::find()->asArray()->all(), 'id', 'nama_divisi'),
            ],
            [
                'attribute' => 'divisi_tujuan_id',
                'value' => 'divisiTujuan.nama_divisi',
                'filter' => ArrayHelper::map(Divisi::find()->asArray()->all(), 'id', 'nama_divisi'),
            ],
            'tanggal_surat:date',
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
