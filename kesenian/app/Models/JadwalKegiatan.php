<?php

namespace App\Models;

use App\Enums\JenisKegiatan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class JadwalKegiatan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kegiatan';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'judul',
        'jenis',
        'deskripsi',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'qr_token',
        'qr_active',
        'id_user_pembuat',
    ];

    protected function casts(): array
    {
        return [
            'jenis'     => JenisKegiatan::class,
            'tanggal'   => 'date',
            'qr_active' => 'boolean',
        ];
    }

    // ═══════════════════════════════════════
    // RELASI
    // ═══════════════════════════════════════

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user_pembuat', 'id_user');
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'id_jadwal', 'id_jadwal');
    }

    public function album(): HasMany
    {
        return $this->hasMany(DokumentasiAlbum::class, 'id_jadwal', 'id_jadwal');
    }

    // ═══════════════════════════════════════
    // HELPER
    // ═══════════════════════════════════════

    /**
     * Generate token QR baru.
     */
    public function generateQrToken(): string
    {
        $token = Str::random(64);
        $this->update([
            'qr_token'  => $token,
            'qr_active' => true,
        ]);
        return $token;
    }

    public function scopeUpcoming($query)
    {
        return $query->where('tanggal', '>=', now()->toDateString())
                     ->orderBy('tanggal')
                     ->orderBy('jam_mulai');
    }

    public function scopeByJenis($query, JenisKegiatan $jenis)
    {
        return $query->where('jenis', $jenis->value);
    }
}