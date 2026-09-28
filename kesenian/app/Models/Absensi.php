<?php

namespace App\Models;

use App\Enums\StatusAbsensi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';

    protected $fillable = [
        'id_jadwal',
        'id_user',
        'status',
        'waktu_absen',
        'keterangan',
        'metode',
    ];

    protected function casts(): array
    {
        return [
            'status'      => StatusAbsensi::class,
            'waktu_absen' => 'datetime',
        ];
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(JadwalKegiatan::class, 'id_jadwal', 'id_jadwal');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function scopeHadir($query)
    {
        return $query->where('status', StatusAbsensi::HADIR->value);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('id_user', $userId);
    }
}