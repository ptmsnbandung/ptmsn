<!DOCTYPE html>
<html lang="id" class="h-full bg-sky-400">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyMSN — Customer Self-Care | PT Media Solusi Network</title>
    
    <!-- Favicon -->
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
                            navy: '#0f172a',
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
        body {
            background: linear-gradient(180deg, #38bdf8 0%, #60cdff 35%, #56c2f5 65%, #38bdf8 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
        }

        .login-sheet {
            border-top-left-radius: 40px;
            border-top-right-radius: 40px;
            box-shadow: 0 -10px 40px -5px rgba(2, 132, 199, 0.25);
        }

        @media (min-width: 640px) {
            .login-sheet {
                border-radius: 36px;
                box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
            }
        }

        .input-glow:focus-within {
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between sm:justify-center items-center text-slate-800 antialiased sm:p-4">

    <!-- Container wrapper (App Shell) -->
    <div class="w-full max-w-[430px] flex flex-col justify-between min-h-screen sm:min-h-[720px] sm:bg-gradient-to-b sm:from-[#38bdf8] sm:via-[#5bcafc] sm:to-[#38bdf8] sm:rounded-[44px] sm:shadow-2xl sm:border-[5px] sm:border-white/30 overflow-hidden relative">

        <!-- TOP SECTION: Logo & Brand Header -->
        <div class="flex-1 flex flex-col items-center justify-center pt-10 pb-8 px-6 text-center z-10">
            
            <!-- White Icon Container with Soft Drop Shadow -->
            <a href="{{ route('home') }}" class="group block mb-3 transform hover:scale-105 transition-transform duration-300">
                <div class="relative w-24 h-24 sm:w-28 sm:h-28 mx-auto flex items-center justify-center">
                    <!-- Subtle Glow Ring -->
                    <div class="absolute inset-0 bg-white/30 rounded-full blur-xl animate-pulse"></div>
                    
                    <!-- White Logo / Emblem Graphic -->
                    <div class="relative w-full h-full rounded-3xl bg-white/20 backdrop-blur-md border border-white/50 shadow-lg flex items-center justify-center p-4">
                        <img 
                            src="{{ asset('images/logo/logo-msn-white.png') }}" 
                            alt="PT Media Solusi Network" 
                            class="max-h-full max-w-full object-contain filter drop-shadow-md"
                            onerror="this.onerror=null; this.src='{{ asset('images/logo/logo-icon.png') }}';"
                        >
                    </div>
                </div>
            </a>

            <!-- Brand Name Typography -->
            <h1 class="text-white font-heading font-extrabold text-2xl sm:text-3xl tracking-tight drop-shadow-md flex items-center justify-center gap-1.5">
                <span>My</span><span class="text-sky-100">MSN</span>
            </h1>
            <p class="text-white/90 text-xs font-medium tracking-wide uppercase mt-0.5 drop-shadow-xs">
                Customer Self-Care Portal
            </p>
        </div>

        <!-- BOTTOM SECTION: White Rounded Sheet Card -->
        <div class="login-sheet bg-white px-7 pt-8 pb-7 w-full flex-shrink-0 z-20">
            
            <!-- Card Header: WELCOME -->
            <div class="text-center mb-6">
                <h2 class="text-2xl sm:text-[26px] font-heading font-black tracking-widest text-[#4f7cf7] uppercase">
                    WELCOME
                </h2>
                <p class="text-xs text-slate-400 font-medium mt-1">
                    Silakan masuk dengan akun internet Anda
                </p>
            </div>

            <!-- Alerts Container -->
            @if(session('warning'))
                <div class="mb-4 p-3 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-start gap-2 animate-pulse">
                    <iconify-icon icon="solar:clock-circle-bold" class="text-base shrink-0 text-amber-500 mt-0.5"></iconify-icon>
                    <span class="leading-snug">{{ session('warning') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-4 p-3 rounded-2xl bg-sky-50 border border-sky-200 text-sky-900 text-xs flex items-start gap-2">
                    <iconify-icon icon="solar:info-circle-bold" class="text-base shrink-0 text-sky-500 mt-0.5"></iconify-icon>
                    <span class="leading-snug">{{ session('info') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs flex items-start gap-2">
                    <iconify-icon icon="solar:check-circle-bold" class="text-base shrink-0 text-emerald-500 mt-0.5"></iconify-icon>
                    <span class="leading-snug">{{ session('success') }}</span>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="mb-4 p-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-xs">
                    @foreach($errors->all() as $error)
                        <div class="flex items-start gap-2">
                            <iconify-icon icon="solar:danger-circle-bold" class="text-base shrink-0 text-rose-500 mt-0.5"></iconify-icon>
                            <span class="leading-snug">{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Form -->
            <form id="loginForm" action="{{ route('portal.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Input: Nomor Internet / WhatsApp -->
                <div>
                    <label for="login" class="block text-[11.5px] font-heading font-semibold text-slate-600 mb-1.5 pl-1">
                        Nomor Internet / WhatsApp
                    </label>
                    
                    <div class="relative input-glow rounded-2xl transition-all">
                        <input 
                            type="text" 
                            id="login" 
                            name="login" 
                            value="{{ old('login', old('phone')) }}" 
                            required 
                            autofocus 
                            class="w-full pl-4 pr-11 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:bg-white focus:border-sky-400 transition-all font-sans shadow-inner"
                            placeholder="Contoh: 1711221 atau 081234567890"
                            autocomplete="username"
                        >
                        <!-- Right Icon (matching sample style) -->
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-sky-400">
                            <iconify-icon icon="solar:letter-bold" width="20"></iconify-icon>
                        </div>
                    </div>
                </div>

                <!-- Auxiliary Row: Remember & Help -->
                <div class="flex items-center justify-between text-[11px] pt-0.5 px-1">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-500 hover:text-slate-700 select-none">
                        <input type="checkbox" name="remember" checked class="w-3.5 h-3.5 rounded-full text-sky-500 border-slate-300 focus:ring-sky-400 accent-sky-500">
                        <span>Ingat Saya</span>
                    </label>
                    <a href="https://wa.me/628112293888?text=Halo%20Admin%20MSN,%20saya%20butuh%20bantuan%20login%20portal%20pelanggan" target="_blank" class="font-medium text-[#4f7cf7] hover:underline">
                        Butuh Bantuan?
                    </a>
                </div>

                <!-- Submit Button (Pill shaped gradient matching sample image) -->
                <div class="pt-2 text-center">
                    <button 
                        type="submit" 
                        id="btnSubmit"
                        class="w-full sm:w-48 py-3 px-8 rounded-full bg-gradient-to-r from-sky-400 via-sky-500 to-[#4f7cf7] hover:from-sky-500 hover:to-[#3b66e3] text-white font-heading font-extrabold text-sm uppercase tracking-widest transition-all duration-200 shadow-md shadow-sky-400/40 hover:shadow-lg hover:shadow-sky-400/50 active:scale-95 flex items-center justify-center gap-2 cursor-pointer mx-auto disabled:opacity-80 disabled:cursor-not-allowed disabled:pointer-events-none"
                    >
                        <span id="btnText" class="inline-flex items-center justify-center">
                            LOGIN
                        </span>
                        <span id="btnLoading" class="hidden items-center justify-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-xs">LOADING...</span>
                        </span>
                    </button>
                </div>
            </form>

            <!-- Social / Help Badges (similar to Google / FB icons in sample) -->
            <div class="mt-6 flex items-center justify-center gap-4">
                <a href="https://wa.me/628112293888" target="_blank" class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200/80 shadow-xs flex items-center justify-center text-emerald-500 hover:scale-110 hover:bg-emerald-50 transition-all" title="WhatsApp Support">
                    <iconify-icon icon="logos:whatsapp-icon" width="20"></iconify-icon>
                </a>
                <a href="{{ route('home') }}" class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200/80 shadow-xs flex items-center justify-center text-sky-500 hover:scale-110 hover:bg-sky-50 transition-all" title="Website Resmi MSN">
                    <iconify-icon icon="solar:global-bold" width="20"></iconify-icon>
                </a>
            </div>

            <!-- Footer: Register / Web Link -->
            <div class="mt-5 text-center">
                <p class="text-[11px] text-slate-500">
                    Belum berlangganan? 
                    <a href="https://wa.me/628112293888?text=Halo%20Admin%20MSN,%20saya%20ingin%20pasang%20internet%20baru" target="_blank" class="font-bold text-[#4f7cf7] hover:underline">
                        Daftar Sekarang
                    </a>
                </p>
                <div class="mt-1.5">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-[10.5px] text-slate-400 hover:text-slate-600 transition-colors">
                        <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                        <span>Kembali ke Halaman Utama</span>
                    </a>
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
