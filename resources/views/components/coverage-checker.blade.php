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
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/[0.08] border border-sky-400/30 text-xs font-mono text-[#38bdf8] uppercase tracking-wider mb-4 font-semibold shadow-[0_0_15px_rgba(56,189,248,0.2)] backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span>GIS ODP Precision Coverage Engine</span>
            </div>
            
            <h2 class="font-heading font-extrabold text-3xl sm:text-4xl lg:text-[44px] text-white tracking-tight leading-tight mb-4" data-reveal-words>
                Cek Coverage Lokasi ke ODP Terdekat.
            </h2>
            
            <p class="font-sans text-sm sm:text-base text-slate-300 leading-relaxed">
                Periksa kelayakan tarikan kabel dropcore fiber optik mengikuti rute jalan, estimasi jarak meter ke Optical Distribution Point (ODP), dan ketersediaan port secara presisi & real-time.
            </p>
        </div>

        <!-- 2-COLUMN MAIN GIS COVERAGE CONTAINER (Like IMS-v2) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 items-start reveal-zoom" id="gisCoverageApp">
            
            <!-- LEFT COLUMN: CONTROLS & COVERAGE RESULT CARD (5 COLS) -->
            <div class="lg:col-span-5 space-y-4">
                
                <!-- Search & Input Box -->
                <div class="p-5 sm:p-6 rounded-3xl bg-white/[0.04] border border-sky-400/30 backdrop-blur-xl shadow-2xl">
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <label class="text-xs font-heading font-bold text-white uppercase tracking-wider flex items-center gap-1.5">
                            <iconify-icon icon="solar:point-on-map-bold" class="text-[#38bdf8] text-base"></iconify-icon>
                            <span>Titik Lokasi / Alamat Anda</span>
                        </label>
                        <span class="text-[10px] text-sky-400 font-mono">💡 Pin dapat digeser di peta</span>
                    </div>

                    <form id="gisCoverageForm" class="space-y-3">
                        <div class="relative">
                            <input 
                                type="text" 
                                id="gisInputCoord" 
                                value="{{ $initialCoord }}"
                                placeholder="-6.936988, 107.5904512 atau nama jalan/kelurahan..." 
                                class="w-full pl-10 pr-4 py-3.5 rounded-2xl bg-[#050d1a]/80 border border-white/20 text-white placeholder-slate-400 text-xs sm:text-sm font-mono focus:outline-none focus:ring-2 focus:ring-[#38bdf8] focus:border-[#38bdf8] transition-all shadow-inner"
                                required
                            />
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-sky-400">
                                <iconify-icon icon="solar:map-point-wave-bold" width="18"></iconify-icon>
                            </div>
                        </div>

                        <!-- Action Buttons: GPS & Check -->
                        <div class="grid grid-cols-2 gap-2">
                            <button 
                                type="button" 
                                id="gisGpsBtn" 
                                class="py-3 px-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-white font-heading font-bold text-xs flex items-center justify-center gap-1.5 transition-all cursor-pointer"
                            >
                                <iconify-icon icon="solar:gps-bold" class="text-[#38bdf8] text-base"></iconify-icon>
                                <span>GPS Lokasi Saya</span>
                            </button>

                            <button 
                                type="submit" 
                                id="gisSubmitBtn" 
                                class="py-3 px-3 rounded-xl bg-gradient-to-r from-[#0284c7] via-[#0ea5e9] to-[#38bdf8] hover:from-[#0369a1] hover:to-[#0284c7] text-white font-heading font-extrabold text-xs flex items-center justify-center gap-1.5 transition-all duration-200 shadow-[0_0_20px_rgba(56,189,248,0.35)] hover:scale-[1.02] active:scale-95 cursor-pointer"
                            >
                                <span>Cek Jarak ODP</span>
                                <iconify-icon icon="solar:radar-bold" width="16" class="animate-pulse"></iconify-icon>
                            </button>
                        </div>

                        <!-- Detected Address Notification & GPS Accuracy -->
                        <div id="gisAddressBox" class="hidden p-3 rounded-2xl bg-sky-950/70 border border-sky-400/30 text-[11px] text-sky-200 space-y-1.5 shadow-lg backdrop-blur-md">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-1.5">
                                    <iconify-icon icon="solar:map-point-bold" class="text-[#38bdf8] text-sm"></iconify-icon>
                                    <span class="font-bold text-white text-[10px] uppercase tracking-wider">Alamat Titik Terpilih:</span>
                                </div>
                                <span id="gisAccuracyBadge" class="hidden"></span>
                            </div>
                            <span id="gisAddressText" class="block text-slate-200 leading-snug text-[11.5px] font-sans"></span>
                            <div class="text-[10px] text-sky-300/80 font-sans flex items-center gap-1 pt-1 border-t border-white/5">
                                <span>💡 Pin merah 📍 dapat digeser ke titik atap rumah Anda jika lokasi kurang pas.</span>
                            </div>
                        </div>

                        <!-- Master ODP Preset Selector (From Real Database) -->
                        <div class="pt-3 border-t border-white/10 space-y-1.5">
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="text-slate-300 font-bold flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                    <span>Pilih Titik ODP Master:</span>
                                </span>
                                <span class="text-sky-400 font-mono text-[10px]">{{ $totalOdps }} ODP Aktif</span>
                            </div>
                            
                            <select 
                                id="gisOdpSelect"
                                class="w-full py-2.5 px-3 rounded-xl text-xs bg-[#050d1a] border border-white/20 text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#38bdf8] cursor-pointer"
                            >
                                <option value="">-- Pilih Titik ODP di Bandung & Sekitarnya ({{ $totalOdps }} Node) --</option>
                                @php
                                    $groupedOdps = collect($odpsList)->groupBy('olt_name');
                                @endphp
                                @foreach($groupedOdps as $oltName => $items)
                                    <optgroup label="🏢 {{ $oltName }} ({{ count($items) }} ODP)" class="bg-slate-900 text-sky-300 font-bold">
                                        @foreach($items as $item)
                                            <option value="{{ $item['lat'] }},{{ $item['lng'] }}" class="bg-slate-950 text-white font-normal">
                                                {{ $item['name_odp'] }} ({{ $item['kode_odp'] }}) - Port {{ $item['used_ports'] }}/{{ $item['capacity_odp'] }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <!-- Quick City Buttons -->
                    <div class="flex flex-wrap items-center gap-1.5 mt-4 pt-3 border-t border-white/10 text-xs">
                        <span class="text-slate-400 font-mono text-[10.5px]">Wilayah:</span>
                        <button type="button" class="gis-quick-btn px-2.5 py-1 rounded-lg bg-white/5 hover:bg-sky-500/20 text-slate-300 hover:text-white border border-white/10 text-[11px] transition-colors cursor-pointer" data-coord="-6.936988, 107.5904512">Turangga Bandung</button>
                        <button type="button" class="gis-quick-btn px-2.5 py-1 rounded-lg bg-white/5 hover:bg-sky-500/20 text-slate-300 hover:text-white border border-white/10 text-[11px] transition-colors cursor-pointer" data-coord="-6.921477, 107.607421">Lengkong</button>
                        <button type="button" class="gis-quick-btn px-2.5 py-1 rounded-lg bg-white/5 hover:bg-sky-500/20 text-slate-300 hover:text-white border border-white/10 text-[11px] transition-colors cursor-pointer" data-coord="-7.032611, 107.518652">Soreang</button>
                        <button type="button" class="gis-quick-btn px-2.5 py-1 rounded-lg bg-white/5 hover:bg-sky-500/20 text-slate-300 hover:text-white border border-white/10 text-[11px] transition-colors cursor-pointer" data-coord="-6.890632, 107.616335">Dago / Coblong</button>
                    </div>
                </div>

                <!-- Dynamic Real-time ODP Evaluation Result Card -->
                <div id="gisResultContainer" class="hidden transition-all duration-300">
                    <!-- Populated dynamically via JS -->
                </div>

            </div>

            <!-- RIGHT COLUMN: LEAFLET GIS INTERACTIVE MAP CANVAS (7 COLS) -->
            <div class="lg:col-span-7">
                <div class="rounded-3xl bg-white/[0.04] border border-sky-400/30 overflow-hidden shadow-2xl backdrop-blur-xl flex flex-col">
                    
                    <!-- Map Toolbar / Layers Bar -->
                    <div class="px-4 py-2.5 border-b border-white/10 flex flex-wrap items-center justify-between gap-2.5 text-xs bg-[#050d1a]/80">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block animate-ping"></span>
                            <strong class="font-heading font-bold text-white text-xs">
                                Peta Live Network Fiber MSN
                            </strong>
                            <span class="text-[9px] px-2 py-0.5 rounded-full font-mono font-bold bg-sky-500/20 text-sky-300 border border-sky-400/30">
                                {{ $totalOdps }} ODP Terdata
                            </span>
                        </div>

                        <!-- Map Layer Switches -->
                        <div class="flex items-center gap-1.5">
                            <button type="button" id="gisLayerRoadmap" class="gis-layer-btn px-2.5 py-1 rounded-lg font-bold text-[10.5px] transition-all bg-[#0284c7] text-white border border-[#0284c7] shadow-xs cursor-pointer">
                                🗺️ Peta
                            </button>
                            <button type="button" id="gisLayerHybrid" class="gis-layer-btn px-2.5 py-1 rounded-lg font-bold text-[10.5px] transition-all bg-white/5 hover:bg-white/15 text-slate-300 border border-white/10 cursor-pointer">
                                🛰️ Satelit
                            </button>
                            <button type="button" id="gisLayerTerrain" class="gis-layer-btn px-2.5 py-1 rounded-lg font-bold text-[10.5px] transition-all bg-white/5 hover:bg-white/15 text-slate-300 border border-white/10 cursor-pointer">
                                ⛰️ Terrain
                            </button>
                            <button type="button" id="gisFitBounds" class="px-2.5 py-1 rounded-lg text-sky-400 hover:text-white bg-white/5 hover:bg-white/15 border border-white/10 text-[10.5px] font-bold transition flex items-center gap-1 cursor-pointer">
                                🔄 Fit
                            </button>
                        </div>
                    </div>

                    <!-- Leaflet GIS Map Canvas Container -->
                    <div id="gisCoverageMapCanvas" class="w-full h-[460px] sm:h-[520px] bg-[#050d1a] relative z-10"></div>

                    <!-- Map Footer Legend -->
                    <div class="px-4 py-2.5 border-t border-white/10 flex flex-wrap items-center justify-between gap-3 text-[10.5px] text-slate-400 bg-[#050d1a]/90">
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-sky-400 border border-white inline-block"></span>
                                <span class="text-slate-300 font-medium">ODP Ada Slot</span>
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500 border border-white inline-block"></span>
                                <span class="text-slate-300 font-medium">ODP Penuh</span>
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-red-600 border border-white inline-block text-[8px] text-white flex items-center justify-center">📍</span>
                                <span class="text-slate-300 font-medium">Titik Anda (Bisa Digeser)</span>
                            </span>
                        </div>
                        <div class="flex items-center gap-2 text-sky-400 font-semibold text-[10px]">
                            <span class="flex items-center gap-1">
                                <span class="w-3 h-0.5 bg-sky-400 inline-block"></span>
                                <span>Rute Jalan Kabel Dropcore</span>
                            </span>
                            <span>•</span>
                            <span class="text-emerald-400">Max Jangkauan: &le; 300m</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>

<!-- Leaflet CDN Styles & Scripts -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Embedded ODP Master Data & GIS Precision Engine Script -->
<script>
window.msnOdpsData = @json($odpsList);

document.addEventListener('DOMContentLoaded', function () {
    const mapEl = document.getElementById('gisCoverageMapCanvas');
    if (!mapEl || typeof L === 'undefined') return;

    let mapInstance = null;
    let odpMarkersLayer = L.layerGroup();
    let userMarkerLayer = L.layerGroup();
    let connectionLineLayer = L.layerGroup();

    const tileLayers = {
        roadmap: L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            tileSize: 256
        }),
        hybrid: L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            tileSize: 256
        }),
        terrain: L.tileLayer('https://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            tileSize: 256
        })
    };

    let activeLayerKey = 'roadmap';

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

    // OSRM Real Street / Foot Routing API
    async function fetchStreetRoute(userLat, userLng, odpLat, odpLng) {
        const routingUrls = [
            `https://routing.openstreetmap.de/routed-foot/route/v1/foot/${userLng},${userLat};${odpLng},${odpLat}?overview=full&geometries=geojson&continue_straight=true`,
            `https://router.project-osrm.org/route/v1/foot/${userLng},${userLat};${odpLng},${odpLat}?overview=full&geometries=geojson&continue_straight=true`,
            `https://router.project-osrm.org/route/v1/driving/${userLng},${userLat};${odpLng},${odpLat}?overview=full&geometries=geojson&continue_straight=true`
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
                        const coords = (data.routes[0].geometry && data.routes[0].geometry.coordinates)
                            ? data.routes[0].geometry.coordinates.map(c => [c[1], c[0]])
                            : null;
                        return {
                            distance: Math.round(data.routes[0].distance),
                            geometry: coords
                        };
                    }
                }
            } catch (e) {
                // Try next endpoint
            }
        }
        return null;
    }

    // Initialize Map
    let defaultLat = -6.936988;
    let defaultLng = 107.5904512;
    if (window.msnOdpsData && window.msnOdpsData.length > 0) {
        defaultLat = window.msnOdpsData[0].lat;
        defaultLng = window.msnOdpsData[0].lng;
    }

    mapInstance = L.map('gisCoverageMapCanvas', {
        center: [defaultLat, defaultLng],
        zoom: 16,
        preferCanvas: true,
        attributionControl: false
    });

    tileLayers.roadmap.addTo(mapInstance);
    odpMarkersLayer.addTo(mapInstance);
    connectionLineLayer.addTo(mapInstance);
    userMarkerLayer.addTo(mapInstance);

    // Plot ODP Markers Cleanly without any green radius circles
    function renderOdps() {
        odpMarkersLayer.clearLayers();

        (window.msnOdpsData || []).forEach(odp => {
            const hasSlot = odp.has_slot;
            const markerColor = hasSlot ? '#38bdf8' : '#f43f5e';

            const iconHtml = `
                <div style="position: relative; width: 22px; height: 22px; background: ${markerColor}; border: 2px solid #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 10px rgba(0,0,0,0.5);">
                    <div style="width: 6px; height: 6px; background: #ffffff; border-radius: 50%;"></div>
                </div>
            `;
            const customIcon = L.divIcon({
                className: 'odp-marker-icon',
                html: iconHtml,
                iconSize: [22, 22],
                iconAnchor: [11, 11]
            });

            const marker = L.marker([odp.lat, odp.lng], { icon: customIcon });
            
            const popupHtml = `
                <div style="font-family: sans-serif; min-width: 200px; padding: 2px;">
                    <div style="font-weight: 800; font-size: 13px; color: #0284c7; margin-bottom: 2px;">
                        ${odp.name_odp}
                    </div>
                    <div style="font-size: 11px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                        ${odp.olt_name} • ${odp.kode_pon}
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 11px; margin-bottom: 4px; padding: 4px 6px; background: #f1f5f9; border-radius: 6px;">
                        <span>Kapasitas Port:</span>
                        <strong style="color: ${hasSlot ? '#059669' : '#dc2626'}">${odp.used_ports} / ${odp.capacity_odp} Port</strong>
                    </div>
                    <div style="font-size: 10px; color: #64748b; font-family: monospace;">
                        ${odp.lat.toFixed(6)}, ${odp.lng.toFixed(6)}
                    </div>
                </div>
            `;
            marker.bindPopup(popupHtml);
            odpMarkersLayer.addLayer(marker);
        });
    }

    renderOdps();

    // Map Layer Controls
    function setMapLayer(key) {
        if (tileLayers[activeLayerKey]) {
            mapInstance.removeLayer(tileLayers[activeLayerKey]);
        }
        activeLayerKey = key;
        tileLayers[key].addTo(mapInstance);

        document.querySelectorAll('.gis-layer-btn').forEach(btn => {
            btn.classList.remove('bg-[#0284c7]', 'text-white', 'border-[#0284c7]');
            btn.classList.add('bg-white/5', 'text-slate-300', 'border-white/10');
        });
        const activeBtn = document.getElementById('gisLayer' + key.charAt(0).toUpperCase() + key.slice(1));
        if (activeBtn) {
            activeBtn.classList.remove('bg-white/5', 'text-slate-300', 'border-white/10');
            activeBtn.classList.add('bg-[#0284c7]', 'text-white', 'border-[#0284c7]');
        }
    }

    document.getElementById('gisLayerRoadmap')?.addEventListener('click', () => setMapLayer('roadmap'));
    document.getElementById('gisLayerHybrid')?.addEventListener('click', () => setMapLayer('hybrid'));
    document.getElementById('gisLayerTerrain')?.addEventListener('click', () => setMapLayer('terrain'));

    document.getElementById('gisFitBounds')?.addEventListener('click', () => {
        if (window.msnOdpsData && window.msnOdpsData.length > 0) {
            const group = L.featureGroup([odpMarkersLayer, userMarkerLayer]);
            mapInstance.fitBounds(group.getBounds(), { padding: [40, 40] });
        }
    });

    // Evaluate Nearest ODP & Draw Street Routing Line (Following Roads)
    async function evaluateCoveragePoint(lat, lng) {
        userMarkerLayer.clearLayers();
        connectionLineLayer.clearLayers();

        // Draggable Google Maps Red Pin
        const pinHtml = `
            <div style="position: relative; width: 34px; height: 46px; display: flex; justify-content: center;">
                <div style="position: absolute; bottom: -2px; left: 50%; transform: translateX(-50%); width: 22px; height: 10px; border-radius: 50%; background: rgba(234, 67, 53, 0.4); border: 1.5px solid #EA4335;"></div>
                <svg width="34" height="46" viewBox="0 0 34 46" fill="none" xmlns="http://www.w3.org/2000/svg" style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.5)); position: relative; z-index: 10;">
                    <path d="M17 0C7.611 0 0 7.611 0 17C0 29.75 17 46 17 46C17 46 34 29.75 34 17C34 7.611 26.389 0 17 0Z" fill="#EA4335"/>
                    <path d="M17 1C8.163 1 1 8.163 1 17C1 28.5 17 44.5 17 44.5C17 44.5 33 28.5 33 17C33 8.163 25.837 1 17 1Z" stroke="#B31412" stroke-width="1.2"/>
                    <circle cx="17" cy="16" r="6" fill="#7A0000"/>
                    <circle cx="17" cy="16" r="2.5" fill="#FFFFFF"/>
                </svg>
            </div>
        `;
        const userIcon = L.divIcon({
            className: 'user-pin-marker',
            html: pinHtml,
            iconSize: [34, 46],
            iconAnchor: [17, 46]
        });

        const userMarker = L.marker([lat, lng], {
            icon: userIcon,
            draggable: true
        });

        userMarker.on('dragend', function (e) {
            const pos = e.target.getLatLng();
            document.getElementById('gisInputCoord').value = `${pos.lat.toFixed(6)}, ${pos.lng.toFixed(6)}`;
            evaluateCoveragePoint(pos.lat, pos.lng);
            reverseGeocode(pos.lat, pos.lng, null);
        });

        userMarkerLayer.addLayer(userMarker);

        // Find top 6 closest ODPs by straight distance first
        const sortedOdps = (window.msnOdpsData || []).map(odp => {
            return {
                ...odp,
                straightDist: calcStraightDistance(lat, lng, odp.lat, odp.lng)
            };
        }).sort((a, b) => a.straightDist - b.straightDist);

        if (sortedOdps.length === 0) return;

        // Take top 4 candidates and fetch real street routing for the closest one
        const topCandidate = sortedOdps[0];
        let finalDistance = topCandidate.straightDist;
        let routeCoordinates = null;

        // Fetch street routing from OSRM
        try {
            const routeResult = await fetchStreetRoute(lat, lng, topCandidate.lat, topCandidate.lng);
            if (routeResult && routeResult.geometry) {
                finalDistance = routeResult.distance;
                routeCoordinates = routeResult.geometry;
            }
        } catch (err) {
            console.warn('Street route fallback to direct line:', err);
        }

        // Draw street route polyline or direct polyline
        const isCovered = finalDistance <= 300;
        const lineColor = isCovered ? '#38bdf8' : '#f59e0b';

        let polyline;
        if (routeCoordinates && routeCoordinates.length > 0) {
            // Draw real street polyline following roads
            polyline = L.polyline(routeCoordinates, {
                color: lineColor,
                weight: 4,
                opacity: 0.9,
                lineCap: 'round',
                lineJoin: 'round'
            });
        } else {
            // Fallback direct line
            polyline = L.polyline([
                [lat, lng],
                [topCandidate.lat, topCandidate.lng]
            ], {
                color: lineColor,
                weight: 3,
                dashArray: '6, 8',
                opacity: 0.9
            });
        }

        connectionLineLayer.addLayer(polyline);

        // Fit map view to show route
        mapInstance.fitBounds(polyline.getBounds().pad(0.2), { maxZoom: 18 });

        // Build Result Card
        const resultEl = document.getElementById('gisResultContainer');
        const waNumber = '6289696629955';

        let badgeHtml = '';
        if (finalDistance <= 150) {
            badgeHtml = '<span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/40 text-[10.5px] font-mono font-bold flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>SANGAT BAGUS (FTTH IDEAL)</span>';
        } else if (finalDistance <= 250) {
            badgeHtml = '<span class="px-3 py-1 rounded-full bg-sky-500/20 text-sky-300 border border-sky-400/40 text-[10.5px] font-mono font-bold flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>BAGUS (LAYAK PASANG)</span>';
        } else if (finalDistance <= 300) {
            badgeHtml = '<span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-400/40 text-[10.5px] font-mono font-bold flex items-center gap-1.5">BATAS JANGKAUAN ODP</span>';
        } else {
            badgeHtml = '<span class="px-3 py-1 rounded-full bg-rose-500/20 text-rose-300 border border-rose-400/40 text-[10.5px] font-mono font-bold flex items-center gap-1.5">DI LUAR RADIUS STANDAR (>300m)</span>';
        }

        const waMsg = isCovered
            ? `Halo PT Media Solusi Network, saya sudah mengecek jaringan di website pada koordinat ${lat.toFixed(6)}, ${lng.toFixed(6)}. Jarak rute jalan ke ${topCandidate.name_odp} (${topCandidate.kode_odp}) adalah ${finalDistance} meter. Mohon info promo dan pemasangannya.`
            : `Halo PT Media Solusi Network, saya mengecek koordinat ${lat.toFixed(6)}, ${lng.toFixed(6)} (jarak rute jalan ${finalDistance}m dari ${topCandidate.name_odp}). Saya ingin mengajukan request survei perluasan ODP ke lokasi saya.`;

        const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(waMsg)}`;

        if (resultEl) {
            resultEl.classList.remove('hidden');
            resultEl.innerHTML = `
                <div class="p-5 sm:p-6 rounded-3xl ${isCovered ? 'bg-gradient-to-br from-emerald-950/70 via-[#071d2b]/80 to-[#05131f]/90 border border-emerald-400/40 shadow-[0_0_30px_rgba(16,185,129,0.2)]' : 'bg-gradient-to-br from-amber-950/60 via-[#1a1409]/80 to-[#0a0d14]/90 border border-amber-400/40 shadow-[0_0_30px_rgba(245,158,11,0.15)]'} backdrop-blur-xl animate-fade-in space-y-4">
                    
                    <div class="flex items-center justify-between gap-2 flex-wrap">
                        ${badgeHtml}
                        <span class="text-xs font-mono text-white font-bold bg-white/10 px-2.5 py-1 rounded-lg border border-white/15">
                            Rute Jalan: ${finalDistance} Meter
                        </span>
                    </div>

                    <div>
                        <h3 class="font-heading font-extrabold text-white text-base sm:text-lg mb-1">
                            ${isCovered ? 'Lokasi Anda Tercover Jaringan Fiber Optic!' : 'Lokasi Berjarak Lebih dari 300m dari ODP'}
                        </h3>
                        <p class="text-xs text-slate-200 leading-relaxed">
                            ${isCovered 
                                ? `Kabar baik! Titik Anda berjarak <b>${finalDistance} meter</b> mengikuti rute jalan dari titik distribusi <b>${topCandidate.name_odp}</b> (${topCandidate.olt_name}). Jalur kabel dropcore siap ditarik ke rumah Anda.`
                                : `Titik Anda berjarak <b>${finalDistance} meter</b> mengikuti rute jalan dari ODP terdekat. Tim teknik kami siap melakukan survei perluasan tiang untuk pendaftaran kolektif.`}
                        </p>
                    </div>

                    <!-- Technical Specification Metrics Box -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 p-3 rounded-2xl bg-white/[0.04] border border-white/10 text-xs">
                        <div>
                            <span class="text-slate-400 text-[10px] block">ODP Terdekat</span>
                            <span class="text-white font-bold font-mono text-[11px] truncate block">${topCandidate.name_odp}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[10px] block">OLT & PON</span>
                            <span class="text-sky-400 font-bold text-[11px] truncate block">${topCandidate.olt_name} • ${topCandidate.kode_pon}</span>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <span class="text-slate-400 text-[10px] block">Port ODP</span>
                            <span class="${topCandidate.has_slot ? 'text-emerald-400' : 'text-rose-400'} font-bold text-[11px] block">
                                ${topCandidate.used_ports}/${topCandidate.capacity_odp} (${topCandidate.has_slot ? 'Tersedia' : 'Penuh'})
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap items-center gap-2.5 pt-1">
                        ${isCovered ? `
                            <a href="#paket" class="flex-1 min-w-[140px] px-4 py-3 rounded-xl bg-[#38bdf8] text-[#050d1a] font-heading font-extrabold text-xs text-center hover:bg-white hover:text-[#0284c7] transition-all shadow-lg shadow-sky-500/20 flex items-center justify-center gap-1.5">
                                <span>Pilih Paket Internet</span>
                                <iconify-icon icon="solar:arrow-right-linear" width="16"></iconify-icon>
                            </a>
                            <a href="${waUrl}" target="_blank" rel="noopener noreferrer" class="flex-1 min-w-[140px] px-4 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-heading font-extrabold text-xs text-center transition-all shadow-lg shadow-emerald-500/20 flex items-center justify-center gap-1.5">
                                <iconify-icon icon="logos:whatsapp-icon" width="16"></iconify-icon>
                                <span>Daftar via WhatsApp</span>
                            </a>
                        ` : `
                            <a href="${waUrl}" target="_blank" rel="noopener noreferrer" class="w-full px-4 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-heading font-extrabold text-xs text-center transition-all shadow-lg shadow-amber-500/20 flex items-center justify-center gap-1.5">
                                <iconify-icon icon="logos:whatsapp-icon" width="16"></iconify-icon>
                                <span>Ajukan Perluasan ODP via WhatsApp</span>
                            </a>
                        `}
                    </div>

                </div>
            `;
        }
    }

    // Reverse geocode to get street name & display accuracy badge
    async function reverseGeocode(lat, lng, accuracy = null) {
        const addrBox = document.getElementById('gisAddressBox');
        const addrText = document.getElementById('gisAddressText');
        const accBadge = document.getElementById('gisAccuracyBadge');
        
        if (addrBox) addrBox.classList.remove('hidden');
        if (addrText) addrText.textContent = 'Mencari detail alamat...';

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
                accBadge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span><span>Titik Manual</span>`;
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

    // Map Click Listener to pick coordinates interactively
    mapInstance.on('click', function (e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        document.getElementById('gisInputCoord').value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        evaluateCoveragePoint(lat, lng);
        reverseGeocode(lat, lng, null);
    });

    // Form Submit Handler
    document.getElementById('gisCoverageForm')?.addEventListener('submit', async function (e) {
        e.preventDefault();
        const inputVal = document.getElementById('gisInputCoord').value.trim();
        if (!inputVal) return;

        const coordMatch = inputVal.match(/^\s*(-?\d+(\.\d+)?)\s*,\s*(-?\d+(\.\d+)?)\s*$/);
        if (coordMatch) {
            const lat = parseFloat(coordMatch[1]);
            const lng = parseFloat(coordMatch[3]);
            evaluateCoveragePoint(lat, lng);
            reverseGeocode(lat, lng, null);
        } else {
            const submitBtn = document.getElementById('gisSubmitBtn');
            if (submitBtn) submitBtn.disabled = true;

            try {
                const geoRes = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(inputVal + ', Indonesia')}&limit=1`, {
                    headers: { 'Accept-Language': 'id' }
                });
                const geoData = await geoRes.json();
                if (geoData && geoData.length > 0) {
                    const lat = parseFloat(geoData[0].lat);
                    const lng = parseFloat(geoData[0].lon);
                    document.getElementById('gisInputCoord').value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                    evaluateCoveragePoint(lat, lng);
                    reverseGeocode(lat, lng, null);
                } else {
                    alert('Lokasi alamat tidak ditemukan. Silakan klik langsung pada peta atau masukkan koordinat (Lat, Lng).');
                }
            } catch (err) {
                console.error(err);
            } finally {
                if (submitBtn) submitBtn.disabled = false;
            }
        }
    });

    // Multi-sample High-Accuracy Geolocation Engine
    let activeGpsWatcher = null;

    function acquireAccurateGps(onSuccess, onError) {
        if (!navigator.geolocation) {
            onError({ code: 0, message: 'Browser Anda tidak mendukung deteksi lokasi otomatis.' });
            return;
        }

        let bestPosition = null;
        let isFinalized = false;
        let fallbackTimer = null;

        const finalize = () => {
            if (isFinalized) return;
            isFinalized = true;
            if (fallbackTimer) clearTimeout(fallbackTimer);
            if (activeGpsWatcher !== null) {
                navigator.geolocation.clearWatch(activeGpsWatcher);
                activeGpsWatcher = null;
            }

            if (bestPosition) {
                onSuccess(bestPosition);
            } else {
                onError({ code: 3, message: 'Waktu pencarian GPS habis atau sinyal tidak ditemukan.' });
            }
        };

        // Tunggu maksimal 6.5 detik untuk mengunci akurasi satelit terbaik
        fallbackTimer = setTimeout(() => {
            finalize();
        }, 6500);

        const geoOptions = {
            enableHighAccuracy: true,
            timeout: 8000,
            maximumAge: 0 // Pastikan GPS chip melakukan pembacaan baru dan tidak menggunakan cache lama
        };

        try {
            activeGpsWatcher = navigator.geolocation.watchPosition(
                function (pos) {
                    const acc = pos.coords.accuracy || 9999;
                    if (!bestPosition || acc < (bestPosition.coords.accuracy || 9999)) {
                        bestPosition = pos;
                    }

                    // Jika akurasi sudah mencapai <= 20 meter (standar akurat GPS mobile), kunci langsung!
                    if (acc <= 20) {
                        finalize();
                    }
                },
                function (err) {
                    if (bestPosition) {
                        finalize();
                    } else {
                        isFinalized = true;
                        if (fallbackTimer) clearTimeout(fallbackTimer);
                        if (activeGpsWatcher !== null) {
                            navigator.geolocation.clearWatch(activeGpsWatcher);
                            activeGpsWatcher = null;
                        }
                        onError(err);
                    }
                },
                geoOptions
            );
        } catch (e) {
            navigator.geolocation.getCurrentPosition(
                function (pos) { onSuccess(pos); },
                function (err) { onError(err); },
                geoOptions
            );
        }
    }

    // GPS Geolocation Button Handler
    document.getElementById('gisGpsBtn')?.addEventListener('click', function () {
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = `<iconify-icon icon="solar:radar-bold" class="text-sky-400 animate-spin text-base"></iconify-icon><span>Mengunci GPS...</span>`;

        acquireAccurateGps(
            function (pos) {
                btn.disabled = false;
                btn.innerHTML = `<iconify-icon icon="solar:check-circle-bold" class="text-emerald-400 text-base"></iconify-icon><span>GPS Terkunci</span>`;
                setTimeout(() => {
                    btn.innerHTML = `<iconify-icon icon="solar:gps-bold" class="text-[#38bdf8] text-base"></iconify-icon><span>GPS Lokasi Saya</span>`;
                }, 3000);

                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                const accuracy = Math.round(pos.coords.accuracy || 0);

                document.getElementById('gisInputCoord').value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;

                // Zoom dan geser ke lokasi pengguna dengan halus
                mapInstance.flyTo([lat, lng], 18, { duration: 1.0 });

                evaluateCoveragePoint(lat, lng);
                reverseGeocode(lat, lng, accuracy);
            },
            function (err) {
                btn.disabled = false;
                btn.innerHTML = `<iconify-icon icon="solar:gps-bold" class="text-[#38bdf8] text-base"></iconify-icon><span>GPS Lokasi Saya</span>`;
                
                let errorMsg = 'Izin lokasi tidak aktif atau sinyal GPS tidak terdeteksi.';
                if (err.code === 1) {
                    errorMsg = 'Akses lokasi ditolak browser. Silakan izinkan akses lokasi di pengaturan browser atau klik langsung posisi rumah Anda pada peta.';
                } else if (err.code === 2) {
                    errorMsg = 'Sinyal GPS / posisi saat ini tidak terdeteksi. Silakan klik langsung pada peta.';
                } else if (err.code === 3) {
                    errorMsg = 'Pencarian GPS memerlukan waktu terlalu lama. Silakan coba klik tombol kembali atau tentukan titik pada peta.';
                }
                alert(errorMsg);
            }
        );
    });

    // Master ODP Select Dropdown
    document.getElementById('gisOdpSelect')?.addEventListener('change', function () {
        const val = this.value;
        if (!val) return;
        const parts = val.split(',');
        if (parts.length === 2) {
            const lat = parseFloat(parts[0]);
            const lng = parseFloat(parts[1]);
            document.getElementById('gisInputCoord').value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            evaluateCoveragePoint(lat, lng);
            reverseGeocode(lat, lng, null);
        }
    });

    // Quick City Buttons
    document.querySelectorAll('.gis-quick-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const coord = this.getAttribute('data-coord');
            if (coord) {
                document.getElementById('gisInputCoord').value = coord;
                const parts = coord.split(',');
                if (parts.length === 2) {
                    const lat = parseFloat(parts[0]);
                    const lng = parseFloat(parts[1]);
                    evaluateCoveragePoint(lat, lng);
                    reverseGeocode(lat, lng, null);
                }
            }
        });
    });

    // Initial evaluation on load
    setTimeout(() => {
        mapInstance.invalidateSize();
        evaluateCoveragePoint(defaultLat, defaultLng);
    }, 400);
});
</script>
