@props([
    'coverageAreas' => collect([]),
    'coveredCities' => collect([]),
    'odps' => [],
])

@php
    $odpsList = !empty($odps) ? $odps : (new \App\Http\Controllers\CoverageController())->getOdps();
    $totalOdps = count($odpsList);
    $initialCoord = '-6.936988, 107.5904512';
@endphp

<section id="coverage" class="py-20 sm:py-28 px-4 sm:px-6 lg:px-8 relative z-10 w-full overflow-hidden bg-[#07172e] border-b border-white/10" style="background: radial-gradient(circle at 50% 15%, #0c274d 0%, #07172e 60%, #030a16 100%);">
    
    <!-- Cyber Geometric Background Grid & Glow Orbs -->
    <div class="absolute inset-0 pointer-events-none opacity-20" style="background-image: radial-gradient(rgba(56, 189, 248, 0.4) 1px, transparent 1px); background-size: 28px 28px;"></div>
    <div class="absolute inset-0 pointer-events-none opacity-15" style="background-image: linear-gradient(to right, rgba(56, 189, 248, 0.08) 1px, transparent 1px), linear-gradient(to bottom, rgba(56, 189, 248, 0.08) 1px, transparent 1px); background-size: 56px 56px;"></div>
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-[#38bdf8]/10 rounded-full blur-[130px] pointer-events-none" style="contain: paint; will-change: transform; transform: translateZ(0);"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-14 reveal-on-scroll">
            <h2 class="font-heading font-extrabold text-3xl sm:text-4xl lg:text-[44px] text-white tracking-tight leading-tight mb-4" data-reveal-words>
                Cek Jangkauan Internet di Lokasi Anda.
            </h2>
            
            <p class="font-sans text-sm sm:text-base text-slate-300 leading-relaxed">
                Cukup masukkan titik koordinat lokasi rumah atau kantor Anda untuk memeriksa ketersediaan jaringan fiber optik dan kesiapan pemasangan secara langsung.
            </p>
        </div>

        <!-- MAIN GIS COVERAGE CONTAINER (Centered Headless Engine) -->
        <div class="max-w-3xl mx-auto space-y-6 reveal-zoom" id="gisCoverageApp">
            
            <!-- Search & Input Card -->
            <div class="p-6 sm:p-8 rounded-3xl bg-white/[0.04] border border-sky-400/30 backdrop-blur-xl shadow-2xl relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex items-center justify-between gap-2 mb-3">
                    <label for="gisInputCoord" class="text-xs font-heading font-bold text-white uppercase tracking-wider flex items-center gap-2">
                        <iconify-icon icon="solar:point-on-map-bold" class="text-[#38bdf8] text-base"></iconify-icon>
                        <span>Titik Koordinat Lokasi Anda</span>
                    </label>
                    <span class="text-[11px] text-sky-400 font-mono flex items-center gap-1">
                        <iconify-icon icon="solar:info-circle-linear" width="14"></iconify-icon>
                        Format: Lat, Lng
                    </span>
                </div>

                <form id="gisCoverageForm" class="space-y-4">
                    <div class="relative">
                        <input 
                            type="text" 
                            id="gisInputCoord" 
                            value="{{ $initialCoord }}"
                            placeholder="Contoh: -6.936988, 107.5904512 atau nama jalan/kelurahan..." 
                            class="w-full pl-11 pr-28 sm:pr-32 py-3.5 sm:py-4 rounded-2xl bg-[#050d1a]/80 border border-white/20 text-white placeholder-slate-400 text-xs sm:text-sm font-mono focus:outline-none focus:ring-2 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all shadow-inner"
                            required
                        />
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-sky-400">
                            <iconify-icon icon="solar:map-point-wave-bold" width="20"></iconify-icon>
                        </div>
                        <div class="absolute inset-y-0 right-2 flex items-center">
                            <button 
                                type="button" 
                                id="gisGpsBtn" 
                                class="py-2 px-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-white font-heading font-bold text-xs flex items-center gap-1.5 transition-all cursor-pointer"
                                title="Gunakan koordinat GPS perangkat saya"
                            >
                                <iconify-icon icon="solar:gps-bold" class="text-[#38bdf8] text-sm"></iconify-icon>
                                <span class="hidden sm:inline">GPS Saya</span>
                            </button>
                        </div>
                    </div>

                    <!-- Action Button: Check -->
                    <div>
                        <button 
                            type="submit" 
                            id="gisSubmitBtn" 
                            class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-[#0284c7] via-[#0ea5e9] to-[#38bdf8] hover:from-[#0369a1] hover:to-[#0284c7] text-white font-heading font-extrabold text-sm flex items-center justify-center gap-2 transition-all duration-200 shadow-[0_0_25px_rgba(56,189,248,0.35)] hover:scale-[1.01] active:scale-98 cursor-pointer"
                        >
                            <span>Cek Jangkauan Jaringan</span>
                            <iconify-icon icon="solar:radar-bold" width="18" class="animate-pulse"></iconify-icon>
                        </button>
                    </div>

                    <!-- Detected Address Notification -->
                    <div id="gisAddressBox" class="hidden p-3.5 rounded-2xl bg-sky-950/70 border border-sky-400/30 text-xs text-sky-200 space-y-1.5 shadow-lg backdrop-blur-md">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-1.5">
                                <iconify-icon icon="solar:map-point-bold" class="text-[#38bdf8] text-sm"></iconify-icon>
                                <span class="font-bold text-white text-[11px] uppercase tracking-wider">Lokasi / Alamat Terdeteksi:</span>
                            </div>
                            <span id="gisAccuracyBadge" class="hidden"></span>
                        </div>
                        <span id="gisAddressText" class="block text-slate-200 leading-snug text-xs font-sans"></span>
                    </div>

                </form>
            </div>

            <!-- Dynamic Real-time ODP Evaluation Result Card -->
            <div id="gisResultContainer" class="hidden transition-all duration-300">
                <!-- Populated dynamically via JS -->
            </div>

        </div>

    </div>
</section>

<!-- Embedded ODP Master Data & Background Precision Engine Script (No Map Rendering) -->
<script>
window.msnOdpsData = @json($odpsList);

document.addEventListener('DOMContentLoaded', function () {
    // Geodesic straight-line distance in meters (Haversine formula)
    function calcStraightDistance(lat1, lon1, lat2, lon2) {
        const R = 6371008.8;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return Math.round(R * c);
    }

    // OSRM Real Street / Foot Routing API in background
    async function fetchStreetRouteDistance(userLat, userLng, odpLat, odpLng) {
        const routingUrls = [
            `https://routing.openstreetmap.de/routed-foot/route/v1/foot/${userLng},${userLat};${odpLng},${odpLat}?overview=false&continue_straight=true`,
            `https://router.project-osrm.org/route/v1/foot/${userLng},${userLat};${odpLng},${odpLat}?overview=false&continue_straight=true`,
            `https://router.project-osrm.org/route/v1/driving/${userLng},${userLat};${odpLng},${odpLat}?overview=false&continue_straight=true`
        ];

        for (const url of routingUrls) {
            try {
                const ctrl = new AbortController();
                const timeoutId = setTimeout(() => ctrl.abort(), 2500);
                const res = await fetch(url, { signal: ctrl.signal });
                clearTimeout(timeoutId);
                if (res.ok) {
                    const data = await res.json();
                    if (data.routes && data.routes[0] && data.routes[0].distance) {
                        return Math.round(data.routes[0].distance);
                    }
                }
            } catch (e) {
                // Try next endpoint
            }
        }
        return null;
    }

    let defaultLat = -6.936988;
    let defaultLng = 107.5904512;
    if (window.msnOdpsData && window.msnOdpsData.length > 0) {
        defaultLat = window.msnOdpsData[0].lat;
        defaultLng = window.msnOdpsData[0].lng;
    }

    // Evaluate Nearest ODP in background & build result card
    async function evaluateCoveragePoint(lat, lng) {
        const resultEl = document.getElementById('gisResultContainer');
        if (!resultEl) return;

        // Show loading state in result container
        resultEl.classList.remove('hidden');
        resultEl.innerHTML = `
            <div class="p-6 sm:p-7 rounded-3xl bg-white/[0.04] border border-sky-400/30 backdrop-blur-xl shadow-2xl flex flex-col items-center justify-center text-center space-y-3 animate-pulse">
                <div class="w-12 h-12 rounded-2xl bg-sky-500/20 border border-sky-400/40 text-sky-400 flex items-center justify-center shadow-[0_0_20px_rgba(56,189,248,0.3)]">
                    <iconify-icon icon="solar:radar-bold" class="text-2xl animate-spin"></iconify-icon>
                </div>
                <div>
                    <h4 class="font-heading font-bold text-white text-sm sm:text-base">Menganalisis Jangkauan Jaringan...</h4>
                    <p class="text-slate-400 text-xs font-mono mt-0.5">Memeriksa ketersediaan jalur kabel fiber optik ke lokasi Anda</p>
                </div>
            </div>
        `;

        // Find closest ODPs by straight distance
        const sortedOdps = (window.msnOdpsData || []).map(odp => {
            return {
                ...odp,
                straightDist: calcStraightDistance(lat, lng, odp.lat, odp.lng)
            };
        }).sort((a, b) => a.straightDist - b.straightDist);

        if (sortedOdps.length === 0) {
            resultEl.innerHTML = `
                <div class="p-5 rounded-2xl bg-rose-950/60 border border-rose-500/40 text-rose-200 text-xs text-center">
                    Data titik jaringan belum tersedia. Silakan hubungi admin.
                </div>
            `;
            return;
        }

        const topCandidate = sortedOdps[0];
        let finalDistance = topCandidate.straightDist;
        let isRoadRoute = false;

        // Fetch street routing from OSRM in background
        try {
            const streetDist = await fetchStreetRouteDistance(lat, lng, topCandidate.lat, topCandidate.lng);
            if (streetDist !== null && streetDist > 0) {
                finalDistance = streetDist;
                isRoadRoute = true;
            }
        } catch (err) {
            console.warn('Street route fallback to straight distance:', err);
        }

        const isCovered = finalDistance <= 300;
        const waNumber = '6289696629955';

        let badgeHtml = '';
        if (finalDistance <= 150) {
            badgeHtml = '<span class="px-3 py-1.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/40 text-[11px] font-mono font-bold flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>SANGAT BAGUS (FTTH IDEAL)</span>';
        } else if (finalDistance <= 250) {
            badgeHtml = '<span class="px-3 py-1.5 rounded-full bg-sky-500/20 text-sky-300 border border-sky-400/40 text-[11px] font-mono font-bold flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>BAGUS (LAYAK PASANG)</span>';
        } else if (finalDistance <= 300) {
            badgeHtml = '<span class="px-3 py-1.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-400/40 text-[11px] font-mono font-bold flex items-center gap-1.5">BATAS JANGKAUAN JARINGAN</span>';
        } else {
            badgeHtml = '<span class="px-3 py-1.5 rounded-full bg-rose-500/20 text-rose-300 border border-rose-400/40 text-[11px] font-mono font-bold flex items-center gap-1.5">DI LUAR JANGKAUAN STANDAR (>300m)</span>';
        }

        const waMsg = isCovered
            ? `Halo PT Media Solusi Network, saya sudah mengecek jangkauan di website pada koordinat ${lat.toFixed(6)}, ${lng.toFixed(6)}. Estimasi jarak rute kabel adalah ${finalDistance} meter. Mohon info promo dan jadwal pemasangannya.`
            : `Halo PT Media Solusi Network, saya mengecek koordinat ${lat.toFixed(6)}, ${lng.toFixed(6)} (jarak estimasi ${finalDistance}m). Saya ingin mengajukan permohonan survei perluasan jaringan ke lokasi saya.`;

        const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(waMsg)}`;

        resultEl.innerHTML = `
            <div class="p-6 sm:p-7 rounded-3xl ${isCovered ? 'bg-gradient-to-br from-emerald-950/80 via-[#071d2b]/90 to-[#05131f]/95 border border-emerald-400/40 shadow-[0_0_35px_rgba(16,185,129,0.25)]' : 'bg-gradient-to-br from-amber-950/70 via-[#1a1409]/90 to-[#0a0d14]/95 border border-amber-400/40 shadow-[0_0_35px_rgba(245,158,11,0.2)]'} backdrop-blur-xl animate-fade-in space-y-5">
                
                <div class="flex items-center justify-between gap-3 flex-wrap">
                    ${badgeHtml}
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-mono text-white font-bold bg-white/10 px-3 py-1.5 rounded-xl border border-white/15">
                            ${isRoadRoute ? '🛣️ Rute Jalan:' : '📏 Jarak Garis:'} ${finalDistance} Meter
                        </span>
                        ${isRoadRoute ? `
                            <span class="text-[11px] font-mono text-slate-300 bg-white/5 px-2.5 py-1.5 rounded-xl border border-white/10">
                                Garis Lurus: ${topCandidate.straightDist}m
                            </span>
                        ` : ''}
                    </div>
                </div>

                <div>
                    <h3 class="font-heading font-extrabold text-white text-lg sm:text-xl mb-1.5 flex items-center gap-2">
                        <iconify-icon icon="${isCovered ? 'solar:check-circle-bold' : 'solar:danger-triangle-bold'}" class="${isCovered ? 'text-emerald-400' : 'text-amber-400'} text-2xl shrink-0"></iconify-icon>
                        <span>${isCovered ? 'Lokasi Anda Tercover Jaringan Fiber Optic!' : 'Lokasi Berjarak Lebih dari 300m dari Titik Jaringan'}</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-200 leading-relaxed">
                        ${isCovered 
                            ? `Kabar baik! Titik koordinat Anda berjarak <b>${finalDistance} meter</b> dari titik distribusi jaringan fiber optik. Jalur kabel siap ditarik ke lokasi Anda.`
                            : `Titik koordinat Anda berjarak <b>${finalDistance} meter</b> dari jaringan terdekat (melebihi jarak standar 300m). Tim kami siap melakukan pengecekan penambahan tiang atau perluasan jaringan.`}
                    </p>
                </div>



                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-3 pt-1">
                    ${isCovered ? `
                        <a href="#paket" class="flex-1 min-w-[150px] px-5 py-3.5 rounded-xl bg-[#38bdf8] text-[#050d1a] font-heading font-extrabold text-xs sm:text-sm text-center hover:bg-white hover:text-[#0284c7] transition-all shadow-lg shadow-sky-500/20 flex items-center justify-center gap-2">
                            <span>Pilih Paket Internet</span>
                            <iconify-icon icon="solar:arrow-right-linear" width="16"></iconify-icon>
                        </a>
                        <a href="${waUrl}" target="_blank" rel="noopener noreferrer" class="flex-1 min-w-[150px] px-5 py-3.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-heading font-extrabold text-xs sm:text-sm text-center transition-all shadow-lg shadow-emerald-500/20 flex items-center justify-center gap-2">
                            <iconify-icon icon="logos:whatsapp-icon" width="16"></iconify-icon>
                            <span>Daftar via WhatsApp</span>
                        </a>
                    ` : `
                        <a href="${waUrl}" target="_blank" rel="noopener noreferrer" class="w-full px-5 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-heading font-extrabold text-xs sm:text-sm text-center transition-all shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
                            <iconify-icon icon="logos:whatsapp-icon" width="16"></iconify-icon>
                            <span>Ajukan Perluasan Jaringan via WhatsApp</span>
                        </a>
                    `}
                </div>

            </div>
        `;
    }

    // Reverse geocode in background to get friendly address name
    async function reverseGeocode(lat, lng, accuracy = null) {
        const addrBox = document.getElementById('gisAddressBox');
        const addrText = document.getElementById('gisAddressText');
        const accBadge = document.getElementById('gisAccuracyBadge');
        
        if (addrBox) addrBox.classList.remove('hidden');
        if (addrText) addrText.textContent = 'Mencari detail alamat di sistem...';

        if (accBadge) {
            accBadge.classList.remove('hidden');
            if (accuracy !== null && accuracy > 0) {
                if (accuracy <= 25) {
                    accBadge.className = 'text-[10px] font-mono px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 flex items-center gap-1 shrink-0';
                    accBadge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span><span>GPS Presisi ±${accuracy}m</span>`;
                } else {
                    accBadge.className = 'text-[10px] font-mono px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-400/30 flex items-center gap-1 shrink-0';
                    accBadge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span><span>Estimasi ±${accuracy}m</span>`;
                }
            } else {
                accBadge.className = 'text-[10px] font-mono px-2 py-0.5 rounded-full bg-sky-500/20 text-sky-300 border border-sky-400/30 flex items-center gap-1 shrink-0';
                accBadge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span><span>Titik Koordinat</span>`;
            }
        }

        try {
            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`, {
                headers: { 'Accept-Language': 'id' }
            });
            const data = await res.json();
            if (data && data.display_name) {
                if (addrText) addrText.textContent = data.display_name;
            } else {
                if (addrText) addrText.textContent = `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            }
        } catch (e) {
            if (addrText) addrText.textContent = `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            console.warn('Geocode error:', e);
        }
    }

    // Helper to extract coordinates from text
    function extractCoordinates(input) {
        if (!input) return null;
        const trimmed = input.trim();
        const coordMatch = trimmed.match(/(-?\d+(?:\.\d+)?)\s*[,;\s]\s*(-?\d+(?:\.\d+)?)/);
        if (coordMatch) {
            let lat = parseFloat(coordMatch[1]);
            let lng = parseFloat(coordMatch[2]);
            // Reverse if lat and lng were swapped
            if (lat > 60 && lng < 10) {
                const temp = lat;
                lat = lng;
                lng = temp;
            }
            if (!isNaN(lat) && !isNaN(lng)) {
                return { lat, lng };
            }
        }
        return null;
    }

    // Form Submit Handler
    document.getElementById('gisCoverageForm')?.addEventListener('submit', async function (e) {
        e.preventDefault();
        const inputVal = document.getElementById('gisInputCoord').value.trim();
        if (!inputVal) return;

        const coords = extractCoordinates(inputVal);
        if (coords) {
            await evaluateCoveragePoint(coords.lat, coords.lng);
            reverseGeocode(coords.lat, coords.lng, null);
        } else {
            const submitBtn = document.getElementById('gisSubmitBtn');
            const originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `<iconify-icon icon="solar:radar-bold" class="text-white animate-spin text-lg"></iconify-icon><span>Mencari Koordinat...</span>`;
            }

            try {
                const geoRes = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(inputVal + ', Indonesia')}&limit=1`, {
                    headers: { 'Accept-Language': 'id' }
                });
                const geoData = await geoRes.json();
                if (geoData && geoData.length > 0) {
                    const lat = parseFloat(geoData[0].lat);
                    const lng = parseFloat(geoData[0].lon);
                    document.getElementById('gisInputCoord').value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                    await evaluateCoveragePoint(lat, lng);
                    reverseGeocode(lat, lng, null);
                } else {
                    const addrBox = document.getElementById('gisAddressBox');
                    const addrText = document.getElementById('gisAddressText');
                    if (addrBox && addrText) {
                        addrBox.classList.remove('hidden');
                        addrText.innerHTML = 'Alamat tidak ditemukan. Silakan masukkan format koordinat seperti: <span class="font-mono text-sky-300">-6.936988, 107.5904512</span>';
                    }
                }
            } catch (err) {
                console.error(err);
                const addrBox = document.getElementById('gisAddressBox');
                const addrText = document.getElementById('gisAddressText');
                if (addrBox && addrText) {
                    addrBox.classList.remove('hidden');
                    addrText.innerHTML = 'Pencarian alamat offline/gagal. Silakan ketik titik koordinat langsung (contoh: <span class="font-mono text-sky-300">-6.936988, 107.5904512</span>).';
                }
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHtml;
                }
            }
        }
    });

    // Fast Geolocation Engine with IP Location Fallback (Zero Blocking Alerts)
    async function acquireSmartLocation(onSuccess, onError) {
        let isResolved = false;

        const deliverLocation = (lat, lng, accuracy, sourceName) => {
            if (isResolved) return;
            isResolved = true;
            onSuccess({
                coords: { latitude: lat, longitude: lng, accuracy: accuracy },
                source: sourceName
            });
        };

        const tryIpFallback = async () => {
            try {
                const res = await fetch('https://ipwho.is/', { signal: AbortSignal.timeout(3000) });
                if (res.ok) {
                    const data = await res.json();
                    if (data && data.success && data.latitude && data.longitude) {
                        deliverLocation(parseFloat(data.latitude), parseFloat(data.longitude), 500, 'Jaringan IP Provider');
                        return;
                    }
                }
            } catch (e) {}

            try {
                const res2 = await fetch('https://ipapi.co/json/', { signal: AbortSignal.timeout(3000) });
                if (res2.ok) {
                    const data2 = await res2.json();
                    if (data2 && data2.latitude && data2.longitude) {
                        deliverLocation(parseFloat(data2.latitude), parseFloat(data2.longitude), 500, 'Jaringan IP Provider');
                        return;
                    }
                }
            } catch (e) {}

            if (!isResolved) {
                isResolved = true;
                onError();
            }
        };

        // Try browser geolocation first with short 3s timeout
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (pos) {
                    deliverLocation(pos.coords.latitude, pos.coords.longitude, Math.round(pos.coords.accuracy || 20), 'GPS Perangkat');
                },
                function (err) {
                    // If desktop/laptop or timeout, silently fallback to IP location
                    tryIpFallback();
                },
                { enableHighAccuracy: false, timeout: 3000, maximumAge: 60000 }
            );

            // Safety timer if browser geolocation hangs indefinitely without callback
            setTimeout(() => {
                if (!isResolved) {
                    tryIpFallback();
                }
            }, 3200);
        } else {
            tryIpFallback();
        }
    }

    // GPS Button Handler (Smooth Inline Notification, Zero Blocking Alert)
    document.getElementById('gisGpsBtn')?.addEventListener('click', function () {
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = `<iconify-icon icon="solar:radar-bold" class="text-sky-400 animate-spin text-base"></iconify-icon><span class="hidden sm:inline">Mendeteksi...</span>`;

        acquireSmartLocation(
            async function (pos) {
                btn.disabled = false;
                btn.innerHTML = `<iconify-icon icon="solar:check-circle-bold" class="text-emerald-400 text-base"></iconify-icon><span class="hidden sm:inline">Terkunci</span>`;
                setTimeout(() => {
                    btn.innerHTML = `<iconify-icon icon="solar:gps-bold" class="text-[#38bdf8] text-sm"></iconify-icon><span class="hidden sm:inline">GPS Saya</span>`;
                }, 3000);

                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                const accuracy = pos.coords.accuracy;

                document.getElementById('gisInputCoord').value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                await evaluateCoveragePoint(lat, lng);
                reverseGeocode(lat, lng, accuracy);
            },
            function () {
                btn.disabled = false;
                btn.innerHTML = `<iconify-icon icon="solar:gps-bold" class="text-[#38bdf8] text-sm"></iconify-icon><span class="hidden sm:inline">GPS Saya</span>`;
                
                const addrBox = document.getElementById('gisAddressBox');
                const addrText = document.getElementById('gisAddressText');
                const accBadge = document.getElementById('gisAccuracyBadge');
                if (addrBox && addrText) {
                    addrBox.classList.remove('hidden');
                    if (accBadge) {
                        accBadge.className = 'text-[10px] font-mono px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-400/30';
                        accBadge.textContent = 'Manual';
                    }
                    addrText.innerHTML = 'Lokasi perangkat tidak dapat dijangkau otomatis. Silakan masukkan koordinat lokasi Anda (contoh: <span class="font-mono text-sky-300">-6.936988, 107.5904512</span>).';
                }
            }
        );
    });



    // Initial evaluation on page load
    setTimeout(() => {
        evaluateCoveragePoint(defaultLat, defaultLng);
    }, 300);
});
</script>
