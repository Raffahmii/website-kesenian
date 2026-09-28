@extends('layouts.dashboard')

@section('title', 'Buat Jadwal')
@section('subtitle', 'Buat jadwal kegiatan baru')

@section('content')

    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('dashboard.events.index') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Jadwal
        </a>
    </div>

    <form method="POST" action="{{ route('dashboard.events.store') }}" data-aos="fade-up">
        @csrf

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- FORM UTAMA --}}
            <div class="lg:col-span-2 space-y-6">

                <div class="panel-light">
                    <div class="section-head-light">
                        <div class="icon-badge-light">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="section-head-title-light">Informasi Kegiatan</h3>
                            <p class="section-head-sub-light">Detail jadwal & lokasi</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Judul Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="judul" value="{{ old('judul') }}" required
                                   placeholder="Contoh: Latihan Rutin Padus"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          placeholder-light-muted/70 focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                            @error('judul') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">Deskripsi</label>
                            <textarea name="deskripsi" rows="3"
                                      placeholder="Detail kegiatan (opsional)"
                                      class="w-full px-4 py-2.5 rounded-xl text-sm
                                             bg-light-bg border border-light-border text-light-text
                                             placeholder-light-muted/70 focus:outline-none focus:bg-white
                                             focus:border-gold/50 focus:ring-2 focus:ring-gold/20 resize-none">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">Lokasi</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                                   placeholder="Contoh: Aula SMKN 1 Banjar"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          placeholder-light-muted/70 focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        </div>
                    </div>
                </div>

            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-6">

                <div class="panel-light">
                    <div class="section-head-light">
                        <div class="icon-badge-light">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div><h3 class="section-head-title-light">Waktu</h3></div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Jenis Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis" required
                                    class="w-full px-4 py-2.5 rounded-xl text-sm
                                           bg-light-bg border border-light-border text-light-text
                                           focus:outline-none focus:bg-white
                                           focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                @foreach(\App\Enums\JenisKegiatan::cases() as $j)
                                    <option value="{{ $j->value }}" @selected(old('jenis') === $j->value)>
                                        {{ $j->icon() }} {{ $j->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Tanggal <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-light-text mb-2">Mulai</label>
                                <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm
                                              bg-light-bg border border-light-border text-light-text
                                              focus:outline-none focus:bg-white
                                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-light-text mb-2">Selesai</label>
                                <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm
                                              bg-light-bg border border-light-border text-light-text
                                              focus:outline-none focus:bg-white
                                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-light">
                    <button type="submit" class="btn-gold w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Jadwal
                    </button>
                    <a href="{{ route('dashboard.events.index') }}" 
                       class="mt-3 block text-center text-xs text-light-muted 
                              hover:text-gold-dark transition-colors">
                        Batal
                    </a>
                </div>

            </div>
        </div>
    </form>

@endsection