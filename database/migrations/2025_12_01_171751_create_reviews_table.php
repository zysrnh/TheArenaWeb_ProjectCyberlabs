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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->integer('rating')->comment('Rating 1-5 bintang');
            $table->text('comment')->comment('Komentar ulasan pelanggan');
            $table->timestamps();
            
            // Index untuk query lebih cepat
            $table->index('client_id');
            $table->index('booking_id');
            
            // Pastikan 1 booking hanya bisa direview 1x oleh client yang sama
            $table->unique(['client_id', 'booking_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};