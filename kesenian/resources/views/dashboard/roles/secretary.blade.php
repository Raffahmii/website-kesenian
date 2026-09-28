@extends('layouts.dashboard')

@section('title', 'Dashboard Sekretaris')
@section('subtitle', 'Kelola administrasi, anggota, dan absensi organisasi')

@section('content')

    {{-- HERO --}}
    <div class="panel-light-gold mb-8" data-aos="fade-up">
        <div class="relative">
            <div class="flex items-center gap-3 mb-3">
                <span class="badge-gold">Sekretaris</span>
                <span class="text-xs text-light-muted">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-display font-bold mb-2 text-light-text">
                Dashboard <span class="text-gold-dark">Sekretaris</span>
            </h2>
            <p class="text-light-muted text-sm max-w-2xl">
                Kelola data anggota, absensi digital, jadwal kegiatan, dan administrasi organisasi dari sini.
            </p>
        </div>
    </div>

    {{-- STATS --}}
    @php
        $totalAnggota = \App\Models\User::where('status_anggota', 'aktif')->count();
        $totalPending = \App\Models\User::whereNull('email_verified_at')->count();
        $absensiHariIni = \App\Models\Absensi::whereDate('created_at', today())->count();
        $totalEvent = \App\Models\JadwalKegiatan::where('tanggal', '>=', now())->count();
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $stats = [
                ['label' => 'Anggota Aktif', 'value' => $totalAnggota, 'icon' => 'users', 'color' => 'blue'],
                ['label' => 'Pending Approve', 'value' => $totalPending, 'icon' => 'clock', 'color' => 'yellow'],
                ['label' => 'Absensi Hari Ini', 'value' => $absensiHariIni, 'icon' => 'check', 'color' => 'green'],
                ['label' => 'Event Mendatang', 'value' => $totalEvent, 'icon' => 'calendar', 'color' => 'purple'],
            ];
        @endphp

        @foreach($stats as $i => $stat)
            <div class="panel-light-interactive group" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                <div class="flex items-start justify-between mb-5">
                    <div class="icon-badge-light group-hover:bg-gold/15 transition-all">
                        @if($stat['icon'] === 'users')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        @elseif($stat['icon'] === 'clock')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @elseif($stat['icon'] === 'check')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @endif
                    </div>
                </div>
                <div class="text-3xl sm:text-4xl font-display font-bold 
                            bg-gradient-to-br from-gold-dark to-gold bg-clip-text text-transparent 
                            mb-1 leading-none">
                    {{ $stat['value'] }}
                </div>
                <div class="text-xs text-light-muted font-medium">{{ $stat['label'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- MAIN ACTIONS --}}
    <div class="section-head-light mb-6" data-aos="fade-up">
        <div class="icon-badge-light">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <div>
            <h3 class="section-head-title-light">Menu Utama Sekretaris</h3>
            <p class="section-head-sub-light">Fitur yang paling sering dipakai</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4" data-aos="fade-up">
        <a href="{{ route('dashboard.members.index') }}" 
           class="panel-light-interactive group">
            <div class="flex items-start justify-between mb-5">
                <div class="icon-badge-light-solid group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <svg class="w-5 h-5 text-light-muted group-hover:text-gold-dark 
                            group-hover:translate-x-1 transition-all" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </div>
            <h3 class="font-display font-bold text-lg mb-2 text-light-text 
                       group-hover:text-gold-dark transition-colors">
                Manajemen Anggota
            </h3>
            <p class="text-light-muted text-sm leading-relaxed">
                Approve registrasi, edit data, dan kelola seluruh anggota organisasi.
            </p>
        </a>

        <a href="{{ route('dashboard.attendance') }}" 
           class="panel-light-interactive group">
            <div class="flex items-start justify-between mb-5">
                <div class="icon-badge-light-solid group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <svg class="w-5 h-5 text-light-muted group-hover:text-gold-dark 
                            group-hover:translate-x-1 transition-all" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </div>
            <h3 class="font-display font-bold text-lg mb-2 text-light-text 
                       group-hover:text-gold-dark transition-colors">
                Absensi Digital
            </h3>
            <p class="text-light-muted text-sm leading-relaxed">
                Generate QR attendance, rekap kehadiran, dan ekspor laporan absensi.
            </p>
        </a>

        <a href="{{ route('dashboard.events') }}" 
           class="panel-light-interactive group">
            <div class="flex items-start justify-between mb-5">
                <div class="icon-badge-light-solid group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <svg class="w-5 h-5 text-light-muted group-hover:text-gold-dark 
                            group-hover:translate-x-1 transition-all" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </div>
            <h3 class="font-display font-bold text-lg mb-2 text-light-text 
                       group-hover:text-gold-dark transition-colors">
                Jadwal & Event
            </h3>
            <p class="text-light-muted text-sm leading-relaxed">
                Buat jadwal latihan, pentas, rapat, dan kelola seluruh agenda kegiatan.
            </p>
        </a>
    </div>

@endsection