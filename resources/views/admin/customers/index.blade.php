@extends('admin.layouts.app')

@section('title', 'Data Pelanggan')
@section('header', 'Manajemen Data Pelanggan')

@section('content')
<div class="space-y-5" x-data="{ createModalOpen: false }">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="text-xs text-slate-400">Total Pelanggan Terdaftar: <span class="text-[#38bdf8] font-bold font-mono">{{ $customers->total() }}</span></div>
        </div>
        <div class="flex items-center gap-2">
            <button @click="createModalOpen = true" class="px-4 py-2 rounded-xl bg-[#38bdf8] hover:bg-white text-[#050d1a] font-heading font-bold text-xs transition-all shadow-md flex items-center gap-1.5">
                <iconify-icon icon="solar:user-plus-bold" width="16"></iconify-icon>
                <span>Tambah Pelanggan Baru</span>
            </button>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="p-3.5 rounded-xl bg-white/[0.03] border border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.customers.index') }}" class="px-3 py-1 rounded-lg text-xs font-semibold {{ !request('status') ? 'bg-[#38bdf8] text-[#050d1a] font-bold' : 'text-slate-300 hover:bg-white/[0.05]' }}">
                Semua
            </a>
            <a href="{{ route('admin.customers.index', ['status' => 'active']) }}" class="px-3 py-1 rounded-lg text-xs font-semibold {{ request('status') === 'active' ? 'bg-[#38bdf8] text-[#050d1a] font-bold' : 'text-slate-300 hover:bg-white/[0.05]' }}">
                Aktif
            </a>
            <a href="{{ route('admin.customers.index', ['status' => 'isolated']) }}" class="px-3 py-1 rounded-lg text-xs font-semibold {{ request('status') === 'isolated' ? 'bg-[#38bdf8] text-[#050d1a] font-bold' : 'text-slate-300 hover:bg-white/[0.05]' }}">
                Isolir
            </a>
        </div>

        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex items-center gap-2">
            <div class="relative w-full sm:w-64">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama, ID, no HP..." 
                    class="w-full pl-8 pr-3 py-1.5 rounded-lg bg-white/[0.06] border border-white/10 text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-[#38bdf8]"
                >
                <iconify-icon icon="solar:magnifer-linear" class="absolute left-2.5 top-2 text-slate-400 text-xs"></iconify-icon>
            </div>
            <button type="submit" class="px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs text-white font-semibold">
                Cari
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="rounded-xl border border-white/10 bg-[#081528]/80 overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-white/[0.04] text-slate-400 font-mono uppercase text-[10px] tracking-wider border-b border-white/10">
                    <tr>
                        <th class="py-3 px-4">ID Pelanggan</th>
                        <th class="py-3 px-4">Nama Pelanggan</th>
                        <th class="py-3 px-4">No. HP / WhatsApp</th>
                        <th class="py-3 px-4">Paket Internet</th>
                        <th class="py-3 px-4">Tagihan & Status</th>
                        <th class="py-3 px-4">IP Address</th>
                        <th class="py-3 px-4">Tiket Aktif</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-slate-300">
                    @forelse($customers as $cust)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-[#38bdf8]">
                                {{ $cust->customer_id }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-white">{{ $cust->name }}</div>
                                <div class="text-[10px] text-slate-400 truncate max-w-[180px]">{{ $cust->address ?? '-' }}</div>
                            </td>
                            <td class="py-3 px-4 font-mono">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cust->phone) }}" target="_blank" class="text-emerald-400 hover:underline flex items-center gap-1">
                                    <iconify-icon icon="solar:chat-round-dots-bold"></iconify-icon>
                                    <span>{{ $cust->phone }}</span>
                                </a>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-semibold text-white">{{ $cust->package->name ?? '-' }}</div>
                                <div class="text-[10px] text-sky-400 font-mono">{{ $cust->package->speed ?? '-' }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <div>Rp {{ number_format($cust->billing_amount, 0, ',', '.') }}</div>
                                <span class="px-2 py-0.2 rounded text-[10px] font-mono {{ $cust->billing_status === 'paid' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-rose-500/20 text-rose-300' }}">
                                    {{ strtoupper($cust->billing_status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-mono text-[11px] text-slate-400">
                                {{ $cust->ip_address ?? '—' }}
                            </td>
                            <td class="py-3 px-4">
                                @if($cust->active_tickets_count > 0)
                                    <a href="{{ route('admin.tickets.index', ['search' => $cust->customer_id]) }}" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-300 font-bold font-mono text-[10px] hover:bg-rose-500/30">
                                        <iconify-icon icon="solar:danger-triangle-bold"></iconify-icon>
                                        <span>{{ $cust->active_tickets_count }} Aktif</span>
                                    </a>
                                @else
                                    <span class="text-slate-500 text-[11px]">0</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <form action="{{ route('admin.customers.destroy', $cust->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition-colors" title="Hapus">
                                        <iconify-icon icon="solar:trash-bin-trash-bold" width="14"></iconify-icon>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-500">
                                Belum ada data pelanggan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 border-t border-white/10">
            {{ $customers->links() }}
        </div>
    </div>

    <!-- Modal Tambah Pelanggan Baru -->
    <div 
        x-show="createModalOpen" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
        style="display: none;"
    >
        <div class="bg-[#081528] border border-white/10 rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto" @click.outside="createModalOpen = false">
            <div class="flex items-center justify-between pb-3 border-b border-white/10">
                <h3 class="text-sm font-heading font-bold text-white">Tambah Pelanggan Baru</h3>
                <button @click="createModalOpen = false" class="text-slate-400 hover:text-white">
                    <iconify-icon icon="solar:close-circle-bold" width="20"></iconify-icon>
                </button>
            </div>

            <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-3.5 text-xs">
                @csrf

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-mono font-bold text-slate-300 mb-1">ID Pelanggan *</label>
                        <input type="text" name="customer_id" required value="MSN-{{ date('Y') }}-{{ rand(100, 999) }}" class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-white font-mono">
                    </div>
                    <div>
                        <label class="block font-mono font-bold text-slate-300 mb-1">PIN / Password *</label>
                        <input type="text" name="password" required value="123456" class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-white font-mono">
                    </div>
                </div>

                <div>
                    <label class="block font-mono font-bold text-slate-300 mb-1">Nama Lengkap *</label>
                    <input type="text" name="name" required placeholder="Contoh: Hendra Wijaya" class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-white">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-mono font-bold text-slate-300 mb-1">No. HP / WhatsApp *</label>
                        <input type="text" name="phone" required placeholder="0812xxxxxxxx" class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-white font-mono">
                    </div>
                    <div>
                        <label class="block font-mono font-bold text-slate-300 mb-1">Email</label>
                        <input type="email" name="email" placeholder="nama@email.com" class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-white">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-mono font-bold text-slate-300 mb-1">Paket Layanan</label>
                        <select name="package_id" class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-white">
                            <option value="">Pilih Paket</option>
                            @foreach($packages as $pkg)
                                <option value="{{ $pkg->id }}">{{ $pkg->name }} ({{ $pkg->speed }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-mono font-bold text-slate-300 mb-1">IP Address</label>
                        <input type="text" name="ip_address" value="10.20.{{ rand(10, 200) }}.{{ rand(10, 250) }}" class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-white font-mono">
                    </div>
                </div>

                <div>
                    <label class="block font-mono font-bold text-slate-300 mb-1">Alamat Pemasangan</label>
                    <textarea name="address" rows="2" placeholder="Alamat lengkap..." class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-white"></textarea>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block font-mono font-bold text-slate-300 mb-1">Tarif Bulanan</label>
                        <input type="number" name="billing_amount" value="250000" class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-white font-mono">
                    </div>
                    <div>
                        <label class="block font-mono font-bold text-slate-300 mb-1">Jatuh Tempo (Tgl)</label>
                        <input type="number" name="due_date" value="20" min="1" max="31" class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-white font-mono">
                    </div>
                    <div>
                        <label class="block font-mono font-bold text-slate-300 mb-1">Status Langganan</label>
                        <select name="status" class="w-full px-3 py-2 rounded-xl bg-white/[0.06] border border-white/10 text-white">
                            <option value="active">Active</option>
                            <option value="isolated">Isolated</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="billing_status" value="paid">

                <div class="pt-3 border-t border-white/10 flex justify-end gap-2">
                    <button type="button" @click="createModalOpen = false" class="px-4 py-2 rounded-xl bg-white/10 text-slate-300 font-semibold">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#38bdf8] hover:bg-white text-[#050d1a] font-bold font-heading">Simpan Pelanggan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
