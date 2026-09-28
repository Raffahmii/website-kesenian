<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_log';
    protected $primaryKey = 'id_log';

    public $timestamps = false; // cuma pakai created_at

    

    protected $fillable = [
        'id_user',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent',
        'old_values',
        'new_values',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    public function getRouteKeyName(): string
    {
        return 'id_log';
    }

    public static function record(
        string $action,
        string $module,
        ?string $description = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): self {
        return self::create([
            'id_user'     => Auth::id(),
            'action'      => $action,
            'module'      => $module,
            'description' => $description,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'old_values'  => $oldValues,
            'new_values'  => $newValues,
        ]);
    }
}