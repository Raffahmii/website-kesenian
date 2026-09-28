@extends('layouts.dashboard')

@section('title', $album->judul)
@section('subtitle', 'Album dokumentasi · ' . $album->media->count() . ' media')

@section('content')

    {{-- BREADCRUMB --}}
    <div class="mb-6 flex items-center justify-between flex-wrap gap-3" data-aos="fade-up">
        <a href="{{ route('dashboard.albums.index') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Album
        </a>

        @can('manage-docs')
            <a href="{{ route('dashboard.albums.edit', $album->id_album) }}" class="btn-gold btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Album
            </a>
        @endcan
    </div>

    {{-- HERO ALBUM --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative flex flex-col md:flex-row gap-6">
            <div class="shrink-0 w-full md:w-64">
                <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-gradient-to-br from-gold/20 to-bg-secondary">
                    @if($album->cover_image)
                        <img src="{{ asset('storage/' . $album->cover_image) }}" 
                             alt="{{ $album->judul }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gold/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex-1">
                @if($album->kategori)
                    <span class="badge-gold text-[10px]">{{ $album->kategori }}</span>
                @endif

                <h1 class="font-display font-bold text-2xl md:text-3xl text-light-text mt-3 mb-2 leading-tight">
                    {{ $album->judul }}
                </h1>

                @if($album->deskripsi)
                    <p class="text-light-muted text-sm leading-relaxed mb-3">{{ $album->deskripsi }}</p>
                @endif

                <div class="flex flex-wrap gap-x-4 gap-y-2 text-xs text-light-muted">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $album->tanggal_kegiatan?->format('d F Y') ?? $album->created_at->format('d F Y') }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ $album->uploader->nama_lengkap ?? '-' }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $album->media->count() }} media
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- UPLOAD FORM --}}
    @can('manage-docs')
        <div class="panel-light mb-6" data-aos="fade-up">
            <div class="section-head-light">
                <div class="icon-badge-light-solid">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                <div>
                    <h3 class="section-head-title-light">Upload Media</h3>
                    <p class="section-head-sub-light">Foto (max 5MB) atau video (max 20MB)</p>
                </div>
            </div>

            <form method="POST" action="{{ route('dashboard.albums.media.upload', $album->id_album) }}" 
                  enctype="multipart/form-data"
                  x-data="{ files: [], handleFiles(e) { this.files = Array.from(e.target.files); } }">
                @csrf

                <div class="flex gap-3 mb-4">
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="tipe" value="foto" class="peer sr-only" checked>
                        <div class="p-3 rounded-xl border-2 border-light-border text-center
                                    peer-checked:bg-gold/10 peer-checked:border-gold peer-checked:text-gold-dark
                                    transition-all text-sm font-medium">📷 Foto</div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="tipe" value="video" class="peer sr-only">
                        <div class="p-3 rounded-xl border-2 border-light-border text-center
                                    peer-checked:bg-gold/10 peer-checked:border-gold peer-checked:text-gold-dark
                                    transition-all text-sm font-medium">🎬 Video</div>
                    </label>
                </div>

                <label class="block cursor-pointer mb-4">
                    <input type="file" name="files[]" multiple accept="image/*,video/*"
                           class="hidden"
                           @change="handleFiles($event)">
                    <div class="relative rounded-2xl border-2 border-dashed border-light-border
                                hover:border-gold/50 transition-colors p-8 bg-light-bg text-center">
                        <svg class="w-12 h-12 text-light-muted mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-sm font-medium text-light-text mb-1">Klik untuk pilih file</p>
                        <p class="text-xs text-light-muted">Bisa pilih banyak file sekaligus</p>

                        <template x-if="files.length > 0">
                            <div class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg
                                        bg-gold/10 text-gold-dark text-xs font-medium">
                                <span x-text="files.length"></span> file dipilih
                            </div>
                        </template>
                    </div>
                </label>

                <button type="submit" class="btn-gold w-full justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Upload Media
                </button>
            </form>
        </div>
    @endcan

    {{-- GRID MEDIA --}}
    @if($media->isEmpty())
        <div class="panel-light text-center py-16" data-aos="fade-up">
            <div class="text-5xl mb-3 opacity-50">📭</div>
            <p class="text-light-text font-medium mb-1">Album masih kosong</p>
            <p class="text-light-muted text-sm">Upload foto atau video pertama</p>
        </div>
    @else
        @php
            // Siapkan data media untuk Alpine
            $mediaData = $media->map(function($m) {
                return [
                    'id'       => $m->id_media,
                    'tipe'     => $m->tipe->value,
                    'url'      => asset('storage/' . $m->file_path),
                    'caption'  => $m->caption,
                    'created'  => $m->created_at->translatedFormat('d F Y, H:i'),
                ];
            })->values()->toArray();
        @endphp

        <div 
            x-data="{
                lightboxOpen: false,
                currentIndex: 0,
                items: {{ json_encode($mediaData) }},
                
                open(index) {
                    this.currentIndex = index;
                    this.lightboxOpen = true;
                    document.body.style.overflow = 'hidden';
                },
                close() {
                    this.lightboxOpen = false;
                    document.body.style.overflow = '';
                },
                next() {
                    this.currentIndex = (this.currentIndex + 1) % this.items.length;
                },
                prev() {
                    this.currentIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
                },
                get current() {
                    return this.items[this.currentIndex] || {};
                },
                isVideo(item) {
                    return item.tipe === 'video';
                }
            }"
            @keydown.escape.window="lightboxOpen && close()"
            @keydown.arrow-right.window="lightboxOpen && next()"
            @keydown.arrow-left.window="lightboxOpen && prev()"
        >
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($media as $i => $m)
                    <div class="group relative overflow-hidden rounded-2xl aspect-square 
                                bg-light-card border border-light-border
                                hover:border-gold/50 transition-all hover:-translate-y-1
                                hover:shadow-xl hover:shadow-gold/10 cursor-pointer"
                         data-aos="fade-up" data-aos-delay="{{ ($i % 8) * 50 }}"
                         @click="open({{ $i }})">

                        @if($m->tipe === \App\Enums\TipeMedia::FOTO)
                            <img src="{{ asset('storage/' . $m->file_path) }}" 
                                 alt="{{ $m->caption ?? '' }}"
                                 class="w-full h-full object-cover
                                        transition-transform duration-500 group-hover:scale-105">
                        @else
                            <video src="{{ asset('storage/' . $m->file_path) }}" 
                                   class="w-full h-full object-cover"
                                   preload="metadata"
                                   muted></video>
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="w-12 h-12 rounded-full bg-bg-primary/70 backdrop-blur
                                            flex items-center justify-center
                                            group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-gold ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>
                        @endif

                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent
                                    opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="absolute bottom-0 left-0 right-0 p-3">
                                @if($m->caption)
                                    <p class="text-white text-xs truncate">{{ $m->caption }}</p>
                                @endif
                                <p class="text-white/60 text-[10px] mt-0.5">
                                    {{ $m->tipe->label() }}
                                </p>
                            </div>

                            @can('manage-docs')
                                <div class="absolute top-2 right-2" @click.stop>
                                    <form action="{{ route('dashboard.albums.media.destroy', $m->id_media) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Hapus media ini?')"
                                                class="w-8 h-8 rounded-lg bg-red-500/90 hover:bg-red-600
                                                       text-white flex items-center justify-center transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endcan

                            {{-- Zoom icon --}}
                            <div class="absolute top-2 left-2">
                                <div class="w-8 h-8 rounded-lg bg-black/50 backdrop-blur
                                            flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ═══════════════════════════════════════════════════════
                 LIGHTBOX MODAL — Detail View
                 ═══════════════════════════════════════════════════════ --}}
            <div 
                x-show="lightboxOpen"
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-md
                       flex items-center justify-center"
                @click.self="close()"
            >
                {{-- CLOSE BUTTON --}}
                <button 
                    @click="close()"
                    class="absolute top-4 right-4 z-10 w-11 h-11 rounded-full
                           bg-white/10 hover:bg-white/20 backdrop-blur
                           text-white flex items-center justify-center
                           transition-all hover:rotate-90"
                    title="Tutup (ESC)"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- COUNTER --}}
                <div class="absolute top-4 left-4 z-10 px-4 py-2 rounded-full
                            bg-white/10 backdrop-blur text-white text-sm font-medium">
                    <span x-text="currentIndex + 1"></span> / <span x-text="items.length"></span>
                </div>

                {{-- PREV BUTTON --}}
                <button 
                    x-show="items.length > 1"
                    @click="prev()"
                    class="absolute left-4 z-10 w-12 h-12 rounded-full
                           bg-white/10 hover:bg-white/20 backdrop-blur
                           text-white flex items-center justify-center
                           transition-all hover:-translate-x-1"
                    title="Sebelumnya (←)"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                {{-- NEXT BUTTON --}}
                <button 
                    x-show="items.length > 1"
                    @click="next()"
                    class="absolute right-4 z-10 w-12 h-12 rounded-full
                           bg-white/10 hover:bg-white/20 backdrop-blur
                           text-white flex items-center justify-center
                           transition-all hover:translate-x-1"
                    title="Selanjutnya (→)"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                {{-- CONTENT WRAPPER --}}
                <div 
                    class="relative max-w-6xl w-full mx-4 sm:mx-16 
                           flex flex-col gap-4 max-h-[90vh]"
                    @click.stop
                >
                    {{-- MEDIA --}}
                    <div class="flex-1 flex items-center justify-center min-h-0">
                        {{-- FOTO --}}
                        <template x-if="!isVideo(current)">
                            <img 
                                :src="current.url" 
                                :alt="current.caption"
                                class="max-w-full max-h-[65vh] rounded-2xl object-contain shadow-2xl"
                            >
                        </template>

                        {{-- VIDEO --}}
                        <template x-if="isVideo(current)">
                            <video 
                                :src="current.url"
                                controls 
                                autoplay
                                class="max-w-full max-h-[65vh] rounded-2xl shadow-2xl"
                            ></video>
                        </template>
                    </div>

                    {{-- INFO BAR --}}
                    <div class="rounded-2xl bg-white/5 backdrop-blur-md border border-white/10 p-5">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                {{-- Tipe badge --}}
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full
                                                 bg-gold/20 text-gold text-[10px] font-semibold uppercase tracking-wider">
                                        <template x-if="!isVideo(current)">
                                            <span>📷 Foto</span>
                                        </template>
                                        <template x-if="isVideo(current)">
                                            <span>🎬 Video</span>
                                        </template>
                                    </span>
                                </div>

                                {{-- Caption --}}
                                <template x-if="current.caption">
                                    <p class="text-white font-medium text-base leading-snug mb-1"
                                       x-text="current.caption"></p>
                                </template>
                                <template x-if="!current.caption">
                                    <p class="text-white/50 italic text-sm mb-1">
                                        Tidak ada keterangan
                                    </p>
                                </template>

                                {{-- Tanggal --}}
                                <p class="text-white/60 text-xs flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Diupload <span x-text="current.created"></span>
                                </p>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-2 shrink-0">
                                {{-- Open in new tab --}}
                                <a 
                                    :href="current.url" 
                                    target="_blank"
                                    class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20
                                           text-white text-sm font-medium transition-colors
                                           flex items-center gap-2"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    <span class="hidden sm:inline">Buka Original</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection