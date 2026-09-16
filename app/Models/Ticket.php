<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'customer_id',
        'category',
        'subject',
        'description',
        'photo_path',
        'status',
        'priority',
        'technician_name',
        'resolution_notes',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Relasi ke pelanggan pemilik tiket
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Label kategori yang ramah dibaca
     */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'internet_mati' => 'Internet Mati Total',
            'los_merah' => 'Lampu Modem LOS Merah',
            'koneksi_lambat' => 'Koneksi Sangat Lambat',
            'perangkat_rusak' => 'Kerusakan Modem / Adaptor',
            'billing' => 'Kendala Tagihan / Pembayaran',
            default => 'Lainnya / Pertanyaan Umum',
        };
    }

    /**
     * Label status bahasa Indonesia
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'open' => 'Menunggu Verifikasi',
            'in_progress' => 'Sedang Ditangani',
            'resolved' => 'Selesai Ditangani',
            'closed' => 'Tiket Ditutup',
            default => ucfirst($this->status),
        };
    }

    /**
     * Warna badge status
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'open' => 'bg-amber-500/10 text-amber-400 border border-amber-500/30',
            'in_progress' => 'bg-sky-500/10 text-[#38bdf8] border border-sky-500/30',
            'resolved' => 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30',
            'closed' => 'bg-slate-500/10 text-slate-400 border border-slate-500/30',
            default => 'bg-slate-500/10 text-slate-300 border border-slate-500/30',
        };
    }
}
