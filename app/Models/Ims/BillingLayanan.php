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
        return 'Rp ' . number_format($this->payable_amount, 0, ',', '.');
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format((float) ($this->total_layanan ?: 0), 0, ',', '.');
    }

    public function getProrateInfoAttribute(): array
    {
        $customer = $this->customer;
        $baseAmount = (float) ($this->total_layanan ?: ($customer?->billing_amount ?? 250000));

        // Cek apakah invoice ini adalah tagihan bulan berjalan saat ini
        $now = Carbon::now();
        $isCurrentMonthInvoice = ((int)$this->bulan_tagihan === (int)$now->format('m') && (int)$this->tahun_tagihan === (int)$now->format('Y'));

        // Prorate HANYA berlaku untuk tagihan bulan berjalan jika pelanggan suspend. 
        // Tagihan masa lalu (tunggakan lama seperti Apr 2026 atau May 2026) adalah tunggakan penuh (100% normal).
        if ($customer && $isCurrentMonthInvoice) {
            return $customer->calculateProrate($baseAmount);
        }

        return [
            'is_prorate' => false,
            'base_amount' => $baseAmount,
            'final_amount' => $baseAmount,
            'discount' => 0,
            'days_active' => 30,
            'days_suspended' => 0,
            'total_days' => 30,
            'percentage' => 100,
            'formatted_base' => 'Rp ' . number_format($baseAmount, 0, ',', '.'),
            'formatted_discount' => 'Rp 0',
            'formatted_final' => 'Rp ' . number_format($baseAmount, 0, ',', '.'),
        ];
    }

    public function getPayableAmountAttribute(): float
    {
        if ($this->is_paid) {
            return (float) ($this->amount_paid ?: ($this->total_layanan ?: 0));
        }

        $prorate = $this->prorate_info;
        if (!empty($prorate['is_prorate'])) {
            return (float) $prorate['final_amount'];
        }

        return (float) ($this->total_layanan ?: 250000);
    }

    public function getFormattedPayableAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->payable_amount, 0, ',', '.');
    }

    public function getIsPaidAttribute(): bool
    {
        return trim((string) $this->status_bill_lay) === '15';
    }

    public function getStatusAttribute(): string
    {
        return $this->is_paid ? 'paid' : 'unpaid';
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
