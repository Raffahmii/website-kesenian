@extends('layouts.public')

@section('title', 'Beranda')
@section('description', 'Kesenian Giri Adiwarna — Organisasi kesenian resmi SMKN 1 Banjar. 1 Suara, 1 Rasa, 1 Extra, We Are The Best Yes.')

@php
    $modalLogin    = 'href="javascript:void(0)" @click.prevent="$dispatch(\'open-auth-modal\', { tab: \'login\' })"';
    $modalRegister = 'href="javascript:void(0)" @click.prevent="$dispatch(\'open-auth-modal\', { tab: \'register\' })"';

    if (auth()->check()) {
        $actionLogin    = 'href="' . route('dashboard.index') . '"';
        $actionRegister = 'href="' . route('dashboard.index') . '"';
    } else {
        $actionLogin    = $modalLogin;
        $actionRegister = $modalRegister;
    }
@endphp

@section('content')

    {{-- ═══════════════════════════════════════════════════════
         SECTION 1: HERO
         ═══════════════════════════════════════════════════════ --}}
    <section 
        x-data="heroSection()"
        x-init="init()"
        class="relative min-h-screen flex items-center justify-center overflow-hidden -mt-16 md:-mt-20 pb-32"
    >
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat animate-hero-bg"
             style="background-image: url('{{ asset('images/wayang_background.jpg') }}'); opacity: 0.22;"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-bg-primary/70 via-bg-primary/40 to-bg-primary"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-bg-primary via-transparent to-bg-secondary"></div>

        <div 
            class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[600px] md:w-[900px] md:h-[900px] rounded-full blur-3xl opacity-20 pointer-events-none"
            :style="`transform: translate(-50%, ${scrollY * 0.3}px)`"
            style="background: radial-gradient(circle, #F5B301 0%, transparent 70%);"
        ></div>

        <div class="absolute top-20 left-10 w-72 h-72 bg-gold/5 rounded-full blur-3xl pointer-events-none animate-float-slow"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-gold/5 rounded-full blur-3xl pointer-events-none animate-float-slow" style="animation-delay: -3s"></div>

        <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
             style="background-image: linear-gradient(#F5B301 1px, transparent 1px), linear-gradient(90deg, #F5B301 1px, transparent 1px); background-size: 60px 60px;"></div>

        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20 md:pt-32 md:pb-18 text-center">

            <div class="mb-8 flex justify-center" data-aos="zoom-in" data-aos-duration="1000">
                <div class="relative" :style="`transform: translateY(${scrollY * 0.15}px)`">
                    <div class="absolute inset-0 rounded-full bg-gold blur-2xl opacity-30 animate-glow"></div>
                    <img 
                        src="{{ asset('images/logo.png') }}" 
                        alt="Logo Kesenian Giri Adiwarna"
                        class="relative w-32 h-32 md:w-40 md:h-40 object-contain drop-shadow-2xl animate-float-slow"
                        onerror="this.style.display='none'"
                    >
                </div>
            </div>

            <div class="inline-flex items-center gap-2 badge-gold mb-6 backdrop-blur-sm"
                 data-aos="fade-down" data-aos-delay="200">
                <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                <span class="text-xs tracking-widest uppercase font-medium">
                    Ekstrakurikuler Kesenian · SMKN 1 Banjar
                </span>
            </div>

            <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-display font-bold mb-6 leading-[1.05] tracking-tight"
                data-aos="fade-up" data-aos-delay="300">
                <span class="block text-text-primary">Giri</span>
                <span class="block gold-text relative inline-block">
                    Adiwarna
                    <svg class="absolute -bottom-3 left-0 w-full" height="12" viewBox="0 0 300 12" fill="none">
                        <path d="M2 10C50 4 150 2 298 6" stroke="#F5B301" stroke-width="3" stroke-linecap="round"
                              stroke-dasharray="300" stroke-dashoffset="300" class="animate-draw-line"/>
                    </svg>
                </span>
            </h1>

            <div class="text-lg md:text-2xl text-text-muted mb-10 font-medium h-10 md:h-12"
                 data-aos="fade-up" data-aos-delay="500">
                <span x-text="typedText"></span>
                <span class="inline-block w-0.5 h-6 md:h-7 bg-gold ml-1 align-middle animate-pulse"></span>
            </div>

            <p class="text-text-muted text-sm md:text-base max-w-2xl mx-auto mb-12 leading-relaxed"
               data-aos="fade-up" data-aos-delay="600">
                <span class="gold-text font-medium">Giri</span> berarti gunung, 
                <span class="gold-text font-medium">Adiwarna</span> berarti seni & keindahan.
                Menjunjung tinggi nilai seni budaya dengan dasar kekuatan dan solidaritas.
            </p>

            <div class="flex flex-wrap gap-4 justify-center" data-aos="fade-up" data-aos-delay="700">
                <a href="#about" class="btn-gold btn-lg group">
                    <svg class="w-5 h-5 transition-transform group-hover:rotate-45" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Jelajahi Organisasi
                </a>

                <a {!! $actionLogin !!} class="btn-outline btn-lg group backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Lihat Dokumentasi
                </a>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-bg-primary to-transparent pointer-events-none z-[3]"></div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         SECTION 2: STATS — Dinamis dari DB
         ═══════════════════════════════════════════════════════ --}}
    <section class="relative py-16 md:py-20 bg-bg-secondary border-y border-border-dark overflow-hidden">
        <div class="absolute inset-0 pointer-events-none"
             style="background-image: url('{{ asset('images/batik.jpeg') }}'); background-size: 380px; background-repeat: repeat; opacity: 0.08;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12">
                @foreach ($stats as $i => $stat)
                    <div class="text-center group"
                         x-data="counter({{ $stat['value'] }})"
                         x-init="start()"
                         data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                        <div class="text-4xl md:text-6xl font-display font-bold gold-text mb-2 leading-none
                                    transition-transform group-hover:scale-110">
                            <span x-text="current"></span><span>{{ $stat['suffix'] }}</span>
                        </div>
                        <div class="text-text-primary font-semibold text-sm md:text-base mb-1">
                            {{ $stat['label'] }}
                        </div>
                        <div class="text-text-muted text-xs">{{ $stat['desc'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         SECTION 3: ABOUT
         ═══════════════════════════════════════════════════════ --}}
    <section id="about" class="section bg-bg-primary relative overflow-hidden">
        <div class="absolute top-1/3 right-0 w-96 h-96 bg-gold/5 rounded-full blur-3xl pointer-events-none animate-float-slow"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">

            <div class="text-center mb-16" data-aos="fade-up">
                <span class="badge-gold mb-4 inline-block">Tentang Kami</span>
                <h2 class="section-title">
                    Lebih dari Sekadar <span class="gold-text">Ekstrakurikuler</span>
                </h2>
                <p class="section-subtitle">
                    Rumah bagi para seniman muda SMKN 1 Banjar untuk berkarya, berprestasi, dan melestarikan budaya bangsa.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-10">
                @php
                    $maknaNama = [
                        ['title' => 'Giri', 'subtitle' => 'Sanskerta', 'desc' => 'Berarti Gunung — melambangkan kekuatan, keteguhan, dan solidaritas yang kokoh.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 20l8-16 8 16M7 14h10"/>'],
                        ['title' => 'Adiwarna', 'subtitle' => 'Sanskerta', 'desc' => 'Berarti Seni / Keindahan — ekspresi kreativitas dan pelestarian budaya Indonesia.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>'],
                    ];
                @endphp

                @foreach($maknaNama as $i => $item)
                    <div class="card-hover relative overflow-hidden group h-full"
                         data-aos="fade-{{ $i === 0 ? 'right' : 'left' }}">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gold/[0.06] rounded-full blur-3xl -mr-16 -mt-16
                                    group-hover:bg-gold/[0.12] transition-all duration-500"></div>
                        <div class="relative flex items-start gap-4 h-full">
                            <div class="shrink-0 w-14 h-14 rounded-2xl bg-gold/10 flex items-center justify-center
                                        group-hover:scale-110 group-hover:bg-gold/20 transition-all duration-300">
                                <svg class="w-7 h-7 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $item['icon'] !!}
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-display font-bold text-xl text-text-primary mb-1">
                                    {{ $item['title'] }}
                                    <span class="text-text-muted text-xs font-normal ml-1">({{ $item['subtitle'] }})</span>
                                </h4>
                                <p class="text-text-muted text-sm leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-6 md:p-8 rounded-2xl bg-bg-card border border-border-dark border-l-4 border-l-gold mb-12
                        hover:border-l-gold/60 transition-all duration-500"
                 data-aos="fade-up">
                <p class="text-text-primary italic leading-relaxed text-center md:text-lg">
                    "Bahwa Kesenian SMKN 1 Banjar menjunjung tinggi nilai seni budaya 
                    dengan dasar kekuatan dan solidaritas untuk mencapai kesuksesan bersama."
                </p>
            </div>

            <div class="text-center mb-8" data-aos="fade-up">
                <h3 class="text-2xl md:text-3xl font-display font-bold mb-2">
                    Makna <span class="gold-text">Logo</span> Kami
                </h3>
                <p class="text-text-muted text-sm">Empat elemen yang menyatukan arti</p>
            </div>

            @php
                $maknaLogo = [
                    ['title' => 'Keris & Bagan', 'desc' => 'Karya seni khas Indonesia — menjunjung tinggi nilai budaya bangsa.'],
                    ['title' => 'Warna Emas & Putih', 'desc' => 'Kesenian dan kejayaan, dilandasi keimanan kepada Tuhan.'],
                    ['title' => 'Dasar Hitam', 'desc' => 'Nilai estetika seni harus dipertahankan dan dilestarikan.'],
                    ['title' => 'Sayap Emas', 'desc' => 'Bersama-sama menjaga, berjaya, dan melestarikan kesenian.'],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($maknaLogo as $i => $item)
                    <div class="card-hover group text-center h-full flex flex-col"
                         data-aos="zoom-in" data-aos-delay="{{ $i * 100 }}">
                        <div class="w-12 h-12 mx-auto rounded-2xl bg-gold/10 border border-gold/30 
                                    flex items-center justify-center text-gold font-display font-bold text-lg
                                    group-hover:bg-gold group-hover:text-bg-primary 
                                    group-hover:scale-110 transition-all duration-300">
                            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <h4 class="font-display font-semibold text-sm text-text-primary mt-4 mb-2">
                            {{ $item['title'] }}
                        </h4>
                        <p class="text-text-muted text-xs leading-relaxed flex-1">
                            {{ $item['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         SECTION 4: VISI & MISI
         ═══════════════════════════════════════════════════════ --}}
    <section id="visi-misi" class="section bg-bg-secondary relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none"
             style="background-image: url('{{ asset('images/batik.jpeg') }}'); background-size: 380px; background-repeat: repeat; opacity: 0.08;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-16" data-aos="fade-up">
                <span class="badge-gold mb-4 inline-block">Visi & Misi</span>
                <h2 class="section-title">
                    Arah & <span class="gold-text">Tujuan</span> Kami
                </h2>
                <p class="section-subtitle">
                    Fondasi yang menggerakkan setiap langkah Kesenian Giri Adiwarna.
                </p>
            </div>

            <div class="grid lg:grid-cols-5 gap-8">
                <div class="lg:col-span-2" data-aos="fade-right">
                    <div class="card-hover h-full relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gold/10 rounded-full blur-3xl -mr-16 -mt-16
                                    group-hover:scale-125 transition-transform duration-500"></div>
                        <div class="relative">
                            <div class="w-14 h-14 rounded-2xl gradient-gold flex items-center justify-center mb-6 shadow-lg shadow-gold/30
                                        group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-bg-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                            <span class="text-xs tracking-widest uppercase text-gold font-medium mb-2 block">Visi</span>
                            <h3 class="text-2xl font-display font-bold mb-4">Visi Kami</h3>
                            <p class="text-text-muted leading-relaxed">
                                Menjadi wadah kesenian yang unggul di SMKN 1 Banjar dalam melestarikan 
                                seni budaya Indonesia, membentuk generasi kreatif, dan mengukir prestasi 
                                di tingkat nasional dengan menjunjung tinggi solidaritas.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3" data-aos="fade-left">
                    <div class="card-hover h-full">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-gold/10 border border-gold/30 flex items-center justify-center">
                                <svg class="w-7 h-7 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs tracking-widest uppercase text-gold font-medium block">Misi</span>
                                <h3 class="text-2xl font-display font-bold">Misi Kami</h3>
                            </div>
                        </div>

                        @php
                            $misi = [
                                'Mengembangkan minat dan bakat seni siswa dalam berbagai bidang kesenian.',
                                'Melestarikan seni budaya tradisional Indonesia, khususnya Jawa Barat.',
                                'Menciptakan lingkungan organisasi yang solid, kreatif, dan inklusif.',
                                'Mengikuti berbagai kompetisi seni untuk mengukir prestasi.',
                                'Membangun karakter seniman muda yang berintegritas dan berbudaya.',
                            ];
                        @endphp

                        <ul class="space-y-4">
                            @foreach ($misi as $i => $item)
                                <li class="flex gap-3 group" data-aos="fade-left" data-aos-delay="{{ $i * 100 }}">
                                    <div class="shrink-0 w-6 h-6 rounded-full bg-gold/20 border border-gold/40 
                                                flex items-center justify-center text-gold text-xs font-bold mt-0.5
                                                group-hover:bg-gold group-hover:text-bg-primary 
                                                group-hover:scale-110 transition-all duration-300">
                                        {{ $i + 1 }}
                                    </div>
                                    <p class="text-text-muted leading-relaxed group-hover:text-text-primary transition-colors">
                                        {{ $item }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         SECTION 5: DIVISI
         ═══════════════════════════════════════════════════════ --}}
    <section id="divisi" class="section bg-bg-primary relative overflow-hidden">
        <div class="absolute top-1/2 right-0 w-96 h-96 bg-gold/5 rounded-full blur-3xl pointer-events-none animate-float-slow"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">

            <div class="text-center mb-16" data-aos="fade-up">
                <span class="badge-gold mb-4 inline-block">Divisi</span>
                <h2 class="section-title">
                    Enam Panggung <span class="gold-text">Berkarya</span>
                </h2>
                <p class="section-subtitle">
                    Setiap divisi punya karakter, warna, dan panggungnya sendiri. 
                    Semua bersatu dalam satu rasa.
                </p>
            </div>

            @php
                $divisi = [
                    ['nama' => 'Padus', 'slug' => 'padus', 'full' => 'Paduan Suara', 'desc' => 'Menyatukan suara dalam harmoni, menyentuh hati dengan nada.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>'],
                    ['nama' => 'Seni Tari', 'slug' => 'seni_tari', 'full' => 'Tari Tradisional & Modern', 'desc' => 'Menggerakkan tubuh dalam cerita, melestarikan tarian nusantara.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>'],
                    ['nama' => 'Dance', 'slug' => 'dance', 'full' => 'Modern Dance', 'desc' => 'Ekspresi bebas lewat gerakan modern, energik, dan penuh gaya.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>'],
                    ['nama' => 'Band', 'slug' => 'band', 'full' => 'Grup Band', 'desc' => 'Menggebrak panggung dengan aransemen musik yang powerful.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/>'],
                    ['nama' => 'Musik', 'slug' => 'musik', 'full' => 'Musik Tradisional & Modern', 'desc' => 'Memainkan alat musik dengan jiwa, dari tradisional hingga modern.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM15 8h6v6"/>'],
                    ['nama' => 'Seni', 'slug' => 'seni', 'full' => 'Seni Rupa & Teater', 'desc' => 'Menuangkan kreativitas dalam visual, panggung, dan cerita.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>'],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($divisi as $i => $div)
                    <a 
                        {!! $actionLogin !!}
                        class="group relative overflow-hidden rounded-3xl 
                               bg-bg-card aspect-[4/5]
                               cursor-pointer
                               transition-all duration-500
                               hover:-translate-y-2
                               hover:shadow-2xl hover:shadow-gold/20
                               ring-1 ring-border-dark hover:ring-2 hover:ring-gold/60"
                        data-aos="fade-up" 
                        data-aos-delay="{{ $i * 80 }}"
                    >
                        <img 
                            src="{{ asset('images/divisi/' . $div['slug'] . '.jpeg') }}" 
                            alt="{{ $div['nama'] }}"
                            class="absolute inset-0 w-full h-full object-cover 
                                   transition-transform duration-[1200ms] 
                                   group-hover:scale-110"
                            onerror="this.style.opacity='0'"
                        >

                        <div class="absolute inset-0 bg-gradient-to-br from-gold/20 via-bg-card to-bg-secondary -z-10"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-bg-primary via-bg-primary/50 to-transparent"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-gold/20 via-transparent to-transparent 
                                    opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                        <div class="absolute top-5 left-5 z-10">
                            <div class="w-12 h-12 rounded-2xl 
                                        bg-bg-primary/80 backdrop-blur-md
                                        border border-gold/30
                                        flex items-center justify-center
                                        group-hover:bg-gold group-hover:border-gold 
                                        group-hover:scale-110 group-hover:rotate-6
                                        transition-all duration-300">
                                <svg class="w-6 h-6 text-gold group-hover:text-bg-primary transition-colors" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $div['icon'] !!}
                                </svg>
                            </div>
                        </div>

                        <div class="absolute top-5 right-5 z-10">
                            <span class="text-[10px] tracking-[0.2em] font-mono text-gold/60">
                                {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 p-6 z-10">
                            <p class="text-[10px] text-gold uppercase tracking-[0.2em] mb-2 font-semibold">
                                {{ $div['full'] }}
                            </p>

                            <h3 class="font-display font-bold text-2xl md:text-3xl text-text-primary mb-3 
                                       transition-colors duration-300
                                       group-hover:text-gold">
                                {{ $div['nama'] }}
                            </h3>

                            <div class="w-8 h-0.5 bg-gold rounded-full mb-3
                                        transition-all duration-500
                                        group-hover:w-16"></div>

                            <p class="text-sm text-text-muted leading-relaxed
                                      max-h-0 opacity-0 overflow-hidden
                                      group-hover:max-h-32 group-hover:opacity-100
                                      transition-all duration-500 ease-out">
                                {{ $div['desc'] }}
                            </p>

                            <div class="flex items-center gap-2 text-gold text-xs font-semibold mt-4
                                        opacity-0 translate-y-4
                                        group-hover:opacity-100 group-hover:translate-y-0
                                        transition-all duration-500 delay-150">
                                <span class="tracking-wider uppercase">Selengkapnya</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         SECTION 6: PRESTASI — Dinamis dari DB
         ═══════════════════════════════════════════════════════ --}}
    <section id="prestasi" class="section bg-bg-secondary relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none"
             style="background-image: url('{{ asset('images/batik.jpeg') }}'); background-size: 380px; background-repeat: repeat; opacity: 0.08;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-16">
                <div data-aos="fade-right">
                    <span class="badge-gold mb-4 inline-block">Prestasi</span>
                    <h2 class="section-title text-left">
                        Jejak <span class="gold-text">Kemenangan</span>
                    </h2>
                    <p class="text-text-muted max-w-xl">
                        Setiap penghargaan adalah bukti dedikasi seniman muda Giri Adiwarna.
                    </p>
                </div>
                <a 
                    {!! $actionLogin !!}
                    class="btn-outline btn-sm self-start md:self-end group" 
                    data-aos="fade-left"
                >
                    Lihat Semua
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            @if($prestasis->isEmpty())
                <div class="panel-light text-center py-16" data-aos="fade-up">
                    <div class="text-5xl mb-3 opacity-50">🏆</div>
                    <p class="text-light-text font-medium mb-1">Belum ada prestasi tercatat</p>
                    <p class="text-light-muted text-sm">Prestasi akan muncul di sini setelah ditambahkan</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($prestasis as $i => $p)
                        @php
                            $peringkat = $p->peringkat ?? '-';
                            $svgIcon = '<path d="M7 4h10v6a5 5 0 0 1-10 0V4z"/><path d="M7 6H4.5a1.5 1.5 0 0 0-1.5 1.5v1A3.5 3.5 0 0 0 6.5 12H7"/><path d="M17 6h2.5a1.5 1.5 0 0 1 1.5 1.5v1a3.5 3.5 0 0 1-3.5 3.5H17"/><path d="M10 15h4v3h-4z"/><path d="M7 21h10"/><path d="M8.5 18h7"/><path d="M12 6l.7 1.6 1.7.2-1.3 1.2.4 1.7L12 9.8 10.5 10.7l.4-1.7-1.3-1.2 1.7-.2L12 6z"/>';
                        @endphp
                        <a href="javascript:void(0)" 
                           @click.prevent="$dispatch('open-auth-modal', { tab: 'login' })"
                           class="card-hover group relative overflow-hidden cursor-pointer block"
                           data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                            <div class="relative h-44 rounded-xl overflow-hidden mb-5
                                        bg-bg-primary border border-gold/20 
                                        flex items-center justify-center
                                        group-hover:border-gold/50 transition-colors">
                                @if($p->foto)
                                    <img src="{{ asset('storage/' . $p->foto) }}" 
                                         alt="{{ $p->nama_lomba }}"
                                         class="absolute inset-0 w-full h-full object-cover
                                                transition-transform duration-700 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-gradient-to-t from-bg-primary/90 via-transparent to-transparent"></div>
                                @else
                                    <div class="absolute inset-0 opacity-20"
                                         style="background-image: radial-gradient(circle at 50% 50%, rgba(245,179,1,0.4) 0%, transparent 70%);"></div>
                                    <svg class="w-24 h-24 text-gold group-hover:scale-110 transition-transform duration-500 relative" 
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" 
                                         stroke-linecap="round" stroke-linejoin="round">
                                        {!! $svgIcon !!}
                                    </svg>
                                @endif
                                <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 
                                            bg-bg-primary border-2 border-gold rounded-full 
                                            w-11 h-11 flex items-center justify-center
                                            font-display font-bold gold-text text-lg
                                            shadow-lg shadow-gold/20 z-10">
                                    {{ $peringkat }}
                                </div>
                            </div>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="badge-gold text-[10px]">{{ $p->tingkat->shortLabel() }}</span>
                                <span class="text-xs text-text-muted">·</span>
                                <span class="text-xs text-text-muted">{{ $p->tahun }}</span>
                            </div>
                            <h3 class="font-display font-bold text-lg text-text-primary mb-2 
                                       group-hover:text-gold transition-colors leading-snug">
                                {{ $p->nama_lomba }}
                            </h3>
                            <p class="text-text-muted text-xs">
                                Kategori: <span class="text-gold">{{ $p->kategori ?? '-' }}</span>
                            </p>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         SECTION 7: DOKUMENTASI — Dinamis dari DB
         ═══════════════════════════════════════════════════════ --}}
    <section id="dokumentasi" class="section bg-bg-primary relative overflow-hidden">
        <div class="absolute top-1/3 left-0 w-96 h-96 bg-gold/5 rounded-full blur-3xl pointer-events-none animate-float-slow"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">

            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-16">
                <div data-aos="fade-right">
                    <span class="badge-gold mb-4 inline-block">Dokumentasi</span>
                    <h2 class="section-title text-left">
                        Jejak <span class="gold-text">Karya</span> Kami
                    </h2>
                    <p class="text-text-muted max-w-xl">
                        Setiap momen latihan, pentas, dan kebersamaan terabadikan di sini.
                    </p>
                </div>
                <a 
                    {!! $actionLogin !!}
                    class="btn-outline btn-sm self-start md:self-end group" 
                    data-aos="fade-left"
                >
                    Buka Galeri
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            @if($albums->isEmpty())
                <div class="panel-light text-center py-16" data-aos="fade-up">
                    <div class="text-5xl mb-3 opacity-50">📸</div>
                    <p class="text-light-text font-medium mb-1">Belum ada dokumentasi</p>
                    <p class="text-light-muted text-sm">Album akan muncul setelah ditambahkan</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($albums as $i => $album)
                        <a 
                            {!! $actionLogin !!}
                            class="group relative overflow-hidden rounded-2xl bg-bg-card 
                                   border border-border-dark hover:border-gold/50
                                   transition-all duration-500 hover:-translate-y-1
                                   hover:shadow-2xl hover:shadow-gold/10
                                   block cursor-pointer"
                            data-aos="fade-up" data-aos-delay="{{ ($i % 6) * 80 }}"
                        >
                            <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-gold/20 to-bg-secondary">
                                @if($album->cover_image)
                                    <img src="{{ asset('storage/' . $album->cover_image) }}" 
                                         alt="{{ $album->judul }}"
                                         class="w-full h-full object-cover transition-transform duration-700 
                                                group-hover:scale-110 opacity-90 group-hover:opacity-100">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gold/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-bg-card via-bg-card/40 to-transparent"></div>

                                @if($album->kategori)
                                    <div class="absolute top-3 left-3">
                                        <span class="badge-gold text-[10px] backdrop-blur-sm">{{ $album->kategori }}</span>
                                    </div>
                                @endif

                                <div class="absolute bottom-3 right-3 flex items-center gap-1.5 
                                            bg-bg-primary/90 backdrop-blur-sm px-3 py-1.5 rounded-lg
                                            border border-gold/20">
                                    <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-xs text-text-primary font-medium">{{ $album->media_count }}</span>
                                </div>

                                <div class="absolute inset-0 bg-bg-primary/70 opacity-0 group-hover:opacity-100 
                                            transition-opacity flex items-center justify-center">
                                    <div class="w-12 h-12 rounded-full gradient-gold flex items-center justify-center
                                                transform scale-75 group-hover:scale-100 transition-transform">
                                        <svg class="w-5 h-5 text-bg-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" 
                                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="p-5">
                                <h3 class="font-display font-bold text-base text-text-primary mb-1 
                                           group-hover:text-gold transition-colors leading-snug">
                                    {{ $album->judul }}
                                </h3>
                                <p class="text-text-muted text-xs flex items-center gap-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $album->tanggal_kegiatan?->translatedFormat('M Y') ?? $album->created_at->translatedFormat('M Y') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         SECTION 8: EVENT — Dinamis dari DB
         ═══════════════════════════════════════════════════════ --}}
    <section id="event" class="section bg-bg-secondary relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none"
             style="background-image: url('{{ asset('images/batik.jpeg') }}'); background-size: 380px; background-repeat: repeat; opacity: 0.08;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-16">
                <div data-aos="fade-right">
                    <span class="badge-gold mb-4 inline-block">Agenda</span>
                    <h2 class="section-title text-left">
                        Event <span class="gold-text">Terdekat</span>
                    </h2>
                    <p class="text-text-muted max-w-xl">
                        Jangan lewatkan setiap panggung, latihan, dan pertemuan kami.
                    </p>
                </div>
                <a 
                    {!! $actionLogin !!}
                    class="btn-outline btn-sm self-start md:self-end group" 
                    data-aos="fade-left"
                >
                    Lihat Semua Event
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            @if($events->isEmpty())
                <div class="panel-light text-center py-16" data-aos="fade-up">
                    <div class="text-5xl mb-3 opacity-50">📅</div>
                    <p class="text-light-text font-medium mb-1">Belum ada event mendatang</p>
                    <p class="text-light-muted text-sm">Event akan muncul setelah ditambahkan</p>
                </div>
            @else
                @php
                    $warnaJenis = [
                        'latihan' => 'from-blue-500/20 to-blue-900/10',
                        'pentas'  => 'from-pink-500/20 to-pink-900/10',
                        'rapat'   => 'from-purple-500/20 to-purple-900/10',
                        'lomba'   => 'from-yellow-500/20 to-yellow-900/10',
                    ];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($events as $i => $event)
                        @php
                            $tanggal = \Carbon\Carbon::parse($event->tanggal);
                            $jenis = $event->jenis->value;
                            $warna = $warnaJenis[$jenis] ?? 'from-gold/20 to-gold/5';
                        @endphp

                        <a 
                            {!! $actionLogin !!}
                            class="card-hover group relative overflow-hidden flex gap-5 cursor-pointer block"
                            data-aos="fade-up" data-aos-delay="{{ $i * 100 }}"
                        >
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br {{ $warna }} 
                                        rounded-full blur-2xl -mr-16 -mt-16 pointer-events-none
                                        group-hover:scale-125 transition-transform duration-500"></div>

                            <div class="shrink-0 relative">
                                <div class="w-20 h-20 rounded-2xl gradient-gold 
                                            flex flex-col items-center justify-center
                                            shadow-lg shadow-gold/30
                                            group-hover:scale-105 group-hover:rotate-3 transition-transform duration-300">
                                    <span class="text-2xl font-display font-bold text-bg-primary leading-none">
                                        {{ $tanggal->format('d') }}
                                    </span>
                                    <span class="text-[10px] uppercase tracking-wider text-bg-primary/80 font-semibold mt-1">
                                        {{ $tanggal->translatedFormat('M') }}
                                    </span>
                                    <span class="text-[9px] text-bg-primary/60">
                                        {{ $tanggal->format('Y') }}
                                    </span>
                                </div>
                            </div>

                            <div class="relative flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="badge-gold text-[10px]">
                                        {{ $event->jenis->icon() }} {{ $event->jenis->label() }}
                                    </span>
                                </div>

                                <h3 class="font-display font-bold text-base md:text-lg text-text-primary mb-3 
                                           group-hover:text-gold transition-colors leading-snug">
                                    {{ $event->judul }}
                                </h3>

                                <div class="space-y-1.5 text-xs text-text-muted">
                                    @if($event->jam_mulai)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5 text-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ \Carbon\Carbon::parse($event->jam_mulai)->format('H:i') }} WIB</span>
                                        </div>
                                    @endif
                                    @if($event->lokasi)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5 text-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span class="truncate">{{ $event->lokasi }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         SECTION 9: KONTAK
         ═══════════════════════════════════════════════════════ --}}
    <section id="kontak" class="relative pt-20 md:pt-28 pb-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-bg-secondary via-bg-primary to-bg-secondary"></div>
        <div class="absolute inset-0 opacity-[0.03]"
             style="background-image: linear-gradient(#F5B301 1px, transparent 1px), linear-gradient(90deg, #F5B301 1px, transparent 1px); background-size: 60px 60px;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 
                    w-[600px] h-[600px] rounded-full blur-3xl opacity-10 pointer-events-none"
             style="background: radial-gradient(circle, #F5B301 0%, transparent 70%);"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">

            <div data-aos="fade-up">
                <span class="badge-gold mb-6 inline-block">Kontak</span>
                <h2 class="text-3xl md:text-5xl lg:text-6xl font-display font-bold mb-6 leading-tight">
                    Punya Pertanyaan?<br>
                    <span class="gold-text">Mari Bicara.</span>
                </h2>
                <p class="text-text-muted max-w-2xl mx-auto mb-12 text-base md:text-lg">
                    Ingin bergabung, berkolaborasi, atau sekadar menyapa? 
                    Kami terbuka untuk siapa saja yang cinta seni dan budaya.
                </p>
            </div>

            @php
                $waNumber = '62811242678';
                $waText = urlencode('Halo Kesenian Giri Adiwarna! Saya ingin bertanya / bergabung. Terima kasih 🙏');
                
                $kontak = [
                    [
                        'label' => 'WhatsApp',
                        'value' => '+62 811-242-678',
                        'href' => "https://wa.me/{$waNumber}?text={$waText}",
                        'target' => '_blank',
                        'icon' => 'M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z',
                    ],
                    [
                        'label' => 'Instagram',
                        'value' => '@kesenian_smkn1banjar',
                        'href' => 'https://www.instagram.com/kesenian_smkn1banjar/',
                        'target' => '_blank',
                        'icon' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z',
                    ],
                    [
                        'label' => 'TikTok',
                        'value' => '@kesenian_smkn1',
                        'href' => 'https://www.tiktok.com/@kesenian_smkn1',
                        'target' => '_blank',
                        'icon' => 'M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z',
                    ],
                    [
                        'label' => 'Email',
                        'value' => 'kesenian_smkn1banjar',
                        'href' => 'mailto:kesenian_smkn1banjar@gmail.com',
                        'target' => null,
                        'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12" data-aos="fade-up" data-aos-delay="200">
                @foreach ($kontak as $i => $k)
                    <a 
                        href="{{ $k['href'] }}"
                        @if($k['target']) target="{{ $k['target'] }}" rel="noopener" @endif
                        class="card-hover group text-center"
                        data-aos="zoom-in" data-aos-delay="{{ 300 + ($i * 100) }}"
                    >
                        <div class="w-12 h-12 mx-auto rounded-xl bg-gold/10 border border-gold/30 
                                    flex items-center justify-center mb-4
                                    group-hover:bg-gold group-hover:border-gold 
                                    group-hover:scale-110 group-hover:-rotate-6 transition-all">
                            <svg class="w-5 h-5 text-gold group-hover:text-bg-primary transition-colors" 
                                 fill="currentColor" viewBox="0 0 24 24">
                                <path d="{{ $k['icon'] }}"/>
                            </svg>
                        </div>
                        <div class="text-xs uppercase tracking-wider text-text-muted mb-1">
                            {{ $k['label'] }}
                        </div>
                        <div class="font-medium text-text-primary text-xs group-hover:text-gold transition-colors break-all">
                            {{ $k['value'] }}
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="flex flex-wrap gap-4 justify-center pb-20" data-aos="fade-up" data-aos-delay="600">
                <a {!! $actionRegister !!} class="btn-gold btn-lg group">
                    Gabung Sekarang
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="#about" class="btn-outline btn-lg">Pelajari Dulu</a>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
<script>
    function heroSection() {
        return {
            scrollY: 0,
            typedText: '',
            fullText: '1 Suara · 1 Rasa · 1 Extra · We Are The Best Yes',
            
            init() {
                window.addEventListener('scroll', () => {
                    this.scrollY = window.scrollY;
                });

                let i = 0;
                const fullText = this.fullText;
                const self = this;

                const typeChar = () => {
                    if (i <= fullText.length) {
                        self.typedText = fullText.substring(0, i);
                        i++;
                        setTimeout(typeChar, 50);
                    } else {
                        setTimeout(deleteChar, 2000);
                    }
                };

                const deleteChar = () => {
                    if (i >= 0) {
                        self.typedText = fullText.substring(0, i);
                        i--;
                        setTimeout(deleteChar, 30);
                    } else {
                        setTimeout(typeChar, 500);
                    }
                };

                setTimeout(typeChar, 800);
            }
        }
    }

    function counter(target) {
        return {
            current: 0,
            started: false,
            
            start() {
                const el = this.$el;
                const self = this;
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !self.started) {
                            self.started = true;
                            self.animate(target);
                            observer.unobserve(el);
                        }
                    });
                }, { threshold: 0.5 });
                
                observer.observe(el);
            },

            animate(target) {
                const duration = 1500;
                const step = target / (duration / 16);
                let current = 0;

                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        this.current = target;
                        clearInterval(timer);
                    } else {
                        this.current = Math.floor(current);
                    }
                }, 16);
            }
        }
    }
</script>
@endpush