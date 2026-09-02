<footer class="pt-16 pb-12 px-4 sm:px-6 lg:px-8 border-t border-slate-200 relative z-10 bg-[#050d1a] text-white w-full">
    <div class="max-w-7xl mx-auto">
        
        <!-- Main 5-Column Corporate Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-white/10">
            
            <!-- Col 1: Brand Info & Legitimacy (5 cols) -->
            <div class="lg:col-span-5 space-y-4">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo/logo-msn-white.png') }}" alt="Logo PT Media Solusi Network" class="h-9 w-auto object-contain">
                </div>

                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-sm">
                    Menyediakan solusi konektivitas dan infrastruktur digital untuk Indonesia. Berlisensi resmi sebagai penyelenggara jasa telekomunikasi dan pengembang sistem enterprise.
                </p>

                <!-- Corporate Contact & Location Data -->
                <div class="space-y-2 pt-2 text-xs text-slate-300 font-sans">
                    <div class="flex items-start gap-2.5">
                        <iconify-icon icon="solar:map-point-bold" width="16" class="text-[#38bdf8] shrink-0 mt-0.5"></iconify-icon>
                        <span>{{ config('company.address') }}</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <iconify-icon icon="solar:phone-bold" width="16" class="text-[#38bdf8] shrink-0"></iconify-icon>
                        <a href="https://wa.me/{{ config('company.whatsapp') }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">
                            WhatsApp: {{ config('company.whatsapp_display') }}
                        </a>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <iconify-icon icon="solar:letter-bold" width="16" class="text-[#38bdf8] shrink-0"></iconify-icon>
                        <a href="mailto:{{ config('company.email') }}" class="hover:text-white transition-colors">
                            Email: {{ config('company.email') }}
                        </a>
                    </div>
                </div>

                <!-- Social Media & Maps Links -->
                <div class="flex items-center gap-2.5 pt-2">
                    @if(config('company.instagram'))
                        <a href="{{ config('company.instagram') }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-white/10 border border-white/15 flex items-center justify-center text-slate-300 hover:text-[#38bdf8] hover:border-[#38bdf8]/50 transition-colors" aria-label="Instagram">
                            <iconify-icon icon="solar:camera-bold" width="16"></iconify-icon>
                        </a>
                    @endif
                    @if(config('company.linkedin'))
                        <a href="{{ config('company.linkedin') }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-white/10 border border-white/15 flex items-center justify-center text-slate-300 hover:text-[#38bdf8] hover:border-[#38bdf8]/50 transition-colors" aria-label="LinkedIn">
                            <iconify-icon icon="solar:link-circle-bold" width="16"></iconify-icon>
                        </a>
                    @endif
                    <a href="{{ config('company.maps_url') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/10 border border-white/15 text-xs text-slate-300 hover:text-[#38bdf8] transition-colors" aria-label="Google Maps">
                        <iconify-icon icon="solar:map-bold" width="14" class="text-[#38bdf8]"></iconify-icon>
                        <span>Google Maps</span>
                    </a>
                </div>
            </div>

            <!-- Col 2, 3, 4: Navigation Links (2 Columns on Mobile, 3 Columns on Tablet/Desktop) -->
            <div class="lg:col-span-7 grid grid-cols-2 sm:grid-cols-3 gap-6 sm:gap-8 pt-4 lg:pt-0 border-t border-white/10 lg:border-t-0">
                
                <!-- Layanan -->
                <div>
                    <div class="font-heading font-bold text-xs font-mono uppercase tracking-wider text-[#38bdf8] mb-4">Layanan</div>
                    <ul class="space-y-2.5 text-xs text-slate-300 font-medium">
                        <li><a href="#paket" class="hover:text-white transition-colors">Internet Broadband</a></li>
                        <li><a href="#layanan" class="hover:text-white transition-colors">Fiber Optic</a></li>
                        <li><a href="#layanan" class="hover:text-white transition-colors">Network Infrastructure</a></li>
                        <li><a href="#layanan" class="hover:text-white transition-colors">Digital Solutions</a></li>
                    </ul>
                </div>

                <!-- Perusahaan -->
                <div>
                    <div class="font-heading font-bold text-xs font-mono uppercase tracking-wider text-[#38bdf8] mb-4">Perusahaan</div>
                    <ul class="space-y-2.5 text-xs text-slate-300 font-medium">
                        <li><a href="#tentang-kami" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#portofolio" class="hover:text-white transition-colors">Proyek</a></li>
                        <li><a href="#coverage" class="hover:text-white transition-colors">Coverage</a></li>
                        <li><a href="#kontak" class="hover:text-white transition-colors">Karir</a></li>
                    </ul>
                </div>

                <!-- Bantuan & NOC -->
                <div class="col-span-2 sm:col-span-1 pt-4 sm:pt-0 border-t border-white/10 sm:border-t-0">
                    <div class="font-heading font-bold text-xs font-mono uppercase tracking-wider text-[#38bdf8] mb-4">Bantuan & NOC</div>
                    <ul class="grid grid-cols-2 sm:grid-cols-1 gap-2.5 text-xs text-slate-300 font-medium">
                        <li><a href="#faq" class="hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#kontak" class="hover:text-white transition-colors">Support 24/7</a></li>
                        <li><a href="#kontak" class="hover:text-white transition-colors">Kontak Kami</a></li>
                        <li class="flex items-center gap-1.5 text-[11px] text-emerald-400 font-mono">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>NOC Active</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

        <!-- Footer Bottom Bar -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400 font-mono">
            <div>
                &copy; 2026 PT Media Solusi Network. All Rights Reserved.
            </div>
            <div class="flex items-center gap-4">
                <a href="#hero" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                <span>•</span>
                <a href="#hero" class="hover:text-white transition-colors">Privasi</a>
                <span>•</span>
                <span class="text-[#38bdf8]">ISP Berlisensi Resmi</span>
            </div>
        </div>
    </div>
</footer>
