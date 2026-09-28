@extends('layouts.dashboard')

@section('title', 'Kas & Pembayaran')
@section('subtitle', 'Kelola kas dan pembayaran anggota')

@section('content')

    {{-- HERO --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-display font-bold mb-1 text-light-text">
                    Kas & <span class="text-gold-dark">Pembayaran</span>
                </h2>
                <p class="text-light-muted text-sm">
                    Periode {{ \Carbon\Carbon::parse($periodeAktif . '-01')->translatedFormat('F Y') }}
                </p>
            </div>

            <div class="flex flex-wrap gap-2 self-start sm:self-center">
                <a href="{{ route('dashboard.cash.input', ['periode' => $periodeAktif]) }}" class="btn-gold btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Input Kas
                </a>
                <a href="{{ route('dashboard.cash.categories') }}" class="btn-outline btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Kategori
                </a>
                <a href="{{ route('dashboard.cash.export', request()->only(['periode', 'status', 'kategori', 'cabang'])) }}" 
                   class="btn-outline btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export
                </a>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="panel-light" data-aos="fade-up">
            <div class="text-xl sm:text-2xl font-display font-bold 
                        bg-gradient-to-br from-gold-dark to-gold bg-clip-text text-transparent mb-1 leading-tight">
                Rp {{ number_format($stats['total_bulan_ini'], 0, ',', '.') }}
            </div>
            <div class="text-xs text-light-muted font-medium">Kas Bulan Ini</div>
        </div>

        <div class="panel-light" data-aos="fade-up" data-aos-delay="60">
            <div class="text-3xl font-display font-bold 
                        bg-gradient-to-br from-green-600 to-green-400 bg-clip-text text-transparent mb-1 leading-none">
                {{ $stats['lunas_bulan_ini'] }}
            </div>
            <div class="text-xs text-light-muted font-medium">Sudah Lunas</div>
        </div>

        <div class="panel-light" data-aos="fade-up" data-aos-delay="120">
            <div class="text-3xl font-display font-bold 
                        bg-gradient-to-br from-red-600 to-red-400 bg-clip-text text-transparent mb-1 leading-none">
                {{ $stats['belum_bulan_ini'] }}
            </div>
            <div class="text-xs text-light-muted font-medium">Belum Lunas</div>
        </div>

        <div class="panel-light" data-aos="fade-up" data-aos-delay="180">
            <div class="text-3xl font-display font-bold 
                        bg-gradient-to-br from-blue-600 to-blue-400 bg-clip-text text-transparent mb-1 leading-none">
                {{ $stats['total_anggota'] }}
            </div>
            <div class="text-xs text-light-muted font-medium">Total Anggota</div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="panel-light mb-6" data-aos="fade-up">
        <form method="GET" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / NIS..."
                   class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                          text-light-text placeholder-light-muted/70 focus:outline-none focus:bg-white
                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">

            <input type="month" name="periode" value="{{ request('periode', $periodeAktif) }}"
                   class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                          text-light-text focus:outline-none focus:bg-white
                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">

            <select name="status" class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                          text-light-text focus:outline-none focus:bg-white
                                          focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                <option value="">Semua Status</option>
                @foreach(\App\Enums\StatusKas::cases() as $s)
                    <option value="{{ $s->value }}" @selected(request('status') === $s->value)>{{ $s->label() }}</option>
                @endforeach
            </select>

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

            <div class="flex gap-2">
                <button type="submit" class="btn-gold btn-sm flex-1 justify-center">Filter</button>
                @if(request()->hasAny(['q', 'periode', 'status', 'cabang']))
                    <a href="{{ route('dashboard.cash') }}" class="btn-outline btn-sm justify-center">Reset</a>
                @endif
            </div>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="panel-light p-0 overflow-hidden" data-aos="fade-up">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-light-border bg-light-bg/50">
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Anggota</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4 hidden lg:table-cell">Cabang</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Kategori</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Periode</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Nominal</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Status</th>
                        <th class="text-right text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-light-border">
                    @forelse($payments as $p)
                        <tr class="hover:bg-light-hover transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl gradient-gold flex items-center justify-center
                                                font-display font-bold text-bg-primary text-sm shrink-0">
                                        {{ strtoupper(substr($p->user->nama_lengkap ?? '?', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium text-sm text-light-text truncate">
                                            {{ $p->user->nama_lengkap ?? '-' }}
                                        </p>
                                        <p class="text-xs text-light-muted truncate">
                                            {{ $p->user->nis ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 hidden lg:table-cell">
                                @if($p->user?->cabang)
                                    <span class="text-xs text-light-text">
                                        {{ $p->user->cabang->icon() }} {{ $p->user->cabang->shortLabel() }}
                                    </span>
                                @else
                                    <span class="text-xs text-light-muted">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-xs text-light-text">{{ $p->kategori->nama ?? '-' }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-xs text-light-muted font-mono">{{ $p->periode_bulan }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-sm font-semibold text-light-text">
                                    Rp {{ number_format($p->nominal, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @if($p->status === \App\Enums\StatusKas::LUNAS)
                                    <span class="text-[10px] px-2.5 py-1 rounded-full font-medium bg-green-100 text-green-700">
                                        ✓ Lunas
                                    </span>
                                @else
                                    <span class="text-[10px] px-2.5 py-1 rounded-full font-medium bg-red-100 text-red-700">
                                        Belum Lunas
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center justify-end gap-1">
                                    @if($p->status === \App\Enums\StatusKas::BELUM_LUNAS)
                                        <form action="{{ route('dashboard.cash.mark-paid', $p->id_pembayaran) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="p-2 rounded-lg hover:bg-green-50 text-light-muted 
                                                           hover:text-green-600 transition-colors"
                                                    title="Tandai Lunas">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    <button type="button"
                                            onclick="if(confirm('Hapus data kas ini?')) document.getElementById('del-{{ $p->id_pembayaran }}').submit()"
                                            class="p-2 rounded-lg hover:bg-red-50 text-light-muted 
                                                   hover:text-red-500 transition-colors"
                                            title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                    <form id="del-{{ $p->id_pembayaran }}" 
                                          action="{{ route('dashboard.cash.destroy', $p->id_pembayaran) }}" 
                                          method="POST" class="hidden">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                <div class="text-5xl mb-3">💰</div>
                                <p class="text-light-text font-medium mb-1">Belum ada data kas</p>
                                <p class="text-light-muted text-sm">Mulai input pembayaran kas anggota</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($payments->hasPages())
        <div class="mt-6">{{ $payments->links() }}</div>
    @endif

@endsection