<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MyMSN') — Customer Self-Care | PT Media Solusi Network</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-icon.png') }}">

    <!-- Google Fonts: Outfit, Plus Jakarta Sans, Inter, JetBrains Mono -->
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

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            background-image: 
                radial-gradient(at 15% 15%, rgba(14, 165, 233, 0.15) 0px, transparent 40%),
                radial-gradient(at 85% 20%, rgba(56, 189, 248, 0.18) 0px, transparent 45%),
                radial-gradient(at 50% 85%, rgba(99, 102, 241, 0.10) 0px, transparent 50%),
                radial-gradient(at 90% 85%, rgba(14, 165, 233, 0.12) 0px, transparent 40%),
                radial-gradient(at 10% 80%, rgba(16, 185, 129, 0.08) 0px, transparent 40%);
            background-attachment: fixed;
        }

        /* Glassmorphism Classes */
        .portal-card {
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 
                0 10px 30px -5px rgba(15, 23, 42, 0.06), 
                0 1px 3px 0 rgba(0, 0, 0, 0.03),
                inset 0 1px 1px 0 rgba(255, 255, 255, 0.9);
        }

        .portal-card-hover {
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .portal-card-hover:hover {
            background: rgba(255, 255, 255, 0.92);
            border-color: rgba(56, 189, 248, 0.6);
            transform: translateY(-3px);
            box-shadow: 
                0 20px 35px -10px rgba(14, 165, 233, 0.16), 
                0 0 0 1px rgba(56, 189, 248, 0.35),
                inset 0 1px 1px 0 rgba(255, 255, 255, 1);
        }

        .glass-pill {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.85);
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(203, 213, 225, 0.85);
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.03);
        }
    </style>
