@extends('layouts.dashboard')

@section('title', 'Dashboard PDD')
@section('subtitle', 'Publikasi, Dokumentasi, dan Desain')

@section('content')

    {{-- HERO --}}
    <div class="panel-light-gold mb-8" data-aos="fade-up">
        <div class="relative">
            <div class="flex items-center gap-3 mb-3">
                <span class="badge-gold">PDD</span>
                <span class="text-xs text-light-muted">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-display font-bold mb-2 text-light-text">
                Dashboard <span class="text-gold-text">PDD</span>
            </h2>
            <p class="text-light-muted text-sm max-w-2xl">
                Publikasi, Dokumentasi, dan Desain — abadikan setiap momen berharga organisasi.
            </p>
        </div>
    </div>

    {{-- STATS --}}
    @php
        $totalAlbum = \App\Models\DokumentasiAlbum::count();
        $totalMedia = \App\Models\DokumentasiMedia::count();
        $totalPrestasi = \App\Models\Prestasi::count();
        $totalPengumuman = \App\Models\Pengumuman::count();
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $stats = [
                ['label' => 'Total Album', 'value' => $totalAlbum, 'icon' => 'album'],
                ['label' => 'Foto & Video', 'value' => $totalMedia, 'icon' => 'image'],
                ['label' => 'Prestasi Terdata', 'value' => $totalPrestasi, 'icon' => 'trophy'],
                ['label' => 'Pengumuman', 'value' => $totalPengumuman, 'icon' => 'bell'],
            ];
        @endphp

        @foreach($stats as $i => $stat)
            <div class="panel-light-interactive group" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                <div class="flex items-start justify-between mb-5">
                    <div class="icon-badge-light group-hover:bg-gold/15 transition-all">
                        @if($stat['icon'] === 'album')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        @elseif($stat['icon'] === 'image')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @elseif($stat['icon'] === 'trophy')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
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
            <h3 class="section-head-title-light">Menu Utama PDD</h3>
            <p class="section-head-sub-light">Fitur publikasi & dokumentasi</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4" data-aos="fade-up">
        <a href="{{ route('dashboard.albums.index') }}" 
           class="panel-light-interactive group">
            <div class="flex items-start justify-between mb-5">
                <div class="icon-badge-light-solid group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
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
                Album & Media
            </h3>
            <p class="text-light-muted text-sm leading-relaxed">
                Upload foto & video kegiatan, kelola album, dan atur dokumentasi organisasi.
            </p>
        </a>

        <a href="{{ route('dashboard.achievements') }}" 
           class="panel-light-interactive group">
            <div class="flex items-start justify-between mb-5">
                <div class="icon-badge-light-solid group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
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
                Prestasi
            </h3>
            <p class="text-light-muted text-sm leading-relaxed">
                Dokumentasikan setiap pencapaian organisasi dengan foto dan detail lomba.
            </p>
        </a>

        <a href="{{ route('dashboard.announcements') }}" 
           class="panel-light-interactive group">
            <div class="flex items-start justify-between mb-5">
                <div class="icon-badge-light-solid group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
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
                Pengumuman
            </h3>
            <p class="text-light-muted text-sm leading-relaxed">
                Buat pengumuman publik, atur target audience, dan broadcast info penting.
            </p>
        </a>
    </div>

@endsection