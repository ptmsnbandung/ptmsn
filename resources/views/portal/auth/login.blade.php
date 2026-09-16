<!DOCTYPE html>
<html lang="id" class="h-full bg-[#050d1a] text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Portal Pelanggan — PT Media Solusi Network</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-msn BG Trans - Copy2.png') }}">

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

    <style>
        body {
            background: radial-gradient(circle at 50% 15%, #0d2547 0%, #07172e 60%, #050d1a 100%);
            font-family: 'Inter', sans-serif;
        }
        .login-card {
            background: rgba(13, 27, 49, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(56, 189, 248, 0.25);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.8), 0 0 40px rgba(56, 189, 248, 0.15);
        }
    </style>
</head>
<body class="min-h-full flex items-center justify-center p-4 sm:p-6 relative overflow-x-hidden text-slate-200">

    <!-- Subtle Background Elements -->
    <div class="absolute inset-0 pointer-events-none opacity-20" style="background-image: radial-gradient(rgba(56, 189, 248, 0.4) 1px, transparent 1px); background-size: 32px 32px;"></div>
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[320px] bg-[#38bdf8]/15 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-[440px] mx-auto py-8">
        
        <!-- Brand Logo Header -->
        <div class="text-center mb-7">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center mb-4 hover:opacity-90 transition-opacity">
                <img 
                    src="{{ asset('images/logo/logo-msn-white.png') }}" 
                    alt="PT Media Solusi Network" 
                    class="h-11 w-auto max-w-[220px] object-contain drop-shadow-[0_0_15px_rgba(56,189,248,0.4)]"
                >
            </a>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#38bdf8]/10 border border-[#38bdf8]/30 text-[11px] font-mono font-bold text-[#38bdf8] uppercase tracking-widest mb-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>PORTAL LAYANAN PELANGGAN</span>
            </div>
            <h1 class="font-heading font-extrabold text-2xl text-white tracking-tight">Masuk Portal Pelanggan</h1>
            <p class="text-xs text-slate-400 mt-1">Masukkan nomor telepon / WhatsApp yang terdaftar untuk masuk</p>
        </div>

        <!-- Login Card -->
        <div class="login-card rounded-3xl p-7 sm:p-8">
            
            @if(session('info'))
                <div class="mb-5 p-3.5 rounded-2xl bg-sky-500/15 border border-sky-500/30 text-sky-300 text-xs font-sans flex items-center gap-2.5">
                    <iconify-icon icon="solar:info-circle-bold" class="text-base shrink-0"></iconify-icon>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-5 p-3.5 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs font-sans flex items-center gap-2.5">
                    <iconify-icon icon="solar:check-circle-bold" class="text-base shrink-0"></iconify-icon>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-3.5 rounded-2xl bg-rose-500/15 border border-rose-500/30 text-rose-300 text-xs font-sans">
                    @foreach($errors->all() as $error)
                        <div class="flex items-start gap-2">
                            <iconify-icon icon="solar:danger-circle-bold" class="text-base shrink-0 text-rose-400 mt-0.5"></iconify-icon>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('portal.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Phone Number / Internet ID Input -->
                <div>
                    <label for="phone" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-300 mb-1.5 flex items-center justify-between">
                        <span>Nomor WhatsApp / Nomor Internet</span>
                        <span class="text-[10px] text-emerald-400 font-mono font-normal">Langsung Masuk</span>
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
                            class="w-full pl-10 pr-4 py-3.5 rounded-2xl bg-white/[0.07] border border-white/20 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-[#38bdf8] focus:border-transparent transition-all font-mono"
                            placeholder="Contoh: 081320335016 / 1010222"
                        >
                    </div>
                    <div class="text-[11px] text-slate-400 mt-1.5 flex items-center gap-1">
                        <iconify-icon icon="solar:shield-check-bold" class="text-[#38bdf8]"></iconify-icon>
                        <span>Cukup masukkan nomor yang terdaftar di IMS tanpa perlu PIN</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-4 px-6 rounded-2xl bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-extrabold text-sm transition-all duration-200 shadow-[0_0_25px_rgba(56,189,248,0.4)] hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2 cursor-pointer mt-2"
                >
                    <span>Masuk ke Portal</span>
                    <iconify-icon icon="solar:login-2-bold" width="18"></iconify-icon>
                </button>
            </form>

            <!-- Quick Demo Account Box for Testing (from IMS DB) -->
            @if($demoCustomers->isNotEmpty())
                <div class="mt-6 pt-5 border-t border-white/10">
                    <div class="text-[11px] font-mono font-semibold uppercase tracking-wider text-slate-400 mb-2.5 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <iconify-icon icon="solar:user-id-bold" class="text-[#38bdf8]"></iconify-icon>
                            <span>Klik Contoh Pelanggan IMS:</span>
                        </span>
                        <span class="text-[10px] text-emerald-400 font-mono">Database IMS</span>
                    </div>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($demoCustomers as $demo)
                            <button type="button" onclick="fillDemo('{{ $demo->phone ?? $demo->customer_id }}')" class="p-2.5 rounded-xl bg-white/[0.04] hover:bg-white/[0.09] border border-white/10 text-left transition-all flex items-center justify-between group">
                                <div class="truncate max-w-[280px]">
                                    <div class="text-xs font-bold text-white group-hover:text-[#38bdf8] truncate">{{ $demo->name }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono">No HP: {{ $demo->phone }} • ID: {{ $demo->customer_id }}</div>
                                </div>
                                <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-sky-500/20 text-sky-300 font-bold shrink-0 ml-2">Pilih</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- Help Info & Footer -->
        <div class="text-center mt-6 space-y-3">
            <div class="text-xs text-slate-400">
                Nomor Anda belum terdaftar? 
                <a href="https://wa.me/6281214878436?text=Halo%20Admin%20PT%20MSN,%20saya%20ingin%20mendaftarkan%20nomor%20HP%20saya%20di%20portal%20pelanggan" target="_blank" class="text-[#38bdf8] hover:underline font-semibold">Hubungi Customer Service</a>
            </div>
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-white transition-colors font-mono">
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
