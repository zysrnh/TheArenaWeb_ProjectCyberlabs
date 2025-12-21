<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Hapus kolom rating lama jika perlu, atau biarkan untuk compatibility
            // $table->dropColumn('rating');
            
            // Tambah 3 rating terpisah
            $table->unsignedTinyInteger('rating_facilities')->default(5)->after('rating'); // Rating fasilitas
            $table->unsignedTinyInteger('rating_hospitality')->default(5)->after('rating_facilities'); // Rating keramahan
            $table->unsignedTinyInteger('rating_cleanliness')->default(5)->after('rating_hospitality'); // Rating kebersihan
        });
    }

    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['rating_facilities', 'rating_hospitality', 'rating_cleanliness']);
        });
    }
};