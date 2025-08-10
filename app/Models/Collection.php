<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'slug',
        'color',
        'icon',
        'is_public',
        'is_featured',
        'sort_order',
        'views',
        'metadata',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_featured' => 'boolean',
        'views' => 'integer',
        'sort_order' => 'integer',
        'metadata' => 'array',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($collection) {
            if (empty($collection->slug)) {
                $collection->slug = Str::slug($collection->name);
            }
        });

        static::updating(function ($collection) {
            if ($collection->isDirty('name')) {
                $collection->slug = Str::slug($collection->name);
            }
        });
    }

    /**
     * Get the user that owns the collection.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the books in this collection.
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'collection_books')
            ->withPivot('added_at', 'sort_order', 'notes')
            ->withTimestamps()
            ->orderBy('pivot_sort_order')
            ->orderBy('pivot_created_at', 'desc');
    }

    /**
     * Scope to get public collections
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope to get featured collections
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to get collections for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to search collections by name or description
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the collection's URL
     */
    public function getUrlAttribute()
    {
        return route('user.collections.show', $this->slug);
    }

    /**
     * Get the collection's cover image (first book's cover or default)
     */
    public function getCoverImageAttribute()
    {
        $firstBook = $this->books()->first();
        return $firstBook?->cover_image ?? '/images/default-collection-cover.jpg';
    }

    /**
     * Get books count
     */
    public function getBooksCountAttribute()
    {
        return $this->books()->count();
    }

    /**
     * Get total pages in collection
     */
    public function getTotalPagesAttribute()
    {
        return $this->books()->sum('pages') ?? 0;
    }

    /**
     * Get average rating of books in collection
     */
    public function getAverageRatingAttribute()
    {
        return round($this->books()->avg('rating') ?? 0, 1);
    }

    /**
     * Get unique genres in collection
     */
    public function getGenresAttribute()
    {
        return $this->books()
            ->whereNotNull('genre')
            ->distinct()
            ->pluck('genre')
            ->filter()
            ->values();
    }

    /**
     * Add a book to the collection
     */
    public function addBook($bookId, $notes = null, $sortOrder = null)
    {
        if ($this->books()->where('book_id', $bookId)->exists()) {
            return false; // Book already in collection
        }

        $this->books()->attach($bookId, [
            'added_at' => now(),
            'notes' => $notes,
            'sort_order' => $sortOrder ?? $this->books()->count() + 1,
        ]);

        return true;
    }

    /**
     * Remove a book from the collection
     */
    public function removeBook($bookId)
    {
        return $this->books()->detach($bookId);
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Check if user can view this collection
     */
    public function canBeViewedBy($user = null)
    {
        if ($this->is_public) {
            return true;
        }

        if (!$user) {
            return false;
        }

        return $this->user_id === $user->id;
    }

    /**
     * Check if user can edit this collection
     */
    public function canBeEditedBy($user = null)
    {
        if (!$user) {
            return false;
        }

        return $this->user_id === $user->id;
    }
}
