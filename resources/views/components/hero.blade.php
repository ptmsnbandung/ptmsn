<section id="hero" class="relative flex items-center justify-center pt-28 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden z-10 w-full" style="background: radial-gradient(circle at 50% 30%, #0c2340 0%, #07172e 60%, #050d1a 100%); min-height: calc(100vh / 0.9); min-height: 111.2vh;">

    <!-- 1. WebGL Moving Neon Aurora Wave Shader Canvas (Thin Delicate Ambient Wave) -->
    <canvas id="glCanvas" class="absolute inset-0 w-full h-full pointer-events-none opacity-50 z-0"></canvas>

    <!-- 2. Ambient Soft Glowing Orbs -->
    <div class="absolute top-1/4 left-1/3 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-[#38bdf8]/6 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="absolute bottom-1/4 right-1/4 w-[500px] h-[300px] bg-[#0284c7]/8 rounded-full blur-[130px] pointer-events-none z-0"></div>

    <!-- 3. Subtle Precision Architectural Grid Pattern -->
    <div class="absolute inset-0 pointer-events-none opacity-15 z-0" style="background-image: radial-gradient(rgba(56, 189, 248, 0.35) 1px, transparent 1px); background-size: 32px 32px;"></div>

    <div class="max-w-7xl mx-auto w-full relative z-10 grid lg:grid-cols-12 gap-12 lg:gap-14 items-center">
        
        <!-- Left Column (7 cols): Direct Telecom Authority Narrative -->
        <div class="lg:col-span-7 flex flex-col justify-center text-left">
            
            <!-- ISP Authority Badge -->
            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/[0.08] border border-white/20 backdrop-blur-md text-[#38bdf8] text-xs font-mono font-semibold tracking-wider uppercase mb-5 w-fit shadow-sm">
                <span>{{ \App\Models\SiteSetting::get('hero_badge', 'Infrastruktur Digital & Jaringan Fiber Optic • ISP Resmi') }}</span>
            </div>

            <!-- Authoritative Headline (Manrope 56px 700): GET YOUR IT SOLUTION -->
            <h1 class="font-heading font-extrabold text-4xl sm:text-5xl lg:text-[54px] xl:text-[62px] text-white tracking-tight leading-[1.1] mb-6">
                {{ \App\Models\SiteSetting::get('hero_title_line1', 'GET YOUR IT') }} {{ \App\Models\SiteSetting::get('hero_title_highlight', 'SOLUTION') }}
            </h1>

            <!-- Subtitle (Inter 18px line-height 1.7) -->
            <p class="font-sans text-base sm:text-lg lg:text-[18px] text-slate-300 leading-[1.7] max-w-2xl mb-8">
                {{ \App\Models\SiteSetting::get('hero_description', 'Penyedia layanan internet broadband fiber optic murni tanpa FUP, konektivitas dedicated berkecepatan tinggi, dan solusi rekayasa piranti lunak terintegrasi untuk akselerasi bisnis, korporasi, dan institusi pemerintahan.') }}
            </p>

            <!-- Dual Action Buttons -->
            <div class="flex flex-wrap items-center gap-3.5 sm:gap-4 mb-10">
                <a href="#kontak" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-xs sm:text-sm transition-all duration-200 shadow-[0_0_25px_rgba(56,189,248,0.4)] hover:scale-105 active:scale-95">
                    <span>Konsultasi Sekarang</span>
                    <iconify-icon icon="solar:arrow-right-linear" width="18"></iconify-icon>
                </a>
                <a href="#coverage" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/25 text-white font-heading font-semibold text-xs sm:text-sm transition-all duration-200 backdrop-blur-md hover:scale-105 active:scale-95">
                    <iconify-icon icon="solar:point-on-map-bold" width="18" class="text-[#38bdf8]"></iconify-icon>
                    <span>Cek Coverage Area</span>
                </a>
            </div>

            <!-- Key Enterprise Metrics -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-5 pt-6 border-t border-white/15 max-w-2xl">
                <div>
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight">1.500+</div>
                    <div class="text-xs text-white/60 font-medium mt-1">Pelanggan Aktif</div>
                </div>
                <div>
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-[#38bdf8] tracking-tight">50+</div>
                    <div class="text-xs text-white/60 font-medium mt-1">Titik Jaringan & Wilayah</div>
                </div>
                <div>
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight">99.9%</div>
                    <div class="text-xs text-white/60 font-medium mt-1">Garansi Uptime SLA</div>
                </div>
                <div>
                    <div class="font-heading font-extrabold text-2xl sm:text-3xl text-[#38bdf8] tracking-tight">24/7/365</div>
                    <div class="text-xs text-white/60 font-medium mt-1">Dedicated Support NOC</div>
                </div>
            </div>
        </div>

        <!-- Right Column (5 cols): Official Hero Graphic (hero.png) -->
        <div class="lg:col-span-5 relative flex items-center justify-center">
            
            <!-- Ambient Cyan Glow Behind Hero Image -->
            <div class="absolute w-[400px] sm:w-[480px] h-[400px] sm:h-[480px] bg-[#38bdf8]/15 rounded-full blur-[100px] pointer-events-none"></div>

            <!-- Hero Image Showcase with Smooth Hover Effect -->
            <div class="relative z-10 w-full flex items-center justify-center group">
                <img 
                    src="{{ asset('images/hero/hero.png') }}" 
                    alt="PT Media Solusi Network - IT & Internet Solution" 
                    class="w-full max-w-lg h-auto object-contain drop-shadow-[0_15px_30px_rgba(56,189,248,0.25)] group-hover:scale-105 transition-transform duration-500"
                >
            </div>

        </div>

    </div>
</section>
