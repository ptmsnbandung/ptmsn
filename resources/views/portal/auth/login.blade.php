<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Portal Pelanggan — PT Media Solusi Network</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-icon.png') }}">

    <!-- Google Fonts: Inter, Manrope, JetBrains Mono -->
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
                            navy: '#0f172a',
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

    <style>
        body {
            background-color: #f1f5f9;
            background-image: 
                radial-gradient(at 10% 15%, rgba(14, 165, 233, 0.16) 0px, transparent 40%),
                radial-gradient(at 90% 15%, rgba(56, 189, 248, 0.20) 0px, transparent 45%),
                radial-gradient(at 50% 90%, rgba(99, 102, 241, 0.12) 0px, transparent 50%),
                radial-gradient(at 95% 85%, rgba(14, 165, 233, 0.14) 0px, transparent 40%);
            font-family: 'Inter', sans-serif;
            background-attachment: fixed;
        }

        .login-glass-card {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid rgba(255, 255, 255, 0.95);
            box-shadow: 
                0 20px 45px -10px rgba(15, 23, 42, 0.08),
                0 0 0 1px rgba(226, 232, 240, 0.8),
                inset 0 1px 2px 0 rgba(255, 255, 255, 1);
        }

        .side-feature-card {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.85);
            box-shadow: 0 4px 15px -2px rgba(15, 23, 42, 0.04);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .side-feature-card:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -4px rgba(14, 165, 233, 0.12);
            border-color: rgba(56, 189, 248, 0.5);
        }

        .glass-demo-btn {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(226, 232, 240, 0.9);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .glass-demo-btn:hover {
            background: #ffffff;
            border-color: rgba(14, 165, 233, 0.6);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px -1px rgba(14, 165, 233, 0.16);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between p-3 sm:p-6 lg:p-10 relative overflow-x-hidden text-slate-800 antialiased">

    <!-- Ambient Glow Background Blobs -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-sky-300/30 rounded-full blur-[130px]"></div>
        <div class="absolute bottom-5 left-5 w-[400px] h-[400px] bg-blue-200/35 rounded-full blur-[110px]"></div>
        <div class="absolute top-1/3 -right-20 w-[450px] h-[450px] bg-indigo-200/30 rounded-full blur-[120px]"></div>
    </div>

    <!-- Top Navigation Bar -->
    <header class="relative z-10 w-full max-w-6xl mx-auto flex items-center justify-between py-2 sm:py-3 mb-2 sm:mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 group transition-all" title="Kembali ke Beranda">
            <img 
                src="{{ asset('images/logo/logo-msn.png') }}" 
                alt="Logo PT Media Solusi Network" 
                class="h-9 sm:h-11 w-auto object-contain drop-shadow-xs transition-transform group-hover:scale-105"
            >
        </a>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white/70 hover:bg-white border border-slate-200/80 text-xs font-semibold text-slate-600 hover:text-sky-600 transition-all shadow-xs">
            <iconify-icon icon="solar:arrow-left-linear" class="text-sm"></iconify-icon>
            <span class="hidden sm:inline">Kembali ke</span>
            <span>Beranda</span>
        </a>
    </header>

    <!-- Main Container: Responsive Split on Desktop, Compact Stack on Mobile -->
    <main class="relative z-10 w-full max-w-6xl mx-auto my-auto py-2 sm:py-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 lg:gap-12 items-center">
            
            <!-- Left Info Panel (Prominent on Desktop, Condensed on Mobile) -->
            <div class="lg:col-span-6 flex flex-col justify-center text-left space-y-5 lg:pr-4">
                
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/80 backdrop-blur-md border border-sky-200 text-xs font-mono font-bold text-sky-700 shadow-xs w-fit">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span>PORTAL RESMI LAYANAN PELANGGAN</span>
                </div>

                <!-- Headline & Intro -->
                <div>
                    <h1 class="font-heading font-extrabold text-2xl sm:text-3xl lg:text-4xl text-slate-900 tracking-tight leading-tight">
                        Akses Mandiri Layanan Internet PT MSN
                    </h1>
                    <p class="text-sm sm:text-base text-slate-600 mt-2 leading-relaxed">
                        Masuk secara mudah tanpa ribet mengingat PIN. Pantau koneksi, cek status tagihan, dan buat laporan gangguan langsung ke tim NOC.
                    </p>
                </div>

                <!-- 3 Feature Highlight Cards (Visible on md+ screens) -->
                <div class="hidden sm:grid grid-cols-1 gap-3 pt-1">
                    <div class="side-feature-card p-3.5 rounded-2xl flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-sky-100/90 text-sky-600 flex items-center justify-center shrink-0 shadow-xs">
                            <iconify-icon icon="solar:wi-fi-router-bold" width="20"></iconify-icon>
                        </div>
                        <div class="text-xs">
                            <div class="font-heading font-bold text-slate-900 text-sm">Status Jaringan & Paket Realtime</div>
                            <div class="text-slate-500 mt-0.5 leading-snug">Pantau paket aktif, IP pelanggan, dan kondisi koneksi fiber optic langsung dari sistem IMS.</div>
                        </div>
                    </div>

                    <div class="side-feature-card p-3.5 rounded-2xl flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100/90 text-emerald-600 flex items-center justify-center shrink-0 shadow-xs">
                            <iconify-icon icon="solar:ticket-sale-bold" width="20"></iconify-icon>
                        </div>
                        <div class="text-xs">
                            <div class="font-heading font-bold text-slate-900 text-sm">Lapor Gangguan 24 Jam</div>
                            <div class="text-slate-500 mt-0.5 leading-snug">Ajukan tiket kendala teknis (LOS/Modem) dengan update progres langsung dari teknisi.</div>
                        </div>
                    </div>

                    <div class="side-feature-card p-3.5 rounded-2xl flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-amber-100/90 text-amber-600 flex items-center justify-center shrink-0 shadow-xs">
                            <iconify-icon icon="solar:shield-check-bold" width="20"></iconify-icon>
                        </div>
                        <div class="text-xs">
                            <div class="font-heading font-bold text-slate-900 text-sm">Keamanan Sesi 1 Jam</div>
                            <div class="text-slate-500 mt-0.5 leading-snug">Akun Anda dilindungi dengan sistem logout otomatis setelah 1 jam inaktivitas demi privasi.</div>
                        </div>
                    </div>
                </div>

                <!-- Support Contact Badge -->
                <div class="pt-2 flex items-center gap-3 text-xs text-slate-600">
                    <span class="font-medium">Butuh bantuan pendaftaran?</span>
                    <a href="https://wa.me/6281214878436?text=Halo%20Admin%20PT%20MSN,%20saya%20ingin%20mendaftarkan%20nomor%20HP%20saya%20di%20portal%20pelanggan" target="_blank" class="inline-flex items-center gap-1 font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                        <iconify-icon icon="solar:chat-round-dots-bold" class="text-sm"></iconify-icon>
                        <span>WhatsApp CS</span>
                    </a>
                </div>

            </div>

            <!-- Right Login Form Card (Polished & Highly Responsive) -->
            <div class="lg:col-span-6 w-full max-w-md mx-auto lg:max-w-none">
                
                <div class="login-glass-card rounded-3xl p-6 sm:p-8 lg:p-9">
                    
                    <!-- Card Header -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-1">
                            <h2 class="font-heading font-extrabold text-xl sm:text-2xl text-slate-900 tracking-tight">
                                Masuk ke Portal
                            </h2>
                            <span class="px-2.5 py-0.5 rounded-full bg-sky-100 text-sky-700 font-mono font-bold text-[10px] uppercase tracking-wider">
                                Tanpa PIN
                            </span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500">
                            Masukkan nomor WhatsApp atau Nomor Pelanggan (ID Internet) Anda
                        </p>
                    </div>

                    <!-- Alerts Container -->
                    
                    <!-- 1 Hour Timeout Alert -->
                    @if(session('warning'))
                        <div class="mb-5 p-3.5 rounded-2xl bg-amber-50/95 border border-amber-200 text-amber-900 text-xs sm:text-sm font-sans flex items-start gap-2.5 shadow-xs animate-pulse">
                            <iconify-icon icon="solar:clock-circle-bold" class="text-lg shrink-0 text-amber-600 mt-0.5"></iconify-icon>
                            <span class="leading-snug">{{ session('warning') }}</span>
                        </div>
                    @endif

                    <!-- General Info Alert -->
                    @if(session('info'))
                        <div class="mb-5 p-3.5 rounded-2xl bg-sky-50/95 border border-sky-200 text-sky-900 text-xs sm:text-sm font-sans flex items-start gap-2.5 shadow-xs">
                            <iconify-icon icon="solar:info-circle-bold" class="text-lg shrink-0 text-sky-600 mt-0.5"></iconify-icon>
                            <span class="leading-snug">{{ session('info') }}</span>
                        </div>
                    @endif

                    <!-- Success Alert -->
                    @if(session('success'))
                        <div class="mb-5 p-3.5 rounded-2xl bg-emerald-50/95 border border-emerald-200 text-emerald-900 text-xs sm:text-sm font-sans flex items-start gap-2.5 shadow-xs">
                            <iconify-icon icon="solar:check-circle-bold" class="text-lg shrink-0 text-emerald-600 mt-0.5"></iconify-icon>
                            <span class="leading-snug">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Error Alert -->
                    @if(isset($errors) && $errors->any())
                        <div class="mb-5 p-3.5 rounded-2xl bg-rose-50/95 border border-rose-200 text-rose-900 text-xs sm:text-sm font-sans shadow-xs">
                            @foreach($errors->all() as $error)
                                <div class="flex items-start gap-2">
                                    <iconify-icon icon="solar:danger-circle-bold" class="text-lg shrink-0 text-rose-500 mt-0.5"></iconify-icon>
                                    <span class="leading-snug">{{ $error }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('portal.login.submit') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="phone" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center justify-between">
                                <span>No. WhatsApp / ID Internet</span>
                                <span class="text-[10px] text-slate-400 font-normal">Contoh: 0812... / 1010222</span>
                            </label>
                            
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <iconify-icon icon="solar:phone-bold" width="19"></iconify-icon>
                                </div>
                                <input 
                                    type="text" 
                                    id="phone" 
                                    name="phone" 
                                    value="{{ old('phone') }}" 
                                    required 
                                    autofocus 
                                    class="w-full pl-11 pr-4 py-3 sm:py-3.5 rounded-2xl bg-white/90 border border-slate-300 text-slate-900 placeholder-slate-400 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all font-mono shadow-xs"
                                    placeholder="Masukkan No. WA atau ID Internet"
                                    autocomplete="tel"
                                >
                            </div>

                            <div class="flex items-center justify-between text-[11px] text-slate-500 mt-2 px-1">
                                <span class="flex items-center gap-1">
                                    <iconify-icon icon="solar:shield-check-bold" class="text-emerald-500 text-xs"></iconify-icon>
                                    <span>Tervalidasi Database IMS</span>
                                </span>
                                <span class="flex items-center gap-1 text-slate-400">
                                    <iconify-icon icon="solar:clock-circle-linear" class="text-xs"></iconify-icon>
                                    <span>Auto-logout 1 jam</span>
                                </span>
                            </div>
                        </div>

                        <!-- Action Submit Button -->
                        <button 
                            type="submit" 
                            class="w-full py-3.5 sm:py-4 px-6 rounded-2xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-extrabold text-sm sm:text-base transition-all duration-200 shadow-md shadow-sky-500/25 hover:shadow-lg hover:shadow-sky-500/35 hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2 cursor-pointer pt-3"
                        >
                            <span>Masuk Sekarang</span>
                            <iconify-icon icon="solar:arrow-right-linear" width="18"></iconify-icon>
                        </button>
                    </form>

                    <!-- Quick IMS Demo Accounts (Collapsible for Clean Look) -->
                    @if($demoCustomers->isNotEmpty())
                        <div class="mt-6 pt-5 border-t border-slate-200/80">
                            
                            <button 
                                type="button" 
                                onclick="toggleDemoDrawer()" 
                                class="w-full flex items-center justify-between py-1 px-1 text-left text-xs font-mono font-semibold text-slate-600 hover:text-sky-600 transition-colors group cursor-pointer"
                                aria-expanded="false"
                                id="demoDrawerBtn"
                            >
                                <span class="flex items-center gap-1.5">
                                    <iconify-icon icon="solar:user-id-bold" class="text-sky-500 text-sm"></iconify-icon>
                                    <span>Klik Contoh Akun Pelanggan IMS (Uji Coba)</span>
                                </span>
                                <iconify-icon icon="solar:alt-arrow-down-linear" id="demoDrawerArrow" class="text-slate-400 group-hover:text-sky-600 transition-transform duration-200"></iconify-icon>
                            </button>

                            <div id="demoDrawerContent" class="hidden mt-3 space-y-2 transition-all">
                                <div class="text-[11px] text-slate-500 mb-1">
                                    Pilih salah satu akun riil dari database IMS di bawah ini untuk mengisi nomor secara otomatis:
                                </div>
                                @foreach($demoCustomers as $demo)
                                    <button 
                                        type="button" 
                                        onclick="fillDemo('{{ $demo->phone ?? $demo->customer_id }}')" 
                                        class="glass-demo-btn w-full p-2.5 rounded-xl text-left flex items-center justify-between group cursor-pointer"
                                    >
                                        <div class="truncate max-w-[240px] sm:max-w-[280px]">
                                            <div class="text-xs font-bold text-slate-800 group-hover:text-sky-600 truncate">{{ $demo->name }}</div>
                                            <div class="text-[10px] text-slate-500 font-mono mt-0.5">
                                                HP: <span class="text-slate-700 font-semibold">{{ $demo->phone ?? '-' }}</span> 
                                                • ID: <span class="text-slate-700 font-semibold">{{ $demo->customer_id }}</span>
                                            </div>
                                        </div>
                                        <span class="text-[10px] font-mono px-2.5 py-1 rounded-lg bg-sky-50 text-sky-700 border border-sky-200/80 font-bold shrink-0 ml-2 group-hover:bg-sky-600 group-hover:text-white group-hover:border-sky-600 transition-all">
                                            Pilih
                                        </span>
                                    </button>
                                @endforeach
                            </div>

                        </div>
                    @endif

                    <!-- Safety & Privacy Guarantee Note -->
                    <div class="mt-5 text-center text-[11px] text-slate-400 flex items-center justify-center gap-1.5 font-mono">
                        <iconify-icon icon="solar:lock-bold" class="text-slate-400"></iconify-icon>
                        <span>Koneksi aman terenkripsi • Sesi aktif 1 jam</span>
                    </div>

                </div>

            </div>

        </div>
    </main>

    <!-- Page Footer -->
    <footer class="relative z-10 w-full max-w-6xl mx-auto py-3 text-center text-xs text-slate-500 font-mono flex flex-col sm:flex-row items-center justify-between gap-2 mt-4">
        <div>
            &copy; {{ date('Y') }} PT Media Solusi Network • All Rights Reserved
        </div>
        <div class="flex items-center gap-4 text-xs">
            <a href="{{ route('home') }}#kontak" class="hover:text-sky-600 transition-colors">Bantuan</a>
            <span>•</span>
            <a href="https://wa.me/6281214878436" target="_blank" class="hover:text-emerald-600 transition-colors flex items-center gap-1">
                <iconify-icon icon="solar:chat-round-dots-bold"></iconify-icon>
                <span>Helpdesk 24 Jam</span>
            </a>
        </div>
    </footer>

    <!-- Script for Demo Selector & Auto-focus Effect -->
    <script>
        function fillDemo(identifier) {
            const input = document.getElementById('phone');
            input.value = identifier;
            input.focus();
            
            // Visual feedback on input field
            input.classList.add('ring-2', 'ring-emerald-500', 'border-emerald-500');
            setTimeout(() => {
                input.classList.remove('ring-2', 'ring-emerald-500', 'border-emerald-500');
            }, 800);
        }

        function toggleDemoDrawer() {
            const content = document.getElementById('demoDrawerContent');
            const arrow = document.getElementById('demoDrawerArrow');
            const isHidden = content.classList.contains('hidden');

            if (isHidden) {
                content.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        }
    </script>

</body>
</html>
