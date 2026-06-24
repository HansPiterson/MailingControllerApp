<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;

$items = [
    [
        'label' => 'Home',
        'url' => ['/site/index'],
    ],
    [
        'label' => 'Kelola Divisi',
        'url' => ['/divisi/index'],
        'visible' => !Yii::$app->user->isGuest,
    ],
    [
        'label' => 'Kelola Users',
        'url' => ['/user/index'],
        'visible' => !Yii::$app->user->isGuest,
    ],
    [
        'label' => 'Kelola Surat',
        'url' => ['/surat-ekspedisi/index'],
        'visible' => !Yii::$app->user->isGuest,
    ],
];

if (Yii::$app->user->isGuest) {
    $items[] = [
        'label' => 'Login',
        'url' => ['/site/login'],
    ];
} else {
    $items[] = [
        'label' => 'Logout (' . Html::encode(Yii::$app->user->identity?->username) . ')',
        'url' => ['/site/logout'],
        'linkOptions' => [
            'data-method' => 'post',
            'class' => 'logout',
        ],
    ];
}

?>
<header id="header">
    <?php NavBar::begin(
        [
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            // Mengubah kelas untuk tampilan yang lebih bersih
            'options' => ['class' => 'navbar-expand-md navbar-light bg-white shadow-sm fixed-top']
        ],
    ) ?>
    <?= Nav::widget(
        [
            'options' => ['class' => 'navbar-nav me-auto'],
            'encodeLabels' => false,
            'items' => $items,
        ],
    ) ?>
    <?php NavBar::end() ?>
</header>
