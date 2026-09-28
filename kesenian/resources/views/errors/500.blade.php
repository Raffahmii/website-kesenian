<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Server Error | Giri Adiwarna</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bg-primary text-text-primary font-sans antialiased overflow-hidden">

    <div class="fixed inset-0 bg-gradient-to-br from-bg-primary via-[#23272E] to-bg-secondary"></div>
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat animate-hero-bg"
         style="background-image: url('{{ asset('images/wayang_background.jpg') }}'); opacity: 0.15;"></div>
    <div class="fixed inset-0 bg-gradient-to-b from-bg-primary/80 via-bg-primary/60 to-bg-primary"></div>

    <div class="fixed top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[600px] rounded-full blur-3xl opacity-20 pointer-events-none animate-float-slow"
         style="background: radial-gradient(circle, #f97316 0%, transparent 70%);"></div>

    <div class="relative min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-2xl w-full text-center">

            <div class="relative mb-8">
                <h1 class="text-[120px] sm:text-[180px] md:text-[220px] font-display font-bold leading-none
                           bg-gradient-to-br from-orange-400 via-orange-500 to-red-600 bg-clip-text text-transparent
                           drop-shadow-[0_0_40px_rgba(249,115,22,0.3)]">
                    500
                </h1>

                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 
                            w-24 h-24 rounded-3xl bg-orange-500/20 border-2 border-orange-500/40 
                            flex items-center justify-center backdrop-blur-md animate-pulse">
                    <svg class="w-12 h-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>

            <div class="inline-flex items-center gap-2 bg-orange-500/10 border border-orange-500/30 
                        rounded-full px-4 py-1.5 mb-6">
                <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                <span class="text-xs tracking-widest uppercase font-medium text-orange-400">
                    Server Error
                </span>
            </div>

            <h2 class="text-3xl md:text-4xl font-display font-bold mb-4">
                Ada Masalah Teknis 🛠️
            </h2>

            <p class="text-text-muted text-base md:text-lg max-w-lg mx-auto mb-10 leading-relaxed">
                Server lagi <span class="text-orange-400 font-medium">mengalami gangguan</span>. 
                Tim kami udah dikasih tau. Coba refresh beberapa saat lagi ya.
            </p>

            <div class="flex flex-wrap gap-3 justify-center mb-12">
                <button onclick="window.location.reload()" class="btn-gold btn-lg group">
                    <svg class="w-5 h-5 transition-transform group-hover:rotate-180" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Refresh Halaman
                </button>
                <a href="{{ url('/') }}" class="btn-outline btn-lg">
                    Balik ke Beranda
                </a>
            </div>

            @if(config('app.debug') && isset($exception))
                <div class="mt-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-left">
                    <p class="text-xs text-red-400 font-mono break-all">
                        {{ $exception->getMessage() ?? 'No message' }}
                    </p>
                </div>
            @endif

            <p class="text-xs text-text-muted/60 mt-8">
                Error 500 · Kesenian Giri Adiwarna · SMKN 1 Banjar
            </p>

        </div>
    </div>

</body>
</html>