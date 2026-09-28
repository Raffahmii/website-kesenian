<?php

namespace App\Enums;

enum TingkatPrestasi: string
{
    case SEKOLAH   = 'sekolah';
    case KABUPATEN = 'kabupaten';
    case PROVINSI  = 'provinsi';
    case NASIONAL  = 'nasional';

    public function label(): string
    {
        return match ($this) {
            self::SEKOLAH   => 'Tingkat Sekolah',
            self::KABUPATEN => 'Tingkat Kabupaten',
            self::PROVINSI  => 'Tingkat Provinsi',
            self::NASIONAL  => 'Tingkat Nasional',
        };
    }

    public function shortLabel(): string
    {
        return match ($this) {
            self::SEKOLAH   => 'Sekolah',
            self::KABUPATEN => 'Kabupaten',
            self::PROVINSI  => 'Provinsi',
            self::NASIONAL  => 'Nasional',
        };
    }

    /**
     * Level (semakin tinggi = semakin prestisius).
     */
    public function level(): int
    {
        return match ($this) {
            self::SEKOLAH   => 1,
            self::KABUPATEN => 2,
            self::PROVINSI  => 3,
            self::NASIONAL  => 4,
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::SEKOLAH   => 'badge',
            self::KABUPATEN => 'badge-gold',
            self::PROVINSI  => 'badge bg-orange-500/20 text-orange-400 border border-orange-500/30',
            self::NASIONAL  => 'badge bg-gradient-to-r from-gold to-gold-hover text-bg-primary border-0',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}