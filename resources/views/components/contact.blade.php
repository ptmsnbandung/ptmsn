<section id="kontak" class="py-20 sm:py-28 px-4 sm:px-6 lg:px-8 relative z-10 bg-transparent w-full">
    <div class="max-w-7xl mx-auto">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20 reveal-on-scroll">
            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-sky-100/80 border border-sky-200 text-xs font-mono text-[#0284c7] uppercase tracking-wider mb-4 font-semibold shadow-xs">
                <span>Lokasi Kantor & Layanan Pelanggan</span>
            </div>
            <h2 class="font-heading font-extrabold text-3xl sm:text-4xl lg:text-[44px] text-slate-900 tracking-tight mb-5 leading-tight" data-reveal-words>
                Kunjungi Kantor & Hubungi Kami.
            </h2>
            <p class="font-sans text-base sm:text-lg text-slate-600 leading-[1.7]">
                Pusat operasional jaringan, NOC 24/7, dan customer care PT. MSN siap melayani konsultasi kebutuhan internet dan infrastruktur digital Anda.
            </p>
        </div>

        <div class="grid lg:grid-cols-12 gap-10 lg:gap-12 items-stretch">
            
            <!-- Left Column: Company Contact Info (5 cols) -->
            <div class="lg:col-span-5 flex flex-col justify-between space-y-4 reveal-from-left">
                
                <!-- Card 1: Alamat Operasional Resmi -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex items-start gap-4 hover:border-sky-300 transition-colors">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-200 flex items-center justify-center text-[#0284c7] flex-shrink-0">
                        <iconify-icon icon="solar:map-point-bold" width="24"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-[11px] font-mono uppercase tracking-wider text-[#0284c7] font-bold">Kantor Operasional & NOC</div>
                        <div class="font-heading font-bold text-slate-900 text-base mt-1 leading-snug">
                            {{ \App\Models\SiteSetting::get('company_address', config('company.address')) }}
                        </div>
                        <div class="text-xs text-slate-500 mt-1 font-sans">Turangga, Kec. Lengkong, Kota Bandung</div>
                    </div>
                </div>

                <!-- Card 2: WhatsApp & Telepon -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex items-start gap-4 hover:border-sky-300 transition-colors">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600 flex-shrink-0">
                        <iconify-icon icon="solar:phone-calling-bold" width="24"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-[11px] font-mono uppercase tracking-wider text-emerald-600 font-bold">WhatsApp & Hotline</div>
                        <div class="font-heading font-bold text-slate-900 text-base mt-1">
                            <a href="https://wa.me/{{ \App\Models\SiteSetting::get('company_whatsapp', config('company.whatsapp')) }}" target="_blank" rel="noopener noreferrer" class="text-[#0284c7] hover:underline">{{ config('company.whatsapp_display') }}</a>
                        </div>
                        <div class="text-xs text-slate-500 mt-0.5">Telepon Kantor: {{ \App\Models\SiteSetting::get('company_phone', config('company.phone')) }}</div>
                    </div>
                </div>

                <!-- Card 3: Email Resmi -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex items-start gap-4 hover:border-sky-300 transition-colors">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-200 flex items-center justify-center text-[#0284c7] flex-shrink-0">
                        <iconify-icon icon="solar:letter-bold" width="24"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-[11px] font-mono uppercase tracking-wider text-[#0284c7] font-bold">Email Perusahaan</div>
                        <div class="font-heading font-bold text-slate-900 text-base mt-1">
                            <a href="mailto:{{ \App\Models\SiteSetting::get('company_email', config('company.email')) }}" class="hover:text-[#0284c7] transition-colors">{{ \App\Models\SiteSetting::get('company_email', config('company.email')) }}</a>
                        </div>
                        <div class="text-xs text-slate-500 mt-0.5">Penawaran & Bantuan Teknis</div>
                    </div>
                </div>

                <!-- Card 4: Jam Kerja & Monitoring -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex items-start gap-4 hover:border-sky-300 transition-colors">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-200 flex items-center justify-center text-[#0284c7] flex-shrink-0">
                        <iconify-icon icon="solar:clock-circle-bold" width="24"></iconify-icon>
                    </div>
                    <div>
                        <div class="text-[11px] font-mono uppercase tracking-wider text-[#0284c7] font-bold">Jam Layanan & Monitoring</div>
                        <div class="font-heading font-bold text-slate-900 text-base mt-1">{{ \App\Models\SiteSetting::get('company_hours', config('company.operational_hours')) }}</div>
                        <div class="text-xs text-emerald-600 font-mono font-semibold mt-0.5">Helpdesk NOC: 24/7/365 Non-Stop</div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Interactive Google Maps Container (7 cols) -->
            <div class="lg:col-span-7 flex flex-col justify-between reveal-from-right">
                <div class="relative w-full h-full min-h-[440px] rounded-3xl overflow-hidden border border-slate-200 shadow-xl bg-white flex flex-col">
                    
                    <!-- Google Maps Iframe (PT. MSN - Jl. Reog No.18 Bandung) -->
                    <div class="relative w-full flex-grow min-h-[380px]">
                        <iframe 
                            src="{{ config('company.maps_embed') }}" 
                            width="100%" 
                            height="100%" 
                            style="border:0; min-height: 380px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Kantor PT. MSN (Media Solusi Network)"
                            class="w-full h-full object-cover"
                        ></iframe>

                        <!-- Floating Location Pin Badge -->
                        <div class="absolute top-4 left-4 z-10 px-4 py-2.5 rounded-2xl bg-slate-900/90 border border-white/20 backdrop-blur-md text-white shadow-lg flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-sky-500/20 text-[#38bdf8] flex items-center justify-center">
                                <iconify-icon icon="solar:buildings-bold" width="20"></iconify-icon>
                            </div>
                            <div>
                                <div class="font-heading font-bold text-xs text-white">PT. MSN ( Media Solusi Network )</div>
                                <div class="text-[10px] text-slate-300 font-mono">Jl. Reog No. 18, Lengkong, Bandung</div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Bar of Map Card: Quick Action Buttons -->
                    <div class="p-4 sm:p-5 bg-white border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="text-xs text-slate-600 font-sans">
                            Buka petunjuk arah navigasi GPS langsung di Google Maps untuk menuju kantor PT. MSN.
                        </div>
                        <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                            <a 
                                href="{{ config('company.maps_url') }}" 
                                target="_blank" 
                                rel="noopener noreferrer" 
                                class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-heading font-bold text-xs transition-colors shadow-xs w-full sm:w-auto"
                            >
                                <iconify-icon icon="solar:map-bold" width="16" class="text-[#0284c7]"></iconify-icon>
                                <span>Petunjuk Arah (Maps)</span>
                            </a>
                            <a 
                                href="https://wa.me/{{ config('company.whatsapp') }}?text={{ urlencode('Halo PT Media Solusi Network, saya ingin membuat janji temu / survei lokasi.') }}" 
                                target="_blank" 
                                rel="noopener noreferrer" 
                                class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-xl bg-[#0284c7] hover:bg-[#0369a1] text-white font-heading font-bold text-xs transition-colors shadow-sm w-full sm:w-auto"
                            >
                                <iconify-icon icon="solar:chat-round-dots-bold" width="16"></iconify-icon>
                                <span>WhatsApp Hotline</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>
