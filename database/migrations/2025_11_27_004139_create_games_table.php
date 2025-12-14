<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('league');
            $table->date('date');
            $table->time('time');
            $table->string('venue')->nullable();
            $table->foreignId('team1_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('team2_id')->constrained('teams')->onDelete('cascade');
            $table->string('score')->nullable();
            $table->enum('status', ['upcoming', 'live', 'finished'])->default('upcoming');
            $table->json('quarters')->nullable();
            $table->json('stats')->nullable();
            $table->string('year');
            $table->string('series')->default('Regular Season');
            $table->string('region')->nullable();
            
            // TAMBAHKAN INI - Quarter scores per team
            $table->string('quarters_team1')->nullable();
            $table->string('quarters_team2')->nullable();
            
            // TAMBAHKAN INI - Team Statistics
            $table->string('stat_fg_team1')->nullable(); // Field Goals
            $table->string('stat_fg_team2')->nullable();
            $table->string('stat_2pt_team1')->nullable(); // 2 Points
            $table->string('stat_2pt_team2')->nullable();
            $table->string('stat_3pt_team1')->nullable(); // 3 Points
            $table->string('stat_3pt_team2')->nullable();
            $table->string('stat_ft_team1')->nullable(); // Free Throws
            $table->string('stat_ft_team2')->nullable();
            $table->string('stat_reb_team1')->nullable(); // Rebounds
            $table->string('stat_reb_team2')->nullable();
            $table->string('stat_ast_team1')->nullable(); // Assists
            $table->string('stat_ast_team2')->nullable();
            $table->string('stat_stl_team1')->nullable(); // Steals
            $table->string('stat_stl_team2')->nullable();
            $table->string('stat_blk_team1')->nullable(); // Blocks
            $table->string('stat_blk_team2')->nullable();
            $table->string('stat_to_team1')->nullable(); // Turnovers
            $table->string('stat_to_team2')->nullable();
            $table->string('stat_foul_team1')->nullable(); // Fouls
            $table->string('stat_foul_team2')->nullable();
            $table->string('stat_pot_team1')->nullable(); // Points Off Turnover
            $table->string('stat_pot_team2')->nullable();
            
            // TAMBAHKAN INI - Box Score JSON
            $table->json('box_score_team1')->nullable();
            $table->json('box_score_team2')->nullable();
            
            $table->timestamps();
            
            $table->index('date');
            $table->index('status');
            $table->index('year');
            $table->index(['date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};