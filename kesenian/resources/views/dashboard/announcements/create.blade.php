@extends('layouts.dashboard')

@section('title', 'Buat Pengumuman')
@section('subtitle', 'Buat pengumuman baru untuk organisasi')

@section('content')

    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('dashboard.announcements.index') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <form method="POST" action="{{ route('dashboard.announcements.store') }}" 
          enctype="multipart/form-data" data-aos="fade-up">
        @csrf

        <div class="grid lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="panel-light">
                    <div class="section-head-light">
                        <div class="icon-badge-light">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="section-head-title-light">Isi Pengumuman</h3>
                            <p class="section-head-sub-light">Detail informasi yang diumumkan</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Judul <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="judul" value="{{ old('judul') }}" required
                                   placeholder="Contoh: Jadwal Latihan Rutin Bulan Desember"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          placeholder-light-muted/70 focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                            @error('judul') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Isi Pengumuman <span class="text-red-500">*</span>
                            </label>
                            <textarea name="isi" rows="10" required
                                      placeholder="Tulis isi pengumuman..."
                                      class="w-full px-4 py-2.5 rounded-xl text-sm
                                             bg-light-bg border border-light-border text-light-text
                                             placeholder-light-muted/70 focus:outline-none focus:bg-white
                                             focus:border-gold/50 focus:ring-2 focus:ring-gold/20 resize-none">{{ old('isi') }}</textarea>
                            @error('isi') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

            </div>

            <div class="space-y-6">

                <div class="panel-light">
                    <div class="section-head-light">
                        <div class="icon-badge-light">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div><h3 class="section-head-title-light">Target & Status</h3></div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Target <span class="text-red-500">*</span>
                            </label>
                            <select name="target_role" required
                                    class="w-full px-4 py-2.5 rounded-xl text-sm
                                           bg-light-bg border border-light-border text-light-text
                                           focus:outline-none focus:bg-white
                                           focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                @foreach(\App\Enums\TargetPengumuman::cases() as $t)
                                    <option value="{{ $t->value }}" @selected(old('target_role') === $t->value)>
                                        {{ $t->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <label class="flex items-center gap-3 cursor-pointer p-3 rounded-xl bg-light-bg
                                      hover:bg-gold/[0.05] transition-colors">
                            <input type="checkbox" name="is_published" value="1"
                                   {{ old('is_published', true) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded border-light-border bg-white text-gold focus:ring-gold/30">
                            <div>
                                <p class="text-sm font-medium text-light-text">Publish Sekarang</p>
                                <p class="text-xs text-light-muted">Jika tidak dicentang, jadi draft</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="panel-light">
                    <div class="section-head-light">
                        <div class="icon-badge-light">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="section-head-title-light">Lampiran</h3>
                            <p class="section-head-sub-light">PDF, DOC, IMG (max 10MB)</p>
                        </div>
                    </div>

                    <div x-data="{ filename: null }">
                        <label class="block cursor-pointer">
                            <input type="file" name="lampiran" class="hidden"
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                                   @change="filename = $event.target.files[0]?.name">
                            <div class="rounded-2xl border-2 border-dashed border-light-border
                                        hover:border-gold/50 transition-colors p-6 bg-light-bg
                                        text-center">
                                <svg class="w-10 h-10 text-light-muted mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <p class="text-sm font-medium text-light-text mb-1" 
                                   x-text="filename || 'Pilih file'"></p>
                                <p class="text-xs text-light-muted">Klik untuk pilih</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="panel-light">
                    <button type="submit" class="btn-gold w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Pengumuman
                    </button>
                    <a href="{{ route('dashboard.announcements.index') }}" 
                       class="mt-3 block text-center text-xs text-light-muted 
                              hover:text-gold-dark transition-colors">
                        Batal
                    </a>
                </div>

            </div>
        </div>
    </form>

@endsection