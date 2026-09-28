@extends('layouts.dashboard')

@section('title', 'Tambah Pengurus')
@section('subtitle', 'Tambah pengurus ke periode')

@section('content')

    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('dashboard.management') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('dashboard.management.store') }}" data-aos="fade-up">
        @csrf

        <div class="grid lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="panel-light">
                    <div class="section-head-light">
                        <div class="icon-badge-light-solid">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="section-head-title-light">Info Kepengurusan</h3>
                            <p class="section-head-sub-light">Pilih user, jabatan, dan periode</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Anggota <span class="text-red-500">*</span>
                            </label>
                            <select name="id_user" required
                                    class="w-full px-4 py-2.5 rounded-xl text-sm
                                           bg-light-bg border border-light-border text-light-text
                                           focus:outline-none focus:bg-white
                                           focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                <option value="">— Pilih Anggota —</option>
                                @foreach($members as $m)
                                    <option value="{{ $m->id_user }}" @selected(old('id_user') == $m->id_user)>
                                        {{ $m->nama_lengkap }} 
                                        @if($m->kelas) · {{ $m->kelas }} {{ $m->jurusan }} @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('id_user') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Jabatan <span class="text-red-500">*</span>
                            </label>
                            <select name="id_jabatan" required
                                    class="w-full px-4 py-2.5 rounded-xl text-sm
                                           bg-light-bg border border-light-border text-light-text
                                           focus:outline-none focus:bg-white
                                           focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                <option value="">— Pilih Jabatan —</option>
                                @foreach($jabatans as $j)
                                    <option value="{{ $j->id_jabatan }}" @selected(old('id_jabatan') == $j->id_jabatan)>
                                        {{ $j->nama_jabatan }}
                                        @if($j->divisi) ({{ $j->divisi }}) @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('id_jabatan') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Periode <span class="text-red-500">*</span>
                            </label>
                            <select name="id_periode" required
                                    class="w-full px-4 py-2.5 rounded-xl text-sm
                                           bg-light-bg border border-light-border text-light-text
                                           focus:outline-none focus:bg-white
                                           focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                <option value="">— Pilih Periode —</option>
                                @foreach($periodes as $p)
                                    <option value="{{ $p->id_periode }}" @selected(old('id_periode', $p->is_active) == $p->id_periode)>
                                        {{ $p->nama_periode }} @if($p->is_active) (Aktif) @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('id_periode') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

            </div>

            <div class="space-y-6">
                <div class="panel-light">
                    <div class="section-head-light">
                        <div class="icon-badge-light-solid">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div><h3 class="section-head-title-light">Detail</h3></div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">SK Number</label>
                            <input type="text" name="sk_number" value="{{ old('sk_number') }}"
                                   placeholder="Contoh: SK/001/GA/2026"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          placeholder-light-muted/70 focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        </div>

                        <label class="flex items-center gap-3 p-3 rounded-xl bg-light-bg 
                                      hover:bg-gold/[0.05] cursor-pointer transition-colors">
                            <input type="checkbox" name="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-light-border bg-white text-gold focus:ring-gold/30">
                            <span class="text-sm text-light-text">Aktifkan sekarang</span>
                        </label>
                    </div>
                </div>

                <div class="panel-light">
                    <button type="submit" class="btn-gold w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan
                    </button>
                    <a href="{{ route('dashboard.management') }}" 
                       class="mt-3 block text-center text-xs text-light-muted hover:text-gold-dark transition-colors">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>

@endsection