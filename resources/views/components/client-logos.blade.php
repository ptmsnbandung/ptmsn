@props(['clients'])

<section id="client" class="pt-4 sm:pt-8 pb-10 sm:pb-20 px-3 sm:px-6 lg:px-8 relative z-10 w-full bg-transparent overflow-hidden">
    <div class="max-w-7xl mx-auto">
        
        <!-- Clean, Subtle Section Header -->
        <div class="text-center max-w-xl mx-auto mb-5 sm:mb-10">
            <div class="inline-flex items-center px-3 sm:px-3.5 py-0.5 sm:py-1 rounded-full bg-white/80 border border-sky-100 shadow-2xs backdrop-blur-sm text-[10px] sm:text-[11px] font-mono font-semibold text-slate-500 uppercase tracking-widest">
                <span>Dipercaya oleh Berbagai Perusahaan & Institusi di Indonesia</span>
            </div>
        </div>

        <!-- Pure Logo Showcase: Seamless Marquee (Compact on Mobile, Elegant on Desktop) -->
        @php
            $clientList = $clients->values();
            $halfCount = ceil($clientList->count() / 2);
            $row1 = $clientList->slice(0, $halfCount);
            $row2 = $clientList->slice($halfCount);
        @endphp

        <div class="relative w-full space-y-2.5 sm:space-y-5 py-1 sm:py-2">
            <!-- Left & Right Gradient Fade Overlays -->
            <div class="absolute top-0 left-0 bottom-0 w-12 sm:w-28 md:w-36 bg-gradient-to-r from-[#f8fafc] via-[#f8fafc]/80 to-transparent z-10 pointer-events-none"></div>
            <div class="absolute top-0 right-0 bottom-0 w-12 sm:w-28 md:w-36 bg-gradient-to-l from-[#f8fafc] via-[#f8fafc]/80 to-transparent z-10 pointer-events-none"></div>

            <!-- Row 1: Marquee Left -->
            <div class="flex overflow-hidden group">
                <div class="flex shrink-0 items-center gap-2.5 sm:gap-6 md:gap-8 animate-marquee-left group-hover:[animation-play-state:paused]">
                    @foreach($row1 as $client)
                        <div class="flex items-center justify-center h-11 sm:h-16 w-28 sm:w-40 md:w-44 px-2.5 py-1.5 sm:px-4 sm:py-2 rounded-xl sm:rounded-2xl bg-white/85 border border-sky-100/80 shadow-2xs sm:shadow-xs hover:shadow-md hover:border-sky-300 hover:bg-white transition-all duration-300 backdrop-blur-xs cursor-pointer group/logo" title="{{ $client->name }}">
                            <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}" loading="lazy" class="max-h-6 sm:max-h-10 max-w-[75px] sm:max-w-[125px] object-contain opacity-90 group-hover/logo:opacity-100 group-hover/logo:scale-105 transition-all duration-300">
                        </div>
                    @endforeach
                </div>
                <!-- Duplicate Row 1 for Seamless Loop -->
                <div class="flex shrink-0 items-center gap-2.5 sm:gap-6 md:gap-8 animate-marquee-left group-hover:[animation-play-state:paused]" aria-hidden="true">
                    @foreach($row1 as $client)
                        <div class="flex items-center justify-center h-11 sm:h-16 w-28 sm:w-40 md:w-44 px-2.5 py-1.5 sm:px-4 sm:py-2 rounded-xl sm:rounded-2xl bg-white/85 border border-sky-100/80 shadow-2xs sm:shadow-xs hover:shadow-md hover:border-sky-300 hover:bg-white transition-all duration-300 backdrop-blur-xs cursor-pointer group/logo" title="{{ $client->name }}">
                            <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}" loading="lazy" class="max-h-6 sm:max-h-10 max-w-[75px] sm:max-w-[125px] object-contain opacity-90 group-hover/logo:opacity-100 group-hover/logo:scale-105 transition-all duration-300">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Row 2: Marquee Right -->
            <div class="flex overflow-hidden group">
                <div class="flex shrink-0 items-center gap-2.5 sm:gap-6 md:gap-8 animate-marquee-right group-hover:[animation-play-state:paused]">
                    @foreach($row2 as $client)
                        <div class="flex items-center justify-center h-11 sm:h-16 w-28 sm:w-40 md:w-44 px-2.5 py-1.5 sm:px-4 sm:py-2 rounded-xl sm:rounded-2xl bg-white/85 border border-sky-100/80 shadow-2xs sm:shadow-xs hover:shadow-md hover:border-sky-300 hover:bg-white transition-all duration-300 backdrop-blur-xs cursor-pointer group/logo" title="{{ $client->name }}">
                            <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}" loading="lazy" class="max-h-6 sm:max-h-10 max-w-[75px] sm:max-w-[125px] object-contain opacity-90 group-hover/logo:opacity-100 group-hover/logo:scale-105 transition-all duration-300">
                        </div>
                    @endforeach
                </div>
                <!-- Duplicate Row 2 for Seamless Loop -->
                <div class="flex shrink-0 items-center gap-2.5 sm:gap-6 md:gap-8 animate-marquee-right group-hover:[animation-play-state:paused]" aria-hidden="true">
                    @foreach($row2 as $client)
                        <div class="flex items-center justify-center h-11 sm:h-16 w-28 sm:w-40 md:w-44 px-2.5 py-1.5 sm:px-4 sm:py-2 rounded-xl sm:rounded-2xl bg-white/85 border border-sky-100/80 shadow-2xs sm:shadow-xs hover:shadow-md hover:border-sky-300 hover:bg-white transition-all duration-300 backdrop-blur-xs cursor-pointer group/logo" title="{{ $client->name }}">
                            <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}" loading="lazy" class="max-h-6 sm:max-h-10 max-w-[75px] sm:max-w-[125px] object-contain opacity-90 group-hover/logo:opacity-100 group-hover/logo:scale-105 transition-all duration-300">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>
