@php
    $customer = auth('customer')->user();
    $customerId = $customer?->customer_id ?? 'default';
    $nomorInternet = $customer?->nomor_internet;
    $customerEmail = $customer?->email ?? '';
    $customerName = $customer?->name ?? 'Pelanggan';
    
    $currentRouteName = request()->route()?->getName() ?? '';
    $requestedStep = request()->query('tour_step');
    $isDashboardPage = ($currentRouteName === 'portal.dashboard' || request()->routeIs('portal.dashboard*') || request()->is('portal') || request()->is('portal/dashboard'));

    // Status is_login: Cek session dan model terlebih dahulu agar tidak melakukan query remote berulang setiap pindah halaman
    $isLoginVal = null;
    if (session('is_first_login') === false || (int)($customer?->is_login ?? 0) === 1) {
        $isLoginVal = 1;
    } elseif ($nomorInternet) {
        $isLoginVal = \Illuminate\Support\Facades\Cache::remember("portal_cust_is_login_{$nomorInternet}", 300, function () use ($nomorInternet, $customer) {
            $val = null;
            try {
                $val = \Illuminate\Support\Facades\DB::connection('ims')
                    ->table('trx_batchjob_register')
                    ->where('nomor_internet', $nomorInternet)
                    ->value('is_login');
            } catch (\Throwable $e) {}

            if ($val === null) {
                try {
                    $val = \Illuminate\Support\Facades\DB::connection('mysql')
                        ->table('trx_batchjob_register')
                        ->where('nomor_internet', $nomorInternet)
                        ->value('is_login');
                } catch (\Throwable $e) {}
            }

            return $val !== null ? $val : ($customer?->is_login ?? 0);
        });
    } else {
        $isLoginVal = $customer?->is_login;
    }

    // Jika is_login = 0, '0', null, empty, atau false, wajib muncul onboarding
    $isLoginDbZero = ($isLoginVal === null) || empty($isLoginVal) || (string)$isLoginVal === '0' || (int)$isLoginVal === 0;

    $initialStepIdx = 0;
    if ($requestedStep !== null && is_numeric($requestedStep)) {
        $initialStepIdx = max(0, min(5, ((int)$requestedStep) - 1));
    }
@endphp

@if($isLoginDbZero || $requestedStep !== null)
<!-- Preload completion image so it appears instantly without delay -->
<img src="{{ asset('images/logo/berhasil1.png') }}" alt="" class="hidden" style="display:none;" />

<script>
    window.__portalOnboardingConfig = {
        customerId: {!! json_encode((string)$customerId) !!},
        customerEmail: {!! json_encode((string)$customerEmail) !!},
        customerName: {!! json_encode((string)$customerName) !!},
        isLoginZero: {!! $isLoginDbZero ? 'true' : 'false' !!},
        isDashboard: {!! $isDashboardPage ? 'true' : 'false' !!},
        hasExplicitStep: {!! $requestedStep !== null ? 'true' : 'false' !!},
        initialStep: {{ (int)$initialStepIdx }},
        routes: {
            dashboard: {!! json_encode(url('/portal')) !!},
            tickets: {!! json_encode(route('portal.tickets.index')) !!},
            billing: {!! json_encode(route('portal.billing.index')) !!},
            complete: {!! json_encode(route('portal.onboarding.complete')) !!},
            updateEmail: {!! json_encode(route('portal.profile.update-email')) !!}
        }
    };
</script>

<!-- Interactive Product Tour & Email Verification Component -->
<div 
    x-data="portalOnboardingTour(window.__portalOnboardingConfig)"
    x-init="initTour()"
    x-cloak
