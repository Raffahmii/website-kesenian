<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DokumentasiAlbum extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi_album';
    protected $primaryKey = 'id_album';

    public function getRouteKeyName(): string
    {
        return 'id_album';
    }

    protected $fillable = [
        'judul',
        'deskripsi',
        'cover_image',
        'kategori',
        'tanggal_kegiatan',
        'id_jadwal',
        'id_user_uploader',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kegiatan' => 'date',
        ];
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(JadwalKegiatan::class, 'id_jadwal', 'id_jadwal');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user_uploader', 'id_user');
    }

    public function media(): HasMany
    {
        return $this->hasMany(DokumentasiMedia::class, 'id_album', 'id_album')
                    ->orderBy('urutan');
    }

    public function getJumlahMediaAttribute(): int
    {
        return $this->media()->count();
    }
}