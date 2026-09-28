<?php

namespace App\Services;

use App\Enums\Cabang;
use App\Enums\StatusAbsensi;
use App\Models\Absensi;
use App\Models\JadwalKegiatan;
use App\Models\User;

class AttendanceService
{
    /**
     * Ambil semua anggota aktif berdasarkan cabang.
     */
    public function getMembersByCabang(string $cabang): \Illuminate\Database\Eloquent\Collection
    {
        return User::where('status_anggota', \App\Enums\StatusAnggota::AKTIF->value)
            ->where('cabang', $cabang)
            ->orderBy('nama_lengkap')
            ->get();
    }

    /**
     * Ambil existing attendance untuk jadwal + list user.
     * Return: Collection keyed by id_user.
     */
    public function getExistingAttendance(int $idJadwal, array $idUsers): \Illuminate\Support\Collection
    {
        return Absensi::where('id_jadwal', $idJadwal)
            ->whereIn('id_user', $idUsers)
            ->get()
            ->keyBy('id_user');
    }

    /**
     * Simpan absensi massal (bulk).
     * Return: jumlah yang berhasil disimpan.
     */
    public function bulkStore(JadwalKegiatan $jadwal, array $rows): int
    {
        $count = 0;

        foreach ($rows as $row) {
            Absensi::updateOrCreate(
                [
                    'id_jadwal' => $jadwal->id_jadwal,
                    'id_user'   => $row['id_user'],
                ],
                [
                    'status'      => $row['status'],
                    'keterangan'  => $row['keterangan'] ?? null,
                    'waktu_absen' => now(),
                    'metode'      => 'manual',
                ]
            );
            $count++;
        }

        return $count;
    }

    /**
     * Statistik kehadiran user.
     */
    public function getUserStats(User $user): array
    {
        $total = Absensi::where('id_user', $user->id_user)->count();
        $hadir = Absensi::where('id_user', $user->id_user)->where('status', StatusAbsensi::HADIR->value)->count();
        $izin  = Absensi::where('id_user', $user->id_user)->where('status', StatusAbsensi::IZIN->value)->count();
        $sakit = Absensi::where('id_user', $user->id_user)->where('status', StatusAbsensi::SAKIT->value)->count();
        $alpa  = Absensi::where('id_user', $user->id_user)->where('status', StatusAbsensi::ALPA->value)->count();

        $persentase = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;

        return [
            'total'      => $total,
            'hadir'      => $hadir,
            'izin'       => $izin,
            'sakit'      => $sakit,
            'alpa'       => $alpa,
            'persentase' => $persentase,
        ];
    }

    /**
     * Statistik kehadiran per jadwal.
     */
    public function getScheduleStats(JadwalKegiatan $jadwal): array
    {
        return [
            'total' => Absensi::where('id_jadwal', $jadwal->id_jadwal)->count(),
            'hadir' => Absensi::where('id_jadwal', $jadwal->id_jadwal)->where('status', StatusAbsensi::HADIR->value)->count(),
            'izin'  => Absensi::where('id_jadwal', $jadwal->id_jadwal)->where('status', StatusAbsensi::IZIN->value)->count(),
            'sakit' => Absensi::where('id_jadwal', $jadwal->id_jadwal)->where('status', StatusAbsensi::SAKIT->value)->count(),
            'alpa'  => Absensi::where('id_jadwal', $jadwal->id_jadwal)->where('status', StatusAbsensi::ALPA->value)->count(),
        ];
    }

    /**
     * Statistik kehadiran per cabang di suatu jadwal.
     */
    public function getCabangStats(JadwalKegiatan $jadwal): array
    {
        $stats = [];

        foreach (Cabang::cases() as $cabang) {
            $idUsers = User::where('cabang', $cabang->value)->pluck('id_user')->toArray();
            
            $stats[$cabang->value] = [
                'label' => $cabang->shortLabel(),
                'icon'  => $cabang->icon(),
                'total' => count($idUsers),
                'hadir' => Absensi::where('id_jadwal', $jadwal->id_jadwal)
                    ->whereIn('id_user', $idUsers)
                    ->where('status', StatusAbsensi::HADIR->value)
                    ->count(),
            ];
        }

        return $stats;
    }
}