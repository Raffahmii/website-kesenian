@php
    $user = auth()->user();
    $currentRoute = request()->route()?->getName() ?? '';
    
    $menuItems = [
        [
            'group' => 'Utama',
            'items' => [
                ['label' => 'Dashboard', 'route' => 'dashboard.index', 'active' => $currentRoute === 'dashboard.index', 'can' => null, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
            ],
        ],
        [
            'group' => 'Organisasi',
            'items' => [
                ['label' => 'Cari Anggota', 'route' => 'users.index', 'active' => str_starts_with($currentRoute, 'users.'), 'can' => null, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>'],
                ['label' => 'Anggota', 'route' => 'dashboard.members.index', 'active' => str_starts_with($currentRoute, 'dashboard.members'), 'can' => 'manage-members', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>'],
                ['label' => 'Kepengurusan', 'route' => 'dashboard.management', 'active' => str_starts_with($currentRoute, 'dashboard.management'), 'can' => 'access-admin', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>'],
            ],
        ],
        [
            'group' => 'Kegiatan',
            'items' => [
                ['label' => 'Jadwal & Event', 'route' => 'dashboard.events.index', 'active' => str_starts_with($currentRoute, 'dashboard.events'), 'can' => null, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                ['label' => 'Absensi', 'route' => 'dashboard.attendance', 'active' => str_starts_with($currentRoute, 'dashboard.attendance'), 'can' => null, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>'],
            ],
        ],
        [
            'group' => 'Keuangan',
            'items' => [
                ['label' => 'Kas & Pembayaran', 'route' => 'dashboard.cash', 'active' => str_starts_with($currentRoute, 'dashboard.cash'), 'can' => null, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
            ],
        ],
        [
            'group' => 'Konten',
            'items' => [
                ['label' => 'Dokumentasi', 'route' => 'dashboard.albums.index', 'active' => str_starts_with($currentRoute, 'dashboard.albums'), 'can' => null, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                ['label' => 'Prestasi', 'route' => 'dashboard.achievements.index', 'active' => str_starts_with($currentRoute, 'dashboard.achievements'), 'can' => null, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>'],
                ['label' => 'Pengumuman', 'route' => 'dashboard.announcements.index', 'active' => str_starts_with($currentRoute, 'dashboard.announcements'), 'can' => null, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>'],
            ],
        ],
        [
            'group' => 'Sistem',
            'items' => [
                ['label' => 'Laporan', 'route' => 'dashboard.reports', 'active' => str_starts_with($currentRoute, 'dashboard.reports'), 'can' => 'view-audit', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                ['label' => 'Audit Log', 'route' => 'dashboard.audit.index', 'active' => str_starts_with($currentRoute, 'dashboard.audit'), 'can' => 'view-audit', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                ['label' => 'Pengaturan', 'route' => 'dashboard.settings', 'active' => str_starts_with($currentRoute, 'dashboard.settings'), 'can' => 'access-admin', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>'],
            ],
        ],
    ];
@endphp

<aside 
    :class="{
        'translate-x-0': sidebarOpen || window.innerWidth >= 1024,
        '-translate-x-full': !sidebarOpen && window.innerWidth < 1024,
        'lg:w-64': !sidebarCollapsed,
        'lg:w-20': sidebarCollapsed
    }"
    class="fixed top-0 left-0 bottom-0 z-50 w-64 flex flex-col 
           transition-all duration-300 lg:translate-x-0
           bg-gradient-to-b from-bg-secondary to-bg-primary
           shadow-2xl shadow-black/30"
>
    {{-- HEADER — Logo --}}
    <div 
        class="h-16 flex items-center shrink-0 transition-all duration-300"
        :class="sidebarCollapsed ? 'lg:justify-center lg:px-0 px-4' : 'justify-between px-4'"
    >
        <a href="{{ route('home') }}" 
           class="flex items-center group overflow-hidden transition-all duration-300"
           :class="sidebarCollapsed ? 'lg:gap-0 gap-3' : 'gap-3'">
            <div class="relative shrink-0">
                <div class="absolute inset-0 rounded-xl bg-gold blur-lg opacity-20 group-hover:opacity-40 transition-opacity"></div>
                <img 
                    src="{{ asset('images/logo.png') }}" 
                    alt="Logo" 
                    class="relative w-9 h-9 object-contain transition-transform group-hover:scale-110"
                    onerror="this.style.display='none'"
                >
            </div>
            <div x-show="!sidebarCollapsed" x-transition class="leading-tight whitespace-nowrap">
                <div class="font-display font-bold text-sm gold-text">Giri Adiwarna</div>
                <div class="text-[10px] text-text-muted">Dashboard</div>
            </div>
        </a>

        <button @click="sidebarOpen = false" 
                class="lg:hidden p-1.5 rounded-lg hover:bg-bg-card/50 text-text-muted transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div class="divider-soft mx-4"></div>

    {{-- USER CARD — soft, no border --}}
    <div 
        class="shrink-0 transition-all duration-300"
        :class="sidebarCollapsed ? 'lg:p-3 p-3' : 'p-3'"
    >
        <div 
            class="flex items-center rounded-2xl transition-all duration-300
                   bg-gradient-to-br from-bg-card/60 to-bg-card/20
                   shadow-lg shadow-black/10"
            :class="sidebarCollapsed ? 'lg:justify-center lg:gap-0 lg:p-2 p-2.5 gap-3' : 'gap-3 p-3'"
        >
            <div class="relative shrink-0">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" 
                         class="w-10 h-10 rounded-xl object-cover">
                @else
                    <div class="w-10 h-10 rounded-xl gradient-gold flex items-center justify-center
                                font-display font-bold text-bg-primary">
                        {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                    </div>
                @endif
                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 rounded-full 
                             border-2 border-bg-secondary shadow-md shadow-green-500/50"></span>
            </div>

            <div x-show="!sidebarCollapsed" x-transition class="flex-1 min-w-0 overflow-hidden">
                <p class="font-medium text-sm text-text-primary truncate leading-tight">
                    {{ $user->nama_lengkap }}
                </p>
                <p class="text-xs text-gold truncate leading-tight">
                    {{ $user->role->label() }}
                </p>
            </div>
        </div>
    </div>

    {{-- MENU --}}
    <nav class="flex-1 overflow-y-auto px-3 pb-3 space-y-5 custom-scrollbar">
        @foreach($menuItems as $group)
            @php
                $visibleItems = collect($group['items'])->filter(function($item) {
                    $can = $item['can'] ?? null;
                    return is_null($can) || auth()->user()->can($can);
                })->values();
            @endphp

            @if($visibleItems->isNotEmpty())
                <div>
                    <p x-show="!sidebarCollapsed" 
                       class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-[0.15em] text-text-muted/70">
                        {{ $group['group'] }}
                    </p>

                    <ul class="space-y-1">
                        @foreach($visibleItems as $item)
                            <li>
                                <a 
                                    href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                                    class="group flex items-center rounded-xl 
                                           transition-all duration-200 relative
                                           {{ $item['active'] 
                                                ? 'menu-active' 
                                                : 'text-text-muted hover:text-text-primary hover:bg-bg-card/40' }}"
                                    :class="sidebarCollapsed 
                                        ? 'lg:justify-center lg:px-0 lg:py-3 px-3 py-2.5 gap-3' 
                                        : 'gap-3 px-3 py-2.5'"
                                    title="{{ $item['label'] }}"
                                >
                                    @if($item['active'])
                                        {{-- Left gold indicator --}}
                                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-7 
                                                     bg-gold rounded-r-full shadow-md shadow-gold/50"></span>
                                    @endif

                                    <svg class="w-5 h-5 shrink-0 {{ $item['active'] ? 'text-gold drop-shadow-[0_0_8px_rgba(245,179,1,0.5)]' : 'group-hover:text-gold' }} transition-colors" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        {!! $item['icon'] !!}
                                    </svg>

                                    <span 
                                        x-show="!sidebarCollapsed" 
                                        x-transition 
                                        class="text-sm font-medium whitespace-nowrap overflow-hidden"
                                    >
                                        {{ $item['label'] }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endforeach
    </nav>

    {{-- FOOTER — Collapse --}}
    <div class="p-3 shrink-0">
        <div class="divider-soft mb-3"></div>
        <button 
            @click="toggleSidebar()"
            class="hidden lg:flex w-full items-center rounded-xl 
                   text-text-muted hover:bg-bg-card/40 hover:text-text-primary 
                   transition-all duration-200"
            :class="sidebarCollapsed ? 'justify-center py-3 gap-0' : 'gap-3 px-3 py-2.5'"
            :title="sidebarCollapsed ? 'Expand' : 'Collapse'"
        >
            <svg 
                class="w-5 h-5 shrink-0 transition-transform duration-300"
                :class="{ 'rotate-180': sidebarCollapsed }"
                fill="none" stroke="currentColor" viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
            <span 
                x-show="!sidebarCollapsed" 
                x-transition 
                class="text-sm font-medium whitespace-nowrap overflow-hidden"
            >
                Collapse
            </span>
        </button>
    </div>
</aside>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(245,179,1,0.15); border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(245,179,1,0.3); }
</style>