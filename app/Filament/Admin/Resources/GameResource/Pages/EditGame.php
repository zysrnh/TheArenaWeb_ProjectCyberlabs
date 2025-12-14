<?php

namespace App\Filament\Admin\Resources\GameResource\Pages;

use App\Filament\Admin\Resources\GameResource;
use App\Models\PlayerStat;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGame extends EditRecord
{
    protected static string $resource = GameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Mutate data SEBELUM mengisi form
     * Convert quarters dari JSON ke format input
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Ambil quarters data dari JSON
        $quarters = $this->record->quarters ?? ['team1' => [0,0,0,0], 'team2' => [0,0,0,0]];
        
        // Convert array ke string comma-separated
        $data['quarters_team1'] = implode(',', $quarters['team1'] ?? [0,0,0,0]);
        $data['quarters_team2'] = implode(',', $quarters['team2'] ?? [0,0,0,0]);

        // Load box score data dari player_stats table
        $boxScoreTeam1 = $this->record->playerStats()
            ->where('team_id', $this->record->team1_id)
            ->with('player')
            ->get()
            ->map(function ($stat) {
                return [
                    'player_id' => $stat->player_id,
                    'minutes' => $stat->minutes,
                    'points' => $stat->points,
                    'assists' => $stat->assists,
                    'rebounds' => $stat->rebounds,
                    'is_mvp' => $stat->is_mvp,
                ];
            })
            ->toArray();

        $boxScoreTeam2 = $this->record->playerStats()
            ->where('team_id', $this->record->team2_id)
            ->with('player')
            ->get()
            ->map(function ($stat) {
                return [
                    'player_id' => $stat->player_id,
                    'minutes' => $stat->minutes,
                    'points' => $stat->points,
                    'assists' => $stat->assists,
                    'rebounds' => $stat->rebounds,
                    'is_mvp' => $stat->is_mvp,
                ];
            })
            ->toArray();

        $data['box_score_team1'] = $boxScoreTeam1;
        $data['box_score_team2'] = $boxScoreTeam2;

        return $data;
    }

    /**
     * Mutate data SEBELUM save
     * Convert quarters string ke JSON format
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Convert quarters string ke array
        if (isset($data['quarters_team1']) && isset($data['quarters_team2'])) {
            $team1Quarters = array_map('intval', explode(',', $data['quarters_team1']));
            $team2Quarters = array_map('intval', explode(',', $data['quarters_team2']));
            
            $data['quarters'] = [
                'team1' => $team1Quarters,
                'team2' => $team2Quarters,
            ];
        }

        // Remove temporary fields
        unset($data['quarters_team1']);
        unset($data['quarters_team2']);
        unset($data['box_score_team1']);
        unset($data['box_score_team2']);

        return $data;
    }

    /**
     * Handle after save
     * Save player stats ke player_stats table
     */
    protected function afterSave(): void
    {
        $data = $this->form->getState();

        // Save Box Score Team 1
        if (isset($data['box_score_team1']) && !empty($data['box_score_team1'])) {
            // Hapus stats lama untuk team1
            PlayerStat::where('game_id', $this->record->id)
                ->where('team_id', $this->record->team1_id)
                ->delete();

            // Insert stats baru
            foreach ($data['box_score_team1'] as $stat) {
                if (isset($stat['player_id'])) {
                    PlayerStat::create([
                        'game_id' => $this->record->id,
                        'player_id' => $stat['player_id'],
                        'team_id' => $this->record->team1_id,
                        'minutes' => $stat['minutes'] ?? 0,
                        'points' => $stat['points'] ?? 0,
                        'assists' => $stat['assists'] ?? 0,
                        'rebounds' => $stat['rebounds'] ?? 0,
                        'is_mvp' => $stat['is_mvp'] ?? false,
                    ]);
                }
            }
        }

        // Save Box Score Team 2
        if (isset($data['box_score_team2']) && !empty($data['box_score_team2'])) {
            // Hapus stats lama untuk team2
            PlayerStat::where('game_id', $this->record->id)
                ->where('team_id', $this->record->team2_id)
                ->delete();

            // Insert stats baru
            foreach ($data['box_score_team2'] as $stat) {
                if (isset($stat['player_id'])) {
                    PlayerStat::create([
                        'game_id' => $this->record->id,
                        'player_id' => $stat['player_id'],
                        'team_id' => $this->record->team2_id,
                        'minutes' => $stat['minutes'] ?? 0,
                        'points' => $stat['points'] ?? 0,
                        'assists' => $stat['assists'] ?? 0,
                        'rebounds' => $stat['rebounds'] ?? 0,
                        'is_mvp' => $stat['is_mvp'] ?? false,
                    ]);
                }
            }
        }
    }

    /**
     * Redirect setelah save
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Success notification
     */
    protected function getSavedNotificationTitle(): ?string
    {
        return $this->record->score 
            ? 'Match results updated successfully!' 
            : 'Match schedule updated successfully!';
    }
}