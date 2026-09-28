<nav 
    x-data="{ 
        open: false, 
        scrolled: false 
    }"
    x-init="
        window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })
    "
    :class="scrolled ? 'glass shadow-lg shadow-black/20' : 'bg-transparent'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20">

            {{-- ── LOGO ── --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <img 
                    src="{{ asset('images/logo.png') }}" 
                    alt="Giri Adiwarna" 
                    class="w-10 h-10 md:w-12 md:h-12 object-contain transition-transform group-hover:scale-110"
                    onerror="this.style.display='none'"
                >
                <div class="leading-tight">
                    <div class="font-display font-bold text-base md:text-lg gold-text">
                        Giri Adiwarna
                    </div>
                    <div class="text-[10px] md:text-xs text-text-muted">
                        SMKN 1 Banjar
                    </div>
                </div>
            </a>

            {{-- ── DESKTOP MENU ── --}}
            <div class="hidden lg:flex items-center gap-1">
                @php
                    $navItems = [
                        ['label' => 'Beranda',     'anchor' => 'top'],
                        ['label' => 'Tentang',     'anchor' => 'about'],
                        ['label' => 'Visi Misi',   'anchor' => 'visi-misi'],
                        ['label' => 'Divisi',      'anchor' => 'divisi'],
                        ['label' => 'Prestasi',    'anchor' => 'prestasi'],
                        ['label' => 'Dokumentasi', 'anchor' => 'dokumentasi'],
                        ['label' => 'Event',       'anchor' => 'event'],
                        ['label' => 'Kontak',      'anchor' => 'kontak'],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    <a 
                        href="{{ $item['anchor'] === 'top' ? url('/') : '#' . $item['anchor'] }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
                               text-text-primary hover:text-gold hover:bg-gold/5"
                    >
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            {{-- ── CTA BUTTON (Login/Dashboard) ── --}}
            <div class="hidden lg:flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard.index') }}" class="btn-gold btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                @else
                    {{-- Trigger modal --}}
                    <button 
                        @click="$dispatch('open-auth-modal', { tab: 'login' })" 
                        class="btn-gold btn-sm"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Login
                    </button>
                @endauth
            </div>

            {{-- ── MOBILE MENU BUTTON ── --}}
            <button 
                @click="open = !open"
                class="lg:hidden p-2 rounded-lg text-text-primary hover:bg-bg-card transition"
                aria-label="Menu"
            >
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- ── MOBILE MENU DROPDOWN ── --}}
    <div 
        x-show="open" 
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="lg:hidden glass border-t border-border-dark"
    >
        <div class="px-4 py-4 space-y-1">
            @foreach ($navItems as $item)
                <a 
                    href="{{ $item['anchor'] === 'top' ? url('/') : '#' . $item['anchor'] }}"
                    @click="open = false"
                    class="block px-4 py-3 rounded-lg text-sm font-medium transition-all
                           text-text-primary hover:text-gold hover:bg-gold/5"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach

            <div class="pt-3 mt-3 border-t border-border-dark">
                @auth
                    <a href="{{ route('dashboard.index') }}" class="btn-gold w-full">
                        Dashboard
                    </a>
                @else
                    <button 
                        @click="open = false; $dispatch('open-auth-modal', { tab: 'login' })" 
                        class="btn-gold w-full"
                    >
                        Login / Daftar
                    </button>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Spacer biar konten gak ketutup navbar --}}
<div class="h-16 md:h-20"></div>

<style>
    [x-cloak] { display: none !important; }
</style>
