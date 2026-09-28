@extends('layouts.dashboard')

@section('title', 'Laporan')
@section('subtitle', 'Statistik & export data organisasi')

@section('content')

    {{-- HERO --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative">
            <h2 class="text-2xl sm:text-3xl font-display font-bold mb-1 text-light-text">
                Laporan <span class="text-gold-dark">Organisasi</span>
            </h2>
            <p class="text-light-muted text-sm">
                Statistik lengkap & export data dalam PDF atau Excel
            </p>
        </div>
    </div>

    {{-- STATS OVERVIEW --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        @php
            $statCards = [
                ['label' => 'Total Anggota', 'value' => $stats['total_anggota'], 'sub' => $stats['anggota_aktif'] . ' aktif'],
                ['label' => 'Total Prestasi', 'value' => $stats['total_prestasi'], 'sub' => 'Sepanjang sejarah'],
                ['label' => 'Total Kegiatan', 'value' => $stats['total_kegiatan'], 'sub' => 'Semua jenis'],
                ['label' => 'Total Absensi', 'value' => $stats['total_absensi'], 'sub' => 'Semua kegiatan'],
                ['label' => 'Kas Bulan Ini', 'value' => 'Rp ' . number_format($stats['kas_bulan_ini'], 0, ',', '.'), 'sub' => now()->translatedFormat('F Y'), 'is_text' => true],
            ];
        @endphp

        @foreach($statCards as $i => $s)
            <div class="panel-light" data-aos="fade-up" data-aos-delay="{{ $i * 60 }}">
                <div class="{{ isset($s['is_text']) ? 'text-xl sm:text-2xl' : 'text-3xl' }} font-display font-bold 
                            bg-gradient-to-br from-gold-dark to-gold bg-clip-text text-transparent 
                            mb-1 leading-tight">
                    {{ $s['value'] }}
                </div>
                <div class="text-xs text-light-muted font-medium">{{ $s['label'] }}</div>
                <div class="text-[10px] text-light-muted/70 mt-0.5">{{ $s['sub'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- ═══════════════════════════════════════
         EXPORT DENGAN FILTER
         ═══════════════════════════════════════ --}}
    <div class="section-head-light mb-4" data-aos="fade-up">
        <div class="icon-badge-light-solid">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div>
            <h3 class="section-head-title-light">Export Laporan</h3>
            <p class="section-head-sub-light">Filter dulu, baru export PDF/Excel</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        {{-- ═══ EXPORT ANGGOTA ═══ --}}
        <div class="panel-light" data-aos="fade-up">
            <div class="flex items-center gap-3 mb-4">
                <div class="icon-badge-light-solid">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-display font-bold text-base text-light-text">Laporan Anggota</h3>
                    <p class="text-xs text-light-muted">Data lengkap anggota & pengurus</p>
                </div>
            </div>

            <form action="{{ route('dashboard.reports.members.export') }}" method="GET" class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-light-text mb-1.5">Role</label>
                    <select name="role" class="w-full px-3 py-2 rounded-xl text-sm
                                                bg-light-bg border border-light-border text-light-text
                                                focus:outline-none focus:bg-white
                                                focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        <option value="">Semua Role</option>
                        @foreach(\App\Enums\RoleUser::cases() as $r)
                            <option value="{{ $r->value }}">{{ $r->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-light-text mb-1.5">Status</label>
                    <select name="status" class="w-full px-3 py-2 rounded-xl text-sm
                                                  bg-light-bg border border-light-border text-light-text
                                                  focus:outline-none focus:bg-white
                                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        <option value="">Semua Status</option>
                        @foreach(\App\Enums\StatusAnggota::cases() as $s)
                            <option value="{{ $s->value }}">{{ $s->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-light-text mb-1.5">Cabang</label>
                    <select name="cabang" class="w-full px-3 py-2 rounded-xl text-sm
                                                  bg-light-bg border border-light-border text-light-text
                                                  focus:outline-none focus:bg-white
                                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        <option value="">Semua Cabang</option>
                        @foreach(\App\Enums\Cabang::cases() as $c)
                            <option value="{{ $c->value }}">{{ $c->icon() }} {{ $c->shortLabel() }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-2 pt-2">
                    <button type="submit" name="type" value="excel"
                            class="px-3 py-2 rounded-xl bg-green-100 hover:bg-green-200 
                                   text-green-700 text-xs font-semibold transition-colors
                                   flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Excel
                    </button>
                    <button type="submit" name="type" value="pdf" formtarget="_blank"
                            class="px-3 py-2 rounded-xl bg-red-100 hover:bg-red-200 
                                   text-red-700 text-xs font-semibold transition-colors
                                   flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        PDF
                    </button>
                </div>
            </form>
        </div>

        {{-- ═══ EXPORT KAS ═══ --}}
        <div class="panel-light" data-aos="fade-up" data-aos-delay="80">
            <div class="flex items-center gap-3 mb-4">
                <div class="icon-badge-light-solid">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-display font-bold text-base text-light-text">Laporan Kas</h3>
                    <p class="text-xs text-light-muted">Data pembayaran kas</p>
                </div>
            </div>

            <form action="{{ route('dashboard.reports.cash.export') }}" method="GET" class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-light-text mb-1.5">Periode Bulan</label>
                    <input type="month" name="periode"
                           class="w-full px-3 py-2 rounded-xl text-sm
                                  bg-light-bg border border-light-border text-light-text
                                  focus:outline-none focus:bg-white
                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    <p class="text-[10px] text-light-muted mt-1">Kosongkan untuk semua periode</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-light-text mb-1.5">Status</label>
                    <select name="status" class="w-full px-3 py-2 rounded-xl text-sm
                                                  bg-light-bg border border-light-border text-light-text
                                                  focus:outline-none focus:bg-white
                                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        <option value="">Semua Status</option>
                        <option value="lunas">Lunas</option>
                        <option value="belum_lunas">Belum Lunas</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-light-text mb-1.5">Cabang</label>
                    <select name="cabang" class="w-full px-3 py-2 rounded-xl text-sm
                                                  bg-light-bg border border-light-border text-light-text
                                                  focus:outline-none focus:bg-white
                                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        <option value="">Semua Cabang</option>
                        @foreach(\App\Enums\Cabang::cases() as $c)
                            <option value="{{ $c->value }}">{{ $c->icon() }} {{ $c->shortLabel() }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-2 pt-2">
                    <button type="submit" name="type" value="excel"
                            class="px-3 py-2 rounded-xl bg-green-100 hover:bg-green-200 
                                   text-green-700 text-xs font-semibold transition-colors
                                   flex items-center justify-center gap-1.5">
                        Excel
                    </button>
                    <button type="submit" name="type" value="pdf" formtarget="_blank"
                            class="px-3 py-2 rounded-xl bg-red-100 hover:bg-red-200 
                                   text-red-700 text-xs font-semibold transition-colors
                                   flex items-center justify-center gap-1.5">
                        PDF
                    </button>
                </div>
            </form>
        </div>

        {{-- ═══ EXPORT ABSENSI ═══ --}}
        <div class="panel-light" data-aos="fade-up" data-aos-delay="160">
            <div class="flex items-center gap-3 mb-4">
                <div class="icon-badge-light-solid">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-display font-bold text-base text-light-text">Laporan Absensi</h3>
                    <p class="text-xs text-light-muted">Rekap kehadiran anggota</p>
                </div>
            </div>

            <form action="{{ route('dashboard.reports.attendance.export') }}" method="GET" class="space-y-3">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-medium text-light-text mb-1.5">Dari</label>
                        <input type="date" name="dari"
                               class="w-full px-3 py-2 rounded-xl text-sm
                                      bg-light-bg border border-light-border text-light-text
                                      focus:outline-none focus:bg-white
                                      focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-light-text mb-1.5">Sampai</label>
                        <input type="date" name="sampai"
                               class="w-full px-3 py-2 rounded-xl text-sm
                                      bg-light-bg border border-light-border text-light-text
                                      focus:outline-none focus:bg-white
                                      focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-light-text mb-1.5">Cabang</label>
                    <select name="cabang" class="w-full px-3 py-2 rounded-xl text-sm
                                                  bg-light-bg border border-light-border text-light-text
                                                  focus:outline-none focus:bg-white
                                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        <option value="">Semua Cabang</option>
                        @foreach(\App\Enums\Cabang::cases() as $c)
                            <option value="{{ $c->value }}">{{ $c->icon() }} {{ $c->shortLabel() }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-2 pt-2">
                    <button type="submit" name="type" value="excel"
                            class="px-3 py-2 rounded-xl bg-green-100 hover:bg-green-200 
                                   text-green-700 text-xs font-semibold transition-colors">
                        Excel
                    </button>
                    <button type="submit" name="type" value="pdf" formtarget="_blank"
                            class="px-3 py-2 rounded-xl bg-red-100 hover:bg-red-200 
                                   text-red-700 text-xs font-semibold transition-colors">
                        PDF
                    </button>
                </div>
            </form>
        </div>

        {{-- ═══ EXPORT PRESTASI ═══ --}}
        <div class="panel-light" data-aos="fade-up" data-aos-delay="240">
            <div class="flex items-center gap-3 mb-4">
                <div class="icon-badge-light-solid">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-display font-bold text-base text-light-text">Laporan Prestasi</h3>
                    <p class="text-xs text-light-muted">Data prestasi & peserta</p>
                </div>
            </div>

            <form action="{{ route('dashboard.reports.achievements.export') }}" method="GET" class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-light-text mb-1.5">Tingkat</label>
                    <select name="tingkat" class="w-full px-3 py-2 rounded-xl text-sm
                                                  bg-light-bg border border-light-border text-light-text
                                                  focus:outline-none focus:bg-white
                                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                        <option value="">Semua Tingkat</option>
                        @foreach(\App\Enums\TingkatPrestasi::cases() as $t)
                            <option value="{{ $t->value }}">{{ $t->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-light-text mb-1.5">Tahun</label>
                    <input type="number" name="tahun" placeholder="Contoh: 2025"
                           min="2000" max="{{ date('Y') + 1 }}"
                           class="w-full px-3 py-2 rounded-xl text-sm
                                  bg-light-bg border border-light-border text-light-text
                                  placeholder-light-muted/70 focus:outline-none focus:bg-white
                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                </div>

                <div class="grid grid-cols-2 gap-2 pt-2">
                    <button type="submit" name="type" value="excel"
                            class="px-3 py-2 rounded-xl bg-green-100 hover:bg-green-200 
                                   text-green-700 text-xs font-semibold transition-colors">
                        Excel
                    </button>
                    <button type="submit" name="type" value="pdf" formtarget="_blank"
                            class="px-3 py-2 rounded-xl bg-red-100 hover:bg-red-200 
                                   text-red-700 text-xs font-semibold transition-colors">
                        PDF
                    </button>
                </div>
            </form>
        </div>

    </div>

    {{-- CHART STATISTIK --}}
    <div class="grid lg:grid-cols-2 gap-4" data-aos="fade-up">
        <div class="panel-light">
            <div class="section-head-light">
                <div class="icon-badge-light">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="section-head-title-light">Anggota per Cabang</h3>
                </div>
            </div>

            <div class="space-y-3">
                @foreach(\App\Enums\Cabang::cases() as $cab)
                    @php
                        $total = $anggotaPerCabang[$cab->value] ?? 0;
                        $persen = $stats['anggota_aktif'] > 0 ? ($total / $stats['anggota_aktif']) * 100 : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm font-medium text-light-text">
                                {{ $cab->icon() }} {{ $cab->shortLabel() }}
                            </span>
                            <span class="text-xs text-light-muted">
                                {{ $total }} ({{ round($persen, 1) }}%)
                            </span>
                        </div>
                        <div class="h-2 bg-light-bg rounded-full overflow-hidden">
                            <div class="h-full gradient-gold rounded-full transition-all duration-1000" 
                                 style="width: {{ $persen }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="panel-light">
            <div class="section-head-light">
                <div class="icon-badge-light">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="section-head-title-light">Prestasi per Tingkat</h3>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                @foreach(\App\Enums\TingkatPrestasi::cases() as $t)
                    <div class="p-4 rounded-2xl bg-light-bg border border-light-border text-center">
                        <div class="text-3xl font-display font-bold 
                                    bg-gradient-to-br from-gold-dark to-gold bg-clip-text text-transparent 
                                    mb-1 leading-none">
                            {{ $prestasiPerTingkat[$t->value] ?? 0 }}
                        </div>
                        <div class="text-xs text-light-muted font-medium">{{ $t->shortLabel() }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection