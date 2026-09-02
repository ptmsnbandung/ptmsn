@php
    $reviews = [
        [
            'initials' => 'SR',
            'bg_initial' => 'bg-slate-950 border-sky-400',
            'name' => 'Soleh Rohmat',
            'is_local_guide' => false,
            'meta' => '5 reviews • 5 photos',
            'rating' => 5,
            'comment' => '"Saya tau koq... semua yg saya rekomendasikan buat pasang internet dari MSN sdh lama berlangganan"',
            'badge' => 'Pelanggan Terverifikasi',
        ],
        [
            'initials' => 'JJ',
            'bg_initial' => 'bg-[#0284c7] border-sky-300',
            'name' => 'Jingga Joviarneta',
            'is_local_guide' => true,
            'meta' => 'Local Guide • 12 reviews • 30 photos',
            'rating' => 5,
            'comment' => '"Amazing..MSN is always in my heart, especially the director is great...always be successful, Ustad 🙏😍"',
            'badge' => 'Local Guide Terverifikasi',
        ],
        [
            'initials' => 'AG',
            'bg_initial' => 'bg-slate-900 border-sky-300',
            'name' => 'AW GAJE CHANEL',
            'is_local_guide' => true,
            'meta' => 'Local Guide • 106 reviews • 3 photos',
            'rating' => 5,
            'comment' => '"Menyediakan layanan jaringan internet cepat.."',
            'badge' => 'Local Guide Terverifikasi',
        ],
    ];
@endphp

