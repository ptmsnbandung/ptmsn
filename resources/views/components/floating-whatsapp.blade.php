@php
    $whatsappNumber = config('company.whatsapp');
    $waText = urlencode("Halo PT Media Solusi Network, saya ingin mendapatkan informasi mengenai layanan internet.");
    $waUrl = "https://wa.me/{$whatsappNumber}?text={$waText}";
@endphp

<div class="fixed bottom-6 right-6 z-50 flex items-center gap-3">
    <!-- Invitation Bubble -->
    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="hidden sm:inline-flex items-center px-4 py-2 rounded-full bg-[#050d1a]/95 border border-[#38bdf8]/40 text-white text-xs font-heading font-medium shadow-2xl backdrop-blur-md hover:border-[#38bdf8] transition-colors" aria-label="Konsultasi WhatsApp">
        <span>Butuh bantuan internet? <strong class="text-[#38bdf8]">Chat Sales</strong></span>
    </a>

    <!-- Floating Button with Pulse -->
    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="w-14 h-14 rounded-full bg-[#38bdf8] text-[#050d1a] flex items-center justify-center shadow-[0_0_25px_rgba(56,189,248,0.5)] hover:scale-110 active:scale-95 transition-all duration-300 relative group" aria-label="Chat WhatsApp PT Media Solusi Network" title="Chat WhatsApp PT Media Solusi Network">
        <div class="absolute inset-0 rounded-full bg-[#38bdf8]/40 animate-ping pointer-events-none"></div>
        <iconify-icon icon="solar:chat-round-dots-bold" width="28" height="28" class="group-hover:rotate-12 transition-transform duration-300"></iconify-icon>
    </a>
</div>
