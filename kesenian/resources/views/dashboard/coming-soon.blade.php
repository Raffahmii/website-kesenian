@extends('layouts.dashboard')

@section('title', $title ?? 'Coming Soon')

@section('content')
    <div class="panel-light text-center py-20" data-aos="zoom-in">
        <div class="text-7xl mb-6">🚧</div>
        <h2 class="text-3xl font-display font-bold mb-3 text-light-text">
            {{ $title ?? 'Halaman Ini' }} <span class="text-gold-dark">Segera Hadir</span>
        </h2>
        <p class="text-light-muted max-w-md mx-auto mb-8">
            Modul ini sedang dalam pengembangan. Nantikan fitur lengkapnya segera!
        </p>
        <a href="{{ route('dashboard.index') }}" class="btn-gold inline-flex">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>
@endsection