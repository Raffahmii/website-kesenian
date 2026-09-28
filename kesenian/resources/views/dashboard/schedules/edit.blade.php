@extends('layouts.dashboard')

@section('title', 'Edit Jadwal')
@section('subtitle', 'Edit jadwal: ' . $schedule->judul)

@section('content')

    {{-- BREADCRUMB --}}
    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('dashboard.events.show', $schedule->id_jadwal) }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Detail Jadwal
        </a>
    </div>

    <form method="POST" action="{{ route('dashboard.events.update', $schedule->id_jadwal) }}" data-aos="fade-up">
        @csrf
        @method('PUT')

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
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="section-head-title-light">Informasi Kegiatan</h3>
                            <p class="section-head-sub-light">Detail jadwal & lokasi</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        {{-- Judul --}}
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Judul Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="judul" 
                                   value="{{ old('judul', $schedule->judul) }}" 
                                   required
                                   placeholder="Contoh: Latihan Rutin Padus"
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
                                      placeholder="Detail kegiatan (opsional)"
                                      class="w-full px-4 py-2.5 rounded-xl text-sm
                                             bg-light-bg border border-light-border text-light-text
                                             placeholder-light-muted/70 focus:outline-none focus:bg-white
                                             focus:border-gold/50 focus:ring-2 focus:ring-gold/20 resize-none">{{ old('deskripsi', $schedule->deskripsi) }}</textarea>
                            @error('deskripsi') 
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Lokasi --}}
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">Lokasi</label>
                            <input type="text" name="lokasi" 
                                   value="{{ old('lokasi', $schedule->lokasi) }}"
                                   placeholder="Contoh: Aula SMKN 1 Banjar"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          placeholder-light-muted/70 focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                            @error('lokasi') 
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- INFO: Jangan ubah jenis kalau udah ada absensi --}}
                @if($schedule->absensi()->count() > 0)
                    <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-700 mb-1">
                                Jadwal ini sudah punya {{ $schedule->absensi()->count() }} absensi
                            </p>
                            <p class="text-xs text-blue-600">
                                Hati-hati saat mengubah tanggal atau jenis — bisa mempengaruhi rekap absensi.
                            </p>
                        </div>
                    </div>
                @endif

            </div>

            {{-- ═══════════════════════════════════════
                 SIDEBAR
                 ═══════════════════════════════════════ --}}
            <div class="space-y-6">

                {{-- Waktu & Jenis --}}
                <div class="panel-light">
                    <div class="section-head-light">
                        <div class="icon-badge-light">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="section-head-title-light">Waktu</h3>
                        </div>
                    </div>

                    <div class="space-y-4">
                        {{-- Jenis --}}
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
                                    <option value="{{ $j->value }}" 
                                            @selected(old('jenis', $schedule->jenis->value) === $j->value)>
                                        {{ $j->icon() }} {{ $j->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis') 
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Tanggal --}}
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Tanggal <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal" 
                                   value="{{ old('tanggal', $schedule->tanggal ? \Carbon\Carbon::parse($schedule->tanggal)->format('Y-m-d') : now()->format('Y-m-d')) }}" 
                                   required
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                            @error('tanggal') 
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Jam --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-light-text mb-2">Mulai</label>
                                <input type="time" name="jam_mulai" 
                                       value="{{ old('jam_mulai', $schedule->jam_mulai ? \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') : '') }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm
                                              bg-light-bg border border-light-border text-light-text
                                              focus:outline-none focus:bg-white
                                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                @error('jam_mulai') 
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> 
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-light-text mb-2">Selesai</label>
                                <input type="time" name="jam_selesai" 
                                       value="{{ old('jam_selesai', $schedule->jam_selesai ? \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') : '') }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm
                                              bg-light-bg border border-light-border text-light-text
                                              focus:outline-none focus:bg-white
                                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                @error('jam_selesai') 
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> 
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- INFO PEMBUAT --}}
                <div class="panel-light">
                    <div class="flex items-center gap-3 mb-3">
                        @if($schedule->pembuat?->photo)
                            <img src="{{ asset('storage/' . $schedule->pembuat->photo) }}" 
                                 class="w-10 h-10 rounded-xl object-cover">
                        @else
                            <div class="w-10 h-10 rounded-xl gradient-gold flex items-center justify-center
                                        font-display font-bold text-bg-primary shrink-0">
                                {{ strtoupper(substr($schedule->pembuat->nama_lengkap ?? '?', 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <p class="text-[10px] uppercase tracking-wider text-light-muted">Dibuat oleh</p>
                            <p class="text-sm font-medium text-light-text truncate">
                                {{ $schedule->pembuat->nama_lengkap ?? 'Unknown' }}
                            </p>
                        </div>
                    </div>
                    <div class="divider-light mb-3"></div>
                    <div class="flex justify-between text-xs">
                        <span class="text-light-muted">Dibuat</span>
                        <span class="text-light-text">
                            {{ $schedule->created_at?->format('d M Y, H:i') ?? '-' }}
                        </span>
                    </div>
                    <div class="flex justify-between text-xs mt-2">
                        <span class="text-light-muted">Terakhir update</span>
                        <span class="text-light-text">
                            {{ $schedule->updated_at?->format('d M Y, H:i') ?? '-' }}
                        </span>
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="panel-light">
                    <button type="submit" class="btn-gold w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('dashboard.events.show', $schedule->id_jadwal) }}" 
                       class="mt-3 block text-center text-xs text-light-muted 
                              hover:text-gold-dark transition-colors">
                        Batal
                    </a>
                </div>

                {{-- ZONA HAPUS --}}
                @can('manage-events')
                    <div class="panel-light border border-red-200">
                        <h4 class="font-display font-semibold text-sm text-red-600 mb-2">
                            Zona Berbahaya
                        </h4>
                        <p class="text-xs text-light-muted mb-3">
                            Hapus jadwal ini akan menghapus semua absensi terkait secara permanen.
                        </p>
                        <button 
                            type="button"
                            onclick="if(confirm('Yakin hapus jadwal ini? Semua absensi terkait akan ikut terhapus!')) document.getElementById('delete-form').submit()"
                            class="w-full px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600
                                   text-white font-medium text-sm transition-colors
                                   flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Jadwal
                        </button>
                    </div>
                @endcan

            </div>
        </div>
    </form>

    {{-- FORM HAPUS (hidden, di luar form utama) --}}
    @can('manage-events')
        <form id="delete-form" 
              action="{{ route('dashboard.events.destroy', $schedule->id_jadwal) }}" 
              method="POST" 
              class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endcan

@endsection