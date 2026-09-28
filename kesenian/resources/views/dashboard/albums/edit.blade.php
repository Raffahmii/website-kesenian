@extends('layouts.dashboard')

@section('title', 'Edit Album')
@section('subtitle', 'Edit album: ' . $album->judul)

@section('content')

    {{-- BREADCRUMB --}}
    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('dashboard.albums.show', $album->id_album) }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Detail Album
        </a>
    </div>

    <form method="POST" action="{{ route('dashboard.albums.update', $album->id_album) }}" 
          enctype="multipart/form-data" data-aos="fade-up">
        @csrf
        @method('PUT')

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- FORM UTAMA --}}
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
                            <p class="section-head-sub-light">Update detail album dokumentasi</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Judul Album <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="judul" 
                                   value="{{ old('judul', $album->judul) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          placeholder-light-muted/70 focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                            @error('judul') 
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">Deskripsi</label>
                            <textarea name="deskripsi" rows="3"
                                      placeholder="Ceritakan tentang album ini (opsional)"
                                      class="w-full px-4 py-2.5 rounded-xl text-sm
                                             bg-light-bg border border-light-border text-light-text
                                             placeholder-light-muted/70 focus:outline-none focus:bg-white
                                             focus:border-gold/50 focus:ring-2 focus:ring-gold/20 resize-none">{{ old('deskripsi', $album->deskripsi) }}</textarea>
                            @error('deskripsi') 
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> 
                            @enderror
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-light-text mb-2">Kategori</label>
                                <input type="text" name="kategori" 
                                       value="{{ old('kategori', $album->kategori) }}"
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
                                <input type="date" name="tanggal_kegiatan" 
                                       value="{{ old('tanggal_kegiatan', $album->tanggal_kegiatan?->format('Y-m-d')) }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm
                                              bg-light-bg border border-light-border text-light-text
                                              focus:outline-none focus:bg-white
                                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                @error('tanggal_kegiatan') 
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> 
                                @enderror
                            </div>
                        </div>

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
                                    <option value="{{ $jad->id_jadwal }}" 
                                            @selected(old('id_jadwal', $album->id_jadwal) == $jad->id_jadwal)>
                                        {{ $jad->judul }} ({{ \Carbon\Carbon::parse($jad->tanggal)->format('d M Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @if($album->media()->count() > 0)
                    <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-700 mb-1">
                                Album ini punya {{ $album->media()->count() }} media
                            </p>
                            <p class="text-xs text-blue-600">
                                Untuk kelola foto/video, buka halaman detail album.
                            </p>
                        </div>
                    </div>
                @endif

            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-6">

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
                            <p class="section-head-sub-light">Ganti cover (opsional)</p>
                        </div>
                    </div>

                    <div x-data="{ preview: '{{ $album->cover_image ? asset('storage/' . $album->cover_image) : '' }}' }">
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
                                    </div>
                                </template>
                                <template x-if="preview">
                                    <img :src="preview" class="absolute inset-0 w-full h-full object-cover">
                                </template>
                            </div>
                        </label>

                        @if($album->cover_image)
                            <p class="mt-2 text-[11px] text-light-muted text-center">
                                Kosongkan jika tidak ingin ganti cover
                            </p>
                        @endif

                        @error('cover_image') 
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>

                <div class="panel-light">
                    <div class="flex items-center gap-3 mb-3">
                        @if($album->uploader?->photo)
                            <img src="{{ asset('storage/' . $album->uploader->photo) }}" 
                                 class="w-10 h-10 rounded-xl object-cover">
                        @else
                            <div class="w-10 h-10 rounded-xl gradient-gold flex items-center justify-center
                                        font-display font-bold text-bg-primary shrink-0">
                                {{ strtoupper(substr($album->uploader->nama_lengkap ?? '?', 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <p class="text-[10px] uppercase tracking-wider text-light-muted">Dibuat oleh</p>
                            <p class="text-sm font-medium text-light-text truncate">
                                {{ $album->uploader->nama_lengkap ?? 'Unknown' }}
                            </p>
                        </div>
                    </div>
                    <div class="divider-light mb-3"></div>
                    <div class="flex justify-between text-xs">
                        <span class="text-light-muted">Dibuat</span>
                        <span class="text-light-text">
                            {{ $album->created_at?->format('d M Y, H:i') ?? '-' }}
                        </span>
                    </div>
                    <div class="flex justify-between text-xs mt-2">
                        <span class="text-light-muted">Terakhir update</span>
                        <span class="text-light-text">
                            {{ $album->updated_at?->format('d M Y, H:i') ?? '-' }}
                        </span>
                    </div>
                </div>

                <div class="panel-light">
                    <button type="submit" class="btn-gold w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('dashboard.albums.show', $album->id_album) }}" 
                       class="mt-3 block text-center text-xs text-light-muted 
                              hover:text-gold-dark transition-colors">
                        Batal
                    </a>
                </div>

                @can('manage-docs')
                    <div class="panel-light border border-red-200">
                        <h4 class="font-display font-semibold text-sm text-red-600 mb-2">
                            Zona Berbahaya
                        </h4>
                        <p class="text-xs text-light-muted mb-3">
                            Hapus album akan menghapus <strong>{{ $album->media()->count() }} media</strong> di dalamnya.
                        </p>
                        <button 
                            type="button"
                            onclick="if(confirm('Yakin hapus album ini? Semua media akan ikut terhapus!')) document.getElementById('delete-album-form').submit()"
                            class="w-full px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600
                                   text-white font-medium text-sm transition-colors
                                   flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Album
                        </button>
                    </div>
                @endcan

            </div>
        </div>
    </form>

    @can('manage-docs')
        <form id="delete-album-form" 
              action="{{ route('dashboard.albums.destroy', $album->id_album) }}" 
              method="POST" 
              class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endcan

@endsection