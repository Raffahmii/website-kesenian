@extends('layouts.dashboard')

@section('title', 'Edit Pengurus')
@section('subtitle', 'Edit data pengurus')

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

    <form method="POST" action="{{ route('dashboard.management.update', $management->id_kepengurusan) }}" data-aos="fade-up">
        @csrf
        @method('PUT')

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
                                @foreach($members as $m)
                                    <option value="{{ $m->id_user }}" 
                                            @selected(old('id_user', $management->id_user) == $m->id_user)>
                                        {{ $m->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
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
                                @foreach($jabatans as $j)
                                    <option value="{{ $j->id_jabatan }}" 
                                            @selected(old('id_jabatan', $management->id_jabatan) == $j->id_jabatan)>
                                        {{ $j->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
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
                                @foreach($periodes as $p)
                                    <option value="{{ $p->id_periode }}" 
                                            @selected(old('id_periode', $management->id_periode) == $p->id_periode)>
                                        {{ $p->nama_periode }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="panel-light">
                    <h3 class="font-display font-bold text-base mb-4">Detail</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">SK Number</label>
                            <input type="text" name="sk_number" 
                                   value="{{ old('sk_number', $management->sk_number) }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" 
                                   value="{{ old('tanggal_mulai', $management->tanggal_mulai?->format('Y-m-d')) }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" 
                                   value="{{ old('tanggal_selesai', $management->tanggal_selesai?->format('Y-m-d')) }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        </div>

                        <label class="flex items-center gap-3 p-3 rounded-xl bg-light-bg cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" 
                                   {{ old('is_active', $management->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-light-border bg-white text-gold focus:ring-gold/30">
                            <span class="text-sm text-light-text">Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="panel-light">
                    <button type="submit" class="btn-gold w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>

@endsection