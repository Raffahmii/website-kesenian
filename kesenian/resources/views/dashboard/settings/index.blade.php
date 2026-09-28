@extends('layouts.dashboard')

@section('title', 'Pengaturan')
@section('subtitle', 'Pengaturan sistem & periode')

@section('content')

    {{-- HERO --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative">
            <h2 class="text-2xl sm:text-3xl font-display font-bold mb-1 text-light-text">
                <span class="text-gold-dark">Pengaturan</span> Sistem
            </h2>
            <p class="text-light-muted text-sm">
                Kelola periode & info sistem organisasi
            </p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- FORM TAMBAH PERIODE --}}
        <div class="panel-light" data-aos="fade-up">
            <div class="section-head-light">
                <div class="icon-badge-light-solid">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div><h3 class="section-head-title-light">Tambah Periode</h3></div>
            </div>

            <form method="POST" action="{{ route('dashboard.settings.periode.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-light-text mb-2">
                        Nama Periode <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_periode" value="{{ old('nama_periode') }}" required
                           placeholder="Contoh: 2026/2027"
                           class="w-full px-4 py-2.5 rounded-xl text-sm
                                  bg-light-bg border border-light-border text-light-text
                                  placeholder-light-muted/70 focus:outline-none focus:bg-white
                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    @error('nama_periode') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">Mulai</label>
                        <input type="number" name="tahun_mulai" value="{{ old('tahun_mulai', date('Y')) }}" 
                               required min="2000" max="2100"
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      bg-light-bg border border-light-border text-light-text
                                      focus:outline-none focus:bg-white
                                      focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-light-text mb-2">Selesai</label>
                        <input type="number" name="tahun_selesai" value="{{ old('tahun_selesai', date('Y') + 1) }}" 
                               required min="2000" max="2100"
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      bg-light-bg border border-light-border text-light-text
                                      focus:outline-none focus:bg-white
                                      focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    </div>
                </div>

                <label class="flex items-center gap-3 p-3 rounded-xl bg-light-bg cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           class="w-4 h-4 rounded border-light-border bg-white text-gold focus:ring-gold/30">
                    <span class="text-sm text-light-text">Jadikan periode aktif</span>
                </label>

                <button type="submit" class="btn-gold w-full justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tambah Periode
                </button>
            </form>
        </div>

        {{-- LIST PERIODE --}}
        <div class="lg:col-span-2 panel-light" data-aos="fade-up" data-aos-delay="100">
            <div class="section-head-light">
                <div class="icon-badge-light-solid">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="section-head-title-light">Daftar Periode</h3>
                    <p class="section-head-sub-light">{{ $periodes->count() }} periode</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse($periodes as $p)
                    <div class="p-4 rounded-2xl border-2 transition-all
                                {{ $p->is_active 
                                    ? 'bg-gold/10 border-gold' 
                                    : 'bg-light-bg border-light-border' }}">
                        <div class="flex items-center gap-4">
                            <div class="shrink-0">
                                <div class="w-12 h-12 rounded-xl 
                                            {{ $p->is_active ? 'gradient-gold shadow-md shadow-gold/30' : 'bg-light-border/30' }} 
                                            flex items-center justify-center">
                                    <svg class="w-6 h-6 {{ $p->is_active ? 'text-bg-primary' : 'text-light-muted' }}" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <p class="font-display font-bold text-lg 
                                              {{ $p->is_active ? 'text-gold-dark' : 'text-light-text' }}">
                                        {{ $p->nama_periode }}
                                    </p>
                                    @if($p->is_active)
                                        <span class="text-[9px] px-2 py-0.5 rounded-full font-bold
                                                     bg-gold text-bg-primary uppercase tracking-wider">
                                            AKTIF
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-light-muted">
                                    {{ $p->tahun_mulai }} - {{ $p->tahun_selesai }} 
                                    · {{ $p->kepengurusan_count }} pengurus
                                </p>
                            </div>

                            <div class="flex items-center gap-1">
                                @if(!$p->is_active)
                                    <form action="{{ route('dashboard.settings.periode.activate', $p->id_periode) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-lg bg-gold hover:bg-gold-hover
                                                       text-bg-primary text-xs font-semibold transition-colors">
                                            Aktifkan
                                        </button>
                                    </form>
                                @endif

                                <button 
                                    type="button"
                                    onclick="if(confirm('Hapus periode {{ $p->nama_periode }}?')) document.getElementById('del-p-{{ $p->id_periode }}').submit()"
                                    class="p-2 rounded-lg hover:bg-red-50 text-light-muted 
                                           hover:text-red-500 transition-colors"
                                    {{ $p->is_active || $p->kepengurusan_count > 0 ? 'disabled' : '' }}>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                <form id="del-p-{{ $p->id_periode }}" 
                                      action="{{ route('dashboard.settings.periode.destroy', $p->id_periode) }}" 
                                      method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="text-5xl mb-3 opacity-50">📅</div>
                        <p class="text-light-text font-medium mb-1">Belum ada periode</p>
                        <p class="text-light-muted text-sm">Tambah periode pertama di form sebelah</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- SYSTEM INFO --}}
    <div class="grid lg:grid-cols-2 gap-6 mt-6">

        <div class="panel-light" data-aos="fade-up">
            <div class="section-head-light">
                <div class="icon-badge-light-solid">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                    </svg>
                </div>
                <div><h3 class="section-head-title-light">Informasi Sistem</h3></div>
            </div>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between gap-3 pb-2 border-b border-light-border">
                    <span class="text-light-muted">PHP</span>
                    <span class="text-light-text font-mono text-xs font-medium">{{ $info['php_version'] }}</span>
                </div>
                <div class="flex justify-between gap-3 pb-2 border-b border-light-border">
                    <span class="text-light-muted">Laravel</span>
                    <span class="text-light-text font-mono text-xs font-medium">{{ $info['laravel_version'] }}</span>
                </div>
                <div class="flex justify-between gap-3 pb-2 border-b border-light-border">
                    <span class="text-light-muted">Database</span>
                    <span class="text-light-text font-mono text-xs font-medium">{{ $info['database'] }}</span>
                </div>
                <div class="flex justify-between gap-3">
                    <span class="text-light-muted">Timezone</span>
                    <span class="text-light-text font-mono text-xs font-medium">{{ $info['timezone'] }}</span>
                </div>
            </div>
        </div>

        <div class="panel-light" data-aos="fade-up" data-aos-delay="100">
            <div class="section-head-light">
                <div class="icon-badge-light-solid">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="section-head-title-light">Ringkasan Data</h3>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                @foreach($info['total_data'] as $key => $val)
                    <div class="p-3 rounded-xl bg-light-bg border border-light-border text-center">
                        <div class="text-xl font-display font-bold text-gold-dark leading-none mb-1">
                            {{ number_format($val, 0, ',', '.') }}
                        </div>
                        <div class="text-[10px] text-light-muted uppercase tracking-wider font-medium">
                            {{ $key }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Clear Cache --}}
            <form action="{{ route('dashboard.settings.clear-cache') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit"
                        onclick="return confirm('Clear cache aplikasi?')"
                        class="w-full px-4 py-2.5 rounded-xl bg-yellow-100 hover:bg-yellow-200
                               text-yellow-700 text-sm font-medium transition-colors
                               flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Clear Cache
                </button>
            </form>
        </div>
    </div>

@endsection