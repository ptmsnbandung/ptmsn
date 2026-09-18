@extends('portal.layouts.app')

@section('title', 'Tagihan & Pembayaran')

@section('content')
<div class="space-y-3.5 sm:space-y-6" x-data="{ midtransModal: false }">

    <!-- Header Section -->
    <div class="flex items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-1.5 text-[11px] font-mono text-slate-500 mb-0.5">
                <a href="{{ route('portal.dashboard') }}" class="hover:text-sky-600 transition-colors">Portal</a>
                <span>/</span>
                <span class="text-sky-600 font-bold">Tagihan</span>
            </div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-heading font-extrabold text-slate-900 tracking-tight">
                Tagihan & Pembayaran
            </h1>
        </div>

        <!-- ID Pelanggan Pill -->
        <button 
            type="button" 
            onclick="copyToClipboard('{{ $customer->customer_id }}', 'ID Pelanggan {{ $customer->customer_id }}')"
            class="copy-btn px-3 py-1.5 rounded-xl bg-white/90 border border-slate-200/90 shadow-2xs hover:border-sky-400 flex items-center gap-1.5 shrink-0"
            title="Klik untuk menyalin ID"
        >
            <iconify-icon icon="solar:hashtag-bold" class="text-sky-500 text-xs"></iconify-icon>
            <span class="text-xs font-mono font-bold text-slate-800">{{ $customer->customer_id }}</span>
            <iconify-icon icon="solar:copy-linear" class="text-[11px] text-slate-400"></iconify-icon>
        </button>
    </div>

    <!-- Active Invoice Card -->
    <div class="portal-card rounded-2xl sm:rounded-3xl p-4 sm:p-7 relative overflow-hidden space-y-4 sm:space-y-6">
        
        <!-- Header Strip: No Invoice, Periode & Status -->
        <div class="flex items-center justify-between gap-2 pb-3 sm:pb-4 border-b border-slate-200/80 flex-wrap">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="px-2.5 py-1 rounded-lg bg-sky-50 border border-sky-200/80 font-mono text-xs font-bold text-sky-700">
                    #{{ $currentInvoice->invoice_number }}
                </span>
                <span class="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-xs font-heading font-semibold text-slate-700">
                    Periode: <strong class="text-slate-900 font-bold">{{ $currentInvoice->period }}</strong>
                </span>
            </div>

            <div class="shrink-0">
                @if($currentInvoice->is_paid)
                    <span class="badge-paid">
                        <iconify-icon icon="solar:check-circle-bold" class="text-sm"></iconify-icon>
                        <span>LUNAS</span>
                    </span>
                @else
                    <span class="badge-unpaid">
                        <iconify-icon icon="solar:danger-triangle-bold" class="text-sm"></iconify-icon>
                        <span>BELUM DIBAYAR</span>
                    </span>
                @endif
            </div>
        </div>

        <!-- Body Grid: Package & Service Details -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 items-start">
            
            <!-- Left Info: Package & Subscriber Details (7 Cols) -->
            <div class="lg:col-span-7 space-y-3.5">
                <div>
                    <span class="text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider text-slate-400">Layanan Berlangganan</span>
                    <h2 class="text-base sm:text-xl font-heading font-extrabold text-slate-900 leading-snug mt-0.5">
                        {{ $currentInvoice->package_name }}
                    </h2>
                    <div class="flex items-center gap-1.5 text-xs text-sky-600 font-medium mt-1">
                        <iconify-icon icon="solar:bolt-circle-bold" class="text-sm shrink-0"></iconify-icon>
                        <span>Kecepatan Simetris Fiber Optic Unlimited</span>
                    </div>
                </div>

                <!-- Detail Meta Box -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 p-3 rounded-xl bg-slate-50/80 border border-slate-200/80 text-xs">
                    <div class="space-y-0.5">
                        <span class="text-slate-400 text-[11px] block">Jatuh Tempo:</span>
                        <span class="font-mono font-bold {{ $currentInvoice->is_paid ? 'text-slate-700' : 'text-rose-600' }}">
                            {{ $currentInvoice->due_date?->translatedFormat('d F Y') ?? 'Tgl ' . $customer->due_date . ' / bln' }}
                        </span>
                    </div>
                    <div class="space-y-0.5">
                        <span class="text-slate-400 text-[11px] block">Nama Pelanggan:</span>
                        <span class="font-heading font-semibold text-slate-800 truncate block">{{ $customer->name }}</span>
                    </div>
                    <div class="sm:col-span-2 space-y-0.5 pt-1.5 border-t border-slate-200/60">
                        <span class="text-slate-400 text-[11px] block">Alamat Pemasangan:</span>
                        <span class="text-slate-700 text-[11px] leading-relaxed block">{{ $customer->address ?: '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Right Info: Receipt Breakdown & Payment Action (5 Cols) -->
            <div class="lg:col-span-5 space-y-3.5">
                
                <!-- Price Breakdown Box -->
                <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-white/90 border border-slate-200/90 shadow-2xs space-y-2">
                    <div class="text-[11px] font-mono uppercase text-slate-400 font-bold tracking-wider pb-1.5 border-b border-slate-100">
                        Rincian Tagihan
                    </div>

                    <div class="space-y-1.5 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <span>Biaya Paket (1 Bulan)</span>
                            <span class="font-mono font-semibold text-slate-800">{{ $currentInvoice->formatted_amount }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Biaya Admin & Pajak</span>
                            <span class="font-mono font-semibold text-emerald-600">Termasuk (Rp 0)</span>
                        </div>
                        <div class="pt-2 border-t border-slate-100 flex justify-between items-baseline">
                            <span class="font-heading font-bold text-slate-800 text-xs sm:text-sm">Total Tagihan:</span>
                            <span class="font-heading font-black text-lg sm:text-2xl text-sky-600 tracking-tight">
                                {{ $currentInvoice->formatted_total }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="space-y-2">
                    @if(!$currentInvoice->is_paid)
                        <button 
                            type="button" 
                            id="btnPayMain"
                            onclick="payWithMidtrans('{{ $currentInvoice->kode_billing_layanan }}', 'btnPayMain')"
                            class="w-full py-2.5 sm:py-3 px-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-heading font-extrabold text-xs sm:text-sm shadow-md shadow-emerald-500/20 active:scale-98 transition-all flex items-center justify-center gap-2 text-center disabled:opacity-60"
                        >
                            <iconify-icon icon="solar:card-recive-bold" class="text-base sm:text-lg"></iconify-icon>
                            <span>Bayar Sekarang (Midtrans)</span>
                        </button>
                        <p class="text-[10px] text-center text-slate-500">
                            Otomatis terverifikasi 24 jam via QRIS, Virtual Account, & E-Wallet
                        </p>
                    @else
                        <div class="p-3 rounded-xl bg-emerald-50/90 border border-emerald-200 text-center space-y-0.5">
                            <div class="flex items-center justify-center gap-1.5 text-emerald-800 font-heading font-bold text-xs">
                                <iconify-icon icon="solar:check-circle-bold" class="text-emerald-600 text-base"></iconify-icon>
                                <span>Tagihan Telah Lunas</span>
                            </div>
                            <p class="text-[11px] text-emerald-700">Layanan internet Anda aktif tanpa kendala.</p>
                        </div>
                    @endif

                    <!-- Print Button -->
                    <a 
                        href="{{ route('portal.billing.show', urlencode($currentInvoice->kode_billing_layanan)) }}" 
                        target="_blank"
                        class="w-full py-2 px-3 rounded-xl bg-slate-50 hover:bg-sky-50 border border-slate-200 hover:border-sky-300 text-slate-700 hover:text-sky-700 font-heading font-semibold text-xs transition-all flex items-center justify-center gap-1.5 shadow-2xs text-center"
                    >
                        <iconify-icon icon="solar:printer-minimalistic-bold" class="text-slate-500"></iconify-icon>
                        <span>Cetak / Unduh Bukti Invoice</span>
                    </a>
                </div>

            </div>

        </div>

        <!-- Payment Channels Supported Strip -->
        <div class="pt-3 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-2 text-slate-500">
            <div class="flex items-center gap-1.5 text-[11px] font-heading font-semibold text-slate-600">
                <iconify-icon icon="solar:shield-check-bold" class="text-emerald-500 text-sm"></iconify-icon>
                <span>Kanal Pembayaran Midtrans yang Didukung:</span>
            </div>

            <div class="flex items-center gap-1.5 flex-wrap justify-center text-[10px] font-mono font-bold">
                <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-700 shadow-2xs">QRIS</span>
                <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-700 shadow-2xs">BCA VA</span>
                <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-700 shadow-2xs">Mandiri</span>
                <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-700 shadow-2xs">BRI</span>
                <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-700 shadow-2xs">BNI</span>
                <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-700 shadow-2xs">Alfamart / Indomaret</span>
            </div>
        </div>

    </div>

    <!-- Riwayat Pembayaran & Tagihan -->
    <div class="portal-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 space-y-3.5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">
                    <iconify-icon icon="solar:history-bold" class="text-base"></iconify-icon>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-heading font-bold text-slate-900">
                        Riwayat Pembayaran & Tagihan
                    </h3>
                    <p class="text-[11px] text-slate-500">
                        Daftar seluruh tagihan periode bulan berjalan dan bulan sebelumnya.
                    </p>
                </div>
            </div>
        </div>

        <!-- Mobile Card View (sm:hidden) -->
        <div class="sm:hidden space-y-2.5">
            @forelse($invoices as $inv)
                <div class="p-3 rounded-xl bg-white border border-slate-200/80 shadow-2xs space-y-2">
                    <div class="flex items-center justify-between gap-2">
                        <span class="font-mono text-xs font-bold text-slate-800">#{{ $inv->invoice_number }}</span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-mono font-bold border {{ $inv->status_badge_classes }}">
                            @if($inv->is_paid)
                                <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                            @else
                                <iconify-icon icon="solar:clock-circle-bold"></iconify-icon>
                            @endif
                            <span>{{ $inv->status_label }}</span>
                        </span>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-100">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $inv->period }}</div>
                            <div class="text-[10px] text-slate-500">{{ $inv->package_name }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-mono font-extrabold text-sky-600">{{ $inv->formatted_total }}</div>
                            <div class="text-[10px] text-slate-400 font-mono">Tempo: {{ $inv->due_date?->format('d/m/Y') }}</div>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex items-center justify-end gap-2">
                        @if(!$inv->is_paid)
                            <button 
                                type="button" 
                                id="btnPayMobile-{{ $loop->index }}"
                                onclick="payWithMidtrans('{{ $inv->kode_billing_layanan }}', 'btnPayMobile-{{ $loop->index }}')"
                                class="px-2.5 py-1 rounded-lg bg-emerald-600 text-white font-semibold text-xs flex items-center gap-1 shadow-2xs"
                            >
                                <iconify-icon icon="solar:card-recive-bold" width="13"></iconify-icon>
                                <span>Bayar</span>
                            </button>
                        @endif
                        <a 
                            href="{{ route('portal.billing.show', urlencode($inv->kode_billing_layanan)) }}" 
                            target="_blank"
                            class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 hover:text-sky-700 font-semibold text-xs flex items-center gap-1"
                        >
                            <iconify-icon icon="solar:document-text-bold" width="13"></iconify-icon>
                            <span>Struk</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-6 text-center text-slate-400 text-xs">
                    Belum ada riwayat tagihan.
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View (hidden sm:block) -->
        <div class="hidden sm:block overflow-x-auto rounded-xl border border-slate-200/80 bg-white/70">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50/80 text-[11px] font-mono uppercase text-slate-500 border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-4">No. Invoice</th>
                        <th class="py-3 px-4">Periode</th>
                        <th class="py-3 px-4">Paket</th>
                        <th class="py-3 px-4">Total</th>
                        <th class="py-3 px-4">Jatuh Tempo</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-sans">
                    @forelse($invoices as $inv)
                        <tr class="hover:bg-sky-50/40 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-slate-800">
                                {{ $inv->invoice_number }}
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-800">
                                {{ $inv->period }}
                            </td>
                            <td class="py-3 px-4 text-slate-600 text-xs">
                                {{ $inv->package_name }}
                            </td>
                            <td class="py-3 px-4 font-mono font-bold text-slate-900">
                                {{ $inv->formatted_total }}
                            </td>
                            <td class="py-3 px-4 font-mono text-xs text-slate-500">
                                {{ $inv->due_date?->format('d/m/Y') }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold border {{ $inv->status_badge_classes }}">
                                    @if($inv->is_paid)
                                        <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                                    @else
                                        <iconify-icon icon="solar:clock-circle-bold"></iconify-icon>
                                    @endif
                                    <span>{{ $inv->status_label }}</span>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    @if(!$inv->is_paid)
                                        <button 
                                            type="button" 
                                            id="btnPayHist-{{ $loop->index }}"
                                            onclick="payWithMidtrans('{{ $inv->kode_billing_layanan }}', 'btnPayHist-{{ $loop->index }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-2xs transition-all disabled:opacity-60"
                                            title="Bayar tagihan ini via Midtrans"
                                        >
                                            <iconify-icon icon="solar:card-recive-bold" width="13"></iconify-icon>
                                            <span>Bayar</span>
                                        </button>
                                    @endif
                                    <a 
                                        href="{{ route('portal.billing.show', urlencode($inv->kode_billing_layanan)) }}" 
                                        target="_blank"
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-slate-100 hover:bg-sky-100 text-slate-700 hover:text-sky-700 transition-colors font-semibold text-xs"
                                        title="Cetak struk resmi"
                                    >
                                        <iconify-icon icon="solar:document-text-bold" width="13"></iconify-icon>
                                        <span>Struk</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                <iconify-icon icon="solar:inbox-line" width="36" class="mx-auto mb-2 opacity-60"></iconify-icon>
                                <p>Belum ada riwayat tagihan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ $snapJsUrl }}" data-client-key="{{ $clientKey }}"></script>
<script>
    function payWithMidtrans(kodeBilling, btnId = null) {
        let btn = null;
        let originalContent = '';
        if (btnId) {
            btn = document.getElementById(btnId);
            if (btn) {
                originalContent = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<iconify-icon icon="solar:spinner-line" class="animate-spin inline-block mr-1" width="16"></iconify-icon><span>Memproses Midtrans...</span>';
            }
        }

        const endpoint = `{{ url('/portal/tagihan') }}/${encodeURIComponent(kodeBilling)}/pay`;

        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalContent;
            }

            if (data.success && data.token) {
                if (typeof window.snap !== 'undefined') {
                    window.snap.pay(data.token, {
                        onSuccess: function(result) {
                            fetch(`{{ url('/portal/tagihan') }}/${encodeURIComponent(kodeBilling)}/sync`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            }).finally(() => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pembayaran Berhasil!',
                                    text: 'Pembayaran tagihan Anda berhasil dikonfirmasi. Halaman akan dimuat ulang.',
                                    confirmButtonColor: '#0ea5e9'
                                }).then(() => window.location.reload());
                            });
                        },
                        onPending: function(result) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Menunggu Pembayaran',
                                text: 'Instruksi pembayaran telah dibuat. Silakan selesaikan pembayaran sesuai panduan Midtrans.',
                                confirmButtonColor: '#0ea5e9'
                            }).then(() => window.location.reload());
                        },
                        onError: function(result) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Pembayaran Dibatalkan',
                                text: 'Pembayaran gagal diproses atau telah dibatalkan.',
                                confirmButtonColor: '#0ea5e9'
                            });
                        },
                        onClose: function() {
                            console.log('Jendela popup Snap Midtrans ditutup.');
                        }
                    });
                } else if (data.redirect_url) {
                    window.open(data.redirect_url, '_blank');
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Siap Membayar',
                        text: 'Sistem pembayaran Midtrans siap diproses.',
                        confirmButtonColor: '#0ea5e9'
                    });
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: data.message || 'Gagal memproses pembayaran Midtrans. Mohon periksa konfigurasi server.',
                    confirmButtonColor: '#0ea5e9'
                });
            }
        })
        .catch(err => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalContent;
            }
            console.error('Midtrans Request Error:', err);
            Swal.fire({
                icon: 'error',
                title: 'Gangguan Server',
                text: 'Terjadi kendala saat menghubungi server pembayaran.',
                confirmButtonColor: '#0ea5e9'
            });
        });
    }
</script>
@endpush
