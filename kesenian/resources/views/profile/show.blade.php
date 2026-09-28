@extends('layouts.dashboard')

@section('title', 'Profile Saya')
@section('subtitle', 'Lihat profil publik kamu')

@section('content')

    {{-- HERO COVER + AVATAR --}}
    <div class="panel-light overflow-hidden mb-6" data-aos="fade-up">
        <div class="relative h-48 rounded-t-2xl overflow-hidden"
             style="background: linear-gradient(135deg, #F5B301 0%, #FEB053 50%, #C28A00 100%);">
            @if(auth()->user()->cover_photo)
                <img src="{{ asset('storage/' . auth()->user()->cover_photo) }}" 
                     class="absolute inset-0 w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-black/20"></div>
        </div>

        <div class="relative px-6 pb-6">
            <div class="-mt-16 flex flex-col sm:flex-row items-center sm:items-end gap-4">
                <div class="relative">
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" 
                             class="w-32 h-32 rounded-3xl object-cover border-4 border-white shadow-xl">
                    @else
                        <div class="w-32 h-32 rounded-3xl gradient-gold flex items-center justify-center
                                    font-display font-bold text-bg-primary text-4xl
                                    border-4 border-white shadow-xl">
                            {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1 text-center sm:text-left pb-2">
                    <h1 class="font-display font-bold text-2xl text-light-text mb-1">
                        {{ auth()->user()->nama_lengkap }}
                    </h1>
                    <p class="text-sm text-light-muted mb-2">
                        {{ auth()->user()->email }}
                    </p>
                    <div class="flex items-center gap-2 justify-center sm:justify-start flex-wrap">
                        <span class="badge-gold text-[10px]">{{ auth()->user()->role->label() }}</span>
                        @if(auth()->user()->kepengurusanAktif())
                            <span class="text-[10px] px-2.5 py-1 rounded-full bg-light-bg border border-light-border
                                         text-light-muted font-medium">
                                {{ auth()->user()->kepengurusanAktif()->jabatan->nama_jabatan }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn-gold btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>

            {{-- Bio --}}
            @if(auth()->user()->bio)
                <div class="mt-6 p-4 rounded-2xl bg-light-bg border border-light-border">
                    <p class="text-sm text-light-text leading-relaxed whitespace-pre-line">
                        {{ auth()->user()->bio }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- INFO GRID --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6" data-aos="fade-up">
        <div class="panel-light">
            <div class="text-[10px] uppercase tracking-wider text-light-muted font-semibold mb-1">NIS</div>
            <p class="font-display font-bold text-lg text-light-text">
                {{ auth()->user()->nis ?? '-' }}
            </p>
        </div>
        <div class="panel-light">
            <div class="text-[10px] uppercase tracking-wider text-light-muted font-semibold mb-1">Kelas</div>
            <p class="font-display font-bold text-lg text-light-text">
                {{ auth()->user()->kelas ?? '-' }} {{ auth()->user()->jurusan }}
            </p>
        </div>
        <div class="panel-light">
            <div class="text-[10px] uppercase tracking-wider text-light-muted font-semibold mb-1">Cabang</div>
            <p class="font-display font-bold text-lg text-light-text">
                @if(auth()->user()->cabang)
                    {{ auth()->user()->cabang->icon() }} {{ auth()->user()->cabang->shortLabel() }}
                @else
                    -
                @endif
            </p>
        </div>
        <div class="panel-light">
            <div class="text-[10px] uppercase tracking-wider text-light-muted font-semibold mb-1">Angkatan</div>
            <p class="font-display font-bold text-lg text-light-text">
                {{ auth()->user()->angkatan ?? '-' }}
            </p>
        </div>
    </div>

    {{-- QUICK STATS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4" data-aos="fade-up">
        <a href="{{ route('dashboard.attendance') }}" 
           class="panel-light-interactive group text-center">
            <div class="icon-badge-light mx-auto mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="font-display font-bold text-lg text-light-text 
                       group-hover:text-gold-dark transition-colors">
                Absensi Saya
            </p>
            <p class="text-xs text-light-muted">Lihat riwayat kehadiran</p>
        </a>

        <a href="{{ route('dashboard.cash') }}" 
           class="panel-light-interactive group text-center">
            <div class="icon-badge-light mx-auto mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="font-display font-bold text-lg text-light-text 
                       group-hover:text-gold-dark transition-colors">
                Kas Saya
            </p>
            <p class="text-xs text-light-muted">Cek status pembayaran kas</p>
        </a>

        <a href="{{ route('dashboard.events.index') }}" 
           class="panel-light-interactive group text-center">
            <div class="icon-badge-light mx-auto mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <p class="font-display font-bold text-lg text-light-text 
                       group-hover:text-gold-dark transition-colors">
                Event
            </p>
            <p class="text-xs text-light-muted">Lihat jadwal kegiatan</p>
        </a>
    </div>
    
@endsection