<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Review;
use App\Models\Borrowing;
use App\Models\ReadingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class UserDiscoverController extends Controller
{
    /**
     * Display discover page with recommendations
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get personalized recommendations
        $recommendations = $this->getPersonalizedRecommendations($user);
        
        // Get trending books
        $trendingQuery = Book::where('status', 'approved');
        if (Schema::hasColumn('books', 'visibility')) {
            $trendingQuery->where('visibility', 'public');
        }
        $trending = $trendingQuery->orderBy('views', 'desc')
            ->orderBy('downloads', 'desc')
            ->limit(12)
            ->get();
        
        // Get new releases
        $newReleasesQuery = Book::where('status', 'approved');
        if (Schema::hasColumn('books', 'visibility')) {
            $newReleasesQuery->where('visibility', 'public');
        }
        $newReleases = $newReleasesQuery->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();
        
        // Get top rated - using downloads as proxy for rating
        $topRatedQuery = Book::where('status', 'approved');
        if (Schema::hasColumn('books', 'visibility')) {
            $topRatedQuery->where('visibility', 'public');
        }
        $topRated = $topRatedQuery->where('downloads', '>=', 5)
            ->orderBy('downloads', 'desc')
            ->limit(12)
            ->get();
        
        // Get popular categories
        $popularCategories = Category::withCount('books')
            ->orderBy('books_count', 'desc')
            ->limit(8)
            ->get();
        
        return view('user.discover', compact(
            'recommendations',
            'trending',
            'newReleases',
            'topRated',
            'popularCategories'
        ));
    }
    
    /**
     * Display new books
     */
    public function new()
    {
        // Check if visibility column exists, otherwise just use status
        $books = Book::where('status', 'approved');
        
        // Only add visibility condition if column exists
        if (Schema::hasColumn('books', 'visibility')) {
            $books->where('visibility', 'public');
        }
        
        $books = $books->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->paginate(24);
        
        $filters = [
            'categories' => Category::orderBy('name')->get(),
            'languages' => Book::distinct()->pluck('language'),
            'formats' => ['pdf', 'epub', 'mobi', 'azw3']
        ];
        
        return view('user.discover.new', compact('books', 'filters'));
    }
    
    /**
     * Display popular books
     */
    public function popular()
    {
        $timeRange = request('range', 'week');
        
        $startDate = match($timeRange) {
            'day' => now()->subDay(),
            'week' => now()->subWeek(),
            'month' => now()->subMonth(),
            'year' => now()->subYear(),
            default => now()->subWeek()
        };
        
        $booksQuery = Book::where('status', 'approved');
        
        // Check if visibility column exists
        if (Schema::hasColumn('books', 'visibility')) {
            $booksQuery->where('visibility', 'public');
        }
        
        // Note: borrowings relationship may not exist, using downloads as fallback
        $books = $booksQuery
            ->orderBy('downloads', 'desc')
            ->orderBy('views', 'desc')
            ->paginate(24);
        
        return view('user.discover.popular', compact('books', 'timeRange'));
    }
    
    /**
     * Display book categories
     */
    public function categories()
    {
        $categoriesQuery = Category::withCount('books')
            ->where('is_active', true);
        
        // Check if position column exists
        if (Schema::hasColumn('categories', 'position')) {
            $categoriesQuery->orderBy('position');
        }
        
        $categories = $categoriesQuery->orderBy('name')->get();
        
        // Check if is_featured column exists
        $featuredCategories = collect();
        if (Schema::hasColumn('categories', 'is_featured')) {
            $featuredCategoriesQuery = Category::where('is_featured', true)
                ->withCount('books');
            
            if (Schema::hasColumn('categories', 'position')) {
                $featuredCategoriesQuery->orderBy('position');
            }
            
            $featuredCategories = $featuredCategoriesQuery->limit(6)->get();
        } else {
            // Fallback: use first 6 categories as featured
            $featuredCategories = $categories->take(6);
        }
        
        return view('user.discover.categories', compact('categories', 'featuredCategories'));
    }
    
    /**
     * Display books by category
     */
    public function categoryBooks($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        // Note: Using simple category matching since many-to-many relationship may not exist
        $booksQuery = Book::where('category', $category->name)
            ->where('status', 'approved');
        
        // Check if visibility column exists
        if (Schema::hasColumn('books', 'visibility')) {
            $booksQuery->where('visibility', 'public');
        }
        
        $books = $booksQuery->orderBy('created_at', 'desc')->paginate(24);
        
        // Check if parent_id column exists for subcategories
        $subcategories = collect();
        if (Schema::hasColumn('categories', 'parent_id')) {
            $subcategories = Category::where('parent_id', $category->id)
                ->withCount('books')
                ->get();
        }
        
        return view('user.discover.category-books', compact('category', 'books', 'subcategories'));
    }
    
    /**
     * Display authors list
     */
    public function authors()
    {
        try {
            // Get all users who have uploaded books (they are authors)
            $authorsQuery = \App\Models\User::whereHas('uploadedBooks')
                ->withCount('uploadedBooks as books_count');
            
            // Check if role column exists
            if (Schema::hasColumn('users', 'role')) {
                $authorsQuery->whereIn('role', ['author', 'admin']);
            }
            
            $authors = $authorsQuery->orderBy('books_count', 'desc')
                ->paginate(24);
            
            // Get featured authors (those with most books)
            $featuredAuthors = \App\Models\User::whereHas('uploadedBooks')
                ->withCount('uploadedBooks as books_count')
                ->orderBy('books_count', 'desc')
                ->limit(8)
                ->get();
            
            // Calculate some stats
            $totalAuthors = \App\Models\User::whereHas('uploadedBooks')->count();
            $totalBooks = \App\Models\Book::count();
            $newAuthors = \App\Models\User::whereHas('uploadedBooks')
                ->where('created_at', '>=', now()->subMonth())
                ->count();
            $trendingCount = $featuredAuthors->count();
            
            return view('user.discover.authors', compact(
                'authors', 
                'featuredAuthors',
                'totalAuthors',
                'totalBooks',
                'newAuthors',
                'trendingCount'
            ));
        } catch (\Exception $e) {
            // Fallback with empty data
            return view('user.discover.authors', [
                'authors' => collect(),
                'featuredAuthors' => collect(),
                'totalAuthors' => 0,
                'totalBooks' => 0,
                'newAuthors' => 0,
                'trendingCount' => 0
            ]);
        }
    }
    
    /**
     * Display personalized recommendations
     */
    public function recommendations()
    {
        $user = Auth::user();
        
        // Get detailed recommendations with different algorithms
        $recommendations = [
            'based_on_history' => $this->getHistoryBasedRecommendations($user),
            'based_on_favorites' => $this->getFavoriteBasedRecommendations($user),
            'based_on_genre' => $this->getGenreBasedRecommendations($user),
            'collaborative' => $this->getCollaborativeRecommendations($user),
            'trending_in_interests' => $this->getTrendingInInterests($user)
        ];
        
        return view('user.discover.recommendations', compact('recommendations'));
    }
    
    /**
     * Search books with filters
     */
    public function search(Request $request)
    {
        $query = Book::where('status', 'approved');
        
        // Text search
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('author_name', 'like', "%{$searchTerm}%")
                  ->orWhere('isbn', 'like', "%{$searchTerm}%");
            });
        }
        
        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }
        
        // Language filter
        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }
        
        // Format filter
        if ($request->filled('format')) {
            $query->where('format', $request->format);
        }
        
        // Rating filter
        if ($request->filled('min_rating')) {
            $query->where('rating_average', '>=', $request->min_rating);
        }
        
        // Price filter
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Sort
        $sortBy = $request->get('sort', 'relevance');
        switch ($sortBy) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'rating':
                $query->orderBy('downloads', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('views', 'desc');
        }
        
        $books = $query->paginate(24)->withQueryString();
        
        $filters = [
            'categories' => Category::orderBy('name')->get(),
            'languages' => Book::distinct()->pluck('language'),
            'formats' => ['pdf', 'epub', 'mobi', 'azw3']
        ];
        
        return view('user.discover.search', compact('books', 'filters'));
    }
    
    /**
     * Get personalized recommendations for user
     */
    private function getPersonalizedRecommendations($user)
    {
        if (!$user) {
            return collect();
        }
        
        return Cache::remember("user_recommendations_{$user->id}", 3600, function () use ($user) {
            try {
                // Get user's reading history from borrowings table
                $readBooks = DB::table('borrowings')
                    ->where('user_id', $user->id)
                    ->pluck('book_id')
                    ->toArray();
                
                if (empty($readBooks)) {
                    // Return popular books for new users
                    $query = Book::where('status', 'approved');
                    
                    if (Schema::hasColumn('books', 'visibility')) {
                        $query->where('visibility', 'public');
                    }
                    
                    return $query->orderBy('downloads', 'desc')
                        ->limit(12)
                        ->get();
                }
                
                // Get categories from read books (using simple category field)
                $preferredCategories = Book::whereIn('id', $readBooks)
                    ->pluck('category')
                    ->unique()
                    ->toArray();
                
                // Get similar books based on categories
                $query = Book::whereIn('category', $preferredCategories)
                    ->whereNotIn('id', $readBooks)
                    ->where('status', 'approved');
                
                if (Schema::hasColumn('books', 'visibility')) {
                    $query;
                }
                
                return $query->orderBy('downloads', 'desc')
                    ->limit(12)
                    ->get();
                    
            } catch (\Exception $e) {
                // Fallback: return random approved books
                return Book::where('status', 'approved')
                    ->inRandomOrder()
                    ->limit(12)
                    ->get();
            }
        });
    }
    
    /**
     * Get recommendations based on reading history
     */
    private function getHistoryBasedRecommendations($user)
    {
        $readBooks = Borrowing::where('user_id', $user->id)
            ->orderBy('borrowed_at', 'desc')
            ->limit(10)
            ->pluck('book_id');
        
        if ($readBooks->isEmpty()) {
            return collect();
        }
        
        $categories = DB::table('book_categories')
            ->whereIn('book_id', $readBooks)
            ->groupBy('category_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(3)
            ->pluck('category_id');
        
        return Book::whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('categories.id', $categories);
            })
            ->whereNotIn('id', $readBooks)
            ->where('status', 'approved')
            ->orderBy('downloads', 'desc')
            ->limit(8)
            ->get();
    }
    
    /**
     * Get recommendations based on favorites
     */
    private function getFavoriteBasedRecommendations($user)
    {
        $favoriteBooks = DB::table('user_favorites')
            ->where('user_id', $user->id)
            ->pluck('book_id');
        
        if ($favoriteBooks->isEmpty()) {
            return collect();
        }
        
        $authors = Book::whereIn('id', $favoriteBooks)
            ->pluck('author_name')
            ->unique();
        
        return Book::whereIn('author_name', $authors)
            ->whereNotIn('id', $favoriteBooks)
            ->where('status', 'approved')
            ->orderBy('downloads', 'desc')
            ->limit(8)
            ->get();
    }
    
    /**
     * Get genre-based recommendations
     */
    private function getGenreBasedRecommendations($user)
    {
        $profile = $user->profile;
        
        if (!$profile || !$profile->reading_preferences) {
            return collect();
        }
        
        $preferences = json_decode($profile->reading_preferences, true);
        $preferredGenres = $preferences['genres'] ?? [];
        
        if (empty($preferredGenres)) {
            return collect();
        }
        
        return Book::whereHas('categories', function ($query) use ($preferredGenres) {
                $query->whereIn('name', $preferredGenres);
            })
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
    }
    
    /**
     * Get collaborative filtering recommendations
     */
    private function getCollaborativeRecommendations($user)
    {
        // Find users with similar reading patterns
        $userBooks = Borrowing::where('user_id', $user->id)
            ->pluck('book_id')
            ->toArray();
        
        if (empty($userBooks)) {
            return collect();
        }
        
        // Find other users who read similar books
        $similarUsers = Borrowing::whereIn('book_id', $userBooks)
            ->where('user_id', '!=', $user->id)
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) >= ?', [3])
            ->pluck('user_id');
        
        if ($similarUsers->isEmpty()) {
            return collect();
        }
        
        // Get books read by similar users
        $recommendedBookIds = Borrowing::whereIn('user_id', $similarUsers)
            ->whereNotIn('book_id', $userBooks)
            ->groupBy('book_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(8)
            ->pluck('book_id');
        
        return Book::whereIn('id', $recommendedBookIds)
            ->where('status', 'approved')
            ->get();
    }
    
    /**
     * Get trending books in user's interests
     */
    private function getTrendingInInterests($user)
    {
        $readCategories = DB::table('book_categories')
            ->join('borrowings', 'book_categories.book_id', '=', 'borrowings.book_id')
            ->where('borrowings.user_id', $user->id)
            ->pluck('book_categories.category_id')
            ->unique();
        
        if ($readCategories->isEmpty()) {
            return collect();
        }
        
        return Book::whereHas('categories', function ($query) use ($readCategories) {
                $query->whereIn('categories.id', $readCategories);
            })
            ->where('status', 'approved')
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('views', 'desc')
            ->limit(8)
            ->get();
    }
}