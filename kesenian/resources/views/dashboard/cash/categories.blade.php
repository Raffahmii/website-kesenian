@extends('layouts.dashboard')

@section('title', 'Kategori Kas')
@section('subtitle', 'Kelola kategori pembayaran kas')

@section('content')

    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('dashboard.cash') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Kas
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- FORM TAMBAH --}}
        <div class="panel-light" data-aos="fade-up">
            <div class="section-head-light">
                <div class="icon-badge-light-solid">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div>
                    <h3 class="section-head-title-light">Tambah Kategori</h3>
                </div>
            </div>

            <form method="POST" action="{{ route('dashboard.cash.categories.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-light-text mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                           placeholder="Contoh: Kas Bulanan"
                           class="w-full px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                  text-light-text placeholder-light-muted/70 focus:outline-none focus:bg-white
                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    @error('nama') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-light-text mb-2">
                        Nominal <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="nominal" value="{{ old('nominal', 10000) }}" required
                           min="0" step="1000"
                           class="w-full px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                  text-light-text focus:outline-none focus:bg-white
                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    @error('nominal') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-light-text mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="2"
                              placeholder="Opsional"
                              class="w-full px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                     text-light-text placeholder-light-muted/70 focus:outline-none focus:bg-white
                                     focus:border-gold/50 focus:ring-2 focus:ring-gold/20 resize-none">{{ old('deskripsi') }}</textarea>
                </div>

                <button type="submit" class="btn-gold w-full justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tambah Kategori
                </button>
            </form>
        </div>

        {{-- LIST --}}
        <div class="lg:col-span-2 panel-light" data-aos="fade-up" data-aos-delay="100">
            <div class="section-head-light">
                <div class="icon-badge-light">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="section-head-title-light">Daftar Kategori</h3>
                    <p class="section-head-sub-light">{{ $categories->count() }} kategori</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse($categories as $cat)
                    <div class="p-4 rounded-2xl bg-light-bg border border-light-border 
                                hover:border-gold/30 transition-colors group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl {{ $cat->is_active ? 'bg-gold/10' : 'bg-light-border/30' }}
                                        flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 {{ $cat->is_active ? 'text-gold-dark' : 'text-light-muted' }}" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <p class="font-semibold text-sm text-light-text truncate">
                                        {{ $cat->nama }}
                                    </p>
                                    @if(!$cat->is_active)
                                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-light-border text-light-muted font-medium">
                                            NONAKTIF
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-light-muted">
                                    Rp {{ number_format($cat->nominal, 0, ',', '.') }} · 
                                    {{ $cat->pembayaran_count }} transaksi
                                </p>
                            </div>
                            <div class="text-right text-xs text-light-muted">
                                {{ $cat->deskripsi ?: '-' }}
                            </div>
                            <form action="{{ route('dashboard.cash.categories.destroy', $cat->id_kategori) }}" 
                                  method="POST" class="shrink-0">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Hapus kategori {{ $cat->nama }}?')"
                                        class="p-2 rounded-lg hover:bg-red-50 text-light-muted 
                                               hover:text-red-500 transition-colors
                                               disabled:opacity-30 disabled:cursor-not-allowed"
                                        {{ $cat->pembayaran_count > 0 ? 'disabled' : '' }}
                                        title="{{ $cat->pembayaran_count > 0 ? 'Masih dipakai' : 'Hapus' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="text-5xl mb-3 opacity-50">💰</div>
                        <p class="text-light-text font-medium">Belum ada kategori</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection