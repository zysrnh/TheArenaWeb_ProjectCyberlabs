<div class="space-y-6">
    {{-- Header Match Info --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-700 dark:to-blue-900 rounded-lg p-6 text-white">
        <div class="text-center mb-4">
            <div class="text-sm font-medium opacity-90">{{ $record->league }}</div>
            <div class="text-xs opacity-75 mt-1">
                {{ $record->date->format('d M Y') }} • {{ $record->time?->format('H:i') }} WIB
                @if($record->venue)
                    • {{ $record->venue }}
                @endif
            </div>
            <div class="flex justify-center gap-2 mt-2">
                <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">
                    {{ $record->series }}
                </span>
                @if($record->region)
                    <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">
                        {{ $record->region }}
                    </span>
                @endif
            </div>
        </div>

        {{-- Score Display --}}
        <div class="flex items-center justify-between gap-6 mt-6">
            {{-- Team 1 --}}
            <div class="flex-1 text-center">
                <div class="mb-3">
                    @if($record->team1->logo)
                        <img src="{{ Storage::url($record->team1->logo) }}" 
                             alt="{{ $record->team1->name }}" 
                             class="w-24 h-24 mx-auto object-contain">
                    @else
                        <div class="w-24 h-24 mx-auto bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-3xl font-bold">{{ substr($record->team1->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
                <h3 class="text-xl font-bold">{{ $record->team1->name }}</h3>
                <p class="text-sm opacity-75">HOME</p>
            </div>

            {{-- Score --}}
            <div class="text-center px-6">
                @if($record->status === 'finished' && $record->score)
                    @php
                        $scores = explode(' - ', $record->score);
                        $team1Score = (int)($scores[0] ?? 0);
                        $team2Score = (int)($scores[1] ?? 0);
                    @endphp
                    <div class="flex items-center gap-4">
                        <div class="text-5xl font-bold {{ $team1Score > $team2Score ? 'text-yellow-300' : '' }}">
                            {{ $team1Score }}
                        </div>
                        <div class="text-2xl opacity-75">-</div>
                        <div class="text-5xl font-bold {{ $team2Score > $team1Score ? 'text-yellow-300' : '' }}">
                            {{ $team2Score }}
                        </div>
                    </div>
                    <div class="text-xs mt-2 opacity-75">FINAL SCORE</div>
                @elseif($record->status === 'live')
                    <div class="text-3xl font-bold animate-pulse">LIVE</div>
                    <div class="text-sm mt-1 opacity-75">Match in Progress</div>
                @else
                    <div class="text-xl opacity-75">VS</div>
                    <div class="text-xs mt-2">{{ $record->time?->format('H:i') }} WIB</div>
                @endif
            </div>

            {{-- Team 2 --}}
            <div class="flex-1 text-center">
                <div class="mb-3">
                    @if($record->team2->logo)
                        <img src="{{ Storage::url($record->team2->logo) }}" 
                             alt="{{ $record->team2->name }}" 
                             class="w-24 h-24 mx-auto object-contain">
                    @else
                        <div class="w-24 h-24 mx-auto bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-3xl font-bold">{{ substr($record->team2->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
                <h3 class="text-xl font-bold">{{ $record->team2->name }}</h3>
                <p class="text-sm opacity-75">AWAY</p>
            </div>
        </div>
    </div>

    {{-- Quarter by Quarter Scores --}}
    @if($record->status !== 'upcoming' && isset($record->quarters))
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white text-center">
                Quarter Scores
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                            <th class="text-left py-2 px-3 font-semibold text-gray-900 dark:text-white">Team</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white">Q1</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white">Q2</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white">Q3</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white">Q4</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white bg-blue-100 dark:bg-blue-900">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-2 px-3 text-gray-900 dark:text-white font-medium">{{ $record->team1->name }}</td>
                            <td class="text-center py-2 px-3 text-gray-700 dark:text-gray-300">{{ $record->quarters['team1'][0] ?? 0 }}</td>
                            <td class="text-center py-2 px-3 text-gray-700 dark:text-gray-300">{{ $record->quarters['team1'][1] ?? 0 }}</td>
                            <td class="text-center py-2 px-3 text-gray-700 dark:text-gray-300">{{ $record->quarters['team1'][2] ?? 0 }}</td>
                            <td class="text-center py-2 px-3 text-gray-700 dark:text-gray-300">{{ $record->quarters['team1'][3] ?? 0 }}</td>
                            <td class="text-center py-2 px-3 text-gray-900 dark:text-white font-bold bg-blue-50 dark:bg-blue-900/30">
                                {{ array_sum($record->quarters['team1'] ?? [0,0,0,0]) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 text-gray-900 dark:text-white font-medium">{{ $record->team2->name }}</td>
                            <td class="text-center py-2 px-3 text-gray-700 dark:text-gray-300">{{ $record->quarters['team2'][0] ?? 0 }}</td>
                            <td class="text-center py-2 px-3 text-gray-700 dark:text-gray-300">{{ $record->quarters['team2'][1] ?? 0 }}</td>
                            <td class="text-center py-2 px-3 text-gray-700 dark:text-gray-300">{{ $record->quarters['team2'][2] ?? 0 }}</td>
                            <td class="text-center py-2 px-3 text-gray-700 dark:text-gray-300">{{ $record->quarters['team2'][3] ?? 0 }}</td>
                            <td class="text-center py-2 px-3 text-gray-900 dark:text-white font-bold bg-blue-50 dark:bg-blue-900/30">
                                {{ array_sum($record->quarters['team2'] ?? [0,0,0,0]) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Team Statistics --}}
    @if($record->status === 'finished' && ($record->stat_fg_team1 || $record->stat_fg_team2))
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white text-center">
                Team Statistics
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                            <th class="text-right py-2 px-4 font-semibold text-gray-900 dark:text-white w-2/5">{{ $record->team1->name }}</th>
                            <th class="text-center py-2 px-4 font-semibold text-gray-600 dark:text-gray-400 w-1/5">STAT</th>
                            <th class="text-left py-2 px-4 font-semibold text-gray-900 dark:text-white w-2/5">{{ $record->team2->name }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- Field Goals --}}
                        @if($record->stat_fg_team1 || $record->stat_fg_team2)
                            <tr>
                                <td class="text-right py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_fg_team1 ?: '-' }}</td>
                                <td class="text-center py-2 px-4 text-gray-600 dark:text-gray-400 text-xs">Field Goals</td>
                                <td class="text-left py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_fg_team2 ?: '-' }}</td>
                            </tr>
                        @endif

                        {{-- 2 Points --}}
                        @if($record->stat_2pt_team1 || $record->stat_2pt_team2)
                            <tr>
                                <td class="text-right py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_2pt_team1 ?: '-' }}</td>
                                <td class="text-center py-2 px-4 text-gray-600 dark:text-gray-400 text-xs">2 Points</td>
                                <td class="text-left py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_2pt_team2 ?: '-' }}</td>
                            </tr>
                        @endif

                        {{-- 3 Points --}}
                        @if($record->stat_3pt_team1 || $record->stat_3pt_team2)
                            <tr>
                                <td class="text-right py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_3pt_team1 ?: '-' }}</td>
                                <td class="text-center py-2 px-4 text-gray-600 dark:text-gray-400 text-xs">3 Points</td>
                                <td class="text-left py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_3pt_team2 ?: '-' }}</td>
                            </tr>
                        @endif

                        {{-- Free Throws --}}
                        @if($record->stat_ft_team1 || $record->stat_ft_team2)
                            <tr>
                                <td class="text-right py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_ft_team1 ?: '-' }}</td>
                                <td class="text-center py-2 px-4 text-gray-600 dark:text-gray-400 text-xs">Free Throws</td>
                                <td class="text-left py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_ft_team2 ?: '-' }}</td>
                            </tr>
                        @endif

                        {{-- Rebounds --}}
                        @if($record->stat_reb_team1 || $record->stat_reb_team2)
                            <tr>
                                <td class="text-right py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_reb_team1 ?: '-' }}</td>
                                <td class="text-center py-2 px-4 text-gray-600 dark:text-gray-400 text-xs">Rebounds</td>
                                <td class="text-left py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_reb_team2 ?: '-' }}</td>
                            </tr>
                        @endif

                        {{-- Assists --}}
                        @if($record->stat_ast_team1 || $record->stat_ast_team2)
                            <tr>
                                <td class="text-right py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_ast_team1 ?: '-' }}</td>
                                <td class="text-center py-2 px-4 text-gray-600 dark:text-gray-400 text-xs">Assists</td>
                                <td class="text-left py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_ast_team2 ?: '-' }}</td>
                            </tr>
                        @endif

                        {{-- Steals --}}
                        @if($record->stat_stl_team1 || $record->stat_stl_team2)
                            <tr>
                                <td class="text-right py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_stl_team1 ?: '-' }}</td>
                                <td class="text-center py-2 px-4 text-gray-600 dark:text-gray-400 text-xs">Steals</td>
                                <td class="text-left py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_stl_team2 ?: '-' }}</td>
                            </tr>
                        @endif

                        {{-- Blocks --}}
                        @if($record->stat_blk_team1 || $record->stat_blk_team2)
                            <tr>
                                <td class="text-right py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_blk_team1 ?: '-' }}</td>
                                <td class="text-center py-2 px-4 text-gray-600 dark:text-gray-400 text-xs">Blocks</td>
                                <td class="text-left py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_blk_team2 ?: '-' }}</td>
                            </tr>
                        @endif

                        {{-- Turnovers --}}
                        @if($record->stat_to_team1 || $record->stat_to_team2)
                            <tr>
                                <td class="text-right py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_to_team1 ?: '-' }}</td>
                                <td class="text-center py-2 px-4 text-gray-600 dark:text-gray-400 text-xs">Turnovers</td>
                                <td class="text-left py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_to_team2 ?: '-' }}</td>
                            </tr>
                        @endif

                        {{-- Fouls --}}
                        @if($record->stat_foul_team1 || $record->stat_foul_team2)
                            <tr>
                                <td class="text-right py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_foul_team1 ?: '-' }}</td>
                                <td class="text-center py-2 px-4 text-gray-600 dark:text-gray-400 text-xs">Fouls</td>
                                <td class="text-left py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_foul_team2 ?: '-' }}</td>
                            </tr>
                        @endif

                        {{-- Points Off Turnover --}}
                        @if($record->stat_pot_team1 || $record->stat_pot_team2)
                            <tr>
                                <td class="text-right py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_pot_team1 ?: '-' }}</td>
                                <td class="text-center py-2 px-4 text-gray-600 dark:text-gray-400 text-xs">Points Off TO</td>
                                <td class="text-left py-2 px-4 text-gray-900 dark:text-white font-medium">{{ $record->stat_pot_team2 ?: '-' }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Box Score Team 1 --}}
    @if($record->status === 'finished' && $record->playerStats()->where('team_id', $record->team1_id)->exists())
        @php
            $boxScoreTeam1 = $record->playerStats()
                ->where('team_id', $record->team1_id)
                ->with('player')
                ->get();
        @endphp
        
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">
                Box Score - {{ $record->team1->name }}
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                            <th class="text-left py-2 px-3 font-semibold text-gray-900 dark:text-white">Player</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white">Min</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white">Pts</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white">Ast</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white">Reb</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white">MVP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($boxScoreTeam1 as $stat)
                            <tr class="{{ $stat->is_mvp ? 'bg-yellow-50 dark:bg-yellow-900/20' : '' }}">
                                <td class="py-2 px-3 text-gray-900 dark:text-white font-medium">
                                    #{{ $stat->player->jersey_no }} {{ $stat->player->name }}
                                    @if($stat->is_mvp)
                                        <span class="ml-2 text-xs bg-yellow-400 text-yellow-900 px-2 py-0.5 rounded-full font-bold">⭐ MVP</span>
                                    @endif
                                </td>
                                <td class="text-center py-2 px-3 text-gray-700 dark:text-gray-300">{{ $stat->minutes }}</td>
                                <td class="text-center py-2 px-3 text-gray-900 dark:text-white font-bold">{{ $stat->points }}</td>
                                <td class="text-center py-2 px-3 text-gray-700 dark:text-gray-300">{{ $stat->assists }}</td>
                                <td class="text-center py-2 px-3 text-gray-700 dark:text-gray-300">{{ $stat->rebounds }}</td>
                                <td class="text-center py-2 px-3">
                                    @if($stat->is_mvp)
                                        <span class="text-yellow-500">⭐</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-2 border-gray-300 dark:border-gray-600">
                        <tr class="font-bold bg-gray-100 dark:bg-gray-700">
                            <td class="py-2 px-3 text-gray-900 dark:text-white">TOTAL</td>
                            <td class="text-center py-2 px-3 text-gray-900 dark:text-white">{{ $boxScoreTeam1->sum('minutes') }}</td>
                            <td class="text-center py-2 px-3 text-gray-900 dark:text-white">{{ $boxScoreTeam1->sum('points') }}</td>
                            <td class="text-center py-2 px-3 text-gray-900 dark:text-white">{{ $boxScoreTeam1->sum('assists') }}</td>
                            <td class="text-center py-2 px-3 text-gray-900 dark:text-white">{{ $boxScoreTeam1->sum('rebounds') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif

    {{-- Box Score Team 2 --}}
    @if($record->status === 'finished' && $record->playerStats()->where('team_id', $record->team2_id)->exists())
        @php
            $boxScoreTeam2 = $record->playerStats()
                ->where('team_id', $record->team2_id)
                ->with('player')
                ->get();
        @endphp
        
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">
                Box Score - {{ $record->team2->name }}
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                            <th class="text-left py-2 px-3 font-semibold text-gray-900 dark:text-white">Player</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white">Min</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white">Pts</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white">Ast</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white">Reb</th>
                            <th class="text-center py-2 px-3 font-semibold text-gray-900 dark:text-white">MVP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($boxScoreTeam2 as $stat)
                            <tr class="{{ $stat->is_mvp ? 'bg-yellow-50 dark:bg-yellow-900/20' : '' }}">
                                <td class="py-2 px-3 text-gray-900 dark:text-white font-medium">
                                    #{{ $stat->player->jersey_no }} {{ $stat->player->name }}
                                    @if($stat->is_mvp)
                                        <span class="ml-2 text-xs bg-yellow-400 text-yellow-900 px-2 py-0.5 rounded-full font-bold">⭐ MVP</span>
                                    @endif
                                </td>
                                <td class="text-center py-2 px-3 text-gray-700 dark:text-gray-300">{{ $stat->minutes }}</td>
                                <td class="text-center py-2 px-3 text-gray-900 dark:text-white font-bold">{{ $stat->points }}</td>
                                <td class="text-center py-2 px-3 text-gray-700 dark:text-gray-300">{{ $stat->assists }}</td>
                                <td class="text-center py-2 px-3 text-gray-700 dark:text-gray-300">{{ $stat->rebounds }}</td>
                                <td class="text-center py-2 px-3">
                                    @if($stat->is_mvp)
                                        <span class="text-yellow-500">⭐</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-2 border-gray-300 dark:border-gray-600">
                        <tr class="font-bold bg-gray-100 dark:bg-gray-700">
                            <td class="py-2 px-3 text-gray-900 dark:text-white">TOTAL</td>
                            <td class="text-center py-2 px-3 text-gray-900 dark:text-white">{{ $boxScoreTeam2->sum('minutes') }}</td>
                            <td class="text-center py-2 px-3 text-gray-900 dark:text-white">{{ $boxScoreTeam2->sum('points') }}</td>
                            <td class="text-center py-2 px-3 text-gray-900 dark:text-white">{{ $boxScoreTeam2->sum('assists') }}</td>
                            <td class="text-center py-2 px-3 text-gray-900 dark:text-white">{{ $boxScoreTeam2->sum('rebounds') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif

    {{-- Match Status Badge --}}
    <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-700">
        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
            {{ $record->status === 'finished' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
            {{ $record->status === 'live' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
            {{ $record->status === 'upcoming' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}">
            {{ strtoupper($record->status) }}
        </span>
    </div>
</div>