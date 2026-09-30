@php
    $isFirstLogin = (int)(auth('customer')->user()->is_login ?? 0) === 0;
    $currentRouteName = request()->route()?->getName() ?? '';
    $requestedStep = request()->query('tour_step');
    
    // Tentukan apakah tour harus aktif otomatis di halaman saat ini
    $shouldActive = false;
    $initialStepIdx = 0;

    if ($requestedStep !== null && is_numeric($requestedStep)) {
        $initialStepIdx = max(0, min(4, ((int)$requestedStep) - 1));
        $shouldActive = true;
    } elseif ($isFirstLogin && ($currentRouteName === 'portal.dashboard' || request()->is('portal') || request()->is('portal/dashboard'))) {
        $initialStepIdx = 0;
        $shouldActive = true;
    }
@endphp

<!-- Interactive Product Tour / Onboarding Component (5 Langkah untuk 1 Aplikasi) -->
<div 
    x-data="portalOnboardingTour({
        shouldActive: {{ $shouldActive ? 'true' : 'false' }},
        initialStep: {{ $initialStepIdx }},
        routes: {
            dashboard: '{{ route('portal.dashboard') }}',
            tickets: '{{ route('portal.tickets.index') }}',
            billing: '{{ route('portal.billing.index') }}',
            complete: '{{ route('portal.onboarding.complete') }}'
        }
    })"
    x-init="initTour()"
    x-show="isOpen"
    x-cloak
    class="fixed inset-0 z-[100] overflow-hidden pointer-events-none transition-opacity duration-300"
    :class="isOpen ? 'opacity-100' : 'opacity-0'"
    style="display: none;"
    @keydown.escape.window="skipTour()"
    @resize.window="updatePosition()"
    @wheel.window="if(isOpen) { $event.preventDefault(); }"
    @touchmove.window="if(isOpen) { $event.preventDefault(); }"
