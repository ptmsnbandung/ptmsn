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
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid rgba(255, 255, 255, 0.95);
            box-shadow: 
                0 20px 40px -10px rgba(15, 23, 42, 0.08),
                0 0 0 1px rgba(226, 232, 240, 0.8),
                inset 0 1px 2px 0 rgba(255, 255, 255, 1);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 relative overflow-x-hidden text-slate-800 antialiased">

    <!-- Ambient Glow Background Blobs -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[550px] h-[300px] bg-sky-300/30 rounded-full blur-[130px]"></div>
        <div class="absolute bottom-5 left-5 w-[300px] h-[300px] bg-blue-200/35 rounded-full blur-[110px]"></div>
        <div class="absolute top-1/3 -right-20 w-[350px] h-[350px] bg-indigo-200/30 rounded-full blur-[120px]"></div>
    </div>

    <!-- Centered Card Container (Sleek & Compact) -->
    <div class="relative z-10 w-full max-w-[390px] mx-auto py-4">
        
        <!-- Brand Logo MSN MID -->
        <div class="text-center mb-5">
            <a href="{{ route('home') }}" class="inline-block hover:opacity-90 transition-opacity" title="PT Media Solusi Network">
                <img 
                    src="{{ asset('images/logo/LOGO MSN MID.png') }}" 
                    alt="Logo PT Media Solusi Network" 
                    class="h-14 sm:h-16 w-auto mx-auto object-contain drop-shadow-xs hover:scale-105 transition-transform"
                >
            </a>
        </div>

        <!-- The Login Glass Card -->
        <div class="login-glass-card rounded-2xl sm:rounded-3xl p-6 sm:p-7">
            
            <!-- Card Header -->
            <div class="mb-5">
                <h1 class="font-heading font-extrabold text-xl sm:text-2xl text-slate-900 tracking-tight mb-1">
                    Masuk ke Portal
                </h1>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Gunakan Nomor Internet (ID Pelanggan) atau Nomor WhatsApp yang terdaftar
                </p>
            </div>

            <!-- Alerts Container -->
            
            <!-- 1 Hour Timeout Alert -->
            @if(session('warning'))
                <div class="mb-4 p-3 rounded-xl bg-amber-50/95 border border-amber-200 text-amber-900 text-xs font-sans flex items-start gap-2 shadow-xs animate-pulse">
                    <iconify-icon icon="solar:clock-circle-bold" class="text-base shrink-0 text-amber-600 mt-0.5"></iconify-icon>
                    <span class="leading-snug">{{ session('warning') }}</span>
                </div>
            @endif

            <!-- General Info Alert -->
            @if(session('info'))
                <div class="mb-4 p-3 rounded-xl bg-sky-50/95 border border-sky-200 text-sky-900 text-xs font-sans flex items-start gap-2 shadow-xs">
                    <iconify-icon icon="solar:info-circle-bold" class="text-base shrink-0 text-sky-600 mt-0.5"></iconify-icon>
                    <span class="leading-snug">{{ session('info') }}</span>
                </div>
            @endif

            <!-- Success Alert -->
            @if(session('success'))
                <div class="mb-4 p-3 rounded-xl bg-emerald-50/95 border border-emerald-200 text-emerald-900 text-xs font-sans flex items-start gap-2 shadow-xs">
                    <iconify-icon icon="solar:check-circle-bold" class="text-base shrink-0 text-emerald-600 mt-0.5"></iconify-icon>
                    <span class="leading-snug">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Alert -->
            @if(isset($errors) && $errors->any())
                <div class="mb-4 p-3 rounded-xl bg-rose-50/95 border border-rose-200 text-rose-900 text-xs font-sans shadow-xs">
                    @foreach($errors->all() as $error)
                        <div class="flex items-start gap-2">
                            <iconify-icon icon="solar:danger-circle-bold" class="text-base shrink-0 text-rose-500 mt-0.5"></iconify-icon>
                            <span class="leading-snug">{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('portal.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="login" class="block text-[11px] font-mono font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center justify-between">
                        <span>Nomor Internet / WhatsApp</span>
                        <span class="text-[10px] text-sky-600 font-semibold normal-case">ID Pelanggan / No. HP</span>
                    </label>
                    
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <iconify-icon icon="solar:user-id-bold" width="18"></iconify-icon>
                        </div>
                        <input 
                            type="text" 
                            id="login" 
                            name="login" 
                            value="{{ old('login', old('phone')) }}" 
                            required 
                            autofocus 
                            class="w-full pl-10 pr-3.5 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl bg-white/90 border border-slate-300 text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all font-mono shadow-xs"
                            placeholder="Contoh: 1711221 atau 081234567890"
                            autocomplete="username"
                        >
                    </div>

                    <div class="flex items-center justify-between text-[10px] text-slate-500 mt-2 px-0.5">
                        <span class="flex items-center gap-1">
                            <iconify-icon icon="solar:check-circle-bold" class="text-emerald-500 text-xs"></iconify-icon>
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
                    class="w-full py-3 sm:py-3.5 px-5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-heading font-extrabold text-sm transition-all duration-200 shadow-md shadow-sky-500/25 hover:shadow-lg hover:shadow-sky-500/35 hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2 cursor-pointer mt-1"
                >
                    <span>Masuk Sekarang</span>
                    <iconify-icon icon="solar:arrow-right-linear" width="17"></iconify-icon>
                </button>
            </form>

            <!-- Safety & Privacy Guarantee Note -->
            <div class="mt-5 pt-4 border-t border-slate-200/70 text-center text-[10px] text-slate-400 flex items-center justify-center gap-1.5 font-mono">
                <iconify-icon icon="solar:lock-bold" class="text-slate-400"></iconify-icon>
                <span>Koneksi aman terenkripsi • Sesi aktif 1 jam</span>
            </div>

        </div>

        <!-- Back to Home Link -->
        <div class="text-center mt-3.5">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-[11px] text-slate-400 hover:text-slate-600 transition-colors font-mono">
                <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                <span>Kembali ke Website Utama</span>
            </a>
        </div>

    </div>

</body>
</html>
