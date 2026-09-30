<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambahkan kolom is_login ke tabel customers di database default (mysql)
        if (Schema::connection('mysql')->hasTable('customers') && !Schema::connection('mysql')->hasColumn('customers', 'is_login')) {
            Schema::connection('mysql')->table('customers', function (Blueprint $table) {
                $table->tinyInteger('is_login')->default(0)->after('billing_status')->comment('0 = Belum pernah login/onboarding, 1 = Sudah pernah login');
            });
        }

        // 2. Tambahkan kolom is_login ke tabel trx_batchjob_register di database IMS jika ada
        try {
            if (Schema::connection('ims')->hasTable('trx_batchjob_register') && !Schema::connection('ims')->hasColumn('trx_batchjob_register', 'is_login')) {
                Schema::connection('ims')->table('trx_batchjob_register', function (Blueprint $table) {
                    $table->tinyInteger('is_login')->default(0)->comment('0 = Belum pernah login/onboarding, 1 = Sudah pernah login');
                });
            }
        } catch (\Throwable $e) {
            // Abaikan jika database IMS terpisah / read-only
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection('mysql')->hasTable('customers') && Schema::connection('mysql')->hasColumn('customers', 'is_login')) {
            Schema::connection('mysql')->table('customers', function (Blueprint $table) {
                $table->dropColumn('is_login');
            });
        }

        try {
            if (Schema::connection('ims')->hasTable('trx_batchjob_register') && Schema::connection('ims')->hasColumn('trx_batchjob_register', 'is_login')) {
                Schema::connection('ims')->table('trx_batchjob_register', function (Blueprint $table) {
                    $table->dropColumn('is_login');
                });
            }
        } catch (\Throwable $e) {
            //
        }
    }
};
