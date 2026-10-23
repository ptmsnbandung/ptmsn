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
        if (str_starts_with($file, 'http://') || str_starts_with($file, 'https://')) {
            return str_replace(
                ['https://www.ptmsn.co.id', 'https://ptmsn.co.id', 'http://www.ptmsn.co.id', 'http://ptmsn.co.id'],
                'https://portal.ptmsn.co.id',
                $file
            );
        }
        $portalDomain = rtrim(config('company.portal_url', env('PORTAL_URL', 'https://portal.ptmsn.co.id')), '/');
        return $portalDomain . '/' . ltrim($file, '/');
    }
}
