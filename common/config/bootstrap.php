<?php

declare(strict_types=1);

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
if (file_exists(dirname(__DIR__, 2) . '/.env')) {
    $dotenv->load();
}

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@storage', dirname(dirname(__DIR__)) . '/storage');
