<?php
namespace api\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use common\models\Divisi;

class DivisiController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }

    /**
     * Mengambil daftar semua divisi yang aktif.
     * Digunakan oleh Flutter untuk dropdown pilihan tujuan.
     */
    public function actionIndex()
    {
        return Divisi::find()->where(['is_active' => true])->all();
    }
}
