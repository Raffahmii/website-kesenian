<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KasKategori extends Model
{
    use HasFactory;

    protected $table = 'kas_kategori';
    protected $primaryKey = 'id_kategori';

    public function getRouteKeyName(): string
    {
        return 'id_kategori';
    }

    protected $fillable = [
        'nama',
        'nominal',
        'deskripsi',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'nominal'   => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(KasPembayaran::class, 'id_kategori', 'id_kategori');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}