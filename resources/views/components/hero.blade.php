<section id="hero" class="relative flex items-center justify-center pt-24 sm:pt-28 pb-16 sm:pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden z-10 w-full" style="background: radial-gradient(circle at 50% 30%, #0c2340 0%, #07172e 60%, #050d1a 100%); min-height: calc(100vh / 0.9); min-height: 111.2vh;">

    <!-- 1. WebGL Moving Neon Aurora Wave Shader Canvas (Thin Delicate Ambient Wave) -->
    <canvas id="glCanvas" class="absolute inset-0 w-full h-full pointer-events-none opacity-50 z-0"></canvas>

    <!-- 2. Ambient Soft Glowing Orbs -->
    <div class="absolute top-1/4 left-1/3 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-[#38bdf8]/6 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="absolute bottom-1/4 right-1/4 w-[500px] h-[300px] bg-[#0284c7]/8 rounded-full blur-[130px] pointer-events-none z-0"></div>

    <!-- 3. Subtle Precision Architectural Grid Pattern -->
    <div class="absolute inset-0 pointer-events-none opacity-15 z-0" style="background-image: radial-gradient(rgba(56, 189, 248, 0.35) 1px, transparent 1px); background-size: 32px 32px;"></div>

    <div class="max-w-7xl mx-auto w-full relative z-10 grid lg:grid-cols-12 gap-10 lg:gap-14 items-center">
        
        <!-- Left Column (7 cols): Direct Telecom Authority Narrative (Centered on Mobile, Left on Desktop) -->
        <div class="lg:col-span-7 flex flex-col justify-center items-center lg:items-start text-center lg:text-left">
            
            <!-- ISP Authority Badge -->
            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/[0.08] border border-white/20 backdrop-blur-md text-[#38bdf8] text-[11px] sm:text-xs font-mono font-semibold tracking-wider uppercase mb-5 w-fit shadow-sm mx-auto lg:mx-0">
                <span>{{ \App\Models\SiteSetting::get('hero_badge', 'Infrastruktur Digital & Jaringan Fiber Optic • ISP Resmi') }}</span>
            </div>

            <!-- Authoritative Headline (Manrope 56px 700): GET YOUR IT SOLUTION -->
            <h1 class="font-heading font-extrabold text-3xl sm:text-5xl lg:text-[54px] xl:text-[62px] text-white tracking-tight leading-[1.15] mb-4 sm:mb-6 text-center lg:text-left">
                {{ \App\Models\SiteSetting::get('hero_title_line1', 'GET YOUR IT') }} {{ \App\Models\SiteSetting::get('hero_title_highlight', 'SOLUTION') }}
            </h1>

            <!-- Subtitle (Inter 18px line-height 1.7) -->
            <p class="font-sans text-sm sm:text-lg lg:text-[18px] text-slate-300 leading-[1.7] max-w-2xl mb-7 sm:mb-8 text-center lg:text-left mx-auto lg:mx-0">
                {{ \App\Models\SiteSetting::get('hero_description', 'Holding telekomunikasi resmi penyedia internet fiber optic enterprise, infrastruktur jaringan terpadu, dan rekayasa piranti lunak untuk sektor pemerintahan, BUMN, dan korporasi swasta.') }}
            </p>

            <!-- Dual Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 sm:gap-4 mb-8 sm:mb-10 w-full sm:w-auto">
                <a href="#kontak" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-full bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-xs sm:text-sm transition-all duration-200 shadow-[0_0_25px_rgba(56,189,248,0.4)] hover:scale-105 active:scale-95 group">
                    <span>Konsultasi Sekarang</span>
                    <svg class="w-[18px] h-[18px] shrink-0 text-current transition-transform duration-200 group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 12H20M14 18L20 12L14 6"/>
                    </svg>
                </a>
                <a href="#coverage" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/25 text-white font-heading font-semibold text-xs sm:text-sm transition-all duration-200 backdrop-blur-md hover:scale-105 active:scale-95 group">
                    <svg class="w-[18px] h-[18px] shrink-0 text-[#38bdf8] transition-transform duration-200 group-hover:scale-110" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21 16.8292V11.1625C21 10.1189 21 9.5971 20.7169 9.20427C20.4881 8.88694 20.1212 8.71828 19.4667 8.49121C19.3328 10.0974 18.8009 11.7377 17.9655 13.1734C16.9928 14.845 15.5484 16.3395 13.697 17.1472C12.618 17.6179 11.382 17.6179 10.303 17.1472C8.45164 16.3395 7.00718 14.845 6.03449 13.1734C5.40086 12.0844 4.9418 10.8778 4.69862 9.65752C4.31607 9.60117 4.0225 9.63008 3.76917 9.77142C3.66809 9.82781 3.57388 9.89572 3.48841 9.97378C3 10.4199 3 11.2493 3 12.9082V17.8379C3 18.8815 3 19.4033 3.28314 19.7961C3.56627 20.189 4.06129 20.354 5.05132 20.684L5.43488 20.8118L5.43489 20.8118C7.01186 21.3375 7.80035 21.6003 8.60688 21.6018C8.8498 21.6023 9.09242 21.5851 9.33284 21.5503C10.131 21.4347 10.8809 21.0597 12.3806 20.3099C13.5299 19.7352 14.1046 19.4479 14.715 19.3146C14.9292 19.2678 15.1463 19.2352 15.3648 19.2169C15.9875 19.1648 16.6157 19.2695 17.8721 19.4789C19.1455 19.6911 19.7821 19.7972 20.247 19.5303C20.4048 19.4396 20.5449 19.321 20.6603 19.1802C21 18.7655 21 18.1201 21 16.8292Z"/>
                        <path fill-rule="evenodd" d="M12 2C8.68629 2 6 4.55211 6 7.70031C6 10.8238 7.91499 14.4687 10.9028 15.7721C11.5993 16.076 12.4007 16.076 13.0972 15.7721C16.085 14.4687 18 10.8238 18 7.70031C18 4.55211 15.3137 2 12 2ZM12 10C13.1046 10 14 9.10457 14 8C14 6.89543 13.1046 6 12 6C10.8954 6 10 6.89543 10 8C10 9.10457 10.8954 10 12 10Z" clip-rule="evenodd"/>
                    </svg>
                    <span>Cek Coverage Area</span>
                </a>
            </div>

            <!-- Key Enterprise Metrics -->
            <div class="grid grid-cols-3 gap-3 sm:gap-6 pt-6 border-t border-white/15 max-w-xl w-full text-center lg:text-left mx-auto lg:mx-0">
                <div class="text-center lg:text-left">
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight">1000+</div>
                    <div class="text-xs text-white/60 font-medium mt-1">Pelanggan Aktif</div>
                </div>
                <div class="text-center lg:text-left">
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-[#38bdf8] tracking-tight">50+</div>
                    <div class="text-xs text-white/60 font-medium mt-1">Titik Jaringan</div>
                </div>
                <div class="text-center lg:text-left">
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight">24/7</div>
                    <div class="text-xs text-white/60 font-medium mt-1">Dedicated Support NOC</div>
                </div>
            </div>
        </div>

        <!-- Right Column (5 cols): Official Hero Graphic (hero.png) -->
        <div class="lg:col-span-5 relative flex items-center justify-center mt-4 lg:mt-0">
            
            <!-- Ambient Cyan Glow Behind Hero Image -->
            <div class="absolute w-[320px] sm:w-[480px] h-[320px] sm:h-[480px] bg-[#38bdf8]/15 rounded-full blur-[90px] pointer-events-none"></div>

            <!-- Hero Image Showcase with Smooth Hover Effect -->
            <div class="relative z-10 w-full flex items-center justify-center group">
                <img 
                    src="{{ asset('images/hero/hero.png') }}" 
                    alt="PT Media Solusi Network - IT & Internet Solution" 
                    class="w-full max-w-sm sm:max-w-lg h-auto object-contain drop-shadow-[0_15px_30px_rgba(56,189,248,0.25)] group-hover:scale-105 transition-transform duration-500"
                >
            </div>

        </div>

    </div>
</section>