<section id="testimoni" class="pt-20 sm:pt-28 pb-12 sm:pb-16 px-4 sm:px-6 lg:px-8 relative z-10 w-full bg-transparent overflow-hidden">
    <div class="max-w-7xl mx-auto relative z-10">
        
        <!-- Section Header (Dark Mode) -->
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/[0.08] border border-white/20 text-xs font-mono text-[#38bdf8] uppercase tracking-wider mb-4 font-semibold shadow-xs backdrop-blur-md">
                <span>Ulasan Nyata • Google Reviews</span>
            </div>
            <h2 class="font-heading font-extrabold text-3xl sm:text-4xl lg:text-[44px] text-white tracking-tight mb-4 leading-tight" data-reveal-words>
                Apa Kata Pelanggan Tentang Layanan PT MSN.
            </h2>
            <p class="font-sans text-base sm:text-lg text-slate-300 leading-[1.7]">
                Ulasan kepuasan otentik dari para pelanggan dan pengguna aktif layanan internet PT Media Solusi Network.
            </p>
        </div>

        <!-- Horizontal Interactive Carousel Container with Left & Right Arrow Buttons (Auto every 2s) -->
        <div class="testimonial-carousel-container relative max-w-2xl mx-auto px-4 sm:px-12">
            
            <!-- Left Arrow Button -->
            <button 
                type="button" 
                id="testimonialPrevBtn" 
                class="absolute left-0 sm:-left-6 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-slate-900/90 border border-white/20 text-white hover:text-[#38bdf8] hover:border-[#38bdf8] hover:bg-slate-800 flex items-center justify-center shadow-xl transition-all duration-200 hover:scale-110 active:scale-95 z-20 cursor-pointer backdrop-blur-md"
                aria-label="Ulasan Sebelumnya"
            >
                <iconify-icon icon="solar:alt-arrow-left-linear" width="22" height="22"></iconify-icon>
            </button>

            <!-- Right Arrow Button -->
            <button 
                type="button" 
                id="testimonialNextBtn" 
                class="absolute right-0 sm:-right-6 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-slate-900/90 border border-white/20 text-white hover:text-[#38bdf8] hover:border-[#38bdf8] hover:bg-slate-800 flex items-center justify-center shadow-xl transition-all duration-200 hover:scale-110 active:scale-95 z-20 cursor-pointer backdrop-blur-md"
                aria-label="Ulasan Berikutnya"
            >
                <iconify-icon icon="solar:alt-arrow-right-linear" width="22" height="22"></iconify-icon>
            </button>

            <!-- Carousel Viewport / Track Wrapper -->
            <div class="overflow-hidden w-full rounded-3xl">
                <div id="testimonialTrack" class="flex transition-transform duration-500 ease-out will-change-transform">
                    @foreach($reviews as $review)
                        <div class="w-full shrink-0 px-2 sm:px-3">
                            <div class="p-6 sm:p-8 rounded-3xl bg-white/[0.06] border border-white/15 shadow-2xl backdrop-blur-xl flex flex-col justify-between hover:border-cyan-400/40 hover:bg-white/[0.09] transition-all duration-300">
                                <div>
                                    <!-- Header: Author Profile & Google Icon -->
                                    <div class="flex items-start justify-between mb-5">
                                        <div class="flex items-center gap-3.5">
                                            <div class="w-12 h-12 rounded-full {{ $review['bg_initial'] }} text-white flex items-center justify-center font-heading font-extrabold text-base border-2 shadow-md shrink-0">
                                                {{ $review['initials'] }}
                                            </div>
                                            <div>
                                                <div class="font-heading font-bold text-base sm:text-lg text-white flex items-center gap-1.5">
                                                    <span>{{ $review['name'] }}</span>
                                                    @if($review['is_local_guide'])
                                                        <span class="w-4 h-4 rounded-full bg-amber-500 text-white flex items-center justify-center text-[10px]" title="Local Guide">★</span>
                                                    @endif
                                                </div>
                                                <div class="text-xs text-slate-400 font-sans">{{ $review['meta'] }}</div>
                                            </div>
                                        </div>
                                        <span class="p-2 rounded-xl bg-white/[0.08] border border-white/10 text-slate-300">
                                            <iconify-icon icon="logos:google-icon" width="18"></iconify-icon>
                                        </span>
                                    </div>

                                    <!-- Star Rating & Badge -->
                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="flex items-center gap-0.5 text-amber-400">
                                            <iconify-icon icon="solar:star-bold" width="16"></iconify-icon>
                                            <iconify-icon icon="solar:star-bold" width="16"></iconify-icon>
                                            <iconify-icon icon="solar:star-bold" width="16"></iconify-icon>
                                            <iconify-icon icon="solar:star-bold" width="16"></iconify-icon>
                                            <iconify-icon icon="solar:star-bold" width="16"></iconify-icon>
                                        </div>
                                        <span class="text-[11px] text-slate-400 font-mono">Google Review</span>
                                    </div>

                                    <!-- Comment Body -->
                                    <p class="text-slate-100 font-sans text-sm sm:text-base leading-relaxed mb-6 italic">
                                        {{ $review['comment'] }}
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-white/10 flex items-center justify-between text-xs font-mono">
                                    <div class="flex items-center gap-2 text-emerald-400 font-semibold">
                                        <iconify-icon icon="solar:check-circle-bold" width="16"></iconify-icon>
                                        <span>{{ $review['badge'] }}</span>
                                    </div>
                                    <div class="text-slate-400 font-mono text-[11px] hidden sm:block">
                                        Terverifikasi Google Maps
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Dots Pagination -->
            <div class="flex items-center justify-center gap-2 mt-6" id="testimonialDots">
                @foreach($reviews as $idx => $rev)
                    <button 
                        type="button" 
                        class="{{ $idx === 0 ? 'w-7 h-2 rounded-full bg-[#38bdf8]' : 'w-2 h-2 rounded-full bg-white/30 hover:bg-white/60' }} transition-all duration-300 cursor-pointer" 
                        data-index="{{ $idx }}" 
                        aria-label="Lihat ulasan {{ $idx + 1 }}"
                    ></button>
                @endforeach
            </div>

        </div>

        <!-- Google Maps Reviews Link (Dark Mode) -->
        <div class="mt-10 text-center">
            <a href="{{ config('company.maps_url') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-white/10 hover:bg-[#38bdf8] hover:text-[#050d1a] border border-white/20 text-white font-heading font-bold text-xs sm:text-sm transition-all shadow-lg backdrop-blur-md hover:scale-105">
                <iconify-icon icon="logos:google-icon" width="16"></iconify-icon>
                <span>Lihat Semua Ulasan di Google Maps</span>
                <iconify-icon icon="solar:arrow-right-linear" width="16"></iconify-icon>
            </a>
        </div>

    </div>
</section>

<!-- Auto-Slide JavaScript (2 Seconds Interval + Left/Right Controls + Swipe) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const track = document.getElementById('testimonialTrack');
    const prevBtn = document.getElementById('testimonialPrevBtn');
    const nextBtn = document.getElementById('testimonialNextBtn');
    const dots = document.querySelectorAll('#testimonialDots button');

    if (!track) return;

    let currentIndex = 0;
    const totalSlides = track.children.length;
    let autoPlayTimer = null;

    function updateSlide(index) {
        currentIndex = (index + totalSlides) % totalSlides;
        track.style.transform = `translateX(-${currentIndex * 100}%)`;

        dots.forEach((dot, idx) => {
            if (idx === currentIndex) {
                dot.className = 'w-7 h-2 rounded-full bg-[#38bdf8] transition-all duration-300 cursor-pointer';
            } else {
                dot.className = 'w-2 h-2 rounded-full bg-white/30 hover:bg-white/60 transition-all duration-300 cursor-pointer';
            }
        });
    }

    function nextSlide() {
        updateSlide(currentIndex + 1);
    }

    function prevSlide() {
        updateSlide(currentIndex - 1);
    }

    function startAutoPlay() {
        stopAutoPlay();
        autoPlayTimer = setInterval(nextSlide, 2000);
    }

    function stopAutoPlay() {
        if (autoPlayTimer) {
            clearInterval(autoPlayTimer);
            autoPlayTimer = null;
        }
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function () {
            nextSlide();
            startAutoPlay();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function () {
            prevSlide();
            startAutoPlay();
        });
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            const idx = parseInt(dot.getAttribute('data-index'), 10);
            updateSlide(idx);
            startAutoPlay();
        });
    });

    const container = track.closest('.testimonial-carousel-container');
    if (container) {
        container.addEventListener('mouseenter', stopAutoPlay);
        container.addEventListener('mouseleave', startAutoPlay);
        container.addEventListener('touchstart', stopAutoPlay, { passive: true });
        container.addEventListener('touchend', startAutoPlay, { passive: true });
    }

    // Touch swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    track.addEventListener('touchstart', function (e) {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    track.addEventListener('touchend', function (e) {
        touchEndX = e.changedTouches[0].screenX;
        const diff = touchStartX - touchEndX;
        if (Math.abs(diff) > 35) {
            if (diff > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
            startAutoPlay();
        }
    }, { passive: true });

    startAutoPlay();
});
</script>
