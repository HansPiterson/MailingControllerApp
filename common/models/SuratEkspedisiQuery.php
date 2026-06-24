<?php

namespace common\models;

use yii\db\ActiveQuery;
use common\components\DivisiScope;

/**
 * Custom ActiveQuery class for [[SuratEkspedisi]].
 */
class SuratEkspedisiQuery extends ActiveQuery
{
    use DivisiScope;

    /**
     * Otomatis menerapkan filter divisi saat query dijalankan.
     */
    public function init()
    {
        parent::init();
        // Memanggil helper dari trait untuk modifikasi query
        static::applyDivisiScope($this);
    }
}
