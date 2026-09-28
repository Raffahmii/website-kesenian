<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Halaman Tidak Ditemukan | Giri Adiwarna</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bg-primary text-text-primary font-sans antialiased overflow-hidden">

    {{-- Background Layers --}}
    <div class="fixed inset-0 bg-gradient-to-br from-bg-primary via-[#23272E] to-bg-secondary"></div>
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat animate-hero-bg"
         style="background-image: url('{{ asset('images/wayang_background.jpg') }}'); opacity: 0.15;"></div>
    <div class="fixed inset-0 bg-gradient-to-b from-bg-primary/80 via-bg-primary/60 to-bg-primary"></div>

    {{-- Batik overlay --}}
    <div class="fixed inset-0 pointer-events-none"
         style="background-image: url('{{ asset('images/batik.jpeg') }}'); background-size: 380px; background-repeat: repeat; opacity: 0.05;"></div>

    {{-- Gold glow --}}
    <div class="fixed top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[600px] rounded-full blur-3xl opacity-20 pointer-events-none animate-float-slow"
         style="background: radial-gradient(circle, #F5B301 0%, transparent 70%);"></div>

    {{-- Content --}}
    <div class="relative min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-2xl w-full text-center">

            {{-- 404 Gede --}}
            <div class="relative mb-8">
                <h1 class="text-[120px] sm:text-[180px] md:text-[220px] font-display font-bold leading-none
                           bg-gradient-to-br from-gold via-gold-hover to-gold-dark bg-clip-text text-transparent
                           drop-shadow-[0_0_40px_rgba(245,179,1,0.3)]">
                    404
                </h1>

                {{-- Ornamen wayang mini --}}
                <div class="absolute -top-4 left-4 w-12 h-12 rounded-2xl bg-gold/10 border border-gold/30 
                            flex items-center justify-center animate-float-slow">
                    <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <div class="absolute -bottom-4 right-4 w-12 h-12 rounded-2xl bg-gold/10 border border-gold/30 
                            flex items-center justify-center animate-float-slow" style="animation-delay: -3s">
                    <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 badge-gold mb-6">
                <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                <span class="text-xs tracking-widest uppercase font-medium">Halaman Tidak Ditemukan</span>
            </div>

            {{-- Title --}}
            <h2 class="text-3xl md:text-4xl font-display font-bold mb-4">
                Waduh, Nyasar Ya? 🤔
            </h2>

            {{-- Desc --}}
            <p class="text-text-muted text-base md:text-lg max-w-lg mx-auto mb-10 leading-relaxed">
                Halaman yang kamu cari <span class="gold-text font-medium">gak ada</span> 
                atau udah dipindahin ke tempat lain. Tenang, kita balikin ke jalan yang bener.
            </p>

            {{-- Actions --}}
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

            {{-- Quick Links --}}
            <div class="pt-8 border-t border-border-dark/50">
                <p class="text-xs text-text-muted uppercase tracking-widest mb-4">Coba Cek Link Ini</p>
                <div class="flex flex-wrap gap-2 justify-center">
                    <a href="{{ url('/#about') }}" class="px-4 py-2 rounded-xl bg-bg-card hover:bg-gold/10 
                                                          text-text-muted hover:text-gold text-sm transition-all
                                                          border border-border-dark hover:border-gold/30">
                        Tentang
                    </a>
                    <a href="{{ url('/#divisi') }}" class="px-4 py-2 rounded-xl bg-bg-card hover:bg-gold/10 
                                                           text-text-muted hover:text-gold text-sm transition-all
                                                           border border-border-dark hover:border-gold/30">
                        Divisi
                    </a>
                    <a href="{{ url('/#prestasi') }}" class="px-4 py-2 rounded-xl bg-bg-card hover:bg-gold/10 
                                                            text-text-muted hover:text-gold text-sm transition-all
                                                            border border-border-dark hover:border-gold/30">
                        Prestasi
                    </a>
                    <a href="{{ url('/#dokumentasi') }}" class="px-4 py-2 rounded-xl bg-bg-card hover:bg-gold/10 
                                                               text-text-muted hover:text-gold text-sm transition-all
                                                               border border-border-dark hover:border-gold/30">
                        Dokumentasi
                    </a>
                    <a href="{{ url('/#event') }}" class="px-4 py-2 rounded-xl bg-bg-card hover:bg-gold/10 
                                                         text-text-muted hover:text-gold text-sm transition-all
                                                         border border-border-dark hover:border-gold/30">
                        Event
                    </a>
                    <a href="{{ url('/#kontak') }}" class="px-4 py-2 rounded-xl bg-bg-card hover:bg-gold/10 
                                                          text-text-muted hover:text-gold text-sm transition-all
                                                          border border-border-dark hover:border-gold/30">
                        Kontak
                    </a>
                </div>
            </div>

            {{-- Footer --}}
            <p class="mt-10 text-xs text-text-muted/60">
                Error 404 · Kesenian Giri Adiwarna · SMKN 1 Banjar
            </p>

        </div>
    </div>

</body>
</html>