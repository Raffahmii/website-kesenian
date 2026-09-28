@extends('layouts.dashboard')

@section('title', $achievement->nama_lomba)
@section('subtitle', 'Detail prestasi')

@section('content')

    {{-- BREADCRUMB + ACTIONS --}}
    <div class="mb-6 flex items-center justify-between flex-wrap gap-3" data-aos="fade-up">
        <a href="{{ route('dashboard.achievements.index') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>

        @can('manage-docs')
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.achievements.edit', $achievement->id_prestasi) }}" class="btn-gold btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>

                <button 
                    type="button"
                    x-data
                    @click="$dispatch('open-delete-achievement')"
                    class="px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600
                           text-white text-sm font-medium transition-colors
                           flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus
                </button>
            </div>
        @endcan
    </div>

    {{-- HERO --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative flex flex-col md:flex-row gap-6">

            {{-- FOTO / TROPHY --}}
            <div class="shrink-0 w-full md:w-72">
                <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-gradient-to-br from-gold/20 to-bg-secondary relative">
                    @if($achievement->foto)
                        <img src="{{ asset('storage/' . $achievement->foto) }}" 
                             alt="{{ $achievement->nama_lomba }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="w-24 h-24 text-gold/40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                      d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                    @endif

                    @if($achievement->peringkat)
                        <div class="absolute bottom-3 left-3 right-3">
                            <div class="px-4 py-2 rounded-xl gradient-gold shadow-lg shadow-gold/30 text-center">
                                <p class="text-bg-primary text-sm font-bold">🏆 {{ $achievement->peringkat }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- INFO --}}
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-3 flex-wrap">
                    <span class="badge-gold text-[10px]">{{ $achievement->tingkat->label() }}</span>
                    @if($achievement->kategori)
                        <span class="text-[10px] px-2.5 py-1 rounded-full bg-light-bg border border-light-border
                                     text-light-muted font-medium">{{ $achievement->kategori }}</span>
                    @endif
                </div>

                <h1 class="font-display font-bold text-2xl md:text-3xl text-light-text mb-3 leading-tight">
                    {{ $achievement->nama_lomba }}
                </h1>

                @if($achievement->deskripsi)
                    <p class="text-light-muted text-sm leading-relaxed mb-4">{{ $achievement->deskripsi }}</p>
                @endif

                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <div class="p-3 rounded-xl bg-light-bg border border-light-border">
                        <p class="text-[10px] uppercase tracking-wider text-light-muted mb-1">Tahun</p>
                        <p class="font-semibold text-sm text-light-text">{{ $achievement->tahun }}</p>
                    </div>
                    @if($achievement->tanggal)
                        <div class="p-3 rounded-xl bg-light-bg border border-light-border">
                            <p class="text-[10px] uppercase tracking-wider text-light-muted mb-1">Tanggal</p>
                            <p class="font-semibold text-sm text-light-text">{{ $achievement->tanggal->format('d M Y') }}</p>
                        </div>
                    @endif
                    @if($achievement->penyelenggara)
                        <div class="p-3 rounded-xl bg-light-bg border border-light-border">
                            <p class="text-[10px] uppercase tracking-wider text-light-muted mb-1">Penyelenggara</p>
                            <p class="font-semibold text-sm text-light-text truncate">{{ $achievement->penyelenggara }}</p>
                        </div>
                    @endif
                </div>

                @if($achievement->lokasi)
                    <p class="text-light-muted text-xs mt-3 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $achievement->lokasi }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    {{-- PESERTA --}}
    <div class="panel-light mb-6" data-aos="fade-up">
        <div class="section-head-light">
            <div class="icon-badge-light">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="section-head-title-light">Peserta</h3>
                <p class="section-head-sub-light">{{ $achievement->peserta->count() }} anggota terlibat</p>
            </div>
        </div>

        @if($achievement->peserta->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($achievement->peserta as $p)
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-light-bg border border-light-border">
                        @if($p->user?->photo)
                            <img src="{{ asset('storage/' . $p->user->photo) }}" 
                                 class="w-10 h-10 rounded-xl object-cover shrink-0">
                        @else
                            <div class="w-10 h-10 rounded-xl gradient-gold flex items-center justify-center
                                        font-display font-bold text-bg-primary shrink-0">
                                {{ strtoupper(substr($p->user->nama_lengkap ?? '?', 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-light-text truncate">
                                {{ $p->user->nama_lengkap ?? '-' }}
                            </p>
                            <p class="text-xs text-light-muted truncate">
                                {{ $p->user->kelas ?? '' }} {{ $p->user->jurusan ?? '' }}
                                @if($p->user?->cabang)
                                    · {{ $p->user->cabang->shortLabel() }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-4xl mb-2 opacity-40">👥</div>
                <p class="text-sm text-light-muted">Belum ada peserta tercatat</p>
            </div>
        @endif
    </div>

    {{-- INFO PEMBUAT --}}
    <div class="panel-light" data-aos="fade-up">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl gradient-gold flex items-center justify-center
                        font-display font-bold text-bg-primary shrink-0">
                {{ strtoupper(substr($achievement->pencatat->nama_lengkap ?? '?', 0, 1)) }}
            </div>
            <div class="flex-1">
                <p class="text-xs text-light-muted">
                    Dicatat oleh <span class="font-medium text-light-text">{{ $achievement->pencatat->nama_lengkap ?? '-' }}</span>
                    pada {{ $achievement->created_at->translatedFormat('d F Y, H:i') }}
                </p>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════
         MODAL KONFIRMASI HAPUS
         ═══════════════════════════════════════ --}}
    @can('manage-docs')
        <div 
            x-data="{ open: false }"
            x-init="
                window.addEventListener('open-delete-achievement', () => {
                    open = true;
                    document.body.style.overflow = 'hidden';
                });
            "
            @keydown.escape.window="open = false; document.body.style.overflow = ''"
            x-show="open"
            x-cloak
            @click.self="open = false; document.body.style.overflow = ''"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4
                   bg-black/60 backdrop-blur-md"
        >
            <div 
                @click.stop
                x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="relative w-full max-w-md rounded-3xl overflow-hidden
                       bg-light-card border border-light-border
                       shadow-2xl shadow-black/40"
            >
                {{-- Red glow top --}}
                <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-64 h-64 
                            bg-red-500/15 rounded-full blur-3xl pointer-events-none"></div>

                {{-- Close button --}}
                <button 
                    @click="open = false; document.body.style.overflow = ''"
                    class="absolute top-4 right-4 z-10 p-2 rounded-xl 
                           text-light-muted hover:text-red-500 hover:bg-red-50 
                           transition-all"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- Content --}}
                <div class="relative p-6 sm:p-8 text-center">

                    {{-- Icon warning --}}
                    <div class="w-16 h-16 mx-auto rounded-3xl bg-red-100 
                                flex items-center justify-center mb-5
                                animate-pulse">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>

                    {{-- Title --}}
                    <h3 class="font-display font-bold text-xl text-light-text mb-2">
                        Hapus Prestasi?
                    </h3>

                    {{-- Description --}}
                    <p class="text-sm text-light-muted mb-2">
                        Kamu akan menghapus prestasi:
                    </p>

                    <div class="p-3 rounded-xl bg-light-bg border border-light-border mb-5">
                        <p class="font-semibold text-sm text-light-text">
                            {{ $achievement->nama_lomba }}
                        </p>
                        <p class="text-xs text-light-muted mt-0.5">
                            {{ $achievement->tingkat->label() }} · {{ $achievement->tahun }}
                        </p>
                    </div>

                    <p class="text-xs text-red-500 mb-6">
                        ⚠️ Data peserta juga akan terhapus. Tindakan ini tidak bisa dibatalkan!
                    </p>

                    {{-- Actions --}}
                    <div class="flex gap-3">
                        <button 
                            type="button"
                            @click="open = false; document.body.style.overflow = ''"
                            class="flex-1 px-4 py-3 rounded-xl border border-light-border
                                   text-light-muted hover:bg-light-bg 
                                   font-medium text-sm transition-colors"
                        >
                            Batal
                        </button>

                        <form action="{{ route('dashboard.achievements.destroy', $achievement->id_prestasi) }}" 
                              method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit"
                                class="w-full px-4 py-3 rounded-xl bg-red-500 hover:bg-red-600
                                       text-white font-medium text-sm transition-colors
                                       flex items-center justify-center gap-2
                                       shadow-lg shadow-red-500/30 hover:shadow-red-500/50"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Ya, Hapus
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endcan

@endsection