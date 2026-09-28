@extends('layouts.dashboard')

@section('title', 'Buat Album')
@section('subtitle', 'Buat album dokumentasi baru')

@section('content')

    {{-- BREADCRUMB --}}
    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('dashboard.albums.index') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Album
        </a>
    </div>

    <form method="POST" action="{{ route('dashboard.albums.store') }}" 
          enctype="multipart/form-data" data-aos="fade-up">
        @csrf

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- ═══════════════════════════════════════
                 FORM UTAMA
                 ═══════════════════════════════════════ --}}
            <div class="lg:col-span-2 space-y-6">

                <div class="panel-light">
                    <div class="section-head-light">
                        <div class="icon-badge-light">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="section-head-title-light">Informasi Album</h3>
                            <p class="section-head-sub-light">Detail album dokumentasi</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        {{-- Judul --}}
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Judul Album <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="judul" value="{{ old('judul') }}" required
                                   placeholder="Contoh: Pentas Seni Akhir Tahun 2025"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          placeholder-light-muted/70 focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                            @error('judul') 
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">Deskripsi</label>
                            <textarea name="deskripsi" rows="3"
                                      placeholder="Ceritakan tentang album ini (opsional)"
                                      class="w-full px-4 py-2.5 rounded-xl text-sm
                                             bg-light-bg border border-light-border text-light-text
                                             placeholder-light-muted/70 focus:outline-none focus:bg-white
                                             focus:border-gold/50 focus:ring-2 focus:ring-gold/20 resize-none">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi') 
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Kategori & Tanggal --}}
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-light-text mb-2">Kategori</label>
                                <input type="text" name="kategori" value="{{ old('kategori') }}"
                                       placeholder="Contoh: Pentas, Latihan, Lomba"
                                       list="kategori-list"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm
                                              bg-light-bg border border-light-border text-light-text
                                              placeholder-light-muted/70 focus:outline-none focus:bg-white
                                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                <datalist id="kategori-list">
                                    <option value="Pentas">
                                    <option value="Latihan">
                                    <option value="Lomba">
                                    <option value="Rapat">
                                    <option value="Workshop">
                                </datalist>
                                @error('kategori') 
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> 
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-light-text mb-2">Tanggal Kegiatan</label>
                                <input type="date" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan') }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm
                                              bg-light-bg border border-light-border text-light-text
                                              focus:outline-none focus:bg-white
                                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                @error('tanggal_kegiatan') 
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> 
                                @enderror
                            </div>
                        </div>

                        {{-- Kaitkan ke Jadwal --}}
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Kaitkan ke Jadwal (opsional)
                            </label>
                            <select name="id_jadwal" 
                                    class="w-full px-4 py-2.5 rounded-xl text-sm
                                           bg-light-bg border border-light-border
                                           text-light-text focus:outline-none focus:bg-white
                                           focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                <option value="">— Tidak dikaitkan —</option>
                                @foreach($jadwals as $jad)
                                    <option value="{{ $jad->id_jadwal }}" @selected(old('id_jadwal') == $jad->id_jadwal)>
                                        {{ $jad->judul }} ({{ \Carbon\Carbon::parse($jad->tanggal)->format('d M Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_jadwal') 
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            {{-- ═══════════════════════════════════════
                 SIDEBAR
                 ═══════════════════════════════════════ --}}
            <div class="space-y-6">

                {{-- COVER --}}
                <div class="panel-light">
                    <div class="section-head-light">
                        <div class="icon-badge-light">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="section-head-title-light">Cover Album</h3>
                            <p class="section-head-sub-light">Maks 5MB, JPG/PNG</p>
                        </div>
                    </div>

                    <div x-data="{ preview: null }">
                        <label class="block cursor-pointer">
                            <input type="file" name="cover_image" accept="image/*"
                                   class="hidden"
                                   @change="
                                       const file = $event.target.files[0];
                                       if (file) preview = URL.createObjectURL(file);
                                   ">
                            <div class="relative aspect-[4/3] rounded-2xl overflow-hidden
                                        border-2 border-dashed border-light-border
                                        hover:border-gold/50 transition-colors
                                        bg-light-bg flex items-center justify-center">
                                <template x-if="!preview">
                                    <div class="text-center p-6">
                                        <svg class="w-12 h-12 text-light-muted mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        <p class="text-sm text-light-text font-medium">Klik untuk pilih</p>
                                        <p class="text-xs text-light-muted mt-1">JPG, PNG, WEBP</p>
                                    </div>
                                </template>
                                <template x-if="preview">
                                    <img :src="preview" class="absolute inset-0 w-full h-full object-cover">
                                </template>
                            </div>
                        </label>
                        @error('cover_image') 
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="panel-light">
                    <button type="submit" class="btn-gold w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Buat Album
                    </button>

                    <p class="mt-3 text-xs text-light-muted text-center">
                        Setelah dibuat, kamu bisa upload foto & video
                    </p>

                    <a href="{{ route('dashboard.albums.index') }}" 
                       class="mt-3 block text-center text-xs text-light-muted 
                              hover:text-gold-dark transition-colors">
                        Batal
                    </a>
                </div>

            </div>
        </div>
    </form>

@endsection