<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Masuk') — Giri Adiwarna</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bg-primary text-text-primary font-sans antialiased">

    {{-- Background layers --}}
    <div class="fixed inset-0 bg-gradient-to-br from-bg-primary via-[#23272E] to-bg-secondary"></div>
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat animate-hero-bg"
         style="background-image: url('{{ asset('images/wayang_background.jpg') }}'); opacity: 0.75;"></div>
    <div class="fixed inset-0 bg-gradient-to-b from-bg-primary/60 via-bg-primary/40 to-bg-primary"></div>

    {{-- Gold glow --}}
    <div class="fixed top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[600px] rounded-full blur-3xl opacity-20 pointer-events-none"
         style="background: radial-gradient(circle, #F5B301 0%, transparent 70%);"></div>

    {{-- Grid pattern --}}
    <div class="fixed inset-0 opacity-[0.03] pointer-events-none"
         style="background-image: linear-gradient(#F5B301 1px, transparent 1px), linear-gradient(90deg, #F5B301 1px, transparent 1px); background-size: 60px 60px;"></div>

    {{-- Content --}}
    <div class="relative min-h-screen flex flex-col items-center justify-center px-4 py-12">
        
        {{-- Logo + Brand --}}
        <div class="mb-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex flex-col items-center group">
                <div class="relative mb-4">
                    <div class="absolute inset-0 rounded-full bg-gold blur-xl opacity-30 group-hover:opacity-50 transition-opacity"></div>
                    <img 
                        src="{{ asset('images/logo.png') }}" 
                        alt="Logo" 
                        class="relative w-20 h-20 object-contain transition-transform group-hover:scale-110"
                        onerror="this.style.display='none'"
                    >
                </div>
                <h1 class="font-display font-bold text-2xl gold-text">Giri Adiwarna</h1>
                <p class="text-xs text-text-muted mt-1">SMKN 1 Banjar</p>
            </a>
        </div>

        {{-- Card --}}
        <div class="w-full max-w-md">
            <div class="rounded-3xl p-6 sm:p-8
                        bg-gradient-to-br from-bg-secondary/90 to-bg-primary/90
                        backdrop-blur-xl
                        border border-border-dark
                        shadow-2xl shadow-black/40">
                {{ $slot }}
            </div>
        </div>

        {{-- Back to home --}}
        <a href="{{ route('home') }}" 
           class="mt-8 inline-flex items-center gap-2 text-xs text-text-muted 
                  hover:text-gold transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Beranda
        </a>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>