</head>
<body class="min-h-full flex flex-col font-sans antialiased text-slate-800" x-data="{ mobileMenu: false, userDropdown: false }">

    <!-- Ambient Glowing Orbs Background -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-sky-300/30 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -right-32 w-96 h-96 bg-cyan-300/25 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-indigo-200/30 rounded-full blur-3xl"></div>
    </div>

    <!-- Top Portal Header -->
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-xl border-b border-slate-200/80 shadow-[0_4px_20px_-4px_rgba(15,23,42,0.04)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 sm:h-16">
                
                <!-- Left: Logo & Portal Badge -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('portal.dashboard') }}" class="flex items-center transition-transform hover:opacity-90">
                        <img src="{{ asset('images/logo/logo-msn.png') }}" alt="PT MSN" class="h-7 sm:h-9 w-auto object-contain">
                    </a>
                    <div class="hidden sm:flex items-center pl-3 border-l border-slate-200">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gradient-to-r from-sky-50 to-blue-50/70 border border-sky-200/80 shadow-2xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="font-brand font-extrabold text-xs text-sky-500">My</span><span class="font-brand font-black text-xs text-slate-800">MSN</span>
                            <span class="text-[9px] font-heading font-bold text-sky-600 uppercase tracking-wide ml-0.5">Self-Care</span>
                        </span>
                    </div>
                </div>

                <!-- Center: Navigation Links (Desktop) -->
                <nav class="hidden md:flex items-center gap-1 bg-slate-100/90 backdrop-blur-md border border-slate-200/80 p-1 rounded-2xl shadow-inner">
                    <a href="{{ route('portal.dashboard') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-heading font-semibold transition-all {{ request()->routeIs('portal.dashboard') ? 'bg-white text-sky-700 shadow-sm border border-slate-200/60 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:home-smile-bold" width="15" class="{{ request()->routeIs('portal.dashboard') ? 'text-sky-600' : 'text-slate-400' }}"></iconify-icon>
                            <span>Beranda</span>
                        </span>
                    </a>
                    <a href="{{ route('portal.billing.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-heading font-semibold transition-all {{ request()->routeIs('portal.billing.*') ? 'bg-white text-sky-700 shadow-sm border border-slate-200/60 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:wallet-money-bold" width="15" class="{{ request()->routeIs('portal.billing.*') ? 'text-sky-600' : 'text-slate-400' }}"></iconify-icon>
                            <span>Tagihan</span>
                        </span>
                    </a>
                    <a href="{{ route('portal.tickets.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-heading font-semibold transition-all {{ request()->routeIs('portal.tickets.*') && !request()->routeIs('portal.tickets.create') ? 'bg-white text-sky-700 shadow-sm border border-slate-200/60 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:chat-round-dots-bold" width="15" class="{{ request()->routeIs('portal.tickets.*') && !request()->routeIs('portal.tickets.create') ? 'text-sky-600' : 'text-slate-400' }}"></iconify-icon>
                            <span>Bantuan & Tiket</span>
                        </span>
                    </a>
                    <a href="{{ route('portal.profile') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-heading font-semibold transition-all {{ request()->routeIs('portal.profile') ? 'bg-white text-sky-700 shadow-sm border border-slate-200/60 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:user-circle-bold" width="15" class="{{ request()->routeIs('portal.profile') ? 'text-sky-600' : 'text-slate-400' }}"></iconify-icon>
                            <span>Profil Akun</span>
                        </span>
                    </a>
                </nav>

                <!-- Right: Quick Action & User Menu -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('portal.tickets.create') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-500 hover:bg-sky-600 text-white font-heading font-semibold text-xs transition-all shadow-sm shadow-sky-500/20 active:scale-95">
                        <iconify-icon icon="solar:add-circle-bold" width="15"></iconify-icon>
                        <span>+ Buat Tiket</span>
                    </a>

                    <!-- User Profile Dropdown -->
                    <div class="relative" @click.outside="userDropdown = false">
                        <button @click="userDropdown = !userDropdown" class="flex items-center gap-2 p-1 sm:px-2.5 sm:py-1 rounded-2xl bg-white border border-slate-200/80 hover:border-slate-300 hover:shadow-xs transition-all">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-sky-600 to-cyan-500 text-white flex items-center justify-center font-bold text-xs shadow-xs ring-1 ring-sky-100">
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

                        <!-- Dropdown Content -->
                        <div 
                            x-show="userDropdown" 
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-60 rounded-2xl bg-white/95 backdrop-blur-2xl border border-slate-200/80 shadow-xl p-2 z-50 divide-y divide-slate-100"
                            style="display: none;"
                        >
                            <div class="px-3 py-2.5">
                                <div class="text-xs font-bold text-slate-800 leading-tight">{{ Auth::guard('customer')->user()->name }}</div>
                                <div class="text-[11px] font-mono text-sky-600 font-semibold mt-0.5">ID: {{ Auth::guard('customer')->user()->customer_id ?? '-' }}</div>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('portal.billing.index') }}" class="flex items-center gap-2 px-3 py-2 text-xs text-slate-700 hover:text-sky-700 hover:bg-sky-50/80 rounded-xl transition-colors font-medium">
                                    <iconify-icon icon="solar:wallet-money-bold" class="text-emerald-500" width="16"></iconify-icon>
                                    <span>Tagihan Saya</span>
                                </a>
                                <a href="{{ route('portal.tickets.index') }}" class="flex items-center gap-2 px-3 py-2 text-xs text-slate-700 hover:text-sky-700 hover:bg-sky-50/80 rounded-xl transition-colors font-medium">
                                    <iconify-icon icon="solar:chat-round-dots-bold" class="text-amber-500" width="16"></iconify-icon>
                                    <span>Bantuan & Tiket</span>
                                </a>
                                <a href="{{ route('portal.profile') }}" class="flex items-center gap-2 px-3 py-2 text-xs text-slate-700 hover:text-sky-700 hover:bg-sky-50/80 rounded-xl transition-colors font-medium">
                                    <iconify-icon icon="solar:user-bold" class="text-sky-500" width="16"></iconify-icon>
                                    <span>Informasi Akun</span>
                                </a>
                                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 px-3 py-2 text-xs text-slate-700 hover:text-sky-700 hover:bg-sky-50/80 rounded-xl transition-colors font-medium">
                                    <iconify-icon icon="solar:globe-bold" class="text-indigo-500" width="16"></iconify-icon>
                                    <span>Website Utama PT MSN</span>
                                </a>
                            </div>
                            <div class="pt-1">
                                <a href="{{ route('portal.logout') }}" class="w-full flex items-center gap-2 px-3 py-2 text-xs text-rose-600 hover:bg-rose-50 rounded-xl text-left font-semibold transition-colors">
                                    <iconify-icon icon="solar:logout-2-bold" width="16"></iconify-icon>
                                    <span>Keluar (Logout)</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-xl bg-white border border-slate-200 text-slate-700 shadow-xs hover:bg-slate-50">
                        <iconify-icon icon="solar:hamburger-menu-bold" width="20"></iconify-icon>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Drawer / Menu -->
        <div x-show="mobileMenu" @click.outside="mobileMenu = false" class="md:hidden px-4 pt-2 pb-4 border-t border-slate-200/80 bg-white/95 backdrop-blur-xl space-y-1.5 shadow-lg" style="display: none;">
            <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-xs font-heading font-semibold {{ request()->routeIs('portal.dashboard') ? 'bg-sky-600 text-white font-bold shadow-xs' : 'text-slate-700 bg-slate-50 hover:bg-slate-100' }}">
                <iconify-icon icon="solar:home-smile-bold" width="16"></iconify-icon>
                <span>Beranda</span>
            </a>
            <a href="{{ route('portal.billing.index') }}" class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-xs font-heading font-semibold {{ request()->routeIs('portal.billing.*') ? 'bg-sky-600 text-white font-bold shadow-xs' : 'text-slate-700 bg-slate-50 hover:bg-slate-100' }}">
                <iconify-icon icon="solar:wallet-money-bold" width="16"></iconify-icon>
                <span>Tagihan</span>
            </a>
            <a href="{{ route('portal.tickets.index') }}" class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-xs font-heading font-semibold {{ request()->routeIs('portal.tickets.*') && !request()->routeIs('portal.tickets.create') ? 'bg-sky-600 text-white font-bold shadow-xs' : 'text-slate-700 bg-slate-50 hover:bg-slate-100' }}">
                <iconify-icon icon="solar:chat-round-dots-bold" width="16"></iconify-icon>
                <span>Bantuan & Tiket</span>
            </a>
            <a href="{{ route('portal.profile') }}" class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-xs font-heading font-semibold {{ request()->routeIs('portal.profile') ? 'bg-sky-600 text-white font-bold shadow-xs' : 'text-slate-700 bg-slate-50 hover:bg-slate-100' }}">
                <iconify-icon icon="solar:user-circle-bold" width="16"></iconify-icon>
                <span>Profil Akun</span>
            </a>
            <a href="{{ route('portal.tickets.create') }}" class="flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl bg-sky-500 hover:bg-sky-600 text-white font-heading font-bold text-xs shadow-xs">
                <iconify-icon icon="solar:add-circle-bold" width="16"></iconify-icon>
                <span>+ Buat Tiket Baru</span>
            </a>
            <div class="pt-2 border-t border-slate-200/80">
                <a href="{{ route('portal.logout') }}" class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-xs font-heading font-semibold text-rose-600 bg-rose-50/80 hover:bg-rose-100 transition-colors">
                    <iconify-icon icon="solar:logout-2-bold" width="16"></iconify-icon>
                    <span>Keluar (Logout)</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Body Container -->
    <main class="relative z-10 flex-1 max-w-7xl w-full mx-auto px-3.5 sm:px-6 lg:px-8 py-3.5 sm:py-8">
        
        <!-- Flash Alerts -->
        @if(session('success'))
            <div class="mb-3 sm:mb-6 p-3 sm:p-4 rounded-2xl sm:rounded-3xl bg-emerald-50/90 backdrop-blur-md border border-emerald-200 text-emerald-800 flex items-center justify-between gap-2.5 text-xs sm:text-sm font-sans shadow-sm">
                <div class="flex items-center gap-2.5">
                    <iconify-icon icon="solar:check-circle-bold" class="text-emerald-500 text-lg sm:text-xl shrink-0"></iconify-icon>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-3 sm:mb-6 p-3 sm:p-4 rounded-2xl sm:rounded-3xl bg-sky-50/90 backdrop-blur-md border border-sky-200 text-sky-800 flex items-center justify-between gap-2.5 text-xs sm:text-sm font-sans shadow-sm">
                <div class="flex items-center gap-2.5">
                    <iconify-icon icon="solar:info-circle-bold" class="text-sky-500 text-lg sm:text-xl shrink-0"></iconify-icon>
                    <span class="font-medium">{{ session('info') }}</span>
                </div>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="mb-3 sm:mb-6 p-3 sm:p-4 rounded-2xl sm:rounded-3xl bg-rose-50/90 backdrop-blur-md border border-rose-200 text-rose-800 text-xs sm:text-sm font-sans shadow-sm">
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

    <!-- Portal Footer -->
    <footer class="relative z-10 mt-auto border-t border-slate-200/80 bg-white/85 backdrop-blur-xl py-3.5 sm:py-4 text-xs text-slate-500 font-sans shadow-[0_-4px_20px_-4px_rgba(15,23,42,0.03)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-2.5 sm:gap-4 text-center sm:text-left">
                
                <!-- Left: Copyright & Operational Status -->
                <div class="flex items-center gap-2 flex-wrap justify-center sm:justify-start">
                    <span class="font-medium text-slate-600">&copy; {{ date('Y') }} <strong class="text-slate-800 font-bold">PT Media Solusi Network</strong></span>
                    <span class="hidden sm:inline text-slate-300">•</span>
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-[10px] font-semibold font-mono">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Helpdesk NOC 24/7</span>
                    </span>
                </div>

                <!-- Right: Quick Action Links -->
                <div class="flex items-center gap-2 sm:gap-3 flex-wrap justify-center">
                    <a href="https://wa.me/{{ config('company.whatsapp', '6289696629955') }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 font-medium text-[11px] sm:text-xs transition-all shadow-2xs">
                        <iconify-icon icon="solar:chat-round-dots-bold" class="text-emerald-600 text-sm"></iconify-icon>
                        <span>WhatsApp NOC</span>
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-900 border border-slate-200 font-medium text-[11px] sm:text-xs transition-all shadow-2xs">
                        <iconify-icon icon="solar:globe-linear" class="text-slate-400 text-sm"></iconify-icon>
                        <span>Website Utama</span>
                    </a>
                </div>

            </div>
        </div>
    </footer>

    <!-- Auto Logout 1 Jam Inaktivitas -->
    <script>
        (function() {
            // Batas waktu inaktivitas 1 jam (3600 detik = 3.600.000 ms)
            const TIMEOUT_MS = 3600 * 1000;
            let idleTimer;

            function resetIdleTimer() {
                clearTimeout(idleTimer);
                idleTimer = setTimeout(function() {
                    // Otomatis logout ketika 1 jam tidak ada interaksi
                    window.location.href = '{{ route("portal.logout") }}';
                }, TIMEOUT_MS);
            }

            const events = ['mousedown', 'mousemove', 'keydown', 'scroll', 'touchstart'];
            events.forEach(function(evt) {
                window.addEventListener(evt, resetIdleTimer, { passive: true });
            });

        resetIdleTimer();
        })();
    </script>

    @stack('scripts')
</body>
</html>


