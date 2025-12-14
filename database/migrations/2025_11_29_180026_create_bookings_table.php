<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('venue_id')->default(1);
            $table->date('booking_date');
            $table->string('venue_type');
            $table->json('time_slots');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->boolean('is_paid')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['booking_date', 'venue_type']);
            $table->index('status');
            $table->index('is_paid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};