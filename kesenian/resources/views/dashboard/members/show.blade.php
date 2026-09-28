@extends('layouts.dashboard')

@section('title', $member->nama_lengkap)
@section('subtitle', 'Detail informasi anggota')

@section('content')

    <div class="mb-6 flex items-center justify-between" data-aos="fade-up">
        <a href="{{ route('dashboard.members.index') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>

        <a href="{{ route('dashboard.members.edit', $member->id_user) }}" 
           class="btn-gold btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- PROFILE CARD --}}
        <div class="lg:col-span-1" data-aos="fade-up">
            <div class="panel-light-gold text-center">
                @if($member->photo)
                    <img src="{{ asset('storage/' . $member->photo) }}" 
                         class="w-24 h-24 rounded-3xl object-cover mx-auto mb-4">
                @else
                    <div class="w-24 h-24 rounded-3xl gradient-gold flex items-center justify-center
                                font-display font-bold text-bg-primary text-3xl mx-auto mb-4
                                shadow-lg shadow-gold/30">
                        {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
                    </div>
                @endif

                <h2 class="font-display font-bold text-xl text-light-text mb-1">
                    {{ $member->nama_lengkap }}
                </h2>
                <p class="text-sm text-light-muted mb-4">{{ $member->email }}</p>

                <div class="flex items-center justify-center gap-2 mb-4">
                    <span class="badge-gold text-[10px]">{{ $member->role->label() }}</span>
                    @php
                        $statusClass = match($member->status_anggota) {
                            \App\Enums\StatusAnggota::AKTIF => 'bg-green-100 text-green-700',
                            \App\Enums\StatusAnggota::ALUMNI => 'bg-yellow-100 text-yellow-700',
                            \App\Enums\StatusAnggota::NONAKTIF => 'bg-red-100 text-red-700',
                        };
                    @endphp
                    <span class="text-[10px] px-2.5 py-1 rounded-full font-medium {{ $statusClass }}">
                        {{ $member->status_anggota->label() }}
                    </span>
                </div>

                <div class="divider-light my-4"></div>

                <div class="space-y-3 text-left">
                    <div class="flex justify-between text-sm">
                        <span class="text-light-muted">NIS</span>
                        <span class="text-light-text font-medium">{{ $member->nis ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-light-muted">Kelas</span>
                        <span class="text-light-text font-medium">{{ $member->kelas ?? '-' }} {{ $member->jurusan }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-light-muted">Cabang</span>
                        <span class="text-light-text font-medium">
                            @if($member->cabang)
                                {{ $member->cabang->icon() }} {{ $member->cabang->shortLabel() }}
                            @else
                                -
                            @endif
                        </span>
                    </div>                    
                    <div class="flex justify-between text-sm">
                        <span class="text-light-muted">Angkatan</span>
                        <span class="text-light-text font-medium">{{ $member->angkatan ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-light-muted">No. HP</span>
                        <span class="text-light-text font-medium">{{ $member->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- DETAILS --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Kepengurusan --}}
            <div class="panel-light" data-aos="fade-up">
                <div class="section-head-light">
                    <div class="icon-badge-light">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="section-head-title-light">Riwayat Kepengurusan</h3>
                        <p class="section-head-sub-light">Posisi di setiap periode</p>
                    </div>
                </div>

                @if($member->kepengurusan->count() > 0)
                    <div class="space-y-3">
                        @foreach($member->kepengurusan as $kep)
                            <div class="p-4 rounded-xl bg-light-bg border border-light-border flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl gradient-gold flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-bg-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-sm text-light-text">
                                        {{ $kep->jabatan->nama_jabatan ?? '-' }}
                                    </p>
                                    <p class="text-xs text-light-muted">
                                        Periode {{ $kep->periode->nama_periode ?? '-' }}
                                    </p>
                                </div>
                                @if($kep->is_active)
                                    <span class="text-[10px] px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">
                                        Aktif
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-4xl mb-2 opacity-40">📋</div>
                        <p class="text-sm text-light-muted">Belum ada riwayat kepengurusan</p>
                    </div>
                @endif
            </div>


        </div>
    </div>

@endsection