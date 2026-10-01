<!DOCTYPE html>
<html lang="id" class="h-full overflow-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

    <style>
        html, body {
            height: 100%;
            height: 100dvh;
            max-height: 100dvh;
            overflow: hidden !important;
            margin: 0;
            padding: 0;
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
            border-top-left-radius: 36px;
            border-top-right-radius: 36px;
            box-shadow: 0 -12px 36px -4px rgba(9, 19, 34, 0.35);
        }

        @media (min-width: 768px) {
            .clean-login-sheet {
                border-radius: 0px;
                box-shadow: none;
            }
        }

        .input-glow:focus-within {
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.25);
        }
    </style>
</head>
<body class="h-full max-h-[100dvh] hero-network-gradient flex flex-col justify-between md:justify-center items-center text-slate-800 antialiased p-0 md:p-6 relative overflow-hidden">

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
    <div class="w-full max-w-full md:max-w-4xl h-[100dvh] max-h-[100dvh] md:h-auto md:max-h-[90vh] flex flex-col md:flex-row justify-between md:rounded-3xl md:shadow-2xl md:border md:border-sky-500/30 overflow-hidden relative z-10 bg-transparent md:bg-white">

        <!-- LEFT / TOP SECTION: Brand Header (37% on Mobile & 42% on Desktop) -->
        <div class="bg-transparent md:hero-network-gradient h-[37vh] max-h-[37vh] md:h-auto md:max-h-none md:w-5/12 flex-none flex flex-col items-center justify-center p-3.5 sm:p-4 md:p-8 text-center relative z-10 md:border-r md:border-sky-500/20">
            
            <!-- Ambient Card Glow -->
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-36 h-36 bg-sky-400/25 rounded-full blur-2xl pointer-events-none"></div>
            
            <!-- Logo Icon Container (Fixed 56px box so it never expands) -->
            <a href="{{ route('home') }}" class="group block mb-1.5 sm:mb-2 transform hover:scale-105 transition-transform duration-300 relative z-10 shrink-0">
                <div class="w-14 h-14 rounded-2xl bg-white p-2 shadow-xl shadow-sky-950/60 border border-white/90 flex items-center justify-center mx-auto" style="width: 56px; height: 56px;">
                    <img 
                        src="{{ asset('images/logo/logo-icon.png') }}" 
                        alt="PT Media Solusi Network" 
                        class="w-10 h-10 object-contain filter drop-shadow-xs"
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
        <div class="clean-login-sheet h-[63vh] max-h-[63vh] md:h-auto md:max-h-none md:w-7/12 flex-none px-6 sm:px-8 md:px-10 py-5 sm:py-6 md:py-8 flex flex-col justify-center items-center flex-shrink-0 z-20">
            
            <div class="w-full max-w-sm flex flex-col gap-3 sm:gap-3.5 my-auto">
                <!-- Card Header: WELCOME -->
                <div class="text-center">
                    <h2 class="text-2xl sm:text-[26px] font-heading font-black tracking-widest text-[#0284c7] uppercase">
                        WELCOME
                    </h2>
                    <p class="text-[11px] sm:text-xs text-slate-400 font-medium mt-0.5">
                        Silakan masuk dengan akun internet Anda
                    </p>
                </div>

                <!-- Alerts Container -->
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

                <!-- Form -->
                <form id="loginForm" action="{{ route('portal.login.submit') }}" method="POST" class="space-y-3 w-full">
                    @csrf

                    <!-- Input: Nomor Internet / WhatsApp -->
                    <div>
                        <label for="login" class="block text-[11px] font-heading font-semibold text-slate-600 mb-1 pl-1">
                            Nomor Internet / WhatsApp
                        </label>
                        
                        <div class="relative input-glow rounded-xl sm:rounded-2xl transition-all">
                            <input 
                                type="text" 
                                id="login" 
                                name="login" 
                                value="{{ old('login', old('phone')) }}" 
                                required 
                                autofocus 
                                class="w-full pl-3.5 pr-10 py-2.5 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 text-xs sm:text-sm focus:outline-none focus:bg-white focus:border-sky-400 transition-all font-sans shadow-xs"
                                placeholder="Contoh: 1711221 atau 081234567890"
                                autocomplete="username"
                            >
                            <!-- Right Icon -->
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-sky-500">
                                <iconify-icon icon="solar:letter-bold" width="18"></iconify-icon>
                            </div>
                        </div>
                    </div>

                    <!-- Auxiliary Row: Remember & Help -->
                    <div class="flex items-center justify-between text-[11px] pt-0.5 px-0.5">
                        <label class="flex items-center gap-1.5 cursor-pointer text-slate-500 hover:text-slate-700 select-none">
                            <input type="checkbox" name="remember" checked class="w-3.5 h-3.5 rounded text-sky-500 border-slate-300 focus:ring-sky-400 accent-sky-500">
                            <span>Ingat Saya</span>
                        </label>
                        <a href="https://wa.me/628112293888?text=Halo%20Admin%20MSN,%20saya%20butuh%20bantuan%20login%20portal%20pelanggan" target="_blank" class="font-semibold text-sky-600 hover:text-sky-700 hover:underline">
                            Butuh Bantuan?
                        </a>
                    </div>

                    <!-- Submit Button (Pill shaped gradient matching Halo Dashboard theme) -->
                    <div class="pt-1 text-center">
                        <button 
                            type="submit" 
                            id="btnSubmit"
                            class="w-full sm:w-44 py-2.5 px-6 rounded-full bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-extrabold text-xs sm:text-sm uppercase tracking-wider transition-all duration-200 shadow-md shadow-sky-500/25 hover:shadow-lg hover:shadow-sky-500/35 active:scale-95 flex items-center justify-center gap-2 cursor-pointer mx-auto disabled:opacity-80 disabled:cursor-not-allowed disabled:pointer-events-none"
                        >
                            <span id="btnText" class="inline-flex items-center justify-center">
                                LOGIN
                            </span>
                            <span id="btnLoading" class="hidden items-center justify-center gap-1.5">
                                <svg class="animate-spin h-3.5 w-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-[11px]">MEMPROSES...</span>
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Social / Quick Help Buttons -->
                <div class="flex items-center justify-center gap-3 pt-0.5">
                    <a href="https://wa.me/628112293888" target="_blank" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white border border-slate-200/80 shadow-xs flex items-center justify-center text-emerald-500 hover:scale-110 hover:bg-emerald-50 transition-all" title="WhatsApp Customer Service">
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
                        <a href="https://wa.me/628112293888?text=Halo%20Admin%20MSN,%20saya%20ingin%20pasang%20internet%20baru" target="_blank" class="font-bold text-sky-600 hover:underline">
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

    <!-- Script Handling Loading State -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.getElementById('loginForm');
            const btnSubmit = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');

            if (loginForm && btnSubmit) {
                loginForm.addEventListener('submit', function (e) {
                    if (btnSubmit.disabled) {
                        e.preventDefault();
                        return false;
                    }

                    // Disable button and switch to loading state
                    btnSubmit.disabled = true;
                    if (btnText) btnText.classList.add('hidden');
                    if (btnLoading) {
                        btnLoading.classList.remove('hidden');
                        btnLoading.classList.add('inline-flex');
                    }
                });
            }
        });
    </script>
</body>
</html>
