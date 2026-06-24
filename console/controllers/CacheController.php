<?php
namespace console\controllers;

use yii\console\Controller;
use Yii;

class CacheController extends Controller
{
    /**
     * Flushes the database schema cache.
     */
    public function actionFlushSchema()
    {
        Yii::$app->db->schema->refresh();
        echo "Database schema cache has been flushed.\n";
    }
}
