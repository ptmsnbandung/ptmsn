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
    @scroll.window="updatePosition()"
>
    <!-- Darkened Backdrop with cutout spotlight focus ring -->
    <div 
        class="fixed transition-all duration-300 pointer-events-auto rounded-2xl ring-4 ring-sky-400/90 shadow-[0_0_0_9999px_rgba(15,23,42,0.78),0_0_30px_rgba(56,189,248,0.5)]"
        :style="`top: ${spotlight.top}px; left: ${spotlight.left}px; width: ${spotlight.width}px; height: ${spotlight.height}px;`"
    >
        <!-- Pulsing focus halo -->
        <div class="absolute -inset-1.5 rounded-2xl border-2 border-sky-400/70 animate-pulse pointer-events-none"></div>
    </div>

    <!-- Floating Interactive Popover Tooltip Card -->
    <div 
        class="fixed transition-all duration-300 pointer-events-auto z-[102] w-[92vw] max-w-[400px] sm:max-w-[430px]"
        :style="`top: ${popover.top}px; left: ${popover.left}px;`"
    >
        <div class="bg-white/95 backdrop-blur-md rounded-3xl p-5 sm:p-6 shadow-2xl border border-sky-200/90 text-slate-800 space-y-4 relative overflow-hidden">
            
            <!-- Top Gradient Accent Bar & Progress Tracker -->
            <div class="absolute top-0 inset-x-0 h-1.5 bg-slate-100 overflow-hidden">
                <div 
                    class="h-full bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-600 transition-all duration-300"
                    :style="`width: ${((currentStep + 1) / steps.length) * 100}%`"
                ></div>
            </div>

            <!-- Header: Step Badge & Skip Button -->
            <div class="flex items-center justify-between pt-1">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 border border-sky-200/80 text-sky-700 font-heading font-extrabold text-[11px] sm:text-xs">
                        <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
                        <span x-text="`Langkah ${currentStep + 1} dari ${steps.length}`"></span>
                    </span>
                    <span class="text-[10px] font-mono text-slate-400 font-medium" x-text="steps[currentStep]?.pageLabel"></span>
                </div>

                <button 
                    type="button" 
                    @click="skipTour()"
                    class="text-slate-400 hover:text-slate-600 font-heading text-xs font-semibold px-2 py-1 rounded-lg hover:bg-slate-100 transition-colors flex items-center gap-1 cursor-pointer"
                    title="Lewati panduan interaktif"
                >
                    <span>Lewati</span>
                    <iconify-icon icon="solar:close-circle-bold" class="text-sm"></iconify-icon>
                </button>
            </div>

            <!-- Content Body: Icon, Title & Description -->
            <div class="space-y-2.5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-tr from-sky-500 to-blue-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-sky-500/25">
                        <iconify-icon :icon="steps[currentStep]?.icon || 'solar:star-bold'" class="text-xl sm:text-2xl"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-heading font-extrabold text-slate-900 tracking-tight" x-text="steps[currentStep]?.title"></h3>
                        <p class="text-[11px] font-mono font-medium text-sky-600" x-text="steps[currentStep]?.subtitle"></p>
                    </div>
                </div>

                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed" x-text="steps[currentStep]?.description"></p>
            </div>

            <!-- Footer: Progress Dots & Action Buttons -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
                
                <!-- 5 Clickable Progress Dots -->
                <div class="flex items-center gap-1.5">
                    <template x-for="(step, idx) in steps" :key="idx">
                        <button 
                            type="button" 
                            @click="goToStep(idx)"
                            class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                            :class="currentStep === idx ? 'w-6 bg-sky-600' : 'w-2 bg-slate-200 hover:bg-slate-300'"
                            :title="`Buka langkah ${idx + 1}: ${step.title}`"
                        ></button>
                    </template>
                </div>

                <!-- Next / Prev Controls -->
                <div class="flex items-center gap-2">
                    <button 
                        type="button"
                        @click="prevStep()"
                        x-show="currentStep > 0"
                        class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-bold text-xs transition-all cursor-pointer flex items-center gap-1"
                    >
                        <iconify-icon icon="solar:arrow-left-linear" class="text-sm"></iconify-icon>
                        <span>Kembali</span>
                    </button>

                    <button 
                        type="button"
                        @click="nextStep()"
                        class="px-4 py-2 rounded-xl font-heading font-extrabold text-xs shadow-md transition-all active:scale-95 cursor-pointer flex items-center gap-1.5"
                        :class="currentStep === steps.length - 1 
                            ? 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white shadow-emerald-600/20' 
                            : 'bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white shadow-sky-600/20'"
                    >
                        <span x-text="getNextButtonText()"></span>
                        <iconify-icon :icon="currentStep === steps.length - 1 ? 'solar:check-circle-bold' : 'solar:arrow-right-linear'" class="text-sm"></iconify-icon>
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
                    description: 'Pantau performa koneksi fiber optic secara real-time, salin nomor ID Pelanggan Anda dengan cepat, dan akses seluruh ringkasan layanan.'
                },
                // 2. Halaman Gangguan (Langkah 1 Gangguan)
                {
                    page: 'tickets',
                    pageLabel: 'Laporan Gangguan',
                    target: '#tour-step-create-ticket',
                    title: 'Buat Laporan Kendala',
                    subtitle: 'Pengaduan Teknis 24 Jam',
                    icon: 'solar:danger-triangle-bold',
                    description: 'Jika internet Anda lambat atau modem mengalami kendala, klik tombol ini untuk mengajukan tiket laporan langsung ke tim teknisi NOC.'
                },
                // 3. Halaman Gangguan (Langkah 2 Gangguan)
                {
                    page: 'tickets',
                    pageLabel: 'Laporan Gangguan',
                    target: '#tour-step-tickets-list',
                    title: 'Pantau Progres Penanganan',
                    subtitle: 'Transparan & Real-time',
                    icon: 'solar:ticket-sale-bold',
                    description: 'Lacak status perbaikan laporan Anda secara transparan mulai dari verifikasi, penugasan teknisi, hingga tiket dinyatakan selesai.'
                },
                // 4. Halaman Pembayaran (Langkah 1 Pembayaran)
                {
                    page: 'billing',
                    pageLabel: 'Tagihan',
                    target: '#tour-step-midtrans-pay',
                    title: 'Pembayaran Online Instan',
                    subtitle: 'QRIS & Virtual Account 24 Jam',
                    icon: 'solar:bolt-circle-bold',
                    description: 'Bayar tagihan bulanan otomatis tanpa konfirmasi manual via QRIS (GoPay, OVO, Dana) atau Virtual Account Bank (BCA, Mandiri, BRI, BNI).'
                },
                // 5. Halaman Pembayaran (Langkah 2 Pembayaran)
                {
                    page: 'billing',
                    pageLabel: 'Tagihan',
                    target: '#tour-step-transfer-tab',
                    title: 'Transfer Bank & Konfirmasi',
                    subtitle: 'Rekening Resmi PT MSN',
                    icon: 'solar:card-recive-bold',
                    description: 'Anda juga dapat mentransfer langsung ke nomor rekening resmi PT MSN dan mengunggah foto bukti struk transfer di menu ini.'
                }
            ],

            initTour() {
                this.adaptStepsForCurrentPage();

                window.startPortalTour = () => {
                    window.location.href = `${this.routes.dashboard}?tour_step=1`;
                };

                if (config.shouldActive) {
                    setTimeout(() => {
                        this.startTour();
                    }, 500);
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
                            description: 'Status tagihan periode ini telah terbayar lunas. Anda dapat mengunduh invoice digital atau menghubungi WhatsApp Billing jika memerlukan bantuan.'
                        };
                        this.steps[4] = {
                            page: 'billing',
                            pageLabel: 'Tagihan',
                            target: '#tour-step-billing-history',
                            title: 'Riwayat Tagihan & Struk',
                            subtitle: 'Arsip Transaksi Bulanan',
                            icon: 'solar:history-bold',
                            description: 'Daftar riwayat seluruh tagihan dan pembayaran periode lampau tersimpan rapi di sini. Anda dapat mencetak ulang struk resmi kapan saja.'
                        };
                    }
                }
            },

            startTour() {
                this.adaptStepsForCurrentPage();
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
                    // Navigasi antar halaman
                    const targetUrl = this.routes[targetStep.page] || this.routes.dashboard;
                    window.location.href = `${targetUrl}?tour_step=${stepIdx + 1}`;
                }
            },

            getNextButtonText() {
                if (this.currentStep === this.steps.length - 1) {
                    return 'Mulai Menggunakan Aplikasi';
                }
                if (this.currentStep === 0) {
                    return 'Lanjut ke Menu Gangguan';
                }
                if (this.currentStep === 2) {
                    return 'Lanjut ke Menu Pembayaran';
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

                setTimeout(() => {
                    const targetEl = this.findTargetElement(step.target);
                    if (targetEl) {
                        targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        setTimeout(() => {
                            this.calculatePosition(targetEl);
                        }, 250);
                    } else {
                        this.calculateFallbackPosition();
                    }
                }, 120);
            },

            calculatePosition(el) {
                const rect = el.getBoundingClientRect();
                const padding = 8;

                this.spotlight = {
                    top: Math.max(0, rect.top - padding),
                    left: Math.max(0, rect.left - padding),
                    width: rect.width + (padding * 2),
                    height: rect.height + (padding * 2)
                };

                const popoverWidth = Math.min(window.innerWidth * 0.92, 420);
                const popoverHeight = 260;
                const margin = 14;

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
                const width = Math.min(window.innerWidth * 0.92, 420);
                this.spotlight = {
                    top: window.innerHeight / 2 - 50,
                    left: window.innerWidth / 2 - 150,
                    width: 300,
                    height: 100
                };
                this.popover = {
                    top: window.innerHeight / 2 - 130,
                    left: window.innerWidth / 2 - (width / 2)
                };
            },

            updatePosition() {
                if (!this.isOpen) return;
                const step = this.steps[this.currentStep];
                if (step) {
                    const targetEl = document.querySelector(step.target);
                    if (targetEl) {
                        this.calculatePosition(targetEl);
                    }
                }
            },

            finishTour() {
                this.isOpen = false;
                this.markCompletedOnServer();

                if (window.Swal) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Selamat Datang di MyMSN!',
                        text: 'Tutorial selesai! Anda sekarang siap menggunakan seluruh fitur portal pelanggan PT Media Solusi Network.',
                        confirmButtonText: 'Mulai Jelajah',
                        confirmButtonColor: '#0284c7',
                        customClass: {
                            popup: 'rounded-3xl shadow-2xl',
                            confirmButton: 'rounded-xl font-heading font-bold'
                        }
                    }).then(() => {
                        window.location.href = this.routes.dashboard;
                    });
                } else {
                    window.location.href = this.routes.dashboard;
                }
            },

            skipTour() {
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
