<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\TingkatPrestasi;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAchievementRequest;
use App\Models\AuditLog;
use App\Models\Prestasi;
use App\Models\PrestasiPeserta;
use App\Models\User;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AchievementController extends Controller
{
    public function __construct(
        protected ImageUploadService $imageService
    ) {}

    public function index(Request $request): View
    {
        $query = Prestasi::with(['peserta.user', 'pencatat'])
            ->withCount('peserta');

        if ($request->filled('q')) {
            $query->where('nama_lomba', 'ILIKE', "%{$request->q}%");
        }

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $achievements = $query->orderByDesc('tahun')
            ->orderByDesc('tanggal')
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'total'      => Prestasi::count(),
            'nasional'   => Prestasi::where('tingkat', TingkatPrestasi::NASIONAL->value)->count(),
            'provinsi'   => Prestasi::where('tingkat', TingkatPrestasi::PROVINSI->value)->count(),
            'kabupaten'  => Prestasi::where('tingkat', TingkatPrestasi::KABUPATEN->value)->count(),
        ];

        $tahunList = Prestasi::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');
        $kategoris = Prestasi::select('kategori')->whereNotNull('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('dashboard.achievements.index', compact('achievements', 'stats', 'tahunList', 'kategoris'));
    }

    public function create(): View
    {
        $members = User::where('status_anggota', 'aktif')
            ->orderBy('nama_lengkap')
            ->get(['id_user', 'nama_lengkap', 'kelas', 'jurusan', 'cabang', 'photo']);

        return view('dashboard.achievements.create', compact('members'));
    }

    public function store(StoreAchievementRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Upload foto
        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->imageService->uploadImage($request->file('foto'), 'achievements', 1200);
        }

        $validated['id_user_pencatat'] = auth()->id();
        $pesertaIds = $validated['peserta'] ?? [];
        unset($validated['peserta']);

        DB::beginTransaction();
        try {
            $prestasi = Prestasi::create($validated);

            // Attach peserta
            foreach ($pesertaIds as $userId) {
                PrestasiPeserta::create([
                    'id_prestasi' => $prestasi->id_prestasi,
                    'id_user'     => $userId,
                    'peran'       => 'peserta',
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }

        AuditLog::record(
            action: 'create',
            module: 'prestasi',
            description: "Tambah prestasi: {$prestasi->nama_lomba}",
            newValues: $prestasi->only(['nama_lomba', 'tingkat', 'tahun', 'peringkat'])
        );

        return redirect()
            ->route('dashboard.achievements.show', $prestasi->id_prestasi)
            ->with('success', "Prestasi \"{$prestasi->nama_lomba}\" berhasil ditambahkan.");
    }

    public function show(Prestasi $achievement): View
    {
        $achievement->load(['peserta.user', 'pencatat']);
        return view('dashboard.achievements.show', compact('achievement'));
    }

    public function edit(Prestasi $achievement): View
    {
        $achievement->load('peserta');
        $members = User::where('status_anggota', 'aktif')
            ->orderBy('nama_lengkap')
            ->get(['id_user', 'nama_lengkap', 'kelas', 'jurusan', 'cabang', 'photo']);
        $selectedPeserta = $achievement->peserta->pluck('id_user')->toArray();

        return view('dashboard.achievements.edit', compact('achievement', 'members', 'selectedPeserta'));
    }

    public function update(StoreAchievementRequest $request, Prestasi $achievement): RedirectResponse
    {
        $validated = $request->validated();

        // Upload foto baru
        if ($request->hasFile('foto')) {
            $this->imageService->delete($achievement->foto);
            $validated['foto'] = $this->imageService->uploadImage($request->file('foto'), 'achievements', 1200);
        }

        $pesertaIds = $validated['peserta'] ?? [];
        unset($validated['peserta']);

        $old = $achievement->only(['nama_lomba', 'tingkat', 'tahun', 'peringkat']);

        DB::beginTransaction();
        try {
            $achievement->update($validated);

            // Sync peserta
            $achievement->peserta()->delete();
            foreach ($pesertaIds as $userId) {
                PrestasiPeserta::create([
                    'id_prestasi' => $achievement->id_prestasi,
                    'id_user'     => $userId,
                    'peran'       => 'peserta',
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update: ' . $e->getMessage())->withInput();
        }

        AuditLog::record(
            action: 'update',
            module: 'prestasi',
            description: "Update prestasi: {$achievement->nama_lomba}",
            oldValues: $old,
            newValues: $achievement->only(['nama_lomba', 'tingkat', 'tahun', 'peringkat'])
        );

        return redirect()
            ->route('dashboard.achievements.show', $achievement->id_prestasi)
            ->with('success', 'Prestasi berhasil diupdate.');
    }

    public function destroy(Prestasi $achievement): RedirectResponse
    {
        $nama = $achievement->nama_lomba;

        // Hapus foto
        $this->imageService->delete($achievement->foto);

        $achievement->delete(); // peserta kehapus otomatis karena cascade

        AuditLog::record(
            action: 'delete',
            module: 'prestasi',
            description: "Hapus prestasi: {$nama}"
        );

        return redirect()
            ->route('dashboard.achievements.index')
            ->with('success', "Prestasi \"{$nama}\" berhasil dihapus.");
    }
}