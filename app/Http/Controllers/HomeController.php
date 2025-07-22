<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Display the home page with real data
     */
    public function index(Request $request)
    {
        // Statistiques générales
        $stats = $this->getGeneralStats();

        // Livres populaires/récents avec filtrage
        $featuredBooks = $this->getFeaturedBooks($request);

        // Auteurs en vedette
        $featuredAuthors = $this->getFeaturedAuthors();

        // Catégories populaires
        $popularCategories = $this->getPopularCategories();

        // Activité récente
        $recentActivity = $this->getRecentActivity();

        // Obtenir les catégories, langues et auteurs pour les filtres
        $categories = Book::where('status', 'approved')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort();

        $languages = Book::where('status', 'approved')
            ->whereNotNull('language')
            ->distinct()
            ->pluck('language')
            ->sort();

        $authors = Book::where('status', 'approved')
            ->whereNotNull('author_name')
            ->distinct()
            ->pluck('author_name')
            ->sort();

        return view('home', compact(
            'stats',
            'featuredBooks',
            'featuredAuthors',
            'popularCategories',
            'recentActivity',
            'categories',
            'languages',
            'authors'
        ));
    }

    /**
     * Get filtered books for AJAX requests
     */
    public function getFilteredBooks(Request $request)
    {
        // Debug: return debug info for testing
        if ($request->has('debug')) {
            $authors = Book::where('status', 'approved')
                ->whereNotNull('author_name')
                ->distinct()
                ->pluck('author_name')
                ->sort();

            $balzacBooks = Book::where('status', 'approved')
                ->where('author_name', 'Honoré de Balzac')
                ->count();

            return response()->json([
                'debug' => true,
                'request_params' => $request->all(),
                'total_authors' => $authors->count(),
                'sample_authors' => $authors->take(10)->values(),
                'balzac_books_count' => $balzacBooks
            ]);
        }

        $featuredBooks = $this->getFeaturedBooks($request);

        $activeTab = $request->get('tab', 'recent');
        $books = $featuredBooks[$activeTab] ?? $featuredBooks['recent'];

        return response()->json([
            'success' => true,
            'books' => $books->map(function($book) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author_name' => $book->author_name,
                    'category' => $book->category,
                    'language' => $book->language,
                    'views' => $book->views,
                    'downloads' => $book->downloads,
                    'cover_image' => $book->cover_image ? asset('storage/' . $book->cover_image) : null,
                    'url' => route('books.public.show', $book),
                    'created_at' => $book->created_at->format('d M Y')
                ];
            })
        ]);
    }

    /**
     * Get general statistics for the homepage
     */
    private function getGeneralStats()
    {
        $totalBooks = Book::where('status', 'approved')->count();
        $totalUsers = User::count();
        $totalAuthors = User::where('role', 'author')->count();
        
        // Calcul des téléchargements totaux
        $totalDownloads = Book::where('status', 'approved')->sum('downloads');
        
        // Calcul des vues totales
        $totalViews = Book::where('status', 'approved')->sum('views');
        
        // Nouveaux utilisateurs ce mois
        $newUsersThisMonth = User::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        
        // Nouveaux livres ce mois
        $newBooksThisMonth = Book::where('status', 'approved')
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();

        return [
            'total_books' => $totalBooks,
            'total_users' => $totalUsers,
            'total_authors' => $totalAuthors,
            'total_downloads' => $totalDownloads,
            'total_views' => $totalViews,
            'new_users_this_month' => $newUsersThisMonth,
            'new_books_this_month' => $newBooksThisMonth,
            'average_rating' => 4.6, // À implémenter avec un système de notation
        ];
    }

    /**
     * Get featured books (most popular and recent) with filtering
     */
    private function getFeaturedBooks(Request $request = null)
    {
        $baseQuery = Book::where('status', 'approved')->with('uploader');

        // Apply filters if provided
        if ($request) {
            // Filter by category
            if ($request->filled('category') && $request->category !== 'all') {
                $baseQuery->where('category', $request->category);
            }

            // Filter by language
            if ($request->filled('language') && $request->language !== 'all') {
                $baseQuery->where('language', $request->language);
            }

            // Filter by author
            if ($request->filled('author') && $request->author !== 'all') {
                $baseQuery->where('author_name', $request->author);
            }

            // Search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $baseQuery->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('author_name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }
        }

        // Livres les plus populaires (par téléchargements)
        $popularBooks = (clone $baseQuery)
            ->orderBy('downloads', 'desc')
            ->take(8)
            ->get();

        // Livres récents
        $recentBooks = (clone $baseQuery)
            ->latest()
            ->take(8)
            ->get();

        // Livres les plus vus
        $mostViewedBooks = (clone $baseQuery)
            ->orderBy('views', 'desc')
            ->take(8)
            ->get();

        return [
            'popular' => $popularBooks,
            'recent' => $recentBooks,
            'most_viewed' => $mostViewedBooks,
        ];
    }

    /**
     * Get featured authors with their statistics
     */
    private function getFeaturedAuthors()
    {
        return User::where('role', 'author')
            ->withCount(['books as approved_books_count' => function ($query) {
                $query->where('status', 'approved');
            }])
            ->with(['books' => function ($query) {
                $query->where('status', 'approved');
            }])
            ->having('approved_books_count', '>', 0)
            ->orderBy('approved_books_count', 'desc')
            ->take(8)
            ->get()
            ->map(function ($author) {
                $author->total_downloads = $author->books->sum('downloads');
                $author->total_views = $author->books->sum('views');
                return $author;
            });
    }

    /**
     * Get popular categories with book counts
     */
    private function getPopularCategories()
    {
        return Book::where('status', 'approved')
            ->whereNotNull('category')
            ->select('category', DB::raw('count(*) as books_count'))
            ->groupBy('category')
            ->orderBy('books_count', 'desc')
            ->take(8)
            ->get()
            ->map(function ($category) {
                // Ajouter des icônes pour chaque catégorie
                $category->icon = $this->getCategoryIcon($category->category);
                return $category;
            });
    }

    /**
     * Get recent activity for the homepage
     */
    private function getRecentActivity()
    {
        // Si le modèle ActivityLog existe, l'utiliser
        if (class_exists(ActivityLog::class)) {
            return ActivityLog::with('user')
                ->whereIn('action', ['download', 'view', 'register'])
                ->latest()
                ->take(10)
                ->get();
        }

        // Sinon, créer une activité basée sur les données existantes
        $recentBooks = Book::where('status', 'approved')
            ->with('uploader')
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()
            ->take(5)
            ->get();

        return collect([
            ...$recentBooks->map(function ($book) {
                return (object) [
                    'action' => 'book_published',
                    'description' => "Nouveau livre publié: {$book->title}",
                    'user' => $book->uploader,
                    'created_at' => $book->created_at,
                    'properties' => ['book_id' => $book->id],
                ];
            }),
            ...$recentUsers->map(function ($user) {
                return (object) [
                    'action' => 'user_registered',
                    'description' => "Nouvel utilisateur inscrit: {$user->name}",
                    'user' => $user,
                    'created_at' => $user->created_at,
                    'properties' => [],
                ];
            })
        ])->sortByDesc('created_at')->take(10);
    }

    /**
     * Get icon for category
     */
    private function getCategoryIcon($category)
    {
        $icons = [
            'Fiction' => 'fas fa-magic',
            'Science' => 'fas fa-flask',
            'Histoire' => 'fas fa-landmark',
            'Biographie' => 'fas fa-user',
            'Technologie' => 'fas fa-laptop-code',
            'Art' => 'fas fa-palette',
            'Cuisine' => 'fas fa-utensils',
            'Voyage' => 'fas fa-plane',
            'Santé' => 'fas fa-heartbeat',
            'Business' => 'fas fa-briefcase',
            'Education' => 'fas fa-graduation-cap',
            'Religion' => 'fas fa-pray',
            'Sport' => 'fas fa-running',
            'Musique' => 'fas fa-music',
        ];

        return $icons[$category] ?? 'fas fa-book';
    }

    /**
     * Get trending data for AJAX requests
     */
    public function getTrendingData()
    {
        $trendingBooks = Book::where('status', 'approved')
            ->where('created_at', '>=', Carbon::now()->subWeek())
            ->with('uploader')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        $trendingAuthors = User::where('role', 'author')
            ->whereHas('books', function ($query) {
                $query->where('status', 'approved')
                    ->where('created_at', '>=', Carbon::now()->subWeek());
            })
            ->withCount(['books as recent_books_count' => function ($query) {
                $query->where('status', 'approved')
                    ->where('created_at', '>=', Carbon::now()->subWeek());
            }])
            ->orderBy('recent_books_count', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'trending_books' => $trendingBooks,
            'trending_authors' => $trendingAuthors,
            'timestamp' => now()->format('H:i:s'),
        ]);
    }
}
