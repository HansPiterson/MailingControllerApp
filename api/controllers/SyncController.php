<?php
namespace api\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use common\models\SuratEkspedisi;
use common\models\SyncLog;
use common\services\SuratService;

class SyncController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = ['class' => HttpBearerAuth::class];
        return $behaviors;
    }

    /**
     * Download data (Incremental Sync).
     */
    public function actionDownload()
    {
        $user = Yii::$app->user->identity;
        $lastSyncAt = Yii::$app->request->post('last_sync_at');

        $query = SuratEkspedisi::find(); // DivisiScope otomatis memfilter di sini

        if ($lastSyncAt) {
            $query->andWhere(['>', 'updated_at', $lastSyncAt]);
        }

        $suratList = $query->all();
        
        $this->logSync('download', count($suratList));

        return [
            'status' => 'success',
            'server_time' => date('Y-m-d H:i:s'),
            'data' => $suratList
        ];
    }

    /**
     * Batch Upload dari Flutter.
     */
    public function actionUpload()
    {
        $user = Yii::$app->user->identity;
        $records = Yii::$app->request->post('records', []); // Array of surat objects
        $successCount = 0;
        $errors = [];

        foreach ($records as $data) {
            $uuid = $data['uuid'] ?? null;
            if (!$uuid) continue;

            $model = SuratEkspedisi::findOne(['uuid' => $uuid]) ?: new SuratEkspedisi();
            
            $isNewRecord = $model->isNewRecord;
            $model->load($data, '');
            
            if ($isNewRecord) {
                $model->divisi_pengirim_id = $user->divisi_id;
                $model->created_by = $user->id;
                if (empty($model->nomor_surat)) {
                    $model->nomor_surat = SuratService::generateNomorSurat();
                }
            }

            if ($model->save()) {
                $successCount++;
            } else {
                $errors[] = ['uuid' => $uuid, 'errors' => $model->errors];
            }
        }

        $status = empty($errors) ? 'success' : ( $successCount > 0 ? 'partial' : 'failed' );
        $this->logSync('upload', $successCount, $status, empty($errors) ? null : json_encode($errors));

        return [
            'status' => $status,
            'uploaded_count' => $successCount,
            'errors' => $errors,
        ];
    }

    /**
     * Helper untuk mencatat log sinkronisasi.
     */
    protected function logSync($type, $count, $status = 'success', $errorMessage = null)
    {
        $log = new SyncLog();
        $log->user_id = Yii::$app->user->id;
        $log->sync_type = $type;
        $log->records_count = $count;
        $log->status = $status;
        $log->error_message = $errorMessage;
        $log->synced_at = date('Y-m-d H:i:s');
        $log->save(false);
    }
}
