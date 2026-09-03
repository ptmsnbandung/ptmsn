@props(['package'])

@php
    $whatsappNumber = config('company.whatsapp');
    $categoryPrefix = ($package->category === 'soho' ? 'SOHO ' : '');
    $waText = urlencode("Halo PT Media Solusi Network, saya ingin berlangganan paket {$categoryPrefix}{$package->name} ({$package->speed} - {$package->formatted_price}/bln). Mohon informasi pemasangan baru.");
    $waLink = "https://wa.me/{$whatsappNumber}?text={$waText}";

    $tierLower = strtolower($package->name);
    $isFeatured = $tierLower === 'gold' || $tierLower === 'emerald' || $package->is_popular;

    // Clean numerical speed
    $speedNumber = trim(preg_replace('/[^0-9]/', '', $package->speed));
    if (empty($speedNumber)) {
        $speedNumber = $package->speed;
    }

    // Formatted price display
    $priceThousands = number_format($package->price / 1000, 0, ',', '.');

    // Recommendation pill per tier
    $recommendations = [
        'bronze' => '1 - 3 Perangkat • Harian',
        'silver' => '3 - 5 Perangkat • Streaming',
        'gold' => '5 - 8 Perangkat • Terfavorit',
        'platinum' => '8 - 12+ Perangkat • Kecepatan Tinggi',
        'crystal' => '3 - 6 Perangkat • Kantor Kecil',
        'saphire' => '6 - 10 Perangkat • Operasional SOHO',
        'emerald' => '10 - 15 Perangkat • Paling Diminati',
        'ruby' => '15 - 20 Perangkat • High Traffic SOHO',
        'diamond' => '20+ Perangkat • Performa Maksimal',
    ];
    $recText = $recommendations[$tierLower] ?? 'Koneksi Stabil & Cepat';

    // Tier badge styles
    $tierBadgeStyles = [
        'bronze' => 'bg-amber-500/10 text-amber-800 border-amber-300',
        'silver' => 'bg-slate-100 text-slate-700 border-slate-300',
        'gold' => 'bg-gradient-to-r from-sky-50 to-blue-50 text-[#0284c7] border-sky-300 font-black',
        'platinum' => 'bg-indigo-50 text-indigo-700 border-indigo-200 font-bold',
        'crystal' => 'bg-emerald-50 text-emerald-700 border-emerald-300 font-bold',
        'saphire' => 'bg-purple-50 text-purple-700 border-purple-300 font-bold',
        'emerald' => 'bg-gradient-to-r from-amber-50 to-yellow-50 text-amber-800 border-amber-300 font-black',
        'ruby' => 'bg-rose-50 text-rose-700 border-rose-300 font-bold',
        'diamond' => 'bg-sky-50 text-sky-700 border-sky-300 font-bold',
    ];
    $currentBadge = $tierBadgeStyles[$tierLower] ?? 'bg-slate-50 text-slate-700 border-slate-200';
@endphp

