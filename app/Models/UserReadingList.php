<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserReadingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'priority',
        'status',
        'added_at',
        'notes',
        'estimated_read_date',
    ];

    protected $casts = [
        'priority' => 'integer',
        'added_at' => 'datetime',
        'estimated_read_date' => 'date',
    ];

    const STATUS_WANT_TO_READ = 'want_to_read';
    const STATUS_READING = 'reading';
    const STATUS_READ = 'read';
    const STATUS_ON_HOLD = 'on_hold';

    const PRIORITY_LOW = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_HIGH = 3;
    const PRIORITY_URGENT = 4;

    /**
     * Get the user that owns the reading list item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book in the reading list.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Scope to get items for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get items by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get items by priority
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope to order by priority
     */
    public function scopeOrderByPriority($query)
    {
        return $query->orderBy('priority', 'desc')->orderBy('added_at', 'asc');
    }

    /**
     * Get priority label
     */
    public function getPriorityLabelAttribute()
    {
        return match($this->priority) {
            self::PRIORITY_URGENT => 'Urgent',
            self::PRIORITY_HIGH => 'Élevée',
            self::PRIORITY_MEDIUM => 'Moyenne',
            self::PRIORITY_LOW => 'Faible',
            default => 'Non définie',
        };
    }

    /**
     * Get priority color
     */
    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            self::PRIORITY_URGENT => 'red',
            self::PRIORITY_HIGH => 'orange',
            self::PRIORITY_MEDIUM => 'yellow',
            self::PRIORITY_LOW => 'green',
            default => 'gray',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            self::STATUS_WANT_TO_READ => 'À lire',
            self::STATUS_READING => 'En cours',
            self::STATUS_READ => 'Lu',
            self::STATUS_ON_HOLD => 'En pause',
            default => 'Inconnu',
        };
    }

    /**
     * Add book to reading list
     */
    public static function addToList($userId, $bookId, $priority = self::PRIORITY_MEDIUM, $notes = null)
    {
        return static::firstOrCreate(
            [
                'user_id' => $userId,
                'book_id' => $bookId,
            ],
            [
                'priority' => $priority,
                'status' => self::STATUS_WANT_TO_READ,
                'added_at' => now(),
                'notes' => $notes,
            ]
        );
    }

    /**
     * Update priority
     */
    public function updatePriority($priority)
    {
        $this->priority = $priority;
        $this->save();
        return $this;
    }

    /**
     * Mark as reading
     */
    public function markAsReading()
    {
        $this->status = self::STATUS_READING;
        $this->save();
        return $this;
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        $this->status = self::STATUS_READ;
        $this->save();
        return $this;
    }

    /**
     * Put on hold
     */
    public function putOnHold()
    {
        $this->status = self::STATUS_ON_HOLD;
        $this->save();
        return $this;
    }

    /**
     * Remove from reading list
     */
    public static function removeFromList($userId, $bookId)
    {
        return static::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->delete();
    }

    /**
     * Check if book is in user's reading list
     */
    public static function isInList($userId, $bookId)
    {
        return static::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->exists();
    }
}
