<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'page_number',
        'position_x',
        'position_y',
        'title',
        'notes',
        'color',
        'is_private',
        'created_at',
    ];

    protected $casts = [
        'page_number' => 'integer',
        'position_x' => 'decimal:4',
        'position_y' => 'decimal:4',
        'is_private' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that owns the bookmark.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that is bookmarked.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Scope to get bookmarks for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get bookmarks for a specific book
     */
    public function scopeForBook($query, $bookId)
    {
        return $query->where('book_id', $bookId);
    }

    /**
     * Scope to get public bookmarks
     */
    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }

    /**
     * Scope to get private bookmarks
     */
    public function scopePrivate($query)
    {
        return $query->where('is_private', true);
    }

    /**
     * Scope to order by page number
     */
    public function scopeOrderByPage($query)
    {
        return $query->orderBy('page_number')->orderBy('position_y');
    }

    /**
     * Get formatted page display
     */
    public function getPageDisplayAttribute()
    {
        return "Page {$this->page_number}";
    }

    /**
     * Get bookmark color with default
     */
    public function getBookmarkColorAttribute()
    {
        return $this->color ?? '#3B82F6'; // Default blue
    }

    /**
     * Create a new bookmark
     */
    public static function createBookmark($userId, $bookId, $pageNumber, $data = [])
    {
        return static::create(array_merge([
            'user_id' => $userId,
            'book_id' => $bookId,
            'page_number' => $pageNumber,
            'title' => $data['title'] ?? "Marque-page page {$pageNumber}",
            'notes' => $data['notes'] ?? null,
            'position_x' => $data['position_x'] ?? 0,
            'position_y' => $data['position_y'] ?? 0,
            'color' => $data['color'] ?? '#3B82F6',
            'is_private' => $data['is_private'] ?? true,
        ]));
    }

    /**
     * Check if bookmark exists for user and book at specific page
     */
    public static function existsForPage($userId, $bookId, $pageNumber)
    {
        return static::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->where('page_number', $pageNumber)
            ->exists();
    }

    /**
     * Get bookmarks for a reading session
     */
    public static function getForReading($userId, $bookId)
    {
        return static::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->orderBy('page_number')
            ->orderBy('position_y')
            ->get();
    }

    /**
     * Get recent bookmarks for user
     */
    public static function getRecentForUser($userId, $limit = 10)
    {
        return static::with('book')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
