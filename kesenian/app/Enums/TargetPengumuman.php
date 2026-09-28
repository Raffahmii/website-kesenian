<?php

namespace App\Enums;

enum TargetPengumuman: string
{
    case SEMUA    = 'semua';
    case ANGGOTA  = 'anggota';
    case PENGURUS = 'pengurus';

    public function label(): string
    {
        return match ($this) {
            self::SEMUA    => 'Semua',
            self::ANGGOTA  => 'Anggota',
            self::PENGURUS => 'Pengurus',
        };
    }

    public function desc(): string
    {
        return match ($this) {
            self::SEMUA    => 'Terlihat oleh semua pengunjung & anggota',
            self::ANGGOTA  => 'Hanya untuk anggota yang login',
            self::PENGURUS => 'Hanya untuk pengurus inti',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}