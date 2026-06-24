<?php

namespace common\services;

use Yii;
use common\models\SuratEkspedisi;

class SuratService
{
    /**
     * Generate nomor surat otomatis berdasarkan format EKS-YYYYMMDD-XXXX
     * @return string
     */
    public static function generateNomorSurat()
    {
        $today = date('Ymd');
        $prefix = "EKS-" . $today . "-";
        
        // Cari nomor urut terakhir pada hari ini
        $lastSurat = SuratEkspedisi::find()
            ->where(['like', 'nomor_surat', $prefix])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        $nextNumber = 1;
        if ($lastSurat && preg_match('/-(\d+)$/', $lastSurat->nomor_surat, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        }

        return $prefix . str_pad((string)$nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
