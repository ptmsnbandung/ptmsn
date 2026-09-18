<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MyMSN') — Customer Self-Care | PT Media Solusi Network</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-icon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans, Outfit, Inter, JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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

    <!-- Iconify Web Component -->
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Portal Custom CSS (Cache Busted) -->
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}?v={{ time() }}">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Glassmorphic Portal Card */
        .portal-card {
            background: rgba(255, 255, 255, 0.78) !important;
            backdrop-filter: blur(16px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(16px) saturate(180%) !important;
            border: 1px solid rgba(255, 255, 255, 0.85) !important;
            box-shadow: 0 8px 32px 0 rgba(15, 23, 42, 0.04), inset 0 1px 0 0 rgba(255, 255, 255, 0.9) !important;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .portal-card-hover:hover {
            background: rgba(255, 255, 255, 0.92) !important;
            border-color: rgba(56, 189, 248, 0.45) !important;
            box-shadow: 0 14px 34px -4px rgba(2, 132, 199, 0.12), inset 0 1px 0 0 rgba(255, 255, 255, 1) !important;
            transform: translateY(-2px);
        }

        /* Hero Network Pass (Dark Oceanic Glassmorphism) */
        .hero-network-card {
            background: linear-gradient(135deg, rgba(9, 19, 34, 0.95) 0%, rgba(15, 23, 42, 0.90) 50%, rgba(14, 116, 144, 0.85) 100%) !important;
            backdrop-filter: blur(20px) saturate(190%) !important;
            -webkit-backdrop-filter: blur(20px) saturate(190%) !important;
            border: 1px solid rgba(56, 189, 248, 0.35) !important;
            box-shadow: 0 16px 36px -8px rgba(2, 132, 199, 0.28), inset 0 1px 1px rgba(255, 255, 255, 0.2) !important;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
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

    <!-- Custom Portal Preloader (Rotating Tab Logo) -->
    <div id="portal-preloader">
        <div class="loader-spinner-ring">
            <div class="w-14 h-14 rounded-full bg-white shadow-lg flex items-center justify-center p-2.5 z-10 border border-slate-100">
                <img src="{{ asset('images/logo/logo-icon.png') }}" alt="PT MSN" class="w-full h-full object-contain loader-logo-spin">
            </div>
        </div>
    </div>

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
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="font-brand font-extrabold text-xs text-sky-600">My</span><span class="font-brand font-black text-xs text-slate-800">MSN</span>
                            <span class="text-[9px] font-heading font-bold text-slate-500 uppercase tracking-wider ml-0.5">Self-Care</span>
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
                    <a href="{{ route('portal.tickets.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-heading font-semibold transition-all {{ request()->routeIs('portal.tickets.*') && !request()->routeIs('portal.tickets.create') ? 'bg-white text-sky-700 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:chat-round-dots-bold" width="15" class="{{ request()->routeIs('portal.tickets.*') && !request()->routeIs('portal.tickets.create') ? 'text-sky-600' : 'text-slate-400' }}"></iconify-icon>
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

                <!-- Right: Quick Action & User Menu -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('portal.tickets.create') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-bold text-xs transition-all shadow-xs active:scale-95">
                        <iconify-icon icon="solar:danger-triangle-bold" width="15" class="text-amber-300"></iconify-icon>
                        <span>Lapor Gangguan</span>
                    </a>

                    <!-- User Profile Dropdown -->
                    <div class="relative" @click.outside="userDropdown = false">
                        <button @click="userDropdown = !userDropdown" class="flex items-center gap-2 p-1 sm:px-2.5 sm:py-1 rounded-2xl bg-white/90 border border-slate-200/90 hover:border-slate-300 hover:shadow-xs transition-all">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-sky-600 to-cyan-500 text-white flex items-center justify-center font-heading font-extrabold text-sm shadow-xs ring-1 ring-sky-100">
                                {{ strtoupper(substr(Auth::guard('customer')->user()->name ?? 'P', 0, 1)) }}
                            </div>
                            <div class="hidden lg:block text-left pr-0.5">
                                <div class="text-xs font-heading font-bold text-slate-800 max-w-[120px] truncate leading-tight">
                                    {{ explode(' ', trim(Auth::guard('customer')->user()->name ?? 'Pelanggan'))[0] }}
                                </div>
                                <div class="text-[10px] font-mono text-slate-500 leading-tight">
                                    {{ Auth::guard('customer')->user()->customer_id ? 'ID: ' . Auth::guard('customer')->user()->customer_id : Auth::guard('customer')->user()->phone }}
                                </div>
                            </div>
                            <iconify-icon icon="solar:alt-arrow-down-linear" class="text-slate-400 text-xs transition-transform duration-200 ml-0.5 hidden sm:block" :class="userDropdown ? 'rotate-180' : ''"></iconify-icon>
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
    <main class="relative z-10 flex-1 max-w-7xl w-full mx-auto px-3 sm:px-6 lg:px-8 py-3 sm:py-6">
        
        <!-- Flash Alerts -->
        @if(session('success'))
            <div class="mb-3 sm:mb-5 p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-emerald-50/90 backdrop-blur-md border border-emerald-200 text-emerald-800 flex items-center justify-between gap-2.5 text-xs sm:text-sm font-sans shadow-xs">
                <div class="flex items-center gap-2.5">
                    <iconify-icon icon="solar:check-circle-bold" class="text-emerald-500 text-base sm:text-xl shrink-0"></iconify-icon>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-3 sm:mb-5 p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-sky-50/90 backdrop-blur-md border border-sky-200 text-sky-800 flex items-center justify-between gap-2.5 text-xs sm:text-sm font-sans shadow-xs">
                <div class="flex items-center gap-2.5">
                    <iconify-icon icon="solar:info-circle-bold" class="text-sky-500 text-base sm:text-xl shrink-0"></iconify-icon>
                    <span class="font-medium">{{ session('info') }}</span>
                </div>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="mb-3 sm:mb-5 p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-rose-50/90 backdrop-blur-md border border-rose-200 text-rose-800 text-xs sm:text-sm font-sans shadow-xs">
                <div class="font-bold mb-1 flex items-center gap-2">
                    <iconify-icon icon="solar:danger-circle-bold" class="text-base sm:text-lg text-rose-500"></iconify-icon>
                    <span>Harap perhatikan input berikut:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-700 pl-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </main>

    <!-- Floating Mobile Island Dock (iOS Style Glassmorphism) -->
    <div class="md:hidden fixed bottom-3 left-3 right-3 z-40 max-w-sm mx-auto">
        <div class="floating-mobile-dock">
            <div class="grid grid-cols-4 gap-1 items-center text-center">
                <!-- Beranda -->
                <a href="{{ route('portal.dashboard') }}" class="flex flex-col items-center justify-center gap-0.5 py-1.5 px-1 rounded-2xl transition-all duration-200 active:scale-90 {{ request()->routeIs('portal.dashboard') ? 'dock-item-active' : 'dock-item-inactive' }}">
                    <div class="relative flex items-center justify-center">
                        <iconify-icon icon="solar:home-smile-bold" width="21" class="{{ request()->routeIs('portal.dashboard') ? 'text-sky-600' : 'text-slate-400' }}"></iconify-icon>
                        @if(request()->routeIs('portal.dashboard'))
                            <span class="absolute -top-0.5 -right-0.5 w-1.5 h-1.5 rounded-full bg-sky-500 ring-2 ring-white"></span>
                        @endif
                    </div>
                    <span class="text-[10px] font-heading {{ request()->routeIs('portal.dashboard') ? 'font-extrabold text-sky-700' : 'font-medium' }}">Beranda</span>
                </a>

                <!-- Tagihan -->
                <a href="{{ route('portal.billing.index') }}" class="flex flex-col items-center justify-center gap-0.5 py-1.5 px-1 rounded-2xl transition-all duration-200 active:scale-90 {{ request()->routeIs('portal.billing.*') ? 'dock-item-active' : 'dock-item-inactive' }}">
                    <div class="relative flex items-center justify-center">
                        <iconify-icon icon="solar:wallet-money-bold" width="21" class="{{ request()->routeIs('portal.billing.*') ? 'text-sky-600' : 'text-slate-400' }}"></iconify-icon>
                        @if(request()->routeIs('portal.billing.*'))
                            <span class="absolute -top-0.5 -right-0.5 w-1.5 h-1.5 rounded-full bg-sky-500 ring-2 ring-white"></span>
                        @endif
                    </div>
                    <span class="text-[10px] font-heading {{ request()->routeIs('portal.billing.*') ? 'font-extrabold text-sky-700' : 'font-medium' }}">Tagihan</span>
                </a>

                <!-- Tiket NOC -->
                <a href="{{ route('portal.tickets.index') }}" class="flex flex-col items-center justify-center gap-0.5 py-1.5 px-1 rounded-2xl transition-all duration-200 active:scale-90 {{ request()->routeIs('portal.tickets.*') ? 'dock-item-active' : 'dock-item-inactive' }}">
                    <div class="relative flex items-center justify-center">
                        <iconify-icon icon="solar:chat-round-dots-bold" width="21" class="{{ request()->routeIs('portal.tickets.*') ? 'text-sky-600' : 'text-slate-400' }}"></iconify-icon>
                        @if(request()->routeIs('portal.tickets.*'))
                            <span class="absolute -top-0.5 -right-0.5 w-1.5 h-1.5 rounded-full bg-sky-500 ring-2 ring-white"></span>
                        @endif
                    </div>
                    <span class="text-[10px] font-heading {{ request()->routeIs('portal.tickets.*') ? 'font-extrabold text-sky-700' : 'font-medium' }}">Tiket NOC</span>
                </a>

                <!-- Profil -->
                <a href="{{ route('portal.profile') }}" class="flex flex-col items-center justify-center gap-0.5 py-1.5 px-1 rounded-2xl transition-all duration-200 active:scale-90 {{ request()->routeIs('portal.profile') ? 'dock-item-active' : 'dock-item-inactive' }}">
                    <div class="relative flex items-center justify-center">
                        <iconify-icon icon="solar:user-circle-bold" width="21" class="{{ request()->routeIs('portal.profile') ? 'text-sky-600' : 'text-slate-400' }}"></iconify-icon>
                        @if(request()->routeIs('portal.profile'))
                            <span class="absolute -top-0.5 -right-0.5 w-1.5 h-1.5 rounded-full bg-sky-500 ring-2 ring-white"></span>
                        @endif
                    </div>
                    <span class="text-[10px] font-heading {{ request()->routeIs('portal.profile') ? 'font-extrabold text-sky-700' : 'font-medium' }}">Profil</span>
                </a>
            </div>
        </div>
    </div>

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

        // Preloader Dismissal Handler
        window.addEventListener('load', function() {
            const preloader = document.getElementById('portal-preloader');
            if (preloader) {
                setTimeout(function() {
                    preloader.classList.add('loaded');
                }, 300);
            }
        });

        // Safety fallback: dismiss preloader after 2.5s if not already dismissed
        setTimeout(function() {
            const preloader = document.getElementById('portal-preloader');
            if (preloader && !preloader.classList.contains('loaded')) {
                preloader.classList.add('loaded');
            }
        }, 2500);
    </script>

    @stack('scripts')
</body>
</html>



