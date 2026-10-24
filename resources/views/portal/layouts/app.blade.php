<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MyMSN') — Customer Self-Care | PT Media Solusi Network</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-icon.png') }}">

    <!-- PWA Web App Manifest & Mobile App Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0284c7">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="MyMSN">
    <link rel="apple-touch-icon" href="{{ asset('images/icons/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/icons/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('images/icons/icon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="512x512" href="{{ asset('images/icons/icon-512x512.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans, Outfit, Inter, JetBrains Mono (Streamlined Weights) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    
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
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>

    <!-- DNS Prefetch & Preconnect for Fast External Asset Handshake -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="dns-prefetch" href="//code.iconify.design">
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">

    <!-- Iconify Web Component (Deferred Non-Blocking) -->
    <script defer src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    
    <!-- Alpine.js (Deferred) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- SweetAlert2 (Deferred) -->
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Portal Custom CSS (Cached by file modification time) -->
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}?v={{ file_exists(public_path('css/portal.css')) ? filemtime(public_path('css/portal.css')) : '1.0' }}">

    <style>
        [x-cloak] {
            display: none !important;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Smooth Content Entrance Animation */
        @keyframes portalPageEnter {
            0% {
                opacity: 0;
                transform: translateY(5px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .portal-page-enter {
            animation: portalPageEnter 0.22s cubic-bezier(0.16, 1, 0.3, 1) both;
            will-change: opacity, transform;
        }

        /* Instant Non-blocking Top Progress Indicator (Ultra-fast navigation) */
        #portal-page-loader {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, #0284c7, #38bdf8, #0ea5e9);
            z-index: 99999;
            transition: width 0.2s cubic-bezier(0.1, 0.9, 0.2, 1), opacity 0.25s ease;
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.8);
            pointer-events: none;
            opacity: 0;
        }
        #portal-page-loader.active {
            opacity: 1;
            width: 80%;
        }
        #portal-page-loader.finish {
            width: 100%;
            opacity: 0;
        }

        /* High-Performance Portal Card (Instant 60-120 FPS Rendering) */
        .portal-card {
            background: rgba(255, 255, 255, 0.94) !important;
            border: 1px solid rgba(226, 232, 240, 0.85) !important;
            box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04), inset 0 1px 0 0 rgba(255, 255, 255, 0.9) !important;
            transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
            contain: layout style;
            transform: translateZ(0);
        }

        .portal-card-hover:hover {
            background: #ffffff !important;
            border-color: rgba(56, 189, 248, 0.5) !important;
            box-shadow: 0 12px 28px -4px rgba(2, 132, 199, 0.12), inset 0 1px 0 0 #ffffff !important;
            transform: translateY(-2px) translateZ(0);
        }

        /* Hero Network Pass (Dark Oceanic Gradient) */
        .hero-network-card {
            background: linear-gradient(135deg, #091322 0%, #0f172a 50%, #0e7490 100%) !important;
            border: 1px solid rgba(56, 189, 248, 0.35) !important;
            box-shadow: 0 12px 32px -6px rgba(2, 132, 199, 0.25), inset 0 1px 1px rgba(255, 255, 255, 0.15) !important;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            contain: paint layout;
            transform: translateZ(0);
        }

        /* Toast notification */
        #portal-toast {
            visibility: hidden;
            opacity: 0;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            transform: translateY(20px);
        }
        #portal-toast.show {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="min-h-full flex flex-col font-sans antialiased text-slate-800 portal-bg pb-20 md:pb-8" x-data="{ userDropdown: false }">

    <!-- Instant Non-blocking Top Page Loading Indicator -->
    <div id="portal-page-loader"></div>

    <!-- Top Portal Header -->
    <header class="sticky top-0 z-40 glass-header shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-18">
                
                <!-- Left: Brand Logo & Portal Badge -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('portal.dashboard') }}" class="flex items-center transition-transform hover:opacity-90">
                        <img src="{{ asset('images/logo/logo-msn.png') }}" alt="PT MSN" class="h-8 sm:h-9 w-auto object-contain">
                    </a>
                    <div class="hidden sm:flex items-center pl-3 border-l border-slate-200">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100/90 border border-slate-200/80 shadow-2xs">
                            <span class="font-brand font-black text-xs tracking-tight"><span class="text-sky-600 font-extrabold">My</span><span class="text-slate-800">MSN</span></span>
                            <span class="text-[9px] font-heading font-bold text-slate-500 uppercase tracking-wider">Self-Care</span>
                        </span>
                    </div>
                </div>

                <!-- Center: Navigation Links (Desktop) -->
                <nav class="hidden md:flex items-center gap-1 bg-slate-100/90 border border-slate-200 p-1 rounded-2xl">
                    <a href="{{ route('portal.dashboard') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-heading font-semibold transition-all {{ request()->routeIs('portal.dashboard') ? 'bg-white text-sky-700 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:home-smile-bold" width="15" class="{{ request()->routeIs('portal.dashboard') ? 'text-sky-600' : 'text-slate-400' }}"></iconify-icon>
                            <span>Beranda</span>
                        </span>
                    </a>
                    <a href="{{ route('portal.billing.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-heading font-semibold transition-all {{ request()->routeIs('portal.billing.*') ? 'bg-white text-sky-700 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:wallet-money-bold" width="15" class="{{ request()->routeIs('portal.billing.*') ? 'text-sky-600' : 'text-slate-400' }}"></iconify-icon>
                            <span>Tagihan</span>
                        </span>
                    </a>
                    <a href="{{ route('portal.tickets.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-heading font-semibold transition-all {{ request()->routeIs('portal.tickets.*') ? 'bg-white text-sky-700 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:ticket-bold" width="15" class="{{ request()->routeIs('portal.tickets.*') ? 'text-sky-600' : 'text-slate-400' }}"></iconify-icon>
                            <span>Bantuan & Tiket</span>
                        </span>
                    </a>
                    <a href="{{ route('portal.profile') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-heading font-semibold transition-all {{ request()->routeIs('portal.profile') ? 'bg-white text-sky-700 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:user-circle-bold" width="15" class="{{ request()->routeIs('portal.profile') ? 'text-sky-600' : 'text-slate-400' }}"></iconify-icon>
                            <span>Profil Akun</span>
                        </span>
                    </a>
                </nav>

                <!-- Right: User Menu -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <!-- User Profile Dropdown -->
                    <div class="relative" @click.outside="userDropdown = false">
                        <button @click="userDropdown = !userDropdown" class="flex items-center gap-1.5 sm:gap-2 px-2 py-1 sm:px-2.5 sm:py-1 rounded-2xl bg-white/90 border border-slate-200/90 hover:border-slate-300 hover:shadow-xs transition-all">
                            <div class="text-right pl-1 pr-0.5 min-w-0">
                                <div class="text-[11px] sm:text-xs font-heading font-bold text-slate-800 max-w-[95px] sm:max-w-[160px] truncate leading-tight" title="{{ Auth::guard('customer')->user()->name }}">
                                    {{ Auth::guard('customer')->user()->name ?? 'Pelanggan' }}
                                </div>
                                <div class="text-[9px] sm:text-[10px] font-mono text-slate-500 leading-tight truncate max-w-[95px] sm:max-w-[160px]">
                                    {{ Auth::guard('customer')->user()->customer_id ? 'ID: ' . Auth::guard('customer')->user()->customer_id : Auth::guard('customer')->user()->phone }}
                                </div>
                            </div>
                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-gradient-to-tr from-sky-600 to-cyan-500 text-white flex items-center justify-center font-heading font-extrabold text-xs sm:text-sm shadow-xs ring-1 ring-sky-100 shrink-0">
                                {{ Auth::guard('customer')->user()->initial ?? 'P' }}
                            </div>
                            <iconify-icon icon="solar:alt-arrow-down-linear" class="text-slate-400 text-[10px] sm:text-xs transition-transform duration-200 ml-0.5" :class="userDropdown ? 'rotate-180' : ''"></iconify-icon>
                        </button>

                        <!-- Dropdown Content (Logout Only) -->
                        <div 
                            x-show="userDropdown" 
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 rounded-2xl bg-white/95 backdrop-blur-md border border-slate-200 shadow-xl p-2 z-50 divide-y divide-slate-100"
                            style="display: none;"
                        >
                            <div class="px-3 py-2.5">
                                <div class="text-xs font-heading font-bold text-slate-800 leading-tight truncate">{{ Auth::guard('customer')->user()->name }}</div>
                                <div class="text-[11px] font-mono text-sky-600 font-semibold mt-0.5">ID: {{ Auth::guard('customer')->user()->customer_id ?? '-' }}</div>
                            </div>
                            <div class="pt-1">
                                <a href="{{ route('portal.logout') }}" class="w-full flex items-center gap-2 px-3 py-2 text-xs text-rose-600 hover:bg-rose-50 rounded-xl text-left font-semibold transition-colors">
                                    <iconify-icon icon="solar:logout-2-bold" width="16"></iconify-icon>
                                    <span>Keluar (Logout)</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- Main Body Container -->
    <main class="relative z-10 flex-1 portal-page-enter max-w-7xl w-full mx-auto px-3 sm:px-6 lg:px-8 py-3 sm:py-6 pb-32 md:pb-6">
        
        <!-- Modern Flash Alerts (Interactive, Dismissible & Auto-Dismissing) -->
        <div 
            x-data="{ 
                showSuccess: {{ (session('success') && !session('wa_confirm_url')) ? 'true' : 'false' }}, 
                showInfo: {{ session('info') ? 'true' : 'false' }}, 
                showError: {{ (isset($errors) && $errors->any()) ? 'true' : 'false' }} 
            }" 
            class="space-y-2.5 mb-3 sm:mb-5"
        >
            @if(session('success') && !session('wa_confirm_url'))
                <div 
                    x-show="showSuccess"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2 scale-98"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 -translate-y-2 scale-98"
                    x-init="setTimeout(() => showSuccess = false, 6000)"
                    class="p-3 sm:p-3.5 rounded-2xl bg-gradient-to-r from-emerald-50/95 via-teal-50/95 to-emerald-50/95 border border-emerald-300/80 text-emerald-950 flex items-center justify-between gap-3 shadow-md shadow-emerald-500/5 backdrop-blur-md"
                >
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-xs ring-2 ring-emerald-200/70">
                            <iconify-icon icon="solar:check-circle-bold" class="text-lg"></iconify-icon>
                        </div>
                        <div class="text-xs sm:text-sm font-medium leading-snug">
                            {{ session('success') }}
                        </div>
                    </div>
                    <button 
                        type="button" 
                        @click="showSuccess = false" 
                        class="p-1 rounded-xl text-emerald-600 hover:text-emerald-900 hover:bg-emerald-200/50 transition-colors shrink-0 cursor-pointer"
                        title="Tutup Notifikasi"
                    >
                        <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                    </button>
                </div>
            @endif

            @if(session('info'))
                <div 
                    x-show="showInfo"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2 scale-98"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 -translate-y-2 scale-98"
                    x-init="setTimeout(() => showInfo = false, 6000)"
                    class="p-3 sm:p-3.5 rounded-2xl bg-gradient-to-r from-sky-50/95 via-blue-50/95 to-sky-50/95 border border-sky-300/80 text-sky-950 flex items-center justify-between gap-3 shadow-md shadow-sky-500/5 backdrop-blur-md"
                >
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-xl bg-sky-600 text-white flex items-center justify-center shrink-0 shadow-xs ring-2 ring-sky-200/70">
                            <iconify-icon icon="solar:info-circle-bold" class="text-lg"></iconify-icon>
                        </div>
                        <div class="text-xs sm:text-sm font-medium leading-snug">
                            {{ session('info') }}
                        </div>
                    </div>
                    <button 
                        type="button" 
                        @click="showInfo = false" 
                        class="p-1 rounded-xl text-sky-600 hover:text-sky-900 hover:bg-sky-200/50 transition-colors shrink-0 cursor-pointer"
                        title="Tutup Notifikasi"
                    >
                        <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                    </button>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div 
                    x-show="showError"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2 scale-98"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 -translate-y-2 scale-98"
                    class="p-3.5 sm:p-4 rounded-2xl bg-gradient-to-r from-rose-50/95 via-red-50/95 to-rose-50/95 border border-rose-300/80 text-rose-950 shadow-md shadow-rose-500/5 backdrop-blur-md"
                >
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-2.5 min-w-0">
                            <div class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center shrink-0 shadow-xs ring-2 ring-rose-200/70 mt-0.5">
                                <iconify-icon icon="solar:danger-circle-bold" class="text-lg"></iconify-icon>
                            </div>
                            <div class="space-y-1">
                                <span class="font-heading font-bold text-xs sm:text-sm block text-rose-950">Harap perhatikan input berikut:</span>
                                <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-800">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button 
                            type="button" 
                            @click="showError = false" 
                            class="p-1 rounded-xl text-rose-600 hover:text-rose-900 hover:bg-rose-200/50 transition-colors shrink-0 cursor-pointer"
                            title="Tutup Notifikasi"
                        >
                            <iconify-icon icon="solar:close-circle-bold" class="text-xl"></iconify-icon>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        @yield('content')

    </main>

    <!-- Floating Mobile Island Dock (Dark Oceanic Island - Wider & Slimmer) -->
    <div class="md:hidden fixed bottom-3 inset-x-0 z-40 max-w-[390px] w-full mx-auto px-4">
        <div class="floating-mobile-dock">
            <div class="grid grid-cols-4 gap-1 items-center text-center">
                <!-- Beranda -->
                <a href="{{ route('portal.dashboard') }}" class="dock-item {{ request()->routeIs('portal.dashboard') ? 'dock-item-active' : '' }} active:scale-95">
                    <div class="dock-icon">
                        <iconify-icon icon="solar:home-smile-bold" width="22"></iconify-icon>
                    </div>
                    <span class="dock-label font-heading">Beranda</span>
                    @if(request()->routeIs('portal.dashboard'))
                        <span class="dock-pill-indicator"></span>
                    @endif
                </a>

                <!-- Tagihan -->
                <a href="{{ route('portal.billing.index') }}" class="dock-item {{ request()->routeIs('portal.billing.*') ? 'dock-item-active' : '' }} active:scale-95">
                    <div class="dock-icon">
                        <iconify-icon icon="solar:wallet-money-bold" width="22"></iconify-icon>
                    </div>
                    <span class="dock-label font-heading">Tagihan</span>
                    @if(request()->routeIs('portal.billing.*'))
                        <span class="dock-pill-indicator"></span>
                    @endif
                </a>

                <!-- Tiket -->
                <a href="{{ route('portal.tickets.index') }}" class="dock-item {{ request()->routeIs('portal.tickets.*') ? 'dock-item-active' : '' }} active:scale-95">
                    <div class="dock-icon">
                        <iconify-icon icon="solar:ticket-bold" width="22"></iconify-icon>
                    </div>
                    <span class="dock-label font-heading">Tiket</span>
                    @if(request()->routeIs('portal.tickets.*'))
                        <span class="dock-pill-indicator"></span>
                    @endif
                </a>

                <!-- Profil -->
                <a href="{{ route('portal.profile') }}" class="dock-item {{ request()->routeIs('portal.profile') ? 'dock-item-active' : '' }} active:scale-95">
                    <div class="dock-icon">
                        <iconify-icon icon="solar:user-circle-bold" width="22"></iconify-icon>
                    </div>
                    <span class="dock-label font-heading">Profil</span>
                    @if(request()->routeIs('portal.profile'))
                        <span class="dock-pill-indicator"></span>
                    @endif
                </a>
            </div>
        </div>
    </div>

    @auth('customer')
        @include('portal.components.onboarding-tour')
    @endauth

    <!-- Toast Notification for Copy / Actions -->
    <div id="portal-toast" class="fixed bottom-20 md:bottom-8 right-1/2 translate-x-1/2 md:translate-x-0 md:right-8 z-50 flex items-center gap-2.5 px-4 py-2.5 rounded-2xl bg-slate-900 text-white text-xs font-heading font-medium shadow-2xl border border-slate-700 pointer-events-none">
        <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400 text-base shrink-0"></iconify-icon>
        <span id="portal-toast-msg">Tersalin ke clipboard</span>
    </div>

    <!-- Global Scripts: Clipboard & Auto Logout -->
    <script>
        // Global Copy to Clipboard Helper
        window.copyToClipboard = function(text, label = 'Teks') {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text);
            } else {
                let textArea = document.createElement("textarea");
                textArea.value = text;
                textArea.style.position = "fixed";
                textArea.style.left = "-999999px";
                textArea.style.top = "-999999px";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                document.execCommand('copy');
                textArea.remove();
            }

            const toast = document.getElementById('portal-toast');
            const toastMsg = document.getElementById('portal-toast-msg');
            if (toast && toastMsg) {
                toastMsg.innerText = label + ' berhasil disalin!';
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 2200);
            }
        };

        // Batas waktu inaktivitas 1 jam (3600 detik)
        (function() {
            const TIMEOUT_MS = 3600 * 1000;
            let idleTimer;

            function resetIdleTimer() {
                clearTimeout(idleTimer);
                idleTimer = setTimeout(function() {
                    window.location.href = '{{ route("portal.logout") }}';
                }, TIMEOUT_MS);
            }

            const events = ['mousedown', 'mousemove', 'keydown', 'scroll', 'touchstart'];
            events.forEach(function(evt) {
                window.addEventListener(evt, resetIdleTimer, { passive: true });
            });

            resetIdleTimer();
        })();

        // Non-Blocking Top Progress Bar saat navigasi halaman
        (function() {
            const loader = document.getElementById('portal-page-loader');
            if (!loader) return;

            let loaderTimeout = null;

            function startLoader() {
                clearTimeout(loaderTimeout);
                loader.classList.remove('finish');
                loader.classList.add('active');
                loaderTimeout = setTimeout(finishLoader, 8000);
            }

            function finishLoader() {
                clearTimeout(loaderTimeout);
                loader.classList.add('finish');
                setTimeout(() => {
                    loader.classList.remove('active', 'finish');
                    loader.style.width = '0%';
                }, 260);
            }

            // Visual Loading Bar saat user mengklik link navigasi
            document.addEventListener('click', function(e) {
                const a = e.target.closest('a[href]');
                if (!a || !a.href || a.target === '_blank' || a.hasAttribute('download')) return;

                const href = a.getAttribute('href');
                if (!href || href.startsWith('javascript:') || href.startsWith('#') || href.startsWith('data:')) return;

                try {
                    const targetUrl = new URL(a.href, window.location.origin);
                    const currentUrl = new URL(window.location.href);

                    if (targetUrl.origin === currentUrl.origin) {
                        if (targetUrl.pathname !== currentUrl.pathname || targetUrl.search !== currentUrl.search) {
                            startLoader();
                        }
                    }
                } catch(err) {}
            });

            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (!form || form.target === '_blank') return;
                startLoader();
            });

            window.addEventListener('pageshow', finishLoader);
            if (document.readyState === 'complete') {
                finishLoader();
            } else {
                window.addEventListener('load', finishLoader);
            }
        })();

        // Ringan & Cepat: Haptic feedback untuk perangkat sentuh tanpa DOM reflow
        document.addEventListener('pointerdown', function(e) {
            if (e.isTrusted && e.pointerType === 'touch' && typeof navigator.vibrate === 'function') {
                try { navigator.vibrate(10); } catch(err) {}
            }
        }, { passive: true });
    </script>

    <!-- PWA Installation Floating Banner & Service Worker Script -->
    <div id="pwa-install-banner" class="fixed bottom-5 left-4 right-4 sm:left-auto sm:right-6 sm:w-96 z-50 transition-all duration-300 transform translate-y-24 opacity-0 pointer-events-none">
        <div class="bg-slate-900/95 backdrop-blur-md text-white p-4 rounded-2xl shadow-2xl border border-sky-500/30 flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700/60 p-1.5 flex items-center justify-center shrink-0 shadow-inner">
                <img src="{{ asset('images/icons/icon-192x192.png') }}" alt="MyMSN App" class="w-full h-full object-contain rounded-lg">
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-1.5">
                    <h4 class="text-xs font-bold text-white tracking-tight">Pasang Aplikasi MyMSN</h4>
                    <span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-sky-500/20 text-sky-300 border border-sky-500/30">PWA</span>
                </div>
                <p class="text-[11px] text-slate-300 line-clamp-1 mt-0.5" id="pwa-desc-text">Akses tagihan &amp; lapor kendala langsung dari layar HP.</p>
            </div>
            <div class="flex items-center gap-1.5 shrink-0">
                <button id="pwa-btn-install" type="button" class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-400 hover:to-blue-500 text-white text-xs font-bold shadow-md shadow-sky-500/20 active:scale-95 transition cursor-pointer">
                    Install
                </button>
                <button id="pwa-btn-dismiss" type="button" class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition cursor-pointer" aria-label="Tutup">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        // PWA Service Worker Registration & Install Handler
        (function() {
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js').then(function(reg) {
                        console.log('[PWA] Service Worker terdaftar dengan scope:', reg.scope);
                    }).catch(function(err) {
                        console.warn('[PWA] Service Worker gagal didaftarkan:', err);
                    });
                });
            }

            let deferredPrompt = null;
            const banner = document.getElementById('pwa-install-banner');
            const btnInstall = document.getElementById('pwa-btn-install');
            const btnDismiss = document.getElementById('pwa-btn-dismiss');
            const descText = document.getElementById('pwa-desc-text');

            // Cek apakah user pernah menutup banner dalam 7 hari terakhir
            const isDismissed = localStorage.getItem('pwa_install_dismissed');
            const isDismissedValid = isDismissed && (Date.now() - parseInt(isDismissed, 10) < 7 * 86400 * 1000);

            // Cek apakah sudah berjalan di standalone mode (sudah diinstall)
            const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;

            function showBanner() {
                if (isStandalone || isDismissedValid || !banner) return;
                banner.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
                banner.classList.add('translate-y-0', 'opacity-100');
            }

            function hideBanner() {
                if (!banner) return;
                banner.classList.remove('translate-y-0', 'opacity-100');
                banner.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
            }

            // Android / Chromium Browser beforeinstallprompt event
            window.addEventListener('beforeinstallprompt', function(e) {
                e.preventDefault();
                deferredPrompt = e;
                window.pwaDeferredPrompt = e;
                window.dispatchEvent(new CustomEvent('pwa-prompt-available'));
                // Tampilkan banner dengan delay sedikit agar halaman selesai render
                setTimeout(showBanner, 2500);
            });

            // Klik tombol Install
            if (btnInstall) {
                btnInstall.addEventListener('click', async function() {
                    if (deferredPrompt) {
                        deferredPrompt.prompt();
                        const { outcome } = await deferredPrompt.userChoice;
                        console.log('[PWA] Pilihan user:', outcome);
                        deferredPrompt = null;
                        hideBanner();
                    } else {
                        // Jika di iOS Safari
                        const isIos = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
                        if (isIos) {
                            alert('Untuk memasang di iPhone/iPad:\n1. Ketuk tombol Bagikan (Share / tanda kotak panah ke atas di bawah layar Safari).\n2. Geser dan pilih "Tambah ke Layar Utama" (Add to Home Screen).');
                        } else {
                            hideBanner();
                        }
                    }
                });
            }

            // Klik tombol Dismiss (Tutup)
            if (btnDismiss) {
                btnDismiss.addEventListener('click', function() {
                    hideBanner();
                    localStorage.setItem('pwa_install_dismissed', Date.now().toString());
                });
            }

            // Deteksi ketika user selesai install
            window.addEventListener('appinstalled', function() {
                console.log('[PWA] Aplikasi MyMSN berhasil diinstall!');
                localStorage.setItem('pwa_installed', 'true');
                window.dispatchEvent(new CustomEvent('pwa-installed-success'));
                hideBanner();
            });

            // Deteksi perangkat iOS jika belum standalone
            const isIos = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
            if (isIos && !isStandalone && !isDismissedValid) {
                if (descText) descText.textContent = 'Ketuk Bagikan lalu Tambah ke Layar Utama.';
                setTimeout(showBanner, 4000);
            }
        })();
    </script>

    @stack('scripts')
</body>
</html>



