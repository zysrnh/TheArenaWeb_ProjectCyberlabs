<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_matches', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('team_home')->nullable();
            $table->string('team_away')->nullable();
            $table->string('category'); // Junior 3x3 Girls, Junior 3x3 Boys, etc
            $table->string('venue');
            $table->string('court');
            $table->string('time'); // Format: HH:MM WIB
            $table->date('match_date');
            $table->enum('status', ['scheduled', 'live', 'ended'])->default('scheduled');
            $table->string('thumbnail')->nullable(); // Path untuk gambar thumbnail
            $table->string('stream_url')->nullable(); // URL streaming (YouTube, dll)
            $table->enum('series', ['regular', 'playoff', 'final'])->default('regular');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_matches');
    }
};