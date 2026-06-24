<?php

namespace backend\controllers;

use Yii;
use common\models\Divisi;
use backend\models\DivisiSearch; // Kita akan buat file ini selanjutnya
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class DivisiController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'], // Hanya admin yang boleh mengelola ini
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new DivisiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Divisi();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Divisi '{$model->nama}' berhasil ditambahkan.");
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Divisi '{$model->nama}' berhasil diperbarui.");
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $namaDivisi = $model->nama;
        $model->delete();
        Yii::$app->session->setFlash('success', "Divisi '{$namaDivisi}' berhasil dihapus.");

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Divisi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Halaman yang Anda cari tidak ditemukan.');
        }
    }
}
