<?php

namespace App\Models;

use App\Enums\TipeMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumentasiMedia extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi_media';
    protected $primaryKey = 'id_media';

    public function getRouteKeyName(): string
    {
        return 'id_media';
    }

    protected $fillable = [
        'id_album',
        'tipe',
        'file_path',
        'thumbnail',
        'caption',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'tipe'   => TipeMedia::class,
            'urutan' => 'integer',
        ];
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(DokumentasiAlbum::class, 'id_album', 'id_album');
    }

    public function scopeFoto($query)
    {
        return $query->where('tipe', TipeMedia::FOTO->value);
    }

    public function scopeVideo($query)
    {
        return $query->where('tipe', TipeMedia::VIDEO->value);
    }
}