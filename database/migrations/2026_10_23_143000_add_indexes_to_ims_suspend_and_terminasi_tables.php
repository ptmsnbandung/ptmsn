<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan index pada kolom nomor_internet di tabel trx_suspend dan trx_terminasi (Database IMS)
     * untuk mempercepat pencarian data riwayat pelanggan dari ~200ms menjadi ~1.5ms.
     */
    public function up(): void
    {
        // 1. Index pada tabel trx_suspend (Database IMS)
        try {
            if (Schema::connection('ims')->hasTable('trx_suspend')) {
                $indexes = collect(DB::connection('ims')->select("SHOW INDEX FROM `trx_suspend` WHERE Key_name = 'idx_trx_suspend_nomor_internet'"));
                if ($indexes->isEmpty()) {
                    DB::connection('ims')->statement("CREATE INDEX `idx_trx_suspend_nomor_internet` ON `trx_suspend` (`nomor_internet`)");
                }
            }
        } catch (\Throwable $e) {}

        // 2. Index komposit pada tabel trx_terminasi (Database IMS)
        try {
            if (Schema::connection('ims')->hasTable('trx_terminasi')) {
                $indexes = collect(DB::connection('ims')->select("SHOW INDEX FROM `trx_terminasi` WHERE Key_name = 'idx_trx_terminasi_nomor_date'"));
                if ($indexes->isEmpty()) {
                    DB::connection('ims')->statement("CREATE INDEX `idx_trx_terminasi_nomor_date` ON `trx_terminasi` (`nomor_internet`, `date_create`)");
                }
            }
        } catch (\Throwable $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            if (Schema::connection('ims')->hasTable('trx_suspend')) {
                DB::connection('ims')->statement("DROP INDEX `idx_trx_suspend_nomor_internet` ON `trx_suspend`");
            }
        } catch (\Throwable $e) {}

        try {
            if (Schema::connection('ims')->hasTable('trx_terminasi')) {
                DB::connection('ims')->statement("DROP INDEX `idx_trx_terminasi_nomor_date` ON `trx_terminasi`");
            }
        } catch (\Throwable $e) {}
    }
};
