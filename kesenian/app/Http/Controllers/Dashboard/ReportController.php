<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\StatusAnggota;
use App\Enums\StatusAbsensi;
use App\Enums\StatusKas;
use App\Enums\TingkatPrestasi;
use App\Exports\AchievementExport;
use App\Exports\AttendanceExport;
use App\Exports\KasExport;
use App\Exports\MembersExport;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AuditLog;
use App\Models\JadwalKegiatan;
use App\Models\KasPembayaran;
use App\Models\Prestasi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function index(): View
    {
        // Statistik umum
        $stats = [
            'total_anggota'   => User::count(),
            'anggota_aktif'   => User::where('status_anggota', StatusAnggota::AKTIF->value)->count(),
            'total_prestasi'  => Prestasi::count(),
            'total_kegiatan'  => JadwalKegiatan::count(),
            'kas_bulan_ini'   => KasPembayaran::where('periode_bulan', now()->format('Y-m'))->where('status', StatusKas::LUNAS->value)->sum('nominal'),
            'total_absensi'   => Absensi::count(),
        ];

        // Statistik anggota per cabang
        $anggotaPerCabang = User::where('status_anggota', StatusAnggota::AKTIF->value)
            ->selectRaw('cabang, COUNT(*) as total')
            ->groupBy('cabang')
            ->pluck('total', 'cabang')
            ->toArray();

        // Prestasi per tingkat
        $prestasiPerTingkat = Prestasi::selectRaw('tingkat, COUNT(*) as total')
            ->groupBy('tingkat')
            ->pluck('total', 'tingkat')
            ->toArray();

        // Absensi 30 hari terakhir
        $absensiTerakhir = Absensi::where('created_at', '>=', now()->subDays(30))
            ->selectRaw("status, COUNT(*) as total")
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('dashboard.reports.index', compact('stats', 'anggotaPerCabang', 'prestasiPerTingkat', 'absensiTerakhir'));
    }

    /**
     * Export Anggota.
     */
    public function exportMembers(Request $request)
    {
        AuditLog::record('export', 'laporan', 'Export laporan anggota');

        $filename = 'laporan-anggota-' . now()->format('Ymd-His');

        if ($request->type === 'pdf') {
            $members = (new MembersExport($request->role, $request->status, $request->cabang))->collection();
            $pdf = Pdf::loadView('dashboard.reports.pdf.members', compact('members'))
                ->setPaper('a4', 'landscape');
            return $pdf->download($filename . '.pdf');
        }

        return Excel::download(
            new MembersExport($request->role, $request->status, $request->cabang),
            $filename . '.xlsx'
        );
    }

    /**
     * Export Kas.
     */
    public function exportCash(Request $request)
    {
        AuditLog::record('export', 'laporan', 'Export laporan kas');

        $filename = 'laporan-kas-' . now()->format('Ymd-His');

        if ($request->type === 'pdf') {
            $payments = (new KasExport($request->periode, $request->status, $request->kategori, $request->cabang))->collection();
            $total = $payments->where('status', StatusKas::LUNAS)->sum('nominal');
            $pdf = Pdf::loadView('dashboard.reports.pdf.cash', compact('payments', 'total'))
                ->setPaper('a4', 'landscape');
            return $pdf->download($filename . '.pdf');
        }

        return Excel::download(
            new KasExport($request->periode, $request->status, $request->kategori, $request->cabang),
            $filename . '.xlsx'
        );
    }

    /**
     * Export Absensi.
     */
    public function exportAttendance(Request $request)
    {
        AuditLog::record('export', 'laporan', 'Export laporan absensi');

        $filename = 'laporan-absensi-' . now()->format('Ymd-His');

        if ($request->type === 'pdf') {
            $attendances = (new AttendanceExport($request->dari, $request->sampai, $request->cabang))->collection();
            $pdf = Pdf::loadView('dashboard.reports.pdf.attendance', compact('attendances'))
                ->setPaper('a4', 'landscape');
            return $pdf->download($filename . '.pdf');
        }

        return Excel::download(
            new AttendanceExport($request->dari, $request->sampai, $request->cabang),
            $filename . '.xlsx'
        );
    }

    /**
     * Export Prestasi.
     */
    public function exportAchievements(Request $request)
    {
        AuditLog::record('export', 'laporan', 'Export laporan prestasi');

        $filename = 'laporan-prestasi-' . now()->format('Ymd-His');

        if ($request->type === 'pdf') {
            $achievements = (new AchievementExport($request->tingkat, $request->tahun))->collection();
            $pdf = Pdf::loadView('dashboard.reports.pdf.achievements', compact('achievements'))
                ->setPaper('a4', 'landscape');
            return $pdf->download($filename . '.pdf');
        }

        return Excel::download(
            new AchievementExport($request->tingkat, $request->tahun),
            $filename . '.xlsx'
        );
    }
}