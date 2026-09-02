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

    <!-- Google Fonts: Geist (Headings & UI) and Inter (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
                        heading: ['Geist', 'sans-serif'],
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

    <!-- Back to Top Button -->
    <button class="back-to-top-btn fixed bottom-24 right-8 w-12 h-12 rounded-full bg-white border border-slate-200 text-[#0284c7] shadow-xl flex items-center justify-center cursor-pointer z-40 transition-all duration-300 opacity-0 invisible hover:scale-110 hover:border-[#0284c7] hover:bg-[#0284c7] hover:text-white" aria-label="Kembali ke atas">
        <iconify-icon icon="solar:arrow-up-linear" width="22" height="22"></iconify-icon>
    </button>

</body>
</html>
