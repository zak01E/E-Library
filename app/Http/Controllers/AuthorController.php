<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is-author']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total_books' => $user->books()->count(),
            'approved_books' => $user->books()->where('status', 'approved')->count(),
            'pending_books' => $user->books()->where('status', 'pending')->count(),
            'rejected_books' => $user->books()->where('status', 'rejected')->count(),
            'total_downloads' => $user->books()->sum('downloads'),
            'total_views' => $user->books()->sum('views'),
        ];

        $recent_books = $user->books()
            ->latest()
            ->take(5)
            ->get();

        $popular_books = $user->books()
            ->orderBy('downloads', 'desc')
            ->take(5)
            ->get();

        $books_by_category = $user->books()
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();

        $monthly_stats = $user->books()
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subYear())
            ->groupBy('month', 'year')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return view('author.dashboard', compact(
            'stats',
            'recent_books',
            'popular_books',
            'books_by_category',
            'monthly_stats'
        ));
    }

    public function books(Request $request)
    {
        $query = Auth::user()->books();

        // Filtrer par statut si spécifié
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filtrer par catégorie si spécifié
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Trier par date de création (plus récent en premier par défaut)
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $books = $query->paginate(10)->appends($request->query());

        // Récupérer les catégories pour le filtre
        $categories = Auth::user()->books()->distinct()->pluck('category')->filter();

        return view('author.books', compact('books', 'categories'));
    }

    public function showBook(Book $book)
    {
        // Vérifier que le livre appartient à l'auteur connecté
        if ($book->uploaded_by !== Auth::id()) {
            abort(403, 'Vous n\'avez pas accès à ce livre.');
        }

        return view('author.book-details', compact('book'));
    }

    public function analytics()
    {
        $user = Auth::user();
        
        $books = $user->books()
            ->select('id', 'title', 'downloads', 'views', 'created_at')
            ->get();

        $total_engagement = [
            'downloads' => $books->sum('downloads'),
            'views' => $books->sum('views'),
            'avg_downloads' => $books->avg('downloads') ?? 0,
            'avg_views' => $books->avg('views') ?? 0,
        ];

        return view('author.analytics', compact('books', 'total_engagement'));
    }

    public function analyticsDownloads()
    {
        $user = Auth::user();

        // Statistiques des téléchargements
        $stats = [
            'total_downloads' => $user->books()->sum('downloads'),
            'this_month' => 45, // Simulé
            'this_week' => 12, // Simulé
            'today' => 3, // Simulé
            'avg_per_book' => $user->books()->count() > 0 ? round($user->books()->sum('downloads') / $user->books()->count()) : 0,
        ];

        // Données pour les graphiques
        $dailyDownloads = [
            'labels' => ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            'data' => [5, 8, 3, 12, 7, 15, 9]
        ];

        $bookDownloads = $user->books()->select('title', 'downloads')->orderBy('downloads', 'desc')->get();

        return view('author.analytics.downloads', compact('stats', 'dailyDownloads', 'bookDownloads'));
    }

    public function analyticsViews()
    {
        $user = Auth::user();

        // Statistiques des vues
        $stats = [
            'total_views' => $user->books()->sum('views'),
            'this_month' => 234, // Simulé
            'this_week' => 67, // Simulé
            'today' => 15, // Simulé
            'avg_per_book' => $user->books()->count() > 0 ? round($user->books()->sum('views') / $user->books()->count()) : 0,
        ];

        // Données pour les graphiques
        $hourlyViews = [
            'labels' => ['00h', '04h', '08h', '12h', '16h', '20h'],
            'data' => [2, 1, 8, 15, 12, 6]
        ];

        $bookViews = $user->books()->select('title', 'views')->orderBy('views', 'desc')->get();

        return view('author.analytics.views', compact('stats', 'hourlyViews', 'bookViews'));
    }

    public function analyticsReaders()
    {
        $user = Auth::user();

        // Statistiques des lecteurs
        $stats = [
            'unique_readers' => 156, // Simulé
            'returning_readers' => 89, // Simulé
            'new_readers' => 67, // Simulé
            'avg_session_time' => '12m 34s', // Simulé
            'bounce_rate' => '23%', // Simulé
        ];

        // Données démographiques simulées
        $demographics = [
            'age_groups' => [
                '18-24' => 15,
                '25-34' => 35,
                '35-44' => 28,
                '45-54' => 15,
                '55+' => 7
            ],
            'countries' => [
                'France' => 45,
                'Canada' => 20,
                'Belgique' => 15,
                'Suisse' => 12,
                'Autres' => 8
            ]
        ];

        return view('author.analytics.readers', compact('stats', 'demographics'));
    }

    public function editBook(Book $book)
    {
        if ($book->uploaded_by !== Auth::id()) {
            abort(403);
        }

        return view('author.edit-book', compact('book'));
    }

    public function createBook()
    {
        return view('books.create');
    }

    public function updateBook(Request $request, Book $book)
    {
        if ($book->uploaded_by !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'language' => 'required|string|max:50',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|string|max:20',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB max
        ]);

        // Prepare update data
        $updateData = $request->only([
            'title', 'author_name', 'description',
            'category', 'language', 'publication_year', 'isbn'
        ]);

        // Handle cover image removal
        if ($request->has('remove_cover') && $book->cover_image) {
            // Delete old cover image
            if (\Storage::disk('public')->exists($book->cover_image)) {
                \Storage::disk('public')->delete($book->cover_image);
            }
            $updateData['cover_image'] = null;
        }
        // Handle new cover image upload
        elseif ($request->hasFile('cover_image')) {
            // Delete old cover image if exists
            if ($book->cover_image && \Storage::disk('public')->exists($book->cover_image)) {
                \Storage::disk('public')->delete($book->cover_image);
            }

            // Store new cover image
            $coverPath = $request->file('cover_image')->store('books/covers', 'public');
            $updateData['cover_image'] = $coverPath;
        }

        $book->update($updateData);

        return redirect()->route('author.books')
            ->with('success', 'Livre mis à jour avec succès.');
    }

    public function deleteBook(Book $book)
    {
        if ($book->uploaded_by !== Auth::id()) {
            abort(403);
        }

        $book->delete();

        return redirect()->route('author.books')
            ->with('success', 'Livre supprimé avec succès.');
    }

    // Revenue methods
    public function revenue()
    {
        $user = Auth::user();

        $stats = [
            'total_earnings' => 0, // À implémenter avec un système de revenus
            'this_month' => 0,
            'pending_payouts' => 0,
            'total_sales' => $user->books()->sum('downloads'), // Approximation
        ];

        $monthly_earnings = []; // À implémenter avec des données réelles

        return view('author.revenue.index', compact('stats', 'monthly_earnings'));
    }

    public function revenueReports()
    {
        return view('author.revenue.reports');
    }

    public function payouts()
    {
        return view('author.revenue.payouts');
    }

    // Promotions methods
    public function promotions()
    {
        return view('author.promotions.index');
    }

    public function createPromotion()
    {
        return view('author.promotions.create');
    }

    public function storePromotion(Request $request)
    {
        // À implémenter
        return redirect()->route('author.promotions')->with('success', 'Promotion créée avec succès.');
    }

    public function promotionsHistory()
    {
        return view('author.promotions.history');
    }

    // Tools methods
    public function tools()
    {
        return view('author.tools.index');
    }

    public function writingTools()
    {
        return view('author.tools.writing');
    }

    public function marketingTools()
    {
        return view('author.tools.marketing');
    }

    // Collections methods
    public function collections()
    {
        return view('author.collections.index');
    }

    public function createCollection()
    {
        return view('author.collections.create');
    }

    public function storeCollection(Request $request)
    {
        // À implémenter
        return redirect()->route('author.collections')->with('success', 'Collection créée avec succès.');
    }

    // Reviews methods
    public function reviews()
    {
        $user = Auth::user();

        // Récupérer tous les avis sur les livres de l'auteur
        // Pour l'instant, on simule des données
        $stats = [
            'total_reviews' => 0,
            'average_rating' => 0,
            'five_star' => 0,
            'four_star' => 0,
            'three_star' => 0,
            'two_star' => 0,
            'one_star' => 0,
            'recent_reviews' => 0,
        ];

        $reviews = collect(); // Collection vide pour l'instant

        return view('author.reviews.index', compact('stats', 'reviews'));
    }

    public function showReview($reviewId)
    {
        // À implémenter - afficher un avis spécifique
        return view('author.reviews.show');
    }

    public function respondToReview(Request $request, $reviewId)
    {
        // À implémenter - répondre à un avis
        return redirect()->back()->with('success', 'Réponse ajoutée avec succès.');
    }

    // Support methods
    public function support()
    {
        $user = Auth::user();

        // Statistiques de support
        $stats = [
            'open_tickets' => 0,
            'resolved_tickets' => 0,
            'avg_response_time' => '2h',
            'satisfaction_rate' => 95,
        ];

        // Tickets récents (simulés)
        $recentTickets = collect();

        return view('author.support.index', compact('stats', 'recentTickets'));
    }

    public function createSupportTicket(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'category' => 'required|string',
            'priority' => 'required|string',
            'message' => 'required|string',
        ]);

        // À implémenter - créer un ticket de support
        return redirect()->route('author.support')->with('success', 'Ticket créé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }

    public function faq()
    {
        return view('author.support.faq');
    }
}