<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('category_name'); // U-16, U-18, U-22, Senior, dll
            $table->string('age_group')->nullable(); // "Under 16", "Under 22", dll
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Pastikan tidak ada duplikat kategori dalam 1 tim
            $table->unique(['team_id', 'category_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_categories');
    }
};