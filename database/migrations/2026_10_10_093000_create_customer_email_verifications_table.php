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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('customer_email_verifications');
    }
};
