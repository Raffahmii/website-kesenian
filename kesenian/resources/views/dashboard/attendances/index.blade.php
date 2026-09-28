@extends('layouts.dashboard')

@section('title', 'Absensi')
@section('subtitle', $isPengurus ? 'Rekap absensi organisasi' : 'Riwayat absensi pribadi')

@section('content')

    @if($isPengurus)

        {{-- ═══════════════════════════════════════
             PENGURUS VIEW
             ═══════════════════════════════════════ --}}
        <div class="panel-light-gold mb-6" data-aos="fade-up">
            <div class="relative">
                <h2 class="text-2xl sm:text-3xl font-display font-bold mb-1 text-light-text">
                    Rekap <span class="text-gold-dark">Absensi</span>
                </h2>
                <p class="text-light-muted text-sm">
                    Total {{ $stats['total'] }} absensi tercatat
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @php
                $statCards = [
                    ['label' => 'Total', 'value' => $stats['total']],
                    ['label' => 'Hadir', 'value' => $stats['hadir']],
                    ['label' => 'Izin', 'value' => $stats['izin']],
                    ['label' => 'Alpa', 'value' => $stats['alpa']],
                ];
            @endphp

            @foreach($statCards as $i => $s)
                <div class="panel-light" data-aos="fade-up" data-aos-delay="{{ $i * 60 }}">
                    <div class="text-3xl font-display font-bold 
                                bg-gradient-to-br from-gold-dark to-gold bg-clip-text text-transparent 
                                mb-1 leading-none">
                        {{ $s['value'] }}
                    </div>
                    <div class="text-xs text-light-muted font-medium">{{ $s['label'] }}</div>
                </div>
            @endforeach
        </div>

        {{-- FILTER --}}
        <div class="panel-light mb-6" data-aos="fade-up">
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="relative">
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Cari nama anggota..."
                           class="w-full pl-4 pr-4 py-2.5 rounded-xl text-sm
                                  bg-light-bg border border-light-border text-light-text
                                  placeholder-light-muted/70 focus:outline-none focus:bg-white
                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                </div>

                <select name="jadwal" class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                              text-light-text focus:outline-none focus:bg-white
                                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    <option value="">Semua Jadwal</option>
                    @foreach(\App\Models\JadwalKegiatan::orderByDesc('tanggal')->limit(50)->get() as $jad)
                        <option value="{{ $jad->id_jadwal }}" @selected(request('jadwal') == $jad->id_jadwal)>
                            {{ $jad->judul }}
                        </option>
                    @endforeach
                </select>

                <select name="status" class="px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                                              text-light-text focus:outline-none focus:bg-white
                                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    <option value="">Semua Status</option>
                    @foreach(\App\Enums\StatusAbsensi::cases() as $st)
                        <option value="{{ $st->value }}" @selected(request('status') === $st->value)>
                            {{ $st->label() }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn-gold btn-sm justify-center">Filter</button>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="panel-light p-0 overflow-hidden" data-aos="fade-up">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-light-border bg-light-bg/50">
                            <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Anggota</th>
                            <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4 hidden md:table-cell">Kegiatan</th>
                            <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4">Status</th>
                            <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-4 hidden lg:table-cell">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-light-border">
                        @forelse($attendances as $a)
                            <tr class="hover:bg-light-hover transition-colors">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl gradient-gold flex items-center justify-center
                                                    font-display font-bold text-bg-primary text-sm shrink-0">
                                            {{ strtoupper(substr($a->user->nama_lengkap ?? '?', 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium text-sm text-light-text truncate">{{ $a->user->nama_lengkap ?? '-' }}</p>
                                            @if($a->user?->cabang)
                                                <p class="text-xs text-light-muted">
                                                    {{ $a->user->cabang->icon() }} {{ $a->user->cabang->shortLabel() }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 hidden md:table-cell">
                                    <a href="{{ route('dashboard.events.show', $a->id_jadwal) }}" 
                                       class="text-xs text-light-text hover:text-gold-dark transition-colors">
                                        {{ $a->jadwal->judul ?? '-' }}
                                    </a>
                                    <p class="text-[10px] text-light-muted">
                                        {{ \Carbon\Carbon::parse($a->jadwal->tanggal ?? now())->format('d M Y') }}
                                    </p>
                                </td>
                                <td class="py-3 px-4">
                                    @php
                                        $statusClass = match($a->status) {
                                            \App\Enums\StatusAbsensi::HADIR => 'bg-green-100 text-green-700',
                                            \App\Enums\StatusAbsensi::IZIN  => 'bg-yellow-100 text-yellow-700',
                                            \App\Enums\StatusAbsensi::SAKIT => 'bg-blue-100 text-blue-700',
                                            \App\Enums\StatusAbsensi::ALPA  => 'bg-red-100 text-red-700',
                                        };
                                    @endphp
                                    <span class="text-[10px] px-2.5 py-1 rounded-full font-medium {{ $statusClass }}">
                                        {{ $a->status->label() }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 hidden lg:table-cell">
                                    <p class="text-xs text-light-muted">
                                        {{ $a->created_at?->format('d M Y, H:i') }}
                                    </p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-16 text-center">
                                    <div class="text-5xl mb-3 opacity-50">📋</div>
                                    <p class="text-light-text font-medium mb-1">Belum ada absensi</p>
                                    <p class="text-light-muted text-sm">Absensi akan muncul setelah diinput oleh sekretaris</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($attendances->hasPages())
            <div class="mt-6">{{ $attendances->links() }}</div>
        @endif

    @else

        {{-- ═══════════════════════════════════════
             ANGGOTA VIEW — Riwayat pribadi
             ═══════════════════════════════════════ --}}
        <div class="panel-light-gold mb-6" data-aos="fade-up">
            <div class="relative">
                <h2 class="text-2xl sm:text-3xl font-display font-bold mb-1 text-light-text">
                    Absensi <span class="text-gold-dark">Saya</span>
                </h2>
                <p class="text-light-muted text-sm">
                    Total {{ $myStats['total'] }} pertemuan · Kehadiran {{ $myStats['persentase'] }}%
                </p>
            </div>
        </div>

        {{-- STATS PRIBADI --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
            @php
                $statCards = [
                    ['label' => 'Total', 'value' => $myStats['total']],
                    ['label' => 'Hadir', 'value' => $myStats['hadir']],
                    ['label' => 'Izin', 'value' => $myStats['izin']],
                    ['label' => 'Sakit', 'value' => $myStats['sakit']],
                    ['label' => 'Alpa', 'value' => $myStats['alpa']],
                ];
            @endphp

            @foreach($statCards as $i => $s)
                <div class="panel-light" data-aos="fade-up" data-aos-delay="{{ $i * 60 }}">
                    <div class="text-3xl font-display font-bold 
                                bg-gradient-to-br from-gold-dark to-gold bg-clip-text text-transparent 
                                mb-1 leading-none">
                        {{ $s['value'] }}
                    </div>
                    <div class="text-xs text-light-muted font-medium">{{ $s['label'] }}</div>
                </div>
            @endforeach
        </div>

        {{-- PROGRESS --}}
        <div class="panel-light mb-6" data-aos="fade-up">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h3 class="font-display font-bold text-light-text">Persentase Kehadiran</h3>
                    <p class="text-xs text-light-muted">Berdasarkan total pertemuan yang tercatat</p>
                </div>
                <div class="text-3xl font-display font-bold text-gold-dark">
                    {{ $myStats['persentase'] }}%
                </div>
            </div>
            <div class="h-3 bg-light-bg rounded-full overflow-hidden">
                <div class="h-full gradient-gold rounded-full transition-all duration-1000" 
                     style="width: {{ $myStats['persentase'] }}%"></div>
            </div>
        </div>

        {{-- RIWAYAT --}}
        <div class="panel-light" data-aos="fade-up">
            <div class="section-head-light">
                <div class="icon-badge-light">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="section-head-title-light">Riwayat Kehadiran</h3>
                    <p class="section-head-sub-light">Semua pertemuan yang kamu ikuti</p>
                </div>
            </div>

            <div class="space-y-2">
                @forelse($myAttendances as $a)
                    @php
                        $statusClass = match($a->status) {
                            \App\Enums\StatusAbsensi::HADIR => 'bg-green-100 text-green-700',
                            \App\Enums\StatusAbsensi::IZIN  => 'bg-yellow-100 text-yellow-700',
                            \App\Enums\StatusAbsensi::SAKIT => 'bg-blue-100 text-blue-700',
                            \App\Enums\StatusAbsensi::ALPA  => 'bg-red-100 text-red-700',
                        };
                    @endphp
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-light-bg 
                                hover:bg-light-hover transition-colors">
                        <div class="shrink-0">
                            <div class="w-12 h-12 rounded-xl bg-white border border-light-border
                                        flex flex-col items-center justify-center">
                                <span class="text-base font-display font-bold text-light-text leading-none">
                                    {{ \Carbon\Carbon::parse($a->jadwal->tanggal ?? now())->format('d') }}
                                </span>
                                <span class="text-[9px] uppercase text-light-muted">
                                    {{ \Carbon\Carbon::parse($a->jadwal->tanggal ?? now())->translatedFormat('M') }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-sm text-light-text truncate">
                                {{ $a->jadwal->judul ?? '-' }}
                            </p>
                            <p class="text-xs text-light-muted">
                                {{ $a->jadwal->jenis->label() ?? '' }}
                                @if($a->keterangan)
                                    · {{ $a->keterangan }}
                                @endif
                            </p>
                        </div>
                        <span class="text-[10px] px-2.5 py-1 rounded-full font-medium {{ $statusClass }} shrink-0">
                            {{ $a->status->label() }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="text-5xl mb-3 opacity-50">📋</div>
                        <p class="text-light-text font-medium mb-1">Belum ada riwayat absensi</p>
                        <p class="text-light-muted text-sm">Riwayat akan muncul setelah kamu mengikuti kegiatan</p>
                    </div>
                @endforelse
            </div>
        </div>

        @if($myAttendances->hasPages())
            <div class="mt-6">{{ $myAttendances->links() }}</div>
        @endif

    @endif

@endsection