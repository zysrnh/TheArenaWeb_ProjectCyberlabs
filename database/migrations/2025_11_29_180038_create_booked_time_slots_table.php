<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booked_time_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('time_slot');
            $table->string('venue_type');
            $table->timestamps();
            
            $table->unique(['date', 'time_slot', 'venue_type'], 'unique_booking_slot');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booked_time_slots');
    }
};