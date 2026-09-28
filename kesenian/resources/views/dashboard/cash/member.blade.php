@extends('layouts.dashboard')

@section('title', 'Kas Saya')
@section('subtitle', 'Riwayat pembayaran kas pribadi')

@section('content')

    {{-- HERO --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative">
            <h2 class="text-2xl sm:text-3xl font-display font-bold mb-1 text-light-text">
                Kas <span class="text-gold-dark">Saya</span>
            </h2>
            <p class="text-light-muted text-sm">
                Total Rp {{ number_format($myStats['total_bayar'], 0, ',', '.') }} sudah dibayar
            </p>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="panel-light" data-aos="fade-up">
            <div class="text-3xl font-display font-bold 
                        bg-gradient-to-br from-gold-dark to-gold bg-clip-text text-transparent 
                        mb-1 leading-none">
                {{ $myStats['total'] }}
            </div>
            <div class="text-xs text-light-muted font-medium">Total Tagihan</div>
        </div>
        <div class="panel-light" data-aos="fade-up" data-aos-delay="60">
            <div class="text-3xl font-display font-bold 
                        bg-gradient-to-br from-green-600 to-green-400 bg-clip-text text-transparent 
                        mb-1 leading-none">
                {{ $myStats['lunas'] }}
            </div>
            <div class="text-xs text-light-muted font-medium">Lunas</div>
        </div>
        <div class="panel-light" data-aos="fade-up" data-aos-delay="120">
            <div class="text-3xl font-display font-bold 
                        bg-gradient-to-br from-red-600 to-red-400 bg-clip-text text-transparent 
                        mb-1 leading-none">
                {{ $myStats['belum_lunas'] }}
            </div>
            <div class="text-xs text-light-muted font-medium">Belum Lunas</div>
        </div>
    </div>

    {{-- LIST --}}
    <div class="panel-light" data-aos="fade-up">
        <div class="section-head-light">
            <div class="icon-badge-light">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <h3 class="section-head-title-light">Riwayat Pembayaran</h3>
                <p class="section-head-sub-light">Semua tagihan kas kamu</p>
            </div>
        </div>

        <div class="space-y-2">
            @forelse($myCash as $c)
                @php
                    $isLunas = $c->status === \App\Enums\StatusKas::LUNAS;
                @endphp
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-light-bg 
                            hover:bg-light-hover transition-colors">
                    <div class="shrink-0">
                        <div class="w-12 h-12 rounded-xl {{ $isLunas ? 'bg-green-100' : 'bg-red-100' }}
                                    flex items-center justify-center">
                            @if($isLunas)
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm text-light-text truncate">
                            {{ $c->kategori->nama ?? '-' }}
                        </p>
                        <p class="text-xs text-light-muted">
                            Periode <span class="font-mono">{{ $c->periode_bulan }}</span>
                            @if($c->tanggal_bayar)
                                · Dibayar {{ $c->tanggal_bayar->format('d M Y') }}
                            @endif
                        </p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="font-bold text-sm {{ $isLunas ? 'text-green-600' : 'text-light-text' }}">
                            Rp {{ number_format($c->nominal, 0, ',', '.') }}
                        </p>
                        <span class="text-[10px] px-2 py-0.5 rounded-full font-medium
                                     {{ $isLunas ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $c->status->label() }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="text-5xl mb-3 opacity-50">💰</div>
                    <p class="text-light-text font-medium mb-1">Belum ada tagihan kas</p>
                    <p class="text-light-muted text-sm">Kamu belum punya tagihan kas</p>
                </div>
            @endforelse
        </div>
    </div>

    @if($myCash->hasPages())
        <div class="mt-6">{{ $myCash->links() }}</div>
    @endif

@endsection