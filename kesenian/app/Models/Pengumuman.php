<?php

namespace App\Models;

use App\Enums\TargetPengumuman;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';
    protected $primaryKey = 'id_pengumuman';

    public function getRouteKeyName(): string
    {
        return 'id_pengumuman';
    }

    protected $fillable = [
        'judul',
        'isi',
        'target_role',
        'lampiran',
        'is_published',
        'published_at',
        'id_user_pembuat',
    ];

    protected function casts(): array
    {
        return [
            'target_role'  => TargetPengumuman::class,
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user_pembuat', 'id_user');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->where(function ($q) {
                         $q->whereNull('published_at')
                           ->orWhere('published_at', '<=', now());
                     });
    }

    public function scopeForRole($query, TargetPengumuman $role)
    {
        return $query->whereIn('target_role', [
            TargetPengumuman::SEMUA->value,
            $role->value,
        ]);
    }
}