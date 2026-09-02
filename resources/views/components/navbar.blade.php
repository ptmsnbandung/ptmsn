<header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 w-full bg-transparent border-b border-[#38bdf8]/35 py-2.5 sm:py-3.5 shadow-[0_1px_15px_rgba(56,189,248,0.15)]" id="mainNavbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4">
            
            <!-- Pure Brand Logo without Box (Dual-State: White on Dark Hero, Color on White Scrolled) -->
            <a href="#hero" class="flex items-center group flex-shrink-0 relative" aria-label="PT Media Solusi Network">
                <!-- White Logo (Default on Dark Hero) -->
                <img 
                    src="{{ asset('images/logo/logo-msn-white.png') }}" 
                    alt="Logo PT Media Solusi Network" 
                    class="h-6 sm:h-8 md:h-9 w-auto object-contain transition-all duration-300 group-hover:scale-105 block" 
                    id="navLogoWhite"
                >
                <!-- Full Color Logo: logo-msn BG Trans (Active on White Scrolled Navbar) -->
                <img 
                    src="{{ asset('images/logo/logo-msn BG Trans.png') }}" 
                    alt="Logo PT Media Solusi Network" 
                    class="h-6 sm:h-8 md:h-9 w-auto object-contain transition-all duration-300 group-hover:scale-105 hidden" 
                    id="navLogoColor"
                >
            </a>

            <!-- Navigation Pill Dock with Dynamic Active State Indicator -->
            <nav class="hidden lg:flex items-center gap-0.5 xl:gap-1 bg-white/[0.07] backdrop-blur-md p-1.5 rounded-full border border-white/15 transition-all duration-300" id="navPillDock">
                <a href="#hero" class="nav-link-item px-3 xl:px-3.5 py-1.5 rounded-full text-xs font-bold text-[#38bdf8] bg-white/20 transition-all duration-150 whitespace-nowrap">
                    Home
                </a>
                <a href="#tentang-kami" class="nav-link-item px-2.5 xl:px-3 py-1.5 rounded-full text-xs font-medium text-white/80 hover:text-white transition-all duration-150 whitespace-nowrap">
                    Tentang Kami
                </a>
                <a href="#layanan" class="nav-link-item px-2.5 xl:px-3 py-1.5 rounded-full text-xs font-medium text-white/80 hover:text-white transition-all duration-150 whitespace-nowrap">
                    Layanan
                </a>
                <a href="#coverage" class="nav-link-item px-2.5 xl:px-3 py-1.5 rounded-full text-xs font-medium text-white/80 hover:text-white transition-all duration-150 whitespace-nowrap">
                    Coverage
                </a>
                <a href="#paket" class="nav-link-item px-2.5 xl:px-3 py-1.5 rounded-full text-xs font-medium text-white/80 hover:text-white transition-all duration-150 whitespace-nowrap">
                    Paket
                </a>
                <a href="#portofolio" class="nav-link-item px-2.5 xl:px-3 py-1.5 rounded-full text-xs font-medium text-white/80 hover:text-white transition-all duration-150 whitespace-nowrap">
                    Proyek
                </a>
                <a href="#faq" class="nav-link-item px-2.5 xl:px-3 py-1.5 rounded-full text-xs font-medium text-white/80 hover:text-white transition-all duration-150 whitespace-nowrap">
                    FAQ
                </a>
                <a href="#kontak" class="nav-link-item px-2.5 xl:px-3 py-1.5 rounded-full text-xs font-medium text-white/80 hover:text-white transition-all duration-150 whitespace-nowrap">
                    Kontak
                </a>
            </nav>

            <!-- High-Converting CTA Button: Cek Coverage → -->
            <div class="flex items-center gap-3">
                <a href="#coverage" class="hidden sm:inline-flex items-center gap-2 px-4 xl:px-5 py-2.5 rounded-full bg-[#38bdf8] text-[#050d1a] font-heading font-bold text-xs sm:text-sm hover:bg-white hover:text-[#0284c7] transition-all duration-200 shadow-[0_0_20px_rgba(56,189,248,0.35)] hover:scale-105 active:scale-95 whitespace-nowrap" id="navCtaBtn">
                    <span>Cek Coverage</span>
                    <iconify-icon icon="solar:arrow-right-linear" width="16"></iconify-icon>
                </a>

                <!-- Mobile Menu Button -->
                <button type="button" class="lg:hidden p-2 sm:p-2.5 rounded-lg sm:rounded-xl bg-white/10 border border-white/20 text-white hover:text-[#38bdf8] transition-colors" id="mobileMenuBtn" aria-label="Buka Menu">
                    <iconify-icon icon="solar:hamburger-menu-linear" width="20" class="sm:w-[22px] sm:h-[22px]"></iconify-icon>
                </button>
            </div>

        </div>
    </div>
</header>

<!-- Mobile Navigation Drawer -->
<div id="mobileOverlay" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-opacity duration-300"></div>

<div id="mobileDrawer" class="fixed top-0 right-0 bottom-0 w-[280px] bg-slate-900 border-l border-white/10 p-6 z-50 transform translate-x-full transition-transform duration-300 flex flex-col justify-between">
    <div>
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-white/10">
            <img src="{{ asset('images/logo/logo-msn-white.png') }}" alt="Logo PT MSN" class="h-6 sm:h-7 w-auto object-contain">
            <button id="mobileCloseBtn" class="text-white/60 hover:text-white p-1">
                <iconify-icon icon="solar:close-circle-linear" width="24"></iconify-icon>
            </button>
        </div>

        <nav class="flex flex-col gap-1.5">
            <a href="#hero" class="mobile-nav-link text-sm font-semibold text-white/80 hover:text-[#38bdf8] py-2 px-3 rounded-lg hover:bg-white/5 transition-colors">
                Home
            </a>
            <a href="#tentang-kami" class="mobile-nav-link text-sm font-semibold text-white/80 hover:text-[#38bdf8] py-2 px-3 rounded-lg hover:bg-white/5 transition-colors">
                Tentang Kami
            </a>
            <a href="#layanan" class="mobile-nav-link text-sm font-semibold text-white/80 hover:text-[#38bdf8] py-2 px-3 rounded-lg hover:bg-white/5 transition-colors">
                Layanan
            </a>
            <a href="#coverage" class="mobile-nav-link text-sm font-semibold text-white/80 hover:text-[#38bdf8] py-2 px-3 rounded-lg hover:bg-white/5 transition-colors">
                Coverage
            </a>
            <a href="#paket" class="mobile-nav-link text-sm font-semibold text-white/80 hover:text-[#38bdf8] py-2 px-3 rounded-lg hover:bg-white/5 transition-colors">
                Paket
            </a>
            <a href="#portofolio" class="mobile-nav-link text-sm font-semibold text-white/80 hover:text-[#38bdf8] py-2 px-3 rounded-lg hover:bg-white/5 transition-colors">
                Proyek
            </a>
            <a href="#faq" class="mobile-nav-link text-sm font-semibold text-white/80 hover:text-[#38bdf8] py-2 px-3 rounded-lg hover:bg-white/5 transition-colors">
                FAQ
            </a>
            <a href="#kontak" class="mobile-nav-link text-sm font-semibold text-white/80 hover:text-[#38bdf8] py-2 px-3 rounded-lg hover:bg-white/5 transition-colors">
                Kontak
            </a>
        </nav>
    </div>

    <div class="pt-6 border-t border-white/10">
        <a href="#coverage" class="w-full py-3 rounded-xl bg-[#38bdf8] text-[#050d1a] font-heading font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg shadow-sky-500/20">
            <span>Cek Coverage</span>
            <iconify-icon icon="solar:arrow-right-linear" width="16"></iconify-icon>
        </a>
    </div>
</div>
