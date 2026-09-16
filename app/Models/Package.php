<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'speed',
        'price',
        'period',
        'description',
        'features',
        'is_popular',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'integer',
        'sort_order' => 'integer',
    ];

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Harga paket jika berlangganan langsung 3 bulan (diskon 5%)
     */
    public function getPriceThreeMonthsDiscountAttribute(): int
    {
        $customMap = [
            'PAKET BASIC' => 356250,
            'PAKET HEMAT' => 470000,
            'PAKET KELUARGA' => 567000,
            'PAKET PREMIUM' => 712000,
            'UMKM BASIC' => 1137150,
            'UMKM PLUS' => 1992150,
            'BISNIS PRO' => 2847150,
            'BISNIS ENTERPRISE' => 3702150,
        ];

        $nameUpper = strtoupper(trim($this->name));
        if (isset($customMap[$nameUpper])) {
            return $customMap[$nameUpper];
        }

        return (int) round(($this->price * 3) * 0.95);
    }

    public function getFormattedPriceThreeMonthsAttribute(): string
    {
        return 'Rp ' . number_format($this->price_three_months_discount, 0, ',', '.');
    }

    /**
     * Rekomendasi pengguna / perangkat ideal
     */
    public function getIdealDevicesAttribute(): ?string
    {
        $map = [
            'PAKET BASIC' => '1 - 4 Perangkat',
            'PAKET HEMAT' => '3 - 6 Perangkat',
            'PAKET KELUARGA' => '5 - 8 Perangkat',
            'PAKET PREMIUM' => '8 - 10 Perangkat',
            'UMKM BASIC' => 'Operasional UMKM & Toko',
            'UMKM PLUS' => 'Kantor & Usaha Berkembang',
            'BISNIS PRO' => 'Perusahaan & High Traffic',
            'BISNIS ENTERPRISE' => 'Korporat & Instansi',
        ];

        return $map[strtoupper(trim($this->name))] ?? null;
    }
}
