<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\Kepengurusan;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Database\Seeder;

class KepengurusanSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil periode aktif
        $periodeAktif = Periode::where('is_active', true)->first();

        if (!$periodeAktif) {
            $this->command->error('❌ Tidak ada periode aktif. Jalankan PeriodeSeeder dulu.');
            return;
        }

        // Mapping email → nama jabatan
        $mapping = [
            'pembina@giriadiwarna.test'         => 'Pembina',
            'ketua@giriadiwarna.test'           => 'Ketua',
            'wakil@giriadiwarna.test'           => 'Wakil Ketua',
            'sekretaris1@giriadiwarna.test'     => 'Sekretaris 1',
            'sekretaris2@giriadiwarna.test'     => 'Sekretaris 2',
            'bendahara1@giriadiwarna.test'      => 'Bendahara 1',
            'bendahara2@giriadiwarna.test'      => 'Bendahara 2',
            'depkesenian@giriadiwarna.test'     => 'Dep. Kesenian',
            'deposis@giriadiwarna.test'         => 'Dep. OSIS',
            'depperalatan1@giriadiwarna.test'   => 'Dep. Peralatan 1',
            'depperalatan2@giriadiwarna.test'   => 'Dep. Peralatan 2',
            'pdd@giriadiwarna.test'             => 'PDD',
            'koorpadus@giriadiwarna.test'       => 'Koor. Padus',
            'koortari@giriadiwarna.test'        => 'Koor. Seni Tari',
            'koordance@giriadiwarna.test'       => 'Koor. Dance',
            'koorband@giriadiwarna.test'        => 'Koor. Band',
            'koormusik@giriadiwarna.test'       => 'Koor. Musik',
            'koorseni@giriadiwarna.test'        => 'Koor. Seni',
        ];

        $count = 0;
        foreach ($mapping as $email => $namaJabatan) {
            $user = User::where('email', $email)->first();
            $jabatan = Jabatan::where('nama_jabatan', $namaJabatan)->first();

            if (!$user || !$jabatan) {
                $this->command->warn("   ⚠️  Skip: {$email} → {$namaJabatan}");
                continue;
            }

            Kepengurusan::updateOrCreate(
                [
                    'id_user'    => $user->id_user,
                    'id_jabatan' => $jabatan->id_jabatan,
                    'id_periode' => $periodeAktif->id_periode,
                ],
                [
                    'sk_number'       => 'SK/' . str_pad($count + 1, 3, '0', STR_PAD_LEFT) . '/GA/' . $periodeAktif->tahun_mulai,
                    'tanggal_mulai'   => $periodeAktif->tahun_mulai . '-07-01',
                    'tanggal_selesai' => $periodeAktif->tahun_selesai . '-06-30',
                    'is_active'       => true,
                ]
            );
            $count++;
        }

        $this->command->info("✅ Kepengurusan seeded ({$count} record) untuk periode {$periodeAktif->nama_periode}.");
    }
}