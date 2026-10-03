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
        $connections = array_unique([config('database.default'), 'ims', 'mysql']);

        foreach ($connections as $conn) {
            try {
                if (!Schema::connection($conn)->hasTable('trx_billing_request')) {
                    Schema::connection($conn)->create('trx_billing_request', function (Blueprint $table) {
                        $table->id();
                        $table->string('nomor_internet', 100);
                        $table->string('nama_pelanggan', 255)->nullable();
                        $table->unsignedInteger('bulan_tagihan');
                        $table->unsignedInteger('tahun_tagihan');
                        $table->string('periode_tagihan', 50);
                        $table->string('layanan', 150)->nullable();
                        $table->decimal('nominal', 15, 2)->default(0.00);
                        $table->text('catatan_pelanggan')->nullable();
                        $table->enum('status_request', ['pending', 'approved', 'rejected'])->default('pending');
                        $table->string('kode_billing_layanan', 100)->nullable();
                        $table->string('approved_by', 150)->nullable();
                        $table->timestamp('approved_at')->nullable();
                        $table->string('rejected_by', 150)->nullable();
                        $table->timestamp('rejected_at')->nullable();
                        $table->text('rejection_note')->nullable();
                        $table->timestamps();

                        $table->index('status_request', 'idx_request_status');
                        $table->index('nomor_internet', 'idx_request_nomor_internet');
                        $table->index(['tahun_tagihan', 'bulan_tagihan'], 'idx_request_periode');
                    });
                }
            } catch (\Throwable $e) {
                // Ignore if connection not accessible
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $connections = array_unique([config('database.default'), 'ims', 'mysql']);
        foreach ($connections as $conn) {
            try {
                Schema::connection($conn)->dropIfExists('trx_billing_request');
            } catch (\Throwable $e) {
                //
            }
        }
    }
};
