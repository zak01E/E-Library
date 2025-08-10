<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFavorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'added_at',
        'notes',
    ];

    protected $casts = [
        'added_at' => 'datetime',
    ];

    /**
     * Get the user that owns the favorite.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that is favorited.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Scope to get favorites for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Check if a book is favorited by a user
     */
    public static function isFavorited($userId, $bookId)
    {
        return static::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->exists();
    }

    /**
     * Add a book to favorites
     */
    public static function addFavorite($userId, $bookId, $notes = null)
    {
        return static::firstOrCreate(
            [
                'user_id' => $userId,
                'book_id' => $bookId,
            ],
            [
                'added_at' => now(),
                'notes' => $notes,
            ]
        );
    }

    /**
     * Remove a book from favorites
     */
    public static function removeFavorite($userId, $bookId)
    {
        return static::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->delete();
    }
}
