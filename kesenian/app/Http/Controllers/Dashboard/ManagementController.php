<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Jabatan;
use App\Models\Kepengurusan;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ManagementController extends Controller
{
    /**
     * List kepengurusan per periode.
     */
    public function index(Request $request): View
    {
        $periodeId = $request->query('periode');
        $periodes = Periode::orderByDesc('tahun_mulai')->get();
        $periodeAktif = $periodeId
            ? Periode::find($periodeId)
            : Periode::where('is_active', true)->first() ?? $periodes->first();

        $kepengurusan = collect();
        if ($periodeAktif) {
            $kepengurusan = Kepengurusan::with(['user', 'jabatan', 'periode'])
                ->where('id_periode', $periodeAktif->id_periode)
                ->orderByRaw('(SELECT level FROM jabatan WHERE jabatan.id_jabatan = kepengurusan.id_jabatan) ASC')
                ->get();
        }

        return view('dashboard.management.index', compact('periodes', 'periodeAktif', 'kepengurusan'));
    }

    /**
     * Form tambah kepengurusan.
     */
    public function create(Request $request): View
    {
        $periodes = Periode::orderByDesc('tahun_mulai')->get();
        $jabatans = Jabatan::ordered()->get();
        $members = User::where('status_anggota', 'aktif')
            ->orderBy('nama_lengkap')
            ->get(['id_user', 'nama_lengkap', 'kelas', 'jurusan', 'cabang']);

        return view('dashboard.management.create', compact('periodes', 'jabatans', 'members'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_user'         => ['required', 'exists:users,id_user'],
            'id_jabatan'      => ['required', 'exists:jabatan,id_jabatan'],
            'id_periode'      => ['required', 'exists:periode,id_periode'],
            'sk_number'       => ['nullable', 'string', 'max:50'],
            'tanggal_mulai'   => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after:tanggal_mulai'],
            'is_active'       => ['boolean'],
        ]);

        // Cek duplikat
        $exists = Kepengurusan::where('id_user', $validated['id_user'])
            ->where('id_jabatan', $validated['id_jabatan'])
            ->where('id_periode', $validated['id_periode'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'User sudah punya jabatan ini di periode yang sama.');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $kep = Kepengurusan::create($validated);

        AuditLog::record(
            action: 'create',
            module: 'kepengurusan',
            description: "Tambah kepengurusan: {$kep->user->nama_lengkap} - {$kep->jabatan->nama_jabatan}"
        );

        return redirect()
            ->route('dashboard.management', ['periode' => $validated['id_periode']])
            ->with('success', 'Kepengurusan berhasil ditambahkan.');
    }

    public function edit(Kepengurusan $management): View
    {
        $periodes = Periode::orderByDesc('tahun_mulai')->get();
        $jabatans = Jabatan::ordered()->get();
        $members = User::where('status_anggota', 'aktif')
            ->orderBy('nama_lengkap')
            ->get(['id_user', 'nama_lengkap', 'kelas', 'jurusan', 'cabang']);

        return view('dashboard.management.edit', compact('management', 'periodes', 'jabatans', 'members'));
    }

    public function update(Request $request, Kepengurusan $management): RedirectResponse
    {
        $validated = $request->validate([
            'id_user'         => ['required', 'exists:users,id_user'],
            'id_jabatan'      => ['required', 'exists:jabatan,id_jabatan'],
            'id_periode'      => ['required', 'exists:periode,id_periode'],
            'sk_number'       => ['nullable', 'string', 'max:50'],
            'tanggal_mulai'   => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after:tanggal_mulai'],
            'is_active'       => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $management->update($validated);

        AuditLog::record(
            action: 'update',
            module: 'kepengurusan',
            description: "Update kepengurusan: {$management->user->nama_lengkap}"
        );

        return redirect()
            ->route('dashboard.management', ['periode' => $validated['id_periode']])
            ->with('success', 'Kepengurusan berhasil diupdate.');
    }

    public function destroy(Kepengurusan $management): RedirectResponse
    {
        $nama = $management->user->nama_lengkap ?? 'Unknown';
        $periode = $management->id_periode;

        $management->delete();

        AuditLog::record(
            action: 'delete',
            module: 'kepengurusan',
            description: "Hapus kepengurusan: {$nama}"
        );

        return redirect()
            ->route('dashboard.management', ['periode' => $periode])
            ->with('success', "Kepengurusan {$nama} berhasil dihapus.");
    }

    // ═══════════════════════════════════════
    // JABATAN CRUD
    // ═══════════════════════════════════════

    public function jabatan(): View
    {
        $periodeAktif = Periode::where('is_active', true)->first();

        // Counter kepengurusan per jabatan, HANYA di periode aktif
        $jabatans = Jabatan::withCount([
                'kepengurusan' => function ($q) use ($periodeAktif) {
                    if ($periodeAktif) {
                        $q->where('id_periode', $periodeAktif->id_periode)
                          ->where('is_active', true);
                    }
                }
            ])
            ->ordered()
            ->get();

        return view('dashboard.management.jabatan', compact('jabatans', 'periodeAktif'));
    }

    public function storeJabatan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jabatan' => ['required', 'string', 'max:50', 'unique:jabatan,nama_jabatan'],
            'level'        => ['nullable', 'integer', 'min:1', 'max:100'],
            'divisi'       => ['nullable', 'string', 'max:50'],
            'deskripsi'    => ['nullable', 'string'],
        ]);

        $jabatan = Jabatan::create($validated);

        AuditLog::record('create', 'jabatan', "Tambah jabatan: {$jabatan->nama_jabatan}");

        return back()->with('success', "Jabatan \"{$jabatan->nama_jabatan}\" berhasil ditambahkan.");
    }

    public function updateJabatan(Request $request, Jabatan $jabatan): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jabatan' => ['required', 'string', 'max:50', Rule::unique('jabatan', 'nama_jabatan')->ignore($jabatan->id_jabatan, 'id_jabatan')],
            'level'        => ['nullable', 'integer', 'min:1', 'max:100'],
            'divisi'       => ['nullable', 'string', 'max:50'],
            'deskripsi'    => ['nullable', 'string'],
        ]);

        $jabatan->update($validated);

        AuditLog::record('update', 'jabatan', "Update jabatan: {$jabatan->nama_jabatan}");

        return back()->with('success', 'Jabatan berhasil diupdate.');
    }

    public function destroyJabatan(Jabatan $jabatan): RedirectResponse
    {
        $periodeAktif = Periode::where('is_active', true)->first();

        $count = $jabatan->kepengurusan()
            ->when($periodeAktif, fn($q) => $q->where('id_periode', $periodeAktif->id_periode))
            ->where('is_active', true)
            ->count();

        if ($count > 0) {
            return back()->with('error', 'Jabatan masih dipakai di periode aktif.');
        }

        $nama = $jabatan->nama_jabatan;
        $jabatan->delete();

        AuditLog::record('delete', 'jabatan', "Hapus jabatan: {$nama}");

        return back()->with('success', "Jabatan \"{$nama}\" berhasil dihapus.");
    }
}