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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->unique(); // e.g. MSN-2026-001
            $table->string('name');
            $table->string('phone')->unique(); // Nomor WhatsApp/HP untuk login
            $table->string('email')->nullable();
            $table->string('password'); // Hashed PIN/Password
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->string('ip_address')->nullable(); // e.g. 10.20.100.45
            $table->string('status')->default('active'); // active, isolated, suspended
            $table->decimal('billing_amount', 12, 2)->default(0);
            $table->integer('due_date')->default(20); // Tanggal 20 setiap bulan
            $table->string('billing_status')->default('paid'); // paid, unpaid, overdue
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
