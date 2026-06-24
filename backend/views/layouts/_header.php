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
?>
<header id="header">
    <?php NavBar::begin(
        [
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark shadow-sm fixed-top']
        ],
    ) ?>
    
    <?= Nav::widget(
        [
            'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
            'items' => $items,
        ],
    ) ?>

    <div class="d-flex align-items-center">
         <?php if (!Yii::$app->user->isGuest): ?>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <hero-icon name="user-circle" class="w-5 h-5 me-1 d-inline-block align-middle"></hero-icon>
                        <?= Html::encode(Yii::$app->user->identity->username) ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                        <li>
                            <?= Html::a('Logout', ['/site/logout'], [
                                'class' => 'dropdown-item text-danger',
                                'data' => ['method' => 'post'],
                            ]) ?>
                        </li>
                    </ul>
                </li>
            </ul>
        <?php else: ?>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <?= Html::a('Login', ['/site/login'], ['class' => 'nav-link']) ?>
                </li>
            </ul>
        <?php endif; ?>
    </div>
    
    <?php NavBar::end() ?>
</header>
