<?php

namespace App\Enums;

enum Cabang: string
{
    case PADUS     = 'padus';
    case SENI_TARI = 'seni_tari';
    case DANCE     = 'dance';
    case BAND      = 'band';
    case MUSIK     = 'musik';
    case SENI      = 'seni';

    public function label(): string
    {
        return match ($this) {
            self::PADUS     => 'Padus (Paduan Suara)',
            self::SENI_TARI => 'Seni Tari',
            self::DANCE     => 'Dance',
            self::BAND      => 'Band',
            self::MUSIK     => 'Musik',
            self::SENI      => 'Seni Rupa & Teater',
        };
    }

    public function shortLabel(): string
    {
        return match ($this) {
            self::PADUS     => 'Padus',
            self::SENI_TARI => 'Seni Tari',
            self::DANCE     => 'Dance',
            self::BAND      => 'Band',
            self::MUSIK     => 'Musik',
            self::SENI      => 'Seni',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::PADUS     => '🎤',
            self::SENI_TARI => '💃',
            self::DANCE     => '🕺',
            self::BAND      => '🎸',
            self::MUSIK     => '🎹',
            self::SENI      => '🎨',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}