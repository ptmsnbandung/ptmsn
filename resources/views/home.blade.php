<x-layouts.app>
    <!-- 1. HERO JUMBOTRON (GET YOUR IT SOLUTION) -->
    <x-hero />

    <!-- 2 & 3. UNIFIED ABOUT & CLIENT LOGOS SECTION WITH RICH AMBIENT TECH BACKGROUND -->
    <div class="relative z-10 w-full overflow-hidden bg-gradient-to-b from-[#f8fafc] via-[#f0f9ff]/70 to-[#f8fafc] border-b border-slate-200/90">
        <!-- Subtle High-Tech Micro Dot Grid -->
        <div class="absolute inset-0 pointer-events-none z-0 opacity-70" style="background-image: radial-gradient(rgba(2, 132, 199, 0.14) 1px, transparent 1px); background-size: 28px 28px;"></div>
        
        <!-- Ambient Glowing Tech Lighting Orbs -->
        <div class="absolute top-1/4 -left-20 w-[600px] h-[600px] bg-sky-200/40 rounded-full blur-[140px] pointer-events-none z-0"></div>
        <div class="absolute bottom-1/4 -right-20 w-[600px] h-[600px] bg-blue-200/35 rounded-full blur-[140px] pointer-events-none z-0"></div>
        <div class="absolute top-2/3 left-1/2 -translate-x-1/2 w-[700px] h-[300px] bg-cyan-200/30 rounded-full blur-[120px] pointer-events-none z-0"></div>

        <div class="relative z-10">
            <!-- 2. ABOUT (Tentang PT Media Solusi Network — Siapa Kami, Statistik & Identitas) -->
            <x-about />

            <!-- 3. TRUST / CLIENTS (Dipercaya oleh Berbagai Perusahaan & Institusi) -->
            <x-client-logos :clients="$clients" />
        </div>
    </div>

    <!-- 5. SERVICES & SOLUTIONS (01 Internet, 02 Software Development, 03 IT Solution) -->
    <section id="layanan" class="py-20 sm:py-28 px-4 sm:px-6 lg:px-8 relative z-10 w-full overflow-hidden" style="background: linear-gradient(160deg, #07172e 0%, #0a1e3b 50%, #07172e 100%);">
        <!-- Ambient Glow & Architectural Grid -->
        <div class="absolute inset-0 pointer-events-none z-0" style="background-image: repeating-linear-gradient(115deg, rgba(255, 255, 255, 0.02) 0px, rgba(255, 255, 255, 0.02) 1px, transparent 1px, transparent 8px);"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-[#38bdf8]/10 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto relative z-10">
                       <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20" data-aos="fade-up">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/[0.08] border border-white/20 text-xs font-mono text-[#38bdf8] uppercase tracking-wider mb-4 font-semibold shadow-xs">
                    <span>Layanan & Portofolio Solusi</span>
                </div>
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl lg:text-[46px] text-white tracking-tight mb-5 leading-tight" data-reveal-words>
                    Solusi untuk Kebutuhan Konektivitas Anda.
                </h2>
                <p class="font-sans text-base sm:text-lg text-slate-300 leading-[1.7]">
                    Infrastruktur internet fiber optic, pengelolaan jaringan terpadu, dan rekayasa piranti lunak enterprise yang dirancang untuk mendukung stabilitas operasional bisnis Anda.
                </p>
            </div>

            <!-- Editorial 3-Column Structured Layout (01 Internet / 02 Software Development / 03 IT Solution) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 divide-y lg:divide-y-0 lg:divide-x divide-white/15 border-y border-white/15">
                
                <!-- 01 — Internet -->
                <div class="group p-6 sm:p-8 lg:p-10 flex flex-col justify-between transition-colors duration-300 hover:bg-white/[0.03]" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <!-- Real Photo Frame -->
                        <div class="relative w-full aspect-[16/10] rounded-2xl overflow-hidden mb-6 border border-white/15 shadow-lg group-hover:border-cyan-400/40 transition-all duration-300">
                            <img src="{{ asset('images/services/service-internet.jpg') }}" alt="Internet PT Media Solusi Network" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#07172e]/80 via-transparent to-transparent pointer-events-none"></div>
                        </div>

                        <div class="flex items-center justify-between mb-3">
                            <span class="font-mono font-extrabold text-3xl sm:text-4xl text-cyan-400/40 group-hover:text-[#38bdf8] transition-colors duration-300">
                                01
                            </span>
                            <span class="px-2.5 py-1 rounded-md bg-white/[0.06] border border-white/10 text-[10px] font-mono text-cyan-300/80 font-bold">
                                HIGH SPEED CONNECTIVITY
                            </span>
                        </div>

                        <h3 class="font-heading font-extrabold text-xl sm:text-2xl text-white tracking-tight mb-3 group-hover:text-[#38bdf8] transition-colors">
                            Internet
                        </h3>

                        <p class="font-sans text-sm sm:text-base text-slate-300 leading-[1.6] mb-6">
                            Layanan koneksi internet berkecepatan tinggi dengan kestabilan optimal untuk kebutuhan bisnis, perkantoran, dan perumahan.
                        </p>

                        <!-- Exact User Items List -->
                        <ul class="space-y-3 mb-8 text-xs sm:text-sm text-slate-200">
                            <li class="flex items-center gap-2.5">
                                <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400 shrink-0 text-base"></iconify-icon>
                                <span>Internet Dedicated Service</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400 shrink-0 text-base"></iconify-icon>
                                <span>Internet Broadband dan SOHO Access</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400 shrink-0 text-base"></iconify-icon>
                                <span>Last Mile Solution</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400 shrink-0 text-base"></iconify-icon>
                                <span>Collocation Service</span>
                            </li>
                        </ul>
                    </div>

                    <div class="pt-5 border-t border-white/10">
                        <a href="#kontak" class="inline-flex items-center gap-2 text-sm font-heading font-bold text-[#38bdf8] hover:text-white group-hover:translate-x-1.5 transition-all">
                            <span>Pelajari layanan</span>
                            <iconify-icon icon="solar:arrow-right-linear" width="16"></iconify-icon>
                        </a>
                    </div>
                </div>

                <!-- 02 — Software Development -->
                <div class="group p-6 sm:p-8 lg:p-10 flex flex-col justify-between transition-colors duration-300 hover:bg-white/[0.03]" data-aos="fade-up" data-aos-delay="200">
                    <div>
                        <!-- Real Photo Frame -->
                        <div class="relative w-full aspect-[16/10] rounded-2xl overflow-hidden mb-6 border border-white/15 shadow-lg group-hover:border-cyan-400/40 transition-all duration-300">
                            <img src="{{ asset('images/services/service-software.jpg') }}" alt="Software Development PT Media Solusi Network" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#07172e]/80 via-transparent to-transparent pointer-events-none"></div>
                        </div>

                        <div class="flex items-center justify-between mb-3">
                            <span class="font-mono font-extrabold text-3xl sm:text-4xl text-cyan-400/40 group-hover:text-[#38bdf8] transition-colors duration-300">
                                02
                            </span>
                            <span class="px-2.5 py-1 rounded-md bg-white/[0.06] border border-white/10 text-[10px] font-mono text-cyan-300/80 font-bold">
                                SOFTWARE ENGINEERING
                            </span>
                        </div>

                        <h3 class="font-heading font-extrabold text-xl sm:text-2xl text-white tracking-tight mb-3 group-hover:text-[#38bdf8] transition-colors">
                            Software Development
                        </h3>

                        <p class="font-sans text-sm sm:text-base text-slate-300 leading-[1.6] mb-6">
                            Rekayasa piranti lunak enterprise, pengembangan backend sistem terintegrasi, dan pemeliharaan aplikasi berbasis web.
                        </p>

                        <!-- Exact User Items List -->
                        <ul class="space-y-3 mb-8 text-xs sm:text-sm text-slate-200">
                            <li class="flex items-center gap-2.5">
                                <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400 shrink-0 text-base"></iconify-icon>
                                <span>Backend Web Development</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400 shrink-0 text-base"></iconify-icon>
                                <span>Maintance Web Base Software</span>
                            </li>
                        </ul>
                    </div>

                    <div class="pt-5 border-t border-white/10">
                        <a href="#kontak" class="inline-flex items-center gap-2 text-sm font-heading font-bold text-[#38bdf8] hover:text-white group-hover:translate-x-1.5 transition-all">
                            <span>Pelajari layanan</span>
                            <iconify-icon icon="solar:arrow-right-linear" width="16"></iconify-icon>
                        </a>
                    </div>
                </div>

                <!-- 03 — IT Solution -->
                <div class="group p-6 sm:p-8 lg:p-10 flex flex-col justify-between transition-colors duration-300 hover:bg-white/[0.03]" data-aos="fade-up" data-aos-delay="300">
                    <div>
                        <!-- Real Photo Frame -->
                        <div class="relative w-full aspect-[16/10] rounded-2xl overflow-hidden mb-6 border border-white/15 shadow-lg group-hover:border-cyan-400/40 transition-all duration-300">
                            <img src="{{ asset('images/services/service-infrastructure.jpg') }}" alt="IT Solution PT Media Solusi Network" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#07172e]/80 via-transparent to-transparent pointer-events-none"></div>
                        </div>

                        <div class="flex items-center justify-between mb-3">
                            <span class="font-mono font-extrabold text-3xl sm:text-4xl text-cyan-400/40 group-hover:text-[#38bdf8] transition-colors duration-300">
                                03
                            </span>
                            <span class="px-2.5 py-1 rounded-md bg-white/[0.06] border border-white/10 text-[10px] font-mono text-cyan-300/80 font-bold">
                                MANAGED SERVICES
                            </span>
                        </div>

                        <h3 class="font-heading font-extrabold text-xl sm:text-2xl text-white tracking-tight mb-3 group-hover:text-[#38bdf8] transition-colors">
                            IT Solution
                        </h3>

                        <p class="font-sans text-sm sm:text-base text-slate-300 leading-[1.6] mb-6">
                            Solusi infrastruktur teknologi komprehensif mulai dari telekonferensi berkualitas, optimalisasi jaringan QoS, hingga managed services.
                        </p>

                        <!-- Exact User Items List -->
                        <ul class="space-y-3 mb-8 text-xs sm:text-sm text-slate-200">
                            <li class="flex items-center gap-2.5">
                                <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400 shrink-0 text-base"></iconify-icon>
                                <span>Video Teleconference</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400 shrink-0 text-base"></iconify-icon>
                                <span>QOS Networking</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400 shrink-0 text-base"></iconify-icon>
                                <span>Network Managed Service</span>
                            </li>
                        </ul>
                    </div>

                    <div class="pt-5 border-t border-white/10">
                        <a href="#kontak" class="inline-flex items-center gap-2 text-sm font-heading font-bold text-[#38bdf8] hover:text-white group-hover:translate-x-1.5 transition-all">
                            <span>Pelajari layanan</span>
                            <iconify-icon icon="solar:arrow-right-linear" width="16"></iconify-icon>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- 6. COVERAGE (Cek Area Jaringan) -->
    <x-coverage-checker />

    <!-- 7. PACKAGES WITH FIXED NETWORK PARALLAX BACKGROUND -->
    <section id="paket" class="py-20 sm:py-28 px-4 sm:px-6 lg:px-8 relative z-10 w-full overflow-hidden bg-[#07172e] border-b border-white/10 bg-fixed bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/packages/network-bg.jpg') }}'); background-attachment: fixed; background-size: cover; background-position: center; background-repeat: no-repeat;">
        
        <!-- Ambient Cyber Glow & Translucent Dark Overlay for Optimal Readability -->
        <div class="absolute inset-0 bg-gradient-to-b from-[#07172e]/92 via-[#07172e]/80 to-[#07172e]/95 pointer-events-none z-0"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[400px] bg-[#38bdf8]/15 rounded-full blur-[130px] pointer-events-none z-0"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <!-- Header Section -->
            <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/[0.08] border border-white/20 text-xs font-mono text-[#38bdf8] uppercase tracking-wider mb-4 font-semibold shadow-xs backdrop-blur-md">
                    <span>Harga Transparan • Tanpa Biaya Tersembunyi</span>
                </div>
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl lg:text-[44px] text-white tracking-tight mb-4" data-reveal-words>
                    Pilihan Paket Internet Fiber Optic.
                </h2>
                <p class="font-sans text-base sm:text-lg text-slate-300 leading-[1.7] mb-6">
                    Koneksi 100% True Unlimited tanpa FUP dengan rasio simetris 1:1, latency rendah, dan dukungan teknisi profesional 24/7.
                </p>

                <!-- Value Proposition Badges -->
                <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4 text-xs font-heading font-semibold text-slate-200" data-aos="fade-up" data-aos-delay="150">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 shadow-2xs backdrop-blur-md">
                        <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400"></iconify-icon>
                        <span>Gratis Router WiFi</span>
                    </span>
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 shadow-2xs backdrop-blur-md">
                        <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400"></iconify-icon>
                        <span>Gratis Biaya Pasang*</span>
                    </span>
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 shadow-2xs backdrop-blur-md">
                        <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400"></iconify-icon>
                        <span>Tanpa Batasan FUP</span>
                    </span>
                </div>
            </div>

            <!-- 4 Clean Package Cards Grid (2 Columns on Mobile, 4 Columns on Desktop) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 items-stretch pt-8 sm:pt-10">
                @foreach($packages as $package)
                    <div class="flex flex-col flex-1" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <x-package-card :package="$package" />
                    </div>
                @endforeach
            </div>

            <!-- Bottom Custom Enterprise Inquiries Note -->
            <div class="mt-14 p-6 sm:p-7 rounded-3xl bg-white/[0.08] border border-white/15 shadow-xl backdrop-blur-md flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-white" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-sky-500/20 border border-sky-400/30 flex items-center justify-center text-[#38bdf8] shrink-0">
                        <iconify-icon icon="solar:buildings-bold" width="24"></iconify-icon>
                    </div>
                    <div>
                        <div class="font-heading font-bold text-white text-base">Butuh Bandwidth Khusus / Dedicated Internet Bisnis hingga 10 Gbps?</div>
                        <div class="text-xs sm:text-sm text-slate-300">Kami menyediakan paket Corporate Dedicated dengan SLA 99.9% dan IP Public Static.</div>
                    </div>
                </div>
                <a href="#kontak" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#38bdf8] text-[#050d1a] font-heading font-bold text-xs sm:text-sm hover:bg-white hover:text-[#0284c7] transition-all shrink-0 shadow-lg shadow-sky-500/20 hover:scale-105">
                    <span>Hubungi Tim Sales B2B</span>
                    <iconify-icon icon="solar:arrow-right-linear" width="16"></iconify-icon>
                </a>
            </div>
        </div>
    </section>

    <!-- 8 & 9. UNIFIED WHY-US & PORTFOLIO CONTINUOUS SECTION -->
    <div class="relative z-10 w-full overflow-hidden border-b border-slate-200" style="background-image: url('{{ asset('images/portfolio/polygon-bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <!-- Translucent Soft Overlay for crisp legibility across both sections -->
        <div class="absolute inset-0 bg-white/75 backdrop-blur-[2px] pointer-events-none z-0"></div>

        <div class="relative z-10">
            <!-- 8. WHY US (Editorial Structure on Continuous Polygon Canvas) -->
            <x-why-us />

            <!-- 9. FEATURED PROJECT & PORTFOLIO -->
            <x-portfolio :portfolios="$portfolios" />
        </div>
    </div>

    <!-- 10 & 11. UNIFIED TESTIMONIALS & FAQ IN SLEEK DARK NETWORK CIRCUIT THEME -->
    <div class="relative z-10 w-full overflow-hidden border-b border-white/10 bg-[#050d1a]">
        
        <!-- High-Resolution Cyber Background: Crisp Circuit Graphic -->
        <div class="absolute inset-0 z-0 pointer-events-none opacity-30 sm:opacity-50 lg:opacity-70 bg-center bg-cover bg-no-repeat" style="background-image: url('{{ asset('images/testimonials/network-circuit-bg.jpg') }}');"></div>

        <!-- Precision Crisp Architectural Cyber Grid (Always 100% Sharp on All Mobile & Retina Screens) -->
        <div class="absolute inset-0 pointer-events-none opacity-25 z-0" style="background-image: linear-gradient(to right, rgba(56, 189, 248, 0.15) 1px, transparent 1px), linear-gradient(to bottom, rgba(56, 189, 248, 0.15) 1px, transparent 1px); background-size: 28px 28px;"></div>

        <!-- Translucent Dark Cyber Gradient Overlay (No blur filter for crystal-clear display) -->
        <div class="absolute inset-0 bg-gradient-to-b from-[#07172e]/92 via-[#07172e]/80 to-[#050d1a]/95 pointer-events-none z-0"></div>
        
        <!-- Ambient Cyber Glow Accent -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[350px] sm:w-[700px] h-[300px] bg-[#38bdf8]/12 rounded-full blur-[100px] pointer-events-none z-0"></div>

        <div class="relative z-10">
            <!-- 10. TESTIMONIAL (Real Corporate Social Proof in Dark Mode) -->
            <x-testimonials />

            <!-- 11. FAQ Section (Clear Accordion in Dark Mode) -->
            <x-faq />
        </div>
    </div>

    <!-- 12 & 13. UNIFIED CTA & CONTACT SECTION (Polygon Crystal Canvas) -->
    <div class="relative z-10 w-full overflow-hidden border-b border-slate-200" style="background-image: url('{{ asset('images/portfolio/polygon-bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <!-- Translucent Soft Overlay for crisp legibility -->
        <div class="absolute inset-0 bg-white/75 backdrop-blur-[2px] pointer-events-none z-0"></div>

        <div class="relative z-10">
            <!-- 12. CTA Block (Mari Bangun Koneksi yang Lebih Baik) -->
            <x-cta />

            <!-- 13. Lokasi Kantor & Live Google Maps -->
            <x-contact />
        </div>
    </div>
</x-layouts.app>
