<?php
use yii\helpers\Html;
/** @var yii\web\View $this */
/** @var common\models\Divisi $model */
$this->title = 'Create Divisi';
$this->params['breadcrumbs'][] = ['label' => 'Divisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="divisi-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
