@extends('layouts.dashboard')

@section('title', 'Edit Profile')
@section('subtitle', 'Kelola info akun & foto profile')

@section('content')

    {{-- BREADCRUMB --}}
    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('profile.show') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Profile
        </a>
    </div>

    {{-- HERO COVER + AVATAR --}}
    <div class="panel-light overflow-hidden mb-6" data-aos="fade-up">
        <div class="relative h-40 rounded-t-2xl overflow-hidden"
             style="background: linear-gradient(135deg, #F5B301 0%, #FEB053 50%, #C28A00 100%);">
            @if(auth()->user()->cover_photo)
                <img src="{{ asset('storage/' . auth()->user()->cover_photo) }}" 
                     class="absolute inset-0 w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-black/20"></div>
        </div>

        <div class="relative px-6 pb-6">
            <div class="-mt-12 flex items-end gap-4 flex-wrap">
                <div class="relative">
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" 
                             class="w-24 h-24 rounded-3xl object-cover border-4 border-white shadow-xl">
                    @else
                        <div class="w-24 h-24 rounded-3xl gradient-gold flex items-center justify-center
                                    font-display font-bold text-bg-primary text-3xl
                                    border-4 border-white shadow-xl">
                            {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0 pb-1">
                    <h2 class="font-display font-bold text-xl text-light-text">
                        {{ auth()->user()->nama_lengkap }}
                    </h2>
                    <p class="text-sm text-light-muted">
                        {{ auth()->user()->email }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- FORM EDIT --}}
    <form method="POST" action="{{ route('profile.update') }}" 
          enctype="multipart/form-data" 
          class="grid lg:grid-cols-3 gap-6" 
          data-aos="fade-up">
        @csrf
        @method('PATCH')

        <div class="lg:col-span-2 space-y-6">

            {{-- FOTO --}}
            <div class="panel-light">
                <div class="section-head-light">
                    <div class="icon-badge-light">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="section-head-title-light">Foto Profile</h3>
                        <p class="section-head-sub-light">JPG/PNG, max 2MB</p>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    {{-- Avatar --}}
                    <div x-data="{ preview: '{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : '' }}' }">
                        <label class="block text-xs font-medium text-light-text mb-2">Foto Profil</label>
                        <label class="block cursor-pointer">
                            <input type="file" name="photo" accept="image/*" class="hidden"
                                   @change="preview = URL.createObjectURL($event.target.files[0])">
                            <div class="relative aspect-square rounded-2xl overflow-hidden
                                        border-2 border-dashed border-light-border
                                        hover:border-gold/50 transition-colors
                                        bg-light-bg flex items-center justify-center">
                                <template x-if="!preview">
                                    <div class="text-center p-6">
                                        <svg class="w-10 h-10 text-light-muted mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        <p class="text-xs text-light-muted">Pilih foto</p>
                                    </div>
                                </template>
                                <template x-if="preview">
                                    <img :src="preview" class="absolute inset-0 w-full h-full object-cover">
                                </template>
                            </div>
                        </label>
                        @error('photo') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Cover --}}
                    <div x-data="{ preview: '{{ auth()->user()->cover_photo ? asset('storage/' . auth()->user()->cover_photo) : '' }}' }">
                        <label class="block text-xs font-medium text-light-text mb-2">Cover</label>
                        <label class="block cursor-pointer">
                            <input type="file" name="cover_photo" accept="image/*" class="hidden"
                                   @change="preview = URL.createObjectURL($event.target.files[0])">
                            <div class="relative aspect-square rounded-2xl overflow-hidden
                                        border-2 border-dashed border-light-border
                                        hover:border-gold/50 transition-colors
                                        bg-light-bg flex items-center justify-center">
                                <template x-if="!preview">
                                    <div class="text-center p-6">
                                        <svg class="w-10 h-10 text-light-muted mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        <p class="text-xs text-light-muted">Pilih cover</p>
                                    </div>
                                </template>
                                <template x-if="preview">
                                    <img :src="preview" class="absolute inset-0 w-full h-full object-cover">
                                </template>
                            </div>
                        </label>
                        @error('cover_photo') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- INFO AKUN --}}
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
                        <p class="section-head-sub-light">Data login & personal</p>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-light-text mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" 
                               value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}" required
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      bg-light-bg border border-light-border text-light-text
                                      focus:outline-none focus:bg-white
                                      focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        @error('nama_lengkap') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" 
                               value="{{ old('email', auth()->user()->email) }}" required
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      bg-light-bg border border-light-border text-light-text
                                      focus:outline-none focus:bg-white
                                      focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        @error('email') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">No. HP</label>
                        <input type="text" name="phone" 
                               value="{{ old('phone', auth()->user()->phone) }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      bg-light-bg border border-light-border text-light-text
                                      focus:outline-none focus:bg-white
                                      focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-light-text mb-2">Bio</label>
                        <textarea name="bio" rows="3" maxlength="255"
                                  placeholder="Ceritakan tentang kamu (max 255 karakter)"
                                  class="w-full px-4 py-2.5 rounded-xl text-sm
                                         bg-light-bg border border-light-border text-light-text
                                         placeholder-light-muted/70 focus:outline-none focus:bg-white
                                         focus:border-gold/50 focus:ring-2 focus:ring-gold/20 resize-none">{{ old('bio', auth()->user()->bio) }}</textarea>
                        @error('bio') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- INFO AKADEMIK --}}
            <div class="panel-light">
                <div class="section-head-light">
                    <div class="icon-badge-light">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="section-head-title-light">Info Akademik</h3>
                        <p class="section-head-sub-light">Diisi sesuai data sekolah</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">NIS</label>
                        <input type="text" name="nis" value="{{ old('nis', auth()->user()->nis) }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      bg-light-bg border border-light-border text-light-text
                                      focus:outline-none focus:bg-white
                                      focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">Angkatan</label>
                        <input type="text" name="angkatan" value="{{ old('angkatan', auth()->user()->angkatan) }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      bg-light-bg border border-light-border text-light-text
                                      focus:outline-none focus:bg-white
                                      focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">Kelas</label>
                        <input type="text" name="kelas" value="{{ old('kelas', auth()->user()->kelas) }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      bg-light-bg border border-light-border text-light-text
                                      focus:outline-none focus:bg-white
                                      focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">Jurusan</label>
                        <input type="text" name="jurusan" value="{{ old('jurusan', auth()->user()->jurusan) }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      bg-light-bg border border-light-border text-light-text
                                      focus:outline-none focus:bg-white
                                      focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    </div>
                </div>
            </div>

        </div>

        {{-- SIDEBAR --}}
        <div class="space-y-6">

            {{-- SUBMIT --}}
            <div class="panel-light">
                <button type="submit" class="btn-gold w-full justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('profile.show') }}" 
                   class="mt-3 block text-center text-xs text-light-muted hover:text-gold-dark transition-colors">
                    Batal
                </a>
            </div>

            {{-- INFO --}}
            <div class="panel-light">
                <h3 class="font-display font-bold text-sm mb-3">Info Akun</h3>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-light-muted">Role</span>
                        <span class="badge-gold text-[10px]">{{ auth()->user()->role->label() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-light-muted">Status</span>
                        <span class="text-light-text font-medium">
                            {{ auth()->user()->status_anggota->label() }}
                        </span>
                    </div>
                    @if(auth()->user()->kepengurusanAktif())
                        <div class="flex justify-between">
                            <span class="text-light-muted">Jabatan</span>
                            <span class="text-light-text font-medium text-right">
                                {{ auth()->user()->kepengurusanAktif()->jabatan->nama_jabatan }}
                            </span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-light-muted">Bergabung</span>
                        <span class="text-light-text font-medium">
                            {{ auth()->user()->created_at?->format('M Y') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- GANTI PASSWORD --}}
            <div class="panel-light">
                <h3 class="font-display font-bold text-sm mb-3">Ganti Password</h3>
                <p class="text-xs text-light-muted mb-3">
                    Klik untuk ganti password akun
                </p>
                <a href="{{ route('password.request') }}" 
                   class="w-full px-4 py-2.5 rounded-xl border border-light-border
                          text-light-muted hover:bg-light-bg hover:text-gold-dark
                          font-medium text-sm transition-colors text-center block">
                    Ganti Password →
                </a>
            </div>

        </div>
    </form>

    {{-- DELETE ACCOUNT --}}
    <div class="panel-light border border-red-200 mt-6" data-aos="fade-up">
        <h3 class="font-display font-semibold text-sm text-red-600 mb-2">Zona Berbahaya</h3>
        <p class="text-xs text-light-muted mb-3">
            Hapus akun secara permanen. Data kamu akan hilang dan tidak bisa dikembalikan.
        </p>
        <form method="POST" action="{{ route('profile.destroy') }}" 
              x-data="{ confirm: '' }">
            @csrf
            @method('DELETE')
            <div class="flex gap-2">
                <input type="password" name="password" required
                       x-model="confirm"
                       placeholder="Ketik password untuk konfirmasi"
                       class="flex-1 px-4 py-2.5 rounded-xl text-sm
                              bg-light-bg border border-light-border text-light-text
                              placeholder-light-muted/70 focus:outline-none focus:bg-white
                              focus:border-red-500/50 focus:ring-2 focus:ring-red-500/20">
                <button type="submit"
                        onclick="return confirm('Yakin hapus akun? Tidak bisa dibatalkan!')"
                        :disabled="!confirm"
                        class="px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600
                               text-white font-medium text-sm transition-colors
                               disabled:opacity-40 disabled:cursor-not-allowed">
                    Hapus Akun
                </button>
            </div>
            @error('password', 'userDeletion')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </form>
    </div>

@endsection