<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('bill_no')->nullable()->after('status');
            $table->string('payment_method')->nullable()->after('bill_no');
            $table->string('payment_status')->default('pending')->after('payment_method');
            $table->timestamp('paid_at')->nullable()->after('payment_status');
            
            // Index untuk performa
            $table->index('bill_no');
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['bill_no']);
            $table->dropIndex(['payment_status']);
            $table->dropColumn(['bill_no', 'payment_method', 'payment_status', 'paid_at']);
        });
    }
};