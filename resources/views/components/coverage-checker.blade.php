@props([
    'coverageAreas' => collect([]),
    'coveredCities' => collect([]),
])

@php
    // Fallback if not passed from controller
    if ($coverageAreas->isEmpty()) {
        $coverageAreas = \App\Models\CoverageArea::where('status', 'covered')->orderBy('city')->orderBy('district')->get();
        $coveredCities = $coverageAreas->pluck('city')->unique()->values();
    }
@endphp

<section id="coverage" class="py-20 sm:py-28 px-4 sm:px-6 lg:px-8 relative z-10 w-full overflow-hidden bg-[#07172e] border-b border-white/10" style="background: radial-gradient(circle at 50% 20%, #0c274d 0%, #07172e 60%, #030a16 100%);">
    
    <!-- Cyber Geometric Background Grid & Ambient Glow Orbs -->
    <div class="absolute inset-0 pointer-events-none opacity-20" style="background-image: radial-gradient(rgba(56, 189, 248, 0.4) 1px, transparent 1px); background-size: 28px 28px;"></div>
    <div class="absolute inset-0 pointer-events-none opacity-15" style="background-image: linear-gradient(to right, rgba(56, 189, 248, 0.08) 1px, transparent 1px), linear-gradient(to bottom, rgba(56, 189, 248, 0.08) 1px, transparent 1px); background-size: 56px 56px;"></div>
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[700px] h-[400px] bg-[#38bdf8]/10 rounded-full blur-[130px] pointer-events-none" style="contain: paint; will-change: transform; transform: translateZ(0);"></div>
    <div class="absolute -bottom-20 -left-20 w-[400px] h-[400px] bg-blue-600/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 reveal-on-scroll">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/[0.08] border border-sky-400/30 text-xs font-mono text-[#38bdf8] uppercase tracking-wider mb-4 font-semibold shadow-[0_0_15px_rgba(56,189,248,0.2)] backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span>Live Network Coverage Explorer</span>
            </div>
            
            <h2 class="font-heading font-extrabold text-3xl sm:text-4xl lg:text-[46px] text-white tracking-tight leading-tight mb-5" data-reveal-words>
                Cek Ketersediaan Jaringan Fiber Optic.
            </h2>
            
            <p class="font-sans text-sm sm:text-base text-slate-300 leading-relaxed">
                Cari tahu ketersediaan jaringan internet ultra-cepat PT Media Solusi Network di area rumah, kantor, atau lokasi bisnis Anda secara instan.
            </p>
        </div>

        <!-- Grand Interactive Coverage Box -->
        <div class="max-w-4xl mx-auto">
            <div class="relative p-6 sm:p-10 rounded-3xl bg-white/[0.04] border border-sky-400/30 backdrop-blur-xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] reveal-zoom">
                
                <!-- Search Form -->
                <form id="coverageForm" class="relative z-20 flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-sky-400">
                            <iconify-icon icon="solar:point-on-map-bold" width="22"></iconify-icon>
                        </div>
                        <input 
                            type="text" 
                            id="coverageQuery" 
                            name="query" 
                            autocomplete="off"
                            required 
                            placeholder="Ketik nama kelurahan, kecamatan, kota, atau kode pos..." 
                            class="w-full pl-12 sm:pl-14 pr-24 py-4 sm:py-4.5 rounded-2xl bg-[#050d1a]/80 border border-white/20 text-white placeholder-slate-400 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all shadow-inner"
                        >
                        
                        <!-- Geolocation GPS Button -->
                        <div class="absolute inset-y-0 right-0 pr-2 sm:pr-3 flex items-center gap-1">
                            <button 
                                type="button" 
                                id="coverageLocateBtn" 
                                title="Gunakan Lokasi GPS Saya" 
                                class="p-2 text-xs font-mono text-slate-400 hover:text-sky-300 hover:bg-white/10 rounded-xl transition-colors flex items-center gap-1"
                            >
                                <iconify-icon icon="solar:gps-bold" width="18"></iconify-icon>
                                <span class="hidden md:inline text-[11px]">GPS</span>
                            </button>
                        </div>

                        <!-- Dropdown Live Search Suggestions -->
                        <div id="coverageSuggestions" class="absolute left-0 right-0 top-full mt-2 bg-[#050d1a]/95 border border-sky-400/30 rounded-2xl shadow-2xl backdrop-blur-xl overflow-hidden hidden z-30 max-h-60 overflow-y-auto">
                            <!-- Populated via JS -->
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        id="coverageSubmitBtn" 
                        class="px-8 py-4 sm:py-4.5 rounded-2xl bg-gradient-to-r from-[#0284c7] via-[#0ea5e9] to-[#38bdf8] hover:from-[#0369a1] hover:to-[#0284c7] text-white font-heading font-extrabold text-sm sm:text-base flex items-center justify-center gap-2.5 transition-all duration-300 shadow-[0_0_25px_rgba(56,189,248,0.4)] hover:scale-[1.02] active:scale-95 shrink-0 cursor-pointer"
                    >
                        <span>Cek Coverage</span>
                        <iconify-icon icon="solar:radar-bold" width="20" class="text-white animate-pulse"></iconify-icon>
                    </button>
                </form>

                <!-- Quick Location Tags / Pills -->
                <div class="flex flex-wrap items-center gap-2 mt-5 pt-5 border-t border-white/10 text-xs">
                    <span class="text-slate-400 font-mono flex items-center gap-1">
                        <iconify-icon icon="solar:fire-bold" class="text-amber-400"></iconify-icon>
                        <span>Area Populer:</span>
                    </span>
                    @php
                        $popularPills = ['Bandung', 'Cimahi', 'Cianjur', 'Bekasi', 'Depok', 'Bogor', 'Karawang', 'Jakarta'];
                    @endphp
                    @foreach($popularPills as $city)
                        <button 
                            type="button" 
                            class="quick-city px-3 py-1.5 rounded-full bg-white/5 hover:bg-sky-500/20 hover:text-white hover:border-sky-400/50 border border-white/10 text-slate-300 transition-all cursor-pointer text-xs flex items-center gap-1.5" 
                            data-city="{{ $city }}"
                        >
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                            <span>{{ $city }}</span>
                        </button>
                    @endforeach
                </div>

                <!-- Dynamic AJAX Result Display Box -->
                <div id="coverageResult" class="mt-6 hidden transition-all duration-300"></div>

            </div>
        </div>

        <!-- Value Proposition Feature Grid (4 High-Tech Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mt-12 sm:mt-16">
            
            <!-- Card 1 -->
            <div class="p-6 rounded-2xl bg-white/[0.03] border border-white/10 hover:border-sky-400/30 transition-all hover:bg-white/[0.05] reveal-on-scroll stagger-1">
                <div class="w-12 h-12 rounded-xl bg-sky-500/20 border border-sky-400/30 flex items-center justify-center text-[#38bdf8] mb-4">
                    <iconify-icon icon="solar:flash-bold" width="24"></iconify-icon>
                </div>
                <h4 class="font-heading font-bold text-white text-base mb-1.5">100% Fiber Optic</h4>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Kabel serat optik murni hingga ke router Anda tanpa terpengaruh cuaca hujan maupun interferensi sinyal.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="p-6 rounded-2xl bg-white/[0.03] border border-white/10 hover:border-sky-400/30 transition-all hover:bg-white/[0.05] reveal-on-scroll stagger-2">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-emerald-400 mb-4">
                    <iconify-icon icon="solar:shield-check-bold" width="24"></iconify-icon>
                </div>
                <h4 class="font-heading font-bold text-white text-base mb-1.5">SLA 99.8% Uptime</h4>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Jaminan keandalan koneksi dengan infrastruktur dual-homing backbone dan monitoring NOC 24/7.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="p-6 rounded-2xl bg-white/[0.03] border border-white/10 hover:border-sky-400/30 transition-all hover:bg-white/[0.05] reveal-on-scroll stagger-3">
                <div class="w-12 h-12 rounded-xl bg-purple-500/20 border border-purple-400/30 flex items-center justify-center text-purple-400 mb-4">
                    <iconify-icon icon="solar:tuning-square-bold" width="24"></iconify-icon>
                </div>
                <h4 class="font-heading font-bold text-white text-base mb-1.5">Kecepatan Simetris</h4>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Download dan upload seimbang dengan latensi ultra-rendah untuk live streaming, gaming, & telekonferensi.
                </p>
            </div>

            <!-- Card 4 -->
            <div class="p-6 rounded-2xl bg-white/[0.03] border border-white/10 hover:border-sky-400/30 transition-all hover:bg-white/[0.05] reveal-on-scroll stagger-4">
                <div class="w-12 h-12 rounded-xl bg-amber-500/20 border border-amber-400/30 flex items-center justify-center text-amber-400 mb-4">
                    <iconify-icon icon="solar:user-hand-up-bold" width="24"></iconify-icon>
                </div>
                <h4 class="font-heading font-bold text-white text-base mb-1.5">Instalasi Cepat</h4>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Tim teknisi bersertifikasi siap melakukan survei dan penarikan kabel dalam 1-3 hari kerja.
                </p>
            </div>

        </div>

        <!-- Covered Areas Directory / Region List -->
        @if($coverageAreas->isNotEmpty())
            <div class="mt-12 sm:mt-16 p-6 sm:p-8 rounded-3xl bg-white/[0.02] border border-white/10 reveal-on-scroll">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-white/10">
                    <div>
                        <h3 class="font-heading font-bold text-white text-lg sm:text-xl flex items-center gap-2">
                            <iconify-icon icon="solar:map-point-wave-bold" class="text-[#38bdf8]"></iconify-icon>
                            <span>Daftar Wilayah Jangkauan Aktif</span>
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">
                            Area berikut telah terhubung infrastruktur ODP / FTTx PT Media Solusi Network.
                        </p>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-mono text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-3 py-1.5 rounded-full self-start sm:self-auto">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        <span>{{ $coverageAreas->count() }} Area Terdaftar</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2.5 sm:gap-3">
                    @foreach($coverageAreas->take(18) as $area)
                        <button 
                            type="button" 
                            class="quick-city p-3 rounded-xl bg-white/[0.04] hover:bg-sky-500/20 border border-white/5 hover:border-sky-400/40 text-left transition-all duration-200 group cursor-pointer"
                            data-city="{{ $area->district ? $area->district . ', ' . $area->city : $area->city }}"
                        >
                            <div class="text-[11px] font-mono text-sky-400 font-semibold truncate group-hover:text-white">
                                {{ $area->city }}
                            </div>
                            <div class="text-xs font-heading font-bold text-slate-200 truncate mt-0.5">
                                {{ $area->district ?? $area->village }}
                            </div>
                            <div class="flex items-center gap-1 mt-1 text-[10px] text-emerald-400 font-mono">
                                <iconify-icon icon="solar:check-circle-bold" width="12"></iconify-icon>
                                <span>Aktif</span>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>
