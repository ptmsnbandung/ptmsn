<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerEmailVerification extends Model
{
    protected $connection = 'mysql';
    protected $table = 'customer_email_verifications';

    protected $fillable = [
        'nomor_internet',
        'email',
        'verified_at',
        'is_skipped',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'is_skipped' => 'boolean',
    ];
}
