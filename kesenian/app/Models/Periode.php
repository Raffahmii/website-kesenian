<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'periode';
    protected $primaryKey = 'id_periode';

    protected $fillable = [
        'nama_periode',
        'tahun_mulai',
        'tahun_selesai',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
    public function getRouteKeyName(): string
    {
        return 'id_periode';
    }

    public function kepengurusan(): HasMany
    {
        return $this->hasMany(Kepengurusan::class, 'id_periode', 'id_periode');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}