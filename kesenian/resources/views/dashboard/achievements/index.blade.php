@extends('layouts.dashboard')

@section('title', 'Prestasi')
@section('subtitle', 'Jejak kemenangan organisasi')

@section('content')

    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-display font-bold mb-1 text-light-text">
                    Jejak <span class="text-gold-dark">Kemenangan</span>
                </h2>
                <p class="text-light-muted text-sm">
                    Total {{ $stats['total'] }} prestasi diraih
                </p>
            </div>
            @can('manage-docs')
                <a href="{{ route('dashboard.achievements.create') }}" class="btn-gold self-start sm:self-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Prestasi
                </a>
            @endcan
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php
            $statCards = [
                ['label' => 'Total Prestasi', 'value' => $stats['total']],
                ['label' => 'Tingkat Nasional', 'value' => $stats['nasional']],
                ['label' => 'Tingkat Provinsi', 'value' => $stats['provinsi']],
                ['label' => 'Tingkat Kabupaten', 'value' => $stats['kabupaten']],
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
        <form method="GET" class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="col-span-2 sm:col-span-1 relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari lomba..."
                       class="w-full px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                              text-light-text placeholder-light-muted/70 focus:outline-none focus:bg-white
                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
            </div>

            <select name="tingkat" class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                          text-light-text focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Tingkat</option>
                @foreach(\App\Enums\TingkatPrestasi::cases() as $t)
                    <option value="{{ $t->value }}" @selected(request('tingkat') === $t->value)>
                        {{ $t->shortLabel() }}
                    </option>
                @endforeach
            </select>

            <select name="tahun" class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                         text-light-text focus:outline-none focus:bg-white
                                         focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Tahun</option>
                @foreach($tahunList as $th)
                    <option value="{{ $th }}" @selected(request('tahun') == $th)>{{ $th }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-gold btn-sm justify-center">Filter</button>
        </form>
    </div>

    {{-- GRID --}}
    @if($achievements->isEmpty())
        <div class="panel-light text-center py-16" data-aos="fade-up">
            <div class="text-5xl mb-3">🏆</div>
            <p class="text-light-text font-medium mb-1">Belum ada prestasi</p>
            <p class="text-light-muted text-sm mb-6">Mulai catat prestasi pertama</p>
            @can('manage-docs')
                <a href="{{ route('dashboard.achievements.create') }}" class="btn-gold inline-flex">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Prestasi
                </a>
            @endcan
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($achievements as $i => $a)
                <a href="{{ route('dashboard.achievements.show', $a->id_prestasi) }}"
                   class="group relative overflow-hidden rounded-2xl bg-light-card 
                          border border-light-border hover:border-gold/50
                          transition-all duration-500 hover:-translate-y-1
                          hover:shadow-xl hover:shadow-gold/10 block"
                   data-aos="fade-up" data-aos-delay="{{ ($i % 6) * 60 }}">

                    {{-- Foto atau trophy SVG --}}
                    <div class="relative h-44 overflow-hidden bg-gradient-to-br from-gold/20 to-bg-secondary">
                        @if($a->foto)
                            <img src="{{ asset('storage/' . $a->foto) }}" alt="{{ $a->nama_lomba }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-20 h-20 text-gold/40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                          d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Peringkat --}}
                        @if($a->peringkat)
                            <div class="absolute top-3 left-3">
                                <div class="px-3 py-1.5 rounded-full gradient-gold shadow-lg shadow-gold/30">
                                    <span class="text-bg-primary text-xs font-bold">
                                        🏆 {{ $a->peringkat }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        {{-- Tingkat badge --}}
                        <div class="absolute top-3 right-3">
                            <span class="text-[10px] px-2.5 py-1 rounded-full font-semibold uppercase
                                         bg-bg-primary/90 backdrop-blur-sm text-gold border border-gold/40">
                                {{ $a->tingkat->shortLabel() }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5">
                        <h3 class="font-display font-bold text-base text-light-text mb-2 
                                   group-hover:text-gold-dark transition-colors leading-snug line-clamp-2">
                            {{ $a->nama_lomba }}
                        </h3>
                        <div class="flex items-center justify-between text-xs text-light-muted">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $a->tahun }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $a->peserta_count }} peserta
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if($achievements->hasPages())
            <div class="mt-6">{{ $achievements->links() }}</div>
        @endif
    @endif

@endsection