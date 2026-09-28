<?php

namespace App\Http\Controllers\Public;

use App\Enums\StatusAnggota;
use App\Enums\StatusKas;
use App\Enums\TingkatPrestasi;
use App\Http\Controllers\Controller;
use App\Models\DokumentasiAlbum;
use App\Models\DokumentasiMedia;
use App\Models\JadwalKegiatan;
use App\Models\KasPembayaran;
use App\Models\Kepengurusan;
use App\Models\Periode;
use App\Models\Pengumuman;
use App\Models\Prestasi;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // ── Stats dinamis dari DB ──
        $totalAktif = User::where('status_anggota', StatusAnggota::AKTIF->value)->count();
        $totalPengurus = Kepengurusan::where('is_active', true)->count();
        $totalDivisi = 6; // tetap 6 (hardcoded karena cabang enum)
        $totalPrestasi = Prestasi::count();
        $totalAlbum = DokumentasiAlbum::count();
        $totalMedia = DokumentasiMedia::count();

        // Tahun berdiri — hitung dari user angkatan tertua
        $angkatanTertua = User::whereNotNull('angkatan')->min('angkatan');
        $tahunBerdiri = $angkatanTertua ? (int) $angkatanTertua : now()->year;
        $totalTahun = max(1, now()->year - $tahunBerdiri);

        $stats = [
            [
                'value' => $totalPengurus,
                'suffix' => '+',
                'label' => 'Pengurus Inti',
                'desc' => 'Periode ' . (Periode::where('is_active', true)->first()?->nama_periode ?? '-'),
            ],
            [
                'value' => $totalDivisi,
                'suffix' => '',
                'label' => 'Divisi Seni',
                'desc' => 'Padus, Tari, Dance, dll',
            ],
            [
                'value' => $totalPrestasi,
                'suffix' => $totalPrestasi > 0 ? '+' : '',
                'label' => 'Prestasi Diraih',
                'desc' => 'Kab. hingga nasional',
            ],
            [
                'value' => max($totalTahun, 1),
                'suffix' => '+',
                'label' => 'Tahun Berkarya',
                'desc' => 'Melestarikan budaya',
            ],
        ];

        // ── Prestasi terbaru (max 3) ──
        $prestasis = Prestasi::with('peserta.user')
            ->orderByDesc('tahun')
            ->orderByDesc('tanggal')
            ->take(3)
            ->get();

        // ── Dokumentasi album terbaru (max 6) ──
        $albums = DokumentasiAlbum::withCount('media')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        // ── Event mendatang (max 4) ──
        $events = JadwalKegiatan::where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')
            ->take(4)
            ->get();

        // ── Kepengurusan aktif periode ini (untuk section struktur opsional) ──
        $periodeAktif = Periode::where('is_active', true)->first();
        $pengurusAktif = collect();
        if ($periodeAktif) {
            $pengurusAktif = Kepengurusan::with(['user', 'jabatan'])
                ->where('id_periode', $periodeAktif->id_periode)
                ->where('is_active', true)
                ->whereHas('jabatan', fn($q) => $q->where('level', '<=', 5)) // cuma inti
                ->orderBy('id_jabatan')
                ->get();
        }

        return view('public.home', compact(
            'stats',
            'prestasis',
            'albums',
            'events',
            'pengurusAktif',
            'periodeAktif'
        ));
    }
}