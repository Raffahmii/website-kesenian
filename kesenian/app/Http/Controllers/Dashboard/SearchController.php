<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DokumentasiAlbum;
use App\Models\JadwalKegiatan;
use App\Models\Pengumuman;
use App\Models\Prestasi;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Endpoint AJAX global search.
     */
    public function search(Request $request): JsonResponse
    {
        $q = $request->query('q');

        if (!$q || strlen($q) < 2) {
            return response()->json(['results' => []]);
        }

        $results = collect();

        // ── Anggota ──
        $members = User::where(function ($sub) use ($q) {
                $sub->where('nama_lengkap', 'ILIKE', "%{$q}%")
                    ->orWhere('nis', 'ILIKE', "%{$q}%");
            })
            ->limit(4)
            ->get(['id_user', 'nama_lengkap', 'nis', 'cabang', 'photo']);

        foreach ($members as $m) {
            $results->push([
                'type'     => 'Anggota',
                'icon'     => '👤',
                'title'    => $m->nama_lengkap,
                'subtitle' => $m->nis ? "NIS: {$m->nis}" : ($m->cabang?->shortLabel() ?? ''),
                'url'      => route('users.show', $m->id_user),
            ]);
        }

        // ── Event ──
        $events = JadwalKegiatan::where('judul', 'ILIKE', "%{$q}%")
            ->limit(3)
            ->get();

        foreach ($events as $e) {
            $results->push([
                'type'     => 'Event',
                'icon'     => '📅',
                'title'    => $e->judul,
                'subtitle' => \Carbon\Carbon::parse($e->tanggal)->format('d M Y'),
                'url'      => route('dashboard.events.show', $e->id_jadwal),
            ]);
        }

        // ── Prestasi ──
        $achievements = Prestasi::where('nama_lomba', 'ILIKE', "%{$q}%")
            ->limit(3)
            ->get();

        foreach ($achievements as $a) {
            $results->push([
                'type'     => 'Prestasi',
                'icon'     => '🏆',
                'title'    => $a->nama_lomba,
                'subtitle' => $a->tingkat->shortLabel() . ' · ' . $a->tahun,
                'url'      => route('dashboard.achievements.show', $a->id_prestasi),
            ]);
        }

        // ── Album ──
        $albums = DokumentasiAlbum::where('judul', 'ILIKE', "%{$q}%")
            ->limit(3)
            ->get();

        foreach ($albums as $al) {
            $results->push([
                'type'     => 'Album',
                'icon'     => '📸',
                'title'    => $al->judul,
                'subtitle' => $al->kategori ?? 'Dokumentasi',
                'url'      => route('dashboard.albums.show', $al->id_album),
            ]);
        }

        // ── Pengumuman ──
        $announcements = Pengumuman::where('judul', 'ILIKE', "%{$q}%")
            ->where('is_published', true)
            ->limit(3)
            ->get();

        foreach ($announcements as $an) {
            $results->push([
                'type'     => 'Pengumuman',
                'icon'     => '📢',
                'title'    => $an->judul,
                'subtitle' => $an->target_role->label(),
                'url'      => route('dashboard.announcements.show', $an->id_pengumuman),
            ]);
        }

        return response()->json([
            'results' => $results->take(10)->values(),
        ]);
    }
}