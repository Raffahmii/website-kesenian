<x-guest-layout>
    @section('title', 'Masuk')

    <div class="text-center mb-6">
        <h2 class="font-display font-bold text-xl mb-1">Selamat Datang</h2>
        <p class="text-xs text-text-muted">Masuk ke akun kamu untuk melanjutkan</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-4 p-3 rounded-xl bg-green-500/10 border border-green-500/30 
                    text-xs text-green-400">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4" x-data="{ showPassword: false }">
        @csrf

        {{-- Email --}}
        <div>
            <label class="block text-xs font-medium text-text-muted mb-2">Email</label>
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
                           focus:ring-2 focus:ring-gold/20 transition-all"
                >
            </div>
            @error('email')
                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-xs font-medium text-text-muted mb-2">Password</label>
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
                           focus:ring-2 focus:ring-gold/20 transition-all"
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
        <button type="submit" class="w-full btn-gold justify-center group">
            Masuk
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
        </button>
    </form>

    {{-- Register link --}}
    <p class="text-center text-xs text-text-muted mt-6">
        Belum punya akun?
        <a href="{{ route('register') }}" 
           class="text-gold hover:text-gold-hover font-medium transition-colors">
            Daftar sekarang
        </a>
    </p>
</x-guest-layout>