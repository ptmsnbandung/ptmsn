@props(['package'])

@php
    $whatsappNumber = config('company.whatsapp');
    $waText = urlencode("Halo PT Media Solusi Network, saya ingin berlangganan paket {$package->name} ({$package->speed} - {$package->formatted_price}/bln). Mohon informasi pemasangan baru.");
    $waLink = "https://wa.me/{$whatsappNumber}?text={$waText}";

    $tierLower = strtolower($package->name);
    $isFeatured = $tierLower === 'gold' || $package->is_popular;

    // Formatted price display like Rp 200rb / BLN
    $priceThousands = number_format($package->price / 1000, 0, ',', '.');

    // Clean subtle tier badge styles
    $tierBadgeStyles = [
        'bronze' => 'bg-amber-50 text-amber-800 border-amber-200',
        'silver' => 'bg-slate-100 text-slate-700 border-slate-200',
        'gold' => 'bg-sky-50 text-[#0284c7] border-sky-200 font-bold',
        'platinum' => 'bg-sky-50 text-[#0284c7] border-sky-200',
    ];
    $currentBadge = $tierBadgeStyles[$tierLower] ?? 'bg-slate-50 text-slate-700 border-slate-200';
@endphp

@if($isFeatured)
    <!-- Featured / Rekomendasi Package Card (Gold - 25 Mbps) -->
    <div class="relative rounded-2xl sm:rounded-3xl p-3.5 sm:p-7 lg:p-8 flex flex-col justify-between bg-white border-2 border-[#0284c7] shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 flex-1">
        
        <!-- Top Floating Popular Ribbon (No Overflow Clipping) -->
        <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-2.5 sm:px-4 py-0.5 sm:py-1 rounded-full bg-[#0284c7] text-white text-[9px] sm:text-[10px] font-mono font-bold uppercase tracking-wider shadow-md whitespace-nowrap flex items-center gap-1 z-30">
            <iconify-icon icon="solar:star-bold" width="11" class="text-amber-300"></iconify-icon>
            <span class="hidden sm:inline">PALING POPULER</span>
            <span class="sm:hidden">POPULER</span>
        </div>

        <div>
            <!-- Tier Name & Speed Header -->
            <div class="text-center pt-1 pb-3 sm:pt-2 sm:pb-5 mb-3 sm:mb-5 border-b border-slate-100">
                <span class="inline-block px-2.5 sm:px-3.5 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-mono font-bold uppercase tracking-wider mb-1.5 sm:mb-2.5 border shadow-2xs {{ $currentBadge }}">
                    {{ $package->name }}
                </span>
                <div class="font-heading font-extrabold text-base sm:text-2xl lg:text-3xl text-slate-900 tracking-tight">
                    ({{ $package->speed }})
                </div>
            </div>

            <!-- Price Display -->
            <div class="text-center pb-3 mb-3 sm:pb-5 sm:mb-5 border-b border-slate-100">
                <div class="flex items-baseline justify-center gap-0.5 sm:gap-1">
                    <span class="text-[10px] sm:text-xs font-bold text-slate-500 font-sans">Rp</span>
                    <span class="font-heading font-black text-2xl sm:text-3xl lg:text-[38px] text-slate-900 tracking-tight">{{ $priceThousands }}</span>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-500 font-sans">rb</span>
                </div>
                <div class="text-[9px] sm:text-[11px] font-mono font-bold uppercase tracking-widest text-slate-400 mt-0.5 sm:mt-1">
                    / BLN
                </div>
            </div>

            <!-- Checklist Features -->
            <ul class="space-y-2 sm:space-y-3.5 mb-5 sm:mb-8 text-left text-[11px] sm:text-xs lg:text-sm text-slate-700 font-medium">
                <li class="flex items-start sm:items-center gap-1.5 sm:gap-3">
                    <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200 mt-0.5 sm:mt-0">
                        <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                    </div>
                    <span class="leading-tight sm:leading-normal">Unlimited Akses (Tanpa FUP)</span>
                </li>
                <li class="flex items-start sm:items-center gap-1.5 sm:gap-3">
                    <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200 mt-0.5 sm:mt-0">
                        <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                    </div>
                    <span class="leading-tight sm:leading-normal">IP Private Dedicated</span>
                </li>
                <li class="flex items-start sm:items-center gap-1.5 sm:gap-3">
                    <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200 mt-0.5 sm:mt-0">
                        <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                    </div>
                    <span class="leading-tight sm:leading-normal">Fast Network Fiber Optic</span>
                </li>
                <li class="flex items-start sm:items-center gap-1.5 sm:gap-3">
                    <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200 mt-0.5 sm:mt-0">
                        <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                    </div>
                    <span class="leading-tight sm:leading-normal">Termasuk Modem ONT / WiFi</span>
                </li>
            </ul>
        </div>

        <!-- CTA Action Button -->
        <div>
            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" class="group/btn w-full py-2.5 sm:py-3.5 px-2 sm:px-4 rounded-xl sm:rounded-2xl font-heading font-bold text-[10px] sm:text-xs uppercase tracking-wider flex items-center justify-center gap-1 sm:gap-2 bg-emerald-500 hover:bg-emerald-600 text-white transition-all duration-300 shadow-md shadow-emerald-500/30 hover:scale-105 active:scale-95 text-center">
                <span class="hidden sm:inline">BERLANGGANAN SEKARANG</span>
                <span class="sm:hidden">PILIH PAKET</span>
                <iconify-icon icon="solar:plain-bold" width="13" class="sm:w-4 group-hover/btn:translate-x-1 group-hover/btn:-translate-y-0.5 transition-transform"></iconify-icon>
            </a>
        </div>
    </div>
@else
    <!-- Standard Clean & Modern Package Card (Bronze, Silver, Platinum) -->
    <div class="relative rounded-2xl sm:rounded-3xl p-3.5 sm:p-7 lg:p-8 flex flex-col justify-between bg-white border border-slate-200 shadow-md hover:border-sky-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1.5 flex-1">
        <div>
            <!-- Tier Name & Speed Header -->
            <div class="text-center pt-1 pb-3 sm:pt-2 sm:pb-5 mb-3 sm:mb-5 border-b border-slate-100">
                <span class="inline-block px-2.5 sm:px-3.5 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-mono font-bold uppercase tracking-wider mb-1.5 sm:mb-2.5 border shadow-2xs {{ $currentBadge }}">
                    {{ $package->name }}
                </span>
                <div class="font-heading font-extrabold text-base sm:text-2xl lg:text-3xl text-slate-900 tracking-tight">
                    ({{ $package->speed }})
                </div>
            </div>

            <!-- Price Display -->
            <div class="text-center pb-3 mb-3 sm:pb-5 sm:mb-5 border-b border-slate-100">
                <div class="flex items-baseline justify-center gap-0.5 sm:gap-1">
                    <span class="text-[10px] sm:text-xs font-bold text-slate-500 font-sans">Rp</span>
                    <span class="font-heading font-black text-2xl sm:text-3xl lg:text-[38px] text-slate-900 tracking-tight">{{ $priceThousands }}</span>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-500 font-sans">rb</span>
                </div>
                <div class="text-[9px] sm:text-[11px] font-mono font-bold uppercase tracking-widest text-slate-400 mt-0.5 sm:mt-1">
                    / BLN
                </div>
            </div>

            <!-- Checklist Features -->
            <ul class="space-y-2 sm:space-y-3.5 mb-5 sm:mb-8 text-left text-[11px] sm:text-xs lg:text-sm text-slate-700 font-medium">
                <li class="flex items-start sm:items-center gap-1.5 sm:gap-3">
                    <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200 mt-0.5 sm:mt-0">
                        <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                    </div>
                    <span class="leading-tight sm:leading-normal">Unlimited Akses (Tanpa FUP)</span>
                </li>
                <li class="flex items-start sm:items-center gap-1.5 sm:gap-3">
                    <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200 mt-0.5 sm:mt-0">
                        <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                    </div>
                    <span class="leading-tight sm:leading-normal">IP Private Dedicated</span>
                </li>
                <li class="flex items-start sm:items-center gap-1.5 sm:gap-3">
                    <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200 mt-0.5 sm:mt-0">
                        <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                    </div>
                    <span class="leading-tight sm:leading-normal">Fast Network Fiber Optic</span>
                </li>
                <li class="flex items-start sm:items-center gap-1.5 sm:gap-3">
                    <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200 mt-0.5 sm:mt-0">
                        <iconify-icon icon="solar:check-circle-bold" class="text-xs sm:text-sm"></iconify-icon>
                    </div>
                    <span class="leading-tight sm:leading-normal">Termasuk Modem ONT / WiFi</span>
                </li>
            </ul>
        </div>

        <!-- CTA Action Button -->
        <div>
            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" class="group/btn w-full py-2.5 sm:py-3.5 px-2 sm:px-4 rounded-xl sm:rounded-2xl font-heading font-bold text-[10px] sm:text-xs uppercase tracking-wider flex items-center justify-center gap-1 sm:gap-2 border-2 border-emerald-500 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-all duration-300 shadow-xs hover:scale-105 active:scale-95 group-hover:border-emerald-600 text-center">
                <span class="hidden sm:inline">BERLANGGANAN SEKARANG</span>
                <span class="sm:hidden">PILIH PAKET</span>
                <iconify-icon icon="solar:plain-bold" width="13" class="sm:w-4 group-hover/btn:translate-x-1 group-hover/btn:-translate-y-0.5 transition-transform"></iconify-icon>
            </a>
        </div>
    </div>
@endif
