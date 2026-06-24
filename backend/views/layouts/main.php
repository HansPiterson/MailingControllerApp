<?php
declare(strict_types=1);

use backend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script type="module" src="https://cdn.jsdelivr.net/npm/heroicons@2.1.3/24/outline/index.js"></script>
</head>
<body>
<?php $this->beginBody() ?>

<div id="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            Buku Ekspedisi
        </div>
        <div class="nav flex-column mt-4">
            <a href="<?= Url::to(['/site/index']) ?>" class="nav-link <?= Yii::$app->controller->id == 'site' ? 'active' : '' ?>">
                <hero-icon name="chart-bar" class="w-5 h-5"></hero-icon> Dashboard
            </a>
            <a href="<?= Url::to(['/surat-ekspedisi/index']) ?>" class="nav-link <?= Yii::$app->controller->id == 'surat-ekspedisi' ? 'active' : '' ?>">
                <hero-icon name="envelope" class="w-5 h-5"></hero-icon> Manajemen Surat
            </a>
            <a href="<?= Url::to(['/divisi/index']) ?>" class="nav-link <?= Yii::$app->controller->id == 'divisi' ? 'active' : '' ?>">
                <hero-icon name="user-group" class="w-5 h-5"></hero-icon> Divisi
            </a>
            <a href="<?= Url::to(['/user/index']) ?>" class="nav-link <?= Yii::$app->controller->id == 'user' ? 'active' : '' ?>">
                <hero-icon name="users" class="w-5 h-5"></hero-icon> Pengguna
            </a>
            
            <div class="mt-auto border-top border-secondary">
                <?= Html::a('<hero-icon name="arrow-left-on-rectangle" class="w-5 h-5"></hero-icon> Keluar', ['/site/logout'], [
                    'class' => 'nav-link text-danger',
                    'data-method' => 'post',
                ]) ?>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div id="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0"><?= Html::encode($this->title) ?></h2>
                <div class="user-info d-flex align-items-center">
                    <span class="me-2"><?= Html::encode(Yii::$app->user->identity->username ?? 'Guest') ?></span>
                    <hero-icon name="user-circle" class="w-8 h-8 text-secondary"></hero-icon>
                </div>
            </div>
            
            <?= $content ?>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
