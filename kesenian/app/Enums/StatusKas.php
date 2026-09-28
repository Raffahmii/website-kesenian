<?php

namespace App\Enums;

enum StatusKas: string
{
    case LUNAS        = 'lunas';
    case BELUM_LUNAS  = 'belum_lunas';

    public function label(): string
    {
        return match ($this) {
            self::LUNAS       => 'Lunas',
            self::BELUM_LUNAS => 'Belum Lunas',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::LUNAS       => 'badge-success',
            self::BELUM_LUNAS => 'badge-danger',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}