<?php
namespace api\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\web\UploadedFile;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use common\models\SuratEkspedisi;
use common\services\PhotoStorageService;

class FotoController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = ['class' => HttpBearerAuth::class];
        return $behaviors;
    }

    public function actionUploadBukti($uuid)
    {
        $user = Yii::$app->user->identity;

        $surat = SuratEkspedisi::findOne(['uuid' => $uuid]);
        if (!$surat) {
            throw new NotFoundHttpException("Surat dengan UUID '$uuid' tidak ditemukan.");
        }

        // Hanya divisi pengirim yang bisa upload bukti (sesuai role kurir di divisi pengirim)
        if ($surat->divisi_pengirim_id !== $user->divisi_id) {
            throw new ForbiddenHttpException('Akses ditolak.');
        }

        $foto_bukti = UploadedFile::getInstanceByName('foto_bukti');
        $foto_bukti_original = UploadedFile::getInstanceByName('foto_bukti_original');

        if (!$foto_bukti || !$foto_bukti_original) {
            Yii::$app->response->statusCode = 422;
            return ['status' => 'error', 'message' => 'Kedua file foto wajib diunggah.'];
        }

        // Menggunakan Service untuk penyimpanan
        $path_bukti = PhotoStorageService::storePhoto($foto_bukti, $surat->uuid, 'overlayed');
        $path_original = PhotoStorageService::storePhoto($foto_bukti_original, $surat->uuid, 'original');

        $surat->nama_penerima = Yii::$app->request->post('nama_penerima');
        $surat->tanggal_penerimaan = date('Y-m-d H:i:s');
        $surat->foto_bukti = $path_bukti;
        $surat->foto_bukti_original = $path_original;
        $surat->status = SuratEkspedisi::STATUS_PERLU_DIULAS;
        
        if ($surat->save()) {
            return $surat;
        } else {
            PhotoStorageService::deletePhoto($path_bukti);
            PhotoStorageService::deletePhoto($path_original);
            Yii::$app->response->statusCode = 422;
            return ['status' => 'error', 'errors' => $surat->errors];
        }
    }
}
