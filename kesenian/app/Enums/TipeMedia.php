<?php

namespace App\Enums;

enum TipeMedia: string
{
    case FOTO  = 'foto';
    case VIDEO = 'video';

    public function label(): string
    {
        return match ($this) {
            self::FOTO  => 'Foto',
            self::VIDEO => 'Video',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::FOTO  => 'image',
            self::VIDEO => 'video',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}