<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kepengurusan extends Model
{
    use HasFactory;

    protected $table = 'kepengurusan';
    protected $primaryKey = 'id_kepengurusan';

    protected $fillable = [
        'id_user',
        'id_jabatan',
        'id_periode',
        'sk_number',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'   => 'date',
            'tanggal_selesai' => 'date',
            'is_active'       => 'boolean',
        ];
    }

    // ═══════════════════════════════════════
    // RELASI
    // ═══════════════════════════════════════

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    public function getRouteKeyName(): string
    {
        return 'id_kepengurusan';
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id_periode');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}