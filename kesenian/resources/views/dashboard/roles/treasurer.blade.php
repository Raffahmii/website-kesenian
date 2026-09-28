@extends('layouts.dashboard')

@section('title', 'Dashboard Bendahara')
@section('subtitle', 'Kelola keuangan, kas, dan laporan organisasi')

@section('content')

    {{-- HERO --}}
    <div class="panel-light-gold mb-8" data-aos="fade-up">
        <div class="relative">
            <div class="flex items-center gap-3 mb-3">
                <span class="badge-gold">Bendahara</span>
                <span class="text-xs text-light-muted">
                    {{ now()->translatedFormat('F Y') }}
                </span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-display font-bold mb-2 text-light-text">
                Dashboard <span class="text-gold-dark">Bendahara</span>
            </h2>
            <p class="text-light-muted text-sm max-w-2xl">
                Kelola kas, input pembayaran, verifikasi bukti transfer, dan buat laporan keuangan organisasi.
            </p>
        </div>
    </div>

    {{-- STATS --}}
    @php
        $periodeBulan = now()->format('Y-m');
        $totalKasBulanIni = \App\Models\KasPembayaran::periode($periodeBulan)->lunas()->sum('nominal');
        $totalLunas = \App\Models\KasPembayaran::periode($periodeBulan)->lunas()->count();
        $totalBelumLunas = \App\Models\KasPembayaran::periode($periodeBulan)->belumLunas()->count();
        $totalAnggota = \App\Models\User::where('status_anggota', 'aktif')->count();
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $stats = [
                ['label' => 'Kas Bulan Ini', 'value' => 'Rp ' . number_format($totalKasBulanIni, 0, ',', '.'), 'icon' => 'cash', 'is_text' => true],
                ['label' => 'Sudah Lunas', 'value' => $totalLunas, 'icon' => 'check', 'is_text' => false],
                ['label' => 'Belum Lunas', 'value' => $totalBelumLunas, 'icon' => 'alert', 'is_text' => false],
                ['label' => 'Total Anggota', 'value' => $totalAnggota, 'icon' => 'users', 'is_text' => false],
            ];
        @endphp

        @foreach($stats as $i => $stat)
            <div class="panel-light-interactive group" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                <div class="flex items-start justify-between mb-5">
                    <div class="icon-badge-light group-hover:bg-gold/15 transition-all">
                        @if($stat['icon'] === 'cash')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @elseif($stat['icon'] === 'check')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @elseif($stat['icon'] === 'alert')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        @endif
                    </div>
                </div>
                <div class="{{ $stat['is_text'] ? 'text-xl sm:text-2xl' : 'text-3xl sm:text-4xl' }} 
                            font-display font-bold 
                            bg-gradient-to-br from-gold-dark to-gold bg-clip-text text-transparent 
                            mb-1 leading-tight">
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
            <h3 class="section-head-title-light">Menu Utama Bendahara</h3>
            <p class="section-head-sub-light">Fitur pengelolaan keuangan</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" data-aos="fade-up">
        <a href="{{ route('dashboard.cash') }}" 
           class="panel-light-interactive group">
            <div class="flex items-start justify-between mb-5">
                <div class="icon-badge-light-solid group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
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
                Kas & Pembayaran
            </h3>
            <p class="text-light-muted text-sm leading-relaxed">
                Input pembayaran kas, verifikasi bukti transfer, dan pantau status setiap anggota.
            </p>
        </a>

        <a href="{{ route('dashboard.reports') }}" 
           class="panel-light-interactive group">
            <div class="flex items-start justify-between mb-5">
                <div class="icon-badge-light-solid group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
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
                Laporan Keuangan
            </h3>
            <p class="text-light-muted text-sm leading-relaxed">
                Export laporan kas dalam format PDF & Excel. Rekap bulanan dan tahunan.
            </p>
        </a>
    </div>

@endsection