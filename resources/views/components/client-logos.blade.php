@props(['clients'])

<section id="client" class="pt-6 sm:pt-8 pb-16 sm:pb-20 px-4 sm:px-6 lg:px-8 relative z-10 w-full bg-transparent overflow-hidden">
    <div class="max-w-7xl mx-auto">
        
        <!-- Clean, Subtle Section Header -->
        <div class="text-center max-w-xl mx-auto mb-8 sm:mb-10">
            <div class="inline-flex items-center px-3.5 py-1 rounded-full bg-white/80 border border-sky-100 shadow-2xs backdrop-blur-sm text-[11px] font-mono font-semibold text-slate-500 uppercase tracking-widest">
                <span>Dipercaya oleh Berbagai Perusahaan & Institusi di Indonesia</span>
            </div>
        </div>

        <!-- Pure Logo Showcase: Seamless Marquee (Direct Full Color with subtle Glass Cards) -->
        @php
            $clientList = $clients->values();
            $halfCount = ceil($clientList->count() / 2);
            $row1 = $clientList->slice(0, $halfCount);
            $row2 = $clientList->slice($halfCount);
        @endphp

        <div class="relative w-full space-y-5 py-2">
            <!-- Left & Right Gradient Fade Overlays (Soft Blend into ambient canvas) -->
            <div class="absolute top-0 left-0 bottom-0 w-24 sm:w-36 bg-gradient-to-r from-[#f8fafc] via-[#f8fafc]/80 to-transparent z-10 pointer-events-none"></div>
            <div class="absolute top-0 right-0 bottom-0 w-24 sm:w-36 bg-gradient-to-l from-[#f8fafc] via-[#f8fafc]/80 to-transparent z-10 pointer-events-none"></div>

            <!-- Row 1: Marquee Left (Direct Full Color on Floating Glass Cards) -->
            <div class="flex overflow-hidden group">
                <div class="flex shrink-0 items-center gap-6 sm:gap-8 animate-marquee-left group-hover:[animation-play-state:paused]">
                    @foreach($row1 as $client)
                        <div class="flex items-center justify-center h-16 w-40 sm:w-44 px-4 py-2 rounded-2xl bg-white/85 border border-sky-100/80 shadow-xs hover:shadow-md hover:border-sky-300 hover:bg-white transition-all duration-300 backdrop-blur-xs cursor-pointer group/logo" title="{{ $client->name }}">
                            <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}" loading="lazy" class="max-h-10 max-w-[125px] object-contain opacity-90 group-hover/logo:opacity-100 group-hover/logo:scale-110 transition-all duration-300">
                        </div>
                    @endforeach
                </div>
                <!-- Duplicate Row 1 for Seamless Loop -->
                <div class="flex shrink-0 items-center gap-6 sm:gap-8 animate-marquee-left group-hover:[animation-play-state:paused]" aria-hidden="true">
                    @foreach($row1 as $client)
                        <div class="flex items-center justify-center h-16 w-40 sm:w-44 px-4 py-2 rounded-2xl bg-white/85 border border-sky-100/80 shadow-xs hover:shadow-md hover:border-sky-300 hover:bg-white transition-all duration-300 backdrop-blur-xs cursor-pointer group/logo" title="{{ $client->name }}">
                            <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}" loading="lazy" class="max-h-10 max-w-[125px] object-contain opacity-90 group-hover/logo:opacity-100 group-hover/logo:scale-110 transition-all duration-300">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Row 2: Marquee Right (Direct Full Color on Floating Glass Cards) -->
            <div class="flex overflow-hidden group">
                <div class="flex shrink-0 items-center gap-6 sm:gap-8 animate-marquee-right group-hover:[animation-play-state:paused]">
                    @foreach($row2 as $client)
                        <div class="flex items-center justify-center h-16 w-40 sm:w-44 px-4 py-2 rounded-2xl bg-white/85 border border-sky-100/80 shadow-xs hover:shadow-md hover:border-sky-300 hover:bg-white transition-all duration-300 backdrop-blur-xs cursor-pointer group/logo" title="{{ $client->name }}">
                            <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}" loading="lazy" class="max-h-10 max-w-[125px] object-contain opacity-90 group-hover/logo:opacity-100 group-hover/logo:scale-110 transition-all duration-300">
                        </div>
                    @endforeach
                </div>
                <!-- Duplicate Row 2 for Seamless Loop -->
                <div class="flex shrink-0 items-center gap-6 sm:gap-8 animate-marquee-right group-hover:[animation-play-state:paused]" aria-hidden="true">
                    @foreach($row2 as $client)
                        <div class="flex items-center justify-center h-16 w-40 sm:w-44 px-4 py-2 rounded-2xl bg-white/85 border border-sky-100/80 shadow-xs hover:shadow-md hover:border-sky-300 hover:bg-white transition-all duration-300 backdrop-blur-xs cursor-pointer group/logo" title="{{ $client->name }}">
                            <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}" loading="lazy" class="max-h-10 max-w-[125px] object-contain opacity-90 group-hover/logo:opacity-100 group-hover/logo:scale-110 transition-all duration-300">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>
