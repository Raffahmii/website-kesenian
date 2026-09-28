<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleUser;
use App\Enums\StatusAnggota;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Register user baru — WAJIB role anggota.
     * Role lain (ketua, sekretaris, dll) cuma bisa di-assign manual via admin dashboard.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'email'        => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:users,email'],
            'password'     => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // ── Paksa role = anggota, status = aktif ──
        $user = User::create([
            'nama_lengkap'   => $request->nama_lengkap,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           => RoleUser::ANGGOTA->value,
            'status_anggota' => StatusAnggota::AKTIF->value,
        ]);

        // Assign Spatie role anggota
        $user->assignRole(RoleUser::ANGGOTA->value);

        event(new Registered($user));

        Auth::login($user);

        // Log audit
        \App\Models\AuditLog::record(
            action: 'register',
            module: 'auth',
            description: 'User baru register: ' . $user->nama_lengkap,
        );

        return redirect(route('dashboard.index', absolute: false));
    }
}