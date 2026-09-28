@php
    $waNumber = '62811242678';
    $waText = urlencode('Halo Kesenian Giri Adiwarna! Saya ingin bertanya. Terima kasih 🙏');
@endphp

<footer class="bg-bg-secondary border-t border-gold/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">

            {{-- ═══════════════════════════════════════
                 Kolom 1: Brand
                 ═══════════════════════════════════════ --}}
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <img 
                        src="{{ asset('images/logo.png') }}" 
                        alt="Logo" 
                        class="w-12 h-12 object-contain"
                        onerror="this.style.display='none'"
                    >
                    <div>
                        <h3 class="font-display font-bold text-xl gold-text">
                            Giri Adiwarna
                        </h3>
                        <p class="text-text-muted text-sm">SMKN 1 Banjar</p>
                    </div>
                </div>
                <p class="text-text-muted text-sm leading-relaxed max-w-md">
                    Organisasi kesenian resmi SMKN 1 Banjar yang mewadahi kreativitas siswa dalam 
                    seni tradisional dan modern. Berkarya, berprestasi, dan melestarikan budaya.
                </p>

                {{-- Social Media --}}
                <div class="flex items-center gap-3 mt-6">
                    {{-- Instagram --}}
                    <a href="https://www.instagram.com/kesenian_smkn1banjar/" 
                       target="_blank" rel="noopener"
                       class="w-10 h-10 rounded-lg bg-bg-card hover:bg-gold hover:text-bg-primary 
                              flex items-center justify-center transition-all duration-200 hover:-translate-y-1"
                       aria-label="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>

                    {{-- TikTok --}}
                    <a href="https://www.tiktok.com/@kesenian_smkn1" 
                       target="_blank" rel="noopener"
                       class="w-10 h-10 rounded-lg bg-bg-card hover:bg-gold hover:text-bg-primary 
                              flex items-center justify-center transition-all duration-200 hover:-translate-y-1"
                       aria-label="TikTok">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                    </a>

                    {{-- WhatsApp — auto text --}}
                    <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" 
                       target="_blank" rel="noopener"
                       class="w-10 h-10 rounded-lg bg-bg-card hover:bg-gold hover:text-bg-primary 
                              flex items-center justify-center transition-all duration-200 hover:-translate-y-1"
                       aria-label="WhatsApp">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- ═══════════════════════════════════════
                 Kolom 2: Navigasi
                 ═══════════════════════════════════════ --}}
            <div>
                <h4 class="font-display font-semibold text-text-primary mb-4">Navigasi</h4>
                <ul class="space-y-2">
                    <li>
                        <a href="#about" class="text-text-muted hover:text-gold text-sm transition-colors">
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="#visi-misi" class="text-text-muted hover:text-gold text-sm transition-colors">
                            Visi & Misi
                        </a>
                    </li>
                    <li>
                        <a href="#divisi" class="text-text-muted hover:text-gold text-sm transition-colors">
                            Divisi
                        </a>
                    </li>
                    <li>
                        <a href="#prestasi" class="text-text-muted hover:text-gold text-sm transition-colors">
                            Prestasi
                        </a>
                    </li>
                    <li>
                        <a href="#dokumentasi" class="text-text-muted hover:text-gold text-sm transition-colors">
                            Dokumentasi
                        </a>
                    </li>
                    <li>
                        <a href="#event" class="text-text-muted hover:text-gold text-sm transition-colors">
                            Event
                        </a>
                    </li>
                    <li>
                        <a href="#kontak" class="text-text-muted hover:text-gold text-sm transition-colors">
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>

            {{-- ═══════════════════════════════════════
                 Kolom 3: Kontak
                 ═══════════════════════════════════════ --}}
            <div>
                <h4 class="font-display font-semibold text-text-primary mb-4">Kontak</h4>
                <ul class="space-y-3 text-sm">

                    {{-- Alamat --}}
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-gold mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-text-muted">
                            SMKN 1 Banjar,<br>Jawa Barat, Indonesia
                        </span>
                    </li>

                    {{-- Email --}}
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-gold mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:kesenian_smkn1banjar@gmail.com" 
                           class="text-text-muted hover:text-gold transition-colors break-all">
                            kesenian_smkn1banjar@gmail.com
                        </a>
                    </li>

                    {{-- WhatsApp --}}
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-gold mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" 
                           target="_blank" rel="noopener"
                           class="text-text-muted hover:text-gold transition-colors">
                            +62 811-242-678
                        </a>
                    </li>

                </ul>
            </div>
        </div>

        {{-- ═══════════════════════════════════════
             BOTTOM BAR
             ═══════════════════════════════════════ --}}
        <div class="mt-12 pt-8 border-t border-border-dark flex flex-col md:flex-row 
                    items-center justify-between gap-4">
            <p class="text-text-muted text-sm text-center md:text-left">
                &copy; {{ date('Y') }} <span class="gold-text font-medium">Kesenian Giri Adiwarna</span> 
                — SMKN 1 Banjar. All rights reserved.
            </p>
            <p class="text-text-muted text-xs">
                Developed by 
                <span class="gold-text font-medium">M Raffa Izzel H</span>
            </p>
        </div>
    </div>
</footer>