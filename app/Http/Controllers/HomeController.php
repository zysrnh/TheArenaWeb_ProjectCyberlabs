<?php

namespace App\Http\Controllers;

use App\Models\LiveMatch;
use App\Models\Game;
use App\Models\News;
use App\Models\Sponsor;
use App\Models\Partner;
use App\Models\Review;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $newsForHome = News::published()
                ->latest()
                ->take(3)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'title' => $item->title,
                        'excerpt' => $item->excerpt,
                        'image' => $item->image ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800',
                        'category' => $item->category,
                        'date' => $item->formatted_date,
                    ];
                });

            // Ambil 6 live matches terbaru yang aktif
            $liveMatches = LiveMatch::where('is_active', true)
                ->orderBy('match_date', 'desc')
                ->orderBy('time', 'desc')
                ->take(6)
                ->get()
                ->map(function ($match) {
                    return [
                        'id' => $match->id,
                        'status' => $match->status,
                        'time' => $match->time,
                        'title' => $match->title,
                        'img' => $match->thumbnail
                            ? asset('storage/' . $match->thumbnail)
                            : asset('images/comingsoon.png'),
                        'venue' => $match->venue,
                        'category' => $match->category,
                        'court' => $match->court,
                        'stream_url' => $match->stream_url,
                    ];
                });

            // Get filter from request, default to 'all'
            $filter = $request->get('filter', 'all');

            // Build query based on filter
            $query = Game::with(['team1', 'team2']);

            if ($filter === 'live') {
                $query->where('status', 'live');
            } elseif ($filter === 'upcoming') {
                $query->whereIn('status', ['upcoming', 'scheduled']);
            } elseif ($filter === 'all') {
                $query->whereIn('status', ['live', 'upcoming', 'scheduled', 'finished', 'completed']);
            }

            // Get matches
            $homeMatches = $query
                ->orderByRaw("FIELD(status, 'live', 'upcoming', 'scheduled', 'finished', 'completed')")
                ->orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->take(4)
                ->get()
                ->map(function ($game) {
                    $type = 'upcoming';
                    if ($game->status === 'live') {
                        $type = 'live';
                    } elseif ($game->status === 'finished' || $game->status === 'completed') {
                        $type = 'finished';
                    }

                    return [
                        'id' => $game->id,
                        'team1' => [
                            'name' => $game->team1->name ?? 'Team 1',
                            'logo' => $game->team1 && $game->team1->logo
                                ? asset('storage/' . $game->team1->logo)
                                : asset('images/default-team-logo.png'),
                        ],
                        'team2' => [
                            'name' => $game->team2->name ?? 'Team 2',
                            'logo' => $game->team2 && $game->team2->logo
                                ? asset('storage/' . $game->team2->logo)
                                : asset('images/default-team-logo.png'),
                        ],
                        'type' => $type,
                        'league' => $game->league ?? 'League',
                        'day' => $game->date->locale('id')->isoFormat('dddd'),
                        'date' => $game->date->locale('id')->isoFormat('D MMMM YYYY'),
                        'time' => $game->formatted_time ?? $game->time,
                        'score' => $game->score,
                    ];
                });

            // Sponsors & Partners
            $sponsors = Sponsor::active()->ordered()->get()->map(function ($sponsor) {
                return [
                    'id' => $sponsor->id,
                    'name' => $sponsor->name,
                    'image' => asset('storage/' . $sponsor->image),
                ];
            });

            $partners = Partner::active()->ordered()->get()->map(function ($partner) {
                return [
                    'id' => $partner->id,
                    'name' => $partner->name,
                    'image' => asset('storage/' . $partner->image),
                ];
            });

            // Reviews
            $reviews = Review::with('client:id,name,profile_image')
                ->approved()
                ->latest()
                ->take(6)
                ->get()
                ->map(function ($review) {
                    return [
                        'id' => $review->id,
                        'client_name' => $review->client->name,
                        'client_profile_image' => $review->client->profile_image,
                        'rating' => $review->rating,
                        'rating_facilities' => $review->rating_facilities,
                        'rating_hospitality' => $review->rating_hospitality,
                        'rating_cleanliness' => $review->rating_cleanliness,
                        'comment' => $review->comment,
                        'created_at' => $review->created_at->diffForHumans(),
                    ];
                });

            // ✅ PERBAIKAN: Handle gambar fasilitas - support URL & uploaded file
            $facilities = Facility::active()
                ->ordered()
                ->get()
                ->map(function ($facility) {
                    // Cek apakah image_url adalah URL penuh (http/https) atau path file
                    $imageUrl = 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800'; // default
                    
                    if ($facility->image_url) {
                        // Jika dimulai dengan http/https, langsung gunakan URL tersebut
                        if (str_starts_with($facility->image_url, 'http://') || 
                            str_starts_with($facility->image_url, 'https://')) {
                            $imageUrl = $facility->image_url;
                        } 
                        // Jika path file lokal, tambahkan asset storage
                        else {
                            $imageUrl = asset('storage/' . $facility->image_url);
                        }
                    }
                    
                    return [
                        'id' => $facility->id,
                        'name' => $facility->name,
                        'description' => $facility->description,
                        'image' => $imageUrl,
                    ];
                });

            return Inertia::render('HomePage/HomePage', [
                'auth' => [
                    'client' => Auth::guard('client')->user()
                ],
                'liveMatches' => $liveMatches,
                'homeMatches' => $homeMatches,
                'currentFilter' => $filter,
                'newsForHome' => $newsForHome,
                'sponsors' => $sponsors,
                'partners' => $partners,
                'reviews' => $reviews,
                'facilities' => $facilities,
            ]);
        } catch (\Exception $e) {
            Log::error('HomePage Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return Inertia::render('HomePage/HomePage', [
                'auth' => [
                    'client' => Auth::guard('client')->user()
                ],
                'liveMatches' => [],
                'homeMatches' => [],
                'currentFilter' => 'all',
                'newsForHome' => [],
                'sponsors' => [],
                'partners' => [],
                'reviews' => [],
                'facilities' => [],
            ]);
        }
    }
}