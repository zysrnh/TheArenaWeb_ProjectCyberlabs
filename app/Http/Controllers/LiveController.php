<?php

namespace App\Http\Controllers;

use App\Models\LiveMatch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LiveController extends Controller
{
    public function index()
    {
        // Ambil semua live matches yang aktif, urutkan berdasarkan tanggal dan status
        $liveMatches = LiveMatch::active()
            ->orderByRaw("FIELD(status, 'live', 'scheduled', 'ended')")
            ->orderBy('match_date', 'desc')
            ->orderBy('time', 'asc')
            ->get()
            ->map(function ($match) {
                return [
                    'id' => $match->id,
                    'title' => $match->title,
                    'category' => $match->category,
                    'venue' => $match->venue,
                    'court' => $match->court,
                    'time' => $match->time,
                    'status' => $match->status,
                    'img' => $match->thumbnail_url, // Menggunakan accessor
                    'stream_url' => $match->stream_url,
                    'series' => $match->series,
                    'match_date' => $match->match_date->format('Y-m-d'),
                ];
            });

        return Inertia::render('LivePage/LivePage', [
            'auth' => [
                'client' => auth('client')->user()
            ],
            'liveMatches' => $liveMatches
        ]);
    }

    public function filter(Request $request)
    {
        $time = $request->input('time', 'all');
        $series = $request->input('series', 'all');

        $liveMatches = LiveMatch::active()
            ->byTimeRange($time)
            ->bySeries($series)
            ->orderByRaw("FIELD(status, 'live', 'scheduled', 'ended')")
            ->orderBy('match_date', 'desc')
            ->orderBy('time', 'asc')
            ->get()
            ->map(function ($match) {
                return [
                    'id' => $match->id,
                    'title' => $match->title,
                    'category' => $match->category,
                    'venue' => $match->venue,
                    'court' => $match->court,
                    'time' => $match->time,
                    'status' => $match->status,
                    'img' => $match->thumbnail_url,
                    'stream_url' => $match->stream_url,
                    'series' => $match->series,
                    'match_date' => $match->match_date->format('Y-m-d'),
                ];
            });

        return response()->json([
            'matches' => $liveMatches
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query', '');

        $liveMatches = LiveMatch::active()
            ->search($query)
            ->orderByRaw("FIELD(status, 'live', 'scheduled', 'ended')")
            ->orderBy('match_date', 'desc')
            ->orderBy('time', 'asc')
            ->get()
            ->map(function ($match) {
                return [
                    'id' => $match->id,
                    'title' => $match->title,
                    'category' => $match->category,
                    'venue' => $match->venue,
                    'court' => $match->court,
                    'time' => $match->time,
                    'status' => $match->status,
                    'img' => $match->thumbnail_url,
                    'stream_url' => $match->stream_url,
                    'series' => $match->series,
                    'match_date' => $match->match_date->format('Y-m-d'),
                ];
            });

        return response()->json([
            'matches' => $liveMatches
        ]);
    }
}