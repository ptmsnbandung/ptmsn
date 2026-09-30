<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentConfirmation extends Model
{
    protected $fillable = [
        'customer_id',
        'kode_billing_layanan',
        'customer_name',
        'proof_file',
        'notes',
        'status',
        'admin_notes',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function getProofUrlAttribute(): string
    {
        return asset($this->proof_file);
    }
}
