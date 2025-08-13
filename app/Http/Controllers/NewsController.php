<?php

namespace App\Http\Controllers;

use App\Models\EducationalNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    /**
     * Display a listing of the news
     */
    public function index(Request $request)
    {
        $query = EducationalNews::published()->with('author');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%");
            });
        }

        $news = $query->recent()->paginate(12);

        // Get categories for filter
        $categories = Cache::remember('news_categories', 3600, function() {
            return EducationalNews::published()
                ->select('category', \DB::raw('count(*) as count'))
                ->groupBy('category')
                ->get();
        });

        // Get recent urgent news for sidebar
        $urgentNews = Cache::remember('urgent_news', 300, function() {
            return EducationalNews::published()
                ->urgent()
                ->recent()
                ->take(3)
                ->get();
        });

        return view('news.index', compact('news', 'categories', 'urgentNews'));
    }

    /**
     * Display the specified news
     */
    public function show($id)
    {
        $news = EducationalNews::published()->findOrFail($id);
        
        // Increment views
        $news->incrementViews();

        // Get related news
        $relatedNews = EducationalNews::published()
            ->where('id', '!=', $id)
            ->where('category', $news->category)
            ->recent()
            ->take(4)
            ->get();

        // Get recent news for sidebar
        $recentNews = Cache::remember('recent_news_sidebar', 600, function() {
            return EducationalNews::published()
                ->recent()
                ->take(5)
                ->get();
        });

        return view('news.show', compact('news', 'relatedNews', 'recentNews'));
    }

    /**
     * Get news for homepage widget
     */
    public function widget()
    {
        $news = Cache::remember('homepage_news_widget', 300, function() {
            return EducationalNews::published()
                ->recent()
                ->take(4)
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'title' => $item->title,
                        'excerpt' => $item->excerpt ?: \Str::limit($item->content, 100),
                        'category' => $item->category_label,
                        'category_color' => $item->category_color,
                        'icon' => $item->icon,
                        'time_ago' => $item->time_ago,
                        'image_path' => $item->image_path,
                        'url' => route('news.show', $item->id)
                    ];
                });
        });

        return response()->json($news);
    }

    /**
     * Get urgent news ticker
     */
    public function ticker()
    {
        $news = Cache::remember('news_ticker', 300, function() {
            return EducationalNews::published()
                ->where('priority', 'urgent')
                ->recent()
                ->take(5)
                ->get(['id', 'title', 'category'])
                ->map(function($item) {
                    return [
                        'title' => $item->title,
                        'url' => route('news.show', $item->id),
                        'badge' => $item->category_label
                    ];
                });
        });

        return response()->json($news);
    }
}