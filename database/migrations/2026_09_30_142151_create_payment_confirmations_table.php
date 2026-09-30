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
        Schema::create('payment_confirmations', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->index();
            $table->string('kode_billing_layanan')->index();
            $table->string('customer_name')->nullable();
            $table->string('bank_destination')->default('BCA');
            $table->string('bank_sender')->nullable();
            $table->string('sender_name')->nullable();
            $table->decimal('transfer_amount', 12, 2)->default(0);
            $table->date('transfer_date')->nullable();
            $table->string('proof_file');
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('admin_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_confirmations');
    }
};
