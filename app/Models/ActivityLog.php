<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'properties',
        'session_id',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    protected $dates = ['created_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log an activity
     */
    public static function log(string $action, ?int $userId = null, ?string $description = null, array $properties = []): self
    {
        return self::create([
            'user_id' => $userId ?? auth()->id(),
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'properties' => $properties,
            'session_id' => session()->getId(),
            'created_at' => now(),
        ]);
    }

    /**
     * Get recent activities
     */
    public static function recent(int $limit = 50)
    {
        return self::with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get activities by time period
     */
    public static function byPeriod(string $period = '24h')
    {
        $startDate = match($period) {
            '1h' => Carbon::now()->subHour(),
            '24h' => Carbon::now()->subDay(),
            '7d' => Carbon::now()->subWeek(),
            '30d' => Carbon::now()->subMonth(),
            default => Carbon::now()->subDay(),
        };

        return self::with('user')
            ->where('created_at', '>=', $startDate)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get activity statistics
     */
    public static function getStats(string $period = '24h')
    {
        $startDate = match($period) {
            '1h' => Carbon::now()->subHour(),
            '24h' => Carbon::now()->subDay(),
            '7d' => Carbon::now()->subWeek(),
            '30d' => Carbon::now()->subMonth(),
            default => Carbon::now()->subDay(),
        };

        $activities = self::where('created_at', '>=', $startDate)->get();

        return [
            'total_activities' => $activities->count(),
            'unique_users' => $activities->pluck('user_id')->unique()->count(),
            'actions_breakdown' => $activities->groupBy('action')->map->count(),
            'hourly_activity' => $activities->groupBy(function($item) {
                return $item->created_at->format('H:00');
            })->map->count(),
        ];
    }
}
