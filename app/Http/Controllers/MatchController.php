<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\News;
use App\Models\MatchHighlight;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class MatchController extends Controller
{
    /**
     * Display the match schedule & results page
     */
    public function index(Request $request)
    {
        // Set timezone dan locale untuk Jakarta
        Carbon::setLocale('id');
        $jakartaNow = Carbon::now('Asia/Jakarta');

        // Get filter parameters
        $selectedYear = $request->input('year', ''); // ✅ Tambahkan year filter
        $league = $request->input('league', '');
        $series = $request->input('series', '');
        $region = $request->input('region', '');
        $search = $request->input('search', '');
        $selectedDate = $request->input('date');
        $weekOffset = (int) $request->input('week', 0);
        $selectedMonth = $request->input('month');

        // ✅ Get unique leagues dari database
        $leagues = Game::select('league')
            ->distinct()
            ->whereNotNull('league')
            ->where('league', '!=', '')
            ->orderBy('league', 'asc')
            ->pluck('league')
            ->toArray();

        // ✅ FIX: Tentukan base date dengan prioritas yang benar
        if ($selectedDate) {
            // Jika ada tanggal spesifik yang dipilih, gunakan tanggal tersebut
            $baseDate = Carbon::parse($selectedDate, 'Asia/Jakarta');
            // Ambil minggu dari tanggal yang dipilih
            $startOfWeek = $baseDate->copy()->startOfWeek();
        } elseif ($selectedMonth) {
            // Jika ada bulan yang dipilih, gunakan bulan tersebut
            $baseDate = Carbon::parse($selectedMonth, 'Asia/Jakarta')->startOfMonth();
            $startOfWeek = $baseDate->copy()->addWeeks($weekOffset);
        } else {
            // Default ke hari ini
            $baseDate = $jakartaNow->copy();
            $startOfWeek = $baseDate->copy()->startOfWeek()->addWeeks($weekOffset);
        }

        // Generate 7 hari berdasarkan start of week
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $currentDate = $startOfWeek->copy()->addDays($i);

            // Hitung jumlah pertandingan di tanggal ini dengan semua filter
            $matchCountQuery = Game::whereDate('date', $currentDate->format('Y-m-d'));

            // ✅ Apply year filter
            if ($selectedYear !== '') {
                $matchCountQuery->whereYear('date', $selectedYear);
            }

            // Apply league filter
            if ($league !== '') {
                $matchCountQuery->where('league', $league);
            }

            // Apply series filter
            if ($series !== '') {
                $matchCountQuery->where('series', $series);
            }

            // Apply region filter
            if ($region !== '') {
                $matchCountQuery->where('region', $region);
            }

            // Apply search filter
            if ($search) {
                $matchCountQuery->where(function ($query) use ($search) {
                    $query->whereHas('team1', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                        ->orWhereHas('team2', function ($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%");
                        });
                });
            }

            $matchCount = $matchCountQuery->count();

            $dates[] = [
                'day' => $currentDate->day,
                'name' => ucfirst($currentDate->isoFormat('dddd')),
                'month' => ucfirst($currentDate->isoFormat('MMMM Y')),
                'matches' => $matchCount,
                'full_date' => $currentDate->format('Y-m-d'),
                'is_today' => $currentDate->isSameDay($jakartaNow),
            ];
        }

        // ✅ FIX: Auto-select date logic yang lebih baik
        if (!$selectedDate && !empty($dates)) {
            if ($weekOffset == 0 && !$selectedMonth) {
                // Cari hari ini di dates array
                $todayInDates = collect($dates)->firstWhere('is_today', true);
                if ($todayInDates) {
                    $selectedDate = $todayInDates['full_date'];
                } else {
                    $selectedDate = $dates[0]['full_date'];
                }
            } else {
                // Pilih hari pertama dari week yang ditampilkan
                $selectedDate = $dates[0]['full_date'];
            }
        }

        // ✅ Hitung info minggu untuk navigasi
        $currentWeekStart = $startOfWeek->copy();
        $currentWeekEnd = $currentWeekStart->copy()->addDays(6);
        $weekInfo = [
            'offset' => $weekOffset,
            'start' => $currentWeekStart->format('d M'),
            'end' => $currentWeekEnd->format('d M Y'),
            'is_current' => $weekOffset == 0 && !$selectedMonth && $currentWeekStart->isSameWeek($jakartaNow),
        ];

        // ✅ Query matches dengan semua filter termasuk year
        $matchesQuery = Game::with(['team1', 'team2', 'team1Category', 'team2Category']);

        // Apply year filter
        if ($selectedYear !== '') {
            $matchesQuery->whereYear('date', $selectedYear);
        }

        // Filter by league
        if ($league !== '') {
            $matchesQuery->where('league', $league);
        }

        // Filter by series
        if ($series !== '') {
            $matchesQuery->where('series', $series);
        }

        // Filter by region
        if ($region !== '') {
            $matchesQuery->where('region', $region);
        }

        // Filter by selected date
        if ($selectedDate) {
            $matchesQuery->whereDate('date', $selectedDate);
        }

        // Search filter
        if ($search) {
            $matchesQuery->where(function ($query) use ($search) {
                $query->whereHas('team1', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                    ->orWhereHas('team2', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Order by date and time
        $matches = $matchesQuery
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->paginate(6)
            ->through(function ($match) {
                $team1Logo = $this->normalizeLogoPath($match->team1->logo, $match->team1->name);
                $team2Logo = $this->normalizeLogoPath($match->team2->logo, $match->team2->name);

                return [
                    'id' => $match->id,
                    'type' => $match->status,
                    'league' => $match->league,
                    'date' => $match->formatted_date,
                    'time' => $match->formatted_time,
                    'venue' => $match->venue,
                    'team1' => [
                        'name' => $match->team1->name,
                        'logo' => $team1Logo,
                        'category' => $match->team1Category ? [
                            'name' => $match->team1Category->category_name,
                            'age_group' => $match->team1Category->age_group
                        ] : null
                    ],
                    'team2' => [
                        'name' => $match->team2->name,
                        'logo' => $team2Logo,
                        'category' => $match->team2Category ? [
                            'name' => $match->team2Category->category_name,
                            'age_group' => $match->team2Category->age_group
                        ] : null
                    ],
                    'score' => $match->score
                ];
            });

        return Inertia::render('MatchPage/MatchPage', [
            'auth' => [
                'client' => auth('client')->user()
            ],
            'filters' => [
                'year' => $selectedYear, // ✅ Tambahkan year ke filters
                'league' => $league,
                'series' => $series,
                'region' => $region,
                'search' => $search,
                'selectedDate' => $selectedDate,
                'week' => $weekOffset,
                'month' => $selectedMonth,
            ],
            'dates' => $dates,
            'matches' => $matches,
            'today' => $jakartaNow->format('Y-m-d'),
            'weekInfo' => $weekInfo,
            'leagues' => $leagues, // ✅ Pass unique leagues ke frontend
        ]);
    }

    /**
     * Normalize logo path
     */
    private function normalizeLogoPath($logoPath, $teamName = null)
    {
        if (empty($logoPath)) {
            return '/images/default-team-logo.png';
        }

        if (str_starts_with($logoPath, 'http://') || str_starts_with($logoPath, 'https://')) {
            return $logoPath;
        }

        if (str_starts_with($logoPath, '/storage/')) {
            return $logoPath;
        }

        if (str_starts_with($logoPath, 'storage/')) {
            return '/' . $logoPath;
        }

        if (!str_contains($logoPath, '/')) {
            return '/storage/teams/logos/' . $logoPath;
        }

        return '/storage/' . ltrim($logoPath, '/');
    }

    /**
     * Display match detail page
     */
    public function show($id)
    {
        Carbon::setLocale('id');

        $match = Game::with([
            'team1',
            'team2',
            'team1Category',
            'team2Category',
            'playerStats.player'
        ])->findOrFail($id);

        $quartersRaw = $match->quarters;

        $quarters = [
            'team1' => array_map('intval', $quartersRaw['team1'] ?? [0, 0, 0, 0]),
            'team2' => array_map('intval', $quartersRaw['team2'] ?? [0, 0, 0, 0]),
        ];

        $total1 = array_sum($quarters['team1']);
        $total2 = array_sum($quarters['team2']);
        $calculatedScore = ($total1 > 0 || $total2 > 0) ? "{$total1} - {$total2}" : null;

        $stats = [];
        if ($match->status === 'finished' && $match->stat_fg_team1) {
            $stats = [
                [
                    'category' => 'Field Goals',
                    'team1' => $match->stat_fg_team1 ?? '0/0 (0%)',
                    'team2' => $match->stat_fg_team2 ?? '0/0 (0%)',
                ],
                [
                    'category' => '2 Points',
                    'team1' => $match->stat_2pt_team1 ?? '0/0 (0%)',
                    'team2' => $match->stat_2pt_team2 ?? '0/0 (0%)',
                ],
                [
                    'category' => '3 Points',
                    'team1' => $match->stat_3pt_team1 ?? '0/0 (0%)',
                    'team2' => $match->stat_3pt_team2 ?? '0/0 (0%)',
                ],
                [
                    'category' => 'Free Throws',
                    'team1' => $match->stat_ft_team1 ?? '0/0 (0%)',
                    'team2' => $match->stat_ft_team2 ?? '0/0 (0%)',
                ],
                [
                    'category' => 'Rebounds',
                    'team1' => $match->stat_reb_team1 ?? '0/0',
                    'team2' => $match->stat_reb_team2 ?? '0/0',
                ],
                [
                    'category' => 'Assist',
                    'team1' => $match->stat_ast_team1 ?? '0',
                    'team2' => $match->stat_ast_team2 ?? '0',
                ],
                [
                    'category' => 'Steals',
                    'team1' => $match->stat_stl_team1 ?? '0',
                    'team2' => $match->stat_stl_team2 ?? '0',
                ],
                [
                    'category' => 'Blocks',
                    'team1' => $match->stat_blk_team1 ?? '0',
                    'team2' => $match->stat_blk_team2 ?? '0',
                ],
                [
                    'category' => 'Turnovers',
                    'team1' => $match->stat_to_team1 ?? '0',
                    'team2' => $match->stat_to_team2 ?? '0',
                ],
                [
                    'category' => 'Fouls',
                    'team1' => $match->stat_foul_team1 ?? '0',
                    'team2' => $match->stat_foul_team2 ?? '0',
                ],
                [
                    'category' => 'Points Off Turnover',
                    'team1' => $match->stat_pot_team1 ?? '0',
                    'team2' => $match->stat_pot_team2 ?? '0',
                ],
            ];
        }

        $matchHighlights = MatchHighlight::where('game_id', $id)
            ->where('status', 'active')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($highlight) use ($match) {
                return [
                    'id' => $highlight->id,
                    'title' => $highlight->title,
                    'thumbnail' => $highlight->thumbnail_url,
                    'quarter' => $highlight->quarter,
                    'duration' => $highlight->duration,
                    'views' => $highlight->formatted_views,
                    'video_url' => $highlight->video_url,
                    'category' => $match->league ?? 'Basketball',
                    'venue' => $match->venue ?? 'GOR Arena',
                    'time' => $match->formatted_time ?? '00:00',
                    'date' => $match->formatted_date ?? now()->format('d M Y'),
                ];
            });

        $relatedNews = News::published()
            ->inRandomOrder()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'excerpt' => $item->excerpt,
                    'image' => $item->image
                        ? asset('storage/' . $item->image)
                        : 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800',
                    'category' => $item->category,
                    'date' => $item->formatted_date,
                ];
            });

        $matchData = [
            'id' => $match->id,
            'league' => $match->league,
            'date' => $match->formatted_date,
            'time' => $match->formatted_time,
            'venue' => $match->venue,
            'status' => $match->status,
            'team1' => [
                'id' => $match->team1->id,
                'name' => $match->team1->name,
                'logo' => $this->normalizeLogoPath($match->team1->logo, $match->team1->name),
                'category' => $match->team1Category ? [
                    'name' => $match->team1Category->category_name,
                    'age_group' => $match->team1Category->age_group
                ] : null
            ],
            'team2' => [
                'id' => $match->team2->id,
                'name' => $match->team2->name,
                'logo' => $this->normalizeLogoPath($match->team2->logo, $match->team2->name),
                'category' => $match->team2Category ? [
                    'name' => $match->team2Category->category_name,
                    'age_group' => $match->team2Category->age_group
                ] : null
            ],
            'score' => $calculatedScore ?? $match->score,
            'quarters' => $quarters,
            'stats' => $stats,
            'boxScoreTeam1' => $match->boxScoreTeam1(),
            'boxScoreTeam2' => $match->boxScoreTeam2(),
        ];
        
        return Inertia::render('MatchPage/MatchDetail', [
            'auth' => [
                'client' => auth('client')->user()
            ],
            'match' => $matchData,
            'matchHighlights' => $matchHighlights,
            'relatedNews' => $relatedNews,
        ]);
    }

    /**
     * Get matches by date (untuk AJAX request)
     */
    public function getMatchesByDate(Request $request)
    {
        $date = $request->input('date');
        $matches = Game::with(['team1', 'team2'])
            ->whereDate('date', $date)
            ->orderBy('time', 'asc')
            ->get()
            ->map(function ($match) {
                return [
                    'id' => $match->id,
                    'type' => $match->status,
                    'league' => $match->league,
                    'date' => $match->formatted_date,
                    'time' => $match->formatted_time,
                    'team1' => [
                        'name' => $match->team1->name,
                        'logo' => $this->normalizeLogoPath($match->team1->logo, $match->team1->name)
                    ],
                    'team2' => [
                        'name' => $match->team2->name,
                        'logo' => $this->normalizeLogoPath($match->team2->logo, $match->team2->name)
                    ],
                    'score' => $match->score
                ];
            });

        return response()->json([
            'success' => true,
            'matches' => $matches
        ]);
    }

    /**
     * Search matches
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $results = Game::with(['team1', 'team2'])
            ->search($query)
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($match) {
                return [
                    'id' => $match->id,
                    'league' => $match->league,
                    'date' => $match->formatted_date,
                    'team1' => $match->team1->name,
                    'team2' => $match->team2->name,
                    'score' => $match->score
                ];
            });

        return response()->json([
            'success' => true,
            'results' => $results
        ]);
    }

    /**
     * Get match statistics
     */
    public function getStats($id)
    {
        $match = Game::findOrFail($id);

        return response()->json([
            'success' => true,
            'stats' => $match->stats
        ]);
    }
}