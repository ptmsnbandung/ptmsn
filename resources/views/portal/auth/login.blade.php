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
                radial-gradient(at 15% 15%, rgba(14, 165, 233, 0.16) 0px, transparent 40%),
                radial-gradient(at 85% 20%, rgba(56, 189, 248, 0.20) 0px, transparent 45%),
                radial-gradient(at 50% 85%, rgba(99, 102, 241, 0.12) 0px, transparent 50%),
                radial-gradient(at 90% 85%, rgba(14, 165, 233, 0.14) 0px, transparent 40%);
            font-family: 'Inter', sans-serif;
            background-attachment: fixed;
        }

        .login-glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid rgba(255, 255, 255, 0.95);
            box-shadow: 
                0 25px 50px -12px rgba(15, 23, 42, 0.10),
                0 0 0 1px rgba(226, 232, 240, 0.8),
                inset 0 1px 2px 0 rgba(255, 255, 255, 1);
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
<body class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 relative overflow-x-hidden text-slate-800 antialiased">

    <!-- Ambient Glow Background Blobs -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[650px] h-[350px] bg-sky-300/30 rounded-full blur-[130px]"></div>
        <div class="absolute bottom-5 left-5 w-[350px] h-[350px] bg-blue-200/35 rounded-full blur-[110px]"></div>
        <div class="absolute top-1/3 -right-20 w-[400px] h-[400px] bg-indigo-200/30 rounded-full blur-[120px]"></div>
    </div>

    <!-- Centered Card Container -->
    <div class="relative z-10 w-full max-w-[480px] mx-auto py-6">
        
        <!-- The Login Glass Card -->
        <div class="login-glass-card rounded-3xl p-6 sm:p-8 lg:p-9">
            
            <!-- Card Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-1.5">
                    <h1 class="font-heading font-extrabold text-2xl sm:text-[26px] text-slate-900 tracking-tight">
                        Masuk ke Portal
                    </h1>
                    <span class="px-2.5 py-0.5 rounded-full bg-sky-100/80 text-sky-700 font-mono font-bold text-[10px] uppercase tracking-wider">
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
                    <div class="flex items-center justify-between mb-2">
                        <label for="phone" class="text-xs font-mono font-bold uppercase tracking-wider text-slate-700">
                            NO. WHATSAPP / ID INTERNET
                        </label>
                        <span class="text-[10px] font-mono text-slate-400 uppercase">
                            CONTOH: 0812... / 1010222
                        </span>
                    </div>
                    
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
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:check-circle-bold" class="text-emerald-500 text-sm"></iconify-icon>
                            <span>Tervalidasi Database IMS</span>
                        </span>
                        <span class="flex items-center gap-1.5 text-slate-500">
                            <iconify-icon icon="solar:clock-circle-linear" class="text-sm"></iconify-icon>
                            <span>Auto-logout 1 jam</span>
                        </span>
                    </div>
                </div>

                <!-- Action Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-3.5 sm:py-4 px-6 rounded-2xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-extrabold text-sm sm:text-base transition-all duration-200 shadow-md shadow-sky-500/25 hover:shadow-lg hover:shadow-sky-500/35 hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2 cursor-pointer mt-2"
                >
                    <span>Masuk Sekarang</span>
                    <iconify-icon icon="solar:arrow-right-linear" width="18"></iconify-icon>
                </button>
            </form>

            <!-- Quick IMS Demo Accounts (Collapsible Drawer) -->
            @if($demoCustomers->isNotEmpty())
                <div class="mt-6 pt-5 border-t border-slate-200/80">
                    
                    <button 
                        type="button" 
                        onclick="toggleDemoDrawer()" 
                        class="w-full flex items-center justify-between py-1 px-1 text-left text-xs font-mono font-semibold text-slate-600 hover:text-sky-600 transition-colors group cursor-pointer"
                        aria-expanded="false"
                        id="demoDrawerBtn"
                    >
                        <span class="flex items-center gap-2">
                            <iconify-icon icon="solar:user-id-bold" class="text-sky-500 text-sm"></iconify-icon>
                            <span>Klik Contoh Akun Pelanggan IMS (Uji Coba)</span>
                        </span>
                        <iconify-icon icon="solar:alt-arrow-down-linear" id="demoDrawerArrow" class="text-slate-400 group-hover:text-sky-600 transition-transform duration-200"></iconify-icon>
                    </button>

                    <div id="demoDrawerContent" class="hidden mt-3 space-y-2 transition-all">
                        <div class="text-[11px] text-slate-500 mb-1">
                            Pilih salah satu akun riil dari database IMS untuk mengisi nomor otomatis:
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
            <div class="mt-6 text-center text-[11px] text-slate-400 flex items-center justify-center gap-1.5 font-mono">
                <iconify-icon icon="solar:lock-bold" class="text-slate-400"></iconify-icon>
                <span>Koneksi aman terenkripsi • Sesi aktif 1 jam</span>
            </div>

        </div>

        <!-- Back to Home Link -->
        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-slate-600 transition-colors font-mono">
                <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                <span>Kembali ke Website Utama</span>
            </a>
        </div>

    </div>

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
