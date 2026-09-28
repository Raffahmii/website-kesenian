<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 — Sesi Habis | Giri Adiwarna</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bg-primary text-text-primary font-sans antialiased overflow-hidden">

    <div class="fixed inset-0 bg-gradient-to-br from-bg-primary via-[#23272E] to-bg-secondary"></div>
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat animate-hero-bg"
         style="background-image: url('{{ asset('images/wayang_background.jpg') }}'); opacity: 0.15;"></div>
    <div class="fixed inset-0 bg-gradient-to-b from-bg-primary/80 via-bg-primary/60 to-bg-primary"></div>

    <div class="fixed top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[600px] rounded-full blur-3xl opacity-20 pointer-events-none animate-float-slow"
         style="background: radial-gradient(circle, #F5B301 0%, transparent 70%);"></div>

    <div class="relative min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-2xl w-full text-center">

            <div class="relative mb-8">
                <h1 class="text-[120px] sm:text-[180px] md:text-[220px] font-display font-bold leading-none
                           bg-gradient-to-br from-gold via-gold-hover to-gold-dark bg-clip-text text-transparent
                           drop-shadow-[0_0_40px_rgba(245,179,1,0.3)]">
                    419
                </h1>

                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 
                            w-24 h-24 rounded-3xl bg-gold/20 border-2 border-gold/40 
                            flex items-center justify-center backdrop-blur-md">
                    <svg class="w-12 h-12 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <div class="inline-flex items-center gap-2 badge-gold mb-6">
                <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                <span class="text-xs tracking-widest uppercase font-medium">Sesi Habis</span>
            </div>

            <h2 class="text-3xl md:text-4xl font-display font-bold mb-4">
                Sesi Kamu Udah Expired ⏰
            </h2>

            <p class="text-text-muted text-base md:text-lg max-w-lg mx-auto mb-10 leading-relaxed">
                Demi keamanan, sesi login kamu udah <span class="gold-text font-medium">habis</span>. 
                Tinggal login ulang aja, cepet kok.
            </p>

            <div class="flex flex-wrap gap-3 justify-center mb-12">
                <a href="{{ route('login') }}" class="btn-gold btn-lg group">
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Login Lagi
                </a>
                <a href="{{ url('/') }}" class="btn-outline btn-lg">
                    Balik ke Beranda
                </a>
            </div>

            <p class="text-xs text-text-muted/60">
                Error 419 · Kesenian Giri Adiwarna · SMKN 1 Banjar
            </p>

        </div>
    </div>

</body>
</html>