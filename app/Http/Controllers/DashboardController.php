<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Affiche le dashboard approprié selon le rôle de l'utilisateur
     * SANS REDIRECTION - Affiche directement la vue appropriée
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Afficher directement le dashboard approprié selon le rôle
        // SANS FAIRE DE REDIRECTION
        switch ($user->role) {
            case 'admin':
                return $this->adminDashboard();
                
            case 'author':
                return $this->authorDashboard();
                
            case 'user':
            default:
                return $this->userDashboard();
        }
    }

    /**
     * Dashboard pour les administrateurs
     */
    private function adminDashboard()
    {
        // Vérifier que l'utilisateur est bien admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Accès non autorisé');
        }

        $stats = [
            'total_books' => Book::count(),
            'approved_books' => Book::where('is_approved', true)->count(),
            'pending_books' => Book::where('is_approved', false)->count(),
            'total_users' => User::count(),
            'authors' => User::where('role', 'author')->count(),
            'regular_users' => User::where('role', 'user')->count(),
            'total_downloads' => Book::sum('downloads'),
            'total_views' => Book::sum('views'),
        ];

        $recent_books = Book::with('uploader')
            ->latest()
            ->take(5)
            ->get();

        $pending_books = Book::with('uploader')
            ->where('is_approved', false)
            ->latest()
            ->take(5)
            ->get();

        $top_books = Book::orderBy('downloads', 'desc')
            ->take(5)
            ->get();

        $users_by_role = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get();

        return view('dashboard.admin', compact('stats', 'recent_books', 'pending_books', 'top_books', 'users_by_role'));
    }

    /**
     * Dashboard pour les auteurs
     */
    private function authorDashboard()
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur est bien auteur
        if ($user->role !== 'author') {
            abort(403, 'Accès non autorisé');
        }

        $stats = [
            'my_books' => Book::where('uploaded_by', $user->id)->count(),
            'approved_books' => Book::where('uploaded_by', $user->id)->where('is_approved', true)->count(),
            'pending_books' => Book::where('uploaded_by', $user->id)->where('is_approved', false)->count(),
            'rejected_books' => Book::where('uploaded_by', $user->id)->where('status', 'rejected')->count(),
            'total_downloads' => Book::where('uploaded_by', $user->id)->sum('downloads'),
            'total_views' => Book::where('uploaded_by', $user->id)->sum('views'),
            'total_revenue' => 0, // À implémenter selon votre logique de revenus
            'this_month_downloads' => Book::where('uploaded_by', $user->id)
                ->whereMonth('created_at', date('m'))
                ->sum('downloads'),
        ];

        $my_books = Book::where('uploaded_by', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $top_books = Book::where('uploaded_by', $user->id)
            ->orderBy('downloads', 'desc')
            ->take(5)
            ->get();

        $recent_activity = Book::where('uploaded_by', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.author', compact('stats', 'my_books', 'top_books', 'recent_activity'));
    }

    /**
     * Dashboard pour les utilisateurs réguliers
     */
    private function userDashboard()
    {
        $user = Auth::user();
        
        // Stats pour l'utilisateur
        $stats = [
            'books_read' => 0, // À implémenter avec un système de tracking
            'books_downloaded' => 0, // À implémenter
            'favorite_books' => 0, // À implémenter
            'reading_streak' => 7, // À implémenter
        ];

        // Livres récents approuvés
        $recent_books = Book::where('is_approved', true)
            ->with('uploader')
            ->latest()
            ->take(6)
            ->get();

        // Livres populaires
        $popular_books = Book::where('is_approved', true)
            ->with('uploader')
            ->orderBy('downloads', 'desc')
            ->take(6)
            ->get();

        // Recommandations (pour l'instant, on prend des livres aléatoires)
        $recommendations = Book::where('is_approved', true)
            ->inRandomOrder()
            ->take(6)
            ->get();

        // Livres en cours de lecture (mock data pour l'instant)
        $continue_reading = collect([]);

        // Activité récente (mock data pour l'instant)
        $recent_activity = collect([]);

        return view('dashboard.user', compact(
            'stats',
            'recent_books',
            'popular_books',
            'recommendations',
            'continue_reading',
            'recent_activity'
        ));
    }
}