<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\DokumentasiAlbum;
use App\Models\JadwalKegiatan;
use App\Models\KasPembayaran;
use App\Models\Pengumuman;
use App\Models\Prestasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Ambil notifikasi terbaru dari berbagai sumber.
     */
    public function index(Request $request): JsonResponse
    {
        $user = auth()->user();
        $since = $request->query('since', now()->subDays(7)->toDateTimeString());
        $notifs = collect();

        // ── Pengumuman baru ──
        $announcements = Pengumuman::with('pembuat')
            ->published()
            ->where('created_at', '>=', $since)
            ->latest()
            ->limit(5)
            ->get();

        foreach ($announcements as $a) {
            $notifs->push([
                'id'       => 'ann-' . $a->id_pengumuman,
                'icon'     => '📢',
                'color'    => 'gold',
                'title'    => 'Pengumuman Baru',
                'desc'     => $a->judul,
                'time'     => $a->created_at->diffForHumans(),
                'url'      => route('dashboard.announcements.show', $a->id_pengumuman),
                'unread'   => true,
            ]);
        }

        // ── Album baru ──
        $albums = DokumentasiAlbum::with('uploader')
            ->where('created_at', '>=', $since)
            ->latest()
            ->limit(3)
            ->get();

        foreach ($albums as $al) {
            $notifs->push([
                'id'       => 'album-' . $al->id_album,
                'icon'     => '📸',
                'color'    => 'blue',
                'title'    => 'Dokumentasi Baru',
                'desc'     => $al->judul,
                'time'     => $al->created_at->diffForHumans(),
                'url'      => route('dashboard.albums.show', $al->id_album),
                'unread'   => true,
            ]);
        }

        // ── Prestasi baru ──
        $achievements = Prestasi::where('created_at', '>=', $since)
            ->latest()
            ->limit(3)
            ->get();

        foreach ($achievements as $p) {
            $notifs->push([
                'id'       => 'prestasi-' . $p->id_prestasi,
                'icon'     => '🏆',
                'color'    => 'yellow',
                'title'    => 'Prestasi Baru',
                'desc'     => $p->nama_lomba . ' - ' . $p->tingkat->shortLabel(),
                'time'     => $p->created_at->diffForHumans(),
                'url'      => route('dashboard.achievements.show', $p->id_prestasi),
                'unread'   => true,
            ]);
        }

        // ── Event mendatang (7 hari) ──
        $events = JadwalKegiatan::whereBetween('tanggal', [now(), now()->addDays(7)])
            ->orderBy('tanggal')
            ->limit(3)
            ->get();

        foreach ($events as $e) {
            $notifs->push([
                'id'       => 'event-' . $e->id_jadwal,
                'icon'     => '📅',
                'color'    => 'purple',
                'title'    => 'Event Mendatang',
                'desc'     => $e->judul . ' · ' . \Carbon\Carbon::parse($e->tanggal)->translatedFormat('d M'),
                'time'     => \Carbon\Carbon::parse($e->tanggal)->diffForHumans(),
                'url'      => route('dashboard.events.show', $e->id_jadwal),
                'unread'   => true,
            ]);
        }

        // ── Kas belum lunas (kalau user = anggota) ──
        if ($user->role->value === 'anggota') {
            $kasBelumLunas = KasPembayaran::where('id_user', $user->id_user)
                ->where('status', 'belum_lunas')
                ->limit(2)
                ->get();

            foreach ($kasBelumLunas as $k) {
                $notifs->push([
                    'id'       => 'kas-' . $k->id_pembayaran,
                    'icon'     => '💰',
                    'color'    => 'red',
                    'title'    => 'Kas Belum Lunas',
                    'desc'     => 'Periode ' . $k->periode_bulan . ' · Rp ' . number_format($k->nominal, 0, ',', '.'),
                    'time'     => 'Segera bayar',
                    'url'      => route('dashboard.cash'),
                    'unread'   => true,
                ]);
            }
        }

        // Sort by time (yang paling baru di atas)
        $notifs = $notifs->sortByDesc('id')->take(10)->values();

        return response()->json([
            'total'   => $notifs->count(),
            'items'   => $notifs,
        ]);
    }
}