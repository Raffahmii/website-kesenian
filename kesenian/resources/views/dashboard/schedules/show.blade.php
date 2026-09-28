@extends('layouts.dashboard')

@section('title', $schedule->judul)
@section('subtitle', 'Detail jadwal & rekap absensi')

@section('content')

    {{-- BREADCRUMB --}}
    <div class="mb-6 flex items-center justify-between" data-aos="fade-up">
        <a href="{{ route('dashboard.events.index') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>

        @can('manage-events')
            <a href="{{ route('dashboard.events.edit', $schedule->id_jadwal) }}" class="btn-gold btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
        @endcan
    </div>

    {{-- HERO JADWAL --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative flex flex-col md:flex-row md:items-center gap-6">
            {{-- Date Block --}}
            <div class="shrink-0">
                <div class="w-24 h-24 rounded-3xl gradient-gold shadow-lg shadow-gold/30
                            flex flex-col items-center justify-center">
                    <span class="text-3xl font-display font-bold text-bg-primary leading-none">
                        {{ \Carbon\Carbon::parse($schedule->tanggal)->format('d') }}
                    </span>
                    <span class="text-[10px] uppercase tracking-wider text-bg-primary/80 font-semibold mt-1">
                        {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('M Y') }}
                    </span>
                </div>
            </div>

            {{-- Content --}}
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2 flex-wrap">
                    <span class="badge-gold text-[10px]">
                        {{ $schedule->jenis->icon() }} {{ $schedule->jenis->label() }}
                    </span>
                </div>

                <h1 class="font-display font-bold text-2xl md:text-3xl text-light-text mb-3 leading-tight">
                    {{ $schedule->judul }}
                </h1>

                @if($schedule->deskripsi)
                    <p class="text-light-muted text-sm leading-relaxed mb-3">{{ $schedule->deskripsi }}</p>
                @endif

                <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm text-light-muted">
                    @if($schedule->jam_mulai)
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }}
                            @if($schedule->jam_selesai)
                                - {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                            @endif
                        </span>
                    @endif
                    @if($schedule->lokasi)
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $schedule->lokasi }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Action --}}
            @can('manage-members')
                <div class="shrink-0">
                    <a href="{{ route('dashboard.attendance.input', $schedule->id_jadwal) }}" 
                       class="btn-gold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        Input Absensi
                    </a>
                </div>
            @endcan
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        @php
            $statCards = [
                ['label' => 'Total Absen', 'value' => $stats['total'], 'color' => 'gray'],
                ['label' => 'Hadir', 'value' => $stats['hadir'], 'color' => 'green'],
                ['label' => 'Izin', 'value' => $stats['izin'], 'color' => 'yellow'],
                ['label' => 'Sakit', 'value' => $stats['sakit'], 'color' => 'blue'],
                ['label' => 'Alpa', 'value' => $stats['alpa'], 'color' => 'red'],
            ];
        @endphp

        @foreach($statCards as $i => $stat)
            <div class="panel-light" data-aos="fade-up" data-aos-delay="{{ $i * 50 }}">
                <div class="text-3xl font-display font-bold 
                            bg-gradient-to-br from-gold-dark to-gold bg-clip-text text-transparent 
                            mb-1 leading-none">
                    {{ $stat['value'] }}
                </div>
                <div class="text-xs text-light-muted font-medium">{{ $stat['label'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- STATS PER CABANG --}}
    <div class="panel-light mb-6" data-aos="fade-up">
        <div class="section-head-light">
            <div class="icon-badge-light">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="section-head-title-light">Rekap per Cabang</h3>
                <p class="section-head-sub-light">Status absensi setiap divisi</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            @foreach($cabangStats as $key => $cs)
                <a href="{{ route('dashboard.attendance.input', ['schedule' => $schedule->id_jadwal, 'cabang' => $key]) }}"
                   class="p-4 rounded-2xl bg-light-bg hover:bg-gold/[0.06] 
                          border border-transparent hover:border-gold/20
                          transition-all text-center group
                          {{ $isPengurus ?? false ? '' : 'cursor-default' }}">
                    <div class="text-2xl mb-1">{{ $cs['icon'] }}</div>
                    <div class="text-xs font-semibold text-light-text group-hover:text-gold-dark transition-colors">
                        {{ $cs['label'] }}
                    </div>
                    <div class="text-[10px] text-light-muted mt-1">
                        <span class="text-green-600 font-semibold">{{ $cs['hadir'] }}</span> / {{ $cs['total'] }} hadir
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- LIST ABSENSI --}}
    <div class="panel-light" data-aos="fade-up">
        <div class="section-head-light">
            <div class="icon-badge-light">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <h3 class="section-head-title-light">Daftar Absensi</h3>
                <p class="section-head-sub-light">{{ $absensi->count() }} anggota tercatat</p>
            </div>
        </div>

        @if($absensi->isNotEmpty())
            <div class="overflow-x-auto -mx-5 sm:-mx-6">
                <table class="w-full">
                    <thead>
                        <tr class="border-y border-light-border bg-light-bg/50">
                            <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-5">Anggota</th>
                            <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-5">Cabang</th>
                            <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-5">Status</th>
                            <th class="text-left text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-5 hidden md:table-cell">Keterangan</th>
                            @can('manage-members')
                                <th class="text-right text-[11px] uppercase tracking-wider text-light-muted font-semibold py-3 px-5">Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-light-border">
                        @foreach($absensi as $a)
                            <tr class="hover:bg-light-hover transition-colors">
                                <td class="py-3 px-5">
                                    <div class="flex items-center gap-3">
                                        @if($a->user?->photo)
                                            <img src="{{ asset('storage/' . $a->user->photo) }}" 
                                                 class="w-9 h-9 rounded-xl object-cover">
                                        @else
                                            <div class="w-9 h-9 rounded-xl gradient-gold flex items-center justify-center
                                                        font-display font-bold text-bg-primary text-sm">
                                                {{ strtoupper(substr($a->user->nama_lengkap ?? '?', 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="font-medium text-sm text-light-text truncate">
                                                {{ $a->user->nama_lengkap ?? 'User dihapus' }}
                                            </p>
                                            <p class="text-xs text-light-muted truncate">
                                                {{ $a->user->kelas ?? '' }} {{ $a->user->jurusan ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-5">
                                    @if($a->user?->cabang)
                                        <span class="text-xs text-light-text">
                                            {{ $a->user->cabang->icon() }} {{ $a->user->cabang->shortLabel() }}
                                        </span>
                                    @else
                                        <span class="text-xs text-light-muted">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-5">
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
                                <td class="py-3 px-5 hidden md:table-cell">
                                    <p class="text-xs text-light-muted">
                                        {{ $a->keterangan ?: '-' }}
                                    </p>
                                </td>
                                @can('manage-members')
                                    <td class="py-3 px-5 text-right">
                                        <button 
                                            type="button"
                                            onclick="if(confirm('Hapus absensi ini?')) document.getElementById('del-{{ $a->id_absensi }}').submit()"
                                            class="p-2 rounded-lg hover:bg-red-50 text-light-muted hover:text-red-500 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                        <form id="del-{{ $a->id_absensi }}" 
                                              action="{{ route('dashboard.attendance.destroy', $a->id_absensi) }}" 
                                              method="POST" class="hidden">
                                            @csrf @method('DELETE')
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-5xl mb-3 opacity-50">📋</div>
                <p class="text-light-text font-medium mb-1">Belum ada absensi</p>
                <p class="text-light-muted text-sm mb-4">Mulai input absensi untuk kegiatan ini</p>
                @can('manage-members')
                    <a href="{{ route('dashboard.attendance.input', $schedule->id_jadwal) }}" class="btn-gold inline-flex">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Input Absensi
                    </a>
                @endcan
            </div>
        @endif
    </div>

@endsection