>
    <!-- Darkened Backdrop with cutout spotlight focus ring (Single Crisp Ring) -->
    <div 
        class="fixed transition-all duration-200 pointer-events-auto rounded-2xl ring-2 ring-sky-400 shadow-[0_0_0_9999px_rgba(15,23,42,0.80)]"
        :style="`top: ${spotlight.top}px; left: ${spotlight.left}px; width: ${spotlight.width}px; height: ${spotlight.height}px;`"
    ></div>

    <!-- Floating Interactive Popover Tooltip Card -->
    <div 
        class="fixed transition-all duration-200 pointer-events-auto z-[102] w-[88vw] max-w-[320px] sm:max-w-[420px]"
        :style="`top: ${popover.top}px; left: ${popover.left}px;`"
    >
        <div class="bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl p-3.5 sm:p-5 shadow-2xl border border-sky-200/90 text-slate-800 space-y-2.5 sm:space-y-3.5 relative overflow-hidden">
            
            <!-- Top Gradient Accent Bar & Progress Tracker -->
            <div class="absolute top-0 inset-x-0 h-1 sm:h-1.5 bg-slate-100 overflow-hidden">
                <div 
                    class="h-full bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-600 transition-all duration-300"
                    :style="`width: ${((currentStep + 1) / steps.length) * 100}%`"
                ></div>
            </div>

            <!-- Header: Step Badge & Skip Button -->
            <div class="flex items-center justify-between pt-0.5">
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 sm:px-3 sm:py-1 rounded-full bg-sky-50 border border-sky-200/80 text-sky-700 font-heading font-extrabold text-[10px] sm:text-xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-pulse"></span>
                        <span x-text="`Langkah ${currentStep + 1} dari ${steps.length}`"></span>
                    </span>
                    <span class="text-[9px] sm:text-[10px] font-mono text-slate-400 font-medium" x-text="steps[currentStep]?.pageLabel"></span>
                </div>

                <button 
                    type="button" 
                    @click="skipTour()"
                    class="text-slate-400 hover:text-slate-600 font-heading text-[10px] sm:text-xs font-semibold px-1.5 py-0.5 rounded-lg hover:bg-slate-100 transition-colors flex items-center gap-1 cursor-pointer"
                    title="Lewati panduan interaktif"
                >
                    <span>Lewati</span>
                    <iconify-icon icon="solar:close-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                </button>
            </div>

            <!-- Content Body: Icon, Title & Description -->
            <div class="space-y-1.5 sm:space-y-2">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-2xl bg-gradient-to-tr from-sky-500 to-blue-600 text-white flex items-center justify-center shrink-0 shadow-xs sm:shadow-md shadow-sky-500/25">
                        <iconify-icon :icon="steps[currentStep]?.icon || 'solar:star-bold'" class="text-sm sm:text-xl"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="text-xs sm:text-base font-heading font-extrabold text-slate-900 tracking-tight leading-tight" x-text="steps[currentStep]?.title"></h3>
                        <p class="text-[9px] sm:text-[11px] font-mono font-medium text-sky-600 leading-tight" x-text="steps[currentStep]?.subtitle"></p>
                    </div>
                </div>

                <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed" x-text="steps[currentStep]?.description"></p>
            </div>

            <!-- Footer: Progress Dots & Action Buttons -->
            <div class="pt-2 sm:pt-2.5 border-t border-slate-100 flex items-center justify-between gap-2">
                
                <!-- 5 Clickable Progress Dots -->
                <div class="flex items-center gap-1 sm:gap-1.5">
                    <template x-for="(step, idx) in steps" :key="idx">
                        <button 
                            type="button" 
                            @click="goToStep(idx)"
                            class="h-1.5 rounded-full transition-all duration-300 cursor-pointer"
                            :class="currentStep === idx ? 'w-4 sm:w-5 bg-sky-600' : 'w-1.5 bg-slate-200 hover:bg-slate-300'"
                            :title="`Buka langkah ${idx + 1}: ${step.title}`"
                        ></button>
                    </template>
                </div>

                <!-- Next / Prev Controls -->
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <button 
                        type="button"
                        @click="prevStep()"
                        x-show="currentStep > 0"
                        class="px-2.5 py-1.5 sm:px-3 sm:py-1.5 rounded-lg sm:rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-bold text-[10px] sm:text-xs transition-all cursor-pointer flex items-center gap-0.5 sm:gap-1"
                    >
                        <iconify-icon icon="solar:arrow-left-linear" class="text-xs sm:text-sm"></iconify-icon>
                        <span>Kembali</span>
                    </button>

                    <button 
                        type="button"
                        @click="nextStep()"
                        class="px-3 py-1.5 sm:px-4 sm:py-1.5 rounded-lg sm:rounded-xl font-heading font-extrabold text-[10px] sm:text-xs shadow-sm sm:shadow-md transition-all active:scale-95 cursor-pointer flex items-center gap-1"
                        :class="currentStep === steps.length - 1 
                            ? 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white shadow-emerald-600/20' 
                            : 'bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white shadow-sky-600/20'"
                    >
                        <span x-text="getNextButtonText()"></span>
                        <iconify-icon :icon="currentStep === steps.length - 1 ? 'solar:check-circle-bold' : 'solar:arrow-right-linear'" class="text-xs sm:text-sm"></iconify-icon>
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('portalOnboardingTour', (config) => ({
            isOpen: false,
            currentStep: config.initialStep || 0,
            spotlight: { top: 0, left: 0, width: 0, height: 0 },
            popover: { top: 0, left: 0 },
            routes: config.routes,
            
            // 5 Langkah Terpadu untuk Seluruh Aplikasi Portal
            steps: [
                // 1. Dashboard (1 Langkah)
                {
                    page: 'dashboard',
                    pageLabel: 'Dashboard',
                    target: '#tour-step-hero',
                    title: 'Beranda & Status Koneksi',
                    subtitle: 'Dashboard Utama MyMSN',
                    icon: 'solar:shield-check-bold',
                    description: 'Pantau status koneksi fiber optic secara real-time, salin ID Pelanggan, dan akses ringkasan layanan Anda.'
                },
                // 2. Halaman Gangguan (Langkah 1 Gangguan)
                {
                    page: 'tickets',
                    pageLabel: 'Laporan Gangguan',
                    target: '#tour-step-create-ticket',
                    title: 'Buat Laporan Kendala',
                    subtitle: 'Pengaduan Teknis 24 Jam',
                    icon: 'solar:danger-triangle-bold',
                    description: 'Klik tombol ini untuk mengajukan tiket laporan kendala koneksi langsung ke tim teknisi NOC.'
                },
                // 3. Halaman Gangguan (Langkah 2 Gangguan)
                {
                    page: 'tickets',
                    pageLabel: 'Laporan Gangguan',
                    target: '#tour-step-tickets-list',
                    title: 'Pantau Progres Penanganan',
                    subtitle: 'Transparan & Real-time',
                    icon: 'solar:ticket-sale-bold',
                    description: 'Lacak status perbaikan laporan teknisi secara transparan, mulai verifikasi hingga penanganan tuntas.'
                },
                // 4. Halaman Pembayaran (Langkah 1 Pembayaran)
                {
                    page: 'billing',
                    pageLabel: 'Tagihan',
                    target: '#tour-step-midtrans-pay',
                    title: 'Pembayaran Online Instan',
                    subtitle: 'QRIS & Virtual Account 24 Jam',
                    icon: 'solar:bolt-circle-bold',
                    description: 'Bayar tagihan otomatis 24 jam via QRIS (GoPay/OVO/Dana) atau Virtual Account Bank resmi.'
                },
                // 5. Halaman Pembayaran (Langkah 2 Pembayaran)
                {
                    page: 'billing',
                    pageLabel: 'Tagihan',
                    target: '#tour-step-transfer-tab',
                    title: 'Transfer Bank & Konfirmasi',
                    subtitle: 'Rekening Resmi PT MSN',
                    icon: 'solar:card-recive-bold',
                    description: 'Transfer ke nomor rekening resmi PT MSN dan unggah foto struk transfer di menu ini.'
                }
            ],

            initTour() {
                this.adaptStepsForCurrentPage();

                window.startPortalTour = () => {
                    window.location.href = `${this.routes.dashboard}?tour_step=1`;
                };

                if (config.shouldActive) {
                    this.startTour();
                }
            },

            adaptStepsForCurrentPage() {
                const currentPage = this.getCurrentPageName();
                if (currentPage === 'billing') {
                    const isPaid = document.querySelector('#tour-step-billing-status') !== null || !document.querySelector('#tour-step-midtrans-pay');
                    if (isPaid && document.querySelector('#tour-step-billing-status')) {
                        this.steps[3] = {
                            page: 'billing',
                            pageLabel: 'Tagihan',
                            target: '#tour-step-billing-status',
                            title: 'Status Tagihan & Rincian',
                            subtitle: 'Tagihan Lunas & Terverifikasi',
                            icon: 'solar:check-circle-bold',
                            description: 'Tagihan periode ini telah lunas sehingga layanan internet Anda aktif lancar.'
                        };
                        this.steps[4] = {
                            page: 'billing',
                            pageLabel: 'Tagihan',
                            target: '#tour-step-billing-actions',
                            title: 'Cetak Invoice & Bantuan',
                            subtitle: 'Akses Dokumen Resmi',
                            icon: 'solar:printer-minimalistic-bold',
                            description: 'Unduh invoice digital resmi atau hubungi WhatsApp Billing jika memerlukan bantuan.'
                        };
                    }
                }
            },

            lockScroll() {
                window.scrollTo({ top: 0, left: 0, behavior: 'instant' });
                document.documentElement.style.overflow = 'hidden';
                document.body.style.overflow = 'hidden';
                document.body.style.touchAction = 'none';

                this._preventScroll = (e) => {
                    if (this.isOpen) {
                        e.preventDefault();
                    }
                };
                window.addEventListener('wheel', this._preventScroll, { passive: false });
                window.addEventListener('touchmove', this._preventScroll, { passive: false });

                this._keyHandler = (e) => {
                    if (this.isOpen && ['Space', 'PageUp', 'PageDown', 'End', 'Home', 'ArrowUp', 'ArrowDown'].includes(e.code)) {
                        e.preventDefault();
                    }
                };
                window.addEventListener('keydown', this._keyHandler, { passive: false });
            },

            unlockScroll() {
                document.documentElement.style.overflow = '';
                document.body.style.overflow = '';
                document.body.style.touchAction = '';
                if (this._preventScroll) {
                    window.removeEventListener('wheel', this._preventScroll);
                    window.removeEventListener('touchmove', this._preventScroll);
                }
                if (this._keyHandler) {
                    window.removeEventListener('keydown', this._keyHandler);
                }
            },

            startTour() {
                this.adaptStepsForCurrentPage();
                this.lockScroll();
                this.isOpen = true;
                this.$nextTick(() => {
                    this.showStep(this.currentStep);
                });
            },

            getCurrentPageName() {
                const path = window.location.pathname;
                if (path.includes('/tagihan') || path.includes('/billing')) return 'billing';
                if (path.includes('/tickets') || path.includes('/tiket')) return 'tickets';
                return 'dashboard';
            },

            goToStep(stepIdx) {
                if (stepIdx < 0 || stepIdx >= this.steps.length) return;
                this.adaptStepsForCurrentPage();
                const targetStep = this.steps[stepIdx];
                const currentPage = this.getCurrentPageName();

                if (targetStep.page === currentPage) {
                    this.showStep(stepIdx);
                } else {
                    this.unlockScroll();
                    // Navigasi antar halaman
                    const targetUrl = this.routes[targetStep.page] || this.routes.dashboard;
                    window.location.href = `${targetUrl}?tour_step=${stepIdx + 1}`;
                }
            },

            getNextButtonText() {
                if (this.currentStep === this.steps.length - 1) {
                    return 'Selesai';
                }
                return 'Lanjut';
            },

            nextStep() {
                if (this.currentStep < this.steps.length - 1) {
                    this.goToStep(this.currentStep + 1);
                } else {
                    this.finishTour();
                }
            },

            prevStep() {
                if (this.currentStep > 0) {
                    this.goToStep(this.currentStep - 1);
                }
            },

            findTargetElement(selectorString) {
                if (!selectorString) return null;
                const selectors = selectorString.split(',').map(s => s.trim());
                for (const sel of selectors) {
                    const el = document.querySelector(sel);
                    if (el) return el;
                }
                return null;
            },

            showStep(stepIdx) {
                this.adaptStepsForCurrentPage();
                this.currentStep = stepIdx;
                const step = this.steps[stepIdx];
                if (!step) return;

                // Khusus halaman tagihan: aktifkan tab yang sesuai jika mode belum lunas
                if (step.page === 'billing') {
                    const isPaid = document.querySelector('#tour-step-billing-status') !== null;
                    if (!isPaid) {
                        if (stepIdx === 3) {
                            const midtransBtn = document.querySelector("button[\\@click*=\"paymentTab = 'midtrans'\"]");
                            if (midtransBtn) midtransBtn.click();
                        } else if (stepIdx === 4) {
                            const transferBtn = document.querySelector("#tour-step-transfer-tab");
                            if (transferBtn) transferBtn.click();
                        }
                    }
                }

                this.$nextTick(() => {
                    const targetEl = this.findTargetElement(step.target);
                    if (targetEl) {
                        this.calculatePosition(targetEl);
                    } else {
                        this.calculateFallbackPosition();
                    }
                });
            },

            calculatePosition(el) {
                const rect = el.getBoundingClientRect();
                const padding = window.innerWidth < 640 ? 6 : 8;

                this.spotlight = {
                    top: Math.max(0, rect.top - padding),
                    left: Math.max(0, rect.left - padding),
                    width: rect.width + (padding * 2),
                    height: rect.height + (padding * 2)
                };

                const popoverWidth = Math.min(window.innerWidth * 0.88, window.innerWidth < 640 ? 320 : 420);
                const popoverHeight = window.innerWidth < 640 ? 175 : 240;
                const margin = window.innerWidth < 640 ? 10 : 14;

                let popLeft = this.spotlight.left + (this.spotlight.width / 2) - (popoverWidth / 2);
                popLeft = Math.max(margin, Math.min(popLeft, window.innerWidth - popoverWidth - margin));

                let popTop = this.spotlight.top + this.spotlight.height + margin;
                if (popTop + popoverHeight > window.innerHeight && this.spotlight.top > popoverHeight + margin) {
                    popTop = this.spotlight.top - popoverHeight - margin;
                }

                popTop = Math.max(margin, Math.min(popTop, window.innerHeight - popoverHeight - margin));

                this.popover = {
                    top: popTop,
                    left: popLeft
                };
            },

            calculateFallbackPosition() {
                const width = Math.min(window.innerWidth * 0.88, window.innerWidth < 640 ? 320 : 420);
                const popoverHeight = window.innerWidth < 640 ? 175 : 240;
                this.spotlight = {
                    top: window.innerHeight / 2 - 40,
                    left: window.innerWidth / 2 - 130,
                    width: 260,
                    height: 80
                };
                this.popover = {
                    top: window.innerHeight / 2 - (popoverHeight / 2),
                    left: window.innerWidth / 2 - (width / 2)
                };
            },

            updatePosition() {
                if (!this.isOpen) return;
                const step = this.steps[this.currentStep];
                if (step) {
                    const targetEl = this.findTargetElement(step.target);
                    if (targetEl) {
                        this.calculatePosition(targetEl);
                    }
                }
            },

            finishTour() {
                this.unlockScroll();
                this.isOpen = false;
                this.markCompletedOnServer();

                if (window.Swal) {
                    Swal.fire({
                        imageUrl: '{{ asset('images/logo/berhasil1.png') }}',
                        imageWidth: 110,
                        imageHeight: 110,
                        imageAlt: 'Selamat Datang',
                        title: 'Selamat Datang',
                        showConfirmButton: false,
                        timer: 2000,
                        customClass: {
                            popup: 'rounded-3xl shadow-2xl p-6 border border-sky-100',
                            title: 'font-heading font-extrabold text-xl sm:text-2xl text-slate-800 tracking-tight mt-2'
                        }
                    }).then(() => {
                        window.location.href = this.routes.dashboard;
                    });
                } else {
                    window.location.href = this.routes.dashboard;
                }
            },

            skipTour() {
                this.unlockScroll();
                this.isOpen = false;
                this.markCompletedOnServer();
            },

            markCompletedOnServer() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                fetch(this.routes.complete, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ is_login: 1 })
                }).catch(err => console.log('Tour completed signal:', err));
            }
        }));
    });
</script>
