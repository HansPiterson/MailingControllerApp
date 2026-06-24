<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $content */

use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;

$this->render('_head');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100" data-bs-theme="light">
<head>
    <?php $this->head() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- Integrasi Heroicons -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/heroicons@2.1.3/24/outline/index.js"></script>
    <!-- Integrasi Toastify.js -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body class="d-flex flex-column h-100 bg-light">
<?php $this->beginBody() ?>

<?= $this->render('_header') ?>

<main id="main" class="flex-grow-1" role="main">
    <div class="container py-4">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        
        <div class="card shadow-sm">
            <div class="card-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</main>

<?= $this->render('_footer') ?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<?php
// Tampilkan flash messages sebagai notifikasi toast
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
    $bgColor = ($key === 'error') ? '#dc3545' : '#198754'; // Merah untuk error, hijau untuk sukses/info
    $js = "
        Toastify({
            text: `{$message}`,
            duration: 3000,
            close: true,
            gravity: 'top',
            position: 'right',
            backgroundColor: '{$bgColor}',
            stopOnFocus: true
        }).showToast();
    ";
    $this->registerJs($js);
}
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
