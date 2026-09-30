@php
    $isFirstLogin = (int)(auth('customer')->user()->is_login ?? 0) === 0;
    $shouldAutoStart = $isFirstLogin || request()->has('tour');
@endphp

<!-- Interactive Product Tour / Onboarding Component -->
<div 
    x-data="portalOnboardingTour({{ $shouldAutoStart ? 'true' : 'false' }})"
    x-init="initTour()"
    x-show="isOpen"
    x-cloak
    class="fixed inset-0 z-[100] overflow-hidden pointer-events-none transition-opacity duration-300"
    :class="isOpen ? 'opacity-100' : 'opacity-0'"
    style="display: none;"
    @keydown.escape.window="skipTour()"
    @keydown.right.window="nextStep()"
    @keydown.left.window="prevStep()"
    @resize.window="updatePosition()"
    @scroll.window="updatePosition()"
>
    <!-- Darkened Backdrop with cutout mask via massive box-shadow -->
    <div 
        class="fixed transition-all duration-300 pointer-events-auto rounded-2xl ring-4 ring-sky-400/90 shadow-[0_0_0_9999px_rgba(15,23,42,0.78),0_0_30px_rgba(56,189,248,0.45)]"
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
                
                <!-- Progress Dots (Clickable) -->
                <div class="flex items-center gap-1.5">
                    <template x-for="(step, idx) in steps" :key="idx">
                        <button 
                            type="button" 
                            @click="goToStep(idx)"
                            class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                            :class="currentStep === idx ? 'w-6 bg-sky-600' : 'w-2 bg-slate-200 hover:bg-slate-300'"
                            :title="`Buka langkah ${idx + 1}`"
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
                        <span x-text="currentStep === steps.length - 1 ? 'Mulai Menggunakan Aplikasi' : 'Lanjut'"></span>
                        <iconify-icon :icon="currentStep === steps.length - 1 ? 'solar:check-circle-bold' : 'solar:arrow-right-linear'" class="text-sm"></iconify-icon>
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('portalOnboardingTour', (autoStart = false) => ({
            isOpen: false,
            currentStep: 0,
            spotlight: { top: 0, left: 0, width: 0, height: 0 },
            popover: { top: 0, left: 0 },
            steps: [
                {
                    target: '#tour-step-hero',
                    title: 'Profil & Status Koneksi',
                    subtitle: 'Akun & Status Internet Real-time',
                    icon: 'solar:shield-check-bold',
                    description: 'Pantau status aktif koneksi fiber optic Anda secara langsung. Anda dapat menyalin ID Pelanggan hanya dengan satu klik untuk keperluan bantuan.'
                },
                {
                    target: '#tour-step-package',
                    title: 'Paket & Kecepatan Bandwidth',
                    subtitle: 'Internet Unlimited Tanpa FUP',
                    icon: 'solar:bolt-circle-bold',
                    description: 'Lihat rincian paket broadband yang sedang Anda gunakan. Seluruh koneksi PT MSN berkecepatan tinggi tanpa batasan kuota (True Unlimited).'
                },
                {
                    target: '#tour-step-billing',
                    title: 'Tagihan & Pembayaran Instan',
                    subtitle: 'QRIS, Virtual Account & Transfer',
                    icon: 'solar:wallet-money-bold',
                    description: 'Pantau tanggal jatuh tempo invoice bulanan. Anda dapat membayar langsung via Midtrans (QRIS, VA BCA/Mandiri/BRI/BNI) atau upload bukti transfer bank.'
                },
                {
                    target: '#tour-step-tickets',
                    title: 'Lapor Kendala & Tiket NOC',
                    subtitle: 'Layanan Pengaduan 24 Jam',
                    icon: 'solar:ticket-sale-bold',
                    description: 'Mengalami gangguan teknis? Buat laporan tiket langsung ke tim NOC. Anda dapat melacak progres penanganan dan nama teknisi yang bertugas secara transparan.'
                },
                {
                    target: '#tour-step-help',
                    title: 'Diagnostik & Bantuan Cepat',
                    subtitle: 'Speedtest & WhatsApp Siaga',
                    icon: 'solar:headphones-round-sound-bold',
                    description: 'Gunakan fitur Fast.com Speedtest, panduan troubleshooting modem, atau hubungi Helpdesk & Billing kami kapan saja via WhatsApp resmi.'
                }
            ],

            initTour() {
                window.startPortalTour = () => this.startTour();

                if (autoStart) {
                    // Delay sejenak agar preloader selesai dan elemen halaman ter-render sempurna
                    setTimeout(() => {
                        this.startTour();
                    }, 800);
                }
            },

            startTour() {
                this.currentStep = 0;
                this.isOpen = true;
                this.$nextTick(() => {
                    this.showStep(0);
                });
            },

            goToStep(stepIdx) {
                if (stepIdx >= 0 && stepIdx < this.steps.length) {
                    this.showStep(stepIdx);
                }
            },

            nextStep() {
                if (this.currentStep < this.steps.length - 1) {
                    this.showStep(this.currentStep + 1);
                } else {
                    this.finishTour();
                }
            },

            prevStep() {
                if (this.currentStep > 0) {
                    this.showStep(this.currentStep - 1);
                }
            },

            showStep(stepIdx) {
                this.currentStep = stepIdx;
                const step = this.steps[stepIdx];
                if (!step) return;

                const targetEl = document.querySelector(step.target);
                if (targetEl) {
                    targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    // Berikan sedikit waktu untuk smooth scrolling selesai sebelum menghitung bounding box
                    setTimeout(() => {
                        this.calculatePosition(targetEl);
                    }, 250);
                } else {
                    // Jika elemen target di halaman ini tidak ditemukan, fallback ke posisi tengah
                    this.calculateFallbackPosition();
                }
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
                const popoverHeight = 260; // estimasi tinggi popover
                const margin = 14;

                // Hitung posisi horizontal (center terhadap spotlight, atau dijaga agar tidak offscreen)
                let popLeft = this.spotlight.left + (this.spotlight.width / 2) - (popoverWidth / 2);
                popLeft = Math.max(margin, Math.min(popLeft, window.innerWidth - popoverWidth - margin));

                // Hitung posisi vertikal (prioritaskan di bawah target, jika tidak cukup ruang letakkan di atas)
                let popTop = this.spotlight.top + this.spotlight.height + margin;
                if (popTop + popoverHeight > window.innerHeight && this.spotlight.top > popoverHeight + margin) {
                    popTop = this.spotlight.top - popoverHeight - margin;
                }

                // Proteksi batas layar atas/bawah
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
                        text: 'Anda sekarang siap menggunakan seluruh layanan portal pelanggan PT Media Solusi Network.',
                        confirmButtonText: 'Mulai Jelajah',
                        confirmButtonColor: '#0284c7',
                        customClass: {
                            popup: 'rounded-3xl shadow-2xl',
                            confirmButton: 'rounded-xl font-heading font-bold'
                        }
                    });
                }
            },

            skipTour() {
                this.isOpen = false;
                this.markCompletedOnServer();
            },

            markCompletedOnServer() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                fetch('{{ route("portal.onboarding.complete") }}', {
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
