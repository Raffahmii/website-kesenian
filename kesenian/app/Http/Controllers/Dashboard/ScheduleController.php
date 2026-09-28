<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\JenisKegiatan;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\JadwalKegiatan;
use App\Services\AttendanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function __construct(
        protected AttendanceService $attendanceService
    ) {}

    public function index(Request $request): View
    {
        $query = JadwalKegiatan::with(['pembuat']);

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('waktu')) {
            if ($request->waktu === 'upcoming') {
                $query->where('tanggal', '>=', now()->toDateString());
            } elseif ($request->waktu === 'past') {
                $query->where('tanggal', '<', now()->toDateString());
            }
        }

        if ($request->filled('q')) {
            $query->where('judul', 'ILIKE', "%{$request->q}%");
        }

        $schedules = $query->orderByDesc('tanggal')
            ->orderByDesc('jam_mulai')
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total'      => JadwalKegiatan::count(),
            'upcoming'   => JadwalKegiatan::where('tanggal', '>=', now()->toDateString())->count(),
            'this_month' => JadwalKegiatan::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count(),
            'completed'  => JadwalKegiatan::where('tanggal', '<', now()->toDateString())->count(),
        ];

        return view('dashboard.schedules.index', compact('schedules', 'stats'));
    }

    public function create(): View
    {
        return view('dashboard.schedules.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul'       => ['required', 'string', 'max:100'],
            'jenis'       => ['required', Rule::enum(JenisKegiatan::class)],
            'deskripsi'   => ['nullable', 'string'],
            'tanggal'     => ['required', 'date'],
            'jam_mulai'   => ['nullable', 'date_format:H:i'],
            'jam_selesai' => ['nullable', 'date_format:H:i', 'after:jam_mulai'],
            'lokasi'      => ['nullable', 'string', 'max:100'],
        ]);

        $validated['id_user_pembuat'] = auth()->id();
        $jadwal = JadwalKegiatan::create($validated);

        AuditLog::record(
            action: 'create',
            module: 'jadwal',
            description: "Buat jadwal: {$jadwal->judul}",
            newValues: $jadwal->only(['judul', 'jenis', 'tanggal', 'lokasi'])
        );

        return redirect()
            ->route('dashboard.events.show', $jadwal->id_jadwal)
            ->with('success', "Jadwal \"{$jadwal->judul}\" berhasil dibuat.");
    }

    public function show(JadwalKegiatan $schedule): View
    {
        $schedule->load(['pembuat']);

        $stats   = $this->attendanceService->getScheduleStats($schedule);
        $absensi = $schedule->absensi()->with('user')->orderBy('waktu_absen', 'desc')->get();
        $cabangStats = $this->attendanceService->getCabangStats($schedule);

        return view('dashboard.schedules.show', compact('schedule', 'stats', 'absensi', 'cabangStats'));
    }

    public function edit(JadwalKegiatan $schedule): View
    {
        return view('dashboard.schedules.edit', compact('schedule'));
    }

    public function update(Request $request, JadwalKegiatan $schedule): RedirectResponse
    {
        $validated = $request->validate([
            'judul'       => ['required', 'string', 'max:100'],
            'jenis'       => ['required', Rule::enum(JenisKegiatan::class)],
            'deskripsi'   => ['nullable', 'string'],
            'tanggal'     => ['required', 'date'],
            'jam_mulai'   => ['nullable', 'date_format:H:i'],
            'jam_selesai' => ['nullable', 'date_format:H:i', 'after:jam_mulai'],
            'lokasi'      => ['nullable', 'string', 'max:100'],
        ]);

        $old = $schedule->only(['judul', 'jenis', 'tanggal', 'lokasi']);
        $schedule->update($validated);

        AuditLog::record(
            action: 'update',
            module: 'jadwal',
            description: "Update jadwal: {$schedule->judul}",
            oldValues: $old,
            newValues: $schedule->only(['judul', 'jenis', 'tanggal', 'lokasi'])
        );

        return redirect()
            ->route('dashboard.events.show', $schedule->id_jadwal)
            ->with('success', 'Jadwal berhasil diupdate.');
    }

    public function destroy(JadwalKegiatan $schedule): RedirectResponse
    {
        $judul = $schedule->judul;
        $schedule->delete();

        AuditLog::record(
            action: 'delete',
            module: 'jadwal',
            description: "Hapus jadwal: {$judul}"
        );

        return redirect()
            ->route('dashboard.events.index')
            ->with('success', "Jadwal \"{$judul}\" berhasil dihapus.");
    }
}