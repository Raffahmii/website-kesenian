<?php

namespace App\Models;

use App\Enums\StatusKas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KasPembayaran extends Model
{
    use HasFactory;

    protected $table = 'kas_pembayaran';
    protected $primaryKey = 'id_pembayaran';

    public function getRouteKeyName(): string
    {
        return 'id_pembayaran';
    }

    protected $fillable = [
        'id_user',
        'id_kategori',
        'periode_bulan',
        'nominal',
        'status',
        'tanggal_bayar',
        'bukti_pembayaran',
        'catatan',
        'id_user_pencatat',
    ];

    protected function casts(): array
    {
        return [
            'nominal'       => 'decimal:2',
            'status'        => StatusKas::class,
            'tanggal_bayar' => 'date',
        ];
    }

    // ═══════════════════════════════════════
    // RELASI
    // ═══════════════════════════════════════

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KasKategori::class, 'id_kategori', 'id_kategori');
    }

    public function pencatat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user_pencatat', 'id_user');
    }

    // ═══════════════════════════════════════
    // SCOPE
    // ═══════════════════════════════════════

    public function scopeLunas($query)
    {
        return $query->where('status', StatusKas::LUNAS->value);
    }

    public function scopeBelumLunas($query)
    {
        return $query->where('status', StatusKas::BELUM_LUNAS->value);
    }

    public function scopePeriode($query, string $periodeBulan)
    {
        return $query->where('periode_bulan', $periodeBulan);
    }

    /**
     * Total kas bulan tertentu (lunas).
     */
    public static function totalLunas(string $periodeBulan): float
    {
        return self::where('periode_bulan', $periodeBulan)
                   ->where('status', StatusKas::LUNAS->value)
                   ->sum('nominal');
    }
}