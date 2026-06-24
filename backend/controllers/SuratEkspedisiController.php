<?php

namespace backend\controllers;

use Yii;
use common\models\SuratEkspedisi;
use backend\models\SuratEkspedisiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class SuratEkspedisiController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?', '@'], 
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
        $searchModel = new SuratEkspedisiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    public function actionReview($id)
    {
        $model = $this->findModel($id);
        if ($this->request->isPost) {
            $action = $this->request->post('action');
            if ($action === 'approve') {
                $model->status = SuratEkspedisi::STATUS_DITERIMA;
            } elseif ($action === 'reject') {
                $model->status = SuratEkspedisi::STATUS_TERKIRIM;
            }
            $model->save(false);
            return $this->redirect(['index']);
        }
        return $this->render('review', ['model' => $model]);
    }

    public function actionLihatBukti($id)
    {
        $model = $this->findModel($id);
        if ($model->foto_bukti && file_exists($model->foto_bukti)) {
            return Yii::$app->response->sendFile($model->foto_bukti, null, ['inline' => true]);
        }
        throw new NotFoundHttpException('File tidak ditemukan.');
    }

    protected function findModel($id)
    {
        if (($model = SuratEkspedisi::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
