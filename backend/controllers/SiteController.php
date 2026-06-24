<?php

namespace backend\controllers;

use common\models\Divisi;
use common\models\SuratEkspedisi;
use common\models\User;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $totalSurat = SuratEkspedisi::find()->count();
        $totalDivisi = Divisi::find()->count();
        $totalUser = User::find()->count();

        $latestSuratProvider = new ActiveDataProvider([
            'query' => SuratEkspedisi::find()->orderBy(['created_at' => SORT_DESC])->limit(5),
            'pagination' => false,
        ]);

        return $this->render('index', [
            'totalSurat' => $totalSurat,
            'totalDivisi' => $totalDivisi,
            'totalUser' => $totalUser,
            'latestSuratProvider' => $latestSuratProvider,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new \common\models\LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return yii\web\Response
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }
}
