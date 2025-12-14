<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Game;
use App\Models\Player;
use App\Models\PlayerStat;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MatchSeeder extends Seeder
{
    public function run(): void
    {
        // Create Teams
        $prawira = Team::create([
            'name' => 'Prawira Bandung',
            'logo' => '/images/Prawira.svg',
            'region' => 'Bandung',
            'city' => 'Bandung',
            'description' => 'Tim basket profesional dari Bandung',
            'is_active' => true,
        ]);

        $pelita = Team::create([
            'name' => 'Pelita Jaya Jakarta',
            'logo' => '/images/Pelita.svg',
            'region' => 'Jakarta',
            'city' => 'Jakarta',
            'description' => 'Tim basket profesional dari Jakarta',
            'is_active' => true,
        ]);

        $satria = Team::create([
            'name' => 'Satria Muda Jakarta',
            'logo' => '/images/Satria.svg',
            'region' => 'Jakarta',
            'city' => 'Jakarta',
            'description' => 'Tim basket profesional dari Jakarta',
            'is_active' => true,
        ]);

        $pacific = Team::create([
            'name' => 'Pacific Caesar Surabaya',
            'logo' => '/images/Pacific.svg',
            'region' => 'Surabaya',
            'city' => 'Surabaya',
            'description' => 'Tim basket profesional dari Surabaya',
            'is_active' => true,
        ]);

        // Create Players for Prawira
        $prawiraPlayers = [
            ['name' => 'Yudha Saputera', 'jersey_no' => '10', 'position' => 'PG', 'photo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=100'],
            ['name' => 'De Vaughn Lamar Washington', 'jersey_no' => '23', 'position' => 'SF', 'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100'],
            ['name' => 'Norbertas Giga', 'jersey_no' => '15', 'position' => 'C', 'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100'],
            ['name' => 'Muhammad Fhirdan Maulana Guntara', 'jersey_no' => '7', 'position' => 'SG', 'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100'],
            ['name' => 'Ahmad Rivaldi', 'jersey_no' => '32', 'position' => 'PF', 'photo' => 'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=100'],
        ];

        foreach ($prawiraPlayers as $playerData) {
            Player::create([
                'team_id' => $prawira->id,
                'name' => $playerData['name'],
                'jersey_no' => $playerData['jersey_no'],
                'position' => $playerData['position'],
                'photo' => $playerData['photo'],
                'is_active' => true,
            ]);
        }

        // Create Players for Pelita
        $pelitaPlayers = [
            ['name' => 'Bima Sakti Putra', 'jersey_no' => '11', 'position' => 'PG', 'photo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=100'],
            ['name' => 'Rizky Pradana', 'jersey_no' => '24', 'position' => 'SG', 'photo' => 'https://images.unsplash.com/photo-1527980965255-d3b416303d12?w=100'],
            ['name' => 'Dedi Kusnandar', 'jersey_no' => '33', 'position' => 'C', 'photo' => 'https://images.unsplash.com/photo-1463453091185-61582044d556?w=100'],
            ['name' => 'Arief Rahman', 'jersey_no' => '8', 'position' => 'SF', 'photo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=100'],
            ['name' => 'Andi Setiawan', 'jersey_no' => '21', 'position' => 'PF', 'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100'],
        ];

        foreach ($pelitaPlayers as $playerData) {
            Player::create([
                'team_id' => $pelita->id,
                'name' => $playerData['name'],
                'jersey_no' => $playerData['jersey_no'],
                'position' => $playerData['position'],
                'photo' => $playerData['photo'],
                'is_active' => true,
            ]);
        }

        // Create Players for Satria
        $satriaPlayers = [
            ['name' => 'Kevin Yohan', 'jersey_no' => '5', 'position' => 'PG', 'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100'],
            ['name' => 'Jamarr Andre Johnson', 'jersey_no' => '35', 'position' => 'SF', 'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100'],
            ['name' => 'Abraham Grahita', 'jersey_no' => '12', 'position' => 'C', 'photo' => 'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=100'],
        ];

        foreach ($satriaPlayers as $playerData) {
            Player::create([
                'team_id' => $satria->id,
                'name' => $playerData['name'],
                'jersey_no' => $playerData['jersey_no'],
                'position' => $playerData['position'],
                'photo' => $playerData['photo'],
                'is_active' => true,
            ]);
        }

        // Create Players for Pacific
        $pacificPlayers = [
            ['name' => 'Brandon Jawato', 'jersey_no' => '9', 'position' => 'PG', 'photo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=100'],
            ['name' => 'Kelvin Wenas', 'jersey_no' => '20', 'position' => 'SG', 'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100'],
            ['name' => 'Fikri Akbar', 'jersey_no' => '14', 'position' => 'C', 'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100'],
        ];

        foreach ($pacificPlayers as $playerData) {
            Player::create([
                'team_id' => $pacific->id,
                'name' => $playerData['name'],
                'jersey_no' => $playerData['jersey_no'],
                'position' => $playerData['position'],
                'photo' => $playerData['photo'],
                'is_active' => true,
            ]);
        }

        // Array of teams for variation
        $teams = [$prawira, $pelita, $satria, $pacific];
        $venues = ['GOR Pajajaran', 'GOR Sritex Arena', 'GOR Basket Senayan', 'DBL Arena'];
        $series = ['Regular Season', 'Playoff', 'Finals'];
        $times = ['14:00:00', '16:00:00', '18:00:00', '19:00:00', '20:00:00', '21:00:00'];

        // Create Matches untuk 2 minggu terakhir dan 2 minggu ke depan
        $matchSchedule = [];

        // MINGGU 2 LALU (-14 sampai -8 hari)
        for ($i = -14; $i <= -8; $i++) {
            $matchSchedule[] = [
                'date' => Carbon::now()->addDays($i),
                'status' => 'finished',
                'team1_id' => $teams[array_rand($teams)]->id,
                'team2_id' => $teams[array_rand($teams)]->id,
            ];
        }

        // MINGGU LALU (-7 sampai -1 hari)
        for ($i = -7; $i <= -1; $i++) {
            $matchSchedule[] = [
                'date' => Carbon::now()->addDays($i),
                'status' => 'finished',
                'team1_id' => $teams[array_rand($teams)]->id,
                'team2_id' => $teams[array_rand($teams)]->id,
            ];
        }

        // MINGGU INI (0 sampai 6 hari)
        // Hari ini - LIVE match
        $matchSchedule[] = [
            'date' => Carbon::now(),
            'status' => 'live',
            'team1_id' => $prawira->id,
            'team2_id' => $pelita->id,
        ];

        // Hari ini - match lain
        $matchSchedule[] = [
            'date' => Carbon::now(),
            'status' => 'upcoming',
            'team1_id' => $satria->id,
            'team2_id' => $pacific->id,
        ];

        // Besok sampai akhir minggu ini
        for ($i = 1; $i <= 6; $i++) {
            // 2 match per hari
            $matchSchedule[] = [
                'date' => Carbon::now()->addDays($i),
                'status' => 'upcoming',
                'team1_id' => $teams[array_rand($teams)]->id,
                'team2_id' => $teams[array_rand($teams)]->id,
            ];
            
            $matchSchedule[] = [
                'date' => Carbon::now()->addDays($i),
                'status' => 'upcoming',
                'team1_id' => $teams[array_rand($teams)]->id,
                'team2_id' => $teams[array_rand($teams)]->id,
            ];
        }

        // MINGGU DEPAN (7 sampai 13 hari)
        for ($i = 7; $i <= 13; $i++) {
            $matchSchedule[] = [
                'date' => Carbon::now()->addDays($i),
                'status' => 'upcoming',
                'team1_id' => $teams[array_rand($teams)]->id,
                'team2_id' => $teams[array_rand($teams)]->id,
            ];
        }

        // MINGGU 2 DEPAN (14 sampai 20 hari)
        for ($i = 14; $i <= 20; $i++) {
            $matchSchedule[] = [
                'date' => Carbon::now()->addDays($i),
                'status' => 'upcoming',
                'team1_id' => $teams[array_rand($teams)]->id,
                'team2_id' => $teams[array_rand($teams)]->id,
            ];
        }

        // Create all matches
        foreach ($matchSchedule as $index => $matchData) {
            // Ensure team1 and team2 are different
            $team1_id = $matchData['team1_id'];
            $team2_id = $matchData['team2_id'];
            
            while ($team1_id === $team2_id) {
                $team2_id = $teams[array_rand($teams)]->id;
            }

            $team1 = Team::find($team1_id);
            $team2 = Team::find($team2_id);

            // Generate score for finished and live matches
            $score = null;
            $quarters = null;
            
            if ($matchData['status'] === 'finished' || $matchData['status'] === 'live') {
                $team1Score = rand(75, 110);
                $team2Score = rand(75, 110);
                $score = "{$team1Score} - {$team2Score}";
                
                // Generate quarters
                $q1_1 = rand(15, 30);
                $q2_1 = rand(15, 30);
                $q3_1 = rand(15, 30);
                $q4_1 = $team1Score - ($q1_1 + $q2_1 + $q3_1);
                
                $q1_2 = rand(15, 30);
                $q2_2 = rand(15, 30);
                $q3_2 = rand(15, 30);
                $q4_2 = $team2Score - ($q1_2 + $q2_2 + $q3_2);
                
                $quarters = [
                    'team1' => [$q1_1, $q2_1, $q3_1, $q4_1],
                    'team2' => [$q1_2, $q2_2, $q3_2, $q4_2]
                ];
            }

            $match = Game::create([
                'league' => 'Arena Seasons 2025',
                'date' => $matchData['date'],
                'time' => $times[array_rand($times)],
                'venue' => $venues[array_rand($venues)],
                'team1_id' => $team1_id,
                'team2_id' => $team2_id,
                'score' => $score,
                'status' => $matchData['status'],
                'quarters' => $quarters,
                'year' => $matchData['date']->year,
                'series' => $series[array_rand($series)],
                'region' => $team1->region,
                'stats' => [
                    ['category' => 'Field Goals', 'team1' => rand(35, 45) . '/' . rand(75, 85) . ' (' . rand(40, 55) . '%)', 'team2' => rand(35, 45) . '/' . rand(75, 85) . ' (' . rand(40, 55) . '%)'],
                    ['category' => '2 Points', 'team1' => rand(25, 35) . '/' . rand(45, 55) . ' (' . rand(50, 65) . '%)', 'team2' => rand(25, 35) . '/' . rand(45, 55) . ' (' . rand(50, 65) . '%)'],
                    ['category' => '3 Points', 'team1' => rand(8, 15) . '/' . rand(25, 35) . ' (' . rand(30, 40) . '%)', 'team2' => rand(8, 15) . '/' . rand(25, 35) . ' (' . rand(30, 40) . '%)'],
                    ['category' => 'Free Throws', 'team1' => rand(18, 25) . '/' . rand(23, 30) . ' (' . rand(75, 85) . '%)', 'team2' => rand(18, 25) . '/' . rand(23, 30) . ' (' . rand(75, 85) . '%)'],
                    ['category' => 'Rebounds', 'team1' => (string)rand(35, 45), 'team2' => (string)rand(35, 45)],
                    ['category' => 'Assists', 'team1' => (string)rand(18, 25), 'team2' => (string)rand(18, 25)],
                    ['category' => 'Steals', 'team1' => (string)rand(5, 10), 'team2' => (string)rand(5, 10)],
                    ['category' => 'Blocks', 'team1' => (string)rand(3, 7), 'team2' => (string)rand(3, 7)],
                ],
            ]);

            // Add Player Stats untuk finished matches (only first 3 for each team to save time)
            if ($matchData['status'] === 'finished') {
                $team1Players = Player::where('team_id', $team1_id)->take(3)->get();
                $team2Players = Player::where('team_id', $team2_id)->take(3)->get();

                foreach ($team1Players as $player) {
                    PlayerStat::create([
                        'game_id' => $match->id,
                        'team_id' => $team1_id,
                        'player_id' => $player->id,
                        'minutes' => rand(20, 35),
                        'points' => rand(10, 30),
                        'assists' => rand(2, 8),
                        'rebounds' => rand(3, 12),
                        'is_mvp' => false,
                    ]);
                }

                // Set one player as MVP
                if ($team1Players->count() > 0) {
                    $mvpStat = PlayerStat::where('game_id', $match->id)
                        ->where('team_id', $team1_id)
                        ->orderBy('points', 'desc')
                        ->first();
                    if ($mvpStat) {
                        $mvpStat->update(['is_mvp' => true]);
                    }
                }

                foreach ($team2Players as $player) {
                    PlayerStat::create([
                        'game_id' => $match->id,
                        'team_id' => $team2_id,
                        'player_id' => $player->id,
                        'minutes' => rand(20, 35),
                        'points' => rand(10, 30),
                        'assists' => rand(2, 8),
                        'rebounds' => rand(3, 12),
                        'is_mvp' => false,
                    ]);
                }
            }
        }

        $this->command->info('✅ Seeder completed successfully!');
        $this->command->info('📊 Created ' . count($matchSchedule) . ' matches');
        $this->command->info('📅 Date range: ' . Carbon::now()->subDays(14)->format('d M Y') . ' to ' . Carbon::now()->addDays(20)->format('d M Y'));
    }
}