<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'page_number',
        'position_x',
        'position_y',
        'title',
        'content',
        'color',
        'is_private',
        'tags',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'page_number' => 'integer',
        'position_x' => 'decimal:4',
        'position_y' => 'decimal:4',
        'is_private' => 'boolean',
        'tags' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the note.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that the note belongs to.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Scope to get notes for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get notes for a specific book
     */
    public function scopeForBook($query, $bookId)
    {
        return $query->where('book_id', $bookId);
    }

    /**
     * Scope to get public notes
     */
    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }

    /**
     * Scope to get private notes
     */
    public function scopePrivate($query)
    {
        return $query->where('is_private', true);
    }

    /**
     * Scope to search notes by content or title
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%");
        });
    }

    /**
     * Scope to filter by tags
     */
    public function scopeWithTag($query, $tag)
    {
        return $query->whereJsonContains('tags', $tag);
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
     * Get note color with default
     */
    public function getNoteColorAttribute()
    {
        return $this->color ?? '#FCD34D'; // Default yellow
    }

    /**
     * Get excerpt of content
     */
    public function getExcerptAttribute($length = 100)
    {
        if (strlen($this->content) <= $length) {
            return $this->content;
        }

        return substr($this->content, 0, $length) . '...';
    }

    /**
     * Get word count
     */
    public function getWordCountAttribute()
    {
        return str_word_count(strip_tags($this->content));
    }

    /**
     * Add tag to note
     */
    public function addTag($tag)
    {
        $tags = $this->tags ?? [];
        if (!in_array($tag, $tags)) {
            $tags[] = $tag;
            $this->tags = $tags;
            $this->save();
        }
        return $this;
    }

    /**
     * Remove tag from note
     */
    public function removeTag($tag)
    {
        $tags = $this->tags ?? [];
        $tags = array_filter($tags, function ($t) use ($tag) {
            return $t !== $tag;
        });
        $this->tags = array_values($tags);
        $this->save();
        return $this;
    }

    /**
     * Create a new note
     */
    public static function createNote($userId, $bookId, $pageNumber, $data = [])
    {
        return static::create(array_merge([
            'user_id' => $userId,
            'book_id' => $bookId,
            'page_number' => $pageNumber,
            'title' => $data['title'] ?? "Note page {$pageNumber}",
            'content' => $data['content'] ?? '',
            'position_x' => $data['position_x'] ?? 0,
            'position_y' => $data['position_y'] ?? 0,
            'color' => $data['color'] ?? '#FCD34D',
            'is_private' => $data['is_private'] ?? true,
            'tags' => $data['tags'] ?? [],
        ]));
    }

    /**
     * Get notes for a reading session
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
     * Get recent notes for user
     */
    public static function getRecentForUser($userId, $limit = 10)
    {
        return static::with('book')
            ->where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get all tags used by user
     */
    public static function getTagsForUser($userId)
    {
        $notes = static::where('user_id', $userId)
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->filter()
            ->values();

        return $notes;
    }
}
