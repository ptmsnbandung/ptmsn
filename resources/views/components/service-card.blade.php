@props(['service'])

<div class="group relative rounded-2xl bg-white border border-white/90 p-8 shadow-xl transition-all duration-300 hover:shadow-2xl hover:border-[#38bdf8] hover:-translate-y-2 flex flex-col justify-between" data-tilt>
    <div>
        <!-- Icon Container with Blue Accent -->
        <div class="w-14 h-14 rounded-2xl bg-sky-50 border border-sky-200 flex items-center justify-center text-[#0284c7] mb-6 group-hover:scale-110 group-hover:bg-[#0284c7] group-hover:text-white transition-all duration-300 shadow-sm">
            @if($service->icon === 'wifi')
                <iconify-icon icon="solar:wifi-router-bold-duotone" width="30" height="30"></iconify-icon>
            @elseif($service->icon === 'code')
                <iconify-icon icon="solar:code-circle-bold-duotone" width="30" height="30"></iconify-icon>
            @else
                <iconify-icon icon="solar:shield-check-bold-duotone" width="30" height="30"></iconify-icon>
            @endif
        </div>

        <h3 class="font-heading font-bold text-2xl text-slate-900 tracking-tight mb-3 group-hover:text-[#0284c7] transition-colors">
            {{ $service->title }}
        </h3>

        <p class="font-sans text-sm text-slate-600 leading-relaxed mb-6">
            {{ $service->description }}
        </p>

        @if(!empty($service->features))
            <div class="pt-5 border-t border-slate-100">
                <div class="text-[11px] font-mono uppercase tracking-wider text-[#0284c7] font-bold mb-3">Cakupan Layanan:</div>
                <ul class="space-y-2.5">
                    @foreach($service->features as $feature)
                        <li class="flex items-center gap-2.5 text-xs sm:text-sm text-slate-700 font-medium">
                            <span class="w-4 h-4 rounded-full bg-sky-100 border border-sky-300 flex items-center justify-center text-[#0284c7] flex-shrink-0 text-[10px] font-bold">
                                ✓
                            </span>
                            <span>{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="pt-6 mt-6 border-t border-slate-100">
        <a href="#kontak" class="inline-flex items-center gap-2 text-xs font-heading font-bold text-[#0284c7] group-hover:translate-x-1.5 transition-transform">
            <span>Konsultasikan Kebutuhan</span>
            <iconify-icon icon="solar:arrow-right-linear" width="14"></iconify-icon>
        </a>
    </div>
</div>
