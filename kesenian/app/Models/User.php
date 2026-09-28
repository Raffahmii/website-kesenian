<?php

namespace App\Models;

use App\Enums\RoleUser;
use App\Enums\StatusAnggota;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'nis',
        'role',
        'cabang',
        'kelas',
        'jurusan',
        'angkatan',
        'status_anggota',
        'photo',
        'cover_photo',
        'bio',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role'              => RoleUser::class,
            'cabang'            => \App\Enums\Cabang::class,
            'status_anggota'    => StatusAnggota::class,
        ];
    }

    /**
     * Route Model Binding pakai id_user.
     */
    public function getRouteKeyName(): string
    {
        return 'id_user';
    }

    // ═══════════════════════════════════════
    // RELASI
    // ═══════════════════════════════════════

    public function kepengurusan(): HasMany
    {
        return $this->hasMany(Kepengurusan::class, 'id_user', 'id_user');
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'id_user', 'id_user');
    }

    public function kasPembayaran(): HasMany
    {
        return $this->hasMany(KasPembayaran::class, 'id_user', 'id_user');
    }

    public function kasDicatat(): HasMany
    {
        return $this->hasMany(KasPembayaran::class, 'id_user_pencatat', 'id_user');
    }

    public function jadwalDibuat(): HasMany
    {
        return $this->hasMany(JadwalKegiatan::class, 'id_user_pembuat', 'id_user');
    }

    public function albumUploaded(): HasMany
    {
        return $this->hasMany(DokumentasiAlbum::class, 'id_user_uploader', 'id_user');
    }

    public function prestasiPeserta(): HasMany
    {
        return $this->hasMany(PrestasiPeserta::class, 'id_user', 'id_user');
    }

    public function prestasiDicatat(): HasMany
    {
        return $this->hasMany(Prestasi::class, 'id_user_pencatat', 'id_user');
    }

    public function pengumumanDibuat(): HasMany
    {
        return $this->hasMany(Pengumuman::class, 'id_user_pembuat', 'id_user');
    }

    public function auditLog(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'id_user', 'id_user');
    }

    // ═══════════════════════════════════════
    // HELPER
    // ═══════════════════════════════════════

    public function hasRoleName(string $role): bool
    {
        return $this->role->value === $role;
    }

    public function isPengurus(): bool
    {
        return $this->role->isPengurus();
    }

    public function kepengurusanAktif()
    {
        return $this->kepengurusan()
            ->where('is_active', true)
            ->with(['jabatan', 'periode'])
            ->first();
    }
}