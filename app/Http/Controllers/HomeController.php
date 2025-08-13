<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\ActivityLog;
use App\Http\Traits\BookFilterTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class HomeController extends Controller
{
    use BookFilterTrait;
    
    /**
     * Display the home page with real data
     */
    public function index(Request $request)
    {
        // Statistiques générales avec cache
        $stats = Cache::remember('homepage_stats', 300, function() {
            return $this->getGeneralStats();
        });

        // Catégories éducatives ivoiriennes
        $ivorianEducationCategories = $this->getIvorianEducationCategories();
        
        // Langues et régions
        $languageStats = $this->getLanguageStats();
        $regionStats = $this->getRegionStats();
        
        // Livres avec filtrage appliqué
        $filteredBooks = $this->getFilteredBooks($request);

        // Livres en vedette (populaires, récents, plus vus)
        $featuredBooks = Cache::remember('featured_books', 300, function() {
            return $this->getFeaturedBooks();
        });

        // Suggestions IA (simulé pour l'instant)
        $aiSuggestions = $this->getAISuggestions($request);

        // Auteurs en vedette
        $featuredAuthors = Cache::remember('featured_authors', 600, function() {
            return $this->getFeaturedAuthors();
        });

        // Options de filtres avancés
        $filterOptions = $this->getAdvancedFilterOptions();

        // Catégories populaires
        $popularCategories = Cache::remember('popular_categories', 600, function() {
            return $this->getPopularCategories();
        });

        // Activité récente
        $recentActivity = Cache::remember('recent_activity', 120, function() {
            return $this->getRecentActivity();
        });

        return view('home', [
            'stats' => $stats,
            'ivorianEducationCategories' => $ivorianEducationCategories,
            'languageStats' => $languageStats,
            'regionStats' => $regionStats,
            'filteredBooks' => $filteredBooks,
            'featuredBooks' => $featuredBooks,
            'aiSuggestions' => $aiSuggestions,
            'featuredAuthors' => $featuredAuthors,
            'filterOptions' => $filterOptions,
            'popularCategories' => $popularCategories,
            'recentActivity' => $recentActivity,
            'appliedFilters' => $request->all(),
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
        // Nombre fixe de livres à afficher par section
        $booksPerSection = 24; // 4 colonnes x 6 lignes

        // Livres récents
        $recentBooks = Book::where('status', 'approved')
            ->with(['uploader'])
            ->latest()
            ->limit($booksPerSection)
            ->get();

        // Livres populaires (par téléchargements)
        $popularBooks = Book::where('status', 'approved')
            ->with(['uploader'])
            ->orderBy('downloads', 'desc')
            ->limit($booksPerSection)
            ->get();

        // Livres les plus vus
        $mostViewedBooks = Book::where('status', 'approved')
            ->with(['uploader'])
            ->orderBy('views', 'desc')
            ->limit($booksPerSection)
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
     * Get Ivorian education categories
     */
    private function getIvorianEducationCategories()
    {
        return [
            'prescolaire' => [
                'name' => 'Préscolaire (3-5 ans)',
                'subjects' => ['Éveil', 'Comptines', 'Dessins', 'Jeux éducatifs'],
                'languages' => ['Français', 'Dioula', 'Baoulé'],
                'books_count' => Book::where('category', 'LIKE', '%préscolaire%')->count(),
                'icon' => 'fas fa-baby',
                'color' => 'pink'
            ],
            
            'primaire' => [
                'name' => 'Primaire (CP1-CM2)',
                'levels' => [
                    'cp1' => ['Lecture', 'Écriture', 'Calcul', 'Éveil scientifique'],
                    'cp2' => ['Français', 'Mathématiques', 'Éveil', 'Éducation civique'],
                    'ce1' => ['Français', 'Mathématiques', 'Histoire-Géo', 'Sciences'],
                    'ce2' => ['Français', 'Mathématiques', 'Histoire-Géo', 'Sciences', 'Anglais'],
                    'cm1' => ['Français', 'Mathématiques', 'Histoire-Géo', 'Sciences', 'Anglais', 'EPS'],
                    'cm2' => ['Français', 'Mathématiques', 'Histoire-Géo', 'Sciences', 'Anglais', 'Éducation civique'],
                ],
                'books_count' => Book::where('category', 'LIKE', '%primaire%')->count(),
                'icon' => 'fas fa-child',
                'color' => 'yellow'
            ],
            
            'college' => [
                'name' => 'Collège (6ème-3ème)',
                'levels' => [
                    '6eme' => ['Français', 'Maths', 'Anglais', 'Histoire-Géo', 'SVT', 'Technologie'],
                    '5eme' => ['Français', 'Maths', 'Anglais', 'Histoire-Géo', 'SVT', 'Physique-Chimie'],
                    '4eme' => ['Français', 'Maths', 'Anglais', 'Histoire-Géo', 'SVT', 'Physique-Chimie', 'Espagnol'],
                    '3eme' => ['Français', 'Maths', 'Anglais', 'Histoire-Géo', 'SVT', 'Physique-Chimie', 'BEPC'],
                ],
                'books_count' => Book::where('category', 'LIKE', '%collège%')->orWhere('category', 'LIKE', '%college%')->count(),
                'icon' => 'fas fa-school',
                'color' => 'green'
            ],
            
            'lycee' => [
                'name' => 'Lycée (2nde-Terminale)',
                'series' => ['A (Littéraire)', 'C (Scientifique)', 'D (Sciences Naturelles)', 'G (Économique)'],
                'levels' => [
                    '2nde' => ['Français', 'Maths', 'Anglais', 'Histoire-Géo', 'SVT', 'Physique-Chimie'],
                    '1ere' => ['Philosophie', 'Français', 'Maths', 'Anglais', 'Spécialités selon série'],
                    'terminale' => ['Philosophie', 'Matières spécialisées', 'Préparation BAC'],
                ],
                'books_count' => Book::where('category', 'LIKE', '%lycée%')->orWhere('category', 'LIKE', '%lycee%')->count(),
                'icon' => 'fas fa-graduation-cap',
                'color' => 'blue'
            ],
            
            'superieur' => [
                'name' => 'Enseignement Supérieur',
                'types' => [
                    'university' => ['Lettres', 'Sciences', 'Médecine', 'Droit', 'Économie'],
                    'grandes_ecoles' => ['ENS', 'INPHB', 'ESC', 'ESATIC', 'ENSEA'],
                    'professional' => ['BTS', 'DUT', 'Licence Pro', 'Masters'],
                ],
                'books_count' => Book::where('category', 'LIKE', '%supérieur%')->orWhere('category', 'LIKE', '%universitaire%')->count(),
                'icon' => 'fas fa-university',
                'color' => 'purple'
            ],
            
            'formation_professionnelle' => [
                'name' => 'Formation Professionnelle',
                'sectors' => ['Agriculture', 'Artisanat', 'Commerce', 'Tourisme', 'Informatique'],
                'certifications' => ['CAP', 'BEP', 'Brevet de Maîtrise'],
                'books_count' => Book::where('category', 'LIKE', '%formation%')->orWhere('category', 'LIKE', '%professionnel%')->count(),
                'icon' => 'fas fa-tools',
                'color' => 'orange'
            ],
            
            'langues_nationales' => [
                'name' => 'Langues et Cultures Nationales',
                'languages' => [
                    'dioula' => ['Grammaire', 'Littérature', 'Contes', 'Chants traditionnels'],
                    'baoule' => ['Grammaire', 'Proverbes', 'Histoires', 'Traditions'],
                    'bete' => ['Langue', 'Culture', 'Traditions orales'],
                    'senoufo' => ['Langue', 'Artisanat traditionnel', 'Musique'],
                    'dan' => ['Langue', 'Masques', 'Danses traditionnelles'],
                    'malinke' => ['Langue', 'Épopées', 'Musique traditionnelle']
                ],
                'books_count' => Book::where('language', '!=', 'Français')->count(),
                'icon' => 'fas fa-language',
                'color' => 'amber'
            ],
            
            'economie_locale' => [
                'name' => 'Économie et Développement Ivoirien',
                'topics' => [
                    'agriculture' => ['Cacao', 'Café', 'Hévéa', 'Coton', 'Palmier à huile'],
                    'industrie' => ['Agroalimentaire', 'Textile', 'BTP', 'Mines'],
                    'services' => ['Banque', 'Assurance', 'Transport', 'Télécoms'],
                    'entrepreneuriat' => ['Création entreprise', 'Microfinance', 'Commerce']
                ],
                'books_count' => Book::where('category', 'LIKE', '%économie%')->orWhere('category', 'LIKE', '%business%')->count(),
                'icon' => 'fas fa-chart-line',
                'color' => 'emerald'
            ]
        ];
    }
    
    /**
     * Get language statistics
     */
    private function getLanguageStats()
    {
        return [
            'fr' => [
                'name' => 'Français',
                'flag' => '🇫🇷',
                'users_count' => 85,
                'books_count' => Book::where('language', 'Français')->count()
            ],
            'dyu' => [
                'name' => 'Dioula',
                'flag' => '🇨🇮',
                'users_count' => 17,
                'books_count' => Book::where('language', 'Dioula')->count()
            ],
            'bci' => [
                'name' => 'Baoulé',
                'flag' => '🇨🇮',
                'users_count' => 15,
                'books_count' => Book::where('language', 'Baoulé')->count()
            ],
            'en' => [
                'name' => 'Anglais',
                'flag' => '🇬🇧',
                'users_count' => 12,
                'books_count' => Book::where('language', 'Anglais')->count()
            ]
        ];
    }
    
    /**
     * Get region statistics
     */
    private function getRegionStats()
    {
        $regions = [
            'Abidjan', 'Bouaké', 'Yamoussoukro', 'Daloa', 'San-Pédro', 
            'Korhogo', 'Man', 'Gagnoa', 'Divo', 'Anyama'
        ];
        
        $stats = [];
        foreach ($regions as $region) {
            $stats[strtolower(str_replace('-', '_', $region))] = [
                'name' => $region,
                'users_count' => rand(500, 15000), // TODO: Remplacer par vraies données
                'books_count' => Book::where('description', 'LIKE', "%$region%")->count()
            ];
        }
        
        return $stats;
    }
    
    /**
     * Get filtered books based on request parameters
     */
    private function getFilteredBooks(Request $request)
    {
        $query = Book::where('status', 'approved')->with(['uploader']);
        
        // Filtrage par niveau
        if ($request->filled('level')) {
            $query->where('category', 'LIKE', '%' . $request->level . '%');
        }
        
        // Filtrage par matière
        if ($request->filled('subject')) {
            $query->where('title', 'LIKE', '%' . $request->subject . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->subject . '%');
        }
        
        // Filtrage par langue
        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }
        
        // Filtrage par prix
        if ($request->filled('price_range')) {
            switch ($request->price_range) {
                case 'gratuit':
                    $query->where('price', 0);
                    break;
                case '0-500':
                    $query->whereBetween('price', [0, 500]);
                    break;
                case '500-1000':
                    $query->whereBetween('price', [500, 1000]);
                    break;
                case '1000-2000':
                    $query->whereBetween('price', [1000, 2000]);
                    break;
                case '2000+':
                    $query->where('price', '>', 2000);
                    break;
            }
        }
        
        // Recherche textuelle
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%")
                  ->orWhere('description', 'LIKE', "%$search%")
                  ->orWhere('author', 'LIKE', "%$search%");
            });
        }
        
        // Tri
        $sortBy = $request->get('sort', 'relevance');
        switch ($sortBy) {
            case 'date':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('downloads', 'desc');
                break;
            case 'rating':
                $query->orderBy('views', 'desc'); // TODO: Remplacer par rating réel
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
        
        return $query->paginate(24);
    }
    
    /**
     * Get AI suggestions (simulated for now)
     */
    private function getAISuggestions(Request $request)
    {
        return [
            [
                'type' => 'question',
                'text' => 'Comment réviser mon bac en 2 mois?',
                'category' => 'study_tips',
                'icon' => 'fas fa-lightbulb',
                'color' => 'purple'
            ],
            [
                'type' => 'contextual',
                'text' => 'Mathématiques avec exemples ivoiriens',
                'category' => 'local_context',
                'icon' => 'fas fa-map-marked-alt',
                'color' => 'emerald'
            ],
            [
                'type' => 'social',
                'text' => 'Trouve-moi un parrain pour mes études',
                'category' => 'solidarity',
                'icon' => 'fas fa-handshake',
                'color' => 'yellow'
            ]
        ];
    }
    
    /**
     * Get advanced filter options
     */
    private function getAdvancedFilterOptions()
    {
        return [
            'subjects' => [
                'francais' => 'Français',
                'mathematiques' => 'Mathématiques',
                'anglais' => 'Anglais',
                'histoire-geo' => 'Histoire-Géographie',
                'sciences' => 'Sciences',
                'philosophie' => 'Philosophie',
                'economie' => 'Économie'
            ],
            'languages' => $this->getLanguageStats(),
            'regions' => array_keys($this->getRegionStats()),
            'content_types' => [
                'manuel' => '📘 Manuels scolaires',
                'exercices' => '✏️ Exercices & Corrigés',
                'resume' => '📝 Résumés de cours',
                'annales' => '📋 Annales d\'examens',
                'audio' => '🎵 Livres audio',
                'video' => '🎥 Cours vidéo'
            ],
            'price_ranges' => [
                'gratuit' => '🆓 Gratuit',
                '0-500' => '💰 0 - 500 FCFA',
                '500-1000' => '💰 500 - 1000 FCFA',
                '1000-2000' => '💰 1000 - 2000 FCFA',
                '2000+' => '💰 Plus de 2000 FCFA'
            ]
        ];
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
    
    /**
     * API endpoint for search suggestions
     */
    public function getSearchSuggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json(['books' => [], 'subjects' => [], 'authors' => []]);
        }
        
        // Suggestions de livres
        $books = Book::where('status', 'approved')
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%$query%")
                  ->orWhere('author', 'LIKE', "%$query%");
            })
            ->select('id', 'title', 'author', 'category', 'cover_path')
            ->take(5)
            ->get()
            ->map(function($book) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'subject' => $book->category,
                    'cover' => $book->cover_path
                ];
            });
            
        // Suggestions de matières
        $subjects = Book::where('status', 'approved')
            ->where('category', 'LIKE', "%$query%")
            ->select('category')
            ->groupBy('category')
            ->get()
            ->map(function($item) {
                return [
                    'name' => $item->category,
                    'count' => Book::where('category', $item->category)->count()
                ];
            })
            ->take(3);
            
        return response()->json([
            'books' => $books,
            'subjects' => $subjects,
            'authors' => []
        ]);
    }
}
