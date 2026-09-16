<!DOCTYPE html>
<html lang="id" class="h-full bg-[#050c18] text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Pelanggan') — PT Media Solusi Network</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-msn BG Trans - Copy2.png') }}">

    <!-- Google Fonts: Manrope, Inter, JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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
                            navy: '#07172e',
                            dark: '#050d1a',
                        }
                    },
                    fontFamily: {
                        heading: ['Manrope', 'sans-serif'],
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

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #050d1a;
            background-image: 
                radial-gradient(at 0% 0%, rgba(56, 189, 248, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(14, 165, 233, 0.05) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(2, 132, 199, 0.05) 0px, transparent 50%);
        }
        .portal-card {
            background: rgba(11, 24, 43, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(56, 189, 248, 0.15);
        }
        .portal-card-hover {
            transition: all 0.2s ease-in-out;
        }
        .portal-card-hover:hover {
            border-color: rgba(56, 189, 248, 0.35);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(56, 189, 248, 0.12);
        }
    </style>
</head>
<body class="min-h-full flex flex-col font-sans antialiased text-slate-200" x-data="{ mobileMenu: false, userDropdown: false }">

    <!-- Top Portal Header -->
    <header class="sticky top-0 z-40 bg-[#061120]/90 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Left: Logo & Portal Tag -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo/logo-msn-white.png') }}" alt="PT MSN" class="h-7 sm:h-8 w-auto object-contain">
                    </a>
                    <div class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-sky-500/10 border border-sky-500/30 text-[10px] font-mono font-bold text-[#38bdf8] uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>PORTAL PELANGGAN</span>
                    </div>
                </div>

                <!-- Center: Navigation Links (Desktop) -->
                <nav class="hidden md:flex items-center gap-1 bg-white/[0.04] border border-white/10 p-1 rounded-full">
                    <a href="{{ route('portal.dashboard') }}" class="px-4 py-1.5 rounded-full text-xs font-heading font-semibold transition-all {{ request()->routeIs('portal.dashboard') ? 'bg-[#38bdf8] text-[#050d1a] shadow-sm font-bold' : 'text-slate-300 hover:text-white hover:bg-white/[0.05]' }}">
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:home-smile-bold" width="15"></iconify-icon>
                            <span>Beranda</span>
                        </span>
                    </a>
                    <a href="{{ route('portal.tickets.index') }}" class="px-4 py-1.5 rounded-full text-xs font-heading font-semibold transition-all {{ request()->routeIs('portal.tickets.*') ? 'bg-[#38bdf8] text-[#050d1a] shadow-sm font-bold' : 'text-slate-300 hover:text-white hover:bg-white/[0.05]' }}">
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:shield-warning-bold" width="15"></iconify-icon>
                            <span>Laporan Gangguan</span>
                        </span>
                    </a>
                    <a href="{{ route('portal.profile') }}" class="px-4 py-1.5 rounded-full text-xs font-heading font-semibold transition-all {{ request()->routeIs('portal.profile') ? 'bg-[#38bdf8] text-[#050d1a] shadow-sm font-bold' : 'text-slate-300 hover:text-white hover:bg-white/[0.05]' }}">
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:user-circle-bold" width="15"></iconify-icon>
                            <span>Profil & Paket</span>
                        </span>
                    </a>
                </nav>

                <!-- Right: Quick Lapor CTA & User Menu -->
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <a href="{{ route('portal.tickets.create') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-rose-500 to-amber-500 text-white font-heading font-bold text-xs shadow-lg shadow-rose-500/20 hover:scale-105 active:scale-95 transition-all">
                        <iconify-icon icon="solar:danger-triangle-bold" width="16"></iconify-icon>
                        <span>Lapor Gangguan</span>
                    </a>

                    <!-- User Profile Dropdown -->
                    <div class="relative" @click.outside="userDropdown = false">
                        <button @click="userDropdown = !userDropdown" class="flex items-center gap-2 p-1 sm:px-2 sm:py-1 rounded-xl bg-white/[0.05] border border-white/10 hover:bg-white/10 transition-colors">
                            <div class="w-7 h-7 rounded-lg bg-sky-500/20 border border-sky-500/30 text-[#38bdf8] flex items-center justify-center font-bold text-xs">
                                {{ substr(Auth::guard('customer')->user()->name ?? 'P', 0, 1) }}
                            </div>
                            <div class="hidden lg:block text-left pr-1">
                                <div class="text-xs font-heading font-bold text-white max-w-[120px] truncate leading-tight">{{ Auth::guard('customer')->user()->name }}</div>
                                <div class="text-[10px] font-mono text-slate-400 leading-tight">{{ Auth::guard('customer')->user()->phone }}</div>
                            </div>
                            <iconify-icon icon="solar:alt-arrow-down-linear" class="text-slate-400 text-xs hidden sm:block"></iconify-icon>
                        </button>

                        <!-- Dropdown Content -->
                        <div 
                            x-show="userDropdown" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-52 rounded-2xl bg-[#081528] border border-white/10 shadow-2xl p-1.5 z-50 divide-y divide-white/10"
                            style="display: none;"
                        >
                            <div class="px-3 py-2">
                                <div class="text-xs font-bold text-white">{{ Auth::guard('customer')->user()->name }}</div>
                                <div class="text-[11px] font-mono text-[#38bdf8]">{{ Auth::guard('customer')->user()->customer_id }}</div>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('portal.profile') }}" class="flex items-center gap-2 px-3 py-1.5 text-xs text-slate-300 hover:text-white hover:bg-white/[0.06] rounded-lg">
                                    <iconify-icon icon="solar:user-bold" width="15"></iconify-icon>
                                    <span>Informasi Akun</span>
                                </a>
                                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 px-3 py-1.5 text-xs text-slate-300 hover:text-white hover:bg-white/[0.06] rounded-lg">
                                    <iconify-icon icon="solar:globe-bold" width="15"></iconify-icon>
                                    <span>Website Utama</span>
                                </a>
                            </div>
                            <div class="pt-1">
                                <form action="{{ route('portal.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-1.5 text-xs text-rose-400 hover:bg-rose-500/10 rounded-lg text-left font-semibold">
                                        <iconify-icon icon="solar:logout-2-bold" width="15"></iconify-icon>
                                        <span>Keluar (Logout)</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-xl bg-white/[0.06] border border-white/10 text-white">
                        <iconify-icon icon="solar:hamburger-menu-bold" width="20"></iconify-icon>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Drawer / Menu -->
        <div x-show="mobileMenu" @click.outside="mobileMenu = false" class="md:hidden px-4 pt-2 pb-4 border-t border-white/10 bg-[#061120] space-y-2" style="display: none;">
            <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-heading font-semibold {{ request()->routeIs('portal.dashboard') ? 'bg-[#38bdf8] text-[#050d1a] font-bold' : 'text-slate-300 bg-white/[0.03]' }}">
                <iconify-icon icon="solar:home-smile-bold" width="16"></iconify-icon>
                <span>Beranda</span>
            </a>
            <a href="{{ route('portal.tickets.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-heading font-semibold {{ request()->routeIs('portal.tickets.*') ? 'bg-[#38bdf8] text-[#050d1a] font-bold' : 'text-slate-300 bg-white/[0.03]' }}">
                <iconify-icon icon="solar:shield-warning-bold" width="16"></iconify-icon>
                <span>Laporan Gangguan</span>
            </a>
            <a href="{{ route('portal.profile') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-heading font-semibold {{ request()->routeIs('portal.profile') ? 'bg-[#38bdf8] text-[#050d1a] font-bold' : 'text-slate-300 bg-white/[0.03]' }}">
                <iconify-icon icon="solar:user-circle-bold" width="16"></iconify-icon>
                <span>Profil & Layanan</span>
            </a>
            <a href="{{ route('portal.tickets.create') }}" class="flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl bg-gradient-to-r from-rose-500 to-amber-500 text-white font-heading font-bold text-xs">
                <iconify-icon icon="solar:danger-triangle-bold" width="16"></iconify-icon>
                <span>Lapor Gangguan Baru</span>
            </a>
        </div>
    </header>

    <!-- Main Body Container -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        
        <!-- Flash Alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 flex items-center justify-between gap-3 text-xs sm:text-sm font-sans shadow-lg shadow-emerald-500/5">
                <div class="flex items-center gap-3">
                    <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400 text-xl shrink-0"></iconify-icon>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 p-4 rounded-2xl bg-sky-500/10 border border-sky-500/30 text-sky-300 flex items-center justify-between gap-3 text-xs sm:text-sm font-sans shadow-lg">
                <div class="flex items-center gap-3">
                    <iconify-icon icon="solar:info-circle-bold" class="text-[#38bdf8] text-xl shrink-0"></iconify-icon>
                    <span>{{ session('info') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs sm:text-sm font-sans shadow-lg">
                <div class="font-bold mb-1 flex items-center gap-2">
                    <iconify-icon icon="solar:danger-circle-bold" class="text-lg"></iconify-icon>
                    <span>Harap perhatikan input berikut:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-200/90 pl-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </main>

    <!-- Portal Footer -->
    <footer class="mt-auto border-t border-white/10 bg-[#040913] py-5 text-center text-xs text-slate-500 font-mono">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span>&copy; {{ date('Y') }} PT Media Solusi Network</span>
                <span>•</span>
                <span class="text-slate-400">Helpdesk NOC 24/7</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="https://wa.me/6281214878436" target="_blank" class="text-emerald-400 hover:text-emerald-300 transition-colors flex items-center gap-1 font-semibold">
                    <iconify-icon icon="solar:chat-round-dots-bold"></iconify-icon>
                    <span>WA Helpdesk (0812-1487-8436)</span>
                </a>
                <a href="{{ route('home') }}" class="text-slate-400 hover:text-[#38bdf8] transition-colors">
                    Beranda Website
                </a>
            </div>
        </div>
    </footer>

</body>
</html>
