@php
    $customer = auth('customer')->user();
    $customerId = $customer?->customer_id ?? 'default';
    $customerEmail = $customer?->email ?? '';
    $customerName = $customer?->name ?? 'Pelanggan';
    $isFirstLogin = session('is_first_login', false);
    
    // Segera hapus is_first_login dari session setelah dibaca agar navigasi berikutnya tidak mengulang tour
    if ($isFirstLogin) {
        session()->forget('is_first_login');
        session(['is_first_login' => false]);
    }

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

<!-- Preload completion image so it appears instantly without delay -->
<img src="{{ asset('images/logo/berhasil1.png') }}" alt="" class="hidden" style="display:none;" />

<!-- Interactive Product Tour & Email Verification Component -->
<div 
    x-data="portalOnboardingTour({
        customerId: '{{ $customerId }}',
        customerEmail: '{{ addslashes($customerEmail) }}',
        customerName: '{{ addslashes($customerName) }}',
        isFirstLogin: {{ $isFirstLogin ? 'true' : 'false' }},
        shouldActive: {{ $shouldActive ? 'true' : 'false' }},
        initialStep: {{ $initialStepIdx }},
        routes: {
            dashboard: '{{ url('/portal') }}',
            tickets: '{{ route('portal.tickets.index') }}',
            billing: '{{ route('portal.billing.index') }}',
            complete: '{{ route('portal.onboarding.complete') }}',
            updateEmail: '{{ route('portal.profile.update-email') }}'
        }
    })"
    x-init="initTour()"
    x-cloak
