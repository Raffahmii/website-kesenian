<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\TipeMedia;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlbumRequest;
use App\Models\AuditLog;
use App\Models\DokumentasiAlbum;
use App\Models\DokumentasiMedia;
use App\Models\JadwalKegiatan;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AlbumController extends Controller
{
    public function __construct(
        protected ImageUploadService $imageService
    ) {}

    /**
     * List album + filter.
     */
    public function index(Request $request): View
    {
        $query = DokumentasiAlbum::with(['uploader', 'jadwal'])
            ->withCount('media');

        if ($request->filled('q')) {
            $query->where('judul', 'ILIKE', "%{$request->q}%");
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $albums = $query->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'total_album'  => DokumentasiAlbum::count(),
            'total_media'  => DokumentasiMedia::count(),
            'total_foto'   => DokumentasiMedia::where('tipe', TipeMedia::FOTO->value)->count(),
            'total_video'  => DokumentasiMedia::where('tipe', TipeMedia::VIDEO->value)->count(),
        ];

        // Kategori unik dari album yang ada
        $kategoris = DokumentasiAlbum::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('dashboard.albums.index', compact('albums', 'stats', 'kategoris'));
    }

    /**
     * Form buat album baru.
     */
    public function create(): View
    {
        $jadwals = JadwalKegiatan::orderByDesc('tanggal')->limit(50)->get();
        return view('dashboard.albums.create', compact('jadwals'));
    }

    /**
     * Simpan album baru.
     */
    public function store(StoreAlbumRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Upload cover
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $this->imageService->uploadCover($request->file('cover_image'));
        }

        $validated['id_user_uploader'] = auth()->id();

        $album = DokumentasiAlbum::create($validated);

        AuditLog::record(
            action: 'create',
            module: 'dokumentasi',
            description: "Buat album: {$album->judul}",
            newValues: $album->only(['judul', 'kategori', 'tanggal_kegiatan'])
        );

        return redirect()
            ->route('dashboard.albums.show', $album->id_album)
            ->with('success', "Album \"{$album->judul}\" berhasil dibuat. Sekarang upload foto & videonya.");
    }

    /**
     * Detail album + grid media.
     */
    public function show(DokumentasiAlbum $album): View
    {
        $album->load(['uploader', 'jadwal']);
        $media = $album->media()->orderBy('urutan')->get();

        return view('dashboard.albums.show', compact('album', 'media'));
    }

    /**
     * Form edit album.
     */
    public function edit(DokumentasiAlbum $album): View
    {
        $jadwals = JadwalKegiatan::orderByDesc('tanggal')->limit(50)->get();
        return view('dashboard.albums.edit', compact('album', 'jadwals'));
    }

    /**
     * Update album.
     */
    public function update(StoreAlbumRequest $request, DokumentasiAlbum $album): RedirectResponse
    {
        $validated = $request->validated();

        // Upload cover baru
        if ($request->hasFile('cover_image')) {
            // Hapus cover lama
            $this->imageService->delete($album->cover_image);
            $validated['cover_image'] = $this->imageService->uploadCover($request->file('cover_image'));
        }

        $old = $album->only(['judul', 'kategori', 'tanggal_kegiatan']);
        $album->update($validated);

        AuditLog::record(
            action: 'update',
            module: 'dokumentasi',
            description: "Update album: {$album->judul}",
            oldValues: $old,
            newValues: $album->only(['judul', 'kategori', 'tanggal_kegiatan'])
        );

        return redirect()
            ->route('dashboard.albums.show', $album->id_album)
            ->with('success', 'Album berhasil diupdate.');
    }

    /**
     * Hapus album + semua media-nya.
     */
    public function destroy(DokumentasiAlbum $album): RedirectResponse
    {
        $judul = $album->judul;

        DB::beginTransaction();
        try {
            // Hapus semua file media
            foreach ($album->media as $media) {
                $this->imageService->delete($media->file_path);
                if ($media->thumbnail) {
                    $this->imageService->delete($media->thumbnail);
                }
            }

            // Hapus cover
            $this->imageService->delete($album->cover_image);

            // Hapus album (media kehapus otomatis karena cascade di DB)
            $album->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus album: ' . $e->getMessage());
        }

        AuditLog::record(
            action: 'delete',
            module: 'dokumentasi',
            description: "Hapus album: {$judul}"
        );

        return redirect()
            ->route('dashboard.albums.index')
            ->with('success', "Album \"{$judul}\" berhasil dihapus.");
    }

    /**
     * Upload media bulk ke album.
     */
    public function uploadMedia(Request $request, DokumentasiAlbum $album): RedirectResponse
    {
        $request->validate([
            'files'         => ['required', 'array', 'min:1'],
            'files.*'       => ['file', 'max:20480'], // max 20MB per file
            'tipe'          => ['required', 'in:foto,video'],
            'caption'       => ['nullable', 'array'],
            'caption.*'     => ['nullable', 'string', 'max:150'],
        ]);

        $tipe = TipeMedia::from($request->tipe);
        $count = 0;
        $urutan = ($album->media()->max('urutan') ?? 0) + 1;

        DB::beginTransaction();
        try {
            foreach ($request->file('files') as $i => $file) {
                // Validasi MIME berdasarkan tipe
                if ($tipe === TipeMedia::FOTO) {
                    if (!in_array($file->getClientMimeType(), ['image/jpeg', 'image/png', 'image/webp', 'image/gif'])) {
                        continue;
                    }
                    $path = $this->imageService->uploadImage($file, 'albums/photos');
                } else {
                    if (!str_starts_with($file->getClientMimeType(), 'video/')) {
                        continue;
                    }
                    $path = $this->imageService->uploadVideo($file, 'albums/videos');
                }

                DokumentasiMedia::create([
                    'id_album'  => $album->id_album,
                    'tipe'      => $tipe->value,
                    'file_path' => $path,
                    'caption'   => $request->caption[$i] ?? null,
                    'urutan'    => $urutan++,
                ]);

                $count++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal upload: ' . $e->getMessage());
        }

        AuditLog::record(
            action: 'create',
            module: 'dokumentasi',
            description: "Upload {$count} media ({$tipe->label()}) ke album: {$album->judul}"
        );

        return back()->with('success', "{$count} {$tipe->label()} berhasil diupload.");
    }

    /**
     * Hapus media.
     */
    public function destroyMedia(DokumentasiMedia $media): RedirectResponse
    {
        $albumId = $media->id_album;

        // Hapus file
        $this->imageService->delete($media->file_path);
        if ($media->thumbnail) {
            $this->imageService->delete($media->thumbnail);
        }

        $media->delete();

        AuditLog::record(
            action: 'delete',
            module: 'dokumentasi',
            description: "Hapus media dari album ID {$albumId}"
        );

        return back()->with('success', 'Media berhasil dihapus.');
    }
}