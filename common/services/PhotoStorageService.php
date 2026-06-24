<?php

namespace common\services;

use Yii;
use yii\web\UploadedFile;
use yii\web\ServerErrorHttpException;

class PhotoStorageService
{
    /**
     * Menyimpan file foto bukti yang diunggah.
     * 
     * @param UploadedFile $file Objek file dari UploadedFile::getInstance()
     * @param string $uuid UUID surat untuk penamaan file
     * @param string $type Tipe foto: 'overlayed' atau 'original'
     * @return string Path lengkap lokasi penyimpanan file
     * @throws ServerErrorHttpException
     */
    public static function storePhoto(UploadedFile $file, $uuid, $type = 'overlayed')
    {
        // 1. Tentukan direktori: storage/app/uploads/bukti_foto/YYYY/MM/DD/
        $subDir = date('Y/m/d');
        $basePath = Yii::getAlias("@storage/app/uploads/bukti_foto/{$subDir}/");

        if (!is_dir($basePath)) {
            mkdir($basePath, 0777, true);
        }

        // 2. Generate nama file unik: {short_uuid}_{type}_{HHmmss}.jpg
        $shortUuid = substr($uuid, 0, 8);
        $time = date('His');
        $fileName = "{$shortUuid}_{$type}_{$time}.{$file->extension}";
        $fullPath = $basePath . $fileName;

        // 3. Simpan file
        if (!$file->saveAs($fullPath)) {
            throw new ServerErrorHttpException("Gagal menyimpan file {$type} ke server.");
        }

        return $fullPath;
    }

    /**
     * Menghapus file foto dari server.
     * @param string|null $path
     */
    public static function deletePhoto($path)
    {
        if ($path && file_exists($path)) {
            @unlink($path);
        }
    }
}
