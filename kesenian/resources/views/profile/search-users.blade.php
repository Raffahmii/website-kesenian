@extends('layouts.dashboard')

@section('title', 'Cari Anggota')
@section('subtitle', 'Temukan anggota & pengurus')

@section('content')

    {{-- HERO --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative">
            <h2 class="text-2xl sm:text-3xl font-display font-bold mb-1 text-light-text">
                Cari <span class="text-gold-dark">Anggota</span>
            </h2>
            <p class="text-light-muted text-sm">
                Temukan anggota, pengurus, atau alumni Giri Adiwarna
            </p>
        </div>
    </div>

    {{-- SEARCH --}}
    <div class="panel-light mb-6" data-aos="fade-up">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="lg:col-span-2 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-light-muted" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Cari nama, NIS, atau email..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm
                              bg-light-bg border border-light-border text-light-text
                              placeholder-light-muted/70 focus:outline-none focus:bg-white
                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
            </div>

            <select name="cabang" class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                          text-light-text focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Cabang</option>
                @foreach(\App\Enums\Cabang::cases() as $c)
                    <option value="{{ $c->value }}" @selected(request('cabang') === $c->value)>
                        {{ $c->icon() }} {{ $c->shortLabel() }}
                    </option>
                @endforeach
            </select>

            <select name="role" class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                        text-light-text focus:outline-none focus:bg-white
                                        focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Role</option>
                @foreach(\App\Enums\RoleUser::cases() as $r)
                    <option value="{{ $r->value }}" @selected(request('role') === $r->value)>
                        {{ $r->label() }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- RESULT COUNT --}}
    <p class="text-xs text-light-muted mb-4">
        Ditemukan <strong>{{ $users->total() }}</strong> anggota
    </p>

    {{-- GRID USERS --}}
    @if($users->isEmpty())
        <div class="panel-light text-center py-16" data-aos="fade-up">
            <div class="text-5xl mb-3">🔍</div>
            <p class="text-light-text font-medium mb-1">User tidak ditemukan</p>
            <p class="text-light-muted text-sm">Coba ubah kata kunci pencarian</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($users as $i => $u)
                <a href="{{ route('users.show', $u->id_user) }}"
                   class="panel-light-interactive group block"
                   data-aos="fade-up" data-aos-delay="{{ ($i % 8) * 40 }}">

                    <div class="flex items-center gap-3 mb-4">
                        @if($u->photo)
                            <img src="{{ asset('storage/' . $u->photo) }}" 
                                 class="w-14 h-14 rounded-2xl object-cover shrink-0">
                        @else
                            <div class="w-14 h-14 rounded-2xl gradient-gold flex items-center justify-center
                                        font-display font-bold text-bg-primary text-lg shrink-0
                                        group-hover:scale-105 transition-transform">
                                {{ strtoupper(substr($u->nama_lengkap, 0, 1)) }}
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-sm text-light-text truncate
                                      group-hover:text-gold-dark transition-colors">
                                {{ $u->nama_lengkap }}
                            </p>
                            <p class="text-xs text-light-muted truncate">
                                {{ $u->nis ? 'NIS: ' . $u->nis : $u->email }}
                            </p>
                            {{-- Status badge --}}
                            @php
                                $statusClass = match($u->status_anggota) {
                                    \App\Enums\StatusAnggota::AKTIF    => 'bg-green-100 text-green-700',
                                    \App\Enums\StatusAnggota::ALUMNI   => 'bg-yellow-100 text-yellow-700',
                                    \App\Enums\StatusAnggota::NONAKTIF => 'bg-red-100 text-red-700',
                                };
                            @endphp
                            <span class="inline-block text-[9px] px-2 py-0.5 rounded-full font-medium mt-1 {{ $statusClass }}">
                                {{ $u->status_anggota->label() }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="badge-gold text-[10px]">{{ $u->role->label() }}</span>
                        @if($u->cabang)
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-light-bg border border-light-border
                                         text-light-muted font-medium">
                                {{ $u->cabang->icon() }} {{ $u->cabang->shortLabel() }}
                            </span>
                        @endif
                        @if($u->kelas)
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-light-bg border border-light-border
                                         text-light-muted font-medium">
                                {{ $u->kelas }} {{ $u->jurusan }}
                            </span>
                        @endif
                    </div>

                    {{-- Jabatan aktif --}}
                    @php
                        $kepAktif = $u->kepengurusan->where('is_active', true)->first();
                    @endphp
                    @if($kepAktif && $kepAktif->jabatan)
                        <div class="mt-3 p-2 rounded-lg bg-gold/10 border border-gold/20">
                            <p class="text-[10px] text-gold-dark font-semibold uppercase tracking-wider mb-0.5">
                                Jabatan Aktif
                            </p>
                            <p class="text-xs font-medium text-light-text">
                                {{ $kepAktif->jabatan->nama_jabatan }}
                            </p>
                            @if($kepAktif->periode)
                                <p class="text-[10px] text-light-muted">
                                    {{ $kepAktif->periode->nama_periode }}
                                </p>
                            @endif
                        </div>
                    @endif

                    @if($u->bio)
                        <p class="text-xs text-light-muted mt-3 line-clamp-2 italic">
                            "{{ $u->bio }}"
                        </p>
                    @endif
                </a>
            @endforeach
        </div>

        @if($users->hasPages())
            <div class="mt-6">{{ $users->links() }}</div>
        @endif
    @endif

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

@endsection