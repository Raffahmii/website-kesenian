<header 
    x-data="{
        searchOpen: false,
        searchQuery: '',
        searchResults: [],
        searchLoading: false,
        
        async doSearch() {
            if (this.searchQuery.length < 2) {
                this.searchResults = [];
                return;
            }
            this.searchLoading = true;
            try {
                const res = await fetch(`{{ route('dashboard.search') }}?q=${encodeURIComponent(this.searchQuery)}`);
                const data = await res.json();
                this.searchResults = data.results || [];
            } catch (e) {
                this.searchResults = [];
            }
            this.searchLoading = false;
        }
    }"
    class="sticky top-0 z-30 h-16 
           bg-white/80 backdrop-blur-xl
           border-b border-light-border
           shadow-sm shadow-black/[0.02]"
>
    <div class="h-full px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-3">

        {{-- LEFT — Mobile menu + Page Title --}}
        <div class="flex items-center gap-3 min-w-0 flex-1">
            <button 
                @click="sidebarOpen = true"
                class="lg:hidden p-2 rounded-xl hover:bg-light-hover text-light-text transition shrink-0"
                aria-label="Open menu"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div class="min-w-0">
                <h1 class="text-sm sm:text-base font-display font-semibold text-light-text truncate leading-tight">
                    @yield('title', 'Dashboard')
                </h1>
                @hasSection('subtitle')
                    <p class="text-[11px] text-light-muted truncate leading-tight">
                        @yield('subtitle')
                    </p>
                @else
                    <p class="text-[11px] text-light-muted/80 truncate leading-tight hidden sm:block">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>
                @endif
            </div>
        </div>

        {{-- CENTER — SEARCH BAR (FUNGSIONAL) --}}
        <div class="hidden md:flex flex-1 max-w-md relative">
            <div class="relative w-full group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-light-muted group-focus-within:text-gold-dark transition-colors" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text"
                    x-model="searchQuery"
                    @input.debounce.300ms="doSearch()"
                    @focus="searchOpen = true"
                    @click.away="searchOpen = false"
                    placeholder="Cari anggota, event, prestasi..."
                    class="w-full pl-10 pr-16 py-2.5 rounded-2xl text-sm
                           bg-light-bg
                           border border-light-border
                           text-light-text placeholder-light-muted/70
                           focus:outline-none focus:bg-white
                           focus:border-gold/50 focus:ring-2 focus:ring-gold/20
                           transition-all"
                >
                <kbd class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none
                            hidden lg:inline-flex items-center gap-1 px-2 py-0.5
                            bg-light-bg border border-light-border rounded-md text-[10px]
                            text-light-muted/70 font-mono">
                    <span>⌘</span><span>K</span>
                </kbd>

                {{-- DROPDOWN RESULTS --}}
                <div 
                    x-show="searchOpen && searchQuery.length >= 2"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute top-full mt-2 left-0 right-0 panel-light p-2 shadow-xl z-50
                           max-h-96 overflow-y-auto custom-scrollbar"
                >
                    {{-- Loading --}}
                    <div x-show="searchLoading" class="p-4 text-center">
                        <div class="inline-block w-5 h-5 border-2 border-gold border-t-transparent rounded-full animate-spin"></div>
                        <p class="text-xs text-light-muted mt-2">Mencari...</p>
                    </div>

                    {{-- Results --}}
                    <div x-show="!searchLoading && searchResults.length > 0">
                        <template x-for="(result, i) in searchResults" :key="i">
                            <a :href="result.url"
                               class="flex items-center gap-3 p-2.5 rounded-xl
                                      hover:bg-gold/[0.06] transition-colors group">
                                <div class="w-9 h-9 rounded-lg bg-light-bg flex items-center justify-center shrink-0">
                                    <span class="text-base" x-text="result.icon"></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-light-text truncate
                                              group-hover:text-gold-dark transition-colors" 
                                       x-text="result.title"></p>
                                    <p class="text-xs text-light-muted truncate">
                                        <span x-text="result.subtitle"></span>
                                    </p>
                                </div>
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-light-bg 
                                             text-light-muted font-medium shrink-0"
                                      x-text="result.type"></span>
                            </a>
                        </template>
                    </div>

                    {{-- No results --}}
                    <div x-show="!searchLoading && searchResults.length === 0" class="p-6 text-center">
                        <div class="text-4xl mb-2 opacity-40">🔍</div>
                        <p class="text-xs text-light-muted">Tidak ada hasil untuk "<span x-text="searchQuery"></span>"</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT — Actions --}}
        <div class="flex items-center gap-1 shrink-0">

            {{-- Mobile search --}}
            <button 
                @click="searchOpen = !searchOpen"
                class="md:hidden p-2 rounded-xl hover:bg-light-hover text-light-muted 
                       hover:text-gold-dark transition-colors"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>

            {{-- Quick action --}}
            <div x-data="{ open: false }" class="relative hidden sm:block">
                <button 
                    @click="open = !open"
                    @click.away="open = false"
                    class="p-2 rounded-xl hover:bg-light-hover text-light-muted 
                           hover:text-gold-dark transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </button>

                <div 
                    x-show="open"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                    class="absolute right-0 mt-2 w-60 panel-light p-2 shadow-xl z-50"
                >
                    <p class="px-3 py-1.5 text-[10px] uppercase tracking-widest text-light-muted font-semibold">
                        Aksi Cepat
                    </p>

                    @can('manage-members')
                        <a href="{{ route('dashboard.members.create') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm
                                  text-light-muted hover:bg-gold/[0.06] hover:text-gold-dark transition-all">
                            <div class="w-8 h-8 rounded-lg bg-gold/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            Tambah Anggota
                        </a>
                    @endcan

                    @can('manage-cash')
                        <a href="{{ route('dashboard.cash.input') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm
                                  text-light-muted hover:bg-gold/[0.06] hover:text-gold-dark transition-all">
                            <div class="w-8 h-8 rounded-lg bg-gold/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            Input Kas
                        </a>
                    @endcan

                    @can('manage-docs')
                        <a href="{{ route('dashboard.albums.create') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm
                                  text-light-muted hover:bg-gold/[0.06] hover:text-gold-dark transition-all">
                            <div class="w-8 h-8 rounded-lg bg-gold/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            Upload Dokumentasi
                        </a>
                    @endcan

                    @can('manage-events')
                        <a href="{{ route('dashboard.events.create') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm
                                  text-light-muted hover:bg-gold/[0.06] hover:text-gold-dark transition-all">
                            <div class="w-8 h-8 rounded-lg bg-gold/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            Buat Jadwal
                        </a>
                    @endcan
                </div>
            </div>

            {{-- ═══════════════════════════════════════
                 NOTIFICATION (FUNGSIONAL)
                 ═══════════════════════════════════════ --}}
            <div 
                x-data="{
                    open: false,
                    notifications: [],
                    total: 0,
                    loading: false,
                    seenIds: JSON.parse(localStorage.getItem('seenNotifs') || '[]'),
                    
                    async load() {
                        this.loading = true;
                        try {
                            const res = await fetch('{{ route('dashboard.notifications') }}');
                            const data = await res.json();
                            this.notifications = data.items || [];
                            // Filter yang belum dibaca
                            const unread = this.notifications.filter(n => !this.seenIds.includes(n.id));
                            this.total = unread.length;
                        } catch (e) {
                            console.error(e);
                        }
                        this.loading = false;
                    },
                    
                    markAllRead() {
                        this.seenIds = this.notifications.map(n => n.id);
                        localStorage.setItem('seenNotifs', JSON.stringify(this.seenIds));
                        this.total = 0;
                    }
                }"
                x-init="
                    load();
                    setInterval(() => load(), 60000);
                "
                class="relative"
            >
                <button 
                    @click="open = !open; if (open) load();"
                    @click.away="open = false"
                    class="relative p-2 rounded-xl hover:bg-light-hover text-light-muted 
                           hover:text-gold-dark transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    {{-- Badge --}}
                    <template x-if="total > 0">
                        <span class="absolute top-1 right-1 min-w-[16px] h-4 px-1 
                                     bg-red-500 text-white text-[10px] font-bold
                                     rounded-full flex items-center justify-center
                                     shadow-sm shadow-red-500/40"
                              x-text="total > 9 ? '9+' : total"></span>
                    </template>
                </button>

                <div 
                    x-show="open"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                    class="absolute right-0 mt-2 w-80 panel-light p-0 shadow-xl z-50"
                >
                    <div class="px-4 py-3 flex items-center justify-between">
                        <h3 class="font-display font-semibold text-sm text-light-text">Notifikasi</h3>
                        <button @click="markAllRead()"
                                class="text-[10px] text-gold-dark hover:underline font-medium">
                            Tandai semua dibaca
                        </button>
                    </div>

                    <div class="divider-light"></div>

                    <div class="max-h-80 overflow-y-auto custom-scrollbar">
                        {{-- Loading --}}
                        <div x-show="loading" class="p-6 text-center">
                            <div class="inline-block w-5 h-5 border-2 border-gold border-t-transparent rounded-full animate-spin"></div>
                        </div>

                        {{-- List --}}
                        <template x-for="(n, i) in notifications" :key="i">
                            <a :href="n.url" 
                               class="flex gap-3 px-4 py-3 hover:bg-light-hover transition-colors">
                                <div class="w-10 h-10 rounded-xl bg-light-bg 
                                            flex items-center justify-center shrink-0">
                                    <span class="text-base" x-text="n.icon"></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-0.5">
                                        <p class="text-xs font-semibold text-gold-dark" x-text="n.title"></p>
                                        <template x-if="!seenIds.includes(n.id)">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full shrink-0 mt-1"></span>
                                        </template>
                                    </div>
                                    <p class="text-sm text-light-text line-clamp-2" x-text="n.desc"></p>
                                    <p class="text-[10px] text-light-muted/70 mt-1" x-text="n.time"></p>
                                </div>
                            </a>
                        </template>

                        {{-- Empty --}}
                        <div x-show="!loading && notifications.length === 0" class="p-8 text-center">
                            <div class="text-4xl mb-2 opacity-40">🔔</div>
                            <p class="text-xs text-light-muted">Belum ada notifikasi</p>
                        </div>
                    </div>

                    <div class="divider-light"></div>
                    <a href="#" class="block text-center text-xs text-gold-dark hover:text-gold 
                                      py-3 hover:bg-gold/[0.04] transition-colors rounded-b-2xl font-medium">
                        Lihat Semua Notifikasi
                    </a>
                </div>
            </div>

            {{-- Profile --}}
            <div x-data="{ open: false }" class="relative ml-1">
                <button 
                    @click="open = !open"
                    @click.away="open = false"
                    class="flex items-center gap-2 p-1 pr-2 rounded-2xl hover:bg-light-hover 
                           transition-colors group"
                >
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" 
                             class="w-8 h-8 rounded-xl object-cover">
                    @else
                        <div class="w-8 h-8 rounded-xl gradient-gold flex items-center justify-center
                                    font-display font-bold text-bg-primary text-sm
                                    shadow-sm shadow-gold/30">
                            {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}
                        </div>
                    @endif
                    
                    <div class="hidden lg:block text-left leading-tight">
                        <p class="text-xs font-medium text-light-text max-w-[120px] truncate">
                            {{ explode(' ', auth()->user()->nama_lengkap)[0] }}
                        </p>
                        <p class="text-[10px] text-gold-dark font-medium">
                            {{ auth()->user()->role->label() }}
                        </p>
                    </div>

                    <svg class="w-3.5 h-3.5 text-light-muted transition-transform hidden lg:block" 
                         :class="{ 'rotate-180': open }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div 
                    x-show="open"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                    class="absolute right-0 mt-2 w-64 panel-light p-0 shadow-xl z-50 overflow-hidden"
                >
                    <div class="p-4 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gold/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                        <div class="relative flex items-center gap-3 mb-3">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" 
                                     class="w-12 h-12 rounded-2xl object-cover">
                            @else
                                <div class="w-12 h-12 rounded-2xl gradient-gold flex items-center justify-center
                                            font-display font-bold text-bg-primary text-lg
                                            shadow-md shadow-gold/30">
                                    {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="font-medium text-sm text-light-text truncate">
                                    {{ auth()->user()->nama_lengkap }}
                                </p>
                                <p class="text-xs text-light-muted truncate">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="badge-gold text-[10px]">
                                {{ auth()->user()->role->label() }}
                            </span>
                            @if(auth()->user()->kepengurusanAktif())
                                <span class="text-[10px] text-light-muted truncate">
                                    {{ auth()->user()->kepengurusanAktif()->jabatan->nama_jabatan }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="divider-light"></div>

                    <div class="p-1.5">
                        <a href="{{ route('profile.show') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm
                                  text-light-muted hover:bg-light-hover hover:text-gold-dark transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profil Saya
                        </a>

                        <a href="{{ route('users.index') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm
                                  text-light-muted hover:bg-light-hover hover:text-gold-dark transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Cari Anggota
                        </a>

                        <a href="{{ route('home') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm
                                  text-light-muted hover:bg-light-hover hover:text-gold-dark transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Halaman Publik
                        </a>
                    </div>

                    <div class="divider-light"></div>

                    <div class="p-1.5">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm
                                           text-red-500 hover:bg-red-50 transition-all font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile search bar --}}
    <div 
        x-show="searchOpen"
        x-cloak
        x-transition
        class="md:hidden px-4 pb-3 pt-1 bg-white"
    >
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-light-muted" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input 
                type="text"
                x-model="searchQuery"
                @input.debounce.300ms="doSearch()"
                placeholder="Cari..."
                class="w-full pl-10 pr-4 py-2.5 rounded-2xl text-sm
                       bg-light-bg border border-light-border
                       text-light-text placeholder-light-muted/70
                       focus:outline-none focus:bg-white
                       focus:border-gold/50 focus:ring-2 focus:ring-gold/20"
            >
        </div>
    </div>
</header>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.2); }
</style>