@extends('layouts.dashboard')

@section('title', 'Detail Log')
@section('subtitle', 'Detail aktivitas user')

@section('content')

    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('dashboard.audit.index') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl gradient-gold flex items-center justify-center
                        font-display font-bold text-bg-primary text-2xl shadow-lg shadow-gold/30 shrink-0">
                {{ strtoupper(substr($log->user->nama_lengkap ?? 'S', 0, 1)) }}
            </div>
            <div class="flex-1">
                <h1 class="font-display font-bold text-xl text-light-text mb-1">
                    {{ $log->user->nama_lengkap ?? 'System' }}
                </h1>
                <p class="text-light-muted text-xs">
                    {{ $log->user->email ?? '-' }} · {{ $log->ip_address ?? '-' }}
                </p>
            </div>
            @php
                $actionColor = match($log->action) {
                    'create' => 'bg-green-100 text-green-700',
                    'update' => 'bg-blue-100 text-blue-700',
                    'delete' => 'bg-red-100 text-red-700',
                    'login'  => 'bg-purple-100 text-purple-700',
                    'export' => 'bg-yellow-100 text-yellow-700',
                    default  => 'bg-light-bg text-light-muted',
                };
            @endphp
            <span class="text-xs px-3 py-1.5 rounded-full font-semibold uppercase {{ $actionColor }}">
                {{ $log->action }}
            </span>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- INFO --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="panel-light">
                <div class="section-head-light">
                    <div class="icon-badge-light">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div><h3 class="section-head-title-light">Deskripsi Aktivitas</h3></div>
                </div>
                <p class="text-sm text-light-text leading-relaxed">
                    {{ $log->description ?? 'Tidak ada deskripsi' }}
                </p>
            </div>

            @if($log->old_values || $log->new_values)
                <div class="grid md:grid-cols-2 gap-4">
                    @if($log->old_values)
                        <div class="panel-light">
                            <h4 class="font-semibold text-sm text-red-500 mb-3">Data Lama</h4>
                            <div class="space-y-2 text-xs">
                                @foreach($log->old_values as $key => $val)
                                    <div class="flex justify-between gap-3 pb-2 border-b border-light-border last:border-0">
                                        <span class="text-light-muted font-mono">{{ $key }}</span>
                                        <span class="text-light-text text-right break-all">
                                            {{ is_array($val) ? json_encode($val) : ($val ?: '-') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($log->new_values)
                        <div class="panel-light">
                            <h4 class="font-semibold text-sm text-green-600 mb-3">Data Baru</h4>
                            <div class="space-y-2 text-xs">
                                @foreach($log->new_values as $key => $val)
                                    <div class="flex justify-between gap-3 pb-2 border-b border-light-border last:border-0">
                                        <span class="text-light-muted font-mono">{{ $key }}</span>
                                        <span class="text-light-text text-right break-all">
                                            {{ is_array($val) ? json_encode($val) : ($val ?: '-') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- META --}}
        <div class="space-y-6">
            <div class="panel-light">
                <h3 class="font-display font-bold text-base mb-4">Informasi</h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between gap-3">
                        <span class="text-light-muted">Module</span>
                        <span class="text-light-text font-medium">{{ $log->module ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between gap-3">
                        <span class="text-light-muted">Action</span>
                        <span class="text-light-text font-medium">{{ $log->action }}</span>
                    </div>
                    <div class="flex justify-between gap-3">
                        <span class="text-light-muted">Waktu</span>
                        <span class="text-light-text font-medium text-right">
                            {{ $log->created_at->translatedFormat('d F Y, H:i:s') }}
                        </span>
                    </div>
                    <div class="flex justify-between gap-3">
                        <span class="text-light-muted">IP Address</span>
                        <span class="text-light-text font-mono text-xs">{{ $log->ip_address ?? '-' }}</span>
                    </div>
                </div>
            </div>

            @if($log->user_agent)
                <div class="panel-light">
                    <h3 class="font-display font-bold text-sm mb-2">User Agent</h3>
                    <p class="text-xs text-light-muted break-all">
                        {{ $log->user_agent }}
                    </p>
                </div>
            @endif
        </div>
    </div>

@endsection