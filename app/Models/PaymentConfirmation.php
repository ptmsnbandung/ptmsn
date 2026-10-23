<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentConfirmation extends Model
{
    protected $fillable = [
        'customer_id',
        'kode_billing_layanan',
        'customer_name',
        'destination_bank',
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
        $file = (string) $this->proof_file;
        if (str_starts_with($file, 'http://') || str_starts_with($file, 'https://') || str_starts_with($file, 'data:')) {
            return $file;
        }
        if (str_contains($file, 'proof_')) {
            return 'https://ims-v2.ptmsn.co.id/' . ltrim($file, '/');
        }
        $portalDomain = rtrim(config('company.portal_url', env('PORTAL_URL', 'https://portal.ptmsn.co.id')), '/');
        return $portalDomain . '/' . ltrim($file, '/');
    }
}
