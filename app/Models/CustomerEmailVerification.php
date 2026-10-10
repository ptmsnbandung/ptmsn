<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

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

    /**
     * Memastikan tabel customer_email_verifications ada di database.
     * Mencegah 500 error jika migration belum dijalankan di server production.
     */
    public static function ensureTableExists(): void
    {
        try {
            if (!Schema::connection('mysql')->hasTable('customer_email_verifications')) {
                Schema::connection('mysql')->create('customer_email_verifications', function (Blueprint $table) {
                    $table->id();
                    $table->string('nomor_internet', 50)->unique();
                    $table->string('email')->nullable();
                    $table->timestamp('verified_at')->nullable();
                    $table->boolean('is_skipped')->default(false);
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            Log::warning('Auto-create table customer_email_verifications failed: ' . $e->getMessage());
        }
    }
}
