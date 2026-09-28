<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak | Giri Adiwarna</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bg-primary text-text-primary font-sans antialiased overflow-hidden">

    <div class="fixed inset-0 bg-gradient-to-br from-bg-primary via-[#23272E] to-bg-secondary"></div>
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat animate-hero-bg"
         style="background-image: url('{{ asset('images/wayang_background.jpg') }}'); opacity: 0.15;"></div>
    <div class="fixed inset-0 bg-gradient-to-b from-bg-primary/80 via-bg-primary/60 to-bg-primary"></div>

    <div class="fixed inset-0 pointer-events-none"
         style="background-image: url('{{ asset('images/batik.jpeg') }}'); background-size: 380px; background-repeat: repeat; opacity: 0.05;"></div>

    {{-- Red glow (karena ini forbidden) --}}
    <div class="fixed top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[600px] rounded-full blur-3xl opacity-20 pointer-events-none animate-float-slow"
         style="background: radial-gradient(circle, #ef4444 0%, transparent 70%);"></div>

    <div class="relative min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-2xl w-full text-center">

            {{-- 403 --}}
            <div class="relative mb-8">
                <h1 class="text-[120px] sm:text-[180px] md:text-[220px] font-display font-bold leading-none
                           bg-gradient-to-br from-red-400 via-red-500 to-red-700 bg-clip-text text-transparent
                           drop-shadow-[0_0_40px_rgba(239,68,68,0.3)]">
                    403
                </h1>

                {{-- Lock icon --}}
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 
                            w-24 h-24 rounded-3xl bg-red-500/20 border-2 border-red-500/40 
                            flex items-center justify-center backdrop-blur-md
                            animate-pulse-glow">
                    <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 bg-red-500/10 border border-red-500/30 
                        rounded-full px-4 py-1.5 mb-6">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                <span class="text-xs tracking-widest uppercase font-medium text-red-400">
                    Akses Ditolak
                </span>
            </div>

            <h2 class="text-3xl md:text-4xl font-display font-bold mb-4">
                Ups, Gak Boleh Masuk 🔒
            </h2>

            <p class="text-text-muted text-base md:text-lg max-w-lg mx-auto mb-10 leading-relaxed">
                Kamu <span class="text-red-400 font-medium">gak punya akses</span> ke halaman ini. 
                Halaman ini khusus untuk role tertentu. Kalau ngerasa salah, hubungi pengurus.
            </p>

            <div class="flex flex-wrap gap-3 justify-center mb-12">
                <a href="{{ url('/') }}" class="btn-gold btn-lg group">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Balik ke Beranda
                </a>

                @auth
                    <a href="{{ route('dashboard.index') }}" class="btn-outline btn-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        Dashboard
                    </a>
                @endauth
            </div>

            <p class="text-xs text-text-muted/60">
                Error 403 · Kesenian Giri Adiwarna · SMKN 1 Banjar
            </p>

        </div>
    </div>

</body>
</html>