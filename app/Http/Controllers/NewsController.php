<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $search = $request->get('search', '');
        $perPage = 9;

        $query = News::published();

        if ($filter === 'latest') {
            $query->latest();
        } elseif ($filter === 'popular') {
            $query->popular();
        } else {
            $query->latest();
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $newsPaginated = $query->paginate($perPage);
        
        $news = $newsPaginated->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'excerpt' => $item->excerpt,
                'content' => $item->content,
                'image' => $item->image ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800',
                'category' => $item->category,
                'date' => $item->formatted_date,
                'views' => $item->views,
                'created_at' => $item->created_at,
            ];
        });

        $latestNews = News::published()->latest()->take(3)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'excerpt' => $item->excerpt,
                'image' => $item->image ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800',
                'date' => $item->formatted_date,
            ];
        });

        $popularNews = News::published()->popular()->take(3)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'excerpt' => $item->excerpt,
                'image' => $item->image ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800',
                'date' => $item->formatted_date,
            ];
        });

        return Inertia::render('HomePage/News', [
            'auth' => [
                'client' => Auth::guard('client')->user()
            ],
            'news' => $news,
            'latestNews' => $latestNews,
            'popularNews' => $popularNews,
            'currentPage' => $newsPaginated->currentPage(),
            'totalPages' => $newsPaginated->lastPage(),
            'filter' => $filter,
            'search' => $search
        ]);
    }

    public function show($id)
    {
        $newsItem = News::published()->findOrFail($id);
        $newsItem->incrementViews();

        $news = [
            'id' => $newsItem->id,
            'title' => $newsItem->title,
            'excerpt' => $newsItem->excerpt,
            'content' => $newsItem->content,
            'image' => $newsItem->image ? asset('storage/' . $newsItem->image) : 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800',
            'category' => $newsItem->category,
            'date' => $newsItem->formatted_date,
            'views' => $newsItem->views,
        ];

        $latestNews = News::published()->where('id', '!=', $id)->latest()->take(3)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'excerpt' => $item->excerpt,
                'image' => $item->image ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800',
                'date' => $item->formatted_date,
            ];
        });

        $popularNews = News::published()->where('id', '!=', $id)->popular()->take(3)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'excerpt' => $item->excerpt,
                'image' => $item->image ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800',
                'date' => $item->formatted_date,
            ];
        });

        return Inertia::render('HomePage/NewsDetail', [
            'auth' => [
                'client' => Auth::guard('client')->user()
            ],
            'news' => $news,
            'latestNews' => $latestNews,
            'popularNews' => $popularNews
        ]);
    }
}