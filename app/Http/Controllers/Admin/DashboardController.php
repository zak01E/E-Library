<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get initial data for the page
        $stats = $this->getDashboardStats();
        $chartData = $this->getChartData();
        $recentData = $this->getRecentData();

        return view('admin.dashboard', compact('stats', 'chartData', 'recentData'));
    }

    public function getRealtimeData(Request $request)
    {
        return response()->json([
            'stats' => $this->getDashboardStats(),
            'chartData' => $this->getChartData(),
            'recentData' => $this->getRecentData(),
            'categoriesData' => $this->getCategoriesData(),
            'timestamp' => now()->format('H:i:s'),
        ]);
    }

    private function getDashboardStats()
    {
        // Current period (last 30 days)
        $currentStart = Carbon::now()->subDays(30);
        $currentEnd = Carbon::now();

        // Previous period (30 days before that)
        $previousStart = Carbon::now()->subDays(60);
        $previousEnd = Carbon::now()->subDays(30);

        // Users statistics
        $totalUsers = User::count();
        $currentUsers = User::whereBetween('created_at', [$currentStart, $currentEnd])->count();
        $previousUsers = User::whereBetween('created_at', [$previousStart, $previousEnd])->count();
        $usersGrowth = $this->calculateGrowth($currentUsers, $previousUsers);

        // Books statistics
        $totalBooks = Book::count();
        $currentBooks = Book::whereBetween('created_at', [$currentStart, $currentEnd])->count();
        $previousBooks = Book::whereBetween('created_at', [$previousStart, $previousEnd])->count();
        $booksGrowth = $this->calculateGrowth($currentBooks, $previousBooks);

        // Authors statistics
        $totalAuthors = User::where('role', 'author')->count();
        $currentAuthors = User::where('role', 'author')
            ->whereBetween('created_at', [$currentStart, $currentEnd])->count();
        $previousAuthors = User::where('role', 'author')
            ->whereBetween('created_at', [$previousStart, $previousEnd])->count();
        $authorsGrowth = $this->calculateGrowth($currentAuthors, $previousAuthors);

        // Pending books
        $pendingBooks = Book::where('is_approved', false)->count();
        $approvedBooks = Book::where('is_approved', true)->count();

        // Activity statistics
        $onlineUsers = $this->getOnlineUsersCount();
        $todayActivities = ActivityLog::whereDate('created_at', today())->count();

        return [
            'total_users' => $totalUsers,
            'users_growth' => $usersGrowth,
            'total_books' => $totalBooks,
            'books_growth' => $booksGrowth,
            'total_authors' => $totalAuthors,
            'authors_growth' => $authorsGrowth,
            'pending_books' => $pendingBooks,
            'approved_books' => $approvedBooks,
            'online_users' => $onlineUsers,
            'today_activities' => $todayActivities,
        ];
    }

    private function getChartData()
    {
        // Get activity data for the last 7 days
        $days = [];
        $userRegistrations = [];
        $bookUploads = [];
        $activities = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->format('M j');

            // User registrations per day
            $userRegistrations[] = User::whereDate('created_at', $date)->count();

            // Book uploads per day
            $bookUploads[] = Book::whereDate('created_at', $date)->count();

            // Activities per day
            $activities[] = ActivityLog::whereDate('created_at', $date)->count();
        }

        return [
            'labels' => $days,
            'user_registrations' => $userRegistrations,
            'book_uploads' => $bookUploads,
            'activities' => $activities,
        ];
    }

    private function getCategoriesData()
    {
        $categories = Book::select('category', DB::raw('count(*) as count'))
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        $totalBooks = Book::count();

        return $categories->map(function($category) use ($totalBooks) {
            return [
                'name' => $category->category,
                'count' => $category->count,
                'percentage' => $totalBooks > 0 ? round(($category->count / $totalBooks) * 100, 1) : 0,
            ];
        });
    }

    private function getRecentData()
    {
        // Recent users (last 5)
        $recentUsers = User::latest()->take(5)->get()->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at->diffForHumans(),
                'avatar' => $user->profile_photo_url,
            ];
        });

        // Pending books (all)
        $pendingBooks = Book::with('uploader')
            ->where('is_approved', false)
            ->latest()
            ->get()
            ->map(function($book) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->uploader ? $book->uploader->name : 'Auteur inconnu',
                    'category' => $book->category,
                    'created_at' => $book->created_at->diffForHumans(),
                ];
            });

        // Recent activities
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get()
            ->map(function($activity) {
                return [
                    'id' => $activity->id,
                    'action' => $activity->action,
                    'description' => $activity->description,
                    'user_name' => $activity->user ? $activity->user->name : 'Système',
                    'created_at' => $activity->created_at->diffForHumans(),
                ];
            });

        return [
            'recent_users' => $recentUsers,
            'pending_books' => $pendingBooks,
            'recent_activities' => $recentActivities,
        ];
    }

    private function calculateGrowth($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function getOnlineUsersCount()
    {
        // Users active in the last 15 minutes
        return ActivityLog::where('created_at', '>=', Carbon::now()->subMinutes(15))
            ->distinct('user_id')
            ->count('user_id');
    }

    /**
     * Get hourly activity data for today
     */
    public function getHourlyActivity()
    {
        $hours = [];
        $activities = [];

        for ($i = 0; $i < 24; $i++) {
            $hours[] = sprintf('%02d:00', $i);

            $count = ActivityLog::whereDate('created_at', today())
                ->whereHour('created_at', $i)
                ->count();

            $activities[] = $count;
        }

        return [
            'labels' => $hours,
            'data' => $activities,
        ];
    }

    /**
     * Get top performing books
     */
    public function getTopBooks()
    {
        return Book::select('title', 'downloads', 'views')
            ->orderBy('downloads', 'desc')
            ->take(5)
            ->get()
            ->map(function($book) {
                return [
                    'title' => $book->title,
                    'downloads' => $book->downloads ?? 0,
                    'views' => $book->views ?? 0,
                ];
            });
    }

    /**
     * Get user growth trend for the last 30 days
     */
    public function getUserGrowthTrend()
    {
        $days = [];
        $counts = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->format('M j');

            $count = User::whereDate('created_at', $date)->count();
            $counts[] = $count;
        }

        return [
            'labels' => $days,
            'data' => $counts,
        ];
    }
}
