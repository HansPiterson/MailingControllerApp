<?php
namespace api\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\data\ActiveDataProvider;
use common\models\SuratEkspedisi;
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
        
        // Kustomisasi data provider untuk action 'index'
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        
        // Kita akan override action 'create' secara manual, jadi kita nonaktifkan yang default
        unset($actions['create']);

        // Menonaktifkan action yang tidak diperlukan untuk saat ini
        unset($actions['update'], $actions['delete']);

        return $actions;
    }

    public function prepareDataProvider()
    {
        $user = Yii::$app->user->identity;
        $divisi_id = $user->divisi_id;

        // User harus memiliki divisi untuk melihat data
        if (empty($divisi_id)) {
            $query = $this->modelClass::find()->where('0=1');
        } else {
            // Menampilkan surat dimana user adalah pengirim ATAU penerima
            $query = $this->modelClass::find()->where(['or',
                ['divisi_pengirim_id' => $divisi_id],
                ['divisi_tujuan_id' => $divisi_id]
            ]);
        }

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    /**
     * Membuat record surat ekspedisi baru.
     * @return \yii\db\ActiveRecordInterface|\common\models\SuratEkspedisi
     * @throws ServerErrorHttpException
     */
    public function actionCreate()
    {
        $model = new SuratEkspedisi();
        $user = Yii::$app->user->identity;

        // Memuat data dari request body
        $model->load(Yii::$app->request->getBodyParams(), '');

        // === Logika Keamanan & Integritas Data ===
        // 1. Set divisi pengirim sesuai dengan divisi user yang login
        $model->divisi_pengirim_id = $user->divisi_id;
        // 2. Set user yang membuat record
        $model->created_by = $user->id;
        // 3. Set status awal
        $model->status = 'dikirim';

        if ($model->save()) {
            Yii::$app->response->setStatusCode(201); // 201 Created
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Gagal membuat record karena alasan yang tidak diketahui.');
        }

        return $model;
    }
}
