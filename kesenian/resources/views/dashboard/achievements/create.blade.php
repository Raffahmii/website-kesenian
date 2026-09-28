@extends('layouts.dashboard')

@section('title', 'Tambah Prestasi')
@section('subtitle', 'Catat prestasi baru organisasi')

@section('content')

    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('dashboard.achievements.index') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Prestasi
        </a>
    </div>

    <form method="POST" action="{{ route('dashboard.achievements.store') }}" 
          enctype="multipart/form-data" data-aos="fade-up">
        @csrf

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- FORM UTAMA --}}
            <div class="lg:col-span-2 space-y-6">

                <div class="panel-light">
                    <div class="section-head-light">
                        <div class="icon-badge-light">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="section-head-title-light">Informasi Prestasi</h3>
                            <p class="section-head-sub-light">Detail lomba & pencapaian</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Nama Lomba <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_lomba" value="{{ old('nama_lomba') }}" required
                                   placeholder="Contoh: Festival Tari Tradisional"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          placeholder-light-muted/70 focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                            @error('nama_lomba') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-light-text mb-2">Kategori</label>
                                <input type="text" name="kategori" value="{{ old('kategori') }}"
                                       placeholder="Contoh: Seni Tari, Padus"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm
                                              bg-light-bg border border-light-border text-light-text
                                              placeholder-light-muted/70 focus:outline-none focus:bg-white
                                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-light-text mb-2">Peringkat</label>
                                <input type="text" name="peringkat" value="{{ old('peringkat') }}"
                                       placeholder="Contoh: Juara 1, Harapan 2"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm
                                              bg-light-bg border border-light-border text-light-text
                                              placeholder-light-muted/70 focus:outline-none focus:bg-white
                                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">Deskripsi</label>
                            <textarea name="deskripsi" rows="4"
                                      placeholder="Ceritakan detail prestasi ini (opsional)"
                                      class="w-full px-4 py-2.5 rounded-xl text-sm
                                             bg-light-bg border border-light-border text-light-text
                                             placeholder-light-muted/70 focus:outline-none focus:bg-white
                                             focus:border-gold/50 focus:ring-2 focus:ring-gold/20 resize-none">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- PESERTA --}}
                <div class="panel-light" x-data="{ 
                    search: '',
                    selected: {{ json_encode(old('peserta', [])) }},
                    members: {{ json_encode($members->map(fn($m) => ['id' => $m->id_user, 'nama' => $m->nama_lengkap, 'kelas' => $m->kelas, 'jurusan' => $m->jurusan, 'cabang' => $m->cabang?->shortLabel()])) }},
                    toggle(id) {
                        if (this.selected.includes(id)) {
                            this.selected = this.selected.filter(i => i !== id);
                        } else {
                            this.selected.push(id);
                        }
                    },
                    isSelected(id) { return this.selected.includes(id); },
                    get filtered() {
                        if (!this.search) return this.members;
                        return this.members.filter(m => m.nama.toLowerCase().includes(this.search.toLowerCase()));
                    }
                }">
                    <div class="section-head-light">
                        <div class="icon-badge-light">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="section-head-title-light">Peserta</h3>
                            <p class="section-head-sub-light">
                                Pilih anggota yang ikut (<span x-text="selected.length"></span> dipilih)
                            </p>
                        </div>
                    </div>

                    <input type="text" x-model="search" placeholder="Cari nama anggota..."
                           class="w-full px-4 py-2.5 rounded-xl text-sm mb-3
                                  bg-light-bg border border-light-border text-light-text
                                  placeholder-light-muted/70 focus:outline-none focus:bg-white
                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">

                    <div class="max-h-96 overflow-y-auto space-y-2 custom-scrollbar">
                        <template x-for="member in filtered" :key="member.id">
                            <label class="flex items-center gap-3 p-3 rounded-xl cursor-pointer
                                          hover:bg-gold/[0.05] transition-colors"
                                   :class="isSelected(member.id) ? 'bg-gold/10 border border-gold/30' : 'bg-light-bg border border-light-border'">
                                <input type="checkbox" 
                                       :value="member.id"
                                       :checked="isSelected(member.id)"
                                       @change="toggle(member.id)"
                                       name="peserta[]"
                                       class="w-4 h-4 rounded border-light-border bg-white text-gold focus:ring-gold/30">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-light-text truncate" x-text="member.nama"></p>
                                    <p class="text-xs text-light-muted">
                                        <span x-text="member.kelas"></span> 
                                        <span x-text="member.jurusan"></span>
                                        <span x-show="member.cabang"> · </span>
                                        <span x-text="member.cabang"></span>
                                    </p>
                                </div>
                            </label>
                        </template>
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
                                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <div><h3 class="section-head-title-light">Info Lomba</h3></div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Tingkat <span class="text-red-500">*</span>
                            </label>
                            <select name="tingkat" required
                                    class="w-full px-4 py-2.5 rounded-xl text-sm
                                           bg-light-bg border border-light-border text-light-text
                                           focus:outline-none focus:bg-white
                                           focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                @foreach(\App\Enums\TingkatPrestasi::cases() as $t)
                                    <option value="{{ $t->value }}" @selected(old('tingkat') === $t->value)>
                                        {{ $t->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">
                                Tahun <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" required
                                   min="2000" max="{{ date('Y') + 1 }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">Penyelenggara</label>
                            <input type="text" name="penyelenggara" value="{{ old('penyelenggara') }}"
                                   placeholder="Contoh: Dinas Pendidikan"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          placeholder-light-muted/70 focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-light-text mb-2">Lokasi</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                                   placeholder="Contoh: Gedung Kesenian Banjar"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          bg-light-bg border border-light-border text-light-text
                                          placeholder-light-muted/70 focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        </div>
                    </div>
                </div>

                {{-- FOTO --}}
                <div class="panel-light">
                    <div class="section-head-light">
                        <div class="icon-badge-light">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div><h3 class="section-head-title-light">Foto Bukti</h3></div>
                    </div>

                    <div x-data="{ preview: null }">
                        <label class="block cursor-pointer">
                            <input type="file" name="foto" accept="image/*" class="hidden"
                                   @change="preview = URL.createObjectURL($event.target.files[0])">
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
                                        <p class="text-sm text-light-text font-medium">Pilih foto</p>
                                    </div>
                                </template>
                                <template x-if="preview">
                                    <img :src="preview" class="absolute inset-0 w-full h-full object-cover">
                                </template>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="panel-light">
                    <button type="submit" class="btn-gold w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Prestasi
                    </button>
                    <a href="{{ route('dashboard.achievements.index') }}" 
                       class="mt-3 block text-center text-xs text-light-muted 
                              hover:text-gold-dark transition-colors">
                        Batal
                    </a>
                </div>

            </div>
        </div>
    </form>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.2); }
    </style>

@endsection