<?php
/** @var yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script type="module" src="https://cdn.jsdelivr.net/npm/heroicons@2.1.3/24/outline/index.js"></script>
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
<?php $this->beginBody() ?>

    <main class="container">
        <?= $content ?>
    </main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
