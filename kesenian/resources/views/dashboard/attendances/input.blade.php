@extends('layouts.dashboard')

@section('title', 'Input Absensi')
@section('subtitle', 'Input absensi: ' . $schedule->judul)

@section('content')

    {{-- BREADCRUMB --}}
    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('dashboard.events.show', $schedule->id_jadwal) }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Detail Jadwal
        </a>
    </div>

    {{-- HERO --}}
    <div class="panel-light-gold mb-6" data-aos="fade-up">
        <div class="relative">
            <div class="flex items-center gap-2 mb-2">
                <span class="badge-gold text-[10px]">{{ $schedule->jenis->icon() }} {{ $schedule->jenis->label() }}</span>
                <span class="text-xs text-light-muted">
                    {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('l, d F Y') }}
                </span>
            </div>
            <h2 class="font-display font-bold text-2xl text-light-text mb-1">
                Input Absensi — {{ $schedule->judul }}
            </h2>
            <p class="text-light-muted text-sm">
                Pilih cabang, lalu isi status kehadiran setiap anggota.
            </p>
        </div>
    </div>

    {{-- CABANG SELECTOR — TABS --}}
    <div class="panel-light mb-6" data-aos="fade-up">
        <div class="section-head-light">
            <div class="icon-badge-light">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div>
                <h3 class="section-head-title-light">Pilih Cabang</h3>
                <p class="section-head-sub-light">Klik cabang untuk input absensi</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            @foreach(\App\Enums\Cabang::cases() as $cab)
                <a href="{{ route('dashboard.attendance.input', ['schedule' => $schedule->id_jadwal, 'cabang' => $cab->value]) }}"
                   class="p-4 rounded-2xl text-center transition-all
                          {{ $cabangAktif === $cab->value 
                              ? 'bg-gradient-to-br from-gold to-gold-hover text-bg-primary shadow-lg shadow-gold/30' 
                              : 'bg-light-bg hover:bg-gold/[0.06] text-light-text border border-transparent hover:border-gold/20' }}">
                    <div class="text-2xl mb-1">{{ $cab->icon() }}</div>
                    <div class="text-xs font-semibold">{{ $cab->shortLabel() }}</div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- FORM ABSENSI --}}
    @if($members->isEmpty())
        <div class="panel-light text-center py-16" data-aos="fade-up">
            <div class="text-5xl mb-3 opacity-50">👥</div>
            <p class="text-light-text font-medium mb-1">Belum ada anggota di cabang ini</p>
            <p class="text-light-muted text-sm">Tambahkan anggota dengan cabang {{ \App\Enums\Cabang::from($cabangAktif)->shortLabel() }}</p>
        </div>
    @else
        <form method="POST" action="{{ route('dashboard.attendance.bulk-store', $schedule->id_jadwal) }}" data-aos="fade-up">
            @csrf
            <input type="hidden" name="cabang" value="{{ $cabangAktif }}">

            <div class="panel-light mb-6">
                <div class="section-head-light">
                    <div class="icon-badge-light">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="section-head-title-light">
                            {{ \App\Enums\Cabang::from($cabangAktif)->icon() }} 
                            {{ \App\Enums\Cabang::from($cabangAktif)->label() }}
                        </h3>
                        <p class="section-head-sub-light">{{ $members->count() }} anggota terdaftar</p>
                    </div>
                </div>

                {{-- QUICK ACTION --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    <button type="button" 
                            onclick="setAllStatus('hadir')"
                            class="text-xs px-3 py-1.5 rounded-lg bg-green-100 hover:bg-green-200 text-green-700 font-medium transition-colors">
                        ✅ Semua Hadir
                    </button>
                    <button type="button" 
                            onclick="setAllStatus('alpa')"
                            class="text-xs px-3 py-1.5 rounded-lg bg-red-100 hover:bg-red-200 text-red-700 font-medium transition-colors">
                        ❌ Semua Alpa
                    </button>
                    <button type="button" 
                            onclick="resetAll()"
                            class="text-xs px-3 py-1.5 rounded-lg bg-light-bg hover:bg-light-hover text-light-muted font-medium transition-colors">
                        ↺ Reset
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach($members as $i => $member)
                        @php
                            $existingRow = $existing->get($member->id_user);
                            $currentStatus = old("attendance.{$i}.status", $existingRow?->status->value ?? 'hadir');
                            $currentKet = old("attendance.{$i}.keterangan", $existingRow?->keterangan ?? '');
                        @endphp
                        <div class="p-4 rounded-2xl bg-light-bg border border-light-border 
                                    hover:border-gold/30 transition-colors">
                            <input type="hidden" name="attendance[{{ $i }}][id_user]" value="{{ $member->id_user }}">

                            <div class="flex flex-col md:flex-row md:items-center gap-4">

                                {{-- Avatar + Nama --}}
                                <div class="flex items-center gap-3 md:w-1/3">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/' . $member->photo) }}" 
                                             class="w-10 h-10 rounded-xl object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-xl gradient-gold flex items-center justify-center
                                                    font-display font-bold text-bg-primary shrink-0">
                                            {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-medium text-sm text-light-text truncate">
                                            {{ $member->nama_lengkap }}
                                        </p>
                                        <p class="text-xs text-light-muted truncate">
                                            {{ $member->kelas }} {{ $member->jurusan }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="grid grid-cols-4 gap-2 md:w-1/3">
                                    @foreach(\App\Enums\StatusAbsensi::cases() as $status)
                                        @php
                                            $color = match($status->value) {
                                                'hadir' => 'peer-checked:bg-green-500 peer-checked:text-white peer-checked:border-green-500',
                                                'izin'  => 'peer-checked:bg-yellow-500 peer-checked:text-white peer-checked:border-yellow-500',
                                                'sakit' => 'peer-checked:bg-blue-500 peer-checked:text-white peer-checked:border-blue-500',
                                                'alpa'  => 'peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-500',
                                            };
                                            $short = match($status->value) {
                                                'hadir' => 'H',
                                                'izin'  => 'I',
                                                'sakit' => 'S',
                                                'alpa'  => 'A',
                                            };
                                        @endphp
                                        <label class="cursor-pointer">
                                            <input 
                                                type="radio" 
                                                name="attendance[{{ $i }}][status]" 
                                                value="{{ $status->value }}"
                                                class="peer sr-only"
                                                {{ $currentStatus === $status->value ? 'checked' : '' }}
                                                data-row="{{ $i }}"
                                                onchange="updateRowColor({{ $i }})"
                                            >
                                            <div class="text-center py-2 rounded-lg border-2 border-light-border
                                                        bg-white text-light-muted text-xs font-bold
                                                        hover:border-gold/40 transition-all
                                                        {{ $color }}"
                                                 title="{{ $status->label() }}">
                                                {{ $short }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                {{-- Keterangan --}}
                                <div class="md:w-1/3">
                                    <input 
                                        type="text"
                                        name="attendance[{{ $i }}][keterangan]"
                                        value="{{ $currentKet }}"
                                        placeholder="Keterangan (opsional)..."
                                        class="w-full px-3 py-2 rounded-lg text-xs
                                               bg-white border border-light-border text-light-text
                                               placeholder-light-muted/50 focus:outline-none
                                               focus:border-gold/50 focus:ring-2 focus:ring-gold/20"
                                    >
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- SUBMIT --}}
            <div class="panel-light">
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="btn-gold flex-1 justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Absensi Cabang Ini
                    </button>
                    <a href="{{ route('dashboard.events.show', $schedule->id_jadwal) }}" 
                       class="px-6 py-2.5 rounded-xl border border-light-border
                              text-light-muted hover:bg-light-bg text-center
                              font-medium text-sm transition-colors">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    @endif

    <script>
        function setAllStatus(status) {
            document.querySelectorAll('input[type="radio"][value="' + status + '"]').forEach(radio => {
                radio.checked = true;
                updateRowColor(radio.dataset.row);
            });
        }

        function resetAll() {
            // Set semua ke hadir sebagai default
            document.querySelectorAll('input[type="radio"][value="hadir"]').forEach(radio => {
                radio.checked = true;
                updateRowColor(radio.dataset.row);
            });
            // Clear keterangan
            document.querySelectorAll('input[name$="[keterangan]"]').forEach(input => input.value = '');
        }

        function updateRowColor(row) {
            // Remove all background colors from this row's status buttons
            const radios = document.querySelectorAll('input[name="attendance[' + row + '][status]"]');
            radios.forEach(r => {
                const div = r.nextElementSibling;
                div.classList.remove('bg-green-500','bg-yellow-500','bg-blue-500','bg-red-500','text-white');
            });
        }
    </script>

@endsection