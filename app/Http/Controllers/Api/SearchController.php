<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Recherche intelligente avec suggestions
     */
    public function suggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'books' => [],
                'subjects' => [],
                'authors' => [],
                'suggestions' => []
            ]);
        }
        
        // Cache des résultats pendant 5 minutes
        $cacheKey = "search_suggestions_" . md5($query);
        
        return Cache::remember($cacheKey, 300, function() use ($query) {
            
            // Suggestions de livres
            $books = Book::where('status', 'approved')
                ->where(function($q) use ($query) {
                    $q->where('title', 'LIKE', "%$query%")
                      ->orWhere('author', 'LIKE', "%$query%")
                      ->orWhere('description', 'LIKE', "%$query%");
                })
                ->select('id', 'title', 'author', 'category', 'cover_path', 'price', 'language')
                ->orderBy('views', 'desc')
                ->take(8)
                ->get()
                ->map(function($book) {
                    return [
                        'id' => $book->id,
                        'title' => $book->title,
                        'author' => $book->author,
                        'subject' => $book->category,
                        'cover' => $book->cover_path,
                        'price' => $book->price,
                        'language' => $book->language,
                        'type' => 'book'
                    ];
                });
                
            // Suggestions de matières
            $subjects = Book::where('status', 'approved')
                ->where('category', 'LIKE', "%$query%")
                ->select('category', DB::raw('COUNT(*) as count'))
                ->groupBy('category')
                ->orderBy('count', 'desc')
                ->take(5)
                ->get()
                ->map(function($item) {
                    return [
                        'name' => $item->category,
                        'count' => $item->count,
                        'type' => 'subject'
                    ];
                });
                
            // Suggestions d'auteurs
            $authors = User::where('role', 'author')
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', "%$query%")
                      ->orWhere('author_name', 'LIKE', "%$query%");
                })
                ->withCount(['books' => function($q) {
                    $q->where('status', 'approved');
                }])
                ->having('books_count', '>', 0)
                ->take(3)
                ->get()
                ->map(function($author) {
                    return [
                        'id' => $author->id,
                        'name' => $author->author_name ?? $author->name,
                        'books_count' => $author->books_count,
                        'avatar' => $author->profile_photo_path,
                        'type' => 'author'
                    ];
                });
                
            // Suggestions contextuelles intelligentes
            $contextualSuggestions = $this->getContextualSuggestions($query);
            
            return [
                'books' => $books,
                'subjects' => $subjects,
                'authors' => $authors,
                'suggestions' => $contextualSuggestions
            ];
        });
    }
    
    /**
     * Recherche avancée avec filtres
     */
    public function advanced(Request $request)
    {
        $query = Book::where('status', 'approved')->with(['uploader']);
        
        // Recherche textuelle
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%")
                  ->orWhere('description', 'LIKE', "%$search%")
                  ->orWhere('author', 'LIKE', "%$search%");
            });
        }
        
        // Filtrage par niveau éducatif
        if ($request->filled('level')) {
            $query->where('category', 'LIKE', '%' . $request->level . '%');
        }
        
        // Filtrage par matière
        if ($request->filled('subject')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->subject . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->subject . '%')
                  ->orWhere('category', 'LIKE', '%' . $request->subject . '%');
            });
        }
        
        // Filtrage par langue
        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }
        
        // Filtrage par type de contenu
        if ($request->filled('content_type')) {
            $type = $request->content_type;
            switch($type) {
                case 'manuel':
                    $query->where('title', 'LIKE', '%manuel%');
                    break;
                case 'exercices':
                    $query->where(function($q) {
                        $q->where('title', 'LIKE', '%exercice%')
                          ->orWhere('title', 'LIKE', '%corrigé%');
                    });
                    break;
                case 'resume':
                    $query->where('title', 'LIKE', '%résumé%');
                    break;
                case 'annales':
                    $query->where('title', 'LIKE', '%annale%');
                    break;
                case 'audio':
                    $query->where('title', 'LIKE', '%audio%');
                    break;
                case 'video':
                    $query->where('title', 'LIKE', '%vidéo%');
                    break;
            }
        }
        
        // Filtrage par région (basé sur la description pour l'instant)
        if ($request->filled('region')) {
            $query->where('description', 'LIKE', '%' . $request->region . '%');
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
        
        // Tri des résultats
        $sortBy = $request->get('sort', 'relevance');
        switch ($sortBy) {
            case 'date':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('downloads', 'desc');
                break;
            case 'rating':
                $query->orderBy('views', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            default:
                // Tri par pertinence (vues + téléchargements)
                $query->orderByRaw('(views + downloads) DESC');
        }
        
        // Pagination
        $perPage = $request->get('per_page', 24);
        $results = $query->paginate($perPage);
        
        return response()->json([
            'data' => $results->items(),
            'pagination' => [
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'per_page' => $results->perPage(),
                'total' => $results->total(),
                'from' => $results->firstItem(),
                'to' => $results->lastItem(),
            ],
            'filters_applied' => $request->except(['page', 'per_page']),
            'total_results' => $results->total()
        ]);
    }
    
    /**
     * Suggestions IA contextuelles (simulation avancée)
     */
    private function getContextualSuggestions($query)
    {
        $suggestions = [];
        
        // Détection de mots-clés pour suggestions intelligentes
        $query_lower = strtolower($query);
        
        // Suggestions pour les mathématiques
        if (strpos($query_lower, 'math') !== false || strpos($query_lower, 'calcul') !== false) {
            $suggestions[] = [
                'text' => 'Mathématiques avec exemples de commerce ivoirien',
                'icon' => 'fas fa-calculator',
                'color' => 'blue',
                'type' => 'contextual'
            ];
        }
        
        // Suggestions pour les examens
        if (strpos($query_lower, 'bac') !== false || strpos($query_lower, 'bepc') !== false || strpos($query_lower, 'examen') !== false) {
            $suggestions[] = [
                'text' => 'Plan de révision personnalisé pour votre examen',
                'icon' => 'fas fa-graduation-cap',
                'color' => 'green',
                'type' => 'study_plan'
            ];
        }
        
        // Suggestions pour les langues locales
        if (strpos($query_lower, 'dioula') !== false || strpos($query_lower, 'baoulé') !== false) {
            $suggestions[] = [
                'text' => 'Contes traditionnels en langues locales',
                'icon' => 'fas fa-book-open',
                'color' => 'amber',
                'type' => 'cultural'
            ];
        }
        
        // Suggestions économiques
        if (strpos($query_lower, 'cher') !== false || strpos($query_lower, 'prix') !== false || strpos($query_lower, 'gratuit') !== false) {
            $suggestions[] = [
                'text' => 'Trouvez un parrain pour financer vos études',
                'icon' => 'fas fa-handshake',
                'color' => 'emerald',
                'type' => 'solidarity'
            ];
        }
        
        // Suggestions générales si pas de contexte spécifique
        if (empty($suggestions)) {
            $suggestions = [
                [
                    'text' => 'Livres recommandés pour votre niveau',
                    'icon' => 'fas fa-star',
                    'color' => 'yellow',
                    'type' => 'recommendation'
                ],
                [
                    'text' => 'Découvrez nos nouveautés',
                    'icon' => 'fas fa-sparkles',
                    'color' => 'purple',
                    'type' => 'discovery'
                ]
            ];
        }
        
        return $suggestions;
    }
    
    /**
     * Autocomplete rapide pour la barre de recherche
     */
    public function autocomplete(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        // Cache court pour l'autocomplete (2 minutes)
        $cacheKey = "autocomplete_" . md5($query);
        
        return Cache::remember($cacheKey, 120, function() use ($query) {
            
            $results = [];
            
            // Titres de livres
            $bookTitles = Book::where('status', 'approved')
                ->where('title', 'LIKE', "$query%")
                ->select('title')
                ->distinct()
                ->take(5)
                ->pluck('title');
                
            foreach($bookTitles as $title) {
                $results[] = [
                    'text' => $title,
                    'type' => 'title',
                    'icon' => 'fas fa-book'
                ];
            }
            
            // Auteurs
            $authors = Book::where('status', 'approved')
                ->where('author', 'LIKE', "$query%")
                ->select('author')
                ->distinct()
                ->take(3)
                ->pluck('author');
                
            foreach($authors as $author) {
                $results[] = [
                    'text' => $author,
                    'type' => 'author',
                    'icon' => 'fas fa-user'
                ];
            }
            
            // Catégories
            $categories = Book::where('status', 'approved')
                ->where('category', 'LIKE', "$query%")
                ->select('category')
                ->distinct()
                ->take(3)
                ->pluck('category');
                
            foreach($categories as $category) {
                $results[] = [
                    'text' => $category,
                    'type' => 'category',
                    'icon' => 'fas fa-tag'
                ];
            }
            
            return array_slice($results, 0, 8);
        });
    }
}