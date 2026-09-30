<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentConfirmation extends Model
{
    protected $fillable = [
        'customer_id',
        'kode_billing_layanan',
        'customer_name',
        'bank_destination',
        'bank_sender',
        'sender_name',
        'transfer_amount',
        'transfer_date',
        'proof_file',
        'notes',
        'status',
        'admin_notes',
        'verified_at',
    ];

    protected $casts = [
        'transfer_date' => 'date',
        'verified_at' => 'datetime',
        'transfer_amount' => 'decimal:2',
    ];

    public function getProofUrlAttribute(): string
    {
        return asset($this->proof_file);
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->transfer_amount, 0, ',', '.');
    }
}
