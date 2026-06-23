<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/** @var yii\web\View $this */
/** @var common\models\Divisi $model */
$this->title = $model->nama_divisi;
$this->params['breadcrumbs'][] = ['label' => 'Divisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="divisi-view">
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
            'kode_divisi',
            'nama_divisi',
            'is_active:boolean',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
</div>
