<?php

declare(strict_types=1);

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

class SuratEkspedisi extends ActiveRecord
{
    // ... (konstanta, tableName, behaviors, rules, attributeLabels tetap sama) ...

    /**
     * Override method find() untuk menggunakan custom Query class
     * yang sudah menyertakan otomatisasi filter divisi.
     * 
     * @return SuratEkspedisiQuery
     */
    public static function find()
    {
        return new SuratEkspedisiQuery(get_called_class());
    }

    // ... (sisa relasi dan method tetap sama) ...
}
