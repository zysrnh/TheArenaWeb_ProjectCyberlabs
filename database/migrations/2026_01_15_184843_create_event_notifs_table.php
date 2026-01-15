<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_notifs', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul event
            $table->text('description'); // Deskripsi event
            $table->string('image')->nullable(); // Banner image untuk popup
            
            // Event Details
            $table->date('event_date'); // Tanggal event
            $table->time('event_time')->nullable(); // Waktu event
            $table->string('location')->nullable(); // Lokasi event
            
            // Pricing Options (untuk layout dengan paket)
            $table->decimal('monthly_original_price', 10, 0)->nullable(); // Harga asli bulanan
            $table->decimal('monthly_price', 10, 0)->nullable(); // Harga diskon bulanan
            $table->integer('monthly_discount_percent')->nullable(); // Persentase diskon
            $table->decimal('weekly_price', 10, 0)->nullable(); // Harga mingguan
            
            // WhatsApp Integration
            $table->string('whatsapp_number'); // Nomor WA untuk pendaftaran
            $table->text('whatsapp_message')->nullable(); // Template pesan WA
            
            // Status
            $table->boolean('is_active')->default(false); // Hanya 1 yang bisa aktif
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_notifs');
    }
};