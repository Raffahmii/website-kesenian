<?php

namespace Database\Seeders;

use App\Models\KasKategori;
use Illuminate\Database\Seeder;

class KasKategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'nama'      => 'Kas Bulanan',
                'nominal'   => 10000,
                'deskripsi' => 'Iuran wajib bulanan seluruh anggota',
                'is_active' => true,
            ],
            [
                'nama'      => 'Iuran Event',
                'nominal'   => 25000,
                'deskripsi' => 'Iuran untuk kegiatan pentas/lomba tertentu',
                'is_active' => true,
            ],
            [
                'nama'      => 'Kas Sukarela',
                'nominal'   => 0,
                'deskripsi' => 'Donasi sukarela dari anggota atau pihak luar',
                'is_active' => true,
            ],
        ];

        foreach ($kategoris as $k) {
            KasKategori::updateOrCreate(['nama' => $k['nama']], $k);
        }

        $this->command->info('✅ Kas Kategori seeded (' . count($kategoris) . ' kategori).');
    }
}