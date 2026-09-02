<section class="py-8 sm:py-10 px-4 sm:px-6 lg:px-8 relative z-10 bg-transparent w-full">
    <div class="max-w-4xl mx-auto rounded-3xl p-6 sm:p-8 relative overflow-hidden text-center shadow-lg border border-sky-400/25" style="background: linear-gradient(150deg, #07172e 0%, #0c2445 50%, #07172e 100%);">
        
        <!-- Subtle Diagonal Accent -->
        <div class="absolute inset-0 pointer-events-none opacity-20" style="background-image: repeating-linear-gradient(115deg, rgba(255, 255, 255, 0.03) 0px, rgba(255, 255, 255, 0.03) 1px, transparent 1px, transparent 8px);"></div>

        <div class="relative z-10 max-w-xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center px-3 py-1 rounded-full bg-white/[0.08] border border-white/20 text-[10px] font-mono text-[#38bdf8] uppercase tracking-wider mb-3.5 backdrop-blur-md">
                <span>{{ \App\Models\SiteSetting::get('cta_badge', 'Infrastruktur & Layanan Dedicated') }}</span>
            </div>

            <!-- Headline (Compact & Balanced Proportion) -->
            <h2 class="font-heading font-extrabold text-xl sm:text-2xl lg:text-[25px] text-white tracking-tight leading-snug mb-2.5" data-reveal-words>
                {{ \App\Models\SiteSetting::get('cta_title', 'Mari Bangun Koneksi yang Lebih Baik.') }}
            </h2>

            <!-- Subtitle -->
            <p class="font-sans text-xs sm:text-sm text-slate-300 leading-relaxed mb-6">
                {{ \App\Models\SiteSetting::get('cta_description', 'Konsultasikan kebutuhan internet dan infrastruktur jaringan Anda bersama tim spesialis kami untuk solusi konektivitas yang andal dan terukur.') }}
            </p>

            <!-- Dual Action Buttons -->
            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="#kontak" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-bold text-xs transition-all duration-200 shadow-md shadow-sky-500/20 hover:scale-105 active:scale-95">
                    <span>Konsultasi Sekarang</span>
                    <iconify-icon icon="solar:arrow-right-linear" width="15"></iconify-icon>
                </a>
                <a href="https://wa.me/{{ config('company.whatsapp') }}?text={{ urlencode('Halo PT Media Solusi Network, saya ingin berkonsultasi mengenai solusi internet & infrastruktur jaringan.') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/25 text-white font-heading font-semibold text-xs transition-all duration-200 backdrop-blur-md hover:scale-105 active:scale-95">
                    <iconify-icon icon="solar:chat-round-dots-bold" width="15" class="text-emerald-400"></iconify-icon>
                    <span>WhatsApp</span>
                </a>
            </div>
        </div>

    </div>
</section>
