<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'period',
        'package_name',
        'amount',
        'tax_amount',
        'total_amount',
        'status',
        'due_date',
        'paid_at',
        'payment_method',
        'midtrans_order_id',
        'midtrans_snap_token',
        'midtrans_payload',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'amount' => 'integer',
        'tax_amount' => 'integer',
        'total_amount' => 'integer',
    ];

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getFormattedTaxAttribute(): string
    {
        return 'Rp ' . number_format($this->tax_amount, 0, ',', '.');
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'paid' => 'LUNAS',
            'unpaid' => 'BELUM DIBAYAR',
            'pending' => 'MENUNGGU PEMBAYARAN',
            'expired' => 'KADALUWARSA',
            default => strtoupper($this->status),
        };
    }

    public function getStatusBadgeClassesAttribute(): string
    {
        return match ($this->status) {
            'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'unpaid' => 'bg-rose-50 text-rose-700 border-rose-200',
            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
            'expired' => 'bg-slate-100 text-slate-600 border-slate-300',
            default => 'bg-slate-100 text-slate-600 border-slate-200',
        };
    }
}
