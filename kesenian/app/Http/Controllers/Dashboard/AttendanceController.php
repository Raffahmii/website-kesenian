<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Cabang;
use App\Enums\StatusAbsensi;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AuditLog;
use App\Models\JadwalKegiatan;
use App\Services\AttendanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function __construct(
        protected AttendanceService $attendanceService
    ) {}

    /**
     * Index absensi:
     * - Pengurus: rekap semua absensi
     * - Anggota: riwayat pribadi
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $isPengurus = $user->can('manage-members') || $user->can('access-admin');

        if ($isPengurus) {
            $query = Absensi::with(['user', 'jadwal']);

            if ($request->filled('jadwal')) {
                $query->where('id_jadwal', $request->jadwal);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('q')) {
                $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'ILIKE', "%{$request->q}%"));
            }

            $attendances = $query->orderByDesc('created_at')
                ->paginate(25)
                ->withQueryString();

            $stats = [
                'total' => Absensi::count(),
                'hadir' => Absensi::where('status', StatusAbsensi::HADIR->value)->count(),
                'izin'  => Absensi::where('status', StatusAbsensi::IZIN->value)->count(),
                'alpa'  => Absensi::where('status', StatusAbsensi::ALPA->value)->count(),
            ];

            return view('dashboard.attendances.index', compact('attendances', 'stats', 'isPengurus'));
        }

        // Anggota: riwayat pribadi
        $myAttendances = Absensi::with('jadwal')
            ->where('id_user', $user->id_user)
            ->orderByDesc('created_at')
            ->paginate(15);

        $myStats = $this->attendanceService->getUserStats($user);

        return view('dashboard.attendances.index', compact('myAttendances', 'myStats', 'isPengurus'));
    }

    /**
     * Form input absensi (pilih cabang + input massal).
     */
    public function input(Request $request, JadwalKegiatan $schedule): View
    {
        // Cabang aktif: dari query string, default Padus
        $cabangAktif = $request->query('cabang', Cabang::PADUS->value);

        // Validate cabang
        if (!in_array($cabangAktif, Cabang::values(), true)) {
            $cabangAktif = Cabang::PADUS->value;
        }

        $members  = $this->attendanceService->getMembersByCabang($cabangAktif);
        $existing = $this->attendanceService->getExistingAttendance(
            $schedule->id_jadwal,
            $members->pluck('id_user')->toArray()
        );

        return view('dashboard.attendances.input', compact('schedule', 'cabangAktif', 'members', 'existing'));
    }

    /**
     * Simpan absensi massal.
     */
    public function bulkStore(Request $request, JadwalKegiatan $schedule): RedirectResponse
    {
        $validated = $request->validate([
            'cabang'                     => ['required', Rule::enum(Cabang::class)],
            'attendance'                 => ['required', 'array'],
            'attendance.*.id_user'       => ['required', 'exists:users,id_user'],
            'attendance.*.status'        => ['required', 'in:hadir,izin,sakit,alpa'],
            'attendance.*.keterangan'    => ['nullable', 'string', 'max:255'],
        ]);

        $count = $this->attendanceService->bulkStore($schedule, $validated['attendance']);

        AuditLog::record(
            action: 'create',
            module: 'absensi',
            description: "Input absensi cabang {$validated['cabang']} untuk jadwal {$schedule->judul} ({$count} anggota)",
            newValues: ['cabang' => $validated['cabang'], 'count' => $count]
        );

        return redirect()
            ->route('dashboard.events.show', $schedule->id_jadwal)
            ->with('success', "Absensi cabang " . Cabang::from($validated['cabang'])->shortLabel() . " berhasil disimpan ({$count} anggota).");
    }

    /**
     * Hapus absensi.
     */
    public function destroy(Absensi $attendance): RedirectResponse
    {
        $userName = $attendance->user->nama_lengkap ?? 'Unknown';
        $idJadwal = $attendance->id_jadwal;

        $attendance->delete();

        AuditLog::record(
            action: 'delete',
            module: 'absensi',
            description: "Hapus absensi: {$userName}"
        );

        return redirect()
            ->route('dashboard.events.show', $idJadwal)
            ->with('success', 'Absensi berhasil dihapus.');
    }
}