<?php

namespace backend\controllers;

use Yii;
use common\models\Divisi;
use common\models\SuratEkspedisi;
use common\models\User;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
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
                        // Kita tetap izinkan guest (?) sementara untuk review UI, 
                        // tapi actionLogout akan memaksa pindah ke Login.
                        'roles' => ['?', '@'], 
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

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

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

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';
        $model = new \common\models\LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', 'Selamat datang kembali!');
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        // Paksa redirect ke halaman login
        return $this->redirect(['login']);
    }
}
