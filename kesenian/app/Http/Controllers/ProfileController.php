<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\AuditLog;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct(
        protected ImageUploadService $imageService
    ) {}

    /**
     * Show the user's profile.
     */
    public function show(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

        /**
     * Lihat profile user lain (publik di internal).
     */
    public function viewUser(User $user): View
    {
        $user->load([
            'kepengurusan.jabatan',
            'kepengurusan.periode',
            'prestasiPeserta.prestasi',
        ]);

        return view('profile.view-user', compact('user'));
    }

    /**
     * Cari user lain.
     */
    public function search(Request $request): View
    {
        $query = User::query();

        // Filter: cuma yang aktif / alumni
        $query->whereIn('status_anggota', [
            \App\Enums\StatusAnggota::AKTIF->value,
            \App\Enums\StatusAnggota::ALUMNI->value,
        ]);

        // Search
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_lengkap', 'ILIKE', "%{$q}%")
                    ->orWhere('nis', 'ILIKE', "%{$q}%")
                    ->orWhere('email', 'ILIKE', "%{$q}%");
            });
        }

        // Filter cabang
        if ($request->filled('cabang')) {
            $query->where('cabang', $request->cabang);
        }

        // Filter role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Load relasi kepengurusan aktif
        $users = $query->with(['kepengurusan' => function ($q) {
                $q->where('is_active', true)->with(['jabatan', 'periode']);
            }])
            ->orderBy('nama_lengkap')
            ->paginate(24)
            ->withQueryString();

        return view('profile.search-users', compact('users'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // Upload photo
        if ($request->hasFile('photo')) {
            $this->imageService->delete($user->photo);
            $validated['photo'] = $this->imageService->uploadImage(
                $request->file('photo'),
                'avatars',
                500
            );
        }

        // Upload cover
        if ($request->hasFile('cover_photo')) {
            $this->imageService->delete($user->cover_photo);
            $validated['cover_photo'] = $this->imageService->uploadImage(
                $request->file('cover_photo'),
                'covers',
                1920
            );
        }

        $user->fill($validated);

        // Kalau email berubah, reset verified_at
        if ($user->isDirty('email')) {
            $user->email_verified_at = now(); // langsung verify biar gak ribet
        }

        $user->save();

        AuditLog::record(
            action: 'update',
            module: 'profile',
            description: "Update profile: {$user->nama_lengkap}"
        );

        return Redirect::route('profile.edit')->with('success', 'Profile berhasil diupdate.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Hapus file
        $this->imageService->delete($user->photo);
        $this->imageService->delete($user->cover_photo);

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}