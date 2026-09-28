<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Giri Adiwarna') — Kesenian SMKN 1 Banjar</title>
    <meta name="description" content="@yield('description', 'Website resmi Kesenian Giri Adiwarna SMKN 1 Banjar.')">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body 
    x-data
    class="bg-bg-primary text-text-primary font-sans antialiased"
>

    {{-- ═══════════════════════════════════════
         LOADING SCREEN — 1.5s, sekali per sesi
         ═══════════════════════════════════════ --}}
    <div 
        x-data="{ 
            show: sessionStorage.getItem('loaderShown') === null 
        }"
        x-init="
            if (show) {
                sessionStorage.setItem('loaderShown', '1');
                setTimeout(() => show = false, 5000);
            }
        "
        x-show="show"
        x-cloak
        x-transition:leave="transition ease-out duration-700"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[9999] bg-bg-primary flex items-center justify-center"
    >
        {{-- Background layer --}}
        <div class="absolute inset-0 bg-gradient-to-br from-bg-primary via-[#23272E] to-bg-secondary"></div>
        <div class="absolute inset-0 bg-cover bg-center"
             style="background-image: url('{{ asset('images/wayang_background.jpg') }}'); opacity: 0.08;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 
                    w-[500px] h-[500px] rounded-full blur-3xl opacity-20"
             style="background: radial-gradient(circle, #F5B301 0%, transparent 70%);"></div>

        {{-- Loader content --}}
        <div class="relative flex flex-col items-center">
            {{-- Rotating rings + logo --}}
            <div class="relative w-32 h-32 mb-8">
                {{-- Outer ring --}}
                <div class="absolute inset-0 rounded-full border-2 border-gold/15"></div>
                <div class="absolute inset-0 rounded-full border-2 border-transparent border-t-gold animate-spin-slow"></div>
                
                {{-- Inner ring --}}
                <div class="absolute inset-3 rounded-full border-2 border-transparent border-b-gold-hover animate-spin-reverse"></div>
                
                {{-- Logo center --}}
                <div class="absolute inset-7 rounded-full bg-gold/10 flex items-center justify-center backdrop-blur-sm">
                    <img 
                        src="{{ asset('images/logo.png') }}" 
                        class="w-12 h-12 object-contain animate-pulse"
                        onerror="this.style.display='none'"
                    >
                </div>
            </div>

            {{-- Text --}}
            <h2 class="font-display font-bold text-xl gold-text mb-1">
                Giri Adiwarna
            </h2>
            <p class="text-xs text-text-muted tracking-[0.3em] uppercase">
                Memuat
            </p>

            {{-- Progress bar --}}
            <div class="w-56 h-1 bg-bg-card rounded-full overflow-hidden mt-6">
                <div class="h-full gradient-gold rounded-full animate-loading-bar"></div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════
         NAVBAR
         ═══════════════════════════════════════ --}}
    <x-navbar-public />

    {{-- ═══════════════════════════════════════
         MAIN CONTENT
         ═══════════════════════════════════════ --}}
    <main>
        @yield('content')
    </main>

    {{-- ═══════════════════════════════════════
         FOOTER
         ═══════════════════════════════════════ --}}
    <x-footer-public />

    {{-- ═══════════════════════════════════════
         SCROLL TO TOP
         ═══════════════════════════════════════ --}}
    <x-scroll-top />

    {{-- ═══════════════════════════════════════
         AUTH MODAL — Login + Register
         ═══════════════════════════════════════ --}}
    <x-auth-modal />

    @stack('scripts')

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>