@extends('layouts.dashboard')

@section('title', 'Kepengurusan')
@section('subtitle', 'Kelola struktur kepengurusan per periode')

@section('content')

    {{-- HERO --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-display font-bold mb-1 text-light-text">
                    <span class="text-gold-dark">Kepengurusan</span>
                </h2>
                <p class="text-light-muted text-sm">
                    @if($periodeAktif)
                        Periode <strong>{{ $periodeAktif->nama_periode }}</strong>
                        @if($periodeAktif->is_active) <span class="text-gold-dark">· Aktif</span> @endif
                    @else
                        Belum ada periode
                    @endif
                </p>
            </div>
            <div class="flex gap-2 self-start sm:self-center">
                <a href="{{ route('dashboard.management.jabatan') }}" class="btn-outline btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    Jabatan
                </a>
                <a href="{{ route('dashboard.management.create') }}" class="btn-gold btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Pengurus
                </a>
            </div>
        </div>
    </div>

    {{-- PERIODE TABS --}}
    <div class="panel-light mb-6" data-aos="fade-up">
        <p class="text-[10px] uppercase tracking-widest text-light-muted font-semibold mb-3">
            Pilih Periode
        </p>
        <div class="flex flex-wrap gap-2">
            @foreach($periodes as $p)
                <a href="{{ route('dashboard.management', ['periode' => $p->id_periode]) }}"
                   class="px-4 py-2 rounded-xl text-sm font-medium transition-all
                          {{ $periodeAktif && $periodeAktif->id_periode === $p->id_periode 
                              ? 'bg-gradient-to-br from-gold to-gold-hover text-bg-primary shadow-md shadow-gold/30' 
                              : 'bg-light-bg text-light-muted hover:text-gold-dark hover:bg-gold/[0.06] border border-light-border' }}">
                    {{ $p->nama_periode }}
                    @if($p->is_active)
                        <span class="ml-1 text-[9px]">●</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    {{-- LIST --}}
    @if(!$periodeAktif)
        <div class="panel-light text-center py-16" data-aos="fade-up">
            <div class="text-5xl mb-3">📋</div>
            <p class="text-light-text font-medium mb-1">Belum ada periode</p>
            <p class="text-light-muted text-sm mb-4">Buat periode dulu di Pengaturan</p>
            <a href="{{ route('dashboard.settings') }}" class="btn-gold inline-flex">
                Ke Pengaturan
            </a>
        </div>
    @elseif($kepengurusan->isEmpty())
        <div class="panel-light text-center py-16" data-aos="fade-up">
            <div class="text-5xl mb-3">👥</div>
            <p class="text-light-text font-medium mb-1">Belum ada pengurus</p>
            <p class="text-light-muted text-sm mb-4">Tambah pengurus pertama untuk periode ini</p>
            <a href="{{ route('dashboard.management.create') }}" class="btn-gold inline-flex">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Pengurus
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($kepengurusan as $i => $k)
                <div class="panel-light-interactive group" data-aos="fade-up" data-aos-delay="{{ ($i % 6) * 50 }}">
                    <div class="flex items-start gap-3 mb-4">
                        @if($k->user?->photo)
                            <img src="{{ asset('storage/' . $k->user->photo) }}" 
                                 class="w-14 h-14 rounded-2xl object-cover shrink-0">
                        @else
                            <div class="w-14 h-14 rounded-2xl gradient-gold flex items-center justify-center
                                        font-display font-bold text-bg-primary text-lg shadow-md shadow-gold/30 shrink-0">
                                {{ strtoupper(substr($k->user->nama_lengkap ?? '?', 0, 1)) }}
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-display font-bold text-sm text-light-text truncate">
                                {{ $k->user->nama_lengkap ?? '-' }}
                            </p>
                            <p class="text-[10px] text-gold-dark font-semibold uppercase tracking-wider mt-0.5">
                                {{ $k->jabatan->nama_jabatan ?? '-' }}
                            </p>
                            @if($k->jabatan?->divisi)
                                <p class="text-[10px] text-light-muted">
                                    Divisi: {{ $k->jabatan->divisi }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-light-border">
                        <div class="text-[10px] text-light-muted">
                            @if($k->sk_number)
                                <p>SK: {{ $k->sk_number }}</p>
                            @endif
                            @if($k->is_active)
                                <span class="inline-flex items-center gap-1 text-green-600 font-medium">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="text-light-muted">Tidak aktif</span>
                            @endif
                        </div>
                        <div class="flex gap-1">
                            <a href="{{ route('dashboard.management.edit', $k->id_kepengurusan) }}"
                               class="p-1.5 rounded-lg hover:bg-blue-50 text-light-muted hover:text-blue-500 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <button type="button"
                                    onclick="if(confirm('Hapus pengurus ini?')) document.getElementById('del-{{ $k->id_kepengurusan }}').submit()"
                                    class="p-1.5 rounded-lg hover:bg-red-50 text-light-muted hover:text-red-500 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                            <form id="del-{{ $k->id_kepengurusan }}" 
                                  action="{{ route('dashboard.management.destroy', $k->id_kepengurusan) }}" 
                                  method="POST" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection