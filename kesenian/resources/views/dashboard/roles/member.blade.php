@extends('layouts.dashboard')

@section('title', 'Dashboard Anggota')

@section('content')
    <div class="panel-light mb-8">
        <h2 class="text-2xl font-display font-bold mb-2 text-light-text">
            Halo, <span class="text-gold-dark">{{ auth()->user()->nama_lengkap }}</span> 👋
        </h2>
        <p class="text-light-muted text-sm">
            Selamat datang di area anggota. Cek jadwal, absensi, dan kas kamu di sini.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('dashboard.events') }}" class="panel-light-interactive group">
            <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">📅</div>
            <h3 class="font-display font-bold mb-1 text-light-text group-hover:text-gold-dark transition-colors">
                Jadwal Kegiatan
            </h3>
            <p class="text-light-muted text-xs">Lihat event mendatang</p>
        </a>
        <a href="{{ route('dashboard.attendance') }}" class="panel-light-interactive group">
            <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">✅</div>
            <h3 class="font-display font-bold mb-1 text-light-text group-hover:text-gold-dark transition-colors">
                Absensi Saya
            </h3>
            <p class="text-light-muted text-xs">Riwayat kehadiran pribadi</p>
        </a>
        <a href="{{ route('dashboard.cash') }}" class="panel-light-interactive group">
            <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">💳</div>
            <h3 class="font-display font-bold mb-1 text-light-text group-hover:text-gold-dark transition-colors">
                Kas Saya
            </h3>
            <p class="text-light-muted text-xs">Status pembayaran kas</p>
        </a>
    </div>
@endsection