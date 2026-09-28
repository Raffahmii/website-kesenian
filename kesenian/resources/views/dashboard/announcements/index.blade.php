@extends('layouts.dashboard')

@section('title', 'Pengumuman')
@section('subtitle', $isPengurus ? 'Kelola pengumuman organisasi' : 'Pengumuman untukmu')

@section('content')

    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-display font-bold mb-1 text-light-text">
                    <span class="text-gold-dark">Pengumuman</span>
                </h2>
                <p class="text-light-muted text-sm">
                    @if($isPengurus)
                        Total {{ $stats['total'] }} pengumuman · {{ $stats['published'] }} published
                    @else
                        Info & berita terbaru dari organisasi
                    @endif
                </p>
            </div>
            @can('manage-members')
                <a href="{{ route('dashboard.announcements.create') }}" class="btn-gold self-start sm:self-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Buat Pengumuman
                </a>
            @endcan
        </div>
    </div>

    @if($isPengurus)
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="panel-light" data-aos="fade-up">
                <div class="text-3xl font-display font-bold 
                            bg-gradient-to-br from-gold-dark to-gold bg-clip-text text-transparent mb-1">
                    {{ $stats['total'] }}
                </div>
                <div class="text-xs text-light-muted font-medium">Total</div>
            </div>
            <div class="panel-light" data-aos="fade-up" data-aos-delay="60">
                <div class="text-3xl font-display font-bold 
                            bg-gradient-to-br from-green-600 to-green-400 bg-clip-text text-transparent mb-1">
                    {{ $stats['published'] }}
                </div>
                <div class="text-xs text-light-muted font-medium">Published</div>
            </div>
            <div class="panel-light" data-aos="fade-up" data-aos-delay="120">
                <div class="text-3xl font-display font-bold 
                            bg-gradient-to-br from-yellow-600 to-yellow-400 bg-clip-text text-transparent mb-1">
                    {{ $stats['draft'] }}
                </div>
                <div class="text-xs text-light-muted font-medium">Draft</div>
            </div>
        </div>
    @endif

    {{-- FILTER --}}
    <div class="panel-light mb-6" data-aos="fade-up">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="sm:col-span-1 relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari pengumuman..."
                       class="w-full px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                              text-light-text placeholder-light-muted/70 focus:outline-none focus:bg-white
                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
            </div>

            <select name="target" class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                          text-light-text focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Target</option>
                @foreach(\App\Enums\TargetPengumuman::cases() as $t)
                    <option value="{{ $t->value }}" @selected(request('target') === $t->value)>
                        {{ $t->label() }}
                    </option>
                @endforeach
            </select>

            @if($isPengurus)
                <select name="status" class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                              text-light-text focus:outline-none focus:bg-white
                                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    <option value="">Semua Status</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                </select>
            @endif
        </form>
    </div>

    {{-- LIST --}}
    @if($announcements->isEmpty())
        <div class="panel-light text-center py-16" data-aos="fade-up">
            <div class="text-5xl mb-3">📢</div>
            <p class="text-light-text font-medium mb-1">Belum ada pengumuman</p>
            <p class="text-light-muted text-sm mb-6">Belum ada pengumuman untuk saat ini</p>
            @can('manage-members')
                <a href="{{ route('dashboard.announcements.create') }}" class="btn-gold inline-flex">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Buat Pengumuman
                </a>
            @endcan
        </div>
    @else
        <div class="space-y-4">
            @foreach($announcements as $i => $a)
                <a href="{{ route('dashboard.announcements.show', $a->id_pengumuman) }}"
                   class="panel-light-interactive group block relative"
                   data-aos="fade-up" data-aos-delay="{{ ($i % 8) * 50 }}">

                    {{-- Draft indicator --}}
                    @if(!$a->is_published)
                        <div class="absolute top-4 right-4 z-10">
                            <span class="text-[10px] px-2.5 py-1 rounded-full font-medium bg-yellow-100 text-yellow-700
                                         flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                Draft
                            </span>
                        </div>
                    @endif

                    <div class="flex items-start gap-4">
                        <div class="shrink-0">
                            <div class="w-12 h-12 rounded-2xl 
                                        {{ $a->is_published ? 'gradient-gold shadow-lg shadow-gold/30' : 'bg-yellow-100' }} 
                                        flex items-center justify-center
                                        group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 {{ $a->is_published ? 'text-bg-primary' : 'text-yellow-600' }}" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2 flex-wrap">
                                @php
                                    $targetClass = match($a->target_role) {
                                        \App\Enums\TargetPengumuman::SEMUA    => 'badge-gold',
                                        \App\Enums\TargetPengumuman::ANGGOTA  => 'bg-blue-100 text-blue-700',
                                        \App\Enums\TargetPengumuman::PENGURUS => 'bg-purple-100 text-purple-700',
                                    };
                                @endphp
                                <span class="text-[10px] px-2.5 py-1 rounded-full font-medium {{ $targetClass }}">
                                    {{ $a->target_role->label() }}
                                </span>
                                <span class="text-xs text-light-muted">
                                    {{ $a->published_at?->translatedFormat('d F Y, H:i') ?? $a->created_at->translatedFormat('d F Y') }}
                                </span>
                            </div>

                            <h3 class="font-display font-bold text-lg text-light-text mb-2 
                                       group-hover:text-gold-dark transition-colors leading-snug">
                                {{ $a->judul }}
                            </h3>

                            <p class="text-light-muted text-sm leading-relaxed line-clamp-2">
                                {{ \Illuminate\Support\Str::limit(strip_tags($a->isi), 200) }}
                            </p>

                            <div class="flex items-center gap-3 mt-3 text-xs text-light-muted">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $a->pembuat->nama_lengkap ?? '-' }}
                                </span>
                                @if($a->lampiran)
                                    <span class="flex items-center gap-1.5 text-gold-dark">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                        </svg>
                                        Lampiran
                                    </span>
                                @endif
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
            @endforeach
        </div>

        @if($announcements->hasPages())
            <div class="mt-6">{{ $announcements->links() }}</div>
        @endif
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