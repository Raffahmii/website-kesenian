@extends('layouts.dashboard')

@section('title', 'Dokumentasi')
@section('subtitle', 'Kelola album & media kegiatan')

@section('content')

    {{-- HERO --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-display font-bold mb-1 text-light-text">
                    Dokumentasi <span class="text-gold-dark">Kegiatan</span>
                </h2>
                <p class="text-light-muted text-sm">
                    {{ $stats['total_album'] }} album · {{ $stats['total_media'] }} media
                </p>
            </div>
            @can('manage-docs')
                <a href="{{ route('dashboard.albums.create') }}" class="btn-gold self-start sm:self-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Buat Album
                </a>
            @endcan
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php
            $statCards = [
                ['label' => 'Total Album', 'value' => $stats['total_album']],
                ['label' => 'Total Media', 'value' => $stats['total_media']],
                ['label' => 'Foto', 'value' => $stats['total_foto']],
                ['label' => 'Video', 'value' => $stats['total_video']],
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
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="sm:col-span-2 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-light-muted" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul album..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm
                              bg-light-bg border border-light-border text-light-text
                              placeholder-light-muted/70 focus:outline-none focus:bg-white
                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
            </div>

            <select name="kategori" class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                          text-light-text focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat }}" @selected(request('kategori') === $kat)>{{ $kat }}</option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- GRID ALBUM --}}
    @if($albums->isEmpty())
        <div class="panel-light text-center py-16" data-aos="fade-up">
            <div class="text-5xl mb-3">📸</div>
            <p class="text-light-text font-medium mb-1">Belum ada album</p>
            <p class="text-light-muted text-sm mb-6">Mulai dengan membuat album pertama</p>
            @can('manage-docs')
                <a href="{{ route('dashboard.albums.create') }}" class="btn-gold inline-flex">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Buat Album
                </a>
            @endcan
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($albums as $i => $album)
                <a href="{{ route('dashboard.albums.show', $album->id_album) }}"
                   class="group relative overflow-hidden rounded-2xl bg-light-card 
                          border border-light-border hover:border-gold/50
                          transition-all duration-500 hover:-translate-y-1
                          hover:shadow-xl hover:shadow-gold/10 block"
                   data-aos="fade-up" data-aos-delay="{{ $i * 60 }}">

                    {{-- Cover --}}
                    <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-gold/20 to-bg-secondary">
                        @if($album->cover_image)
                            <img src="{{ asset('storage/' . $album->cover_image) }}" 
                                 alt="{{ $album->judul }}"
                                 class="w-full h-full object-cover transition-transform duration-700 
                                        group-hover:scale-110">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gold/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Gradient overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                        {{-- Kategori badge --}}
                        @if($album->kategori)
                            <div class="absolute top-3 left-3">
                                <span class="text-[10px] px-2.5 py-1 rounded-full font-medium
                                             bg-bg-primary/80 backdrop-blur-sm text-gold border border-gold/30">
                                    {{ $album->kategori }}
                                </span>
                            </div>
                        @endif

                        {{-- Count media --}}
                        <div class="absolute top-3 right-3 flex items-center gap-1.5
                                    bg-bg-primary/80 backdrop-blur-sm px-2.5 py-1.5 rounded-lg
                                    border border-gold/30">
                            <svg class="w-3 h-3 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-xs text-white font-medium">{{ $album->media_count }}</span>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="p-5">
                        <h3 class="font-display font-bold text-base text-light-text mb-1 
                                   group-hover:text-gold-dark transition-colors leading-snug line-clamp-2">
                            {{ $album->judul }}
                        </h3>
                        <div class="flex items-center justify-between text-xs text-light-muted">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $album->tanggal_kegiatan?->format('d M Y') ?? $album->created_at->format('d M Y') }}
                            </span>
                            <span class="truncate ml-2">
                                oleh {{ $album->uploader->nama_lengkap ?? '-' }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if($albums->hasPages())
            <div class="mt-6">{{ $albums->links() }}</div>
        @endif
    @endif

@endsection