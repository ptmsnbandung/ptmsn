<?php

namespace App\Models\Ims;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BillingLayanan extends Model
{
    /**
     * Database connection ke IMS v2
     */
    protected $connection = 'ims';

    /**
     * Tabel billing layanan bawaan IMS
     */
    protected $table = 'trx_billing_layanan';

    /**
     * Primary key nomor invoice / kode billing
     */
    protected $primaryKey = 'kode_billing_layanan';

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'payment_respond_post' => 'array',
        'payment_respond_process' => 'array',
        'payment_respond_paid' => 'array',
        'payment_publish' => 'datetime',
        'payment_paid' => 'datetime',
        'payment_process' => 'datetime',
        'expiry' => 'datetime',
        'date_create' => 'datetime',
        'date_update' => 'datetime',
    ];

    /**
     * Relasi ke Pelanggan di IMS
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'nomor_internet', 'nomor_internet');
    }

    /**
     * Relasi ke rincian komponen tagihan di IMS
     */
    public function details()
    {
        return $this->hasMany(BillingLayananDetail::class, 'kode_billing_layanan', 'kode_billing_layanan');
    }

    // --- ACCESSOR PORTAL COMPATIBILITY ---

    public function getInvoiceNumberAttribute(): string
    {
        return $this->kode_billing_layanan;
    }

    public function getPeriodAttribute(): string
    {
        if (!empty($this->periode_tagihan)) {
            return $this->periode_tagihan;
        }

        if (!empty($this->bulan_tagihan) && !empty($this->tahun_tagihan)) {
            $monthNum = (int) $this->bulan_tagihan;
            $monthName = Carbon::createFromDate(null, $monthNum, 1)->translatedFormat('F');
            return "{$monthName} {$this->tahun_tagihan}";
        }

        return Carbon::now()->translatedFormat('F Y');
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format((float) ($this->total_layanan ?: 0), 0, ',', '.');
    }

    public function getFormattedAmountAttribute(): string
    {
        return $this->formatted_total;
    }

    public function getIsPaidAttribute(): bool
    {
        return trim($this->status_bill_lay) === '15';
    }

    public function getStatusLabelAttribute(): string
    {
        return match (trim((string) $this->status_bill_lay)) {
            '15' => 'LUNAS',
            '14', '13' => 'MENUNGGU PEMBAYARAN',
            '18' => 'KADALUWARSA',
            '17' => 'DIBATALKAN',
            '11' => 'DRAFT',
            default => 'BELUM DIBAYAR',
        };
    }

    public function getStatusBadgeClassesAttribute(): string
    {
        return match (trim((string) $this->status_bill_lay)) {
            '15' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            '14', '13' => 'bg-rose-50 text-rose-700 border-rose-200',
            '18' => 'bg-slate-100 text-slate-600 border-slate-300',
            '17' => 'bg-slate-100 text-slate-600 border-slate-200',
            default => 'bg-amber-50 text-amber-700 border-amber-200',
        };
    }

    public function getDueDateAttribute(): ?Carbon
    {
        if ($this->expiry) {
            return $this->expiry;
        }

        if ($this->date_create) {
            return $this->date_create->copy()->setDay(20);
        }

        return Carbon::now()->setDay(20);
    }

    public function getPackageNameAttribute(): string
    {
        $speed = $this->nominal_bandwith ?: '25';
        return "Layanan Broadband {$speed} Mbps";
    }

    public function getSnapTokenAttribute(): ?string
    {
        if (is_array($this->payment_respond_post) && isset($this->payment_respond_post['token'])) {
            return $this->payment_respond_post['token'];
        }

        return null;
    }

    public function getRedirectUrlAttribute(): ?string
    {
        if (is_array($this->payment_respond_post) && isset($this->payment_respond_post['redirect_url'])) {
            return $this->payment_respond_post['redirect_url'];
        }

        return null;
    }
}