>
    <!-- 1. FLOATING SPOTLIGHT TOUR CONTAINER -->
    <div 
        x-show="isOpen"
        class="fixed inset-0 z-[99990] overflow-hidden select-none pointer-events-auto transition-opacity duration-300 touch-none"
        :class="isOpen ? 'opacity-100' : 'opacity-0'"
        style="display: none;"
        @wheel.prevent.stop
        @touchmove.prevent.stop
        @scroll.prevent.stop
        @keydown.escape.window="skipTour()"
        @resize.window="updatePosition()"
    >
        <!-- Darkened Backdrop with cutout spotlight focus ring (Single Crisp Ring) -->
        <div 
            class="fixed transition-all duration-200 pointer-events-auto rounded-2xl ring-2 ring-sky-400 shadow-[0_0_0_9999px_rgba(15,23,42,0.80)]"
            :style="`top: ${spotlight.top}px; left: ${spotlight.left}px; width: ${spotlight.width}px; height: ${spotlight.height}px;`"
        ></div>

        <!-- Floating Interactive Popover Tooltip Card -->
        <div 
            class="fixed transition-all duration-200 pointer-events-auto z-[99995] w-[88vw] max-w-[320px] sm:max-w-[420px]"
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

    <!-- 2. EMAIL VERIFICATION & ACTIVE CHECK MODAL (MUNCUL SEBELUM TUTORIAL) -->
    <div 
        x-show="showEmailModal"
        x-cloak
        style="display: none;" 
        class="fixed inset-0 z-[100000] flex items-center justify-center p-3.5 sm:p-4 overflow-y-auto bg-slate-950/75 backdrop-blur-xs"
        x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
    >
        <div 
            class="relative w-full max-w-[360px] sm:max-w-[420px] bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-sky-100/80 text-slate-800 p-4 sm:p-6 space-y-3.5"
            @click.away="!isSavingEmail"
        >
            <!-- Header Ringkas & Modern -->
            <div class="text-center space-y-2">
                <div class="mx-auto w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-tr from-sky-500 to-blue-600 text-white flex items-center justify-center shadow-md shadow-sky-500/20 ring-4 ring-sky-50">
                    <iconify-icon icon="solar:letter-unread-bold-duotone" class="text-2xl sm:text-3xl"></iconify-icon>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-heading font-extrabold text-slate-900 tracking-tight leading-tight">
                        Email Notifikasi Pelanggan
                    </h3>
                    <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5 leading-relaxed">
                        Digunakan untuk mengirim invoice tagihan, bukti lunas, dan info gangguan.
                    </p>
                </div>
            </div>

            <!-- Manfaat Mini Chips (1 Baris Rapi) -->
            <div class="flex items-center justify-center gap-1.5 text-[10px] sm:text-[11px] font-medium text-slate-600 bg-slate-50 border border-slate-100/90 py-1.5 px-2 rounded-xl">
                <span class="inline-flex items-center gap-1"><iconify-icon icon="solar:document-text-bold" class="text-sky-600"></iconify-icon> Invoice</span>
                <span class="text-slate-300">•</span>
                <span class="inline-flex items-center gap-1"><iconify-icon icon="solar:bill-check-bold" class="text-emerald-600"></iconify-icon> Bukti Lunas</span>
                <span class="text-slate-300">•</span>
                <span class="inline-flex items-center gap-1"><iconify-icon icon="solar:danger-triangle-bold" class="text-amber-500"></iconify-icon> Gangguan</span>
            </div>

            <!-- STATE 1: Pelanggan Sudah Memiliki Email & Tidak Sedang Mode Edit -->
            <template x-if="customerEmail && customerEmail.trim() !== '' && !isEditingEmail">
                <div class="space-y-3 pt-0.5">
                    <!-- Email Box -->
                    <div class="p-2.5 sm:p-3 rounded-xl bg-sky-50/60 border border-sky-200/80 flex items-center justify-between gap-2.5">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-white shadow-2xs text-sky-600 flex items-center justify-center shrink-0 border border-sky-100">
                                <iconify-icon icon="solar:mailbox-bold" class="text-base"></iconify-icon>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[9px] font-mono text-sky-700 font-semibold uppercase tracking-wider">Email Terdaftar</div>
                                <div class="text-xs sm:text-sm font-heading font-extrabold text-slate-900 truncate" x-text="customerEmail"></div>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-heading font-bold shrink-0">
                            Aktif
                        </span>
                    </div>

                    <p class="text-[11px] sm:text-xs text-center text-slate-600">
                        Apakah email di atas masih aktif & digunakan?
                    </p>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center gap-2 pt-0.5">
                        <button 
                            type="button" 
                            @click="confirmEmailAndStartTour()"
                            class="flex-1 py-2.5 px-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-heading font-extrabold text-xs shadow-sm shadow-emerald-600/20 transition-all active:scale-95 flex items-center justify-center gap-1.5 cursor-pointer"
                        >
                            <iconify-icon icon="solar:check-circle-bold" class="text-sm"></iconify-icon>
                            <span>Ya, Sudah Benar</span>
                        </button>

                        <button 
                            type="button" 
                            @click="isEditingEmail = true; inputEmail = customerEmail; emailError = '';"
                            class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-bold text-xs transition-all flex items-center justify-center gap-1 cursor-pointer shrink-0"
                        >
                            <iconify-icon icon="solar:pen-new-square-bold" class="text-sm"></iconify-icon>
                            <span>Ubah</span>
                        </button>
                    </div>
                </div>
            </template>

            <!-- STATE 2: Belum Ada Email ATAU Pelanggan Ingin Mengubah Email -->
            <template x-if="!customerEmail || customerEmail.trim() === '' || isEditingEmail">
                <div class="space-y-3 pt-0.5">
                    <div class="space-y-1 text-left">
                        <label class="block text-[11px] sm:text-xs font-heading font-bold text-slate-700">
                            Masukkan Alamat Email Aktif <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <iconify-icon icon="solar:letter-bold" class="text-base"></iconify-icon>
                            </span>
                            <input 
                                type="email" 
                                x-model="inputEmail"
                                @keydown.enter="saveEmailAndStartTour()"
                                placeholder="nama@gmail.com"
                                class="w-full pl-9 pr-3 py-2 sm:py-2.5 rounded-xl border text-xs font-sans transition-all focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 placeholder:text-slate-400"
                                :class="emailError ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200 bg-white'"
                            />
                        </div>
                        <template x-if="emailError">
                            <p class="text-[10px] text-rose-600 font-medium flex items-center gap-1 mt-0.5">
                                <iconify-icon icon="solar:danger-circle-bold"></iconify-icon>
                                <span x-text="emailError"></span>
                            </p>
                        </template>
                    </div>

                    <!-- Tombol Aksi Form -->
                    <div class="flex items-center gap-2 pt-0.5">
                        <button 
                            type="button" 
                            @click="saveEmailAndStartTour()"
                            :disabled="isSavingEmail"
                            class="flex-1 py-2.5 px-3 rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 disabled:opacity-50 text-white font-heading font-extrabold text-xs shadow-sm shadow-sky-600/20 transition-all active:scale-95 flex items-center justify-center gap-1.5 cursor-pointer"
                        >
                            <iconify-icon x-show="!isSavingEmail" icon="solar:diskette-bold" class="text-sm"></iconify-icon>
                            <iconify-icon x-show="isSavingEmail" icon="line-md:loading-loop" class="text-sm animate-spin"></iconify-icon>
                            <span x-text="isSavingEmail ? 'Menyimpan...' : 'Simpan & Lanjut Panduan'"></span>
                        </button>

                        <button 
                            type="button" 
                            x-show="customerEmail && customerEmail.trim() !== ''"
                            @click="isEditingEmail = false; emailError = '';"
                            class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-bold text-xs transition-all flex items-center justify-center cursor-pointer shrink-0"
                        >
                            <span>Batal</span>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
    function portalOnboardingTour(config) {
        config = config || window.__portalOnboardingConfig || {};
        return {
            isOpen: false,
            showEmailModal: false,
            isLoginZero: !!config.isLoginZero,
            isDashboard: !!config.isDashboard,
            hasExplicitStep: !!config.hasExplicitStep,
            customerEmail: (config.customerEmail || '').trim(),
            customerName: config.customerName || 'Pelanggan',
            inputEmail: (config.customerEmail || '').trim(),
            isEditingEmail: !(config.customerEmail && config.customerEmail.trim().length > 0),
            isSavingEmail: false,
            emailError: '',
            currentStep: config.initialStep || 0,
            spotlight: { top: 0, left: 0, width: 0, height: 0 },
            popover: { top: 0, left: 0 },
            routes: config.routes || {},
            
            // 6 Langkah Terpadu untuk Seluruh Aplikasi Portal
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
                    target: '#tour-step-invoice-header',
                    title: 'Status & Periode Tagihan',
                    subtitle: 'Informasi Invoice Aktif',
                    icon: 'solar:document-text-bold',
                    description: 'Cek nomor invoice, periode bulan berjalan, dan status pelunasan internet Anda di bagian ini.'
                },
                // 5. Halaman Pembayaran (Langkah 2 Pembayaran)
                {
                    page: 'billing',
                    pageLabel: 'Tagihan',
                    target: '#tour-step-billing-detail',
                    title: 'Rincian Biaya & Paket',
                    subtitle: 'Paket Layanan & Jatuh Tempo',
                    icon: 'solar:wallet-money-bold',
                    description: 'Informasi paket broadband, tanggal jatuh tempo pembayaran, dan rincian total tagihan bulanan.'
                },
                // 6. Halaman Pembayaran (Langkah 3 Pembayaran: Cara Bayar)
                {
                    page: 'billing',
                    pageLabel: 'Tagihan',
                    target: '#tour-step-payment-methods, #tour-step-midtrans-pay, #tour-step-billing-status',
                    title: 'Pilihan Cara Pembayaran',
                    subtitle: 'Otomatis (Midtrans) & Transfer Bank',
                    icon: 'solar:card-recive-bold',
                    description: 'Pilih metode pembayaran instan 24 jam via QRIS / VA Bank (Midtrans) atau Transfer Rekening Resmi PT MSN dengan konfirmasi bukti transfer.'
                }
            ],

            customerId: config.customerId || 'default',

            initTour() {
                this.adaptStepsForCurrentPage();

                // Expose global helper jika ingin dipanggil manual
                window.startPortalTour = () => {
                    this.lockScroll();
                    this.showEmailModal = true;
                };

                const hasExplicitStep = config.hasExplicitStep;

                // 1. Jika sedang dalam navigasi langkah tour antar halaman (ada query ?tour_step=...)
                if (hasExplicitStep) {
                    this.showEmailModal = false;
                    this.startTour();
                    return;
                }

                // 2. Jika is_login di database masih bernilai 0 (login perdana/belum selesai onboarding)
                if (this.isLoginZero && this.isDashboard) {
                    this.lockScroll();
                    this.$nextTick(() => {
                        this.showEmailModal = true;
                    });
                }
            },

            confirmEmailAndStartTour() {
                this.showEmailModal = false;
                // Tandai is_login = 1 di database agar tidak berulang
                this.markCompletedOnServer();
                this.$nextTick(() => {
                    this.startTour();
                });
            },

            async saveEmailAndStartTour() {
                const emailToSave = (this.inputEmail || '').trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailToSave) {
                    this.emailError = 'Mohon masukkan alamat email Anda.';
                    return;
                }

                if (!emailRegex.test(emailToSave)) {
                    this.emailError = 'Format email tidak valid (contoh: nama@gmail.com).';
                    return;
                }

                this.isSavingEmail = true;
                this.emailError = '';

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const response = await fetch(this.routes.updateEmail, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken || '',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ email: emailToSave })
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        this.customerEmail = data.email || emailToSave;
                        this.showEmailModal = false;
                        // Tandai is_login = 1 di database
                        this.markCompletedOnServer();
                        this.$nextTick(() => {
                            this.startTour();
                        });
                    } else {
                        this.emailError = data.message || 'Terjadi kesalahan saat menyimpan email.';
                    }
                } catch (err) {
                    this.emailError = 'Koneksi gagal saat menyimpan email. Silakan coba lagi.';
                } finally {
                    this.isSavingEmail = false;
                }
            },

            skipEmailAndStartTour() {
                this.showEmailModal = false;
                this.$nextTick(() => {
                    this.startTour();
                });
            },

            adaptStepsForCurrentPage() {
                const currentPage = this.getCurrentPageName();
                if (currentPage === 'billing') {
                    this.steps[3] = {
                        page: 'billing',
                        pageLabel: 'Tagihan',
                        target: '#tour-step-invoice-header',
                        title: 'Status & Periode Tagihan',
                        subtitle: 'Informasi Invoice Aktif',
                        icon: 'solar:document-text-bold',
                        description: 'Cek nomor invoice, periode bulan berjalan, dan status pelunasan internet Anda di bagian ini.'
                    };
                    this.steps[4] = {
                        page: 'billing',
                        pageLabel: 'Tagihan',
                        target: '#tour-step-billing-detail',
                        title: 'Rincian Biaya & Paket',
                        subtitle: 'Paket Layanan & Jatuh Tempo',
                        icon: 'solar:wallet-money-bold',
                        description: 'Informasi paket broadband, tanggal jatuh tempo pembayaran, dan rincian total tagihan bulanan.'
                    };
                    this.steps[5] = {
                        page: 'billing',
                        pageLabel: 'Tagihan',
                        target: '#tour-step-payment-methods, #tour-step-midtrans-pay, #tour-step-billing-status',
                        title: 'Pilihan Cara Pembayaran',
                        subtitle: 'Otomatis (Midtrans) & Transfer Bank',
                        icon: 'solar:card-recive-bold',
                        description: 'Pilih metode pembayaran instan 24 jam via QRIS / VA Bank (Midtrans) atau Transfer Rekening Resmi PT MSN dengan konfirmasi bukti transfer.'
                    };
                }
            },

            lockScroll() {
                document.body.style.overscrollBehavior = 'none';

                if (!this._preventScroll) {
                    this._preventScroll = (e) => {
                        if (this.isOpen || this.showEmailModal) {
                            const modalContent = e.target.closest('.overflow-y-auto');
                            if (modalContent && modalContent.scrollHeight > modalContent.clientHeight) {
                                return; // Izinkan scrolling di dalam modal jika konten panjang
                            }
                            e.preventDefault();
                        }
                    };
                    window.addEventListener('wheel', this._preventScroll, { passive: false });
                    window.addEventListener('touchmove', this._preventScroll, { passive: false });
                }

                if (!this._keyHandler) {
                    this._keyHandler = (e) => {
                        if (this.isOpen && e.code === 'Escape') {
                            this.skipTour();
                            return;
                        }
                        if ((this.isOpen || this.showEmailModal) && ['Space', 'PageUp', 'PageDown', 'End', 'Home', 'ArrowUp', 'ArrowDown'].includes(e.code)) {
                            const isInput = e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA';
                            if (!isInput) {
                                e.preventDefault();
                            }
                        }
                    };
                    window.addEventListener('keydown', this._keyHandler, { passive: false });
                }
            },

            unlockScroll() {
                document.body.style.overscrollBehavior = '';
                if (this._preventScroll) {
                    window.removeEventListener('wheel', this._preventScroll);
                    window.removeEventListener('touchmove', this._preventScroll);
                    this._preventScroll = null;
                }
                if (this._keyHandler) {
                    window.removeEventListener('keydown', this._keyHandler);
                    this._keyHandler = null;
                }
            },

            scrollToElement(el, callback) {
                if (!el) {
                    if (callback) callback();
                    return;
                }
                const rect = el.getBoundingClientRect();
                const absoluteTop = rect.top + window.pageYOffset;
                const isMobile = window.innerWidth < 640;
                
                const headerOffset = isMobile ? 72 : 90;
                const targetScrollY = Math.max(0, Math.round(absoluteTop - headerOffset));

                window.scrollTo({
                    top: targetScrollY,
                    behavior: 'smooth'
                });

                let frame = 0;
                const tracker = setInterval(() => {
                    this.calculatePosition(el);
                    frame++;
                    if (frame > 7) {
                        clearInterval(tracker);
                        if (callback) callback();
                    }
                }, 50);
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

                if (step.page === 'billing') {
                    const isPaid = document.querySelector('#tour-step-billing-status') !== null;
                    if (!isPaid) {
                        if (stepIdx === 3 || stepIdx === 5) {
                            const midtransBtn = document.querySelector("button[\\@click*=\"paymentTab = 'midtrans'\"]");
                            if (midtransBtn) midtransBtn.click();
                        }
                    }
                }

                this.$nextTick(() => {
                    const targetEl = this.findTargetElement(step.target);
                    if (targetEl) {
                        this.scrollToElement(targetEl, () => {
                            this.calculatePosition(targetEl);
                        });
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
                const popoverHeight = window.innerWidth < 640 ? 175 : 230;
                const margin = window.innerWidth < 640 ? 10 : 16;
                const topSafeMargin = window.innerWidth < 640 ? 64 : 78;
                const bottomSafeMargin = window.innerWidth < 640 ? 80 : 20;

                const spaceBelow = window.innerHeight - (this.spotlight.top + this.spotlight.height);
                const spaceAbove = this.spotlight.top - topSafeMargin;
                const spaceRight = window.innerWidth - (this.spotlight.left + this.spotlight.width);
                const spaceLeft = this.spotlight.left;

                let popLeft = this.spotlight.left + (this.spotlight.width / 2) - (popoverWidth / 2);
                let popTop = this.spotlight.top + this.spotlight.height + margin;

                if (window.innerWidth >= 1024 && spaceRight >= popoverWidth + margin && this.spotlight.top < (popoverHeight + topSafeMargin)) {
                    popLeft = this.spotlight.left + this.spotlight.width + margin;
                    popTop = Math.max(topSafeMargin, this.spotlight.top);
                } else if (spaceBelow >= popoverHeight + bottomSafeMargin) {
                    popTop = this.spotlight.top + this.spotlight.height + margin;
                } else if (spaceAbove >= popoverHeight) {
                    popTop = this.spotlight.top - popoverHeight - margin;
                } else if (window.innerWidth >= 768 && spaceRight >= popoverWidth + margin) {
                    popLeft = this.spotlight.left + this.spotlight.width + margin;
                    popTop = Math.max(topSafeMargin, this.spotlight.top);
                } else if (window.innerWidth >= 768 && spaceLeft >= popoverWidth + margin) {
                    popLeft = this.spotlight.left - popoverWidth - margin;
                    popTop = Math.max(topSafeMargin, this.spotlight.top);
                } else {
                    popTop = (spaceBelow > spaceAbove) 
                        ? this.spotlight.top + this.spotlight.height + margin 
                        : this.spotlight.top - popoverHeight - margin;
                }

                popTop = Math.max(topSafeMargin, Math.min(popTop, window.innerHeight - popoverHeight - bottomSafeMargin));
                popLeft = Math.max(margin, Math.min(popLeft, window.innerWidth - popoverWidth - margin));

                this.popover = {
                    top: Math.round(popTop),
                    left: Math.round(popLeft)
                };
            },

            calculateFallbackPosition() {
                const popoverWidth = Math.min(window.innerWidth * 0.88, window.innerWidth < 640 ? 320 : 420);
                const popoverHeight = window.innerWidth < 640 ? 175 : 230;
                const topSafeMargin = window.innerWidth < 640 ? 64 : 78;
                this.spotlight = {
                    top: Math.round(window.innerHeight / 2 - 40),
                    left: Math.round(window.innerWidth / 2 - 130),
                    width: 260,
                    height: 80
                };
                this.popover = {
                    top: Math.max(topSafeMargin, Math.round(window.innerHeight / 2 - (popoverHeight / 2))),
                    left: Math.round(window.innerWidth / 2 - (popoverWidth / 2))
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
                
                // Onboarding selesai tuntas, tandai is_login = 1 di database
                this.markCompletedOnServer();

                this.showCompletionAlert('Selamat Datang!', 'Panduan selesai. Selamat menggunakan portal layanan MyMSN!');
            },

            skipTour() {
                this.unlockScroll();
                this.isOpen = false;
                
                // Pelanggan melewati tour, tandai is_login = 1 di database
                this.markCompletedOnServer();
            },

            showCompletionAlert(title, message) {
                if (window.Swal) {
                    Swal.fire({
                        imageUrl: '{{ asset('images/logo/berhasil1.png') }}',
                        imageWidth: 220,
                        imageHeight: 220,
                        imageAlt: 'Selamat Datang',
                        title: title || 'Selamat Datang!',
                        html: `<p class="text-xs sm:text-sm text-slate-500 font-sans mt-1.5">${message || 'Panduan selesai. Selamat menggunakan portal layanan MyMSN!'}</p>`,
                        showConfirmButton: false,
                        timer: 2600,
                        customClass: {
                            popup: '!rounded-3xl !shadow-2xl !border !border-sky-100 !max-w-[360px] sm:!max-w-[420px] !p-6 sm:!p-8 text-center',
                            image: '!w-48 !h-48 sm:!w-56 sm:!h-56 !object-contain !mx-auto !my-0 !mb-3',
                            title: '!font-heading !font-extrabold !text-xl sm:!text-2xl !text-slate-800 !tracking-tight !p-0 !m-0',
                            htmlContainer: '!m-0 !p-0 !mt-1'
                        }
                    }).then(() => {
                        window.location.href = this.routes.dashboard;
                    });
                } else {
                    window.location.href = this.routes.dashboard;
                }
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
        };
    }

    window.portalOnboardingTour = portalOnboardingTour;

    document.addEventListener('alpine:init', () => {
        if (window.Alpine) {
            Alpine.data('portalOnboardingTour', (config) => portalOnboardingTour(config));
        }
    });
</script>
@endif
