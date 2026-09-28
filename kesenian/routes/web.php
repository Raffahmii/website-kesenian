<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\MemberController;
use App\Http\Controllers\Dashboard\ScheduleController;
use App\Http\Controllers\Dashboard\AttendanceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [\App\Http\Controllers\Public\HomeController::class, 'index'])->name('home');
Route::get('/tentang', fn() => 'Halaman Tentang')->name('about');
Route::get('/prestasi', fn() => 'Halaman Prestasi')->name('achievements');
Route::get('/dokumentasi', fn() => 'Halaman Dokumentasi')->name('gallery');
Route::get('/event', fn() => 'Halaman Event')->name('events');
Route::get('/pengumuman', fn() => 'Halaman Pengumuman')->name('announcements.index');
Route::get('/kontak', fn() => 'Halaman Kontak')->name('contact');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| DASHBOARD ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {

    // ── Dashboard Utama ──
    Route::get('/', fn() => view('dashboard.index'))->name('index');

    // ── Dashboard per Role ──
    Route::get('/secretary', fn() => view('dashboard.roles.secretary'))
        ->middleware('role:sekretaris,ketua,wakil_ketua,pembina')
        ->name('secretary');

    Route::get('/treasurer', fn() => view('dashboard.roles.treasurer'))
        ->middleware('role:bendahara,ketua,wakil_ketua,pembina')
        ->name('treasurer');

    Route::get('/pdd', fn() => view('dashboard.roles.pdd'))
        ->middleware('role:pdd,ketua,wakil_ketua,pembina')
        ->name('pdd');

    Route::get('/member', fn() => view('dashboard.roles.member'))
        ->name('member');

    // ── Global Search & Notification ──
    Route::get('/search', [\App\Http\Controllers\Dashboard\SearchController::class, 'search'])
        ->name('search');
    Route::get('/notifications', [\App\Http\Controllers\Dashboard\NotificationController::class, 'index'])
        ->name('notifications');

    // ═══════════════════════════════════════════════════════════
    //  MODUL ANGGOTA
    // ═══════════════════════════════════════════════════════════
    Route::middleware('can:manage-members')->group(function () {
        Route::get('/members', [MemberController::class, 'index'])->name('members.index');
        Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
        Route::post('/members', [MemberController::class, 'store'])->name('members.store');
        Route::post('/members/alumni-massal', [MemberController::class, 'alumniMassal'])->name('members.alumni-massal');
        Route::post('/members/serah-terima', [MemberController::class, 'serahTerima'])->name('members.serah-terima');
        Route::post('/members/promote', [MemberController::class, 'promote'])->name('members.promote');
        Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');
        Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
        Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
        Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
    });

    // ═══════════════════════════════════════════════════════════
    //  MODUL JADWAL KEGIATAN
    // ═══════════════════════════════════════════════════════════
    Route::get('/events', [ScheduleController::class, 'index'])->name('events.index');
    Route::get('/events/create', [ScheduleController::class, 'create'])
        ->middleware('can:manage-events')->name('events.create');
    Route::post('/events', [ScheduleController::class, 'store'])
        ->middleware('can:manage-events')->name('events.store');
    Route::get('/events/{schedule}', [ScheduleController::class, 'show'])->name('events.show');
    Route::get('/events/{schedule}/edit', [ScheduleController::class, 'edit'])
        ->middleware('can:manage-events')->name('events.edit');
    Route::put('/events/{schedule}', [ScheduleController::class, 'update'])
        ->middleware('can:manage-events')->name('events.update');
    Route::delete('/events/{schedule}', [ScheduleController::class, 'destroy'])
        ->middleware('can:manage-events')->name('events.destroy');

    // ═══════════════════════════════════════════════════════════
    //  MODUL ABSENSI
    // ═══════════════════════════════════════════════════════════
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::get('/events/{schedule}/attendance', [AttendanceController::class, 'input'])
        ->middleware('can:manage-members')->name('attendance.input');
    Route::post('/events/{schedule}/attendance', [AttendanceController::class, 'bulkStore'])
        ->middleware('can:manage-members')->name('attendance.bulk-store');
    Route::delete('/attendance/{attendance}', [AttendanceController::class, 'destroy'])
        ->middleware('can:manage-members')->name('attendance.destroy');

    // ═══════════════════════════════════════════════════════════
    //  MODUL KEPENGURUSAN
    // ═══════════════════════════════════════════════════════════
    Route::middleware('can:access-admin')->group(function () {
        Route::get('/management', [\App\Http\Controllers\Dashboard\ManagementController::class, 'index'])
            ->name('management');
        Route::get('/management/create', [\App\Http\Controllers\Dashboard\ManagementController::class, 'create'])
            ->name('management.create');
        Route::post('/management', [\App\Http\Controllers\Dashboard\ManagementController::class, 'store'])
            ->name('management.store');
        Route::get('/management/{management}/edit', [\App\Http\Controllers\Dashboard\ManagementController::class, 'edit'])
            ->name('management.edit');
        Route::put('/management/{management}', [\App\Http\Controllers\Dashboard\ManagementController::class, 'update'])
            ->name('management.update');
        Route::delete('/management/{management}', [\App\Http\Controllers\Dashboard\ManagementController::class, 'destroy'])
            ->name('management.destroy');

        // Jabatan CRUD
        Route::get('/management/jabatan/list', [\App\Http\Controllers\Dashboard\ManagementController::class, 'jabatan'])
            ->name('management.jabatan');
        Route::post('/management/jabatan', [\App\Http\Controllers\Dashboard\ManagementController::class, 'storeJabatan'])
            ->name('management.jabatan.store');
        Route::put('/management/jabatan/{jabatan}', [\App\Http\Controllers\Dashboard\ManagementController::class, 'updateJabatan'])
            ->name('management.jabatan.update');
        Route::delete('/management/jabatan/{jabatan}', [\App\Http\Controllers\Dashboard\ManagementController::class, 'destroyJabatan'])
            ->name('management.jabatan.destroy');
    });

    // ═══════════════════════════════════════════════════════════
    //  MODUL KAS
    // ═══════════════════════════════════════════════════════════
    Route::get('/cash', [\App\Http\Controllers\Dashboard\CashController::class, 'index'])->name('cash');

    Route::middleware('can:manage-cash')->group(function () {
        Route::get('/cash/input', [\App\Http\Controllers\Dashboard\CashController::class, 'input'])->name('cash.input');
        Route::post('/cash/bulk', [\App\Http\Controllers\Dashboard\CashController::class, 'bulkStore'])->name('cash.bulk-store');
        Route::post('/cash/{cash}/mark-paid', [\App\Http\Controllers\Dashboard\CashController::class, 'markPaid'])->name('cash.mark-paid');
        Route::delete('/cash/{cash}', [\App\Http\Controllers\Dashboard\CashController::class, 'destroy'])->name('cash.destroy');
        Route::get('/cash/export', [\App\Http\Controllers\Dashboard\CashController::class, 'export'])->name('cash.export');

        Route::get('/cash/categories', [\App\Http\Controllers\Dashboard\CashController::class, 'categories'])->name('cash.categories');
        Route::post('/cash/categories', [\App\Http\Controllers\Dashboard\CashController::class, 'storeCategory'])->name('cash.categories.store');
        Route::put('/cash/categories/{category}', [\App\Http\Controllers\Dashboard\CashController::class, 'updateCategory'])->name('cash.categories.update');
        Route::delete('/cash/categories/{category}', [\App\Http\Controllers\Dashboard\CashController::class, 'destroyCategory'])->name('cash.categories.destroy');
    });

    // ═══════════════════════════════════════════════════════════
    //  MODUL DOKUMENTASI
    // ═══════════════════════════════════════════════════════════
    Route::get('/albums', [\App\Http\Controllers\Dashboard\AlbumController::class, 'index'])->name('albums.index');

    Route::middleware('can:manage-docs')->group(function () {
        Route::get('/albums/create', [\App\Http\Controllers\Dashboard\AlbumController::class, 'create'])->name('albums.create');
        Route::post('/albums', [\App\Http\Controllers\Dashboard\AlbumController::class, 'store'])->name('albums.store');
        Route::get('/albums/{album}/edit', [\App\Http\Controllers\Dashboard\AlbumController::class, 'edit'])->name('albums.edit');
        Route::put('/albums/{album}', [\App\Http\Controllers\Dashboard\AlbumController::class, 'update'])->name('albums.update');
        Route::delete('/albums/{album}', [\App\Http\Controllers\Dashboard\AlbumController::class, 'destroy'])->name('albums.destroy');
        Route::post('/albums/{album}/media', [\App\Http\Controllers\Dashboard\AlbumController::class, 'uploadMedia'])->name('albums.media.upload');
        Route::delete('/albums/media/{media}', [\App\Http\Controllers\Dashboard\AlbumController::class, 'destroyMedia'])->name('albums.media.destroy');
    });

    Route::get('/albums/{album}', [\App\Http\Controllers\Dashboard\AlbumController::class, 'show'])->name('albums.show');

    // ═══════════════════════════════════════════════════════════
    //  MODUL PRESTASI
    // ═══════════════════════════════════════════════════════════
    Route::get('/achievements', [\App\Http\Controllers\Dashboard\AchievementController::class, 'index'])->name('achievements.index');

    Route::middleware('can:manage-docs')->group(function () {
        Route::get('/achievements/create', [\App\Http\Controllers\Dashboard\AchievementController::class, 'create'])->name('achievements.create');
        Route::post('/achievements', [\App\Http\Controllers\Dashboard\AchievementController::class, 'store'])->name('achievements.store');
        Route::get('/achievements/{achievement}/edit', [\App\Http\Controllers\Dashboard\AchievementController::class, 'edit'])->name('achievements.edit');
        Route::put('/achievements/{achievement}', [\App\Http\Controllers\Dashboard\AchievementController::class, 'update'])->name('achievements.update');
        Route::delete('/achievements/{achievement}', [\App\Http\Controllers\Dashboard\AchievementController::class, 'destroy'])->name('achievements.destroy');
    });

    Route::get('/achievements/{achievement}', [\App\Http\Controllers\Dashboard\AchievementController::class, 'show'])->name('achievements.show');

    // ═══════════════════════════════════════════════════════════
    //  MODUL PENGUMUMAN
    // ═══════════════════════════════════════════════════════════
    Route::get('/announcements', [\App\Http\Controllers\Dashboard\AnnouncementController::class, 'index'])->name('announcements.index');

    Route::middleware('can:manage-members')->group(function () {
        Route::get('/announcements/create', [\App\Http\Controllers\Dashboard\AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [\App\Http\Controllers\Dashboard\AnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{announcement}/edit', [\App\Http\Controllers\Dashboard\AnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{announcement}', [\App\Http\Controllers\Dashboard\AnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{announcement}', [\App\Http\Controllers\Dashboard\AnnouncementController::class, 'destroy'])->name('announcements.destroy');
        Route::post('/announcements/{announcement}/toggle-publish', [\App\Http\Controllers\Dashboard\AnnouncementController::class, 'togglePublish'])->name('announcements.toggle-publish');
    });

    Route::get('/announcements/{announcement}', [\App\Http\Controllers\Dashboard\AnnouncementController::class, 'show'])->name('announcements.show');

    // ═══════════════════════════════════════════════════════════
    //  MODUL LAPORAN (REPORTS)
    // ═══════════════════════════════════════════════════════════
    Route::middleware('can:view-audit')->group(function () {
        Route::get('/reports', [\App\Http\Controllers\Dashboard\ReportController::class, 'index'])->name('reports');
        Route::get('/reports/members/export', [\App\Http\Controllers\Dashboard\ReportController::class, 'exportMembers'])->name('reports.members.export');
        Route::get('/reports/cash/export', [\App\Http\Controllers\Dashboard\ReportController::class, 'exportCash'])->name('reports.cash.export');
        Route::get('/reports/attendance/export', [\App\Http\Controllers\Dashboard\ReportController::class, 'exportAttendance'])->name('reports.attendance.export');
        Route::get('/reports/achievements/export', [\App\Http\Controllers\Dashboard\ReportController::class, 'exportAchievements'])->name('reports.achievements.export');
    });

    // ═══════════════════════════════════════════════════════════
    //  MODUL AUDIT LOG
    // ═══════════════════════════════════════════════════════════
    Route::middleware('can:view-audit')->group(function () {
        Route::get('/audit', [\App\Http\Controllers\Dashboard\AuditLogController::class, 'index'])->name('audit.index');
        Route::get('/audit/{log}', [\App\Http\Controllers\Dashboard\AuditLogController::class, 'show'])->name('audit.show');
    });

    // ═══════════════════════════════════════════════════════════
    //  MODUL PENGATURAN
    // ═══════════════════════════════════════════════════════════
    Route::middleware('can:access-admin')->group(function () {
        Route::get('/settings', [\App\Http\Controllers\Dashboard\SettingController::class, 'index'])->name('settings');
        Route::post('/settings/periode', [\App\Http\Controllers\Dashboard\SettingController::class, 'storePeriode'])->name('settings.periode.store');
        Route::put('/settings/periode/{periode}', [\App\Http\Controllers\Dashboard\SettingController::class, 'updatePeriode'])->name('settings.periode.update');
        Route::delete('/settings/periode/{periode}', [\App\Http\Controllers\Dashboard\SettingController::class, 'destroyPeriode'])->name('settings.periode.destroy');
        Route::post('/settings/periode/{periode}/activate', [\App\Http\Controllers\Dashboard\SettingController::class, 'activatePeriode'])->name('settings.periode.activate');
        Route::post('/settings/clear-cache', [\App\Http\Controllers\Dashboard\SettingController::class, 'clearCache'])->name('settings.clear-cache');
    });
});

/*
|--------------------------------------------------------------------------
| PROFILE + USERS SEARCH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [ProfileController::class, 'search'])->name('users.index');
    Route::get('/users/{user}', [ProfileController::class, 'viewUser'])->name('users.show');
});