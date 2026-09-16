<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Portal Pelanggan — PT Media Solusi Network</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-icon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    
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
            background-color: #f0f5fb;
            background-image: 
                radial-gradient(at 15% 15%, rgba(14, 165, 233, 0.18) 0px, transparent 40%),
                radial-gradient(at 85% 20%, rgba(56, 189, 248, 0.22) 0px, transparent 45%),
                radial-gradient(at 50% 85%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 90% 85%, rgba(14, 165, 233, 0.16) 0px, transparent 40%);
            font-family: 'Inter', sans-serif;
            background-attachment: fixed;
        }

        .login-glass-card {
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 
                0 25px 50px -12px rgba(15, 23, 42, 0.12),
                0 0 0 1px rgba(226, 232, 240, 0.7),
                inset 0 1px 1px 0 rgba(255, 255, 255, 1);
        }

        .glass-demo-btn {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 5px rgba(15, 23, 42, 0.04);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .glass-demo-btn:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(56, 189, 248, 0.5);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px -2px rgba(14, 165, 233, 0.15);
        }
    </style>
</head>
<body class="min-h-full flex items-center justify-center p-4 sm:p-6 relative overflow-x-hidden text-slate-800">

    <!-- Glowing Orbs in Background -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[650px] h-[350px] bg-sky-300/35 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-10 left-10 w-[350px] h-[350px] bg-blue-200/40 rounded-full blur-[100px]"></div>
        <div class="absolute top-10 right-10 w-[300px] h-[300px] bg-indigo-200/35 rounded-full blur-[100px]"></div>
    </div>

    <div class="relative z-10 w-full max-w-[460px] mx-auto py-8">
        
        <!-- Brand Logo Header -->
        <div class="text-center mb-7">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center mb-4 hover:opacity-90 transition-opacity">
                <img 
                    src="{{ asset('images/logo/logo-msn.png') }}" 
                    alt="PT Media Solusi Network" 
                    class="h-12 w-auto max-w-[240px] object-contain drop-shadow-sm"
                >
            </a>
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/80 backdrop-blur-md border border-sky-200/80 text-[11px] font-mono font-bold text-sky-700 uppercase tracking-widest mb-2 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>PORTAL LAYANAN PELANGGAN</span>
                </div>
            </div>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">Masuk Portal Pelanggan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Masukkan nomor WhatsApp atau Nomor Internet yang terdaftar</p>
        </div>

        <!-- Login Glass Card -->
        <div class="login-glass-card rounded-3xl p-7 sm:p-9">
            
            @if(session('info'))
                <div class="mb-5 p-3.5 rounded-2xl bg-sky-50/90 border border-sky-200 text-sky-800 text-xs font-sans flex items-center gap-2.5 shadow-sm">
                    <iconify-icon icon="solar:info-circle-bold" class="text-base shrink-0 text-sky-600"></iconify-icon>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-5 p-3.5 rounded-2xl bg-emerald-50/90 border border-emerald-200 text-emerald-800 text-xs font-sans flex items-center gap-2.5 shadow-sm">
                    <iconify-icon icon="solar:check-circle-bold" class="text-base shrink-0 text-emerald-600"></iconify-icon>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="mb-5 p-3.5 rounded-2xl bg-rose-50/90 border border-rose-200 text-rose-800 text-xs font-sans shadow-sm">
                    @foreach($errors->all() as $error)
                        <div class="flex items-start gap-2">
                            <iconify-icon icon="solar:danger-circle-bold" class="text-base shrink-0 text-rose-500 mt-0.5"></iconify-icon>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('portal.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Phone Number / Internet ID Input -->
                <div>
                    <label for="phone" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center justify-between">
                        <span>No. WhatsApp / No. Internet</span>
                        <span class="text-[10px] text-emerald-600 font-mono font-semibold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">Langsung Masuk</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <iconify-icon icon="solar:phone-bold" width="18"></iconify-icon>
                        </div>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone') }}" 
                            required 
                            autofocus 
                            class="w-full pl-10 pr-4 py-3.5 rounded-2xl bg-white/80 backdrop-blur-md border border-slate-300 text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all font-mono shadow-sm"
                            placeholder="Contoh: 081320335016 / 1010222"
                        >
                    </div>
                    <div class="text-[11px] text-slate-500 mt-1.5 flex items-center gap-1">
                        <iconify-icon icon="solar:shield-check-bold" class="text-sky-600"></iconify-icon>
                        <span>Cukup masukkan nomor terdaftar di sistem IMS tanpa perlu PIN</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-extrabold text-sm transition-all duration-200 shadow-lg shadow-sky-500/30 hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2 cursor-pointer mt-2"
                >
                    <span>Masuk ke Portal</span>
                    <iconify-icon icon="solar:login-2-bold" width="18"></iconify-icon>
                </button>
            </form>

            <!-- Quick Demo Account Box for Testing (from IMS DB) -->
            @if($demoCustomers->isNotEmpty())
                <div class="mt-6 pt-5 border-t border-slate-200/80">
                    <div class="text-[11px] font-mono font-semibold uppercase tracking-wider text-slate-500 mb-2.5 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:user-id-bold" class="text-sky-600"></iconify-icon>
                            <span>Klik Contoh Pelanggan IMS:</span>
                        </span>
                        <span class="text-[10px] text-emerald-600 font-mono font-bold bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">Database IMS</span>
                    </div>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($demoCustomers as $demo)
                            <button type="button" onclick="fillDemo('{{ $demo->phone ?? $demo->customer_id }}')" class="glass-demo-btn p-2.5 rounded-2xl text-left flex items-center justify-between group">
                                <div class="truncate max-w-[290px]">
                                    <div class="text-xs font-bold text-slate-800 group-hover:text-sky-600 truncate">{{ $demo->name }}</div>
                                    <div class="text-[10px] text-slate-500 font-mono">No HP: {{ $demo->phone }} • ID: {{ $demo->customer_id }}</div>
                                </div>
                                <span class="text-[10px] font-mono px-2 py-0.5 rounded-lg bg-sky-100 text-sky-700 font-bold shrink-0 ml-2 group-hover:bg-sky-600 group-hover:text-white transition-colors">Pilih</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- Help Info & Footer -->
        <div class="text-center mt-6 space-y-3">
            <div class="text-xs text-slate-500">
                Nomor Anda belum terdaftar? 
                <a href="https://wa.me/6281214878436?text=Halo%20Admin%20PT%20MSN,%20saya%20ingin%20mendaftarkan%20nomor%20HP%20saya%20di%20portal%20pelanggan" target="_blank" class="text-sky-600 hover:text-sky-700 font-bold hover:underline">Hubungi Customer Service</a>
            </div>
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-800 transition-colors font-mono font-semibold">
                    <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                    <span>Kembali ke Halaman Depan</span>
                </a>
            </div>
        </div>

    </div>

    <script>
        function fillDemo(phone) {
            document.getElementById('phone').value = phone;
        }
    </script>

</body>
</html>

