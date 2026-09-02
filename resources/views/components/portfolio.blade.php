@props(['portfolios'])

<section id="portofolio" class="pt-8 sm:pt-12 pb-20 sm:pb-28 px-4 sm:px-6 lg:px-8 relative z-10 w-full bg-transparent">
    <div class="max-w-7xl mx-auto relative z-10">
        
        <!-- Section Header (Portofolio + Exact Narrative from Image 3) -->
        <div class="text-center max-w-4xl mx-auto mb-16 sm:mb-20">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-sky-100/90 border border-sky-200 text-xs font-mono text-[#0284c7] uppercase tracking-wider mb-4 font-semibold shadow-xs">
                <span>Studi Kasus & Rekam Jejak Nyata</span>
            </div>
            
            <h2 class="font-heading font-extrabold text-3xl sm:text-4xl lg:text-[46px] text-slate-900 tracking-tight mb-5 leading-tight" data-reveal-words>
                Portofolio
            </h2>

            <div class="space-y-3 font-sans text-sm sm:text-base text-slate-700 leading-[1.8] text-center max-w-3xl mx-auto">
                <p>
                    Pemanfaatan Teknologi Informasi telah menjadi bagian yang hampir tidak terpisahkan dan menyentuh berbagai aspek kehidupan manusia. Hal ini dikarenakan oleh manfaat yang dapat meningkatkan efisiensi, efektifitas, transparansi dan akuntabilitas suatu aktifitas kegiatan.
                </p>
                <p class="text-slate-600 text-xs sm:text-sm">
                    Selain itu kemajuan teknologi informasi yang pesat serta potensi pemanfaatannya secara luas telah membuka peluang bagi pengaksesan, pengelolaan dan pendayagunaan informasi dalam volume yang besar secara cepat dan akurat.
                </p>
            </div>
        </div>

        <!-- 1 Grand Featured Case Study: Project -> Problem -> Solution -> Result -->
        <div class="rounded-3xl border border-slate-200 bg-[#0c2340] text-white overflow-hidden shadow-2xl mb-14 grid lg:grid-cols-12 gap-0 items-stretch">
            
            <!-- Left Side: Grand Real Deployment Photo (6 cols) -->
            <div class="lg:col-span-6 relative min-h-[340px] lg:min-h-[480px] overflow-hidden group">
                <img src="{{ asset('images/portfolio/featured-case-study.jpg') }}" alt="Pekerjaan Penggelaran Kabel Fiber Optic PT Media Solusi Network" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0c2340] via-transparent to-transparent lg:bg-gradient-to-r lg:from-transparent lg:to-[#0c2340]/90 pointer-events-none"></div>
                
                <!-- Badge on Photo -->
                <div class="absolute top-5 left-5 px-3.5 py-1 rounded-full bg-slate-950/85 border border-white/20 backdrop-blur-md text-xs font-mono text-[#38bdf8] font-bold">
                    FEATURED CASE STUDY
                </div>
            </div>

            <!-- Right Side: Structured Project -> Problem -> Solution -> Result (6 cols) -->
            <div class="lg:col-span-6 p-8 sm:p-10 lg:p-12 flex flex-col justify-between">
                <div>
                    <!-- Location & Scope -->
                    <div class="flex items-center gap-2 text-xs font-mono text-[#38bdf8] uppercase tracking-wider mb-2">
                        <iconify-icon icon="solar:point-on-map-bold" width="14"></iconify-icon>
                        <span>Bandung & Jawa Barat • Sektor Infrastruktur & Bisnis</span>
                    </div>

                    <!-- Project Title -->
                    <h3 class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight mb-6">
                        Penggelaran Jaringan Fiber Optic Terintegrasi
                    </h3>

                    <!-- Project Storyline -->
                    <div class="space-y-4 text-xs sm:text-sm font-sans mb-8">
                        
                        <!-- Problem -->
                        <div class="p-3.5 rounded-xl bg-white/[0.06] border border-white/10">
                            <div class="font-mono text-[11px] font-bold text-amber-400 uppercase tracking-wider mb-1">
                                [ Problem / Tantangan ]
                            </div>
                            <div class="text-slate-300 leading-relaxed">
                                Kebutuhan konektivitas antar-titik operasional yang membutuhkan bandwidth simetris tinggi tanpa fluktuasi di kawasan padat lalu lintas Bandung.
                            </div>
                        </div>

                        <!-- Solution -->
                        <div class="p-3.5 rounded-xl bg-white/[0.06] border border-white/10">
                            <div class="font-mono text-[11px] font-bold text-[#38bdf8] uppercase tracking-wider mb-1">
                                [ Solution / Solusi MSN ]
                            </div>
                            <div class="text-slate-300 leading-relaxed">
                                Perancangan rute kabel fiber optic bawah tanah & udara dengan redundansi cincin (ring topology) serta terminasi OTB berstandar industri telco.
                            </div>
                        </div>

                        <!-- Result -->
                        <div class="p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/20">
                            <div class="font-mono text-[11px] font-bold text-emerald-400 uppercase tracking-wider mb-1">
                                [ Result / Hasil Nyata ]
                            </div>
                            <div class="grid grid-cols-3 gap-2 pt-2 text-center">
                                <div>
                                    <div class="font-heading font-extrabold text-lg sm:text-xl text-[#38bdf8]">+120 km</div>
                                    <div class="text-[10px] text-slate-400 font-mono">Kabel Tergelar</div>
                                </div>
                                <div>
                                    <div class="font-heading font-extrabold text-lg sm:text-xl text-white">&lt; 4.5 ms</div>
                                    <div class="text-[10px] text-slate-400 font-mono">Avg Latency</div>
                                </div>
                                <div>
                                    <div class="font-heading font-extrabold text-lg sm:text-xl text-emerald-400">99.9%</div>
                                    <div class="text-[10px] text-slate-400 font-mono">SLA Uptime</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- CTA Link -->
                <div>
                    <a href="#kontak" class="inline-flex items-center justify-center gap-2 w-full py-3.5 rounded-xl bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-xs sm:text-sm uppercase tracking-wider transition-all duration-200 shadow-lg shadow-sky-500/25">
                        <span>Konsultasikan Studi Kasus Serupa</span>
                        <iconify-icon icon="solar:arrow-right-linear" width="16"></iconify-icon>
                    </a>
                </div>
            </div>

        </div>

        <!-- Secondary Projects / Portfolios: Pure Floating Transparent Logos (2 Columns on Mobile, 4 Columns on Desktop) -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 sm:gap-14 items-center justify-items-center max-w-5xl mx-auto py-6 sm:py-10">
            @foreach($portfolios as $portfolio)
                <div class="flex items-center justify-center w-full p-2 group transition-transform duration-300 hover:scale-105" title="{{ $portfolio->title }}">
                    @if(file_exists(public_path($portfolio->image)))
                        <img src="{{ asset($portfolio->image) }}?v=2" alt="{{ $portfolio->title }}" class="h-16 sm:h-24 max-w-[150px] sm:max-w-[220px] w-auto object-contain transition-all duration-300 drop-shadow-xs group-hover:drop-shadow-lg">
                    @else
                        <div class="text-[#0284c7] flex items-center justify-center">
                            <iconify-icon icon="solar:code-square-bold" width="40"></iconify-icon>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </div>
</section>
