<?php

namespace App\Enums;

enum JenisKegiatan: string
{
    case LATIHAN = 'latihan';
    case PENTAS  = 'pentas';
    case LOMBA   = 'lomba';
    case RAPAT   = 'rapat';

    public function label(): string
    {
        return match ($this) {
            self::LATIHAN => 'Latihan',
            self::PENTAS  => 'Pentas',
            self::LOMBA   => 'Lomba',
            self::RAPAT   => 'Rapat',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::LATIHAN => '🎯',
            self::PENTAS  => '🎭',
            self::LOMBA   => '🏆',
            self::RAPAT   => '📋',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::LATIHAN => 'blue',
            self::PENTAS  => 'pink',
            self::LOMBA   => 'gold',
            self::RAPAT   => 'purple',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}