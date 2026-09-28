<?php

namespace App\Enums;

enum StatusAbsensi: string
{
    case HADIR = 'hadir';
    case IZIN  = 'izin';
    case SAKIT = 'sakit';
    case ALPA  = 'alpa';

    public function label(): string
    {
        return match ($this) {
            self::HADIR => 'Hadir',
            self::IZIN  => 'Izin',
            self::SAKIT => 'Sakit',
            self::ALPA  => 'Alpa',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::HADIR => 'badge-success',
            self::IZIN  => 'badge-gold',
            self::SAKIT => 'badge bg-blue-500/20 text-blue-400 border border-blue-500/30',
            self::ALPA  => 'badge-danger',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}