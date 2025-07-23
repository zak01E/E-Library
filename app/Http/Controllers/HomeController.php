<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\ActivityLog;
use App\Http\Traits\BookFilterTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    use BookFilterTrait;
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

        // Obtenir les options de filtres en utilisant le trait
        $filterOptions = $this->getFilterOptions();

        return view('home', [
            'stats' => $stats,
            'featuredBooks' => $featuredBooks,
            'featuredAuthors' => $featuredAuthors,
            'popularCategories' => $popularCategories,
            'recentActivity' => $recentActivity,
            'categories' => $filterOptions['categories'],
            'languages' => $filterOptions['languages'],
            'authors' => $filterOptions['authors'],
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

        // Apply filters if provided using the trait
        if ($request) {
            $baseQuery = $this->applyBookFilters($baseQuery, $request);
        }

        // Vérifier le nombre total de livres disponibles
        $totalBooks = (clone $baseQuery)->count();

        // Ajuster le nombre de livres par section selon le total disponible
        $booksPerSection = min(8, max(1, floor($totalBooks / 3)));

        // Si on a moins de 6 livres, on limite à 2 par section pour éviter trop de répétitions
        if ($totalBooks < 6) {
            $booksPerSection = min(2, $totalBooks);
        }

        // Livres les plus populaires (par téléchargements)
        $popularBooks = (clone $baseQuery)
            ->orderBy('downloads', 'desc')
            ->take($booksPerSection)
            ->get();

        // Livres récents (exclure les populaires déjà sélectionnés)
        $popularIds = $popularBooks->pluck('id')->toArray();
        $recentBooks = (clone $baseQuery)
            ->whereNotIn('id', $popularIds)
            ->latest()
            ->take($booksPerSection)
            ->get();

        // Livres les plus vus (exclure les déjà sélectionnés)
        $usedIds = array_merge($popularIds, $recentBooks->pluck('id')->toArray());
        $mostViewedBooks = (clone $baseQuery)
            ->whereNotIn('id', $usedIds)
            ->orderBy('views', 'desc')
            ->take($booksPerSection)
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
