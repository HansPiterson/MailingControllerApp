<?php

namespace common\components;

use Yii;

/**
 * Trait untuk otomatisasi filter data berdasarkan divisi.
 * Bisa diaplikasikan pada model SuratEkspedisi.
 */
trait DivisiScope
{
    /**
     * Menambahkan filter divisi_id ke query secara otomatis.
     * Hanya berlaku jika user yang login bukan admin.
     * 
     * @param \yii\db\ActiveQuery $query
     * @return \yii\db\ActiveQuery
     */
    public static function applyDivisiScope($query)
    {
        // Jangan apply scope jika dijalankan dari console (misal: migrasi)
        if (Yii::$app instanceof \yii\console\Application) {
            return $query;
        }

        $user = Yii::$app->user->identity;

        // Jika user tidak login, atau user adalah admin, jangan filter (admin bisa lihat semua)
        if (!$user || $user->role === 'admin') {
            return $query;
        }

        $divisiId = $user->divisi_id;

        // Filter surat dimana user adalah pengirim ATAU tujuan
        return $query->andWhere(['or',
            ['divisi_pengirim_id' => $divisiId],
            ['divisi_tujuan_id' => $divisiId]
        ]);
    }
}
