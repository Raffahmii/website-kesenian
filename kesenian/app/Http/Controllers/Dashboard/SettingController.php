<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Periode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Models\Kepengurusan;

class SettingController extends Controller
{

    /**
     * Copy Pembina dari periode lain ke periode target.
     */
    protected function copyPembinaToPeriode(Periode $targetPeriode, ?Periode $sourcePeriode = null): void
    {
        // Ambil periode sebelumnya (yang paling baru sebelum target)
        if (!$sourcePeriode) {
            $sourcePeriode = Periode::where('id_periode', '!=', $targetPeriode->id_periode)
                ->where('tahun_mulai', '<', $targetPeriode->tahun_mulai)
                ->orderByDesc('tahun_mulai')
                ->first();
        }

        if (!$sourcePeriode) return;

        // Ambil semua Pembina dari periode sumber
        $pembinas = Kepengurusan::where('id_periode', $sourcePeriode->id_periode)
            ->whereHas('jabatan', fn($q) => $q->where('nama_jabatan', 'Pembina'))
            ->with('jabatan')
            ->get();

        foreach ($pembinas as $kep) {
            // Cek udah ada belum di periode target
            $exists = Kepengurusan::where('id_user', $kep->id_user)
                ->where('id_jabatan', $kep->id_jabatan)
                ->where('id_periode', $targetPeriode->id_periode)
                ->exists();

            if ($exists) continue;

            // Copy ke periode target
            Kepengurusan::create([
                'id_user'         => $kep->id_user,
                'id_jabatan'      => $kep->id_jabatan,
                'id_periode'      => $targetPeriode->id_periode,
                'sk_number'       => 'SK/' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT) . '/GA/' . $targetPeriode->tahun_mulai,
                'tanggal_mulai'   => $targetPeriode->tahun_mulai . '-07-01',
                'tanggal_selesai' => $targetPeriode->tahun_selesai . '-06-30',
                'is_active'       => true,
            ]);
        }
    }
    public function index(): View
    {
        $periodes = Periode::withCount('kepengurusan')->orderByDesc('tahun_mulai')->get();
        $periodeAktif = Periode::where('is_active', true)->first();

        $info = [
            'php_version'     => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database'        => config('database.default'),
            'timezone'        => config('app.timezone'),
            'total_data'      => [
                'anggota'    => \App\Models\User::count(),
                'kegiatan'   => \App\Models\JadwalKegiatan::count(),
                'absensi'    => \App\Models\Absensi::count(),
                'kas'        => \App\Models\KasPembayaran::count(),
                'album'      => \App\Models\DokumentasiAlbum::count(),
                'prestasi'   => \App\Models\Prestasi::count(),
                'pengumuman' => \App\Models\Pengumuman::count(),
                'audit_log'  => \App\Models\AuditLog::count(),
            ],
        ];

        return view('dashboard.settings.index', compact('periodes', 'periodeAktif', 'info'));
    }

    // ═══════════════════════════════════════
    // PERIODE CRUD
    // ═══════════════════════════════════════

    public function storePeriode(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_periode'  => ['required', 'string', 'max:20', 'unique:periode,nama_periode'],
            'tahun_mulai'   => ['required', 'integer', 'min:2000', 'max:2100'],
            'tahun_selesai' => ['required', 'integer', 'min:2000', 'max:2100', 'after:tahun_mulai'],
            'is_active'     => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        // Kalau aktif, nonaktifkan yang lain
        if ($validated['is_active']) {
            Periode::query()->update(['is_active' => false]);
        }

        $periode = Periode::create($validated);

        // Copy Pembina dari periode sebelumnya
        $this->copyPembinaToPeriode($periode);

        AuditLog::record('create', 'setting', "Tambah periode: {$periode->nama_periode}");

        return back()->with('success', "Periode \"{$periode->nama_periode}\" berhasil ditambahkan. Pembina otomatis di-copy dari periode sebelumnya.");
    }

    public function updatePeriode(Request $request, Periode $periode): RedirectResponse
    {
        $validated = $request->validate([
            'nama_periode'  => ['required', 'string', 'max:20', Rule::unique('periode', 'nama_periode')->ignore($periode->id_periode, 'id_periode')],
            'tahun_mulai'   => ['required', 'integer', 'min:2000', 'max:2100'],
            'tahun_selesai' => ['required', 'integer', 'min:2000', 'max:2100', 'after:tahun_mulai'],
        ]);

        $periode->update($validated);

        AuditLog::record('update', 'setting', "Update periode: {$periode->nama_periode}");

        return back()->with('success', 'Periode berhasil diupdate.');
    }

    public function destroyPeriode(Periode $periode): RedirectResponse
    {
        if ($periode->kepengurusan()->count() > 0) {
            return back()->with('error', 'Periode masih punya data kepengurusan. Tidak bisa dihapus.');
        }

        if ($periode->is_active) {
            return back()->with('error', 'Tidak bisa hapus periode aktif. Aktifkan periode lain dulu.');
        }

        $nama = $periode->nama_periode;
        $periode->delete();

        AuditLog::record('delete', 'setting', "Hapus periode: {$nama}");

        return back()->with('success', "Periode \"{$nama}\" berhasil dihapus.");
    }

    public function activatePeriode(Periode $periode): RedirectResponse
    {
        $oldPeriode = Periode::where('is_active', true)->first();

        Periode::query()->update(['is_active' => false]);
        $periode->update(['is_active' => true]);

        // Copy Pembina dari periode sebelumnya
        $this->copyPembinaToPeriode($periode, $oldPeriode);

        AuditLog::record('update', 'setting', "Aktifkan periode: {$periode->nama_periode}");

        return back()->with('success', "Periode {$periode->nama_periode} berhasil diaktifkan. Pembina otomatis di-copy.");
    }

    public function clearCache(): RedirectResponse
    {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');

        AuditLog::record('update', 'setting', 'Clear cache aplikasi');

        return back()->with('success', 'Cache berhasil dibersihkan.');
    }
}