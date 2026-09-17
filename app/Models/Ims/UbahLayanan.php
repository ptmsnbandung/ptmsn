<?php

namespace App\Models\Ims;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UbahLayanan extends Model
{
    protected $connection = 'ims';
    protected $table = 'trx_ubah_layanan';
    protected $primaryKey = 'kode_trx_ubah_layanan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'nomor_internet', 'nomor_internet');
    }

    public function bandwithLama()
    {
        return $this->belongsTo(Bandwith::class, 'kode_bandwith_lama', 'kode_bandwith');
    }

    public function bandwithBaru()
    {
        return $this->belongsTo(Bandwith::class, 'kode_bandwith_baru', 'kode_bandwith');
    }

    public function getIdAttribute()
    {
        return $this->kode_trx_ubah_layanan;
    }

    public function getTiketAttribute()
    {
        return $this->kode_trx_ubah_layanan;
    }

    public function getTicketNumberAttribute()
    {
        return $this->kode_trx_ubah_layanan;
    }

    public function getKatTiketAttribute()
    {
        return '17';
    }

    public function getCategoryLabelAttribute(): string
    {
        return 'Ubah Layanan';
    }

    public function getSubjectAttribute()
    {
        $bwName = null;
        if ($this->bandwithBaru && !empty($this->bandwithBaru->nominal_bandwith)) {
            $bwName = $this->bandwithBaru->nominal_bandwith . ' Mbps';
        }
        if (!$bwName && !empty($this->note_request)) {
            if (preg_match('/• Paket Baru(?: Tujuan)?\s*:\s*(.+)/i', $this->note_request, $m)) {
                $bwName = trim($m[1]);
            }
        }
        return "Pengajuan Ubah Layanan: " . ($bwName ?: 'Paket Pilihan');
    }

    public function getDescriptionAttribute()
    {
        return $this->note_request;
    }

    public function getStatusAttribute($value)
    {
        return $this->status_ubah_layanan;
    }

    public function getStatusLabelAttribute(): string
    {
        $st = (string) $this->status_ubah_layanan;
        if ($st === '13') {
            return 'Selesai';
        }
        if ($st === '12') {
            return 'Sedang Diproses';
        }
        if ($st === '14') {
            return 'Dibatalkan';
        }
        return 'Menunggu Verifikasi';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        $st = (string) $this->status_ubah_layanan;
        if ($st === '13') {
            return 'bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-xs';
        }
        if ($st === '12') {
            return 'bg-sky-50 text-sky-700 border border-sky-200 shadow-xs';
        }
        if ($st === '14') {
            return 'bg-rose-50 text-rose-700 border border-rose-200 shadow-xs';
        }
        return 'bg-amber-50 text-amber-700 border border-amber-200 shadow-xs';
    }

    public function getTechnicianNameAttribute()
    {
        return $this->user_update ?: ($this->note_closing ? 'Tim Layanan & NOC PT MSN' : null);
    }

    public function getResolutionNotesAttribute()
    {
        return $this->note_closing ?: $this->note_schedule;
    }

    public function getSolusiAttribute()
    {
        return $this->note_closing ?: null;
    }

    public function getPenangananAttribute()
    {
        return $this->note_schedule ?: null;
    }

    public function getHasFotoAttribute(): bool
    {
        return !empty($this->foto_ss) || !empty($this->doc_ubahlayanan);
    }

    public function getFotoSsUrlAttribute(): ?string
    {
        $file = $this->foto_ss ?: $this->doc_ubahlayanan;
        if (empty($file)) {
            return null;
        }

        if (str_starts_with($file, 'http://') || str_starts_with($file, 'https://')) {
            return $file;
        }

        // 1. Jika ada file lokal di project saat pengembangan
        if (file_exists(public_path('uploads/up_downgrade/' . $file))) {
            return asset('uploads/up_downgrade/' . $file);
        }
        if (file_exists(public_path('storage/' . $file))) {
            return asset('storage/' . $file);
        }

        // 2. URL utama dari subdomain IMS (https://ims.ptmsn.co.id/uploads/up_downgrade/{file})
        $baseUrl = config('company.ims_upload_url', env('IMS_UPLOAD_URL', 'https://ims.ptmsn.co.id/uploads/up_downgrade'));
        return rtrim($baseUrl, '/') . '/' . ltrim($file, '/');
    }

    public function getCreatedAtAttribute()
    {
        return !empty($this->date_create) ? Carbon::parse($this->date_create) : now();
    }

    public function getResolvedAtAttribute()
    {
        return !empty($this->date_closing) ? Carbon::parse($this->date_closing) : null;
    }
}
