<?php

namespace App\Providers;

use App\Enums\RoleUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ═══════════════════════════════════════
        // GATES — shortcut cek role di Blade/Controller
        // ═══════════════════════════════════════

        // Role-based
        Gate::define('is-pembina',   fn ($user) => $user->role === RoleUser::PEMBINA);
        Gate::define('is-ketua',     fn ($user) => $user->role === RoleUser::KETUA);
        Gate::define('is-wakil',     fn ($user) => $user->role === RoleUser::WAKIL_KETUA);
        Gate::define('is-sekretaris',fn ($user) => $user->role === RoleUser::SEKRETARIS);
        Gate::define('is-bendahara', fn ($user) => $user->role === RoleUser::BENDAHARA);
        Gate::define('is-pdd',       fn ($user) => $user->role === RoleUser::PDD);
        Gate::define('is-anggota',   fn ($user) => $user->role === RoleUser::ANGGOTA);

        // High-level access
        Gate::define('access-admin', fn ($user) => in_array($user->role, [
            RoleUser::KETUA,
            RoleUser::WAKIL_KETUA,
            RoleUser::PEMBINA,
        ], true));

        Gate::define('manage-members', fn ($user) => in_array($user->role, [
            RoleUser::SEKRETARIS,
            RoleUser::KETUA,
            RoleUser::WAKIL_KETUA,
            RoleUser::PEMBINA,
        ], true));

        Gate::define('manage-cash', fn ($user) => in_array($user->role, [
            RoleUser::BENDAHARA,
            RoleUser::KETUA,
            RoleUser::WAKIL_KETUA,
            RoleUser::PEMBINA,
        ], true));

        Gate::define('manage-docs', fn ($user) => in_array($user->role, [
            RoleUser::PDD,
            RoleUser::KETUA,
            RoleUser::WAKIL_KETUA,
            RoleUser::PEMBINA,
        ], true));

        Gate::define('manage-events', fn ($user) => in_array($user->role, [
            RoleUser::SEKRETARIS,
            RoleUser::KETUA,
            RoleUser::WAKIL_KETUA,
            RoleUser::PEMBINA,
        ], true));

        Gate::define('view-audit', fn ($user) => in_array($user->role, [
            RoleUser::KETUA,
            RoleUser::WAKIL_KETUA,
            RoleUser::PEMBINA,
        ], true));
    }
}