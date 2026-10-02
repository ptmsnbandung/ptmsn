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
        Schema::table('payment_confirmations', function (Blueprint $table) {
            if (!Schema::hasColumn('payment_confirmations', 'destination_bank')) {
                $table->string('destination_bank')->nullable()->after('customer_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_confirmations', function (Blueprint $table) {
            if (Schema::hasColumn('payment_confirmations', 'destination_bank')) {
                $table->dropColumn('destination_bank');
            }
        });
    }
};
