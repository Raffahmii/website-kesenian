<?php

namespace Database\Seeders;

use App\Enums\RoleUser;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ═══════════════════════════════════════
        // PERMISSIONS
        // ═══════════════════════════════════════
        $permissions = [
            // ── User / Anggota ──
            'user.view',
            'user.create',
            'user.update',
            'user.delete',
            'user.approve',

            // ── Kepengurusan ──
            'kepengurusan.view',
            'kepengurusan.manage',

            // ── Jadwal / Event ──
            'jadwal.view',
            'jadwal.create',
            'jadwal.update',
            'jadwal.delete',

            // ── Absensi ──
            'absensi.view',
            'absensi.input',
            'absensi.manage',
            'absensi.qr-generate',

            // ── Kas ──
            'kas.view',
            'kas.create',
            'kas.update',
            'kas.delete',
            'kas.export',

            // ── Dokumentasi ──
            'dokumentasi.view',
            'dokumentasi.create',
            'dokumentasi.update',
            'dokumentasi.delete',

            // ── Prestasi ──
            'prestasi.view',
            'prestasi.manage',

            // ── Pengumuman ──
            'pengumuman.view',
            'pengumuman.manage',

            // ── Laporan ──
            'laporan.view',
            'laporan.export',

            // ── Audit Log ──
            'auditlog.view',

            // ── Settings ──
            'setting.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ═══════════════════════════════════════
        // ROLES + ASSIGN PERMISSIONS
        // ═══════════════════════════════════════

        // ── 1. ANGGOTA ──
        $anggota = Role::firstOrCreate(['name' => RoleUser::ANGGOTA->value]);
        $anggota->syncPermissions([
            'user.view',
            'jadwal.view',
            'absensi.view',
            'kas.view',
            'dokumentasi.view',
            'prestasi.view',
            'pengumuman.view',
        ]);

        // ── 2. PDD (Publikasi, Dokumentasi, Desain) ──
        $pdd = Role::firstOrCreate(['name' => RoleUser::PDD->value]);
        $pdd->syncPermissions([
            'user.view',
            'jadwal.view',
            'dokumentasi.view',
            'dokumentasi.create',
            'dokumentasi.update',
            'dokumentasi.delete',
            'prestasi.view',
            'pengumuman.view',
        ]);

        // ── 3. BENDAHARA ──
        $bendahara = Role::firstOrCreate(['name' => RoleUser::BENDAHARA->value]);
        $bendahara->syncPermissions([
            'user.view',
            'jadwal.view',
            'kas.view',
            'kas.create',
            'kas.update',
            'kas.delete',
            'kas.export',
            'laporan.view',
            'laporan.export',
            'pengumuman.view',
        ]);

        // ── 4. SEKRETARIS ──
        $sekretaris = Role::firstOrCreate(['name' => RoleUser::SEKRETARIS->value]);
        $sekretaris->syncPermissions([
            'user.view',
            'user.create',
            'user.update',
            'user.approve',
            'kepengurusan.view',
            'kepengurusan.manage',
            'jadwal.view',
            'jadwal.create',
            'jadwal.update',
            'absensi.view',
            'absensi.input',
            'absensi.manage',
            'absensi.qr-generate',
            'laporan.view',
            'laporan.export',
            'pengumuman.view',
            'pengumuman.manage',
        ]);

        // ── 5. WAKIL KETUA ──
        $wakil = Role::firstOrCreate(['name' => RoleUser::WAKIL_KETUA->value]);
        $wakil->syncPermissions(Permission::all());

        // ── 6. KETUA ──
        $ketua = Role::firstOrCreate(['name' => RoleUser::KETUA->value]);
        $ketua->syncPermissions(Permission::all());

        // ── 7. PEMBINA ──
        $pembina = Role::firstOrCreate(['name' => RoleUser::PEMBINA->value]);
        $pembina->syncPermissions(Permission::all());

        $this->command->info('✅ Roles & Permissions seeded.');
    }
}