<?php

namespace frontend\controllers;

use common\models\SuratEkspedisi;
use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;

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
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->render('guest');
        }

        $user = Yii::$app->user->identity;
        $divisi_id = $user->divisi_id;
        $nama_divisi = $user->divisi->nama_divisi ?? 'Divisi Tidak Ditemukan';

        $totalSuratMasuk = SuratEkspedisi::find()->where(['divisi_tujuan_id' => $divisi_id])->count();
        $totalSuratKeluar = SuratEkspedisi::find()->where(['divisi_pengirim_id' => $divisi_id])->count();
        $suratMenungguDiterima = SuratEkspedisi::find()
            ->where(['divisi_pengirim_id' => $divisi_id, 'status' => 'dikirim'])
            ->count();


        return $this->render('index', [
            'nama_divisi' => $nama_divisi,
            'totalSuratMasuk' => $totalSuratMasuk,
            'totalSuratKeluar' => $totalSuratKeluar,
            'suratMenungguDiterima' => $suratMenungguDiterima,
        ]);
    }

    // ... (action lainnya seperti login, logout, dll. tetap sama)
}