@if($isFeatured)
    <!-- Featured / Rekomendasi Package Card (Gold - 25 Mbps) -->
    <div class="relative rounded-2xl sm:rounded-3xl p-4 sm:p-7 lg:p-8 flex flex-col justify-between bg-white border-2 border-[#0284c7] shadow-[0_12px_40px_rgba(2,132,199,0.22)] hover:shadow-[0_18px_50px_rgba(2,132,199,0.3)] transition-all duration-300 transform hover:-translate-y-2 flex-1 group">
        
        <!-- Top Floating Popular Ribbon -->
        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-3.5 sm:px-4 py-1 rounded-full bg-gradient-to-r from-[#0284c7] via-[#0ea5e9] to-[#0284c7] text-white text-[9px] sm:text-[10px] font-mono font-extrabold uppercase tracking-wider shadow-md whitespace-nowrap flex items-center gap-1.5 z-30">
            <iconify-icon icon="solar:crown-bold" width="12" class="text-amber-300"></iconify-icon>
            <span>PALING POPULER</span>
        </div>

        <div>
            <!-- Tier Name & Speed Header -->
            <div class="text-center pt-2 pb-3 sm:pb-4 border-b border-slate-100">
                <span class="inline-block px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-mono font-bold uppercase tracking-wider border shadow-2xs {{ $currentBadge }}">
                    {{ $package->name }}
                </span>
                
                <!-- Speed Display Hero (Bold without parentheses) -->
                <div class="mt-2 sm:mt-3 flex items-baseline justify-center gap-1">
                    <span class="font-heading font-black text-3xl sm:text-4xl lg:text-[46px] text-slate-900 tracking-tight leading-none group-hover:text-[#0284c7] transition-colors">
                        {{ $speedNumber }}
                    </span>
                    <span class="font-heading font-extrabold text-sm sm:text-base text-[#0284c7] uppercase">
                        Mbps
                    </span>
                </div>

                <div class="text-[10px] sm:text-[11px] font-mono text-slate-500 mt-1 flex items-center justify-center gap-1">
                    <iconify-icon icon="solar:transfer-horizontal-bold" class="text-[#0284c7] text-xs"></iconify-icon>
                    <span>Fiber 1:1 Simetris</span>
                </div>
            </div>

            <!-- Recommendation Pill -->
            <div class="text-center my-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] sm:text-xs font-heading font-semibold bg-sky-50 text-[#0284c7] border border-sky-200 shadow-2xs">
                    <iconify-icon icon="solar:devices-linear" width="13"></iconify-icon>
                    <span>{{ $recText }}</span>
                </span>
            </div>

            <!-- Price Display Section -->
            <div class="text-center py-3 my-2 border-y border-slate-100 bg-gradient-to-b from-sky-50/50 to-transparent rounded-xl">
                <div class="flex items-baseline justify-center gap-0.5">
                    <span class="text-[11px] sm:text-xs font-bold text-slate-400 font-sans">Rp</span>
                    <span class="font-heading font-black text-2xl sm:text-3xl lg:text-[36px] text-slate-900 tracking-tight">{{ $priceThousands }}</span>
                    <span class="text-[11px] sm:text-xs font-bold text-[#0284c7]">.000</span>
                    <span class="text-[10px] sm:text-xs font-mono text-slate-500 ml-1">/ bln</span>
                </div>
            </div>

            <!-- Checklist Features -->
            <ul class="space-y-2 sm:space-y-3 my-4 sm:my-6 text-left text-[11px] sm:text-xs lg:text-sm text-slate-700 font-medium">
                @if(!empty($package->features) && is_array($package->features))
                    @foreach($package->features as $feature)
                        <li class="flex items-start sm:items-center gap-2">
                            <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 sm:mt-0">
                                <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                            </div>
                            <span class="leading-tight">{{ $feature }}</span>
                        </li>
                    @endforeach
                @else
                    <li class="flex items-start sm:items-center gap-2">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 sm:mt-0">
                            <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                        </div>
                        <span class="leading-tight">Unlimited Akses (Tanpa FUP)</span>
                    </li>
                    <li class="flex items-start sm:items-center gap-2">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 sm:mt-0">
                            <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                        </div>
                        <span class="leading-tight">IP Private / Dedicated</span>
                    </li>
                    <li class="flex items-start sm:items-center gap-2">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 sm:mt-0">
                            <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                        </div>
                        <span class="leading-tight">Fast Network Fiber Optic</span>
                    </li>
                    <li class="flex items-start sm:items-center gap-2">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 sm:mt-0">
                            <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                        </div>
                        <span class="leading-tight">Termasuk Modem ONT / WiFi</span>
                    </li>
                @endif
            </ul>
        </div>

        <!-- CTA Action Button (Signature Cyan / Sky Gradient) -->
        <div class="pt-2">
            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" class="group/btn w-full py-3 sm:py-3.5 px-3 rounded-xl sm:rounded-2xl font-heading font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-1.5 bg-gradient-to-r from-[#0284c7] via-[#0ea5e9] to-[#0284c7] hover:from-[#0369a1] hover:to-[#0284c7] text-white transition-all duration-300 shadow-md shadow-sky-500/25 hover:scale-105 active:scale-95 text-center">
                <span class="hidden sm:inline">PILIH PAKET INI</span>
                <span class="sm:hidden">PILIH PAKET</span>
                <iconify-icon icon="solar:arrow-right-linear" width="16" class="group-hover/btn:translate-x-1 transition-transform"></iconify-icon>
            </a>
        </div>
    </div>
@else
    <!-- Standard Clean & Modern Package Card (Bronze, Silver, Platinum) -->
    <div class="relative rounded-2xl sm:rounded-3xl p-4 sm:p-7 lg:p-8 flex flex-col justify-between bg-white/95 backdrop-blur-md border border-slate-200/90 shadow-md hover:border-sky-300 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 flex-1 group">
        <div>
            <!-- Tier Name & Speed Header -->
            <div class="text-center pt-2 pb-3 sm:pb-4 border-b border-slate-100">
                <span class="inline-block px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-mono font-bold uppercase tracking-wider border shadow-2xs {{ $currentBadge }}">
                    {{ $package->name }}
                </span>
                
                <!-- Speed Display Hero (Bold without parentheses) -->
                <div class="mt-2 sm:mt-3 flex items-baseline justify-center gap-1">
                    <span class="font-heading font-black text-3xl sm:text-4xl lg:text-[44px] text-slate-900 tracking-tight leading-none group-hover:text-[#0284c7] transition-colors">
                        {{ $speedNumber }}
                    </span>
                    <span class="font-heading font-extrabold text-sm sm:text-base text-[#0284c7] uppercase">
                        Mbps
                    </span>
                </div>

                <div class="text-[10px] sm:text-[11px] font-mono text-slate-500 mt-1 flex items-center justify-center gap-1">
                    <iconify-icon icon="solar:transfer-horizontal-bold" class="text-[#0284c7] text-xs"></iconify-icon>
                    <span>Fiber 1:1 Simetris</span>
                </div>
            </div>

            <!-- Recommendation Pill -->
            <div class="text-center my-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] sm:text-xs font-heading font-semibold bg-slate-100 text-slate-600 shadow-2xs">
                    <iconify-icon icon="solar:devices-linear" width="13"></iconify-icon>
                    <span>{{ $recText }}</span>
                </span>
            </div>

            <!-- Price Display Section -->
            <div class="text-center py-3 my-2 border-y border-slate-100 bg-slate-50/80 rounded-xl">
                <div class="flex items-baseline justify-center gap-0.5">
                    <span class="text-[11px] sm:text-xs font-bold text-slate-400 font-sans">Rp</span>
                    <span class="font-heading font-black text-2xl sm:text-3xl lg:text-[34px] text-slate-900 tracking-tight">{{ $priceThousands }}</span>
                    <span class="text-[11px] sm:text-xs font-bold text-[#0284c7]">.000</span>
                    <span class="text-[10px] sm:text-xs font-mono text-slate-500 ml-1">/ bln</span>
                </div>
            </div>

            <!-- Checklist Features -->
            <ul class="space-y-2 sm:space-y-3 my-4 sm:my-6 text-left text-[11px] sm:text-xs lg:text-sm text-slate-700 font-medium">
                @if(!empty($package->features) && is_array($package->features))
                    @foreach($package->features as $feature)
                        <li class="flex items-start sm:items-center gap-2">
                            <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 sm:mt-0">
                                <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                            </div>
                            <span class="leading-tight">{{ $feature }}</span>
                        </li>
                    @endforeach
                @else
                    <li class="flex items-start sm:items-center gap-2">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 sm:mt-0">
                            <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                        </div>
                        <span class="leading-tight">Unlimited Akses (Tanpa FUP)</span>
                    </li>
                    <li class="flex items-start sm:items-center gap-2">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 sm:mt-0">
                            <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                        </div>
                        <span class="leading-tight">IP Private / Dedicated</span>
                    </li>
                    <li class="flex items-start sm:items-center gap-2">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 sm:mt-0">
                            <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                        </div>
                        <span class="leading-tight">Fast Network Fiber Optic</span>
                    </li>
                    <li class="flex items-start sm:items-center gap-2">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 sm:mt-0">
                            <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                        </div>
                        <span class="leading-tight">Termasuk Modem ONT / WiFi</span>
                    </li>
                @endif
            </ul>
        </div>

        <!-- CTA Action Button (Refined Corporate Outline with Blue Accent) -->
        <div class="pt-2">
            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" class="group/btn w-full py-3 sm:py-3.5 px-3 rounded-xl sm:rounded-2xl font-heading font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-1.5 border-2 border-[#0284c7] text-[#0284c7] hover:bg-gradient-to-r hover:from-[#0284c7] hover:to-[#0ea5e9] hover:text-white hover:border-transparent transition-all duration-300 shadow-2xs hover:scale-105 active:scale-95 text-center">
                <span class="hidden sm:inline">PILIH PAKET INI</span>
                <span class="sm:hidden">PILIH PAKET</span>
                <iconify-icon icon="solar:arrow-right-linear" width="16" class="group-hover/btn:translate-x-1 transition-transform"></iconify-icon>
            </a>
        </div>
    </div>
@endif
