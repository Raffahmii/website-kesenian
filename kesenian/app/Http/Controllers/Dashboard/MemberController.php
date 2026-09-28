<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Cabang;
use App\Enums\RoleUser;
use App\Enums\StatusAnggota;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Jabatan;
use App\Models\Kepengurusan;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MemberController extends Controller
{
    // ═══════════════════════════════════════
    // LIST / INDEX
    // ═══════════════════════════════════════

    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_lengkap', 'ILIKE', "%{$q}%")
                    ->orWhere('email', 'ILIKE', "%{$q}%")
                    ->orWhere('nis', 'ILIKE', "%{$q}%");
            });
        }

        // ✅ Default: filter ke "aktif" kecuali user pilih "semua" / filter lain
        $statusFilter = $request->input('status', 'aktif');
        if ($statusFilter && $statusFilter !== 'semua') {
            $query->where('status_anggota', $statusFilter);
        }

        if ($request->filled('role'))   $query->where('role', $request->role);
        if ($request->filled('cabang')) $query->where('cabang', $request->cabang);
        if ($request->filled('kelas'))  $query->where('kelas', $request->kelas);

        $members = $query->orderByRaw("
                CASE role
                    WHEN 'pembina' THEN 1
                    WHEN 'ketua' THEN 2
                    WHEN 'wakil_ketua' THEN 3
                    WHEN 'sekretaris' THEN 4
                    WHEN 'bendahara' THEN 5
                    WHEN 'pdd' THEN 6
                    ELSE 7
                END
            ")
            ->orderBy('nama_lengkap')
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total'    => User::count(),
            'aktif'    => User::where('status_anggota', StatusAnggota::AKTIF->value)->count(),
            'alumni'   => User::where('status_anggota', StatusAnggota::ALUMNI->value)->count(),
            'nonaktif' => User::where('status_anggota', StatusAnggota::NONAKTIF->value)->count(),
        ];

        // Data buat form Alumni Massal & Serah Terima
        $angkatanList = User::where('status_anggota', StatusAnggota::AKTIF->value)
            ->whereNotNull('angkatan')
            ->select('angkatan')
            ->distinct()
            ->orderByDesc('angkatan')
            ->pluck('angkatan');

        $periodeAktif = Periode::where('is_active', true)->first();

        $pengurusAktif = Kepengurusan::with(['user', 'jabatan'])
            ->where('id_periode', $periodeAktif?->id_periode)
            ->where('is_active', true)
            ->orderBy('id_jabatan')
            ->get();

        $membersAktif = User::where('status_anggota', StatusAnggota::AKTIF->value)
            ->orderBy('nama_lengkap')
            ->get(['id_user', 'nama_lengkap', 'nis', 'kelas', 'jurusan', 'cabang', 'photo', 'role']);

        return view('dashboard.members.index', compact(
            'members', 'stats',
            'angkatanList', 'periodeAktif', 'pengurusAktif', 'membersAktif'
        ));
    }

    // ═══════════════════════════════════════
    // CRUD DASAR
    // ═══════════════════════════════════════

    public function create(): View
    {
        return view('dashboard.members.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_lengkap'   => ['required', 'string', 'max:100'],
            'email'          => ['required', 'email', 'max:100', 'unique:users,email'],
            'password'       => ['required', 'string', 'min:8'],
            'nis'            => ['nullable', 'string', 'max:20', 'unique:users,nis'],
            'role'           => ['required', Rule::enum(RoleUser::class)],
            'cabang'         => ['nullable', Rule::enum(Cabang::class)],
            'kelas'          => ['nullable', 'string', 'max:20'],
            'jurusan'        => ['nullable', 'string', 'max:50'],
            'angkatan'       => ['nullable', 'string', 'max:10'],
            'status_anggota' => ['required', Rule::enum(StatusAnggota::class)],
            'phone'          => ['nullable', 'string', 'max:15'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        $user->assignRole($validated['role']);

        $this->syncKepengurusan($user);

        AuditLog::record(
            action: 'create',
            module: 'anggota',
            description: "Tambah anggota: {$user->nama_lengkap}",
            newValues: $user->only(['nama_lengkap', 'email', 'role', 'cabang', 'status_anggota'])
        );

        return redirect()
            ->route('dashboard.members.index')
            ->with('success', "Anggota {$user->nama_lengkap} berhasil ditambahkan.");
    }

    public function show(User $member): View
    {
        $member->load(['kepengurusan.jabatan', 'kepengurusan.periode']);
        return view('dashboard.members.show', compact('member'));
    }

    public function edit(User $member): View
    {
        return view('dashboard.members.edit', compact('member'));
    }

    public function update(Request $request, User $member): RedirectResponse
    {
        $validated = $request->validate([
            'nama_lengkap'   => ['required', 'string', 'max:100'],
            'email'          => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($member->id_user, 'id_user')],
            'password'       => ['nullable', 'string', 'min:8'],
            'nis'            => ['nullable', 'string', 'max:20', Rule::unique('users', 'nis')->ignore($member->id_user, 'id_user')],
            'role'           => ['required', Rule::enum(RoleUser::class)],
            'cabang'         => ['nullable', Rule::enum(Cabang::class)],
            'kelas'          => ['nullable', 'string', 'max:20'],
            'jurusan'        => ['nullable', 'string', 'max:50'],
            'angkatan'       => ['nullable', 'string', 'max:10'],
            'status_anggota' => ['required', Rule::enum(StatusAnggota::class)],
            'phone'          => ['nullable', 'string', 'max:15'],
        ]);

        $oldValues = $member->only(['nama_lengkap', 'email', 'role', 'cabang', 'status_anggota', 'kelas', 'jurusan']);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $member->update($validated);
        $member->syncRoles([$validated['role']]);

        $this->syncKepengurusan($member);

        AuditLog::record(
            action: 'update',
            module: 'anggota',
            description: "Update anggota: {$member->nama_lengkap}",
            oldValues: $oldValues,
            newValues: $member->only(['nama_lengkap', 'email', 'role', 'cabang', 'status_anggota', 'kelas', 'jurusan'])
        );

        return redirect()
            ->route('dashboard.members.index')
            ->with('success', "Data {$member->nama_lengkap} berhasil diupdate.");
    }

    public function destroy(User $member): RedirectResponse
    {
        if ($member->id_user === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $nama = $member->nama_lengkap;

        $member->kepengurusan()->delete();
        $member->delete();

        AuditLog::record(
            action: 'delete',
            module: 'anggota',
            description: "Hapus anggota: {$nama}"
        );

        return redirect()
            ->route('dashboard.members.index')
            ->with('success', "Anggota {$nama} berhasil dihapus.");
    }

    // ═══════════════════════════════════════
    // PROMOTE (NAIK KELAS)
    // ═══════════════════════════════════════

    public function promote(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'dari_kelas' => ['required', 'string'],
            'ke_kelas'   => ['required', 'string'],
        ]);

        $count = User::where('kelas', $validated['dari_kelas'])
            ->where('status_anggota', StatusAnggota::AKTIF->value)
            ->update(['kelas' => $validated['ke_kelas']]);

        AuditLog::record(
            action: 'update',
            module: 'anggota',
            description: "Naik kelas massal: {$validated['dari_kelas']} → {$validated['ke_kelas']} ({$count} anggota)"
        );

        return back()->with('success', "Berhasil naikkan {$count} anggota.");
    }

    // ═══════════════════════════════════════
    // ALUMNI MASSAL
    // ═══════════════════════════════════════

    public function alumniMassal(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'angkatan' => ['required', 'string', 'max:10'],
        ]);

        $users = User::where('angkatan', $validated['angkatan'])
            ->where('status_anggota', StatusAnggota::AKTIF->value)
            ->get();

        if ($users->isEmpty()) {
            return back()->with('error', "Tidak ada anggota aktif dengan angkatan {$validated['angkatan']}.");
        }

        $total = 0;

        DB::beginTransaction();
        try {
            foreach ($users as $user) {
                $user->update([
                    'status_anggota' => StatusAnggota::ALUMNI->value,
                ]);

                Kepengurusan::where('id_user', $user->id_user)
                    ->update(['is_active' => false]);

                $total++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal alumni massal: ' . $e->getMessage());
        }

        AuditLog::record(
            action: 'update',
            module: 'anggota',
            description: "Alumni massal angkatan {$validated['angkatan']} ({$total} anggota)",
            newValues: ['angkatan' => $validated['angkatan'], 'total' => $total]
        );

        return back()->with('success', "Berhasil! {$total} anggota angkatan {$validated['angkatan']} sekarang jadi alumni.");
    }

    // ═══════════════════════════════════════
    // SERAH TERIMA JABATAN
    // ═══════════════════════════════════════

    /**
     * Serah terima jabatan: senior purna → junior gantikan.
     * 
     * KONSEP:
     * - Senior jadi alumni + role di-reset ke anggota
     * - Junior DAPET ROLE baru (buat akses dashboard)
     * - Kepengurusan TIDAK otomatis dibuat — di-assign manual lewat /dashboard/management
     */
    public function serahTerima(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_user_lama' => ['required', 'exists:users,id_user'],
            'id_user_baru' => ['required', 'exists:users,id_user', 'different:id_user_lama'],
            'id_periode'   => ['required', 'exists:periode,id_periode'],
        ]);

        $userLama = User::findOrFail($validated['id_user_lama']);
        $userBaru = User::findOrFail($validated['id_user_baru']);

        // Ambil jabatan user lama (aktif di periode manapun)
        $kepLama = Kepengurusan::with('jabatan')
            ->where('id_user', $userLama->id_user)
            ->where('is_active', true)
            ->get();

        if ($kepLama->isEmpty()) {
            return back()->with('error', "{$userLama->nama_lengkap} tidak punya jabatan aktif.");
        }

        // Cek user baru — jangan kalau dia udah punya jabatan non-anggota
        $punyaJabatanInti = Kepengurusan::where('id_user', $userBaru->id_user)
            ->where('is_active', true)
            ->whereHas('jabatan', function ($q) {
                $q->where('level', '!=', 99)
                  ->where('nama_jabatan', '!=', 'Anggota');
            })
            ->exists();

        if ($punyaJabatanInti) {
            return back()->with('error', "{$userBaru->nama_lengkap} sudah punya jabatan inti. Nonaktifkan dulu.");
        }

        // Ambil role tertinggi dari user lama (yang mau diwarisi ke user baru)
        $jabatanTertinggi = $kepLama->sortBy(fn($k) => $k->jabatan->level ?? 99)->first();
        $roleWarisan = RoleUser::ANGGOTA;

        if ($jabatanTertinggi) {
            $roleMap = [
                'Ketua'        => RoleUser::KETUA,
                'Wakil Ketua'  => RoleUser::WAKIL_KETUA,
                'Sekretaris 1' => RoleUser::SEKRETARIS,
                'Sekretaris 2' => RoleUser::SEKRETARIS,
                'Bendahara 1'  => RoleUser::BENDAHARA,
                'Bendahara 2'  => RoleUser::BENDAHARA,
                'PDD'          => RoleUser::PDD,
                'Pembina'      => RoleUser::PEMBINA,
            ];
            $namaJabatan = $jabatanTertinggi->jabatan->nama_jabatan ?? '';
            $roleWarisan = $roleMap[$namaJabatan] ?? RoleUser::ANGGOTA;
        }

        DB::beginTransaction();
        try {
            // ── 1. Nonaktifkan semua kepengurusan user lama ──
            Kepengurusan::where('id_user', $userLama->id_user)
                ->where('is_active', true)
                ->update([
                    'is_active'       => false,
                    'tanggal_selesai' => now()->format('Y-m-d'),
                ]);

            // ── 2. Nonaktifkan jabatan "Anggota" user baru (kalau ada) ──
            Kepengurusan::where('id_user', $userBaru->id_user)
                ->where('is_active', true)
                ->whereHas('jabatan', function ($q) {
                    $q->where(function ($sub) {
                        $sub->where('level', 99)
                            ->orWhere('nama_jabatan', 'Anggota');
                    });
                })
                ->update([
                    'is_active'       => false,
                    'tanggal_selesai' => now()->format('Y-m-d'),
                ]);

            // ── 3. User lama jadi alumni + reset role ke anggota ──
            $userLama->update([
                'status_anggota' => StatusAnggota::ALUMNI->value,
                'role'           => RoleUser::ANGGOTA->value,
            ]);
            $userLama->syncRoles([RoleUser::ANGGOTA->value]);

            // ── 4. User baru DAPET ROLE baru (buat akses dashboard) ──
            //     TAPI TIDAK otomatis masuk kepengurusan
            $userBaru->update([
                'role' => $roleWarisan->value,
            ]);
            $userBaru->syncRoles([$roleWarisan->value]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal serah terima: ' . $e->getMessage());
        }

        $jabatanList = $kepLama->pluck('jabatan.nama_jabatan')->implode(', ');

        AuditLog::record(
            action: 'update',
            module: 'anggota',
            description: "Serah terima: {$userLama->nama_lengkap} → {$userBaru->nama_lengkap} ({$jabatanList})",
            newValues: [
                'dari'    => $userLama->nama_lengkap,
                'ke'      => $userBaru->nama_lengkap,
                'jabatan' => $jabatanList,
                'role_diberikan' => $roleWarisan->value,
            ]
        );

        return back()->with('success', "Serah terima berhasil! {$userBaru->nama_lengkap} sekarang punya akses role " . $roleWarisan->label() . ". Jangan lupa tambahkan ke kepengurusan lewat menu Kepengurusan.");
    }

    // ═══════════════════════════════════════
    // HELPER: SYNC KEPENGURUSAN
    // ═══════════════════════════════════════

    protected function syncKepengurusan(User $user): void
    {
        $periodeAktif = Periode::where('is_active', true)->first();
        if (!$periodeAktif) return;

        if ($user->status_anggota !== StatusAnggota::AKTIF) {
            Kepengurusan::where('id_user', $user->id_user)
                ->update(['is_active' => false]);
            return;
        }

        $existing = Kepengurusan::where('id_user', $user->id_user)
            ->where('id_periode', $periodeAktif->id_periode)
            ->first();

        if ($existing) {
            $existing->update(['is_active' => true]);
            return;
        }

        $jabatanName = match ($user->role) {
            RoleUser::KETUA       => 'Ketua',
            RoleUser::WAKIL_KETUA => 'Wakil Ketua',
            RoleUser::SEKRETARIS  => 'Sekretaris 1',
            RoleUser::BENDAHARA   => 'Bendahara 1',
            RoleUser::PDD         => 'PDD',
            RoleUser::PEMBINA     => 'Pembina',
            RoleUser::ANGGOTA     => 'Anggota',
        };

        $jabatan = Jabatan::where('nama_jabatan', $jabatanName)->first();
        if (!$jabatan) return;

        Kepengurusan::create([
            'id_user'         => $user->id_user,
            'id_jabatan'      => $jabatan->id_jabatan,
            'id_periode'      => $periodeAktif->id_periode,
            'tanggal_mulai'   => $periodeAktif->tahun_mulai . '-07-01',
            'tanggal_selesai' => $periodeAktif->tahun_selesai . '-06-30',
            'is_active'       => true,
        ]);
    }
}