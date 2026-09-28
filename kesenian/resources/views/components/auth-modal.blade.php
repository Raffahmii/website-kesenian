{{-- ═══════════════════════════════════════════════════════
     AUTH MODAL — Login + Register dalam 1 popup
     ═══════════════════════════════════════════════════════ --}}
<div 
    x-data="{ 
        open: {{ $errors->any() && !request()->routeIs('password.*') ? 'true' : 'false' }},
        tab: '{{ old('_auth_tab', 'login') }}',
        showPassword: false
    }"
    x-init="
        window.addEventListener('open-auth-modal', (e) => {
            open = true;
            tab = e.detail?.tab || 'login';
            document.body.style.overflow = 'hidden';
        });
    "
    @keydown.escape.window="open = false; document.body.style.overflow = ''"
    x-show="open"
    x-cloak
    @click.self="open = false; document.body.style.overflow = ''"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4
           bg-black/70 backdrop-blur-md"
>
    {{-- Modal box --}}
    <div 
        @click.stop
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        class="relative w-full max-w-md rounded-3xl overflow-hidden
               bg-gradient-to-br from-bg-secondary via-bg-secondary to-bg-primary
               border border-border-dark
               shadow-2xl shadow-black/60"
    >
        {{-- Gold glow top --}}
        <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-64 h-64 
                    bg-gold/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
             style="background-image: linear-gradient(#F5B301 1px, transparent 1px), linear-gradient(90deg, #F5B301 1px, transparent 1px); background-size: 40px 40px;"></div>

        {{-- Close button --}}
        <button 
            @click="open = false; document.body.style.overflow = ''"
            class="absolute top-4 right-4 z-10 p-2 rounded-xl 
                   text-text-muted hover:text-gold hover:bg-bg-card/50 
                   transition-all"
            aria-label="Close"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Content --}}
        <div class="relative p-6 sm:p-8">

            {{-- Logo + Brand --}}
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center relative mb-4">
                    <div class="absolute inset-0 rounded-full bg-gold blur-xl opacity-30"></div>
                    <img 
                        src="{{ asset('images/logo.png') }}" 
                        alt="Logo" 
                        class="relative w-16 h-16 object-contain"
                        onerror="this.style.display='none'"
                    >
                </div>
                <h2 class="font-display font-bold text-xl gold-text mb-1">
                    Giri Adiwarna
                </h2>
                <p class="text-xs text-text-muted">
                    <span x-text="tab === 'login' ? 'Masuk ke akun kamu' : 'Daftar jadi anggota baru'"></span>
                </p>
            </div>

            {{-- Tab Switcher --}}
            <div class="flex p-1 rounded-2xl bg-bg-card/50 mb-6 relative">
                <button 
                    @click="tab = 'login'"
                    :class="tab === 'login' ? 'bg-gradient-to-r from-gold to-gold-hover text-bg-primary shadow-md shadow-gold/30' : 'text-text-muted hover:text-text-primary'"
                    class="relative flex-1 py-2.5 rounded-xl text-sm font-medium transition-all duration-300"
                >
                    Masuk
                </button>
                <button 
                    @click="tab = 'register'"
                    :class="tab === 'register' ? 'bg-gradient-to-r from-gold to-gold-hover text-bg-primary shadow-md shadow-gold/30' : 'text-text-muted hover:text-text-primary'"
                    class="relative flex-1 py-2.5 rounded-xl text-sm font-medium transition-all duration-300"
                >
                    Daftar
                </button>
            </div>

            {{-- ═══════════════════════════════════════
                 FORM LOGIN
                 ═══════════════════════════════════════ --}}
            <div x-show="tab === 'login'" x-transition:enter="transition ease-out duration-200">
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_auth_tab" value="login">

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-medium text-text-muted mb-2">
                            Email
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-text-muted group-focus-within:text-gold transition-colors" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input 
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                placeholder="email@example.com"
                                class="w-full pl-10 pr-4 py-3 rounded-xl text-sm
                                       bg-bg-card/60 border border-border-dark
                                       text-text-primary placeholder-text-muted/50
                                       focus:outline-none focus:border-gold/50 
                                       focus:ring-2 focus:ring-gold/20
                                       transition-all"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-xs font-medium text-text-muted mb-2">
                            Password
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-text-muted group-focus-within:text-gold transition-colors" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input 
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                required
                                placeholder="••••••••"
                                class="w-full pl-10 pr-12 py-3 rounded-xl text-sm
                                       bg-bg-card/60 border border-border-dark
                                       text-text-primary placeholder-text-muted/50
                                       focus:outline-none focus:border-gold/50 
                                       focus:ring-2 focus:ring-gold/20
                                       transition-all"
                            >
                            <button 
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-text-muted hover:text-gold"
                            >
                                <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember --}}
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input 
                            type="checkbox"
                            name="remember"
                            class="w-4 h-4 rounded border-border-dark bg-bg-card 
                                   text-gold focus:ring-gold/30 focus:ring-offset-0 cursor-pointer"
                        >
                        <span class="text-xs text-text-muted group-hover:text-text-primary transition-colors">
                            Ingat saya
                        </span>
                    </label>

                    {{-- Submit --}}
                    <button 
                        type="submit"
                        class="w-full btn-gold justify-center group"
                    >
                        Masuk
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>

                {{-- Switch to register --}}
                <p class="text-center text-xs text-text-muted mt-5">
                    Belum punya akun?
                    <button @click="tab = 'register'" 
                            class="text-gold hover:text-gold-hover font-medium transition-colors">
                        Daftar sekarang
                    </button>
                </p>
            </div>

            {{-- ═══════════════════════════════════════
                 FORM REGISTER
                 ═══════════════════════════════════════ --}}
            <div x-show="tab === 'register'" x-cloak x-transition:enter="transition ease-out duration-200">
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_auth_tab" value="register">



                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-xs font-medium text-text-muted mb-2">
                            Nama Lengkap
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-text-muted group-focus-within:text-gold transition-colors" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input 
                                type="text"
                                name="nama_lengkap"
                                value="{{ old('nama_lengkap') }}"
                                required
                                placeholder="Nama lengkap kamu"
                                class="w-full pl-10 pr-4 py-3 rounded-xl text-sm
                                       bg-bg-card/60 border border-border-dark
                                       text-text-primary placeholder-text-muted/50
                                       focus:outline-none focus:border-gold/50 
                                       focus:ring-2 focus:ring-gold/20
                                       transition-all"
                            >
                        </div>
                        @error('nama_lengkap')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-medium text-text-muted mb-2">
                            Email
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-text-muted group-focus-within:text-gold transition-colors" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input 
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="email@example.com"
                                class="w-full pl-10 pr-4 py-3 rounded-xl text-sm
                                       bg-bg-card/60 border border-border-dark
                                       text-text-primary placeholder-text-muted/50
                                       focus:outline-none focus:border-gold/50 
                                       focus:ring-2 focus:ring-gold/20
                                       transition-all"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-xs font-medium text-text-muted mb-2">
                            Password
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-text-muted group-focus-within:text-gold transition-colors" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input 
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                required
                                placeholder="Minimal 8 karakter"
                                class="w-full pl-10 pr-12 py-3 rounded-xl text-sm
                                       bg-bg-card/60 border border-border-dark
                                       text-text-primary placeholder-text-muted/50
                                       focus:outline-none focus:border-gold/50 
                                       focus:ring-2 focus:ring-gold/20
                                       transition-all"
                            >
                            <button 
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-text-muted hover:text-gold"
                            >
                                <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="block text-xs font-medium text-text-muted mb-2">
                            Konfirmasi Password
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-text-muted group-focus-within:text-gold transition-colors" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <input 
                                type="password"
                                name="password_confirmation"
                                required
                                placeholder="Ulangi password"
                                class="w-full pl-10 pr-4 py-3 rounded-xl text-sm
                                       bg-bg-card/60 border border-border-dark
                                       text-text-primary placeholder-text-muted/50
                                       focus:outline-none focus:border-gold/50 
                                       focus:ring-2 focus:ring-gold/20
                                       transition-all"
                            >
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button 
                        type="submit"
                        class="w-full btn-gold justify-center group"
                    >
                        Daftar Sekarang
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </button>
                </form>

                {{-- Switch to login --}}
                <p class="text-center text-xs text-text-muted mt-5">
                    Sudah punya akun?
                    <button @click="tab = 'login'" 
                            class="text-gold hover:text-gold-hover font-medium transition-colors">
                        Masuk di sini
                    </button>
                </p>
            </div>

        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>