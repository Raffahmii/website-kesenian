@extends('layouts.dashboard')

@section('title', 'Jabatan')
@section('subtitle', 'Kelola jabatan kepengurusan')

@section('content')

    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('dashboard.management') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Kepengurusan
        </a>
    </div>

    {{-- INFO BOX --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gold/20 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-display font-bold text-base text-light-text mb-1">
                    Apa itu Tingkat Jabatan?
                </h3>
                <p class="text-xs text-light-muted leading-relaxed mb-2">
                    Tingkat jabatan menentukan <strong>urutan hierarki</strong>. Semakin kecil angkanya, semakin tinggi jabatannya.
                </p>
                <div class="flex flex-wrap gap-2">
                    <span class="text-[10px] px-2 py-1 rounded-full bg-red-100 text-red-700 font-medium">
                        1 = Pembina
                    </span>
                    <span class="text-[10px] px-2 py-1 rounded-full bg-orange-100 text-orange-700 font-medium">
                        2 = Ketua
                    </span>
                    <span class="text-[10px] px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium">
                        3 = Wakil
                    </span>
                    <span class="text-[10px] px-2 py-1 rounded-full bg-blue-100 text-blue-700 font-medium">
                        4 = Sekre/Bendahara
                    </span>
                    <span class="text-[10px] px-2 py-1 rounded-full bg-purple-100 text-purple-700 font-medium">
                        5 = Departemen
                    </span>
                    <span class="text-[10px] px-2 py-1 rounded-full bg-pink-100 text-pink-700 font-medium">
                        6 = Koordinator
                    </span>
                    <span class="text-[10px] px-2 py-1 rounded-full bg-gray-100 text-gray-700 font-medium">
                        99 = Anggota
                    </span>
                </div>
            </div>
        </div>
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
                <div><h3 class="section-head-title-light">Tambah Jabatan</h3></div>
            </div>

            <form method="POST" action="{{ route('dashboard.management.jabatan.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-medium text-light-text mb-2">
                        Nama Jabatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_jabatan" value="{{ old('nama_jabatan') }}" required
                           placeholder="Contoh: Koor. Padus"
                           class="w-full px-4 py-2.5 rounded-xl text-sm
                                  bg-light-bg border border-light-border text-light-text
                                  placeholder-light-muted/70 focus:outline-none focus:bg-white
                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    @error('nama_jabatan') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-light-text mb-2">
                        Tingkat Jabatan <span class="text-red-500">*</span>
                    </label>
                    <select name="level" required
                            class="w-full px-4 py-2.5 rounded-xl text-sm
                                   bg-light-bg border border-light-border text-light-text
                                   focus:outline-none focus:bg-white
                                   focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        <option value="">— Pilih Tingkat —</option>
                        <option value="1" @selected(old('level') == 1)>1 · Pembina (paling tinggi)</option>
                        <option value="2" @selected(old('level') == 2)>2 · Ketua</option>
                        <option value="3" @selected(old('level') == 3)>3 · Wakil Ketua</option>
                        <option value="4" @selected(old('level') == 4)>4 · Sekretaris / Bendahara</option>
                        <option value="5" @selected(old('level') == 5)>5 · Kepala Departemen</option>
                        <option value="6" @selected(old('level') == 6)>6 · Koordinator Divisi</option>
                        <option value="99" @selected(old('level') == 99)>99 · Anggota Biasa</option>
                    </select>
                    @error('level') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-light-text mb-2">Divisi</label>
                    <input type="text" name="divisi" value="{{ old('divisi') }}"
                           placeholder="Contoh: padus, tari (opsional)"
                           class="w-full px-4 py-2.5 rounded-xl text-sm
                                  bg-light-bg border border-light-border text-light-text
                                  placeholder-light-muted/70 focus:outline-none focus:bg-white
                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                </div>

                <button type="submit" class="btn-gold w-full justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Jabatan
                </button>
            </form>
        </div>

        {{-- LIST JABATAN --}}
        <div class="lg:col-span-2 panel-light" data-aos="fade-up" data-aos-delay="100">
            <div class="section-head-light">
                <div class="icon-badge-light-solid">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="section-head-title-light">Daftar Jabatan</h3>
                    <p class="section-head-sub-light">{{ $jabatans->count() }} jabatan · urut dari tertinggi</p>
                </div>
            </div>

            <div class="space-y-2">
                @forelse($jabatans as $j)
                    @php
                        $levelInfo = match((int) $j->level) {
                            1   => ['label' => 'Pembina', 'color' => 'bg-red-100 text-red-700'],
                            2   => ['label' => 'Ketua', 'color' => 'bg-orange-100 text-orange-700'],
                            3   => ['label' => 'Wakil', 'color' => 'bg-yellow-100 text-yellow-700'],
                            4   => ['label' => 'Inti', 'color' => 'bg-blue-100 text-blue-700'],
                            5   => ['label' => 'Departemen', 'color' => 'bg-purple-100 text-purple-700'],
                            6   => ['label' => 'Koordinator', 'color' => 'bg-pink-100 text-pink-700'],
                            99  => ['label' => 'Anggota', 'color' => 'bg-gray-100 text-gray-700'],
                            default => ['label' => 'Lainnya', 'color' => 'bg-light-bg text-light-muted'],
                        };
                    @endphp
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-light-bg border border-light-border
                                hover:border-gold/30 transition-colors group">
                        <div class="w-12 h-12 rounded-xl bg-gold/10 flex flex-col items-center justify-center shrink-0">
                            <span class="font-display font-bold text-gold-dark text-sm leading-none">
                                {{ $j->level ?? '?' }}
                            </span>
                            <span class="text-[8px] text-light-muted uppercase tracking-wider mt-0.5">
                                lvl
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-0.5">
                                <p class="font-medium text-sm text-light-text truncate">
                                    {{ $j->nama_jabatan }}
                                </p>
                                <span class="text-[9px] px-2 py-0.5 rounded-full font-medium {{ $levelInfo['color'] }}">
                                    {{ $levelInfo['label'] }}
                                </span>
                            </div>
                            <p class="text-xs text-light-muted">
                                @if($j->divisi) Divisi: <strong>{{ $j->divisi }}</strong> · @endif
                                {{ $j->kepengurusan_count }} anggota 
                                @if($periodeAktif)
                                    <span class="text-gold-dark">· {{ $periodeAktif->nama_periode }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="flex gap-1">
                            <button type="button"
                                    x-data
                                    @click="$dispatch('edit-jabatan', {
                                        id: {{ $j->id_jabatan }},
                                        nama: '{{ addslashes($j->nama_jabatan) }}',
                                        level: {{ $j->level ?? 5 }},
                                        divisi: '{{ addslashes($j->divisi ?? '') }}'
                                    })"
                                    class="p-1.5 rounded-lg hover:bg-blue-50 text-light-muted 
                                           hover:text-blue-500 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>

                            <form action="{{ route('dashboard.management.jabatan.destroy', $j->id_jabatan) }}" 
                                  method="POST">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Hapus jabatan {{ $j->nama_jabatan }}?')"
                                        class="p-1.5 rounded-lg hover:bg-red-50 text-light-muted 
                                               hover:text-red-500 transition-colors
                                               disabled:opacity-30 disabled:cursor-not-allowed"
                                        {{ $j->kepengurusan_count > 0 ? 'disabled' : '' }}>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="text-5xl mb-3 opacity-50">📋</div>
                        <p class="text-light-text font-medium">Belum ada jabatan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- MODAL EDIT JABATAN --}}
    <div 
        x-data="{ 
            open: false, 
            id: 0, 
            nama: '', 
            level: 5, 
            divisi: '' 
        }"
        x-init="
            window.addEventListener('edit-jabatan', (e) => {
                open = true;
                id = e.detail.id;
                nama = e.detail.nama;
                level = e.detail.level;
                divisi = e.detail.divisi;
            });
        "
        @keydown.escape.window="open = false"
        x-show="open"
        x-cloak
        @click.self="open = false"
        x-transition
        class="fixed inset-0 z-[100] flex items-center justify-center p-4
               bg-black/50 backdrop-blur-sm"
    >
        <div 
            @click.stop
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="w-full max-w-md panel-light p-6"
        >
            <h3 class="font-display font-bold text-lg text-light-text mb-4">
                Edit Jabatan
            </h3>

            <form :action="`/dashboard/management/jabatan/${id}`" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-medium text-light-text mb-2">
                        Nama Jabatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_jabatan" x-model="nama" required
                           class="w-full px-4 py-2.5 rounded-xl text-sm
                                  bg-light-bg border border-light-border text-light-text
                                  focus:outline-none focus:bg-white
                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                </div>

                <div>
                    <label class="block text-xs font-medium text-light-text mb-2">
                        Tingkat <span class="text-red-500">*</span>
                    </label>
                    <select name="level" x-model="level" required
                            class="w-full px-4 py-2.5 rounded-xl text-sm
                                   bg-light-bg border border-light-border text-light-text
                                   focus:outline-none focus:bg-white
                                   focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        <option value="1">1 · Pembina</option>
                        <option value="2">2 · Ketua</option>
                        <option value="3">3 · Wakil Ketua</option>
                        <option value="4">4 · Sekretaris / Bendahara</option>
                        <option value="5">5 · Kepala Departemen</option>
                        <option value="6">6 · Koordinator Divisi</option>
                        <option value="99">99 · Anggota Biasa</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-light-text mb-2">Divisi</label>
                    <input type="text" name="divisi" x-model="divisi"
                           class="w-full px-4 py-2.5 rounded-xl text-sm
                                  bg-light-bg border border-light-border text-light-text
                                  focus:outline-none focus:bg-white
                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" @click="open = false"
                            class="flex-1 px-4 py-2.5 rounded-xl border border-light-border
                                   text-light-muted hover:bg-light-bg font-medium text-sm transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="btn-gold flex-1 justify-center">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection