<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Dashboard') — Giri Adiwarna</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    {{-- ── PRELOAD SCRIPT: cegah flicker sidebar ── --}}
    <script>
        (function() {
            try {
                const collapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (collapsed) {
                    document.documentElement.classList.add('preload-collapsed');
                }
            } catch (e) {}
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body 
    x-data="{ 
        sidebarOpen: false,
        sidebarCollapsed: JSON.parse(localStorage.getItem('sidebarCollapsed') || 'false'),
        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed);
        }
    }"
    x-init="$nextTick(() => document.documentElement.classList.remove('preload-collapsed'))"
    class="bg-light-bg text-light-text antialiased font-sans min-h-screen"
>

    {{-- MOBILE SIDEBAR OVERLAY --}}
    <div 
        x-show="sidebarOpen" 
        x-cloak
        @click="sidebarOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"
    ></div>

    {{-- SIDEBAR (tetap dark) --}}
    <x-sidebar />

    {{-- MAIN AREA --}}
    <div 
        class="min-h-screen transition-all duration-300 flex flex-col bg-content"
        :class="{
            'lg:pl-64': !sidebarCollapsed,
            'lg:pl-20': sidebarCollapsed
        }"
    >
        {{-- TOPBAR (light) --}}
        <x-topbar />

        {{-- CONTENT --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-[1600px] w-full mx-auto">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 5000)"
                    x-transition
                    class="mb-6 p-4 rounded-2xl 
                           bg-green-50 border border-green-200
                           flex items-start gap-3 shadow-sm"
                >
                    <div class="w-9 h-9 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-green-700 text-sm flex-1 pt-1.5 font-medium">{{ session('success') }}</p>
                    <button @click="show = false" class="text-green-600 hover:text-green-800 p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 5000)"
                    x-transition
                    class="mb-6 p-4 rounded-2xl 
                           bg-red-50 border border-red-200
                           flex items-start gap-3 shadow-sm"
                >
                    <div class="w-9 h-9 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-red-700 text-sm flex-1 pt-1.5 font-medium">{{ session('error') }}</p>
                    <button @click="show = false" class="text-red-600 hover:text-red-800 p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            {{-- BREADCRUMB --}}
            @hasSection('breadcrumb')
                <nav class="mb-6 text-sm">
                    @yield('breadcrumb')
                </nav>
            @endif

            {{-- CONTENT --}}
            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="px-4 sm:px-6 lg:px-8 py-6 text-center">
            <div class="divider-light mb-4"></div>
            <p class="text-light-muted text-xs">
                &copy; {{ date('Y') }} <span class="text-gold-dark font-semibold">Giri Adiwarna</span> 
                — SMKN 1 Banjar
            </p>
        </footer>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        
        /* Preload — saat initial, matikan transition biar gak flicker */
        .preload-collapsed aside {
            width: 5rem !important;
            transition: none !important;
        }
        .preload-collapsed main,
        .preload-collapsed .main-wrapper {
            padding-left: 5rem !important;
            transition: none !important;
        }
        @media (max-width: 1023px) {
            .preload-collapsed aside {
                width: 16rem !important;
                transform: translateX(-100%);
            }
            .preload-collapsed main,
            .preload-collapsed .main-wrapper {
                padding-left: 0 !important;
            }
        }
    </style>
</body>
</html>