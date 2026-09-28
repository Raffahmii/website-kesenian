<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * Contoh pemakaian di route:
     *   ->middleware('role:ketua,bendahara')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Belum login? Redirect ke login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Cek role user (pakai kolom `role` di tabel users)
        $userRole = $request->user()->role->value;

        if (!in_array($userRole, $roles, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}