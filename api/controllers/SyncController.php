<?php
namespace api\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use common\models\SuratEkspedisi;
use common\models\SyncLog;

class SyncController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }

    /**
     * Download data surat terbaru sejak sinkronisasi terakhir.
     */
    public function actionDownload()
    {
        $user = Yii::$app->user->identity;
        $lastSyncAt = Yii::$app->request->post('last_sync_at');

        $query = SuratEkspedisi::find()
            ->where(['or',
                ['divisi_pengirim_id' => $user->divisi_id],
                ['divisi_tujuan_id' => $user->divisi_id]
            ]);

        if ($lastSyncAt) {
            $query->andWhere(['>', 'updated_at', $lastSyncAt]);
        }

        $suratList = $query->all();
        
        // Log aktivitas sync
        $log = new SyncLog();
        $log->user_id = $user->id;
        $log->sync_type = 'download';
        $log->records_count = count($suratList);
        $log->status = 'success';
        $log->synced_at = date('Y-m-d H:i:s');
        $log->save();

        return [
            'status' => 'success',
            'server_time' => date('Y-m-d H:i:s'),
            'data' => $suratList
        ];
    }
}
