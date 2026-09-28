@extends('layouts.dashboard')

@section('title', 'Jadwal & Event')
@section('subtitle', 'Kelola seluruh agenda kegiatan organisasi')

@section('content')

    {{-- HERO --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-display font-bold mb-1 text-light-text">
                    Jadwal & <span class="text-gold-dark">Event</span>
                </h2>
                <p class="text-light-muted text-sm">
                    Total {{ $stats['total'] }} kegiatan · {{ $stats['upcoming'] }} akan datang
                </p>
            </div>
            @can('manage-events')
                <a href="{{ route('dashboard.events.create') }}" class="btn-gold self-start sm:self-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Buat Jadwal
                </a>
            @endcan
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php
            $statCards = [
                ['label' => 'Total Kegiatan', 'value' => $stats['total']],
                ['label' => 'Akan Datang', 'value' => $stats['upcoming']],
                ['label' => 'Bulan Ini', 'value' => $stats['this_month']],
                ['label' => 'Selesai', 'value' => $stats['completed']],
            ];
        @endphp

        @foreach($statCards as $i => $stat)
            <div class="panel-light" data-aos="fade-up" data-aos-delay="{{ $i * 60 }}">
                <div class="text-3xl font-display font-bold 
                            bg-gradient-to-br from-gold-dark to-gold bg-clip-text text-transparent 
                            mb-1 leading-none">
                    {{ $stat['value'] }}
                </div>
                <div class="text-xs text-light-muted font-medium">{{ $stat['label'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- FILTER --}}
    <div class="panel-light mb-6" data-aos="fade-up">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="lg:col-span-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-light-muted" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input 
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari jadwal..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm
                           bg-light-bg border border-light-border
                           text-light-text placeholder-light-muted/70
                           focus:outline-none focus:bg-white
                           focus:border-gold/50 focus:ring-2 focus:ring-gold/20"
                >
            </div>

            <select name="jenis" 
                    class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                           text-light-text focus:outline-none focus:bg-white
                           focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Jenis</option>
                @foreach(\App\Enums\JenisKegiatan::cases() as $j)
                    <option value="{{ $j->value }}" @selected(request('jenis') === $j->value)>
                        {{ $j->icon() }} {{ $j->label() }}
                    </option>
                @endforeach
            </select>

            <select name="waktu" 
                    class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                           text-light-text focus:outline-none focus:bg-white
                           focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Waktu</option>
                <option value="upcoming" @selected(request('waktu') === 'upcoming')>Akan Datang</option>
                <option value="past" @selected(request('waktu') === 'past')>Sudah Lewat</option>
            </select>

            <button type="submit" class="btn-gold btn-sm justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter
            </button>
        </form>
    </div>

    {{-- LIST --}}
    <div class="space-y-4" data-aos="fade-up">
        @forelse($schedules as $schedule)
            @php
                $isPast = \Carbon\Carbon::parse($schedule->tanggal)->isPast();
            @endphp
            <a href="{{ route('dashboard.events.show', $schedule->id_jadwal) }}"
               class="panel-light-interactive group block {{ $isPast ? 'opacity-75' : '' }}">
                <div class="flex items-start gap-4">

                    {{-- Date Block --}}
                    <div class="shrink-0">
                        <div class="w-16 h-16 rounded-2xl 
                                    {{ $isPast ? 'bg-light-bg border border-light-border' : 'gradient-gold shadow-lg shadow-gold/30' }} 
                                    flex flex-col items-center justify-center
                                    group-hover:scale-105 transition-transform">
                            <span class="text-xl font-display font-bold {{ $isPast ? 'text-light-muted' : 'text-bg-primary' }} leading-none">
                                {{ \Carbon\Carbon::parse($schedule->tanggal)->format('d') }}
                            </span>
                            <span class="text-[9px] uppercase tracking-wider {{ $isPast ? 'text-light-muted' : 'text-bg-primary/80' }} font-semibold mt-0.5">
                                {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('M Y') }}
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-2 flex-wrap">
                            <span class="badge-gold text-[10px]">
                                {{ $schedule->jenis->icon() }} {{ $schedule->jenis->label() }}
                            </span>
                            @if($isPast)
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-light-bg text-light-muted font-medium">
                                    Selesai
                                </span>
                            @endif
                        </div>

                        <h3 class="font-display font-bold text-lg text-light-text mb-2 
                                   group-hover:text-gold-dark transition-colors leading-snug">
                            {{ $schedule->judul }}
                        </h3>

                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-light-muted">
                            @if($schedule->jam_mulai)
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }}
                                </span>
                            @endif

                            @if($schedule->lokasi)
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $schedule->lokasi }}
                                </span>
                            @endif

                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $schedule->absensi()->count() }} absensi
                            </span>
                        </div>
                    </div>

                    <div class="shrink-0 self-center">
                        <svg class="w-5 h-5 text-light-muted group-hover:text-gold-dark 
                                    group-hover:translate-x-1 transition-all" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>
        @empty
            <div class="panel-light text-center py-16">
                <div class="text-5xl mb-3">📅</div>
                <p class="text-light-text font-medium mb-1">Belum ada jadwal kegiatan</p>
                <p class="text-light-muted text-sm mb-6">Mulai dengan membuat jadwal pertama</p>
                @can('manage-events')
                    <a href="{{ route('dashboard.events.create') }}" class="btn-gold inline-flex">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Buat Jadwal
                    </a>
                @endcan
            </div>
        @endforelse
    </div>

    @if($schedules->hasPages())
        <div class="mt-6">{{ $schedules->links() }}</div>
    @endif

@endsection