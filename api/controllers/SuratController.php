<?php
namespace api\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\data\ActiveDataProvider;
use common\models\SuratEkspedisi;
use common\services\SuratService;
use yii\web\ServerErrorHttpException;

class SuratController extends ActiveController
{
    public $modelClass = 'common\models\SuratEkspedisi';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']); // Kita akan override action create secara manual
        return $actions;
    }

    /**
     * Membuat record surat ekspedisi baru dengan nomor surat otomatis.
     */
    public function actionCreate()
    {
        $model = new SuratEkspedisi();
        $user = Yii::$app->user->identity;

        $model->load(Yii::$app->request->getBodyParams(), '');

        // Otomatisasi via Service Layer
        if (empty($model->nomor_surat)) {
            $model->nomor_surat = SuratService::generateNomorSurat();
        }

        $model->divisi_pengirim_id = $user->divisi_id;
        $model->created_by = $user->id;
        $model->status = SuratEkspedisi::STATUS_TERKIRIM;

        if ($model->save()) {
            Yii::$app->response->setStatusCode(201);
            return $model;
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Gagal membuat record karena alasan yang tidak diketahui.');
        }

        return $model;
    }
}
