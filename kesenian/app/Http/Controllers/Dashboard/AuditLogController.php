<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $query = AuditLog::with('user');

        // Filter by user
        if ($request->filled('user')) {
            $query->where('id_user', $request->user);
        }

        // Filter by module
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by date range
        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        // Search description
        if ($request->filled('q')) {
            $query->where('description', 'ILIKE', "%{$request->q}%");
        }

        $logs = $query->orderByDesc('created_at')->paginate(25)->withQueryString();

        // Stats
        $stats = [
            'total'   => AuditLog::count(),
            'today'   => AuditLog::whereDate('created_at', today())->count(),
            'week'    => AuditLog::where('created_at', '>=', now()->subWeek())->count(),
            'month'   => AuditLog::where('created_at', '>=', now()->subMonth())->count(),
        ];

        // Options
        $users = User::orderBy('nama_lengkap')->get(['id_user', 'nama_lengkap']);
        $modules = AuditLog::select('module')->whereNotNull('module')->distinct()->orderBy('module')->pluck('module');
        $actions = AuditLog::select('action')->whereNotNull('action')->distinct()->orderBy('action')->pluck('action');

        return view('dashboard.audit-logs.index', compact('logs', 'stats', 'users', 'modules', 'actions'));
    }

    public function show(AuditLog $log): View
    {
        $log->load('user');
        return view('dashboard.audit-logs.show', compact('log'));
    }
}