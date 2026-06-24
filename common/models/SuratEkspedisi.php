<?php
// ... (namespace, use statements, etc.)
class SuratEkspedisi extends ActiveRecord
{
    // ... (properti lain)
    public const STATUS_DRAFT = 'draft';
    public const STATUS_TERKIRIM = 'terkirim';
    public const STATUS_DITERIMA = 'diterima';
    public const STATUS_BATAL = 'batal';
    public const STATUS_PERLU_DIULAS = 'perlu_diulas'; // Status baru

    // ... (behavior, dll)

    public static function statuses(): array
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_TERKIRIM,
            self::STATUS_DITERIMA,
            self::STATUS_BATAL,
            self::STATUS_PERLU_DIULAS,
        ];
    }
    // ... (sisa model)
}
