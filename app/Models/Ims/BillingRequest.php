<?php

namespace App\Models\Ims;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BillingRequest extends Model
{
    protected $connection = 'ims';
    protected $table = 'trx_billing_request';
    protected $guarded = [];

    /**
     * Relasi ke data pelanggan
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'nomor_internet', 'nomor_internet');
    }

    public function getTiketAttribute()
    {
        return 'REQ-INV-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }

    public function getTicketNumberAttribute()
    {
        return $this->tiket;
    }

    public function getKatTiketAttribute()
    {
        return '18';
    }

    public function getCategoryLabelAttribute(): string
    {
        return 'Request Tagihan';
    }

    public function getSubjectAttribute()
    {
        return "Permintaan Tagihan / Invoice — Periode " . ($this->periode_tagihan ?: ($this->bulan_tagihan . '/' . $this->tahun_tagihan));
    }

    public function getDescriptionAttribute()
    {
        return $this->catatan_pelanggan ?: "Permintaan penerbitan invoice periode {$this->periode_tagihan} untuk layanan {$this->layanan} (Rp " . number_format((float)$this->nominal, 0, ',', '.') . ")";
    }

    public function getStatusAttribute($value)
    {
        return match ($this->status_request) {
            'pending' => '11',
            'approved' => '13',
            'rejected' => '14',
            default => (string) $this->status_request,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_request) {
            'pending' => 'Menunggu Verifikasi Finance',
            'approved' => 'Disetujui / Invoice Terbit',
            'rejected' => 'Permintaan Ditolak',
            default => ucfirst((string) $this->status_request),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status_request) {
            'approved' => 'bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-xs',
            'rejected' => 'bg-rose-50 text-rose-700 border border-rose-200 shadow-xs',
            default => 'bg-amber-50 text-amber-700 border border-amber-200 shadow-xs',
        };
    }

    public function getTechnicianNameAttribute()
    {
        return $this->approved_by ?: ($this->rejected_by ?: 'Tim Finance & Billing PT MSN');
    }

    public function getResolutionNotesAttribute()
    {
        if ($this->status_request === 'approved') {
            return $this->kode_billing_layanan 
                ? "Tagihan telah diterbitkan dengan Kode Invoice #{$this->kode_billing_layanan}. Anda dapat melihat dan membayar tagihan pada menu Tagihan."
                : "Permintaan penerbitan tagihan telah disetujui oleh tim Finance PT MSN.";
        } elseif ($this->status_request === 'rejected') {
            return $this->rejection_note ?: 'Permintaan tagihan belum dapat disetujui oleh tim Finance.';
        }
        return null;
    }

    public function getSolusiAttribute()
    {
        return $this->resolution_notes;
    }

    public function getPenangananAttribute()
    {
        return null;
    }

    public function getResolvedAtAttribute()
    {
        return $this->approved_at ? Carbon::parse($this->approved_at) : ($this->rejected_at ? Carbon::parse($this->rejected_at) : null);
    }
}
