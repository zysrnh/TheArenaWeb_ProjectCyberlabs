<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_notifs', function (Blueprint $table) {
            // Monthly Package Benefits
            $table->string('monthly_frequency')->default('4x pertemuan')->after('monthly_discount_percent');
            $table->integer('monthly_loyalty_points')->default(500)->after('monthly_frequency');
            $table->string('monthly_note')->nullable()->after('monthly_loyalty_points');
            
            // Weekly Package Benefits
            $table->integer('weekly_loyalty_points')->default(100)->after('weekly_price');
            $table->string('weekly_note')->default('Dompet digital H+1')->after('weekly_loyalty_points');
            
            // General Benefits
            $table->text('benefits_list')->nullable()->after('weekly_note'); // JSON array
            $table->string('participant_count')->default('25+')->after('benefits_list');
            $table->string('level_tagline')->default('Semua Level Boleh Ikut — dari Pemula Sampai Pro')->after('participant_count');
        });
    }

    public function down(): void
    {
        Schema::table('event_notifs', function (Blueprint $table) {
            $table->dropColumn([
                'monthly_frequency',
                'monthly_loyalty_points',
                'monthly_note',
                'weekly_loyalty_points',
                'weekly_note',
                'benefits_list',
                'participant_count',
                'level_tagline',
            ]);
        });
    }
};