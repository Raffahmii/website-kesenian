<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\TargetPengumuman;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Models\AuditLog;
use App\Models\Pengumuman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pengumuman::with('pembuat');

        // Filter role-based: user biasa cuma lihat target sesuai role
        $user = auth()->user();
        $isPengurus = $user->can('manage-members') || $user->can('access-admin');

        if (!$isPengurus) {
            $query->published()
                ->where(function ($q) use ($user) {
                    $q->where('target_role', TargetPengumuman::SEMUA->value);
                    if ($user->role->isPengurus()) {
                        $q->orWhere('target_role', TargetPengumuman::PENGURUS->value);
                    }
                    $q->orWhere('target_role', TargetPengumuman::ANGGOTA->value);
                });
        }

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'ILIKE', "%{$request->q}%")
                  ->orWhere('isi', 'ILIKE', "%{$request->q}%");
            });
        }

        if ($request->filled('target')) {
            $query->where('target_role', $request->target);
        }

        if ($request->filled('status') && $isPengurus) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        $announcements = $query->orderByDesc('is_published')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total'     => Pengumuman::count(),
            'published' => Pengumuman::where('is_published', true)->count(),
            'draft'     => Pengumuman::where('is_published', false)->count(),
        ];

        return view('dashboard.announcements.index', compact('announcements', 'stats', 'isPengurus'));
    }

    public function create(): View
    {
        return view('dashboard.announcements.create');
    }

    public function store(StoreAnnouncementRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Upload lampiran
        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $this->uploadLampiran($request->file('lampiran'));
        }

        $validated['id_user_pembuat'] = auth()->id();
        $validated['is_published'] = $request->boolean('is_published', true);

        // Set published_at kalau publish
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $pengumuman = Pengumuman::create($validated);

        AuditLog::record(
            action: 'create',
            module: 'pengumuman',
            description: "Buat pengumuman: {$pengumuman->judul}",
            newValues: $pengumuman->only(['judul', 'target_role', 'is_published'])
        );

        return redirect()
            ->route('dashboard.announcements.show', $pengumuman->id_pengumuman)
            ->with('success', "Pengumuman \"{$pengumuman->judul}\" berhasil dibuat.");
    }

    public function show(Pengumuman $announcement): View
    {
        $announcement->load('pembuat');
        return view('dashboard.announcements.show', compact('announcement'));
    }

    public function edit(Pengumuman $announcement): View
    {
        return view('dashboard.announcements.edit', compact('announcement'));
    }

    public function update(StoreAnnouncementRequest $request, Pengumuman $announcement): RedirectResponse
    {
        $validated = $request->validated();

        // Upload lampiran baru
        if ($request->hasFile('lampiran')) {
            $this->deleteLampiran($announcement->lampiran);
            $validated['lampiran'] = $this->uploadLampiran($request->file('lampiran'));
        }

        $validated['is_published'] = $request->boolean('is_published', true);

        // Update published_at
        if ($validated['is_published'] && !$announcement->published_at) {
            $validated['published_at'] = now();
        } elseif (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        $old = $announcement->only(['judul', 'target_role', 'is_published']);
        $announcement->update($validated);

        AuditLog::record(
            action: 'update',
            module: 'pengumuman',
            description: "Update pengumuman: {$announcement->judul}",
            oldValues: $old,
            newValues: $announcement->only(['judul', 'target_role', 'is_published'])
        );

        return redirect()
            ->route('dashboard.announcements.show', $announcement->id_pengumuman)
            ->with('success', 'Pengumuman berhasil diupdate.');
    }

    public function destroy(Pengumuman $announcement): RedirectResponse
    {
        $judul = $announcement->judul;

        // Hapus lampiran
        $this->deleteLampiran($announcement->lampiran);

        $announcement->delete();

        AuditLog::record(
            action: 'delete',
            module: 'pengumuman',
            description: "Hapus pengumuman: {$judul}"
        );

        return redirect()
            ->route('dashboard.announcements.index')
            ->with('success', "Pengumuman \"{$judul}\" berhasil dihapus.");
    }

    /**
     * Toggle publish/unpublish.
     */
    public function togglePublish(Pengumuman $announcement): RedirectResponse
    {
        $newStatus = !$announcement->is_published;

        $announcement->update([
            'is_published' => $newStatus,
            'published_at' => $newStatus ? now() : null,
        ]);

        AuditLog::record(
            action: 'update',
            module: 'pengumuman',
            description: ($newStatus ? 'Publish' : 'Unpublish') . " pengumuman: {$announcement->judul}"
        );

        return back()->with('success', $newStatus ? 'Pengumuman berhasil dipublish.' : 'Pengumuman dijadikan draft.');
    }

    // ═══════════════════════════════════════
    // HELPER
    // ═══════════════════════════════════════

    protected function uploadLampiran($file): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = "announcements/{$filename}";
        Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));
        return $path;
    }

    protected function deleteLampiran(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}