<section id="coverage" class="py-20 sm:py-24 px-4 sm:px-6 lg:px-8 relative z-10 bg-slate-900 text-white w-full overflow-hidden" style="background: radial-gradient(circle at 50% 30%, #0c2340 0%, #050d1a 70%, #020617 100%);">
    
    <!-- Subtle Background Grid Pattern -->
    <div class="absolute inset-0 pointer-events-none opacity-20" style="background-image: radial-gradient(rgba(56, 189, 248, 0.4) 1px, transparent 1px); background-size: 24px 24px;"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[650px] h-[350px] bg-[#38bdf8]/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-5xl mx-auto relative z-10">
        
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12">
            <div class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-white/[0.08] border border-white/20 text-xs font-mono text-[#38bdf8] uppercase tracking-wider mb-4 font-semibold shadow-xs">
                <span>Pemeriksaan Jaringan Instan</span>
            </div>
            <h2 class="font-heading font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight mb-4" data-reveal-words>
                Apakah Area Anda Sudah Tercover?
            </h2>
            <p class="font-sans text-sm sm:text-base text-slate-300 leading-relaxed">
                Masukkan lokasi atau kecamatan Anda untuk mengetahui ketersediaan jaringan fiber optic PT Media Solusi Network secara instan.
            </p>
        </div>

        <!-- Grand Search Box Container -->
        <div class="p-6 sm:p-8 rounded-3xl bg-white/[0.05] border border-sky-400/30 backdrop-blur-xl shadow-2xl">
            <form id="coverageForm" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <iconify-icon icon="solar:point-on-map-bold" width="20"></iconify-icon>
                    </div>
                    <input 
                        type="text" 
                        id="coverageQuery" 
                        name="query" 
                        required 
                        placeholder="Masukkan alamat / nama kecamatan (contoh: Buahbatu, Cimahi, Coblong...)" 
                        class="w-full pl-12 pr-4 py-4 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-[#38bdf8] focus:border-transparent transition-all shadow-inner"
                    >
                </div>
                <button 
                    type="submit" 
                    id="coverageSubmitBtn" 
                    class="px-8 py-4 rounded-2xl bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-sm flex items-center justify-center gap-2 transition-all duration-200 shadow-[0_0_25px_rgba(56,189,248,0.4)] hover:scale-105 active:scale-95 shrink-0"
                >
                    <span>Cek Coverage</span>
                    <iconify-icon icon="solar:radar-bold" width="18"></iconify-icon>
                </button>
            </form>

            <!-- Quick City Search Buttons -->
            <div class="flex flex-wrap items-center gap-2 mt-5 pt-4 border-t border-white/10 text-xs">
                <span class="text-slate-400 font-mono">Pilihan Cepat:</span>
                <button type="button" class="quick-city px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 border border-white/15 text-slate-200 transition-colors" data-city="Bandung">Kota Bandung</button>
                <button type="button" class="quick-city px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 border border-white/15 text-slate-200 transition-colors" data-city="Cimahi">Cimahi</button>
                <button type="button" class="quick-city px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 border border-white/15 text-slate-200 transition-colors" data-city="Kabupaten Bandung">Kab. Bandung</button>
                <button type="button" class="quick-city px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 border border-white/15 text-slate-200 transition-colors" data-city="Bandung Barat">Bandung Barat</button>
                <button type="button" class="quick-city px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 border border-white/15 text-slate-200 transition-colors" data-city="Sumedang">Sumedang</button>
            </div>

            <!-- Dynamic AJAX Result Display Box -->
            <div id="coverageResult" class="mt-6 hidden transition-all duration-300"></div>
        </div>

        <!-- Bottom Statement -->
        <p class="text-center text-xs text-slate-400 font-mono mt-6">
            Tersedia di Kota Bandung, Cimahi, Kabupaten Bandung, Bandung Barat, Sumedang, dan area lainnya.
        </p>

    </div>
</section>
