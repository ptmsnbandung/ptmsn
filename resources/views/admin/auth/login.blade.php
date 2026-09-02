<!DOCTYPE html>
<html lang="id" class="h-full bg-[#050d1a] text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Admin Portal — PT Media Solusi Network</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-msn BG Trans - Copy2.png') }}">

    <!-- Google Fonts: Manrope & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    
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
            background: radial-gradient(circle at 50% 20%, #0c2340 0%, #07172e 60%, #050d1a 100%);
            font-family: 'Inter', sans-serif;
        }
        .login-card {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(56, 189, 248, 0.25);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 35px rgba(56, 189, 248, 0.15);
        }
    </style>
</head>
<body class="min-h-full flex items-center justify-center p-4 sm:p-6 relative overflow-hidden text-slate-200">

    <!-- Subtle Architectural Background Grid & Ambient Glow -->
    <div class="absolute inset-0 pointer-events-none opacity-20" style="background-image: radial-gradient(rgba(56, 189, 248, 0.4) 1px, transparent 1px); background-size: 28px 28px;"></div>
    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[300px] bg-[#38bdf8]/15 rounded-full blur-[130px] pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-[420px] mx-auto py-8">
        
        <!-- Brand Logo Header -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center mb-5 hover:opacity-90 transition-opacity">
                <img 
                    src="{{ asset('images/logo/logo-msn-white.png') }}" 
                    alt="PT Media Solusi Network" 
                    class="h-12 w-auto max-w-[220px] object-contain drop-shadow-[0_0_15px_rgba(56,189,248,0.4)]"
                >
            </a>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/[0.08] border border-white/20 text-[11px] font-mono font-bold text-[#38bdf8] uppercase tracking-widest mb-2">
                <span>ADMIN PORTAL</span>
            </div>
            <h1 class="font-heading font-extrabold text-2xl text-white tracking-tight">Sistem Manajemen Konten</h1>
        </div>

        <!-- Login Card -->
        <div class="login-card rounded-3xl p-7 sm:p-8">
            
            @if(session('info'))
                <div class="mb-5 p-3.5 rounded-2xl bg-sky-500/15 border border-sky-500/30 text-sky-300 text-xs font-sans flex items-center gap-2.5">
                    <iconify-icon icon="solar:info-circle-bold" class="text-base shrink-0"></iconify-icon>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-3.5 rounded-2xl bg-rose-500/15 border border-rose-500/30 text-rose-300 text-xs font-sans">
                    @foreach($errors->all() as $error)
                        <div class="flex items-center gap-2">
                            <iconify-icon icon="solar:danger-circle-bold" class="text-base shrink-0 text-rose-400"></iconify-icon>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-300 mb-2">Email Administrator</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <iconify-icon icon="solar:letter-bold" width="18"></iconify-icon>
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', 'admin@ptmsn.co.id') }}" 
                            required 
                            autofocus 
                            class="w-full pl-10 pr-4 py-3.5 rounded-2xl bg-white/[0.08] border border-white/20 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-[#38bdf8] focus:border-transparent transition-all font-mono"
                            placeholder="admin@ptmsn.co.id"
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs font-mono font-bold uppercase tracking-wider text-slate-300 mb-2">Kata Sandi (Password)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <iconify-icon icon="solar:lock-password-bold" width="18"></iconify-icon>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            class="w-full pl-10 pr-4 py-3.5 rounded-2xl bg-white/[0.08] border border-white/20 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-[#38bdf8] focus:border-transparent transition-all font-mono"
                            placeholder="••••••••"
                        >
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2.5 cursor-pointer text-slate-300 select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-white/10 border-white/20 text-[#38bdf8] focus:ring-[#38bdf8]">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-4 px-6 rounded-2xl bg-[#38bdf8] hover:bg-white hover:text-[#0284c7] text-[#050d1a] font-heading font-extrabold text-sm transition-all duration-200 shadow-[0_0_25px_rgba(56,189,248,0.4)] hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2 cursor-pointer mt-2"
                >
                    <span>Masuk ke Dashboard</span>
                    <iconify-icon icon="solar:login-2-bold" width="18"></iconify-icon>
                </button>
            </form>

        </div>

        <!-- Footer Links -->
        <div class="text-center mt-7 space-y-2">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-[#38bdf8] transition-colors font-mono">
                <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                <span>Kembali ke Halaman Utama</span>
            </a>
            <div class="text-[11px] text-slate-500 font-mono">
                &copy; {{ date('Y') }} PT Media Solusi Network. All rights reserved.
            </div>
        </div>

    </div>

</body>
</html>
