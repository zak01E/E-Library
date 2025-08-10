<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Highlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'page_number',
        'start_position',
        'end_position',
        'selected_text',
        'color',
        'notes',
        'is_private',
        'created_at',
    ];

    protected $casts = [
        'page_number' => 'integer',
        'start_position' => 'integer',
        'end_position' => 'integer',
        'is_private' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that owns the highlight.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that the highlight belongs to.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Scope to get highlights for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get highlights for a specific book
     */
    public function scopeForBook($query, $bookId)
    {
        return $query->where('book_id', $bookId);
    }

    /**
     * Scope to get public highlights
     */
    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }

    /**
     * Scope to get private highlights
     */
    public function scopePrivate($query)
    {
        return $query->where('is_private', true);
    }

    /**
     * Scope to search highlights by text or notes
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('selected_text', 'like', "%{$search}%")
              ->orWhere('notes', 'like', "%{$search}%");
        });
    }

    /**
     * Scope to filter by color
     */
    public function scopeByColor($query, $color)
    {
        return $query->where('color', $color);
    }

    /**
     * Scope to order by page number and position
     */
    public function scopeOrderByPosition($query)
    {
        return $query->orderBy('page_number')->orderBy('start_position');
    }

    /**
     * Get formatted page display
     */
    public function getPageDisplayAttribute()
    {
        return "Page {$this->page_number}";
    }

    /**
     * Get highlight color with default
     */
    public function getHighlightColorAttribute()
    {
        return $this->color ?? '#FBBF24'; // Default yellow
    }

    /**
     * Get text excerpt
     */
    public function getExcerptAttribute($length = 100)
    {
        if (strlen($this->selected_text) <= $length) {
            return $this->selected_text;
        }

        return substr($this->selected_text, 0, $length) . '...';
    }

    /**
     * Get word count of selected text
     */
    public function getWordCountAttribute()
    {
        return str_word_count($this->selected_text);
    }

    /**
     * Get character count of selected text
     */
    public function getCharacterCountAttribute()
    {
        return strlen($this->selected_text);
    }

    /**
     * Create a new highlight
     */
    public static function createHighlight($userId, $bookId, $pageNumber, $data = [])
    {
        return static::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'page_number' => $pageNumber,
            'start_position' => $data['start_position'] ?? 0,
            'end_position' => $data['end_position'] ?? 0,
            'selected_text' => $data['selected_text'] ?? '',
            'color' => $data['color'] ?? '#FBBF24',
            'notes' => $data['notes'] ?? null,
            'is_private' => $data['is_private'] ?? true,
        ]);
    }

    /**
     * Get highlights for a reading session
     */
    public static function getForReading($userId, $bookId)
    {
        return static::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->orderBy('page_number')
            ->orderBy('start_position')
            ->get();
    }

    /**
     * Get recent highlights for user
     */
    public static function getRecentForUser($userId, $limit = 10)
    {
        return static::with('book')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get highlights by color for user
     */
    public static function getByColorForUser($userId, $color)
    {
        return static::with('book')
            ->where('user_id', $userId)
            ->where('color', $color)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get all colors used by user
     */
    public static function getColorsForUser($userId)
    {
        return static::where('user_id', $userId)
            ->distinct()
            ->pluck('color')
            ->filter()
            ->values();
    }

    /**
     * Check if text is already highlighted
     */
    public static function isHighlighted($userId, $bookId, $pageNumber, $startPosition, $endPosition)
    {
        return static::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->where('page_number', $pageNumber)
            ->where(function ($query) use ($startPosition, $endPosition) {
                $query->whereBetween('start_position', [$startPosition, $endPosition])
                      ->orWhereBetween('end_position', [$startPosition, $endPosition])
                      ->orWhere(function ($q) use ($startPosition, $endPosition) {
                          $q->where('start_position', '<=', $startPosition)
                            ->where('end_position', '>=', $endPosition);
                      });
            })
            ->exists();
    }
}
