<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrestasiPeserta extends Model
{
    use HasFactory;

    protected $table = 'prestasi_peserta';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_prestasi',
        'id_user',
        'peran',
    ];

    public function prestasi(): BelongsTo
    {
        return $this->belongsTo(Prestasi::class, 'id_prestasi', 'id_prestasi');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}