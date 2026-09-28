<?php

namespace App\Models;

use App\Enums\TingkatPrestasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';
    protected $primaryKey = 'id_prestasi';

    protected $fillable = [
        'nama_lomba',
        'kategori',
        'tingkat',
        'peringkat',
        'tahun',
        'tanggal',
        'penyelenggara',
        'lokasi',
        'foto',
        'deskripsi',
        'id_user_pencatat',
    ];

    protected function casts(): array
    {
        return [
            'tingkat' => TingkatPrestasi::class,
            'tanggal' => 'date',
            'tahun'   => 'integer',
        ];
    }

    /**
     * Route Model Binding pakai id_prestasi.
     */
    public function getRouteKeyName(): string
    {
        return 'id_prestasi';
    }

    // ═══════════════════════════════════════
    // RELASI
    // ═══════════════════════════════════════

    public function pencatat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user_pencatat', 'id_user');
    }

    public function peserta(): HasMany
    {
        return $this->hasMany(PrestasiPeserta::class, 'id_prestasi', 'id_prestasi');
    }

    // ═══════════════════════════════════════
    // SCOPE
    // ═══════════════════════════════════════

    public function scopeTingkat($query, TingkatPrestasi $tingkat)
    {
        return $query->where('tingkat', $tingkat->value);
    }

    public function scopeTahun($query, int $tahun)
    {
        return $query->where('tahun', $tahun);
    }
}