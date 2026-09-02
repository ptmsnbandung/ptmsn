<section id="tentang-kami" class="pt-20 sm:pt-28 pb-12 sm:pb-16 px-4 sm:px-6 lg:px-8 relative z-10 w-full bg-transparent">
    <div class="max-w-7xl mx-auto relative z-10">
        
        <!-- Top Centered Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 reveal-on-scroll">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-sky-100/90 border border-sky-200 text-xs font-mono text-[#0284c7] uppercase tracking-wider mb-4 font-semibold shadow-2xs backdrop-blur-sm">
                <span>{{ \App\Models\SiteSetting::get('about_badge', 'Tentang PT Media Solusi Network') }}</span>
            </div>
            
            <!-- Headline -->
            <h2 class="font-heading font-extrabold text-2xl sm:text-3xl lg:text-4xl text-slate-900 tracking-tight leading-snug">
                {{ \App\Models\SiteSetting::get('about_title_regular', 'Mitra Terpercaya') }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#0284c7] via-[#0ea5e9] to-[#0284c7]">{{ \App\Models\SiteSetting::get('about_title_highlight', 'Solusi IT & Infrastruktur Digital') }}</span>
            </h2>
        </div>

        <!-- Narrative & Graphic Content Grid -->
        <div class="grid lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            
            <!-- Left Column: Corporate Story & Pillars (6 cols) -->
            <div class="lg:col-span-6 flex flex-col justify-center reveal-from-left">
                <!-- Narrative Paragraph (Justified) -->
                <p class="mb-6 text-slate-600 font-sans text-base sm:text-[17px] leading-relaxed text-justify">
                    {!! \App\Models\SiteSetting::get('about_description', '<strong class="text-slate-900 font-bold">PT Media Solusi Network</strong> adalah perusahaan holding penyedia solusi IT terpadu, developer aplikasi, dan infrastruktur internet yang telah dipercaya oleh pemerintah daerah, BUMN, serta berbagai sektor korporasi swasta.') !!}
                </p>

                <!-- Trust Sector Pills (3 Side-by-Side Cards on Mobile & Desktop) -->
                <div class="grid grid-cols-3 gap-2 sm:gap-3 text-xs font-heading font-semibold text-slate-700 w-full">
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 px-2 sm:px-3.5 py-2.5 sm:py-3 rounded-xl bg-white/95 border border-sky-100 shadow-xs backdrop-blur-sm hover:border-sky-300 hover:shadow-sm transition-all text-center">
                        <iconify-icon icon="solar:buildings-bold" class="text-[#0284c7] text-base sm:text-lg shrink-0"></iconify-icon>
                        <span class="text-[10px] sm:text-xs leading-tight sm:leading-snug">Pemerintah & BUMN</span>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 px-2 sm:px-3.5 py-2.5 sm:py-3 rounded-xl bg-white/95 border border-sky-100 shadow-xs backdrop-blur-sm hover:border-sky-300 hover:shadow-sm transition-all text-center">
                        <iconify-icon icon="solar:users-group-two-rounded-bold" class="text-emerald-600 text-base sm:text-lg shrink-0"></iconify-icon>
                        <span class="text-[10px] sm:text-xs leading-tight sm:leading-snug">Korporasi & Swasta</span>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 px-2 sm:px-3.5 py-2.5 sm:py-3 rounded-xl bg-white/95 border border-sky-100 shadow-xs backdrop-blur-sm hover:border-sky-300 hover:shadow-sm transition-all text-center">
                        <iconify-icon icon="solar:server-square-bold" class="text-sky-500 text-base sm:text-lg shrink-0"></iconify-icon>
                        <span class="text-[10px] sm:text-xs leading-tight sm:leading-snug">Holding ISP & IT</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Official Graphic Showcase (tentang-kami.png) (6 cols) -->
            <div class="lg:col-span-6 flex items-center justify-center reveal-from-right">
                <div class="relative w-full flex items-center justify-center group">
                    <!-- Ambient Soft Cyan Glow -->
                    <div class="absolute w-80 h-80 bg-sky-400/20 rounded-full blur-[80px] pointer-events-none"></div>

                    <img 
                        src="{{ asset('images/about/tentang-kami.png') }}" 
                        alt="Tentang PT Media Solusi Network" 
                        class="relative z-10 w-full max-w-lg h-auto object-contain drop-shadow-[0_15px_30px_rgba(2,132,199,0.18)] group-hover:scale-105 transition-transform duration-500"
                    >
                </div>
            </div>

        </div>

    </div>
</section>
