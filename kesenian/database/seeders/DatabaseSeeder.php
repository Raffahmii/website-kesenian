<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('🌱  Starting database seeding...');
        $this->command->info('');

        // ⚠️  URUTAN PENTING — jangan diacak!
        $this->call([
            RolePermissionSeeder::class,   // 1. Roles & Permissions
            PeriodeSeeder::class,          // 2. Periode
            JabatanSeeder::class,          // 3. Jabatan
            UserSeeder::class,             // 4. Users + assign roles
            KepengurusanSeeder::class,     // 5. Linking user ↔ jabatan ↔ periode
            KasKategoriSeeder::class,      // 6. Kategori kas
        ]);

        $this->command->info('');
        $this->command->info('🎉  Database seeding completed!');
        $this->command->info('');
        $this->command->warn('📧  Login credentials (semua password: "password"):');
        $this->command->warn('    ketua@giriadiwarna.test        → KETUA');
        $this->command->warn('    sekretaris1@giriadiwarna.test  → SEKRETARIS');
        $this->command->warn('    bendahara1@giriadiwarna.test   → BENDAHARA');
        $this->command->warn('    pdd@giriadiwarna.test          → PDD');
        $this->command->warn('    anggota@... (17 email total)   → ANGGOTA');
        $this->command->info('');
    }
}