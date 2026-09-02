<!DOCTYPE html>
<html lang="id" class="h-full bg-[#050c18] text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') — PT Media Solusi Network</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-msn BG Trans - Copy2.png') }}">

    <!-- Google Fonts: Manrope & Inter & JetBrains Mono -->
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
            background-color: #060e1c;
            zoom: 92%;
        }
        /* Custom Scrollbar for admin */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #050c18;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(56, 189, 248, 0.2);
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(56, 189, 248, 0.4);
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-200 overflow-x-hidden text-xs sm:text-sm" x-data="{ sidebarOpen: false }">

    <div class="min-h-full flex">
        
        <!-- Mobile Sidebar Backdrop -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false" 
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-40 lg:hidden"
            style="display: none;"
        ></div>

        <!-- Compact Sidebar Navigation -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 w-60 bg-[#040a14] border-r border-white/10 flex flex-col transition-transform duration-200 ease-in-out lg:static lg:translate-x-0"
        >
            <!-- Logo Header -->
            <div class="h-14 flex items-center justify-between px-5 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logo/logo-msn-white.png') }}" alt="PT Media Solusi Network" class="h-7 max-w-[130px] object-contain">
                    <span class="text-[9px] font-mono font-bold text-[#38bdf8] uppercase tracking-wider px-1.5 py-0.5 rounded bg-sky-500/10 border border-sky-500/20">ADMIN</span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1">
                    <iconify-icon icon="solar:close-circle-bold" width="20"></iconify-icon>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <div class="px-2.5 pb-1 text-[9px] font-mono font-bold uppercase tracking-widest text-slate-500">Utama</div>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-heading text-xs font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#38bdf8] text-[#050d1a] shadow-[0_0_12px_rgba(56,189,248,0.25)] font-bold' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
                    <iconify-icon icon="solar:widget-2-bold" width="16"></iconify-icon>
                    <span>Dashboard</span>
                </a>

                <div class="pt-3 px-2.5 pb-1 text-[9px] font-mono font-bold uppercase tracking-widest text-slate-500">Konten Landing Page</div>
                
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-heading text-xs font-semibold transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-[#38bdf8] text-[#050d1a] shadow-[0_0_12px_rgba(56,189,248,0.25)] font-bold' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
                    <iconify-icon icon="solar:document-text-bold" width="16"></iconify-icon>
                    <span>Teks & Copywriting</span>
                </a>

                <a href="{{ route('admin.packages.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-heading text-xs font-semibold transition-all {{ request()->routeIs('admin.packages.*') ? 'bg-[#38bdf8] text-[#050d1a] shadow-[0_0_12px_rgba(56,189,248,0.25)] font-bold' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
                    <iconify-icon icon="solar:box-minimalistic-bold" width="16"></iconify-icon>
                    <span>Paket Internet</span>
                </a>

                <a href="{{ route('admin.services.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-heading text-xs font-semibold transition-all {{ request()->routeIs('admin.services.*') ? 'bg-[#38bdf8] text-[#050d1a] shadow-[0_0_12px_rgba(56,189,248,0.25)] font-bold' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
                    <iconify-icon icon="solar:server-square-bold" width="16"></iconify-icon>
                    <span>Layanan Solusi</span>
                </a>

                <a href="{{ route('admin.portfolios.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-heading text-xs font-semibold transition-all {{ request()->routeIs('admin.portfolios.*') ? 'bg-[#38bdf8] text-[#050d1a] shadow-[0_0_12px_rgba(56,189,248,0.25)] font-bold' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
                    <iconify-icon icon="solar:folder-with-files-bold" width="16"></iconify-icon>
                    <span>Portofolio Proyek</span>
                </a>

                <a href="{{ route('admin.clients.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-heading text-xs font-semibold transition-all {{ request()->routeIs('admin.clients.*') ? 'bg-[#38bdf8] text-[#050d1a] shadow-[0_0_12px_rgba(56,189,248,0.25)] font-bold' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
                    <iconify-icon icon="solar:users-group-two-rounded-bold" width="16"></iconify-icon>
                    <span>Logo Klien & Mitra</span>
                </a>

                <div class="pt-3 px-2.5 pb-1 text-[9px] font-mono font-bold uppercase tracking-widest text-slate-500">Operasional</div>

                <a href="{{ route('admin.coverage.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-heading text-xs font-semibold transition-all {{ request()->routeIs('admin.coverage.*') ? 'bg-[#38bdf8] text-[#050d1a] shadow-[0_0_12px_rgba(56,189,248,0.25)] font-bold' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
                    <iconify-icon icon="solar:map-point-wave-bold" width="16"></iconify-icon>
                    <span>Cakupan Area (Coverage)</span>
                </a>

                <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg font-heading text-xs font-semibold transition-all {{ request()->routeIs('admin.messages.*') ? 'bg-[#38bdf8] text-[#050d1a] shadow-[0_0_12px_rgba(56,189,248,0.25)] font-bold' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
                    <div class="flex items-center gap-2.5">
                        <iconify-icon icon="solar:letter-bold" width="16"></iconify-icon>
                        <span>Pesan Masuk</span>
                    </div>
                    @php
                        $unreadCount = \App\Models\ContactMessage::where('status', 'unread')->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="px-1.5 py-0.2 text-[10px] font-mono font-bold rounded-full {{ request()->routeIs('admin.messages.*') ? 'bg-slate-950 text-[#38bdf8]' : 'bg-emerald-500 text-slate-950' }}">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>
            </nav>

            <!-- Bottom Live Site Link -->
            <div class="p-3 border-t border-white/10">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-1.5 w-full py-2 px-3 rounded-lg bg-white/[0.04] hover:bg-white/10 text-[11px] font-heading font-semibold text-slate-300 transition-colors border border-white/10">
                    <span>Lihat Website</span>
                    <iconify-icon icon="solar:arrow-right-up-linear" width="14"></iconify-icon>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Top Navbar (Compact h-14) -->
            <header class="h-14 bg-[#040a14]/90 backdrop-blur-md border-b border-white/10 px-5 sm:px-6 flex items-center justify-between z-30 sticky top-0">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="lg:hidden text-slate-400 hover:text-white p-1">
                        <iconify-icon icon="solar:hamburger-menu-bold" width="20"></iconify-icon>
                    </button>
                    <h1 class="font-heading font-bold text-sm sm:text-base text-white tracking-tight">
                        @yield('header', 'Dashboard')
                    </h1>
                </div>

                <div class="flex items-center gap-3" x-data="{ userMenuOpen: false }">
                    <div class="relative">
                        <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2.5 p-1 rounded-lg hover:bg-white/[0.05] transition-colors cursor-pointer">
                            <div class="w-7 h-7 rounded-lg bg-[#38bdf8]/20 border border-[#38bdf8]/40 text-[#38bdf8] flex items-center justify-center font-heading font-bold text-xs">
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <div class="text-[11px] font-heading font-bold text-white leading-tight">{{ auth()->user()->name ?? 'Administrator' }}</div>
                                <div class="text-[9px] font-mono text-slate-400">{{ auth()->user()->email ?? 'admin@ptmsn.co.id' }}</div>
                            </div>
                            <iconify-icon icon="solar:alt-arrow-down-linear" class="text-slate-400 text-xs hidden sm:block"></iconify-icon>
                        </button>

                        <!-- Dropdown Menu -->
                        <div 
                            x-show="userMenuOpen" 
                            @click.away="userMenuOpen = false" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-1.5 w-44 rounded-xl bg-[#081528] border border-white/10 shadow-2xl py-1.5 z-50"
                            style="display: none;"
                        >
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-heading font-semibold text-rose-400 hover:bg-rose-500/10 transition-colors text-left cursor-pointer">
                                    <iconify-icon icon="solar:logout-2-bold" width="14"></iconify-icon>
                                    <span>Keluar (Logout)</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Container -->
            <main class="flex-1 p-4 sm:p-5 lg:p-6 overflow-y-auto max-w-7xl w-full mx-auto">
                
                <!-- Flash Alerts -->
                @if(session('success'))
                    <div class="mb-4 p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 flex items-center justify-between gap-2.5 text-xs font-sans shadow-md">
                        <div class="flex items-center gap-2.5">
                            <iconify-icon icon="solar:check-circle-bold" class="text-emerald-400 text-base shrink-0"></iconify-icon>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 flex items-center justify-between gap-2.5 text-xs font-sans shadow-md">
                        <div class="flex items-center gap-2.5">
                            <iconify-icon icon="solar:danger-circle-bold" class="text-rose-400 text-base shrink-0"></iconify-icon>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs font-sans shadow-md">
                        <div class="font-bold mb-1">Harap periksa kembali input formulir:</div>
                        <ul class="list-disc list-inside space-y-0.5 text-[11px]">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')

            </main>

        </div>

    </div>

</body>
</html>
