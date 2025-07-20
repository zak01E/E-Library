<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index()
    {
        // Get initial data for the page
        $stats = $this->getActivityStats('24h');
        $recentActivities = ActivityLog::recent(20);

        return view('admin.activity', compact('stats', 'recentActivities'));
    }

    public function getRealtimeData(Request $request)
    {
        $period = $request->get('period', '24h');

        return response()->json([
            'stats' => $this->getActivityStats($period),
            'activities' => $this->getRecentActivities($request),
            'charts' => $this->getChartData($period),
            'timestamp' => now()->format('H:i:s'),
            'online_users' => $this->getOnlineUsersCount(),
        ]);
    }

    private function getActivityStats(string $period = '24h')
    {
        $startDate = $this->getPeriodStartDate($period);
        $previousStartDate = $this->getPreviousPeriodStartDate($period);

        // Current period stats
        $currentStats = ActivityLog::where('created_at', '>=', $startDate)->get();
        $previousStats = ActivityLog::whereBetween('created_at', [$previousStartDate, $startDate])->get();

        // Online users (active in last 15 minutes)
        $onlineUsers = $this->getOnlineUsersCount();

        // New users in period
        $newUsers = User::where('created_at', '>=', $startDate)->count();
        $previousNewUsers = User::whereBetween('created_at', [$previousStartDate, $startDate])->count();

        // Downloads in period
        $downloads = ActivityLog::where('created_at', '>=', $startDate)
            ->where('action', 'download')
            ->count();
        $previousDownloads = ActivityLog::whereBetween('created_at', [$previousStartDate, $startDate])
            ->where('action', 'download')
            ->count();

        // Page views in period
        $pageViews = ActivityLog::where('created_at', '>=', $startDate)
            ->whereIn('action', ['view', 'page_view'])
            ->count();
        $previousPageViews = ActivityLog::whereBetween('created_at', [$previousStartDate, $startDate])
            ->whereIn('action', ['view', 'page_view'])
            ->count();

        return [
            'online_users' => $onlineUsers,
            'online_users_change' => 0, // Real-time metric, no comparison
            'new_users' => $newUsers,
            'new_users_change' => $this->calculatePercentageChange($newUsers, $previousNewUsers),
            'downloads' => $downloads,
            'downloads_change' => $this->calculatePercentageChange($downloads, $previousDownloads),
            'page_views' => $pageViews,
            'page_views_change' => $this->calculatePercentageChange($pageViews, $previousPageViews),
            'total_activities' => $currentStats->count(),
            'unique_active_users' => $currentStats->pluck('user_id')->unique()->count(),
        ];
    }

    private function getOnlineUsersCount()
    {
        // Users active in the last 15 minutes
        return ActivityLog::where('created_at', '>=', Carbon::now()->subMinutes(15))
            ->distinct('user_id')
            ->count('user_id');
    }

    private function getRecentActivities(Request $request)
    {
        $limit = $request->get('limit', 50);
        $search = $request->get('search');
        $actionFilter = $request->get('action_filter');

        $query = ActivityLog::with('user')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($actionFilter && $actionFilter !== 'all') {
            $query->where('action', $actionFilter);
        }

        return $query->limit($limit)->get()->map(function($activity) {
            return [
                'id' => $activity->id,
                'time' => $activity->created_at->format('H:i:s'),
                'date' => $activity->created_at->format('d/m/Y'),
                'user_name' => $activity->user ? $activity->user->name : 'Système',
                'user_email' => $activity->user ? $activity->user->email : null,
                'action' => $activity->action,
                'description' => $activity->description,
                'ip_address' => $activity->ip_address,
                'user_agent' => $this->parseUserAgent($activity->user_agent),
                'properties' => $activity->properties,
            ];
        });
    }

    private function getChartData(string $period)
    {
        $startDate = $this->getPeriodStartDate($period);

        // Get hourly activity data
        $hourlyData = ActivityLog::where('created_at', '>=', $startDate)
            ->select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        // Create 24-hour labels and data
        $labels = [];
        $data = [];

        for ($i = 0; $i < 24; $i++) {
            $labels[] = sprintf('%02d:00', $i);
            $hourData = $hourlyData->firstWhere('hour', $i);
            $data[] = $hourData ? $hourData->count : 0;
        }

        return [
            'labels' => $labels,
            'activity_data' => $data,
        ];
    }

    private function getPeriodStartDate(string $period)
    {
        return match($period) {
            '1h' => Carbon::now()->subHour(),
            '24h' => Carbon::now()->subDay(),
            '7d' => Carbon::now()->subWeek(),
            '30d' => Carbon::now()->subMonth(),
            default => Carbon::now()->subDay(),
        };
    }

    private function getPreviousPeriodStartDate(string $period)
    {
        return match($period) {
            '1h' => Carbon::now()->subHours(2),
            '24h' => Carbon::now()->subDays(2),
            '7d' => Carbon::now()->subWeeks(2),
            '30d' => Carbon::now()->subMonths(2),
            default => Carbon::now()->subDays(2),
        };
    }

    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function parseUserAgent($userAgent)
    {
        if (!$userAgent) return 'Inconnu';

        // Simple user agent parsing
        if (strpos($userAgent, 'Chrome') !== false) {
            return 'Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            return 'Edge';
        } else {
            return 'Autre';
        }
    }

    /**
     * Log activity helper method
     */
    public static function logActivity(string $action, ?string $description = null, array $properties = [])
    {
        ActivityLog::log($action, null, $description, $properties);
    }
}
