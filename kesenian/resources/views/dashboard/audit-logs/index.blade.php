@extends('layouts.dashboard')

@section('title', 'Audit Log')
@section('subtitle', 'Riwayat aktivitas semua user')

@section('content')

    {{-- HERO --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-display font-bold mb-1 text-light-text">
                    Audit <span class="text-gold-dark">Log</span>
                </h2>
                <p class="text-light-muted text-sm">
                    Total {{ $stats['total'] }} aktivitas tercatat
                </p>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php
            $statCards = [
                ['label' => 'Total Log', 'value' => $stats['total']],
                ['label' => 'Hari Ini', 'value' => $stats['today']],
                ['label' => '7 Hari', 'value' => $stats['week']],
                ['label' => '30 Hari', 'value' => $stats['month']],
            ];
        @endphp
        @foreach($statCards as $i => $s)
            <div class="panel-light" data-aos="fade-up" data-aos-delay="{{ $i * 60 }}">
                <div class="text-3xl font-display font-bold 
                            bg-gradient-to-br from-gold-dark to-gold bg-clip-text text-transparent 
                            mb-1 leading-none">
                    {{ $s['value'] }}
                </div>
                <div class="text-xs text-light-muted font-medium">{{ $s['label'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- FILTER --}}
    <div class="panel-light mb-6" data-aos="fade-up">
        <form method="GET" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari deskripsi..."
                   class="col-span-2 px-3 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                          text-light-text placeholder-light-muted/70 focus:outline-none focus:bg-white
                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">

            <select name="user" class="px-3 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                        text-light-text focus:outline-none focus:bg-white
                                        focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="">Semua User</option>
                @foreach($users as $u)
                    <option value="{{ $u->id_user }}" @selected(request('user') == $u->id_user)>
                        {{ $u->nama_lengkap }}
                    </option>
                @endforeach
            </select>

            <select name="module" class="px-3 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                          text-light-text focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Module</option>
                @foreach($modules as $m)
                    <option value="{{ $m }}" @selected(request('module') === $m)>{{ ucfirst($m) }}</option>
                @endforeach
            </select>

            <select name="action" class="px-3 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                          text-light-text focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Action</option>
                @foreach($actions as $a)
                    <option value="{{ $a }}" @selected(request('action') === $a)>{{ ucfirst($a) }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-gold btn-sm justify-center">Filter</button>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="panel-light p-0 overflow-hidden" data-aos="fade-up">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-light-border bg-light-bg/50">
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">User</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Action</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Module</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Deskripsi</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4 hidden lg:table-cell">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-light-border">
                    @forelse($logs as $log)
                        @php
                            $actionColor = match($log->action) {
                                'create' => 'bg-green-100 text-green-700',
                                'update' => 'bg-blue-100 text-blue-700',
                                'delete' => 'bg-red-100 text-red-700',
                                'login'  => 'bg-purple-100 text-purple-700',
                                'logout' => 'bg-gray-100 text-gray-700',
                                'export' => 'bg-yellow-100 text-yellow-700',
                                default  => 'bg-light-bg text-light-muted',
                            };
                        @endphp
                        <tr class="hover:bg-light-hover transition-colors cursor-pointer"
                            onclick="window.location='{{ route('dashboard.audit.show', $log->id_log) }}'">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl gradient-gold flex items-center justify-center
                                                font-display font-bold text-bg-primary text-sm shrink-0">
                                        {{ strtoupper(substr($log->user->nama_lengkap ?? '?', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium text-sm text-light-text truncate">
                                            {{ $log->user->nama_lengkap ?? 'System' }}
                                        </p>
                                        <p class="text-xs text-light-muted truncate">
                                            {{ $log->ip_address ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-[10px] px-2.5 py-1 rounded-full font-medium uppercase {{ $actionColor }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-xs text-light-text">{{ $log->module ?? '-' }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <p class="text-xs text-light-muted line-clamp-2 max-w-md">
                                    {{ $log->description ?? '-' }}
                                </p>
                            </td>
                            <td class="py-3 px-4 hidden lg:table-cell">
                                <p class="text-xs text-light-muted">
                                    {{ $log->created_at->diffForHumans() }}
                                </p>
                                <p class="text-[10px] text-light-muted/70">
                                    {{ $log->created_at->format('d M Y, H:i') }}
                                </p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center">
                                <div class="text-5xl mb-3">📋</div>
                                <p class="text-light-text font-medium mb-1">Belum ada log</p>
                                <p class="text-light-muted text-sm">Aktivitas user akan muncul di sini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($logs->hasPages())
        <div class="mt-6">{{ $logs->links() }}</div>
    @endif

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

@endsection