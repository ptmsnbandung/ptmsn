<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyMSN — Customer Self-Care | PT Media Solusi Network</title>
    
    <!-- Favicon (Tab Logo) -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-icon.png') }}">

    <!-- Google Fonts: Outfit, Plus Jakarta Sans, Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#0284c7',
                            cyan: '#0ea5e9',
                            sky: '#38bdf8',
                            navy: '#091322',
                        }
                    },
                    fontFamily: {
                        brand: ['Outfit', 'Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'Outfit', 'sans-serif'],
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Iconify Web Component -->
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        html, body {
            min-height: 100%;
            min-height: 100dvh;
            margin: 0;
            padding: 0;
        }

        @media (max-width: 767px) {
            html, body {
                overflow-x: hidden;
            }
        }

        @media (min-width: 768px) {
            html, body {
                height: 100%;
                overflow: hidden !important;
            }
        }

        body {
            background: linear-gradient(135deg, #091322 0%, #0f172a 45%, #0e7490 100%);
            font-family: 'Inter', sans-serif;
        }

        /* Halo Dashboard Gradient for Branding Panel */
        .hero-network-gradient {
            background: linear-gradient(135deg, #091322 0%, #0f172a 45%, #0e7490 100%);
        }

        /* Mobile bottom sheet rounded top with subtle dot micro-texture */
        .clean-login-sheet {
            background-color: #ffffff;
            background-image: 
                radial-gradient(at 100% 0%, rgba(14, 165, 233, 0.08) 0px, transparent 40%),
                radial-gradient(at 0% 100%, rgba(2, 132, 199, 0.05) 0px, transparent 40%),
                radial-gradient(rgba(148, 163, 184, 0.16) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 18px 18px;
            background-position: 0 0, 0 0, 0 0;
            border-top-left-radius: 32px;
            border-top-right-radius: 32px;
            box-shadow: 0 -12px 36px -4px rgba(9, 19, 34, 0.35);
            padding-bottom: max(1.75rem, calc(env(safe-area-inset-bottom, 0px) + 1.25rem));
        }

        @media (min-width: 768px) {
            .desktop-hero-panel {
                background: linear-gradient(135deg, #091322 0%, #0f172a 45%, #0e7490 100%) !important;
            }
            .clean-login-sheet {
                border-radius: 0px;
                box-shadow: none;
                padding-bottom: 2rem;
            }
        }

        .input-glow:focus-within {
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.25);
        }

        .otp-input:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
            border-color: #10b981;
        }
    </style>
</head>
<body class="min-h-[100dvh] hero-network-gradient flex flex-col justify-between md:justify-center items-center text-slate-800 antialiased p-0 md:p-6 relative">

    <!-- Global Network Topology Background (Seamless across full screen) -->
    <div class="absolute inset-0 pointer-events-none opacity-20 overflow-hidden z-0">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
            <defs>
                <pattern id="network-mesh-pattern" width="70" height="70" patternUnits="userSpaceOnUse">
                    <circle cx="12" cy="12" r="1.5" fill="#38bdf8" />
                    <circle cx="55" cy="40" r="2" fill="#0ea5e9" />
                    <circle cx="35" cy="60" r="1.5" fill="#38bdf8" />
                    <path d="M12 12 L55 40 M55 40 L35 60 M12 12 L-12 40 M55 40 L85 12" stroke="#38bdf8" stroke-width="0.75" stroke-dasharray="2 3" opacity="0.8"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#network-mesh-pattern)" />
        </svg>
    </div>

    <!-- Ambient Glow Background Blobs (Desktop) -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden hidden md:block">
        <div class="absolute -top-24 -left-24 w-[450px] h-[450px] bg-sky-500/15 rounded-full blur-[140px]"></div>
        <div class="absolute -bottom-24 -right-24 w-[450px] h-[450px] bg-cyan-500/20 rounded-full blur-[140px]"></div>
    </div>

    <!-- Main Container: 37% Blue / 63% White split on Mobile -->
    <div class="w-full max-w-full md:max-w-4xl min-h-[100dvh] md:min-h-0 md:h-auto md:max-h-[90vh] flex flex-col md:flex-row justify-between md:rounded-3xl md:shadow-2xl md:border md:border-sky-500/30 overflow-hidden relative z-10 bg-transparent md:bg-white">

        <!-- LEFT / TOP SECTION: Brand Header (37% on Mobile & 42% on Desktop) -->
        <div class="bg-transparent desktop-hero-panel min-h-[30dvh] h-[33dvh] md:h-auto md:min-h-0 md:max-h-none md:w-5/12 flex-none flex flex-col items-center justify-center p-3 sm:p-4 md:p-8 text-center relative z-10 md:border-r md:border-sky-500/20">
            
            <!-- Ambient Card Glow -->
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-36 h-36 bg-sky-400/25 rounded-full blur-2xl pointer-events-none"></div>
            
            <!-- Logo Icon Container (Fixed 59px box) -->
            <a href="{{ route('home') }}" class="group block mb-1.5 sm:mb-2 transform hover:scale-105 transition-transform duration-300 relative z-10 shrink-0">
                <div class="w-[59px] h-[59px] rounded-2xl bg-white p-2 shadow-xl shadow-sky-950/60 border border-white/90 flex items-center justify-center mx-auto" style="width: 59px; height: 59px;">
                    <img 
                        src="{{ asset('images/logo/logo-icon.png') }}" 
                        alt="PT Media Solusi Network" 
                        class="w-[43px] h-[43px] object-contain filter drop-shadow-xs"
                    >
                </div>
            </a>

            <!-- Brand Typography -->
            <div class="relative z-10 shrink-0">
                <h1 class="text-white font-heading font-extrabold text-xl sm:text-2xl md:text-3xl tracking-tight drop-shadow-md flex items-center justify-center gap-1">
                    <span>My</span><span class="text-sky-300">MSN</span>
                </h1>
                <p class="text-sky-200/90 text-[10px] sm:text-xs font-semibold tracking-wider uppercase mt-0.5">
                    Customer Self-Care Portal
                </p>
                <p class="text-slate-300/80 text-xs font-sans mt-2 max-w-xs hidden md:block leading-relaxed">
                    Akses tagihan internet, cek status koneksi, dan layanan bantuan pelanggan secara real-time.
                </p>
            </div>

            <!-- Desktop Highlights Badges -->
            <div class="hidden md:flex flex-col gap-2 mt-6 w-full max-w-xs text-left relative z-10">
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-800/60 border border-slate-700/80 text-[11.5px] text-slate-200">
                    <iconify-icon icon="solar:wallet-money-bold" class="text-sky-400 text-sm shrink-0"></iconify-icon>
                    <span>Cek & Bayar Tagihan Otomatis</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-800/60 border border-slate-700/80 text-[11.5px] text-slate-200">
                    <iconify-icon icon="solar:chat-round-dots-bold" class="text-emerald-400 text-sm shrink-0"></iconify-icon>
                    <span>Tiket Bantuan & Respon Cepat NOC</span>
                </div>
            </div>

            <!-- Desktop Footer Note -->
            <div class="hidden md:block mt-auto pt-4 text-[10px] text-slate-400 font-mono">
                PT MEDIA SOLUSI NETWORK © {{ date('Y') }}
            </div>
        </div>

        <!-- RIGHT / BOTTOM SECTION: White Clean Form Card (63% on Mobile & 58% on Desktop) -->
        <div class="clean-login-sheet flex-1 min-h-[67dvh] md:min-h-0 md:h-auto md:max-h-none md:w-7/12 flex-none px-5 sm:px-8 md:px-10 pt-4 md:py-8 flex flex-col justify-center items-center flex-shrink-0 z-20 overflow-y-auto">
            
            <div class="w-full max-w-sm flex flex-col gap-2.5 sm:gap-3.5 my-auto">
                <!-- Card Header: SELAMAT DATANG -->
                <div class="text-center">
                    <h2 class="text-xl sm:text-2xl font-heading font-black tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-[#091322] via-[#0f233d] to-[#0e7490] uppercase">
                        SELAMAT DATANG
                    </h2>
                    <p class="text-[11px] sm:text-xs text-slate-400 font-medium mt-0.5" id="headerSubtitle">
                        Silakan masuk dengan akun internet Anda
                    </p>
                </div>

                <!-- Dynamic Inline Alert Container -->
                <div id="dynamicAlert" class="hidden p-2.5 rounded-xl text-xs flex items-start gap-1.5 transition-all"></div>

                <!-- Session Alerts Container -->
                @if(session('warning'))
                    <div class="p-2.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-start gap-1.5 animate-pulse">
                        <iconify-icon icon="solar:clock-circle-bold" class="text-sm shrink-0 text-amber-500 mt-0.5"></iconify-icon>
                        <span class="leading-tight">{{ session('warning') }}</span>
                    </div>
                @endif

                @if(session('info'))
                    <div class="p-2.5 rounded-xl bg-sky-50 border border-sky-200 text-sky-900 text-xs flex items-start gap-1.5">
                        <iconify-icon icon="solar:info-circle-bold" class="text-sm shrink-0 text-sky-500 mt-0.5"></iconify-icon>
                        <span class="leading-tight">{{ session('info') }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs flex items-start gap-1.5">
                        <iconify-icon icon="solar:check-circle-bold" class="text-sm shrink-0 text-emerald-500 mt-0.5"></iconify-icon>
                        <span class="leading-tight">{{ session('success') }}</span>
                    </div>
                @endif

                @if(isset($errors) && $errors->any())
                    <div class="p-2.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-xs">
                        @foreach($errors->all() as $error)
                            <div class="flex items-start gap-1.5">
                                <iconify-icon icon="solar:danger-circle-bold" class="text-sm shrink-0 text-rose-500 mt-0.5"></iconify-icon>
                                <span class="leading-tight">{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Form Container -->
                <form id="loginForm" action="{{ route('portal.login.submit') }}" method="POST" class="space-y-3 w-full">
                    @csrf

                    <!-- 2 Pilihan Tab: No. Internet vs No. Telepon (Sembunyi saat di mode input OTP) -->
                    <div id="tabContainer" class="space-y-2">
                        <div class="grid grid-cols-2 gap-1.5 p-1 rounded-2xl bg-slate-100/90 border border-slate-200/80">
                            <button 
                                type="button" 
                                id="tabNoInternet"
                                onclick="switchLoginMode('internet')"
                                class="py-2 px-3 rounded-xl text-xs font-heading font-extrabold flex items-center justify-center gap-1.5 transition-all cursor-pointer bg-white text-sky-700 shadow-sm border border-slate-200/60"
                            >
                                <iconify-icon icon="solar:hashtag-bold" class="text-sm text-sky-500"></iconify-icon>
                                <span>No. Internet</span>
                            </button>
                            <button 
                                type="button" 
                                id="tabNoPhone"
                                onclick="switchLoginMode('phone')"
                                class="py-2 px-3 rounded-xl text-xs font-heading font-bold flex items-center justify-center gap-1.5 transition-all cursor-pointer text-slate-500 hover:text-slate-800 hover:bg-slate-200/50"
                            >
                                <iconify-icon icon="solar:phone-calling-bold" class="text-sm text-slate-400"></iconify-icon>
                                <span>No. Telepon</span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP A: INPUT FIELD UTAMA (Nomor Internet atau Nomor WhatsApp) -->
                    <div id="stepInputSection">
                        <div>
                            <label id="inputLabel" for="loginInput" class="block text-[11px] font-heading font-semibold text-slate-600 mb-1 pl-1">
                                Nomor Internet (ID Pelanggan)
                            </label>
                            
                            <div class="relative input-glow rounded-xl sm:rounded-2xl transition-all">
                                <input 
                                    type="text" 
                                    id="loginInput" 
                                    name="login" 
                                    value="{{ old('login', old('phone')) }}" 
                                    required 
                                    autofocus 
                                    class="w-full pl-3.5 pr-10 py-2.5 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 text-xs sm:text-sm focus:outline-none focus:bg-white focus:border-sky-400 transition-all font-sans shadow-xs"
                                    placeholder="Contoh: 123456 / 1020000001"
                                    autocomplete="username"
                                >
                                <!-- Right Icon -->
                                <div id="inputIcon" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-sky-500">
                                    <iconify-icon icon="solar:hashtag-bold" width="18"></iconify-icon>
                                </div>
                            </div>
                            <p id="inputHelper" class="text-[10px] text-slate-400 mt-1 pl-1 font-sans">
                                Masukkan 6-12 digit ID Pelanggan yang tertera pada invoice Anda.
                            </p>
                        </div>

                        <!-- Auxiliary Row: Remember & Help -->
                        <div class="flex items-center justify-between text-[11px] pt-2 px-0.5">
                            <label class="flex items-center gap-1.5 cursor-pointer text-slate-500 hover:text-slate-700 select-none">
                                <input type="checkbox" name="remember" checked class="w-3.5 h-3.5 rounded text-sky-500 border-slate-300 focus:ring-sky-400 accent-sky-500">
                                <span>Ingat Saya</span>
                            </label>
                            <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text={{ urlencode('Halo Tim NOC PT MSN, saya butuh bantuan login portal pelanggan') }}" target="_blank" class="font-semibold text-sky-600 hover:text-sky-700 hover:underline">
                                Butuh Bantuan?
                            </a>
                        </div>
                    </div>

                    <!-- STEP B: INPUT FIELD VERIFIKASI OTP WHATSAPP (Tampil saat mode telepon aktif & OTP terkirim) -->
                    <div id="stepOtpSection" class="hidden space-y-3">
                        <!-- Info Box Nomor WhatsApp -->
                        <div class="p-3 rounded-2xl bg-gradient-to-r from-emerald-50 to-teal-50/70 border border-emerald-200/90 text-emerald-900 text-xs flex items-center justify-between shadow-2xs">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                                    <iconify-icon icon="logos:whatsapp-icon" width="16"></iconify-icon>
                                </div>
                                <div>
                                    <div class="text-[10.5px] text-emerald-700 font-semibold">Kode dikirim via WhatsApp ke:</div>
                                    <div id="otpTargetPhoneText" class="font-mono font-bold text-slate-900 text-xs sm:text-sm">0812••••7890</div>
                                </div>
                            </div>
                            <button 
                                type="button" 
                                onclick="cancelOtpStep()" 
                                class="text-[11px] font-bold text-sky-600 hover:text-sky-800 underline cursor-pointer"
                            >
                                Ganti
                            </button>
                        </div>

                        <!-- Input 6-Digit OTP -->
                        <div>
                            <label for="otpCodeInput" class="block text-[11px] font-heading font-semibold text-slate-700 mb-1 pl-1 text-center">
                                Masukkan 6-Digit Kode Verifikasi:
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="otpCodeInput" 
                                    inputmode="numeric" 
                                    pattern="[0-9]*" 
                                    maxlength="6" 
                                    placeholder="••••••" 
                                    autocomplete="one-time-code"
                                    class="otp-input w-full py-3 px-4 rounded-2xl bg-slate-50 border-2 border-slate-200 text-center text-2xl sm:text-3xl font-mono font-extrabold tracking-[0.45em] text-slate-900 placeholder-slate-300 focus:outline-none focus:bg-white transition-all shadow-xs"
                                >
                            </div>
                            <p class="text-[10.5px] text-slate-400 mt-1.5 text-center font-sans">
                                Cek pesan resmi WhatsApp dari PT Media Solusi Network.
                            </p>
                        </div>

                        <!-- Resend OTP Row with Timer -->
                        <div class="flex items-center justify-between text-xs pt-1 px-1">
                            <button 
                                type="button" 
                                id="btnResendOtp" 
                                onclick="resendOtpCode()" 
                                disabled
                                class="text-[11px] font-heading font-bold text-slate-400 disabled:opacity-60 disabled:cursor-not-allowed hover:text-emerald-600 transition-colors cursor-pointer flex items-center gap-1"
                            >
                                <iconify-icon icon="solar:restart-linear" width="13"></iconify-icon>
                                <span id="resendBtnText">Kirim Ulang Kode (60s)</span>
                            </button>

                            <button 
                                type="button" 
                                onclick="cancelOtpStep()" 
                                class="text-[11px] font-heading font-semibold text-slate-500 hover:text-slate-800 transition-colors cursor-pointer"
                            >
                                ← Batal
                            </button>
                        </div>
                    </div>

                    <!-- Dynamic Action Submit Button -->
                    <div class="pt-1.5 text-center">
                        <button 
                            type="submit" 
                            id="btnSubmit"
                            class="w-full sm:w-52 py-2.5 px-6 rounded-full bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-extrabold text-xs sm:text-sm uppercase tracking-wider transition-all duration-200 shadow-md shadow-sky-500/25 hover:shadow-lg hover:shadow-sky-500/35 active:scale-95 flex items-center justify-center gap-2 cursor-pointer mx-auto disabled:opacity-80 disabled:cursor-not-allowed disabled:pointer-events-none"
                        >
                            <span id="btnIconContainer" class="flex items-center"></span>
                            <span id="btnText" class="inline-flex items-center justify-center">
                                LOGIN
                            </span>
                            <span id="btnLoading" class="hidden items-center justify-center gap-1.5">
                                <svg class="animate-spin h-3.5 w-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-[11px]" id="btnLoadingText">MEMPROSES...</span>
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Social / Quick Help Buttons -->
                <div class="flex items-center justify-center gap-3 pt-0.5">
                    <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text={{ urlencode('Halo Tim NOC PT MSN, saya butuh bantuan terkait layanan internet') }}" target="_blank" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white border border-slate-200/80 shadow-xs flex items-center justify-center text-emerald-500 hover:scale-110 hover:bg-emerald-50 transition-all" title="Hubungi WhatsApp NOC MSN">
                        <iconify-icon icon="logos:whatsapp-icon" width="17"></iconify-icon>
                    </a>
                    <a href="{{ route('home') }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white border border-slate-200/80 shadow-xs flex items-center justify-center text-sky-500 hover:scale-110 hover:bg-sky-50 transition-all" title="Website Resmi MSN">
                        <iconify-icon icon="solar:global-bold" width="17"></iconify-icon>
                    </a>
                </div>

                <!-- Footer: Register / Web Link -->
                <div class="text-center">
                    <p class="text-[10.5px] text-slate-500">
                        Belum berlangganan? 
                        <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}?text={{ urlencode('Halo Tim PT MSN, saya ingin pasang dan berlangganan internet baru') }}" target="_blank" class="font-bold text-sky-600 hover:underline">
                            Daftar Sekarang
                        </a>
                    </p>
                    <div class="mt-0.5">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-[10px] text-slate-400 hover:text-slate-600 transition-colors">
                            <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                            <span>Kembali ke Halaman Utama</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Script Handling Login Mode, WhatsApp OTP Verification & Resend Timer -->
    <script>
        let currentLoginMode = 'internet'; // 'internet' | 'phone'
        let currentOtpStep = 'phone_input'; // 'phone_input' | 'otp_verify'
        let activePhoneTarget = '';
        let resendCountdownTimer = null;
        let cooldownSeconds = 60;

        function showDynamicAlert(type, message) {
            const el = document.getElementById('dynamicAlert');
            if (!el) return;

            el.className = 'p-2.5 rounded-xl text-xs flex items-start gap-1.5 transition-all';
            let icon = 'solar:info-circle-bold';
            
            if (type === 'error') {
                el.classList.add('bg-rose-50', 'border', 'border-rose-200', 'text-rose-900');
                icon = 'solar:danger-circle-bold';
            } else if (type === 'success') {
                el.classList.add('bg-emerald-50', 'border', 'border-emerald-200', 'text-emerald-900');
                icon = 'solar:check-circle-bold';
            } else if (type === 'warning') {
                el.classList.add('bg-amber-50', 'border', 'border-amber-200', 'text-amber-900');
                icon = 'solar:clock-circle-bold';
            } else {
                el.classList.add('bg-sky-50', 'border', 'border-sky-200', 'text-sky-900');
            }

            el.innerHTML = `
                <iconify-icon icon="${icon}" class="text-sm shrink-0 mt-0.5"></iconify-icon>
                <span class="leading-tight">${message}</span>
            `;
            el.classList.remove('hidden');
        }

        function hideDynamicAlert() {
            const el = document.getElementById('dynamicAlert');
            if (el) el.classList.add('hidden');
        }

        function switchLoginMode(mode) {
            currentLoginMode = mode;
            hideDynamicAlert();

            const tabInternet = document.getElementById('tabNoInternet');
            const tabPhone = document.getElementById('tabNoPhone');
            const inputLabel = document.getElementById('inputLabel');
            const loginInput = document.getElementById('loginInput');
            const inputIcon = document.getElementById('inputIcon');
            const inputHelper = document.getElementById('inputHelper');
            const btnSubmit = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnIconContainer = document.getElementById('btnIconContainer');

            if (!tabInternet || !tabPhone || !loginInput) return;

            // Reset step OTP jika sebelumnya dalam tahap OTP
            cancelOtpStep(false);

            const activeClass = ['bg-white', 'text-sky-700', 'shadow-sm', 'border', 'border-slate-200/60', 'font-extrabold'];
            const inactiveClass = ['text-slate-500', 'hover:text-slate-800', 'hover:bg-slate-200/50', 'font-bold'];

            if (mode === 'phone') {
                // Switch tab styling
                tabPhone.classList.remove(...inactiveClass);
                tabPhone.classList.add(...activeClass);
                const phoneIcon = tabPhone.querySelector('iconify-icon');
                if (phoneIcon) phoneIcon.className = 'text-sm text-emerald-500';

                tabInternet.classList.remove(...activeClass);
                tabInternet.classList.add(...inactiveClass);
                const internetIcon = tabInternet.querySelector('iconify-icon');
                if (internetIcon) internetIcon.className = 'text-sm text-slate-400';

                // Switch field attributes
                if (inputLabel) inputLabel.textContent = 'Nomor Telepon / WhatsApp';
                loginInput.placeholder = 'Contoh: 081234567890';
                loginInput.name = 'phone';
                loginInput.type = 'tel';
                if (inputIcon) inputIcon.innerHTML = '<iconify-icon icon="solar:phone-calling-bold" width="18" class="text-emerald-500"></iconify-icon>';
                if (inputHelper) inputHelper.textContent = 'Kode OTP verifikasi resmi akan dikirimkan ke nomor WhatsApp ini.';

                // Switch button style: WhatsApp emerald gradient
                btnSubmit.className = 'w-full sm:w-56 py-2.5 px-6 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-heading font-extrabold text-xs sm:text-sm uppercase tracking-wider transition-all duration-200 shadow-md shadow-emerald-500/25 hover:shadow-lg hover:shadow-emerald-500/35 active:scale-95 flex items-center justify-center gap-2 cursor-pointer mx-auto';
                if (btnIconContainer) btnIconContainer.innerHTML = '<iconify-icon icon="logos:whatsapp-icon" width="16" class="shrink-0"></iconify-icon>';
                if (btnText) btnText.textContent = 'KIRIM KODE OTP';
            } else {
                // Switch tab styling
                tabInternet.classList.remove(...inactiveClass);
                tabInternet.classList.add(...activeClass);
                const internetIcon = tabInternet.querySelector('iconify-icon');
                if (internetIcon) internetIcon.className = 'text-sm text-sky-500';

                tabPhone.classList.remove(...activeClass);
                tabPhone.classList.add(...inactiveClass);
                const phoneIcon = tabPhone.querySelector('iconify-icon');
                if (phoneIcon) phoneIcon.className = 'text-sm text-slate-400';

                // Switch field attributes
                if (inputLabel) inputLabel.textContent = 'Nomor Internet (ID Pelanggan)';
                loginInput.placeholder = 'Contoh: 123456 / 1020000001';
                loginInput.name = 'login';
                loginInput.type = 'text';
                if (inputIcon) inputIcon.innerHTML = '<iconify-icon icon="solar:hashtag-bold" width="18" class="text-sky-500"></iconify-icon>';
                if (inputHelper) inputHelper.textContent = 'Masukkan 6-12 digit ID Pelanggan yang tertera pada invoice Anda.';

                // Switch button style: Classic Sky gradient
                btnSubmit.className = 'w-full sm:w-44 py-2.5 px-6 rounded-full bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-extrabold text-xs sm:text-sm uppercase tracking-wider transition-all duration-200 shadow-md shadow-sky-500/25 hover:shadow-lg hover:shadow-sky-500/35 active:scale-95 flex items-center justify-center gap-2 cursor-pointer mx-auto';
                if (btnIconContainer) btnIconContainer.innerHTML = '';
                if (btnText) btnText.textContent = 'LOGIN';
            }

            loginInput.focus();
        }

        // Beralih ke step Verifikasi OTP
        function activateOtpStep(phone, maskedPhone, cooldown) {
            currentOtpStep = 'otp_verify';
            activePhoneTarget = phone;
            hideDynamicAlert();

            document.getElementById('stepInputSection').classList.add('hidden');
            document.getElementById('tabContainer').classList.add('hidden');
            document.getElementById('stepOtpSection').classList.remove('hidden');

            document.getElementById('otpTargetPhoneText').textContent = maskedPhone || phone;
            document.getElementById('headerSubtitle').textContent = 'Verifikasi kode WhatsApp Anda';

            const btnSubmit = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnIconContainer = document.getElementById('btnIconContainer');

            btnSubmit.className = 'w-full sm:w-56 py-2.5 px-6 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-heading font-extrabold text-xs sm:text-sm uppercase tracking-wider transition-all duration-200 shadow-md shadow-emerald-500/25 hover:shadow-lg hover:shadow-emerald-500/35 active:scale-95 flex items-center justify-center gap-2 cursor-pointer mx-auto';
            if (btnIconContainer) btnIconContainer.innerHTML = '<iconify-icon icon="solar:check-circle-bold" width="16"></iconify-icon>';
            if (btnText) btnText.textContent = 'VERIFIKASI & MASUK';

            const otpInput = document.getElementById('otpCodeInput');
            if (otpInput) {
                otpInput.value = '';
                otpInput.focus();
            }

            startResendCountdown(cooldown || 60);
        }

        // Batalkan / kembali ke step input nomor telepon
        function cancelOtpStep(shouldFocus = true) {
            currentOtpStep = 'phone_input';
            clearInterval(resendCountdownTimer);
            hideDynamicAlert();

            const stepInputSection = document.getElementById('stepInputSection');
            const tabContainer = document.getElementById('tabContainer');
            const stepOtpSection = document.getElementById('stepOtpSection');
            const headerSubtitle = document.getElementById('headerSubtitle');

            if (stepInputSection) stepInputSection.classList.remove('hidden');
            if (tabContainer) tabContainer.classList.remove('hidden');
            if (stepOtpSection) stepOtpSection.classList.add('hidden');
            if (headerSubtitle) headerSubtitle.textContent = 'Silakan masuk dengan akun internet Anda';

            const btnSubmit = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnIconContainer = document.getElementById('btnIconContainer');

            if (currentLoginMode === 'phone') {
                btnSubmit.className = 'w-full sm:w-56 py-2.5 px-6 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-heading font-extrabold text-xs sm:text-sm uppercase tracking-wider transition-all duration-200 shadow-md shadow-emerald-500/25 hover:shadow-lg hover:shadow-emerald-500/35 active:scale-95 flex items-center justify-center gap-2 cursor-pointer mx-auto';
                if (btnIconContainer) btnIconContainer.innerHTML = '<iconify-icon icon="logos:whatsapp-icon" width="16" class="shrink-0"></iconify-icon>';
                if (btnText) btnText.textContent = 'KIRIM KODE OTP';
            } else {
                btnSubmit.className = 'w-full sm:w-44 py-2.5 px-6 rounded-full bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-extrabold text-xs sm:text-sm uppercase tracking-wider transition-all duration-200 shadow-md shadow-sky-500/25 hover:shadow-lg hover:shadow-sky-500/35 active:scale-95 flex items-center justify-center gap-2 cursor-pointer mx-auto';
                if (btnIconContainer) btnIconContainer.innerHTML = '';
                if (btnText) btnText.textContent = 'LOGIN';
            }

            if (shouldFocus) {
                const loginInput = document.getElementById('loginInput');
                if (loginInput) loginInput.focus();
            }
        }

        // Timer hitung mundur kirim ulang OTP
        function startResendCountdown(seconds) {
            clearInterval(resendCountdownTimer);
            cooldownSeconds = seconds;

            const resendBtn = document.getElementById('btnResendOtp');
            const resendText = document.getElementById('resendBtnText');

            if (resendBtn) resendBtn.disabled = true;

            resendCountdownTimer = setInterval(() => {
                cooldownSeconds--;
                if (cooldownSeconds <= 0) {
                    clearInterval(resendCountdownTimer);
                    if (resendBtn) resendBtn.disabled = false;
                    if (resendText) resendText.textContent = 'Kirim Ulang Kode OTP';
                } else {
                    if (resendText) resendText.textContent = `Kirim Ulang Kode (${cooldownSeconds}s)`;
                }
            }, 1000);
        }

        // Handle request kirim OTP WhatsApp
        async function handleSendOtp(phone) {
            const btnSubmit = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            const btnLoadingText = document.getElementById('btnLoadingText');
            const btnIconContainer = document.getElementById('btnIconContainer');

            btnSubmit.disabled = true;
            if (btnIconContainer) btnIconContainer.classList.add('hidden');
            if (btnText) btnText.classList.add('hidden');
            if (btnLoading) {
                btnLoading.classList.remove('hidden');
                btnLoading.classList.add('inline-flex');
                if (btnLoadingText) btnLoadingText.textContent = 'MENGIRIM WHATSAPP...';
            }

            hideDynamicAlert();

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const res = await fetch("{{ route('portal.login.send-otp') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ phone: phone })
                });

                const data = await res.json();

                if (res.ok && data.success) {
                    activateOtpStep(data.phone || phone, data.masked_phone, data.cooldown || 60);
                    showDynamicAlert('success', data.message || 'Kode verifikasi telah dikirim ke WhatsApp Anda.');

                    // Jika ada debug OTP di local development
                    if (data.debug_otp) {
                        console.info('DEMO LOCAL OTP:', data.debug_otp);
                    }
                } else {
                    showDynamicAlert('error', data.message || 'Gagal mengirim kode verifikasi.');
                }
            } catch (err) {
                console.error(err);
                showDynamicAlert('error', 'Gagal terhubung ke server. Silakan periksa koneksi internet Anda.');
            } finally {
                btnSubmit.disabled = false;
                if (btnIconContainer) btnIconContainer.classList.remove('hidden');
                if (btnText) btnText.classList.remove('hidden');
                if (btnLoading) {
                    btnLoading.classList.remove('inline-flex');
                    btnLoading.classList.add('hidden');
                }
            }
        }

        // Handle verifikasi kode OTP
        async function handleVerifyOtp(otp) {
            const btnSubmit = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            const btnLoadingText = document.getElementById('btnLoadingText');
            const btnIconContainer = document.getElementById('btnIconContainer');

            btnSubmit.disabled = true;
            if (btnIconContainer) btnIconContainer.classList.add('hidden');
            if (btnText) btnText.classList.add('hidden');
            if (btnLoading) {
                btnLoading.classList.remove('hidden');
                btnLoading.classList.add('inline-flex');
                if (btnLoadingText) btnLoadingText.textContent = 'MEMVERIFIKASI...';
            }

            hideDynamicAlert();

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const res = await fetch("{{ route('portal.login.verify-otp') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        phone: activePhoneTarget,
                        otp: otp
                    })
                });

                const data = await res.json();

                if (res.ok && data.success) {
                    showDynamicAlert('success', data.message || 'Verifikasi berhasil! Mengalihkan...');
                    window.location.href = data.redirect || "{{ route('portal.dashboard') }}";
                } else {
                    showDynamicAlert('error', data.message || 'Kode verifikasi tidak valid.');
                    btnSubmit.disabled = false;
                    if (btnIconContainer) btnIconContainer.classList.remove('hidden');
                    if (btnText) btnText.classList.remove('hidden');
                    if (btnLoading) {
                        btnLoading.classList.remove('inline-flex');
                        btnLoading.classList.add('hidden');
                    }
                    const otpInput = document.getElementById('otpCodeInput');
                    if (otpInput) {
                        otpInput.select();
                        otpInput.focus();
                    }
                }
            } catch (err) {
                console.error(err);
                showDynamicAlert('error', 'Gagal memproses verifikasi kode OTP.');
                btnSubmit.disabled = false;
                if (btnIconContainer) btnIconContainer.classList.remove('hidden');
                if (btnText) btnText.classList.remove('hidden');
                if (btnLoading) {
                    btnLoading.classList.remove('inline-flex');
                    btnLoading.classList.add('hidden');
                }
            }
        }

        // Trigger kirim ulang OTP
        function resendOtpCode() {
            if (!activePhoneTarget) return;
            handleSendOtp(activePhoneTarget);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const loginInput = document.getElementById('loginInput');
            if (loginInput && loginInput.value) {
                const val = loginInput.value.trim();
                if (val.startsWith('08') || val.startsWith('62') || val.startsWith('+62')) {
                    switchLoginMode('phone');
                }
            }

            const loginForm = document.getElementById('loginForm');
            const otpCodeInput = document.getElementById('otpCodeInput');

            // Form submit dispatcher
            if (loginForm) {
                loginForm.addEventListener('submit', function (e) {
                    if (currentLoginMode === 'phone') {
                        e.preventDefault();

                        if (currentOtpStep === 'phone_input') {
                            const phoneVal = loginInput.value.trim();
                            if (!phoneVal) {
                                showDynamicAlert('warning', 'Silakan masukkan nomor telepon / WhatsApp Anda.');
                                loginInput.focus();
                                return;
                            }
                            handleSendOtp(phoneVal);
                        } else if (currentOtpStep === 'otp_verify') {
                            const otpVal = otpCodeInput ? otpCodeInput.value.trim() : '';
                            if (!otpVal || otpVal.length < 6) {
                                showDynamicAlert('warning', 'Silakan masukkan 6-digit kode OTP verifikasi WhatsApp.');
                                if (otpCodeInput) otpCodeInput.focus();
                                return;
                            }
                            handleVerifyOtp(otpVal);
                        }
                    } else {
                        // Mode 'internet': Langsung submit form standar
                        const btnSubmit = document.getElementById('btnSubmit');
                        const btnText = document.getElementById('btnText');
                        const btnLoading = document.getElementById('btnLoading');

                        if (btnSubmit.disabled) {
                            e.preventDefault();
                            return false;
                        }

                        btnSubmit.disabled = true;
                        if (btnText) btnText.classList.add('hidden');
                        if (btnLoading) {
                            btnLoading.classList.remove('hidden');
                            btnLoading.classList.add('inline-flex');
                        }
                    }
                });
            }

            // Auto-submit saat 6-digit OTP selesai diketik
            if (otpCodeInput) {
                otpCodeInput.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length === 6 && currentOtpStep === 'otp_verify') {
                        handleVerifyOtp(this.value.trim());
                    }
                });
            }
        });
    </script>
</body>
</html>
