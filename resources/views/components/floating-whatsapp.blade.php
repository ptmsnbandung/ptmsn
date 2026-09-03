@php
    $whatsappNumber = config('company.whatsapp');
    $waText = urlencode("Halo PT Media Solusi Network, saya ingin mendapatkan informasi mengenai layanan internet.");
    $waUrl = "https://wa.me/{$whatsappNumber}?text={$waText}";
@endphp

<div class="fixed bottom-5 right-4 sm:bottom-6 sm:right-6 z-50 flex items-center gap-3">
    <!-- Invitation Bubble -->
    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="hidden sm:inline-flex items-center px-4 py-2 rounded-full bg-[#050d1a]/95 border border-emerald-500/40 text-white text-xs font-heading font-medium shadow-2xl backdrop-blur-md hover:border-emerald-400 transition-colors" aria-label="Konsultasi WhatsApp">
        <span>Butuh bantuan internet? <strong class="text-[#25D366]">Chat WhatsApp</strong></span>
    </a>

    <!-- Floating WhatsApp Button (No Pulse) -->
    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="w-13 h-13 sm:w-14 sm:h-14 rounded-full bg-[#25D366] hover:bg-[#20ba5a] text-white flex items-center justify-center shadow-[0_4px_20px_rgba(37,211,102,0.45)] hover:scale-110 active:scale-95 transition-all duration-300 relative group" aria-label="Chat WhatsApp PT Media Solusi Network" title="Chat WhatsApp PT Media Solusi Network">
        <svg class="w-7 h-7 sm:w-8 sm:h-8 fill-current text-white transition-transform duration-300 group-hover:scale-105" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm0 18.15c-1.49 0-2.95-.4-4.23-1.16l-.3-.18-3.14.82.84-3.06-.2-.31a8.16 8.16 0 01-1.25-4.36c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 012.41 5.83c.02 4.54-3.68 8.24-8.2 8.24zm4.52-6.17c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.12-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.39-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.15.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.12-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.12.17 1.77 2.71 4.3 3.79.6.26 1.07.41 1.44.53.61.2 1.16.17 1.6.1.49-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.17-.48-.29z"/>
        </svg>
    </a>
</div>
