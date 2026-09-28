<?php

namespace App\Enums;

enum RoleUser: string
{
    case ANGGOTA      = 'anggota';
    case PDD          = 'pdd';
    case BENDAHARA    = 'bendahara';
    case SEKRETARIS   = 'sekretaris';
    case KETUA        = 'ketua';
    case WAKIL_KETUA  = 'wakil_ketua';
    case PEMBINA      = 'pembina';

    /**
     * Label human-readable (untuk ditampilkan di UI).
     */
    public function label(): string
    {
        return match ($this) {
            self::ANGGOTA     => 'Anggota',
            self::PDD         => 'PDD (Publikasi & Dokumentasi)',
            self::BENDAHARA   => 'Bendahara',
            self::SEKRETARIS  => 'Sekretaris',
            self::KETUA       => 'Ketua',
            self::WAKIL_KETUA => 'Wakil Ketua',
            self::PEMBINA     => 'Pembina',
        };
    }

    /**
     * Level hierarki (semakin tinggi = semakin banyak akses).
     */
    public function level(): int
    {
        return match ($this) {
            self::ANGGOTA     => 1,
            self::PDD         => 2,
            self::BENDAHARA   => 3,
            self::SEKRETARIS  => 4,
            self::WAKIL_KETUA => 5,
            self::KETUA       => 6,
            self::PEMBINA     => 7,
        };
    }

    /**
     * Cek apakah role termasuk pengurus inti.
     */
    public function isPengurus(): bool
    {
        return $this !== self::ANGGOTA;
    }

    /**
     * Semua value (untuk validasi / dropdown).
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}