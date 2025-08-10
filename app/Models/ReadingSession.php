<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReadingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'started_at',
        'ended_at',
        'current_page',
        'total_pages',
        'progress',
        'reading_time_minutes',
        'device_type',
        'notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'current_page' => 'integer',
        'total_pages' => 'integer',
        'progress' => 'decimal:2',
        'reading_time_minutes' => 'integer',
    ];

    /**
     * Get the user that owns the reading session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book being read.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Scope to get active reading sessions
     */
    public function scopeActive($query)
    {
        return $query->whereNull('ended_at');
    }

    /**
     * Scope to get completed reading sessions
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('ended_at');
    }

    /**
     * Scope to get sessions for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Calculate reading progress percentage
     */
    public function calculateProgress()
    {
        if ($this->total_pages && $this->current_page) {
            return round(($this->current_page / $this->total_pages) * 100, 2);
        }
        return 0;
    }

    /**
     * Update reading progress
     */
    public function updateProgress($currentPage, $totalPages = null)
    {
        $this->current_page = $currentPage;
        if ($totalPages) {
            $this->total_pages = $totalPages;
        }
        $this->progress = $this->calculateProgress();
        $this->save();

        return $this;
    }

    /**
     * Start a new reading session
     */
    public static function startSession($userId, $bookId, $currentPage = 1, $totalPages = null)
    {
        // End any existing active session for this book
        static::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->whereNull('ended_at')
            ->update(['ended_at' => now()]);

        // Create new session
        return static::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'started_at' => now(),
            'current_page' => $currentPage,
            'total_pages' => $totalPages,
            'progress' => $totalPages ? round(($currentPage / $totalPages) * 100, 2) : 0,
        ]);
    }

    /**
     * End the reading session
     */
    public function endSession()
    {
        $this->ended_at = now();
        
        // Calculate reading time
        if ($this->started_at) {
            $this->reading_time_minutes = $this->started_at->diffInMinutes($this->ended_at);
        }
        
        $this->save();
        return $this;
    }

    /**
     * Get formatted reading time
     */
    public function getFormattedReadingTimeAttribute()
    {
        if (!$this->reading_time_minutes) {
            return '0 min';
        }

        $hours = floor($this->reading_time_minutes / 60);
        $minutes = $this->reading_time_minutes % 60;

        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'min';
        }

        return $minutes . 'min';
    }

    /**
     * Get estimated time remaining
     */
    public function getEstimatedTimeRemainingAttribute()
    {
        if (!$this->progress || $this->progress >= 100) {
            return null;
        }

        if (!$this->reading_time_minutes) {
            return null;
        }

        $remainingProgress = 100 - $this->progress;
        $timePerPercent = $this->reading_time_minutes / $this->progress;
        $estimatedMinutes = $remainingProgress * $timePerPercent;

        $hours = floor($estimatedMinutes / 60);
        $minutes = round($estimatedMinutes % 60);

        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'min';
        }

        return $minutes . 'min';
    }
}