>
    <!-- 1. FLOATING SPOTLIGHT TOUR CONTAINER -->
    <div 
        x-show="isOpen"
        class="fixed inset-0 z-[100] overflow-hidden pointer-events-none transition-opacity duration-300"
        :class="isOpen ? 'opacity-100' : 'opacity-0'"
        style="display: none;"
        @keydown.escape.window="skipTour()"
        @resize.window="updatePosition()"
        @scroll.window.passive="updatePosition()"
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

    <!-- 2. EMAIL VERIFICATION & ACTIVE CHECK MODAL -->
    <div 
        x-show="showEmailModal" 
        class="fixed inset-0 z-[150] flex items-center justify-center p-4 sm:p-6 overflow-y-auto bg-slate-950/70 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        style="display: none;"
    >
        <div 
            class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-sky-100 overflow-hidden text-slate-800 p-6 sm:p-8"
            @click.away="!isSavingEmail"
        >
            <!-- Decorative Background Accent -->
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-sky-400/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Top Header Icon & Badges -->
            <div class="text-center space-y-3 relative">
                <div class="mx-auto w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-tr from-sky-500 via-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-sky-500/25 ring-4 ring-sky-50">
                    <iconify-icon icon="solar:letter-unread-bold-duotone" class="text-3xl sm:text-4xl"></iconify-icon>
                </div>

                <div class="space-y-1">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 border border-sky-200/80 text-sky-700 font-heading font-bold text-xs">
                        <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
                        Konfirmasi Email Notifikasi
                    </span>
                    <h3 class="text-lg sm:text-xl font-heading font-extrabold text-slate-900 tracking-tight">
                        Pengecekan Email Pelanggan
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-sm mx-auto leading-relaxed">
                        Pastikan email Anda aktif untuk menerima invoice tagihan, bukti lunas, dan pemberitahuan penting.
                    </p>
                </div>
            </div>

            <!-- Manfaat Email Aktif Info Card -->
            <div class="my-5 p-3.5 sm:p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                <div class="text-[11px] font-heading font-bold text-slate-400 uppercase tracking-wider">
                    Guna Email Aktif Bagi Pelanggan:
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-[11px] sm:text-xs text-slate-600">
                    <div class="flex items-center gap-1.5 bg-white p-2 rounded-xl border border-slate-100">
                        <iconify-icon icon="solar:document-text-bold" class="text-sky-600 text-sm shrink-0"></iconify-icon>
                        <span class="font-medium truncate">Invoice Tagihan</span>
                    </div>
                    <div class="flex items-center gap-1.5 bg-white p-2 rounded-xl border border-slate-100">
                        <iconify-icon icon="solar:bill-check-bold" class="text-emerald-600 text-sm shrink-0"></iconify-icon>
                        <span class="font-medium truncate">Bukti Bayar Lunas</span>
                    </div>
                    <div class="flex items-center gap-1.5 bg-white p-2 rounded-xl border border-slate-100">
                        <iconify-icon icon="solar:danger-triangle-bold" class="text-amber-500 text-sm shrink-0"></iconify-icon>
                        <span class="font-medium truncate">Info Gangguan</span>
                    </div>
                </div>
            </div>

            <!-- STATE 1: Pelanggan Sudah Memiliki Email & Tidak Sedang Mode Edit -->
            <template x-if="customerEmail && customerEmail.trim() !== '' && !isEditingEmail">
                <div class="space-y-4">
                    <div class="p-4 rounded-2xl bg-gradient-to-r from-sky-50/70 to-blue-50/70 border border-sky-200/80 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="w-10 h-10 rounded-xl bg-white shadow-xs border border-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                                <iconify-icon icon="solar:mailbox-bold" class="text-xl"></iconify-icon>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[10px] font-mono text-sky-700 font-semibold uppercase tracking-wider">Email Terdaftar Saat Ini</div>
                                <div class="text-sm sm:text-base font-heading font-extrabold text-slate-900 truncate" x-text="customerEmail"></div>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-heading font-bold shrink-0">
                            <iconify-icon icon="solar:check-circle-bold" class="text-xs"></iconify-icon>
                            Tersedia
                        </span>
                    </div>

                    <p class="text-xs text-center text-slate-600">
                        Apakah alamat email di atas <strong>masih aktif</strong> dan dapat menerima pesan dari MyMSN?
                    </p>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 pt-1">
                        <button 
                            type="button" 
                            @click="confirmEmailActive()"
                            class="flex-1 px-4 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-heading font-extrabold text-xs sm:text-sm shadow-md shadow-emerald-600/20 transition-all active:scale-95 flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <iconify-icon icon="solar:check-circle-bold" class="text-base"></iconify-icon>
                            <span>Ya, Email Saya Aktif</span>
                        </button>

                        <button 
                            type="button" 
                            @click="isEditingEmail = true; inputEmail = customerEmail; emailError = '';"
                            class="px-4 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                        >
                            <iconify-icon icon="solar:pen-new-square-bold" class="text-base"></iconify-icon>
                            <span>Ubah Email</span>
                        </button>
                    </div>
                </div>
            </template>

            <!-- STATE 2: Belum Ada Email ATAU Pelanggan Ingin Mengubah Email -->
            <template x-if="!customerEmail || customerEmail.trim() === '' || isEditingEmail">
                <div class="space-y-4">
                    <div x-show="!customerEmail || customerEmail.trim() === ''" class="p-3 rounded-xl bg-amber-50 border border-amber-200/80 text-amber-800 flex items-start gap-2 text-xs">
                        <iconify-icon icon="solar:info-circle-bold" class="text-base text-amber-600 shrink-0 mt-0.5"></iconify-icon>
                        <span>Anda belum mendaftarkan email aktif. Silakan masukkan alamat email yang sering Anda buka.</span>
                    </div>

                    <div class="space-y-1.5 text-left">
                        <label class="block text-xs font-heading font-extrabold text-slate-700">
                            Masukkan Alamat Email Aktif <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <iconify-icon icon="solar:letter-bold" class="text-lg"></iconify-icon>
                            </span>
                            <input 
                                type="email" 
                                x-model="inputEmail"
                                @keydown.enter="saveNewEmail()"
                                placeholder="contoh: nama.anda@gmail.com"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border text-xs sm:text-sm font-sans transition-all focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 placeholder:text-slate-400"
                                :class="emailError ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200 bg-white'"
                            />
                        </div>
                        <template x-if="emailError">
                            <p class="text-[11px] text-rose-600 font-medium flex items-center gap-1 mt-1">
                                <iconify-icon icon="solar:danger-circle-bold"></iconify-icon>
                                <span x-text="emailError"></span>
                            </p>
                        </template>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 pt-1">
                        <button 
                            type="button" 
                            @click="saveNewEmail()"
                            :disabled="isSavingEmail"
                            class="flex-1 px-4 py-3 rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 disabled:opacity-50 text-white font-heading font-extrabold text-xs sm:text-sm shadow-md shadow-sky-600/20 transition-all active:scale-95 flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <iconify-icon x-show="!isSavingEmail" icon="solar:diskette-bold" class="text-base"></iconify-icon>
                            <iconify-icon x-show="isSavingEmail" icon="line-md:loading-loop" class="text-base animate-spin"></iconify-icon>
                            <span x-text="isSavingEmail ? 'Menyimpan...' : 'Simpan & Aktifkan Email'"></span>
                        </button>

                        <button 
                            type="button" 
                            x-show="customerEmail && customerEmail.trim() !== ''"
                            @click="isEditingEmail = false; emailError = '';"
                            class="px-4 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-heading font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                        >
                            <span>Batal</span>
                        </button>
                    </div>
                </div>
            </template>

            <!-- Bottom Skip Option -->
            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                <button 
                    type="button" 
                    @click="skipEmailVerification()"
                    class="text-[11px] text-slate-400 hover:text-slate-600 font-medium underline underline-offset-4 transition-colors cursor-pointer"
                >
                    Lewati (Atur nanti di menu Profil)
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('portalOnboardingTour', (config) => ({
            isOpen: false,
            showEmailModal: false,
            customerEmail: (config.customerEmail || '').trim(),
            customerName: config.customerName || 'Pelanggan',
            inputEmail: (config.customerEmail || '').trim(),
            isEditingEmail: !(config.customerEmail && config.customerEmail.trim().length > 0),
            isSavingEmail: false,
            emailError: '',
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
                }
            ],

            customerId: config.customerId || 'default',
            storageKey: 'mymsn_tour_done_' + (config.customerId || 'default'),
            emailPromptKey: 'mymsn_email_prompt_dismissed_' + (config.customerId || 'default'),

            initTour() {
                this.adaptStepsForCurrentPage();

                // Expose global methods untuk memicu tour atau modal pengecekan email kapan saja
                window.startPortalTour = () => {
                    try {
                        localStorage.removeItem(this.storageKey);
                        sessionStorage.removeItem(this.storageKey);
                    } catch (e) {}
                    window.location.href = `${this.routes.dashboard}?tour_step=1`;
                };

                window.openEmailCheckModal = () => {
                    this.isOpen = false;
                    this.isEditingEmail = !(this.customerEmail && this.customerEmail.trim().length > 0);
                    this.inputEmail = this.customerEmail || '';
                    this.emailError = '';
                    this.showEmailModal = true;
                };

                // Jika server mendeteksi login perdana (is_login = 0 di database), reset storage key agar tour langsung aktif
                if (config.isFirstLogin) {
                    try {
                        localStorage.removeItem(this.storageKey);
                        sessionStorage.removeItem(this.storageKey);
                    } catch (e) {}
                }

                let isDone = false;
                try {
                    isDone = localStorage.getItem(this.storageKey) === 'true' || sessionStorage.getItem(this.storageKey) === 'true';
                } catch (e) {}

                const hasExplicitStep = new URLSearchParams(window.location.search).has('tour_step');

                // 1. Jalankan Onboarding Tour jika login perdana atau jika diminta via URL tour_step
                if (config.shouldActive && (!isDone || hasExplicitStep || config.isFirstLogin)) {
                    this.startTour();
                } else if (this.getCurrentPageName() === 'dashboard') {
                    // 2. Jika di Dashboard dan email belum terdaftar (atau belum pernah dikonfirmasi di sesi ini), tampilkan modal email
                    let emailDismissed = false;
                    try {
                        emailDismissed = sessionStorage.getItem(this.emailPromptKey) === 'true';
                    } catch (e) {}

                    if ((!this.customerEmail || this.customerEmail.trim() === '') && !emailDismissed) {
                        setTimeout(() => {
                            this.showEmailModal = true;
                        }, 600);
                    }
                }
            },

            adaptStepsForCurrentPage() {
                const currentPage = this.getCurrentPageName();
                if (currentPage === 'billing') {
                    // Pastikan langkah 4 dan 5 menargetkan area atas kartu invoice agar tampil optimal di semua layar
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
                }
            },

            lockScroll() {
                this._keyHandler = (e) => {
                    if (this.isOpen && e.code === 'Escape') {
                        this.skipTour();
                    }
                };
                window.addEventListener('keydown', this._keyHandler, { passive: false });
            },

            unlockScroll() {
                if (this._keyHandler) {
                    window.removeEventListener('keydown', this._keyHandler);
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
                
                // Beri ruang yang nyaman di atas elemen agar tidak terpotong navbar
                const headerOffset = isMobile ? 72 : 90;
                const targetScrollY = Math.max(0, Math.round(absoluteTop - headerOffset));

                window.scrollTo({
                    top: targetScrollY,
                    behavior: 'smooth'
                });

                // Perbarui posisi spotlight dan popover secara dinamis selama scrolling berjalan
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

                // Cek jika desktop memiliki ruang lega di samping kanan (misal target ada di kolom kiri seperti rincian tagihan)
                if (window.innerWidth >= 1024 && spaceRight >= popoverWidth + margin && this.spotlight.top < (popoverHeight + topSafeMargin)) {
                    popLeft = this.spotlight.left + this.spotlight.width + margin;
                    popTop = Math.max(topSafeMargin, this.spotlight.top);
                } else if (spaceBelow >= popoverHeight + bottomSafeMargin) {
                    // Cukup ruang di bawah spotlight
                    popTop = this.spotlight.top + this.spotlight.height + margin;
                } else if (spaceAbove >= popoverHeight) {
                    // Cukup ruang di atas spotlight di bawah header navbar
                    popTop = this.spotlight.top - popoverHeight - margin;
                } else if (window.innerWidth >= 768 && spaceRight >= popoverWidth + margin) {
                    // Letakkan di samping kanan
                    popLeft = this.spotlight.left + this.spotlight.width + margin;
                    popTop = Math.max(topSafeMargin, this.spotlight.top);
                } else if (window.innerWidth >= 768 && spaceLeft >= popoverWidth + margin) {
                    // Letakkan di samping kiri
                    popLeft = this.spotlight.left - popoverWidth - margin;
                    popTop = Math.max(topSafeMargin, this.spotlight.top);
                } else {
                    // Fallback di bawah atau di atas
                    popTop = (spaceBelow > spaceAbove) 
                        ? this.spotlight.top + this.spotlight.height + margin 
                        : this.spotlight.top - popoverHeight - margin;
                }

                // Jaminan mutlak: popTop tidak boleh terpotong header dan tidak boleh melampaui batas bawah
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
                
                // Buka Modal Pengecekan & Verifikasi Email Pelanggan
                this.showEmailModal = true;
            },

            skipTour() {
                this.unlockScroll();
                this.isOpen = false;
                try {
                    localStorage.setItem(this.storageKey, 'true');
                    sessionStorage.setItem(this.storageKey, 'true');
                } catch (e) {}
                this.markCompletedOnServer();
            },

            confirmEmailActive() {
                this.showEmailModal = false;
                try {
                    localStorage.setItem(this.storageKey, 'true');
                    sessionStorage.setItem(this.storageKey, 'true');
                } catch (e) {}
                this.markCompletedOnServer();

                this.showCompletionAlert('Email Aktif Terkonfirmasi!', 'Email Anda siap menerima invoice dan notifikasi layanan.');
            },

            async saveNewEmail() {
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
                        try {
                            localStorage.setItem(this.storageKey, 'true');
                            sessionStorage.setItem(this.storageKey, 'true');
                        } catch (e) {}
                        this.markCompletedOnServer();
                        this.showCompletionAlert('Email Berhasil Disimpan!', 'Email notifikasi Anda telah diperbarui dan siap digunakan.');
                    } else {
                        this.emailError = data.message || 'Terjadi kesalahan saat menyimpan email.';
                    }
                } catch (err) {
                    this.emailError = 'Koneksi gagal saat menyimpan email. Silakan coba lagi.';
                } finally {
                    this.isSavingEmail = false;
                }
            },

            skipEmailVerification() {
                this.showEmailModal = false;
                try {
                    localStorage.setItem(this.storageKey, 'true');
                    sessionStorage.setItem(this.storageKey, 'true');
                } catch (e) {}
                this.markCompletedOnServer();
                this.showCompletionAlert('Panduan Selesai!', 'Selamat menggunakan portal layanan MyMSN.');
            },

            showCompletionAlert(title, message) {
                if (window.Swal) {
                    Swal.fire({
                        imageUrl: '{{ asset('images/logo/berhasil1.png') }}',
                        imageWidth: 140,
                        imageHeight: 140,
                        imageAlt: 'Selamat Datang',
                        title: title || 'Selamat Datang!',
                        html: `<p class="text-xs sm:text-sm text-slate-500 font-sans mt-1.5">${message || 'Panduan selesai. Selamat menggunakan portal layanan MyMSN!'}</p>`,
                        showConfirmButton: false,
                        timer: 2300,
                        customClass: {
                            popup: '!rounded-3xl !shadow-2xl !border !border-sky-100 !max-w-[320px] sm:!max-w-[360px] !p-6 sm:!p-7 text-center',
                            image: '!w-32 !h-32 sm:!w-36 sm:!h-36 !object-contain !mx-auto !my-0 !mb-2',
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
        }));
    });
</script>
