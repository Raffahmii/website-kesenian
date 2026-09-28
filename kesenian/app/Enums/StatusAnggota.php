<?php

namespace App\Enums;

enum StatusAnggota: string
{
    case AKTIF    = 'aktif';
    case ALUMNI   = 'alumni';
    case NONAKTIF = 'nonaktif';

    public function label(): string
    {
        return match ($this) {
            self::AKTIF    => 'Aktif',
            self::ALUMNI   => 'Alumni',
            self::NONAKTIF => 'Nonaktif',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::AKTIF    => 'badge-success',
            self::ALUMNI   => 'badge-gold',
            self::NONAKTIF => 'badge-danger',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}