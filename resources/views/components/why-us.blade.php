<section id="why-us" class="pt-20 sm:pt-28 pb-12 sm:pb-16 px-4 sm:px-6 lg:px-8 relative z-10 w-full bg-transparent">
    <div class="max-w-7xl mx-auto">
        
        <!-- Top Row: Narrative (Left 6 cols) & Editorial Photo (Right 6 cols) -->
        <div class="grid lg:grid-cols-12 gap-10 lg:gap-14 items-center mb-16 sm:mb-20">
            
            <!-- Left Column: Eyebrow + Large Heading + Description -->
            <div class="lg:col-span-6 flex flex-col justify-center text-left">
                
                <!-- Prominent Eyebrow (WHY MSN) -->
                <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-sky-50 border border-sky-200 text-xs sm:text-sm font-mono text-[#0284c7] uppercase tracking-widest mb-4 font-bold shadow-2xs w-fit">
                    <span>{{ \App\Models\SiteSetting::get('why_badge', 'WHY MSN') }}</span>
                </div>
                
                <!-- Headline (Scaled Down & Balanced) -->
                <h2 class="font-heading font-extrabold text-2xl sm:text-3xl lg:text-[36px] text-slate-900 tracking-tight leading-snug mb-4">
                    {{ \App\Models\SiteSetting::get('why_title_line1', 'Membangun koneksi yang') }} <br class="hidden sm:inline">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#0284c7] via-[#0ea5e9] to-[#0284c7]">{{ \App\Models\SiteSetting::get('why_title_highlight', 'dapat diandalkan.') }}</span>
                </h2>

                <!-- Short Punchy Description -->
                <p class="font-sans text-sm sm:text-base text-slate-600 leading-relaxed max-w-xl">
                    {{ \App\Models\SiteSetting::get('why_description', 'PT Media Solusi Network hadir dengan pengalaman di bidang konektivitas, infrastruktur jaringan, dan teknologi digital.') }}
                </p>

            </div>

            <!-- Right Column: Proportional Feature Photo (Clean & Well-Fitted) -->
            <div class="lg:col-span-6 flex items-center justify-center">
                <div class="relative w-full rounded-2xl sm:rounded-3xl overflow-hidden shadow-xl border border-slate-100 group">
                    <img 
                        src="{{ asset('images/hero/fiber-technician-field.jpg') }}" 
                        alt="Teknisi Infrastruktur Jaringan Fiber Optic PT Media Solusi Network" 
                        class="w-full h-72 sm:h-80 lg:h-[330px] object-cover object-center group-hover:scale-105 transition-transform duration-500"
                    >
                </div>
            </div>

        </div>

        <!-- Bottom Row: 4 Pillars Editorial List (2 Columns x 2 Rows without Card Backgrounds) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 lg:gap-x-16 gap-y-8 sm:gap-y-10 pt-10 sm:pt-12 border-t border-slate-200">
            
            <!-- 01 — KEAHLIAN JARINGAN -->
            <div class="space-y-2.5">
                <div class="flex items-baseline gap-4 pb-2.5 border-b border-slate-200">
                    <span class="font-mono text-2xl sm:text-3xl font-light text-[#0284c7] tracking-tight">01</span>
                    <h3 class="font-heading font-bold text-base sm:text-lg text-slate-900 uppercase tracking-wider">
                        KEAHLIAN JARINGAN
                    </h3>
                </div>
                <p class="font-sans text-sm sm:text-base text-slate-600 leading-relaxed">
                    Infrastruktur jaringan fiber optic murni yang dirancang untuk stabilitas tinggi, redundansi ganda, dan performa tanpa kompromi.
                </p>
            </div>

            <!-- 02 — SOLUSI TERINTEGRASI -->
            <div class="space-y-2.5">
                <div class="flex items-baseline gap-4 pb-2.5 border-b border-slate-200">
                    <span class="font-mono text-2xl sm:text-3xl font-light text-[#0284c7] tracking-tight">02</span>
                    <h3 class="font-heading font-bold text-base sm:text-lg text-slate-900 uppercase tracking-wider">
                        SOLUSI TERINTEGRASI
                    </h3>
                </div>
                <p class="font-sans text-sm sm:text-base text-slate-600 leading-relaxed">
                    Konektivitas internet dedicated, manajemen bandwidth, dan rekayasa piranti lunak terintegrasi dalam satu ekosistem teknologi.
                </p>
            </div>

            <!-- 03 — PENGALAMAN TERBUKTI -->
            <div class="space-y-2.5">
                <div class="flex items-baseline gap-4 pb-2.5 border-b border-slate-200">
                    <span class="font-mono text-2xl sm:text-3xl font-light text-[#0284c7] tracking-tight">03</span>
                    <h3 class="font-heading font-bold text-base sm:text-lg text-slate-900 uppercase tracking-wider">
                        PENGALAMAN TERBUKTI
                    </h3>
                </div>
                <p class="font-sans text-sm sm:text-base text-slate-600 leading-relaxed">
                    Berpengalaman melayani berbagai sektor strategis mulai dari instansi pemerintah daerah, BUMN, kawasan industri, hingga swasta.
                </p>
            </div>

            <!-- 04 — MITRA JANGKA PANJANG -->
            <div class="space-y-2.5">
                <div class="flex items-baseline gap-4 pb-2.5 border-b border-slate-200">
                    <span class="font-mono text-2xl sm:text-3xl font-light text-[#0284c7] tracking-tight">04</span>
                    <h3 class="font-heading font-bold text-base sm:text-lg text-slate-900 uppercase tracking-wider">
                        MITRA JANGKA PANJANG
                    </h3>
                </div>
                <p class="font-sans text-sm sm:text-base text-slate-600 leading-relaxed">
                    Solusi yang berkembang bersama bisnis Anda, didukung monitoring NOC 24/7/365 dan jaminan garansi ketersediaan SLA 99.9%.
                </p>
            </div>

        </div>

    </div>
</section>
