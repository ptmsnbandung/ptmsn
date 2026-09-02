<!DOCTYPE html>
<html lang="id" class="lenis">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Primary Tags -->
    <title>{{ config('company.name') }} — Internet & Telecom Infrastructure</title>
    <meta name="title" content="{{ config('company.name') }} — Internet & Telecom Infrastructure">
    <meta name="description" content="{{ config('company.name') }} menyediakan solusi internet fiber optic, transmisi data dedicated, dan infrastruktur digital terpercaya untuk korporasi, instansi pemerintah, dan perumahan.">
    <meta name="keywords" content="internet, ISP, fiber optic, internet dedicated, infrastruktur jaringan, PT Media Solusi Network, provider internet jawa barat, bandung">
    <meta name="author" content="{{ config('company.name') }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon & Browser Tab Emblem -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-msn BG Trans - Copy2.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo/logo-msn BG Trans - Copy2.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo/logo-msn BG Trans - Copy2.png') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ config('company.name') }} — Internet & Telecom Infrastructure">
    <meta property="og:description" content="Koneksi internet fiber optic murni tanpa FUP, infrastruktur jaringan andal, dan dukungan NOC 24/7.">
    <meta property="og:image" content="{{ asset('images/logo/logo-msn.png') }}">

    <!-- Google Fonts: Manrope (Headings 700) and Inter (Body 400, 18px line-height 1.7) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

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
                    }
                }
            }
        }
    </script>

    <!-- Iconify Web Component -->
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

    <!-- GSAP 3.12.5 & ScrollTrigger -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    <!-- Lenis Smooth Scroll -->
    <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.29/bundled/lenis.min.js"></script>

    <!-- Vanilla Tilt -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>

    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

    <!-- SweetAlert2 (CSS + JS) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.min.css">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-800 font-sans antialiased overflow-x-hidden selection:bg-[#38bdf8] selection:text-[#050d1a]" style="zoom: 90%;">

    <!-- Navbar Component -->
    <x-navbar />

    <!-- Main Content Container -->
    <main class="min-h-screen flex flex-col justify-between pt-0 w-full overflow-x-hidden">
        <div class="flex-grow w-full">
            {{ $slot }}
        </div>
        <div>
            <x-footer />
        </div>
    </main>

    <!-- Floating WhatsApp Widget -->
    <div class="fixed bottom-6 right-6 z-50 flex items-center gap-3">
        <a href="https://wa.me/{{ config('company.whatsapp') }}?text={{ urlencode('Halo PT Media Solusi Network, saya ingin mendapatkan informasi mengenai layanan internet & infrastruktur.') }}" target="_blank" rel="noopener noreferrer" class="hidden sm:inline-flex items-center px-4 py-2 rounded-full bg-[#050d1a]/95 border border-[#38bdf8]/40 text-white text-xs font-heading font-medium shadow-2xl backdrop-blur-md hover:border-[#38bdf8] transition-colors" aria-label="Konsultasi WhatsApp">
            <span>Butuh bantuan internet? <strong class="text-[#38bdf8]">Chat Sales</strong></span>
        </a>

        <a href="https://wa.me/{{ config('company.whatsapp') }}?text={{ urlencode('Halo PT Media Solusi Network, saya ingin mendapatkan informasi mengenai layanan internet & infrastruktur.') }}" target="_blank" rel="noopener noreferrer" class="w-14 h-14 rounded-full bg-[#38bdf8] text-[#050d1a] flex items-center justify-center shadow-[0_0_25px_rgba(56,189,248,0.5)] hover:scale-110 active:scale-95 transition-all duration-300 relative group" aria-label="Chat WhatsApp PT Media Solusi Network" title="Chat WhatsApp PT Media Solusi Network">
            <div class="absolute inset-0 rounded-full bg-[#38bdf8]/40 animate-ping pointer-events-none"></div>
            <iconify-icon icon="solar:chat-round-dots-bold" width="28" height="28" class="group-hover:rotate-12 transition-transform duration-300"></iconify-icon>
        </a>
    </div>

    <!-- Back to Top Button (Positioned on the Left, Perfectly Aligned with WhatsApp Button) -->
    <button class="back-to-top-btn fixed bottom-5 left-4 sm:bottom-6 sm:left-6 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/95 backdrop-blur-md border border-slate-200/80 text-[#0284c7] shadow-lg flex items-center justify-center cursor-pointer z-40 transition-all duration-300 opacity-0 invisible hover:scale-110 hover:border-[#0284c7] hover:bg-[#0284c7] hover:text-white active:scale-95" aria-label="Kembali ke atas">
        <iconify-icon icon="solar:arrow-up-linear" width="20" height="20" class="sm:w-[22px] sm:h-[22px]"></iconify-icon>
    </button>

</body>
</html>
