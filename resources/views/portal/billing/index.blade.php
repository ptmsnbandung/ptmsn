@extends('portal.layouts.app')

@section('title', 'Tagihan & Pembayaran')

@section('content')
<div class="space-y-6" x-data="{ midtransModal: false }">

    <!-- Breadcrumb & Header Title -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-mono text-slate-500 mb-1">
                <a href="{{ route('portal.dashboard') }}" class="hover:text-sky-600 transition-colors">Portal</a>
                <span>/</span>
                <span class="text-sky-600 font-bold">Tagihan & Pembayaran</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight">
                Tagihan & Pembayaran
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">
                Pantau rincian biaya langganan bulanan dan lakukan pembayaran online mudah & instan melalui Midtrans.
            </p>
        </div>

        <!-- ID Pelanggan Badge -->
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 rounded-2xl bg-white/80 border border-slate-200/80 shadow-sm flex items-center gap-2.5">
                <iconify-icon icon="solar:user-id-bold" class="text-sky-500 text-lg"></iconify-icon>
                <div>
                    <div class="text-[10px] font-mono uppercase text-slate-400 font-bold leading-none">Nomor Internet</div>
                    <div class="text-xs sm:text-sm font-mono font-bold text-slate-800 leading-tight mt-0.5">{{ $customer->customer_id }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Invoice Card (Hero Section) -->
    <div class="portal-card rounded-3xl p-6 sm:p-8 relative overflow-hidden">
        <!-- Glow accents -->
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-sky-200/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-emerald-100/40 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10">
            <!-- Top Status Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-6 border-b border-slate-200/70">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="px-3 py-1 rounded-xl bg-slate-100 font-mono text-xs font-bold text-slate-700 border border-slate-200">
                        {{ $currentInvoice->invoice_number }}
                    </span>
                    <span class="text-xs font-heading font-semibold text-slate-500">
                        Periode: <strong class="text-slate-800">{{ $currentInvoice->period }}</strong>
                    </span>
                </div>

                <div>
                    @if($currentInvoice->status === 'paid')
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold font-mono shadow-sm">
                            <iconify-icon icon="solar:check-circle-bold" class="text-emerald-500 text-sm"></iconify-icon>
                            <span>LUNAS (SUDAH DIBAYAR)</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-xs font-bold font-mono shadow-sm animate-pulse">
                            <iconify-icon icon="solar:danger-triangle-bold" class="text-rose-500 text-sm"></iconify-icon>
                            <span>MENUNGGU PEMBAYARAN</span>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Invoice Body Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 pt-6 items-center">
                
                <!-- Col 1: Service Package Info -->
                <div class="space-y-4">
                    <div>
                        <div class="text-[11px] font-mono uppercase text-slate-400 font-bold tracking-wider mb-1">Layanan Berlangganan</div>
                        <h3 class="text-xl font-heading font-extrabold text-slate-900 leading-tight">
                            {{ $currentInvoice->package_name }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                            <iconify-icon icon="solar:transfer-horizontal-bold" class="text-sky-500"></iconify-icon>
                            <span>Kecepatan Simetris 1:1 Fiber Optic Unlimited</span>
                        </p>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/60 space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Jatuh Tempo:</span>
                            <span class="font-mono font-bold text-rose-600">{{ $currentInvoice->due_date?->translatedFormat('d F Y') ?? 'Tgl ' . $customer->due_date . ' / bulan' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nama Pelanggan:</span>
                            <span class="font-heading font-semibold text-slate-800">{{ $customer->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Alamat Pasang:</span>
                            <span class="text-slate-700 text-right truncate max-w-[180px]">{{ $customer->address ?: '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Breakdown Price Detail -->
                <div class="p-5 rounded-2xl bg-white/90 border border-slate-200/80 shadow-sm space-y-3">
                    <div class="text-xs font-mono uppercase text-slate-400 font-bold tracking-wider pb-2 border-b border-slate-100">
                        Rincian Tagihan
                    </div>

                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <span>Biaya Internet (1 Bulan)</span>
                            <span class="font-mono font-semibold">{{ $currentInvoice->formatted_amount }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Biaya Administrasi & Pajak</span>
                            <span class="font-mono font-semibold text-emerald-600">Termasuk (Rp 0)</span>
                        </div>
                        <div class="pt-2 border-t border-slate-100 flex justify-between items-baseline">
                            <span class="font-heading font-bold text-slate-800 text-sm">Total Bayar:</span>
                            <span class="font-heading font-black text-xl sm:text-2xl text-sky-600 tracking-tight">
                                {{ $currentInvoice->formatted_total }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Col 3: Action & Midtrans Checkout Button -->
                <div class="flex flex-col justify-center space-y-3">
                    @if(!$currentInvoice->is_paid)
                        <!-- Button Bayar Sekarang (Trigger Midtrans Payment) -->
                        <button 
                            type="button" 
                            id="btnPayMain"
                            onclick="payWithMidtrans('{{ $currentInvoice->kode_billing_layanan }}', 'btnPayMain')"
                            class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 hover:from-emerald-600 hover:to-teal-700 text-white font-heading font-extrabold text-sm uppercase tracking-wider shadow-lg shadow-emerald-500/25 hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-center disabled:opacity-60 disabled:cursor-not-allowed"
                        >
                            <iconify-icon icon="solar:card-recive-bold" width="22"></iconify-icon>
                            <span>Bayar Sekarang (Midtrans)</span>
                        </button>

                        <p class="text-[11px] text-center text-slate-500 font-sans">
                            Pembayaran instan terverifikasi otomatis 24 jam via QRIS, Virtual Account Bank & Gerai Retail.
                        </p>
                    @else
                        <!-- Paid State Notification -->
                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-center space-y-1.5">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto">
                                <iconify-icon icon="solar:check-circle-bold" width="24"></iconify-icon>
                            </div>
                            <div class="text-sm font-heading font-bold text-emerald-900">Tagihan Sudah Lunas</div>
                            <div class="text-xs text-emerald-700">
                                Terima kasih! Layanan internet Anda aktif lancar tanpa kendala.
                            </div>
                        </div>
                    @endif

                    <!-- Print / View Detail Button -->
                    <a 
                        href="{{ route('portal.billing.show', urlencode($currentInvoice->kode_billing_layanan)) }}" 
                        target="_blank"
                        class="w-full py-2.5 px-4 rounded-2xl bg-white/90 hover:bg-white border border-slate-200 hover:border-sky-300 text-slate-700 hover:text-sky-700 font-heading font-semibold text-xs shadow-2xs hover:shadow transition-all flex items-center justify-center gap-2 text-center"
                    >
                        <iconify-icon icon="solar:printer-minimalistic-bold" width="16"></iconify-icon>
                        <span>Cetak / Unduh Bukti Invoice</span>
                    </a>
                </div>

            </div>

            <!-- Supported Midtrans Payment Channels Banner -->
            <div class="mt-8 pt-5 border-t border-slate-200/70 flex flex-col sm:flex-row items-center justify-between gap-4 text-slate-500">
                <div class="flex items-center gap-2 text-xs font-heading font-semibold text-slate-600">
                    <iconify-icon icon="solar:shield-check-bold" class="text-emerald-500 text-base"></iconify-icon>
                    <span>Metode Pembayaran Online yang Didukung:</span>
                </div>

                <div class="flex items-center gap-2 flex-wrap justify-center text-xs font-mono font-bold">
                    <span class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 shadow-2xs">QRIS (GoPay/OVO/Dana)</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 shadow-2xs">BCA VA</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 shadow-2xs">Mandiri</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 shadow-2xs">BRI</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 shadow-2xs">Alfamart / Indomaret</span>
                </div>
            </div>
        </div>
    </div>

    <!-- History Invoices Table -->
    <div class="portal-card rounded-3xl p-6 sm:p-7">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-base sm:text-lg font-heading font-bold text-slate-900">
                    Riwayat Pembayaran & Tagihan
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Daftar seluruh tagihan periode bulan berjalan dan bulan sebelumnya.
                </p>
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-200/80 bg-white/60">
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
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-800">
                                {{ $inv->invoice_number }}
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">
                                {{ $inv->period }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 text-xs">
                                {{ $inv->package_name }}
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-900">
                                {{ $inv->formatted_total }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-xs text-slate-500">
                                {{ $inv->due_date?->format('d/m/Y') }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold border {{ $inv->status_badge_classes }}">
                                    @if($inv->status === 'paid')
                                        <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                                    @else
                                        <iconify-icon icon="solar:clock-circle-bold"></iconify-icon>
                                    @endif
                                    <span>{{ $inv->status_label }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
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

    <!-- Midtrans Payment Simulation / Ready Modal -->
    <div 
        x-show="midtransModal" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        style="display: none;"
    >
        <div class="portal-card w-full max-w-lg rounded-3xl p-6 sm:p-7 shadow-2xl relative bg-white">
            <button @click="midtransModal = false" class="absolute top-5 right-5 p-2 rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                <iconify-icon icon="solar:close-circle-bold" width="22"></iconify-icon>
            </button>

            <div class="text-center space-y-2 mb-5">
                <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center mx-auto shadow-sm">
                    <iconify-icon icon="solar:card-recive-bold" width="26"></iconify-icon>
                </div>
                <h3 class="text-lg sm:text-xl font-heading font-extrabold text-slate-900">
                    Pembayaran Online Midtrans
                </h3>
                <p class="text-xs text-slate-500">
                    Invoice: <strong class="text-slate-800 font-mono">{{ $currentInvoice->invoice_number }}</strong>
                </p>
            </div>

            <!-- Billing Summary Box -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 mb-5 space-y-2 text-xs">
                <div class="flex justify-between text-slate-600">
                    <span>Pelanggan:</span>
                    <span class="font-bold text-slate-800">{{ $customer->name }} ({{ $customer->customer_id }})</span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Periode Tagihan:</span>
                    <span class="font-bold text-slate-800">{{ $currentInvoice->period }}</span>
                </div>
                <div class="flex justify-between items-baseline pt-2 border-t border-slate-200/60">
                    <span class="font-bold text-slate-800">Total Pembayaran:</span>
                    <span class="font-mono font-black text-xl text-sky-600">{{ $currentInvoice->formatted_total }}</span>
                </div>
            </div>

            <!-- Setup Instruction for Admin/Owner -->
            <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs space-y-1 mb-5">
                <div class="flex items-center gap-1.5 font-bold text-amber-800">
                    <iconify-icon icon="solar:info-circle-bold"></iconify-icon>
                    <span>Status Integrasi Payment Gateway Midtrans:</span>
                </div>
                <p class="text-[11px] leading-relaxed text-amber-800/90">
                    Tampilan antarmuka (UI) dan sistem tagihan telah siap. Untuk membuka pop-up pembayaran otomatis (Snap Popup), masukkan <strong>Server Key</strong> & <strong>Client Key</strong> Midtrans Anda ke file <code class="bg-amber-100/80 px-1 rounded font-mono">.env</code>.
                </p>
            </div>

            <!-- Modal Action Buttons -->
            <div class="flex gap-3">
                <button 
                    type="button" 
                    @click="midtransModal = false"
                    class="w-full py-3 px-4 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 font-heading font-bold text-xs transition-all"
                >
                    Tutup
                </button>
                <a 
                    href="https://wa.me/6281214878436?text=Halo%20Admin%20PT%20MSN,%20saya%20ingin%20konfirmasi%20pembayaran%20tagihan%20nomor%20{{ $currentInvoice->invoice_number }}%20sebesar%20{{ $currentInvoice->formatted_total }}" 
                    target="_blank"
                    class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-heading font-bold text-xs hover:shadow-md transition-all flex items-center justify-center gap-1.5"
                >
                    <iconify-icon icon="solar:chat-round-dots-bold" width="16"></iconify-icon>
                    <span>Konfirmasi via WA</span>
                </a>
            </div>
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
                            alert('Pembayaran berhasil dikonfirmasi! Halaman akan diperbarui.');
                            window.location.reload();
                        },
                        onPending: function(result) {
                            alert('Transaksi Anda sedang diproses / menunggu pembayaran.');
                            window.location.reload();
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal atau dibatalkan oleh pengguna.');
                        },
                        onClose: function() {
                            console.log('Jendela popup Snap Midtrans ditutup.');
                        }
                    });
                } else if (data.redirect_url) {
                    window.open(data.redirect_url, '_blank');
                } else {
                    alert('Sistem pembayaran Midtrans siap. Token didapatkan.');
                }
            } else {
                alert(data.message || 'Gagal memproses pembayaran Midtrans. Mohon periksa koneksi atau konfigurasi.');
            }
        })
        .catch(err => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalContent;
            }
            console.error('Midtrans Request Error:', err);
            alert('Terjadi kendala saat menghubungi server pembayaran.');
        });
    }
</script>
@endpush

