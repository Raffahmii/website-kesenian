@extends('layouts.dashboard')

@section('title', $user->nama_lengkap)
@section('subtitle', 'Profile anggota')

@section('content')

    {{-- BREADCRUMB --}}
    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('users.index') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Pencarian
        </a>
    </div>

    {{-- HERO COVER + AVATAR --}}
    <div class="panel-light overflow-hidden mb-6" data-aos="fade-up">
        <div class="relative h-48 rounded-t-2xl overflow-hidden"
             style="background: linear-gradient(135deg, #F5B301 0%, #FEB053 50%, #C28A00 100%);">
            @if($user->cover_photo)
                <img src="{{ asset('storage/' . $user->cover_photo) }}" 
                     class="absolute inset-0 w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-black/20"></div>
        </div>

        <div class="relative px-6 pb-6">
            <div class="-mt-16 flex flex-col sm:flex-row items-center sm:items-end gap-4">
                <div class="relative">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" 
                             class="w-32 h-32 rounded-3xl object-cover border-4 border-white shadow-xl">
                    @else
                        <div class="w-32 h-32 rounded-3xl gradient-gold flex items-center justify-center
                                    font-display font-bold text-bg-primary text-4xl
                                    border-4 border-white shadow-xl">
                            {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1 text-center sm:text-left pb-2">
                    <h1 class="font-display font-bold text-2xl text-light-text mb-1">
                        {{ $user->nama_lengkap }}
                    </h1>
                    <p class="text-sm text-light-muted mb-2">
                        {{ $user->email }}
                    </p>
                    <div class="flex items-center gap-2 justify-center sm:justify-start flex-wrap">
                        <span class="badge-gold text-[10px]">{{ $user->role->label() }}</span>
                        @if($user->status_anggota === \App\Enums\StatusAnggota::ALUMNI)
                            <span class="text-[10px] px-2.5 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium">
                                Alumni
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            @if($user->bio)
                <div class="mt-6 p-4 rounded-2xl bg-light-bg border border-light-border">
                    <p class="text-sm text-light-text leading-relaxed whitespace-pre-line">
                        {{ $user->bio }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- INFO GRID --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6" data-aos="fade-up">
        <div class="panel-light">
            <div class="text-[10px] uppercase tracking-wider text-light-muted font-semibold mb-1">NIS</div>
            <p class="font-display font-bold text-lg text-light-text">{{ $user->nis ?? '-' }}</p>
        </div>
        <div class="panel-light">
            <div class="text-[10px] uppercase tracking-wider text-light-muted font-semibold mb-1">Kelas</div>
            <p class="font-display font-bold text-lg text-light-text">
                {{ $user->kelas ?? '-' }} {{ $user->jurusan }}
            </p>
        </div>
        <div class="panel-light">
            <div class="text-[10px] uppercase tracking-wider text-light-muted font-semibold mb-1">Cabang</div>
            <p class="font-display font-bold text-lg text-light-text">
                @if($user->cabang)
                    {{ $user->cabang->icon() }} {{ $user->cabang->shortLabel() }}
                @else
                    -
                @endif
            </p>
        </div>
        <div class="panel-light">
            <div class="text-[10px] uppercase tracking-wider text-light-muted font-semibold mb-1">Angkatan</div>
            <p class="font-display font-bold text-lg text-light-text">{{ $user->angkatan ?? '-' }}</p>
        </div>
    </div>

    {{-- RIWAYAT KEPENGURUSAN (per periode) --}}
    @if($user->kepengurusan->count() > 0)
        @php
            // Group by periode, sort by tahun_mulai DESC
            $riwayat = $user->kepengurusan
                ->sortByDesc(fn($k) => $k->periode->tahun_mulai ?? 0)
                ->groupBy('id_periode');
        @endphp

        <div class="panel-light mb-6" data-aos="fade-up">
            <div class="section-head-light">
                <div class="icon-badge-light">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="section-head-title-light">Riwayat Kepengurusan</h3>
                    <p class="section-head-sub-light">
                        {{ $riwayat->count() }} periode terlibat
                    </p>
                </div>
            </div>

            <div class="relative">
                {{-- Timeline line --}}
                <div class="absolute left-5 top-2 bottom-2 w-0.5 bg-gradient-to-b from-gold/40 via-gold/20 to-transparent"></div>

                <div class="space-y-4">
                    @foreach($riwayat as $idPeriode => $keps)
                        @php
                            $firstKep = $keps->first();
                            $periode = $firstKep->periode;
                            $hasActive = $keps->where('is_active', true)->count() > 0;
                            $allInactive = $keps->where('is_active', false)->count() === $keps->count();
                        @endphp

                        <div class="relative pl-14">
                            {{-- Timeline dot --}}
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full 
                                        {{ $hasActive 
                                            ? 'gradient-gold shadow-lg shadow-gold/40 ring-4 ring-gold/20' 
                                            : 'bg-light-bg border-2 border-light-border' }} 
                                        flex items-center justify-center z-10">
                                @if($hasActive)
                                    <span class="w-2.5 h-2.5 rounded-full bg-bg-primary animate-pulse"></span>
                                @else
                                    <svg class="w-4 h-4 text-light-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                            </div>

                            {{-- Card --}}
                            <div class="p-4 rounded-2xl border-2 transition-all
                                        {{ $hasActive 
                                            ? 'bg-gradient-to-br from-gold/[0.08] to-transparent border-gold/40' 
                                            : 'bg-light-bg border-light-border' }}">
                                <div class="flex items-start justify-between gap-3 mb-3 flex-wrap">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <h4 class="font-display font-bold text-base 
                                                       {{ $hasActive ? 'text-gold-dark' : 'text-light-text' }}">
                                                {{ $periode->nama_periode ?? '-' }}
                                            </h4>
                                            @if($hasActive)
                                                <span class="text-[9px] px-2 py-0.5 rounded-full font-bold uppercase
                                                             bg-gold text-bg-primary tracking-wider">
                                                    AKTIF
                                                </span>
                                            @else
                                                <span class="text-[9px] px-2 py-0.5 rounded-full font-medium
                                                             bg-light-border text-light-muted">
                                                    Selesai
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-light-muted">
                                            {{ $periode->tahun_mulai ?? '-' }} - {{ $periode->tahun_selesai ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Jabatan list --}}
                                <div class="space-y-2">
                                    @foreach($keps as $k)
                                        <div class="flex items-center gap-3 p-2.5 rounded-xl
                                                    {{ $k->is_active ? 'bg-gold/10' : 'bg-white/50' }}">
                                            <div class="w-8 h-8 rounded-lg 
                                                        {{ $k->is_active ? 'gradient-gold' : 'bg-light-border' }}
                                                        flex items-center justify-center shrink-0">
                                                <svg class="w-4 h-4 {{ $k->is_active ? 'text-bg-primary' : 'text-light-muted' }}" 
                                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M9 12l2 2 4-4"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-medium text-sm 
                                                          {{ $k->is_active ? 'text-gold-dark' : 'text-light-text' }}">
                                                    {{ $k->jabatan->nama_jabatan ?? '-' }}
                                                </p>
                                                @if($k->jabatan?->divisi)
                                                    <p class="text-[10px] text-light-muted">
                                                        Divisi: {{ $k->jabatan->divisi }}
                                                    </p>
                                                @endif
                                            </div>
                                            @if(!$k->is_active)
                                                <span class="text-[10px] text-light-muted/70">
                                                    Selesai
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                {{-- SK Number --}}
                                @if($firstKep->sk_number)
                                    <p class="text-[10px] text-light-muted mt-3 pt-3 border-t border-light-border">
                                        SK: <span class="font-mono">{{ $firstKep->sk_number }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- PRESTASI --}}
    @if($user->prestasiPeserta->count() > 0)
        <div class="panel-light" data-aos="fade-up">
            <div class="section-head-light">
                <div class="icon-badge-light">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="section-head-title-light">Prestasi</h3>
                    <p class="section-head-sub-light">{{ $user->prestasiPeserta->count() }} prestasi diraih</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($user->prestasiPeserta as $p)
                    @if($p->prestasi)
                        <a href="{{ route('dashboard.achievements.show', $p->prestasi->id_prestasi) }}"
                           class="flex items-center gap-3 p-3 rounded-xl bg-light-bg border border-light-border
                                  hover:border-gold/50 transition-colors group">
                            <div class="text-2xl">🏆</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-light-text truncate 
                                          group-hover:text-gold-dark transition-colors">
                                    {{ $p->prestasi->nama_lomba }}
                                </p>
                                <p class="text-xs text-light-muted">
                                    {{ $p->prestasi->tingkat->label() }} · {{ $p->prestasi->tahun }}
                                </p>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

@endsection