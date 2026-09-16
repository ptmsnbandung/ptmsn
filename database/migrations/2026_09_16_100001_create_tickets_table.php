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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique(); // e.g. TKT-20260916-001
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('category'); // internet_mati, los_merah, koneksi_lambat, perangkat_rusak, billing, lainnya
            $table->string('subject');
            $table->text('description');
            $table->string('photo_path')->nullable();
            $table->string('status')->default('open'); // open, in_progress, resolved, closed
            $table->string('priority')->default('medium'); // low, medium, high, urgent
            $table->string('technician_name')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
