<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'customer_id',
        'name',
        'phone',
        'email',
        'password',
        'address',
        'city',
        'district',
        'package_id',
        'ip_address',
        'status',
        'billing_amount',
        'due_date',
        'billing_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'billing_amount' => 'decimal:2',
        'due_date' => 'integer',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke paket internet pelanggan
     */
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    /**
     * Relasi ke laporan gangguan / tiket
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'customer_id')->latest();
    }
}
