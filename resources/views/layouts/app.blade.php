<!DOCTYPE html>
<html lang="id" class="lenis">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Primary Tags -->
    <title>{{ config('company.name') }} — Internet & IT Solution</title>
    <meta name="title" content="{{ config('company.name') }} — Internet & IT Solution">
    <meta name="description" content="{{ config('company.name') }} menyediakan layanan internet cepat, stabil, dan solusi teknologi informasi terpercaya untuk rumah, bisnis, dan perusahaan.">
    <meta name="keywords" content="internet, ISP, fiber optic, internet cepat, IT solution, PT Media Solusi Network, provider internet bekasi, cianjur, jawa barat">
    <meta name="author" content="{{ config('company.name') }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ config('company.name') }} — Internet & IT Solution">
    <meta property="og:description" content="Nikmati koneksi internet cepat, stabil, dan terpercaya dengan teknologi fiber optic dan dukungan teknis 24/7.">
    <meta property="og:image" content="{{ asset('images/hero/hero-illustration.png') }}">

    <!-- Google Fonts: Outfit, Plus Jakarta Sans, Geist, Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Geist:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
                            dark: '#030712',
                        }
                    },
                    fontFamily: {
                        brand: ['Outfit', 'Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Geist', 'Plus Jakarta Sans', 'sans-serif'],
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Iconify Web Component -->
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

    <!-- GSAP 3.12.5 & ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <!-- Lenis 1.1.13 Smooth Scroll -->
    <script src="https://unpkg.com/lenis@1.1.13/dist/lenis.min.js"></script>

    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "InternetServiceProvider",
      "name": "{{ config('company.name') }}",
      "alternateName": "{{ config('company.short_name') }}",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('images/logo/logo.svg') }}",
      "description": "Penyedia layanan internet berkecepatan tinggi, fiber optic, software development, dan solusi IT di Indonesia.",
      "telephone": "{{ config('company.phone') }}",
      "email": "{{ config('company.email') }}",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ config('company.address') }}",
        "addressCountry": "ID"
      }
    }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#050d1a] text-slate-800 antialiased font-sans min-h-screen m-0 p-0 selection:bg-[#38bdf8] selection:text-[#050d1a] overflow-x-hidden">

    <!-- Main Container: 100% Full Width Edge-to-Edge -->
    <main class="relative w-full min-h-screen overflow-hidden bg-white">
        
        <!-- Navigation Header (Sticky Glassmorphic) -->
        <div class="relative z-30 w-full">
            <x-navbar />
        </div>

        <!-- Main Content Flow -->
        <div class="relative z-10 w-full" id="main-content">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div class="relative z-10 w-full">
            <x-footer />
        </div>

    </main>

    <!-- Floating WhatsApp Widget -->
    <x-floating-whatsapp />

    <!-- Back to Top Button (Positioned on the Left, Perfectly Aligned with WhatsApp Button) -->
    <button class="back-to-top-btn fixed bottom-5 left-4 sm:bottom-6 sm:left-6 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/95 backdrop-blur-md border border-slate-200/80 text-[#0284c7] shadow-lg flex items-center justify-center cursor-pointer z-40 transition-all duration-300 opacity-0 invisible hover:scale-110 hover:border-[#0284c7] hover:bg-[#0284c7] hover:text-white active:scale-95" aria-label="Kembali ke atas">
        <iconify-icon icon="solar:arrow-up-linear" width="20" height="20" class="sm:w-[22px] sm:h-[22px]"></iconify-icon>
    </button>

    <!-- Global Top Loading Progress Bar -->
    <div id="global-page-loader" style="position:fixed;top:0;left:0;height:3px;width:0%;background:linear-gradient(90deg,#0284c7,#38bdf8,#0ea5e9);z-index:99999;transition:width 0.2s cubic-bezier(0.1,0.9,0.2,1),opacity 0.25s ease;box-shadow:0 0 10px rgba(56,189,248,0.8);pointer-events:none;opacity:0;"></div>

    <!-- Speculative Link Prefetcher for Ultra-Fast Page Transitions -->
    <script>
        (function() {
            const prefetched = new Set();
            const loader = document.getElementById('global-page-loader');

            function prefetch(url) {
                if (!url || prefetched.has(url)) return;
                try {
                    const parsed = new URL(url, window.location.origin);
                    if (parsed.origin !== window.location.origin) return;
                    if (parsed.pathname === window.location.pathname && !parsed.hash) return;
                    if (parsed.pathname.includes('logout')) return;

                    prefetched.add(url);
                    const link = document.createElement('link');
                    link.rel = 'prefetch';
                    link.href = url;
                    link.as = 'document';
                    document.head.appendChild(link);
                } catch(e) {}
            }

            document.addEventListener('mouseover', function(e) {
                const a = e.target.closest('a[href]');
                if (a && a.href && !a.target && !a.href.startsWith('javascript:')) {
                    prefetch(a.href);
                }
            }, { passive: true });

            document.addEventListener('touchstart', function(e) {
                const a = e.target.closest('a[href]');
                if (a && a.href && !a.target && !a.href.startsWith('javascript:')) {
                    prefetch(a.href);
                }
            }, { passive: true });

            document.addEventListener('click', function(e) {
                const a = e.target.closest('a[href]');
                if (a && a.href && !a.target && !a.href.startsWith('javascript:') && !a.href.includes('#')) {
                    try {
                        const parsed = new URL(a.href, window.location.origin);
                        if (parsed.origin === window.location.origin && parsed.pathname !== window.location.pathname) {
                            if (loader) {
                                loader.style.opacity = '1';
                                loader.style.width = '80%';
                            }
                        }
                    } catch(e) {}
                }
            });

            window.addEventListener('pageshow', function() {
                if (loader) {
                    loader.style.width = '100%';
                    loader.style.opacity = '0';
                    setTimeout(() => {
                        loader.style.width = '0%';
                    }, 300);
                }
            });
        })();
    </script>
</body>
</html>
