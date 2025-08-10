<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\ReadingSession;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserStatsController extends Controller
{
    /**
     * Display user statistics dashboard
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Basic stats
        $stats = [
            'total_books_read' => Borrowing::where('user_id', $userId)
                ->where('status', 'returned')
                ->count(),
            
            'currently_reading' => Borrowing::where('user_id', $userId)
                ->where('status', 'active')
                ->count(),
            
            'total_pages_read' => ReadingSession::where('user_id', $userId)
                ->sum('pages_read'),
            
            'total_reading_time' => ReadingSession::where('user_id', $userId)
                ->sum('duration_seconds'),
            
            'favorite_genre' => $this->getFavoriteGenre($userId),
            
            'reading_streak' => $this->getReadingStreak($userId),
        ];
        
        // Monthly reading chart data
        $monthlyData = $this->getMonthlyReadingData($userId);
        
        // Genre distribution
        $genreDistribution = $this->getGenreDistribution($userId);
        
        // Reading time by day of week
        $weeklyPattern = $this->getWeeklyReadingPattern($userId);
        
        return view('user.stats.index', compact('stats', 'monthlyData', 'genreDistribution', 'weeklyPattern'));
    }
    
    /**
     * Get favorite genre
     */
    private function getFavoriteGenre($userId)
    {
        $genre = DB::table('borrowings')
            ->join('books', 'borrowings.book_id', '=', 'books.id')
            ->where('borrowings.user_id', $userId)
            ->select('books.category')
            ->groupBy('books.category')
            ->orderByRaw('COUNT(*) DESC')
            ->first();
            
        return $genre ? $genre->category : 'Non défini';
    }
    
    /**
     * Get reading streak in days
     */
    private function getReadingStreak($userId)
    {
        $sessions = ReadingSession::where('user_id', $userId)
            ->orderBy('started_at', 'desc')
            ->pluck('started_at')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->unique()
            ->values();
        
        $streak = 0;
        $currentDate = now()->format('Y-m-d');
        
        foreach ($sessions as $date) {
            if ($date == $currentDate) {
                $streak++;
                $currentDate = now()->subDays($streak)->format('Y-m-d');
            } else {
                break;
            }
        }
        
        return $streak;
    }
    
    /**
     * Get monthly reading data for chart
     */
    private function getMonthlyReadingData($userId)
    {
        return Borrowing::where('user_id', $userId)
            ->where('borrowed_at', '>=', now()->subMonths(12))
            ->selectRaw('MONTH(borrowed_at) as month, YEAR(borrowed_at) as year, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
                    'count' => $item->count
                ];
            });
    }
    
    /**
     * Get genre distribution
     */
    private function getGenreDistribution($userId)
    {
        return DB::table('borrowings')
            ->join('books', 'borrowings.book_id', '=', 'books.id')
            ->where('borrowings.user_id', $userId)
            ->select('books.category', DB::raw('COUNT(*) as count'))
            ->groupBy('books.category')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
    }
    
    /**
     * Get weekly reading pattern
     */
    private function getWeeklyReadingPattern($userId)
    {
        return ReadingSession::where('user_id', $userId)
            ->selectRaw('DAYOFWEEK(started_at) as day, SUM(duration_seconds) as total_seconds')
            ->groupBy('day')
            ->get()
            ->mapWithKeys(function ($item) {
                $days = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
                return [$days[$item->day - 1] => round($item->total_seconds / 3600, 1)];
            });
    }
}