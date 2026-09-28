@extends('layouts.dashboard')

@section('title', 'Edit Anggota')
@section('subtitle', 'Update data ' . $member->nama_lengkap)

@section('content')

    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('dashboard.members.show', $member->id_user) }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Detail
        </a>
    </div>

    <form method="POST" action="{{ route('dashboard.members.update', $member->id_user) }}" 
          class="grid lg:grid-cols-3 gap-6"
          data-aos="fade-up">
        @csrf
        @method('PUT')

        {{-- FORM UTAMA --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Akun --}}
            <div class="panel-light">
                <div class="section-head-light">
                    <div class="icon-badge-light">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="section-head-title-light">Informasi Akun</h3>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-light-text mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text"
                            name="nama_lengkap"
                            value="{{ old('nama_lengkap', $member->nama_lengkap) }}"
                            required
                            class="w-full px-4 py-2.5 rounded-xl text-sm
                                   bg-light-bg border border-light-border
                                   text-light-text
                                   focus:outline-none focus:bg-white
                                   focus:border-gold/50 focus:ring-2 focus:ring-gold/20"
                        >
                        @error('nama_lengkap')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email"
                            name="email"
                            value="{{ old('email', $member->email) }}"
                            required
                            class="w-full px-4 py-2.5 rounded-xl text-sm
                                   bg-light-bg border border-light-border
                                   text-light-text
                                   focus:outline-none focus:bg-white
                                   focus:border-gold/50 focus:ring-2 focus:ring-gold/20"
                        >
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">
                            Password Baru
                            <span class="text-light-muted text-[10px] font-normal">(kosongkan jika tidak diganti)</span>
                        </label>
                        <input 
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full px-4 py-2.5 rounded-xl text-sm
                                   bg-light-bg border border-light-border
                                   text-light-text placeholder-light-muted/70
                                   focus:outline-none focus:bg-white
                                   focus:border-gold/50 focus:ring-2 focus:ring-gold/20"
                        >
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Data Anggota --}}
            <div class="panel-light">
                <div class="section-head-light">
                    <div class="icon-badge-light">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c0 1.306.835 2.417 2 2.83M15 10a2 2 0 11-4 0 2 2 0 014 0zm0 0c0 1.306-.835 2.417-2 2.83"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="section-head-title-light">Data Anggota</h3>
                    </div>
                </div>

                    <div class="sm:col-span-2 mb-4">
                        <label class="block text-xs font-medium text-light-text mb-2">Cabang / Divisi</label>
                        <select name="cabang"
                                class="w-full px-4 py-2.5 rounded-xl text-sm
                                       bg-light-bg border border-light-border
                                       text-light-text
                                       focus:outline-none focus:bg-white
                                       focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                            <option value="">— Pilih Cabang —</option>
                            @foreach(\App\Enums\Cabang::cases() as $cab)
                                <option value="{{ $cab->value }}" @selected(old('cabang', $member->cabang?->value) === $cab->value)>
                                    {{ $cab->icon() }} {{ $cab->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('cabang')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">NIS</label>
                        <input 
                            type="text"
                            name="nis"
                            value="{{ old('nis', $member->nis) }}"
                            class="w-full px-4 py-2.5 rounded-xl text-sm
                                   bg-light-bg border border-light-border
                                   text-light-text
                                   focus:outline-none focus:bg-white
                                   focus:border-gold/50 focus:ring-2 focus:ring-gold/20"
                        >
                        @error('nis')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">No. HP</label>
                        <input 
                            type="text"
                            name="phone"
                            value="{{ old('phone', $member->phone) }}"
                            class="w-full px-4 py-2.5 rounded-xl text-sm
                                   bg-light-bg border border-light-border
                                   text-light-text
                                   focus:outline-none focus:bg-white
                                   focus:border-gold/50 focus:ring-2 focus:ring-gold/20"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">Kelas</label>
                        <input 
                            type="text"
                            name="kelas"
                            value="{{ old('kelas', $member->kelas) }}"
                            class="w-full px-4 py-2.5 rounded-xl text-sm
                                   bg-light-bg border border-light-border
                                   text-light-text
                                   focus:outline-none focus:bg-white
                                   focus:border-gold/50 focus:ring-2 focus:ring-gold/20"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">Jurusan</label>
                        <input 
                            type="text"
                            name="jurusan"
                            value="{{ old('jurusan', $member->jurusan) }}"
                            class="w-full px-4 py-2.5 rounded-xl text-sm
                                   bg-light-bg border border-light-border
                                   text-light-text
                                   focus:outline-none focus:bg-white
                                   focus:border-gold/50 focus:ring-2 focus:ring-gold/20"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">Angkatan</label>
                        <input 
                            type="text"
                            name="angkatan"
                            value="{{ old('angkatan', $member->angkatan) }}"
                            class="w-full px-4 py-2.5 rounded-xl text-sm
                                   bg-light-bg border border-light-border
                                   text-light-text
                                   focus:outline-none focus:bg-white
                                   focus:border-gold/50 focus:ring-2 focus:ring-gold/20"
                        >
                    </div>
                </div>
            </div>

        </div>

        {{-- SIDEBAR --}}
        <div class="space-y-6">

            {{-- Role --}}
            <div class="panel-light">
                <div class="section-head-light">
                    <div class="icon-badge-light">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="section-head-title-light">Role & Status</h3>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select name="role" required
                                class="w-full px-4 py-2.5 rounded-xl text-sm
                                       bg-light-bg border border-light-border
                                       text-light-text
                                       focus:outline-none focus:bg-white
                                       focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                            @foreach(\App\Enums\RoleUser::cases() as $role)
                                <option value="{{ $role->value }}" @selected(old('role', $member->role->value) === $role->value)>
                                    {{ $role->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status_anggota" required
                                class="w-full px-4 py-2.5 rounded-xl text-sm
                                       bg-light-bg border border-light-border
                                       text-light-text
                                       focus:outline-none focus:bg-white
                                       focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                            @foreach(\App\Enums\StatusAnggota::cases() as $status)
                                <option value="{{ $status->value }}" @selected(old('status_anggota', $member->status_anggota->value) === $status->value)>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="panel-light">
                <button type="submit" class="btn-gold w-full justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>

            </div>
        </div>
    </form>

@endsection