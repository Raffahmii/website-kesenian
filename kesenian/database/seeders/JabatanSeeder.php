<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        $jabatans = [
            // ── INTI (level 1-4) ──
            ['nama_jabatan' => 'Pembina',       'level' => 1, 'divisi' => null,            'deskripsi' => 'Pembina ekstrakurikuler'],
            ['nama_jabatan' => 'Ketua',         'level' => 2, 'divisi' => null,            'deskripsi' => 'Ketua organisasi'],
            ['nama_jabatan' => 'Wakil Ketua',   'level' => 3, 'divisi' => null,            'deskripsi' => 'Wakil ketua organisasi'],
            ['nama_jabatan' => 'Sekretaris 1',  'level' => 4, 'divisi' => null,            'deskripsi' => 'Sekretaris utama'],
            ['nama_jabatan' => 'Sekretaris 2',  'level' => 4, 'divisi' => null,            'deskripsi' => 'Sekretaris kedua'],
            ['nama_jabatan' => 'Bendahara 1',   'level' => 4, 'divisi' => null,            'deskripsi' => 'Bendahara utama'],
            ['nama_jabatan' => 'Bendahara 2',   'level' => 4, 'divisi' => null,            'deskripsi' => 'Bendahara kedua'],

            // ── DEPARTEMEN (level 5) ──
            ['nama_jabatan' => 'Dep. Kesenian',   'level' => 5, 'divisi' => 'kesenian',   'deskripsi' => 'Departemen kesenian'],
            ['nama_jabatan' => 'Dep. OSIS',       'level' => 5, 'divisi' => 'osis',       'deskripsi' => 'Departemen OSIS'],
            ['nama_jabatan' => 'Dep. Peralatan 1','level' => 5, 'divisi' => 'peralatan',  'deskripsi' => 'Departemen peralatan 1'],
            ['nama_jabatan' => 'Dep. Peralatan 2','level' => 5, 'divisi' => 'peralatan',  'deskripsi' => 'Departemen peralatan 2'],
            ['nama_jabatan' => 'PDD',             'level' => 5, 'divisi' => 'pdd',        'deskripsi' => 'Publikasi, Dokumentasi, Desain'],

            // ── KOORDINATOR DIVISI (level 6) ──
            ['nama_jabatan' => 'Koor. Padus',    'level' => 6, 'divisi' => 'padus',      'deskripsi' => 'Koordinator paduan suara'],
            ['nama_jabatan' => 'Koor. Seni Tari','level' => 6, 'divisi' => 'seni_tari',  'deskripsi' => 'Koordinator seni tari'],
            ['nama_jabatan' => 'Koor. Dance',    'level' => 6, 'divisi' => 'dance',      'deskripsi' => 'Koordinator dance'],
            ['nama_jabatan' => 'Koor. Band',     'level' => 6, 'divisi' => 'band',       'deskripsi' => 'Koordinator band'],
            ['nama_jabatan' => 'Koor. Musik',    'level' => 6, 'divisi' => 'musik',      'deskripsi' => 'Koordinator musik'],
            ['nama_jabatan' => 'Koor. Seni',     'level' => 6, 'divisi' => 'seni',       'deskripsi' => 'Koordinator seni rupa & teater'],

            ['nama_jabatan' => 'Anggota', 'level' => 99, 'divisi' => null, 'deskripsi' => 'Anggota biasa (belum punya jabatan khusus)'],
        ];

        foreach ($jabatans as $j) {
            Jabatan::updateOrCreate(
                ['nama_jabatan' => $j['nama_jabatan']],
                $j
            );
        }

        $this->command->info('✅ Jabatan seeded (' . count($jabatans) . ' jabatan).');
    }
}