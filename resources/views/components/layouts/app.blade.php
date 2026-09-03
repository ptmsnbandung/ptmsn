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
    <div class="fixed bottom-5 right-4 sm:bottom-6 sm:right-6 z-50 flex items-center gap-3">
        <a href="https://wa.me/{{ config('company.whatsapp') }}?text={{ urlencode('Halo PT Media Solusi Network, saya ingin mendapatkan informasi mengenai layanan internet & infrastruktur.') }}" target="_blank" rel="noopener noreferrer" class="hidden sm:inline-flex items-center px-4 py-2 rounded-full bg-[#050d1a]/95 border border-emerald-500/40 text-white text-xs font-heading font-medium shadow-2xl backdrop-blur-md hover:border-emerald-400 transition-colors" aria-label="Konsultasi WhatsApp">
            <span>Butuh bantuan internet? <strong class="text-[#25D366]">Chat WhatsApp</strong></span>
        </a>

        <a href="https://wa.me/{{ config('company.whatsapp') }}?text={{ urlencode('Halo PT Media Solusi Network, saya ingin mendapatkan informasi mengenai layanan internet & infrastruktur.') }}" target="_blank" rel="noopener noreferrer" class="w-13 h-13 sm:w-14 sm:h-14 rounded-full bg-[#25D366] hover:bg-[#20ba5a] text-white flex items-center justify-center shadow-[0_4px_20px_rgba(37,211,102,0.45)] hover:scale-110 active:scale-95 transition-all duration-300 relative group" aria-label="Chat WhatsApp PT Media Solusi Network" title="Chat WhatsApp PT Media Solusi Network">
            <svg class="w-7 h-7 sm:w-8 sm:h-8 fill-current text-white transition-transform duration-300 group-hover:scale-105" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm0 18.15c-1.49 0-2.95-.4-4.23-1.16l-.3-.18-3.14.82.84-3.06-.2-.31a8.16 8.16 0 01-1.25-4.36c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 012.41 5.83c.02 4.54-3.68 8.24-8.2 8.24zm4.52-6.17c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.12-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.39-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.15.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.12-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.12.17 1.77 2.71 4.3 3.79.6.26 1.07.41 1.44.53.61.2 1.16.17 1.6.1.49-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.17-.48-.29z"/>
            </svg>
        </a>
    </div>

    <!-- Back to Top Button (Positioned on the Left, Perfectly Aligned with WhatsApp Button) -->
    <button class="back-to-top-btn fixed bottom-5 left-4 sm:bottom-6 sm:left-6 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/95 backdrop-blur-md border border-slate-200/80 text-[#0284c7] shadow-lg flex items-center justify-center cursor-pointer z-40 transition-all duration-300 opacity-0 invisible hover:scale-110 hover:border-[#0284c7] hover:bg-[#0284c7] hover:text-white active:scale-95" aria-label="Kembali ke atas">
        <iconify-icon icon="solar:arrow-up-linear" width="20" height="20" class="sm:w-[22px] sm:h-[22px]"></iconify-icon>
    </button>

</body>
</html>
