<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // ✅ SEED DEFAULT DATA (6 Fasilitas)
        $now = now();
        
        DB::table('facilities')->insert([
            [
                'name' => 'Cafe & Resto',
                'image_url' => null,
                'description' => 'Tempat bersantai dengan menu makanan dan minuman lengkap. Nikmati hidangan lezat sambil menonton pertandingan basket.',
                'is_active' => true,
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Jual Makanan Ringan',
                'image_url' => null,
                'description' => 'Berbagai pilihan snack dan makanan ringan untuk menemani permainan Anda. Tersedia berbagai jenis camilan favorit.',
                'is_active' => true,
                'order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Jual Minuman',
                'image_url' => null,
                'description' => 'Minuman segar dan dingin untuk melepas dahaga. Dari air mineral hingga minuman berenergi, semua tersedia di sini.',
                'is_active' => true,
                'order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Parkir Motor',
                'image_url' => null,
                'description' => 'Area parkir motor yang luas dan aman dengan sistem keamanan 24 jam. Gratis untuk semua pengunjung.',
                'is_active' => true,
                'order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Parkir Mobil',
                'image_url' => null,
                'description' => 'Tempat parkir mobil yang nyaman dan terjaga dengan kapasitas hingga 50 mobil. Dilengkapi dengan petugas parkir profesional.',
                'is_active' => true,
                'order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Toilet',
                'image_url' => null,
                'description' => 'Fasilitas toilet bersih dan terawat dengan standar kebersihan tinggi. Tersedia toilet pria, wanita, dan difabel.',
                'is_active' => true,
                'order' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};