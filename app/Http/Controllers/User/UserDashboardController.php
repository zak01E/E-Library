<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\UserFavorite;
use App\Models\ReadingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    /**
     * Display the user dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Statistiques utilisateur
        $stats = [
            'books_read' => $this->getBooksReadCount($user->id),
            'books_reading' => $this->getCurrentReadingCount($user->id),
            'favorites' => $this->getFavoritesCount($user->id),
            'reading_time' => $this->getReadingTime($user->id),
        ];

        // Livres récents
        $recent_books = Book::where('is_approved', true)
            ->orderBy('created_at', 'desc')
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

        // Livres en cours de lecture
        $currentBooks = $this->getCurrentReadingBooks($user->id);

        // Activité récente
        $recent_activity = $this->getRecentActivity($user->id);

        return view('user.dashboard.index', compact(
            'stats',
            'recent_books',
            'popular_books',
            'recommendations',
            'currentBooks',
            'recent_activity'
        ));
    }

    /**
     * Get widgets data for AJAX requests
     */
    public function widgets(Request $request)
    {
        $user = Auth::user();
        $widget = $request->get('widget');

        switch ($widget) {
            case 'stats':
                return response()->json([
                    'books_read' => $this->getBooksReadCount($user->id),
                    'books_reading' => $this->getCurrentReadingCount($user->id),
                    'favorites' => $this->getFavoritesCount($user->id),
                    'reading_time' => $this->getReadingTime($user->id),
                ]);

            case 'current_books':
                return response()->json($this->getCurrentReadingBooks($user->id));

            case 'recent_activity':
                return response()->json($this->getRecentActivity($user->id));

            default:
                return response()->json(['error' => 'Widget not found'], 404);
        }
    }

    /**
     * Get count of books read by user
     */
    private function getBooksReadCount($userId)
    {
        try {
            return ReadingSession::where('user_id', $userId)
                ->whereNotNull('ended_at')
                ->distinct('book_id')
                ->count();
        } catch (\Exception $e) {
            return 0; // Return 0 if table doesn't exist
        }
    }

    /**
     * Get count of books currently being read
     */
    private function getCurrentReadingCount($userId)
    {
        try {
            return ReadingSession::where('user_id', $userId)
                ->whereNull('ended_at')
                ->distinct('book_id')
                ->count();
        } catch (\Exception $e) {
            return 0; // Return 0 if table doesn't exist
        }
    }

    /**
     * Get count of favorite books
     */
    private function getFavoritesCount($userId)
    {
        try {
            return UserFavorite::where('user_id', $userId)->count();
        } catch (\Exception $e) {
            return 0; // Return 0 if table doesn't exist
        }
    }

    /**
     * Get total reading time
     */
    private function getReadingTime($userId)
    {
        try {
            $totalMinutes = ReadingSession::where('user_id', $userId)
                ->whereNotNull('ended_at')
                ->sum(DB::raw('TIMESTAMPDIFF(MINUTE, started_at, ended_at)'));
            
            if ($totalMinutes > 60) {
                return round($totalMinutes / 60, 1) . 'h';
            }
            
            return $totalMinutes . 'min';
        } catch (\Exception $e) {
            return '0h'; // Return 0 if table doesn't exist
        }
    }

    /**
     * Get books currently being read
     */
    private function getCurrentReadingBooks($userId)
    {
        try {
            return ReadingSession::with('book')
                ->where('user_id', $userId)
                ->whereNull('ended_at')
                ->orderBy('started_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($session) {
                    return [
                        'id' => $session->book->id,
                        'title' => $session->book->title,
                        'author' => $session->book->author_name ?? 'Auteur inconnu',
                        'cover_image' => $session->book->cover_image,
                        'progress' => $session->progress ?? 0,
                        'current_page' => $session->current_page ?? 1,
                        'total_pages' => $session->book->pages ?? 100,
                        'started_at' => $session->started_at->format('d/m/Y'),
                    ];
                });
        } catch (\Exception $e) {
            return collect([]); // Return empty collection if table doesn't exist
        }
    }

    /**
     * Get recent user activity
     */
    private function getRecentActivity($userId)
    {
        try {
            $activities = collect([]);

            // Recent reading sessions
            $recentSessions = ReadingSession::with('book')
                ->where('user_id', $userId)
                ->whereNotNull('ended_at')
                ->orderBy('ended_at', 'desc')
                ->take(3)
                ->get();

            foreach ($recentSessions as $session) {
                $activities->push([
                    'type' => 'completed',
                    'book' => $session->book->title,
                    'date' => $session->ended_at->diffForHumans(),
                    'rating' => null,
                ]);
            }

            // Recent favorites
            $recentFavorites = UserFavorite::with('book')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->take(2)
                ->get();

            foreach ($recentFavorites as $favorite) {
                $activities->push([
                    'type' => 'favorited',
                    'book' => $favorite->book->title,
                    'date' => $favorite->created_at->diffForHumans(),
                    'rating' => null,
                ]);
            }

            return $activities->sortByDesc('date')->take(5)->values();
        } catch (\Exception $e) {
            return collect([]); // Return empty collection if tables don't exist
        }
    }
}
