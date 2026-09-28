<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        \App\Models\AuditLog::record(
            action: 'login',
            module: 'auth',
            description: 'User login: ' . $request->user()->nama_lengkap
        );

        return redirect()->intended(route('dashboard.index'));
    }

    /**
     * Tentukan path redirect berdasarkan role user.
     */
    protected function redirectPathByRole(string $role): string
    {
        return match ($role) {
            'ketua', 'wakil_ketua', 'pembina' => route('dashboard'),
            'sekretaris'                       => route('dashboard.secretary'),
            'bendahara'                        => route('dashboard.treasurer'),
            'pdd'                              => route('dashboard.pdd'),
            default                            => route('dashboard.member'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
