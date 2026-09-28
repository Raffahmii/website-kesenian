<?php

namespace Database\Seeders;

use App\Models\Periode;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    public function run(): void
    {
        $periodes = [
            ['nama_periode' => '2024/2025', 'tahun_mulai' => 2024, 'tahun_selesai' => 2025, 'is_active' => false],
            ['nama_periode' => '2025/2026', 'tahun_mulai' => 2025, 'tahun_selesai' => 2026, 'is_active' => false],
            ['nama_periode' => '2026/2027', 'tahun_mulai' => 2026, 'tahun_selesai' => 2027, 'is_active' => true],
        ];

        foreach ($periodes as $p) {
            Periode::updateOrCreate(
                ['nama_periode' => $p['nama_periode']],
                $p
            );
        }

        $this->command->info('✅ Periode seeded.');
    }
}