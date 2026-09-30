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
            $columnsToDrop = [];
            foreach (['bank_destination', 'bank_sender', 'sender_name', 'transfer_amount', 'transfer_date'] as $column) {
                if (Schema::hasColumn('payment_confirmations', $column)) {
                    $columnsToDrop[] = $column;
                }
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_confirmations', function (Blueprint $table) {
            $table->string('bank_destination')->nullable();
            $table->string('bank_sender')->nullable();
            $table->string('sender_name')->nullable();
            $table->decimal('transfer_amount', 12, 2)->default(0);
            $table->date('transfer_date')->nullable();
        });
    }
};
