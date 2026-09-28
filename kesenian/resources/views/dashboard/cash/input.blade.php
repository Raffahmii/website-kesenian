@extends('layouts.dashboard')

@section('title', 'Input Kas')
@section('subtitle', 'Input pembayaran kas massal per cabang')

@section('content')

    <div class="mb-6" data-aos="fade-up">
        <a href="{{ route('dashboard.cash') }}" 
           class="inline-flex items-center gap-2 text-sm text-light-muted 
                  hover:text-gold-dark transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Kas
        </a>
    </div>

    {{-- CONFIG PERIODE & KATEGORI --}}
    <div class="panel-light mb-6" data-aos="fade-up">
        <div class="section-head-light">
            <div class="icon-badge-light">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="section-head-title-light">Konfigurasi</h3>
                <p class="section-head-sub-light">Periode & kategori kas</p>
            </div>
        </div>

        <form method="GET" class="grid sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-medium text-light-text mb-2">Periode Bulan</label>
                <input type="month" name="periode" value="{{ $periode }}"
                       class="w-full px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                              text-light-text focus:outline-none focus:bg-white
                              focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
            </div>
            <div>
                <label class="block text-xs font-medium text-light-text mb-2">Kategori Kas</label>
                <select name="kategori" 
                        onchange="this.form.submit()"
                        class="w-full px-4 py-2.5 rounded-xl text-sm bg-light-bg border border-light-border
                               text-light-text focus:outline-none focus:bg-white
                               focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}" @selected($kategoriAktif?->id_kategori == $k->id_kategori)>
                            {{ $k->nama }} — Rp {{ number_format($k->nominal, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    {{-- CABANG SELECTOR --}}
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
                <p class="section-head-sub-light">Input kas per cabang</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            @foreach(\App\Enums\Cabang::cases() as $c)
                <a href="{{ route('dashboard.cash.input', ['periode' => $periode, 'kategori' => $kategoriAktif?->id_kategori, 'cabang' => $c->value]) }}"
                   class="p-4 rounded-2xl text-center transition-all
                          {{ $cabangAktif === $c->value 
                              ? 'bg-gradient-to-br from-gold to-gold-hover text-bg-primary shadow-lg shadow-gold/30' 
                              : 'bg-light-bg hover:bg-gold/[0.06] text-light-text border border-transparent hover:border-gold/20' }}">
                    <div class="text-2xl mb-1">{{ $c->icon() }}</div>
                    <div class="text-xs font-semibold">{{ $c->shortLabel() }}</div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- FORM INPUT --}}
    @if(!$kategoriAktif)
        <div class="panel-light text-center py-16" data-aos="fade-up">
            <div class="text-5xl mb-3 opacity-50">💰</div>
            <p class="text-light-text font-medium mb-1">Belum ada kategori kas</p>
            <p class="text-light-muted text-sm mb-4">Tambah kategori dulu sebelum input</p>
            <a href="{{ route('dashboard.cash.categories') }}" class="btn-gold inline-flex">
                Kelola Kategori
            </a>
        </div>
    @elseif($members->isEmpty())
        <div class="panel-light text-center py-16" data-aos="fade-up">
            <div class="text-5xl mb-3 opacity-50">👥</div>
            <p class="text-light-text font-medium mb-1">Belum ada anggota di cabang ini</p>
            <p class="text-light-muted text-sm">Tambahkan anggota dengan cabang {{ \App\Enums\Cabang::from($cabangAktif)->shortLabel() }}</p>
        </div>
    @else
        <form method="POST" action="{{ route('dashboard.cash.bulk-store') }}" data-aos="fade-up">
            @csrf
            <input type="hidden" name="periode_bulan" value="{{ $periode }}">
            <input type="hidden" name="id_kategori" value="{{ $kategoriAktif->id_kategori }}">
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
                        <p class="section-head-sub-light">
                            {{ $members->count() }} anggota · {{ $kategoriAktif->nama }} · Rp {{ number_format($kategoriAktif->nominal, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- Quick action --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    <button type="button" onclick="setAllLunas()"
                            class="text-xs px-3 py-1.5 rounded-lg bg-green-100 hover:bg-green-200 
                                   text-green-700 font-medium transition-colors">
                        ✓ Semua Lunas
                    </button>
                    <button type="button" onclick="setAllBelum()"
                            class="text-xs px-3 py-1.5 rounded-lg bg-red-100 hover:bg-red-200 
                                   text-red-700 font-medium transition-colors">
                        ✗ Semua Belum Lunas
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach($members as $i => $member)
                        @php
                            $existingRow = $existing->get($member->id_user);
                            $currentStatus = old("payments.{$i}.status", $existingRow?->status->value ?? 'lunas');
                            $currentNominal = old("payments.{$i}.nominal", $existingRow?->nominal ?? $kategoriAktif->nominal);
                        @endphp
                        <div class="p-4 rounded-2xl bg-light-bg border border-light-border 
                                    hover:border-gold/30 transition-colors">
                            <input type="hidden" name="payments[{{ $i }}][id_user]" value="{{ $member->id_user }}">

                            <div class="flex flex-col md:flex-row md:items-center gap-4">

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

                                <div class="grid grid-cols-2 gap-2 md:w-1/3">
                                    @foreach(\App\Enums\StatusKas::cases() as $status)
                                        <label class="cursor-pointer">
                                            <input type="radio" 
                                                   name="payments[{{ $i }}][status]" 
                                                   value="{{ $status->value }}"
                                                   class="peer sr-only"
                                                   {{ $currentStatus === $status->value ? 'checked' : '' }}>
                                            <div class="text-center py-2 rounded-lg border-2 border-light-border
                                                        bg-white text-light-muted text-xs font-semibold
                                                        transition-all
                                                        {{ $status->value === 'lunas' 
                                                            ? 'peer-checked:bg-green-500 peer-checked:text-white peer-checked:border-green-500' 
                                                            : 'peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-500' }}">
                                                {{ $status->label() }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="md:w-1/3">
                                    <input type="number" 
                                           name="payments[{{ $i }}][nominal]"
                                           value="{{ $currentNominal }}"
                                           min="0"
                                           step="1000"
                                           placeholder="Nominal"
                                           class="w-full px-3 py-2 rounded-lg text-xs
                                                  bg-white border border-light-border text-light-text
                                                  placeholder-light-muted/50 focus:outline-none
                                                  focus:border-gold/50 focus:ring-2 focus:ring-gold/20">
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="panel-light">
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="btn-gold flex-1 justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Kas Cabang Ini
                    </button>
                    <a href="{{ route('dashboard.cash') }}" 
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
        function setAllLunas() {
            document.querySelectorAll('input[type="radio"][value="lunas"]').forEach(r => r.checked = true);
        }
        function setAllBelum() {
            document.querySelectorAll('input[type="radio"][value="belum_lunas"]').forEach(r => r.checked = true);
        }
    </script>

@endsection