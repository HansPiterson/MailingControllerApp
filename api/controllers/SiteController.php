<?php

namespace api\controllers;

use yii\rest\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return array
     */
    public function actionIndex()
    {
        return [
            'status' => 'success',
            'message' => 'Welcome to the API!',
            'version' => '1.0.0',
        ];
    }
}
