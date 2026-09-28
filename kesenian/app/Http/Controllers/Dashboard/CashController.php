<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Cabang;
use App\Enums\StatusAnggota;
use App\Enums\StatusKas;
use App\Exports\KasExport;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\KasKategori;
use App\Models\KasPembayaran;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CashController extends Controller
{
    /**
     * List kas + filter.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $isPengurus = $user->can('manage-cash');

        // ── Anggota: tampilkan kas pribadi ──
        if (!$isPengurus) {
            $myCash = KasPembayaran::with(['kategori'])
                ->where('id_user', $user->id_user)
                ->orderByDesc('periode_bulan')
                ->paginate(15);

            $myStats = [
                'total'       => KasPembayaran::where('id_user', $user->id_user)->count(),
                'lunas'       => KasPembayaran::where('id_user', $user->id_user)->where('status', StatusKas::LUNAS->value)->count(),
                'belum_lunas' => KasPembayaran::where('id_user', $user->id_user)->where('status', StatusKas::BELUM_LUNAS->value)->count(),
                'total_bayar' => KasPembayaran::where('id_user', $user->id_user)->where('status', StatusKas::LUNAS->value)->sum('nominal'),
            ];

            return view('dashboard.cash.member', compact('myCash', 'myStats'));
        }

        // ── Pengurus: list semua ──
        $query = KasPembayaran::with(['user', 'kategori', 'pencatat']);

        if ($request->filled('periode'))   $query->where('periode_bulan', $request->periode);
        if ($request->filled('status'))    $query->where('status', $request->status);
        if ($request->filled('kategori'))  $query->where('id_kategori', $request->kategori);
        if ($request->filled('cabang'))    $query->whereHas('user', fn($q) => $q->where('cabang', $request->cabang));
        if ($request->filled('q')) {
            $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'ILIKE', "%{$request->q}%")
                                                 ->orWhere('nis', 'ILIKE', "%{$request->q}%"));
        }

        $payments = $query->orderByDesc('periode_bulan')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        // ── Stats bulan aktif ──
        $periodeAktif = $request->filled('periode') ? $request->periode : now()->format('Y-m');

        $stats = [
            'total_bulan_ini'   => KasPembayaran::periode($periodeAktif)->lunas()->sum('nominal'),
            'lunas_bulan_ini'   => KasPembayaran::periode($periodeAktif)->lunas()->count(),
            'belum_bulan_ini'   => KasPembayaran::periode($periodeAktif)->belumLunas()->count(),
            'total_anggota'     => User::where('status_anggota', StatusAnggota::AKTIF->value)->count(),
        ];

        $kategoris = KasKategori::orderBy('nama')->get();

        return view('dashboard.cash.index', compact('payments', 'stats', 'kategoris', 'periodeAktif'));
    }

    /**
     * Form input pembayaran bulk per cabang.
     */
    public function input(Request $request): View
    {
        $periode = $request->query('periode', now()->format('Y-m'));
        $kategoriId = $request->query('kategori');
        $cabangAktif = $request->query('cabang', Cabang::PADUS->value);

        if (!in_array($cabangAktif, Cabang::values(), true)) {
            $cabangAktif = Cabang::PADUS->value;
        }

        $kategoris = KasKategori::active()->orderBy('nama')->get();
        $kategoriAktif = $kategoriId ? KasKategori::find($kategoriId) : $kategoris->first();

        // Ambil anggota cabang aktif
        $members = User::where('status_anggota', StatusAnggota::AKTIF->value)
            ->where('cabang', $cabangAktif)
            ->orderBy('nama_lengkap')
            ->get();

        // Existing payments untuk periode + kategori
        $existing = collect();
        if ($kategoriAktif) {
            $existing = KasPembayaran::where('periode_bulan', $periode)
                ->where('id_kategori', $kategoriAktif->id_kategori)
                ->whereIn('id_user', $members->pluck('id_user')->toArray())
                ->get()
                ->keyBy('id_user');
        }

        return view('dashboard.cash.input', compact(
            'periode', 'cabangAktif', 'kategoris', 'kategoriAktif', 'members', 'existing'
        ));
    }

    /**
     * Simpan pembayaran bulk.
     */
    public function bulkStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'periode_bulan'              => ['required', 'regex:/^\d{4}-\d{2}$/'],
            'id_kategori'                => ['required', 'exists:kas_kategori,id_kategori'],
            'cabang'                     => ['required', Rule::enum(Cabang::class)],
            'payments'                   => ['required', 'array'],
            'payments.*.id_user'         => ['required', 'exists:users,id_user'],
            'payments.*.status'          => ['required', 'in:lunas,belum_lunas'],
            'payments.*.nominal'         => ['nullable', 'numeric', 'min:0'],
            'payments.*.tanggal_bayar'   => ['nullable', 'date'],
            'payments.*.catatan'         => ['nullable', 'string', 'max:255'],
        ]);

        $kategori = KasKategori::findOrFail($validated['id_kategori']);
        $count = 0;
        $totalNominal = 0;

        DB::beginTransaction();
        try {
            foreach ($validated['payments'] as $row) {
                $nominal = $row['nominal'] ?? $kategori->nominal;
                $isLunas = $row['status'] === 'lunas';

                KasPembayaran::updateOrCreate(
                    [
                        'id_user'       => $row['id_user'],
                        'id_kategori'   => $validated['id_kategori'],
                        'periode_bulan' => $validated['periode_bulan'],
                    ],
                    [
                        'nominal'           => $nominal,
                        'status'            => $row['status'],
                        'tanggal_bayar'     => $isLunas ? ($row['tanggal_bayar'] ?? now()->toDateString()) : null,
                        'catatan'           => $row['catatan'] ?? null,
                        'id_user_pencatat'  => auth()->id(),
                    ]
                );

                if ($isLunas) {
                    $count++;
                    $totalNominal += $nominal;
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        AuditLog::record(
            action: 'create',
            module: 'kas',
            description: "Input kas cabang {$validated['cabang']} periode {$validated['periode_bulan']} ({$count} lunas)",
            newValues: ['periode' => $validated['periode_bulan'], 'kategori' => $kategori->nama, 'count' => $count, 'total' => $totalNominal]
        );

        return redirect()
            ->route('dashboard.cash')
            ->with('success', "Kas berhasil disimpan: {$count} pembayaran lunas, total Rp " . number_format($totalNominal, 0, ',', '.'));
    }

    /**
     * Tandai lunas (verifikasi cepat).
     */
    public function markPaid(KasPembayaran $cash): RedirectResponse
    {
        $cash->update([
            'status'        => StatusKas::LUNAS->value,
            'tanggal_bayar' => now()->toDateString(),
            'id_user_pencatat' => auth()->id(),
        ]);

        AuditLog::record(
            action: 'update',
            module: 'kas',
            description: "Verifikasi kas: {$cash->user->nama_lengkap} - {$cash->periode_bulan}",
            newValues: ['status' => 'lunas', 'nominal' => $cash->nominal]
        );

        return back()->with('success', "Kas {$cash->user->nama_lengkap} berhasil diverifikasi.");
    }

    /**
     * Hapus pembayaran kas.
     */
    public function destroy(KasPembayaran $cash): RedirectResponse
    {
        $userName = $cash->user->nama_lengkap ?? 'Unknown';
        $periode = $cash->periode_bulan;

        $cash->delete();

        AuditLog::record(
            action: 'delete',
            module: 'kas',
            description: "Hapus kas: {$userName} - {$periode}"
        );

        return back()->with('success', "Data kas {$userName} berhasil dihapus.");
    }

    /**
     * Export Excel.
     */
    public function export(Request $request): BinaryFileResponse
    {
        $filename = 'kas-' . ($request->periode ?? 'all') . '-' . now()->format('Ymd-His') . '.xlsx';

        AuditLog::record(
            action: 'export',
            module: 'kas',
            description: "Export Excel kas: " . ($request->periode ?? 'semua periode')
        );

        return Excel::download(
            new KasExport(
                $request->periode,
                $request->status,
                $request->kategori,
                $request->cabang,
            ),
            $filename
        );
    }

    /**
     * Kategori kas — index.
     */
    public function categories(): View
    {
        $categories = KasKategori::withCount('pembayaran')->orderBy('nama')->get();
        return view('dashboard.cash.categories', compact('categories'));
    }

    /**
     * Simpan kategori baru.
     */
    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'      => ['required', 'string', 'max:50', 'unique:kas_kategori,nama'],
            'nominal'   => ['required', 'numeric', 'min:0'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
        ]);

        $kategori = KasKategori::create($validated);

        AuditLog::record(
            action: 'create',
            module: 'kas',
            description: "Tambah kategori kas: {$kategori->nama}"
        );

        return back()->with('success', "Kategori \"{$kategori->nama}\" berhasil ditambahkan.");
    }

    /**
     * Update kategori.
     */
    public function updateCategory(Request $request, KasKategori $category): RedirectResponse
    {
        $validated = $request->validate([
            'nama'      => ['required', 'string', 'max:50', Rule::unique('kas_kategori', 'nama')->ignore($category->id_kategori, 'id_kategori')],
            'nominal'   => ['required', 'numeric', 'min:0'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        $category->update($validated);

        AuditLog::record(
            action: 'update',
            module: 'kas',
            description: "Update kategori kas: {$category->nama}"
        );

        return back()->with('success', "Kategori \"{$category->nama}\" berhasil diupdate.");
    }

    /**
     * Hapus kategori.
     */
    public function destroyCategory(KasKategori $category): RedirectResponse
    {
        if ($category->pembayaran()->count() > 0) {
            return back()->with('error', 'Kategori masih dipakai di pembayaran. Tidak bisa dihapus.');
        }

        $nama = $category->nama;
        $category->delete();

        AuditLog::record(
            action: 'delete',
            module: 'kas',
            description: "Hapus kategori kas: {$nama}"
        );

        return back()->with('success', "Kategori \"{$nama}\" berhasil dihapus.");
    }
}