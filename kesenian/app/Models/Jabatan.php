<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';
    protected $primaryKey = 'id_jabatan';

    protected $fillable = [
        'nama_jabatan',
        'level',
        'divisi',
        'deskripsi',
    ];

    public function kepengurusan(): HasMany
    {
        return $this->hasMany(Kepengurusan::class, 'id_jabatan', 'id_jabatan');
    }
    public function getRouteKeyName(): string
    {
        return 'id_jabatan';
    }

    /**
     * Scope untuk filter berdasarkan divisi.
     */
    public function scopeDivisi($query, string $divisi)
    {
        return $query->where('divisi', $divisi);
    }

    /**
     * Scope untuk urut berdasarkan hierarki.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('level');
    }
}