<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 — Maintenance | Giri Adiwarna</title>
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

            {{-- Logo besar --}}
            <div class="mb-8 flex justify-center">
                <div class="relative">
                    <div class="absolute inset-0 rounded-full bg-gold blur-3xl opacity-30 animate-glow"></div>
                    <img src="{{ asset('images/logo.png') }}" 
                         class="relative w-32 h-32 object-contain animate-float-slow"
                         onerror="this.style.display='none'">
                </div>
            </div>

            <div class="inline-flex items-center gap-2 badge-gold mb-6">
                <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                <span class="text-xs tracking-widest uppercase font-medium">Under Maintenance</span>
            </div>

            <h1 class="text-4xl md:text-5xl font-display font-bold mb-4">
                Lagi <span class="gold-text">Diperbaiki</span> 🚧
            </h1>

            <p class="text-text-muted text-base md:text-lg max-w-lg mx-auto mb-10 leading-relaxed">
                Website Kesenian Giri Adiwarna lagi <span class="gold-text font-medium">maintenance</span>. 
                Kami bakal balik lagi sebentar lagi. Makasih atas kesabarannya 🙏
            </p>

            {{-- Loading bar --}}
            <div class="max-w-xs mx-auto mb-12">
                <div class="h-1.5 bg-bg-card rounded-full overflow-hidden">
                    <div class="h-full gradient-gold rounded-full animate-loading-bar"></div>
                </div>
                <p class="text-xs text-text-muted mt-3">Sedang memuat...</p>
            </div>

            <p class="text-xs text-text-muted/60">
                Error 503 · Kesenian Giri Adiwarna · SMKN 1 Banjar
            </p>

        </div>
    </div>

</body>
</html>