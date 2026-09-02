import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', () => {

    /* ==========================================================================
       1. Dynamic Transparent-to-Solid Navbar on Scroll with Dynamic Active ScrollSpy
       ========================================================================== */
    const navbar = document.getElementById('mainNavbar');
    const navLogoWhite = document.getElementById('navLogoWhite');
    const navLogoColor = document.getElementById('navLogoColor');
    const pillDock = document.getElementById('navPillDock');
    const ctaBtn = document.getElementById('navCtaBtn');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navLinks = document.querySelectorAll('.nav-link-item');
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

    const sections = [
        { id: 'hero', element: document.getElementById('hero') },
        { id: 'tentang-kami', element: document.getElementById('tentang-kami') },
        { id: 'layanan', element: document.getElementById('layanan') },
        { id: 'coverage', element: document.getElementById('coverage') },
        { id: 'paket', element: document.getElementById('paket') },
        { id: 'portofolio', element: document.getElementById('why-us') },
        { id: 'portofolio', element: document.getElementById('portofolio') },
        { id: 'faq', element: document.getElementById('faq') },
        { id: 'kontak', element: document.getElementById('kontak') },
    ].filter(s => s.element !== null);

    let activeSectionId = 'hero';
    let isClickScrolling = false;
    let clickTimeout = null;

    const getActiveSection = () => {
        let current = sections[0]?.id || 'hero';
        const threshold = Math.min(220, window.innerHeight * 0.35);

        for (let i = 0; i < sections.length; i++) {
            const rect = sections[i].element.getBoundingClientRect();
            // If section top is above the threshold line (user has scrolled into it)
            if (rect.top <= threshold) {
                current = sections[i].id;
            }
        }
        return current;
    };

    const updateNavbarActiveLinks = (isScrolled, currentSection) => {
        navLinks.forEach(link => {
            const href = link.getAttribute('href')?.replace('#', '');
            const isActive = href === currentSection;

            if (isScrolled) {
                if (isActive) {
                    link.className = 'nav-link-item px-4 py-1.5 rounded-full text-xs font-bold text-white bg-gradient-to-r from-[#0284c7] to-[#0ea5e9] shadow-[0_2px_10px_rgba(2,132,199,0.35)] transition-all duration-200 whitespace-nowrap';
                } else {
                    link.className = 'nav-link-item px-3.5 py-1.5 rounded-full text-xs font-semibold text-slate-600 hover:text-[#0284c7] hover:bg-white/80 transition-all duration-150 whitespace-nowrap';
                }
            } else {
                if (isActive) {
                    link.className = 'nav-link-item px-4 py-1.5 rounded-full text-xs font-bold text-[#38bdf8] bg-white/20 shadow-xs border border-white/20 transition-all duration-150 whitespace-nowrap';
                } else {
                    link.className = 'nav-link-item px-3.5 py-1.5 rounded-full text-xs font-medium text-white/80 hover:text-white transition-all duration-150 whitespace-nowrap';
                }
            }
        });

        mobileNavLinks.forEach(link => {
            const href = link.getAttribute('href')?.replace('#', '');
            const isActive = href === currentSection;

            if (isActive) {
                link.className = 'mobile-nav-link text-sm font-bold text-[#38bdf8] bg-white/10 py-2 px-3 rounded-lg transition-colors border-l-2 border-[#38bdf8]';
            } else {
                link.className = 'mobile-nav-link text-sm font-semibold text-white/80 hover:text-[#38bdf8] py-2 px-3 rounded-lg hover:bg-white/5 transition-colors';
            }
        });
    };

    const updateNavbarOnScroll = (scrollY) => {
        if (!navbar) return;

        const isScrolled = scrollY > 30;
        if (!isClickScrolling) {
            activeSectionId = getActiveSection(scrollY);
        }

        if (isScrolled) {
            // Scrolled state: Solid Crisp White Glass Navbar with Vivid Blue Bottom Border
            navbar.classList.remove('bg-transparent', 'border-[#38bdf8]/35', 'shadow-[0_1px_15px_rgba(56,189,248,0.15)]', 'py-2.5', 'sm:py-3.5');
            navbar.classList.add('bg-white/90', 'backdrop-blur-xl', 'border-b', 'border-[#0ea5e9]/45', 'shadow-[0_4px_25px_rgba(2,132,199,0.08)]', 'py-2', 'sm:py-3');

            // Switch to full color transparent logo
            if (navLogoWhite && navLogoColor) {
                navLogoWhite.classList.add('hidden');
                navLogoWhite.classList.remove('block');
                navLogoColor.classList.remove('hidden');
                navLogoColor.classList.add('block');
            }

            if (pillDock) {
                pillDock.className = 'hidden lg:flex items-center gap-0.5 xl:gap-1 bg-slate-100/80 backdrop-blur-md p-1.5 rounded-full border border-slate-200/70 shadow-xs transition-all duration-300';
            }
            if (ctaBtn) {
                ctaBtn.className = 'hidden sm:inline-flex items-center gap-2 px-4 xl:px-5 py-2.5 rounded-full bg-gradient-to-r from-[#0284c7] to-[#0ea5e9] hover:from-[#0369a1] hover:to-[#0284c7] text-white font-heading font-bold text-xs sm:text-sm hover:scale-105 active:scale-95 transition-all duration-200 shadow-[0_2px_12px_rgba(2,132,199,0.35)] whitespace-nowrap';
            }
            if (mobileMenuBtn) {
                mobileMenuBtn.className = 'lg:hidden p-2 sm:p-2.5 rounded-lg sm:rounded-xl bg-slate-100 border border-slate-200/80 text-slate-700 hover:text-[#0284c7] hover:border-[#0284c7] hover:bg-sky-50 transition-colors';
            }
        } else {
            // Top/Hero state: 100% Transparent Navbar with Cyan/Sky Blue Bottom Border
            navbar.classList.remove('bg-white/90', 'backdrop-blur-xl', 'border-[#0ea5e9]/45', 'shadow-[0_4px_25px_rgba(2,132,199,0.08)]', 'py-2', 'sm:py-3');
            navbar.classList.add('bg-transparent', 'border-b', 'border-[#38bdf8]/35', 'shadow-[0_1px_15px_rgba(56,189,248,0.15)]', 'py-2.5', 'sm:py-3.5');

            // Switch to pure white logo
            if (navLogoWhite && navLogoColor) {
                navLogoColor.classList.add('hidden');
                navLogoColor.classList.remove('block');
                navLogoWhite.classList.remove('hidden');
                navLogoWhite.classList.add('block');
            }

            if (pillDock) {
                pillDock.className = 'hidden lg:flex items-center gap-0.5 xl:gap-1 bg-white/[0.07] backdrop-blur-md p-1.5 rounded-full border border-white/15 transition-all duration-300';
            }
            if (ctaBtn) {
                ctaBtn.className = 'hidden sm:inline-flex items-center gap-2 px-4 xl:px-5 py-2.5 rounded-full bg-[#38bdf8] text-[#050d1a] font-heading font-bold text-xs sm:text-sm hover:bg-white hover:text-[#0284c7] transition-all duration-200 shadow-[0_0_20px_rgba(56,189,248,0.35)] hover:scale-105 active:scale-95 whitespace-nowrap';
            }
            if (mobileMenuBtn) {
                mobileMenuBtn.className = 'lg:hidden p-2 sm:p-2.5 rounded-lg sm:rounded-xl bg-white/10 border border-white/20 text-white hover:text-[#38bdf8] transition-colors';
            }
        }

        updateNavbarActiveLinks(isScrolled, activeSectionId);
    };

    window.addEventListener('scroll', () => {
        updateNavbarOnScroll(window.scrollY);
    }, { passive: true });
    updateNavbarOnScroll(window.scrollY);

    /* ==========================================================================
       2. Lenis Smooth Scrolling & Anchor Click Interception
       ========================================================================== */
    let lenis = null;
    if (typeof window.Lenis !== 'undefined') {
        lenis = new window.Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            smoothWheel: true,
            touchMultiplier: 1.8,
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);

        lenis.on('scroll', (e) => {
            updateNavbarOnScroll(e.scroll);
        });
    }

    // Smooth scroll handler for all anchor links (#hero, #tentang-kami, #layanan, #coverage, #paket, #portofolio, #kontak)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#' || !targetId) return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                
                // Close mobile drawer if open
                if (typeof closeDrawer === 'function') {
                    closeDrawer();
                }

                // Immediately lock and highlight clicked section
                const sectionName = targetId.replace('#', '');
                activeSectionId = sectionName;
                isClickScrolling = true;
                clearTimeout(clickTimeout);
                clickTimeout = setTimeout(() => {
                    isClickScrolling = false;
                }, 1300);

                updateNavbarActiveLinks(window.scrollY > 30, sectionName);

                if (lenis) {
                    lenis.scrollTo(targetElement, {
                        offset: -70,
                        duration: 1.2,
                        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t))
                    });
                } else {
                    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - 70;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    /* ==========================================================================
       3. WebGL Moving Neon Aurora Wave Shader (#glCanvas)
       ========================================================================== */
    const canvas = document.getElementById('glCanvas');
    if (canvas) {
        const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
        if (gl) {
            const vsSource = `
                attribute vec2 position;
                void main() {
                    gl_Position = vec4(position, 0.0, 1.0);
                }
            `;

            const fsSource = `
                precision mediump float;
                uniform vec2 u_resolution;
                uniform float u_time;

                void main() {
                    vec2 uv = gl_FragCoord.xy / u_resolution.xy;
                    vec2 p = uv * 2.0 - 1.0;
                    p.x *= u_resolution.x / u_resolution.y;

                    float t = u_time * 0.30;
                    
                    // Fluid undulating harmonic waves
                    float wave1 = sin(p.x * 2.0 + t * 0.8 + sin(p.y * 1.3 + t * 0.5)) * 0.42;
                    float wave2 = cos(p.x * 2.4 - t * 0.6 + cos(p.y * 1.6 - t * 0.7)) * 0.32;
                    float wave3 = sin(p.x * 1.3 + p.y * 2.0 + t * 0.4) * 0.22;

                    // Ultra-thin, delicate, fine neon ribbon (Decay ~18.0)
                    float dist1 = abs(p.y + wave1 + wave2 * 0.45);
                    float dist2 = abs(p.y + wave2 + wave3 * 0.5 + 0.12);
                    
                    // Fine delicate line + soft minimal glow
                    float core1 = exp(-dist1 * 18.0) * 0.55;
                    float halo1 = exp(-dist1 * 4.2) * 0.20;
                    
                    float core2 = exp(-dist2 * 15.0) * 0.35;
                    float halo2 = exp(-dist2 * 3.8) * 0.15;

                    float neonGlow = core1 + halo1 + core2 + halo2;

                    // Deep Elegant Palette (No blinding white, just crisp telecom cyan)
                    vec3 darkNavy = vec3(0.020, 0.051, 0.102);
                    vec3 deepSapphire = vec3(0.035, 0.095, 0.190);
                    vec3 cyanGlow = vec3(0.15, 0.65, 0.92);
                    vec3 electricSky = vec3(0.25, 0.78, 0.98);

                    vec3 color = mix(darkNavy, deepSapphire, uv.y * 0.75 + 0.15);
                    
                    // Delicate glowing ribbon
                    vec3 ribbonColor = mix(cyanGlow, electricSky, sin(t * 0.7 + p.x * 1.2) * 0.5 + 0.5);
                    
                    color += ribbonColor * neonGlow * 0.34;

                    // Ambient depth
                    float topGlow = smoothstep(0.0, 1.0, uv.y) * 0.18;
                    color += vec3(0.03, 0.16, 0.35) * topGlow;

                    gl_FragColor = vec4(color, 0.75);
                }
            `;

            const createShader = (gl, type, source) => {
                const shader = gl.createShader(type);
                gl.shaderSource(shader, source);
                gl.compileShader(shader);
                if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
                    console.error('Shader compile error:', gl.getShaderInfoLog(shader));
                    gl.deleteShader(shader);
                    return null;
                }
                return shader;
            };

            const vertexShader = createShader(gl, gl.VERTEX_SHADER, vsSource);
            const fragmentShader = createShader(gl, gl.FRAGMENT_SHADER, fsSource);

            if (vertexShader && fragmentShader) {
                const program = gl.createProgram();
                gl.attachShader(program, vertexShader);
                gl.attachShader(program, fragmentShader);
                gl.linkProgram(program);

                if (gl.getProgramParameter(program, gl.LINK_STATUS)) {
                    gl.useProgram(program);

                    const positionBuffer = gl.createBuffer();
                    gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer);
                    const positions = new Float32Array([
                        -1.0, -1.0,
                         1.0, -1.0,
                        -1.0,  1.0,
                        -1.0,  1.0,
                         1.0, -1.0,
                         1.0,  1.0,
                    ]);
                    gl.bufferData(gl.ARRAY_BUFFER, positions, gl.STATIC_DRAW);

                    const positionLocation = gl.getAttribLocation(program, 'position');
                    gl.enableVertexAttribArray(positionLocation);
                    gl.vertexAttribPointer(positionLocation, 2, gl.FLOAT, false, 0, 0);

                    const resolutionLocation = gl.getUniformLocation(program, 'u_resolution');
                    const timeLocation = gl.getUniformLocation(program, 'u_time');

                    const resizeCanvas = () => {
                        const rect = canvas.getBoundingClientRect();
                        const width = Math.floor(rect.width) || window.innerWidth;
                        const height = Math.floor(rect.height) || window.innerHeight;
                        if (canvas.width !== width || canvas.height !== height) {
                            canvas.width = width;
                            canvas.height = height;
                            gl.viewport(0, 0, width, height);
                        }
                    };

                    window.addEventListener('resize', resizeCanvas);
                    resizeCanvas();

                    let startTime = performance.now();
                    const renderLoop = () => {
                        resizeCanvas();
                        const currentTime = (performance.now() - startTime) * 0.001;
                        gl.uniform2f(resolutionLocation, canvas.width, canvas.height);
                        gl.uniform1f(timeLocation, currentTime);
                        gl.drawArrays(gl.TRIANGLES, 0, 6);
                        requestAnimationFrame(renderLoop);
                    };
                    requestAnimationFrame(renderLoop);
                }
            }
        }
    }

    /* ==========================================================================
       4. Mobile Navigation Drawer
       ========================================================================== */
    const mobileCloseBtn = document.getElementById('mobileCloseBtn');
    const mobileDrawer = document.getElementById('mobileDrawer');
    const mobileOverlay = document.getElementById('mobileOverlay');
    const mobileLinks = document.querySelectorAll('.mobile-nav-link');

    function openDrawer() {
        if (mobileDrawer && mobileOverlay) {
            mobileDrawer.classList.remove('translate-x-full');
            mobileOverlay.classList.remove('opacity-0', 'pointer-events-none');
            mobileOverlay.classList.add('opacity-100', 'pointer-events-auto');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeDrawer() {
        if (mobileDrawer && mobileOverlay) {
            mobileDrawer.classList.add('translate-x-full');
            mobileOverlay.classList.remove('opacity-100', 'pointer-events-auto');
            mobileOverlay.classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = '';
        }
    }

    if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openDrawer);
    if (mobileCloseBtn) mobileCloseBtn.addEventListener('click', closeDrawer);
    if (mobileOverlay) mobileOverlay.addEventListener('click', closeDrawer);
    mobileLinks.forEach(link => link.addEventListener('click', closeDrawer));

    /* ==========================================================================
       5. FAQ Accordion Interaction
       ========================================================================== */
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const header = item.querySelector('.faq-header');
        const content = item.querySelector('.faq-content');
        const icon = item.querySelector('.faq-icon');

        if (header && content) {
            header.addEventListener('click', () => {
                const isOpen = item.classList.contains('open');

                faqItems.forEach(other => {
                    other.classList.remove('open');
                    const otherContent = other.querySelector('.faq-content');
                    const otherIcon = other.querySelector('.faq-icon');
                    if (otherContent) otherContent.style.maxHeight = '0px';
                    if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                });

                if (!isOpen) {
                    item.classList.add('open');
                    content.style.maxHeight = content.scrollHeight + 30 + 'px';
                    if (icon) icon.style.transform = 'rotate(180deg)';
                }
            });
        }
    });

    const initialOpenFaq = document.querySelector('.faq-item.open');
    if (initialOpenFaq) {
        const content = initialOpenFaq.querySelector('.faq-content');
        const icon = initialOpenFaq.querySelector('.faq-icon');
        if (content) content.style.maxHeight = content.scrollHeight + 30 + 'px';
        if (icon) icon.style.transform = 'rotate(180deg)';
    }

    /* ==========================================================================
       6. Live Coverage Checker (AJAX) + Quick City Buttons
       ========================================================================== */
    const coverageForm = document.getElementById('coverageForm');
    const coverageQuery = document.getElementById('coverageQuery');
    const coverageResult = document.getElementById('coverageResult');
    const coverageSubmitBtn = document.getElementById('coverageSubmitBtn');
    const quickCityButtons = document.querySelectorAll('.quick-city');

    const performCoverageCheck = async (queryText) => {
        if (!queryText.trim()) return;

        if (coverageSubmitBtn) {
            coverageSubmitBtn.disabled = true;
            coverageSubmitBtn.innerHTML = `
                <svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Mengecek Jaringan...</span>
            `;
        }

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const response = await fetch('/coverage/check', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ query: queryText })
            });

            const data = await response.json();

            if (coverageResult) {
                coverageResult.classList.remove('hidden');

                if (data.status === 'covered') {
                    coverageResult.innerHTML = `
                        <div class="p-6 rounded-2xl bg-sky-50 border border-sky-200 text-sky-900 shadow-sm">
                            <div class="flex items-start gap-3.5">
                                <div class="w-9 h-9 rounded-xl bg-[#0284c7] text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <iconify-icon icon="solar:check-circle-bold" width="22"></iconify-icon>
                                </div>
                                <div class="flex-grow">
                                    <div class="font-heading font-bold text-slate-900 text-base mb-1">${data.title}</div>
                                    <p class="text-xs text-slate-600 leading-relaxed mb-4">${data.message}</p>
                                    <div class="flex flex-wrap gap-2.5">
                                        <a href="#paket" class="px-4 py-2 rounded-lg bg-[#0284c7] text-white font-heading font-bold text-xs hover:bg-[#0369a1] transition-colors shadow-sm">
                                            Lihat Paket Internet
                                        </a>
                                        <a href="${data.whatsapp_url}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-lg bg-white text-slate-800 font-heading font-bold text-xs hover:bg-slate-50 transition-colors border border-slate-200 shadow-sm">
                                            WhatsApp Registrasi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    coverageResult.innerHTML = `
                        <div class="p-6 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 shadow-sm">
                            <div class="flex items-start gap-3.5">
                                <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <iconify-icon icon="solar:info-circle-bold" width="22"></iconify-icon>
                                </div>
                                <div class="flex-grow">
                                    <div class="font-heading font-bold text-slate-900 text-base mb-1">${data.title}</div>
                                    <p class="text-xs text-slate-600 leading-relaxed mb-4">${data.message}</p>
                                    <a href="${data.whatsapp_url}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-amber-500 text-white font-heading font-bold text-xs hover:bg-amber-600 transition-colors shadow-sm">
                                        <span>Request Perluasan Wilayah via WA</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                }
            }
        } catch (error) {
            console.error('Coverage error:', error);
            if (coverageResult) {
                coverageResult.classList.remove('hidden');
                coverageResult.innerHTML = `
                    <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-medium">
                        Terjadi kesalahan koneksi. Silakan coba kembali atau hubungi WhatsApp kami.
                    </div>
                `;
            }
        } finally {
            if (coverageSubmitBtn) {
                coverageSubmitBtn.disabled = false;
                coverageSubmitBtn.innerHTML = `
                    <span>Cek Coverage</span>
                    <iconify-icon icon="solar:radar-bold" width="18"></iconify-icon>
                `;
            }
        }
    };

    if (coverageForm && coverageQuery) {
        coverageForm.addEventListener('submit', (e) => {
            e.preventDefault();
            performCoverageCheck(coverageQuery.value);
        });
    }

    quickCityButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const city = btn.getAttribute('data-city');
            if (city && coverageQuery) {
                coverageQuery.value = city;
                performCoverageCheck(city);
            }
        });
    });

    /* ==========================================================================
       7. Back to Top Button Controller
       ========================================================================== */
    const backToTopBtn = document.querySelector('.back-to-top-btn');
    if (backToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTopBtn.classList.remove('opacity-0', 'invisible');
                backToTopBtn.classList.add('opacity-100', 'visible');
            } else {
                backToTopBtn.classList.remove('opacity-100', 'visible');
                backToTopBtn.classList.add('opacity-0', 'invisible');
            }
        }, { passive: true });

        backToTopBtn.addEventListener('click', () => {
            if (lenis) {
                lenis.scrollTo(0);
            } else {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }

    /* ==========================================================================
       8. Hero Section Opening Sequence (GSAP)
       ========================================================================== */
    const initScrollAnimations = () => {

        // Hero Section Opening Sequence (GSAP)
        if (typeof window.gsap !== 'undefined') {
            const heroSection = document.getElementById('hero');
            if (heroSection) {
                const heroBadge = heroSection.querySelector('.inline-flex.items-center.px-4');
                const heroH1 = heroSection.querySelector('h1');
                const heroDesc = heroSection.querySelector('p');
                const heroButtons = heroSection.querySelectorAll('a[href="#kontak"], a[href="#coverage"]');
                const heroMetrics = heroSection.querySelectorAll('.grid.grid-cols-2 > div, .grid.grid-cols-4 > div');
                const heroImage = heroSection.querySelector('img');

                const heroTl = window.gsap.timeline({ delay: 0.1 });

                if (heroBadge) heroTl.from(heroBadge, { y: -20, opacity: 0, duration: 0.7, ease: 'power3.out' });
                if (heroH1) heroTl.from(heroH1, { y: 30, opacity: 0, duration: 0.8, ease: 'power3.out' }, '-=0.4');
                if (heroDesc) heroTl.from(heroDesc, { y: 20, opacity: 0, duration: 0.7, ease: 'power3.out' }, '-=0.5');
                if (heroButtons.length) heroTl.from(heroButtons, { y: 20, opacity: 0, duration: 0.6, stagger: 0.1, ease: 'power3.out' }, '-=0.4');
                if (heroMetrics.length) heroTl.from(heroMetrics, { y: 20, opacity: 0, duration: 0.6, stagger: 0.08, ease: 'power3.out' }, '-=0.3');

                if (heroImage) {
                    window.gsap.to(heroImage, {
                        y: -10,
                        duration: 3.2,
                        ease: 'sine.inOut',
                        yoyo: true,
                        repeat: -1
                    });
                }
            }
        }
    };

    // Run animation initialization
    initScrollAnimations();

});
