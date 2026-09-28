<?php

namespace Database\Seeders;

use App\Enums\RoleUser;
use App\Enums\StatusAnggota;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Password default untuk semua user: "password"
        $defaultPassword = Hash::make('password');

        // ═══════════════════════════════════════
        // STRUKTUR KEPENGURUSAN 2026/2027
        // ═══════════════════════════════════════
        $users = [
            // ── INTI ──
            [
                'nama_lengkap'   => 'Lin Karlina',
                'email'          => 'pembina@giriadiwarna.test',
                'nis'            => null,
                'role'           => RoleUser::PEMBINA->value,
                'kelas'          => null,
                'jurusan'        => null,
                'angkatan'       => null,
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],
            [
                'nama_lengkap'   => 'Rikza Fariq Harii',
                'email'          => 'ketua@giriadiwarna.test',
                'nis'            => '2024001',
                'role'           => RoleUser::KETUA->value,
                'kelas'          => 'XII',
                'jurusan'        => 'RPL',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],
            [
                'nama_lengkap'   => 'Agung Mulyana',
                'email'          => 'wakil@giriadiwarna.test',
                'nis'            => '2024002',
                'role'           => RoleUser::WAKIL_KETUA->value,
                'kelas'          => 'XII',
                'jurusan'        => 'TKJ',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],

            // ── SEKRETARIS ──
            [
                'nama_lengkap'   => 'Chika Syalsa Atifah',
                'email'          => 'sekretaris1@giriadiwarna.test',
                'nis'            => '2024003',
                'role'           => RoleUser::SEKRETARIS->value,
                'kelas'          => 'XII',
                'jurusan'        => 'RPL',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],
            [
                'nama_lengkap'   => 'Devany Julia Putri',
                'email'          => 'sekretaris2@giriadiwarna.test',
                'nis'            => '2024004',
                'role'           => RoleUser::SEKRETARIS->value,
                'kelas'          => 'XI',
                'jurusan'        => 'RPL',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],

            // ── BENDAHARA ──
            [
                'nama_lengkap'   => 'Siti Anisa',
                'email'          => 'bendahara1@giriadiwarna.test',
                'nis'            => '2024005',
                'role'           => RoleUser::BENDAHARA->value,
                'kelas'          => 'XII',
                'jurusan'        => 'AKL',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],
            [
                'nama_lengkap'   => 'Diva Tyara Indriana',
                'email'          => 'bendahara2@giriadiwarna.test',
                'nis'            => '2024006',
                'role'           => RoleUser::BENDAHARA->value,
                'kelas'          => 'XI',
                'jurusan'        => 'AKL',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],

            // ── DEPARTEMEN ──
            [
                'nama_lengkap'   => 'Amelia Meilani',
                'email'          => 'depkesenian@giriadiwarna.test',
                'nis'            => '2024007',
                'role'           => RoleUser::ANGGOTA->value,
                'kelas'          => 'XII',
                'jurusan'        => 'RPL',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],
            [
                'nama_lengkap'   => 'Wisye Amelia',
                'email'          => 'deposis@giriadiwarna.test',
                'nis'            => '2024008',
                'role'           => RoleUser::ANGGOTA->value,
                'kelas'          => 'XII',
                'jurusan'        => 'TKJ',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],
            [
                'nama_lengkap'   => 'Euis Noer Samsiah',
                'email'          => 'depperalatan1@giriadiwarna.test',
                'nis'            => '2024009',
                'role'           => RoleUser::ANGGOTA->value,
                'kelas'          => 'XI',
                'jurusan'        => 'RPL',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],
            [
                'nama_lengkap'   => 'Sandi Darma K',
                'email'          => 'depperalatan2@giriadiwarna.test',
                'nis'            => '2024010',
                'role'           => RoleUser::ANGGOTA->value,
                'kelas'          => 'XI',
                'jurusan'        => 'TKJ',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],

            // ── PDD ──
            [
                'nama_lengkap'   => 'Josephine Abigail',
                'email'          => 'pdd@giriadiwarna.test',
                'nis'            => '2024011',
                'role'           => RoleUser::PDD->value,
                'kelas'          => 'XI',
                'jurusan'        => 'DKV',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],

            // ── KOORDINATOR DIVISI ──
            [
                'nama_lengkap'   => 'Dea Rahmawati',
                'email'          => 'koorpadus@giriadiwarna.test',
                'nis'            => '2024012',
                'role'           => RoleUser::ANGGOTA->value,
                'kelas'          => 'XI',
                'jurusan'        => 'RPL',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],
            [
                'nama_lengkap'   => 'Nabila Sapitri',
                'email'          => 'koortari@giriadiwarna.test',
                'nis'            => '2024013',
                'role'           => RoleUser::ANGGOTA->value,
                'kelas'          => 'XI',
                'jurusan'        => 'AKL',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],
            [
                'nama_lengkap'   => 'Indah Berliyanti C.',
                'email'          => 'koordance@giriadiwarna.test',
                'nis'            => '2024014',
                'role'           => RoleUser::ANGGOTA->value,
                'kelas'          => 'XI',
                'jurusan'        => 'DKV',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],
            [
                'nama_lengkap'   => 'M. Raffa Izrael',
                'email'          => 'koorband@giriadiwarna.test',
                'nis'            => '2024015',
                'role'           => RoleUser::ANGGOTA->value,
                'kelas'          => 'X',
                'jurusan'        => 'TKJ',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],
            [
                'nama_lengkap'   => 'Gilang Hamdani',
                'email'          => 'koormusik@giriadiwarna.test',
                'nis'            => '2024016',
                'role'           => RoleUser::ANGGOTA->value,
                'kelas'          => 'X',
                'jurusan'        => 'RPL',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],
            [
                'nama_lengkap'   => 'Siska Halimatus S.',
                'email'          => 'koorseni@giriadiwarna.test',
                'nis'            => '2024017',
                'role'           => RoleUser::ANGGOTA->value,
                'kelas'          => 'X',
                'jurusan'        => 'DKV',
                'angkatan'       => '2024',
                'status_anggota' => StatusAnggota::AKTIF->value,
            ],
        ];

        foreach ($users as $u) {
            $user = User::updateOrCreate(
                ['email' => $u['email']],
                array_merge($u, ['password' => $defaultPassword])
            );

            // Assign role Spatie
            if (!$user->hasRole($u['role'])) {
                $user->assignRole($u['role']);
            }
        }

        $this->command->info('✅ Users seeded (' . count($users) . ' user).');
        $this->command->warn('   ⚠️  Password default: "password" — ganti di production!');
    }
}