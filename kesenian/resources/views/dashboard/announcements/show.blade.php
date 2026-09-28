@extends('layouts.dashboard')

@section('title', $announcement->judul)
@section('subtitle', 'Detail pengumuman')

@section('content')

    {{-- BREADCRUMB + ACTIONS --}}
    <div class="mb-6 flex items-center justify-between flex-wrap gap-3" data-aos="fade-up">
        <a href="{{ route('dashboard.announcements.index') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Pengumuman
        </a>

        @can('manage-members')
            <div class="flex items-center gap-2 flex-wrap">
                {{-- Toggle Publish --}}
                <form action="{{ route('dashboard.announcements.toggle-publish', $announcement->id_pengumuman) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition-colors
                                   flex items-center gap-2
                                   {{ $announcement->is_published 
                                       ? 'bg-yellow-100 hover:bg-yellow-200 text-yellow-700' 
                                       : 'bg-green-100 hover:bg-green-200 text-green-700' }}">
                        @if($announcement->is_published)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                            Unpublish
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Publish
                        @endif
                    </button>
                </form>

                <a href="{{ route('dashboard.announcements.edit', $announcement->id_pengumuman) }}" class="btn-gold btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>

                <button 
                    type="button"
                    x-data
                    @click="$dispatch('open-delete-announcement')"
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

    {{-- MAIN CARD --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative">

            {{-- Header badges --}}
            <div class="flex items-center gap-2 mb-4 flex-wrap">
                @if($announcement->is_published)
                    <span class="text-[10px] px-2.5 py-1 rounded-full font-medium 
                                 bg-green-100 text-green-700 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                        Published
                    </span>
                @else
                    <span class="text-[10px] px-2.5 py-1 rounded-full font-medium 
                                 bg-yellow-100 text-yellow-700 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                        Draft
                    </span>
                @endif

                @php
                    $targetClass = match($announcement->target_role) {
                        \App\Enums\TargetPengumuman::SEMUA    => 'badge-gold',
                        \App\Enums\TargetPengumuman::ANGGOTA  => 'bg-blue-100 text-blue-700',
                        \App\Enums\TargetPengumuman::PENGURUS => 'bg-purple-100 text-purple-700',
                    };
                @endphp
                <span class="text-[10px] px-2.5 py-1 rounded-full font-medium {{ $targetClass }}">
                    Target: {{ $announcement->target_role->label() }}
                </span>
            </div>

            {{-- Title --}}
            <h1 class="font-display font-bold text-2xl md:text-3xl text-light-text mb-3 leading-tight">
                {{ $announcement->judul }}
            </h1>

            {{-- Meta --}}
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-light-muted mb-6">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    {{ $announcement->pembuat->nama_lengkap ?? '-' }}
                </span>

                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ ($announcement->published_at ?? $announcement->created_at)->translatedFormat('d F Y, H:i') }}
                </span>
            </div>

            {{-- Divider --}}
            <div class="divider-light mb-6"></div>

            {{-- Content --}}
            <div class="prose prose-sm max-w-none text-light-text leading-relaxed
                        whitespace-pre-line">
                {{ $announcement->isi }}
            </div>

        </div>
    </div>

    {{-- LAMPIRAN --}}
    @if($announcement->lampiran)
        <div class="panel-light mb-6" data-aos="fade-up">
            <div class="section-head-light">
                <div class="icon-badge-light">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                    </svg>
                </div>
                <div>
                    <h3 class="section-head-title-light">Lampiran</h3>
                    <p class="section-head-sub-light">File pendukung pengumuman</p>
                </div>
            </div>

            <a href="{{ asset('storage/' . $announcement->lampiran) }}" 
               target="_blank"
               class="flex items-center gap-4 p-4 rounded-2xl bg-light-bg border border-light-border
                      hover:border-gold/50 hover:bg-gold/[0.03] transition-all group">
                <div class="w-12 h-12 rounded-xl gradient-gold flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-bg-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-light-text truncate">
                        {{ basename($announcement->lampiran) }}
                    </p>
                    <p class="text-xs text-light-muted">Klik untuk buka / download</p>
                </div>
                <svg class="w-5 h-5 text-light-muted group-hover:text-gold-dark 
                            group-hover:translate-x-1 transition-all shrink-0" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </div>
    @endif

    {{-- MODAL HAPUS --}}
    @can('manage-members')
        <div 
            x-data="{ open: false }"
            x-init="
                window.addEventListener('open-delete-announcement', () => {
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
                <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-64 h-64 
                            bg-red-500/15 rounded-full blur-3xl pointer-events-none"></div>

                <button 
                    @click="open = false; document.body.style.overflow = ''"
                    class="absolute top-4 right-4 z-10 p-2 rounded-xl 
                           text-light-muted hover:text-red-500 hover:bg-red-50 transition-all"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="relative p-6 sm:p-8 text-center">
                    <div class="w-16 h-16 mx-auto rounded-3xl bg-red-100 
                                flex items-center justify-center mb-5 animate-pulse">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>

                    <h3 class="font-display font-bold text-xl text-light-text mb-2">
                        Hapus Pengumuman?
                    </h3>

                    <p class="text-sm text-light-muted mb-2">
                        Kamu akan menghapus pengumuman:
                    </p>

                    <div class="p-3 rounded-xl bg-light-bg border border-light-border mb-5">
                        <p class="font-semibold text-sm text-light-text">
                            {{ $announcement->judul }}
                        </p>
                        <p class="text-xs text-light-muted mt-0.5">
                            Target: {{ $announcement->target_role->label() }}
                        </p>
                    </div>

                    <p class="text-xs text-red-500 mb-6">
                        ⚠️ Lampiran juga akan terhapus. Tidak bisa dibatalkan!
                    </p>

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

                        <form action="{{ route('dashboard.announcements.destroy', $announcement->id_pengumuman) }}" 
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