<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class EducationalNews extends Model
{
    use HasFactory;

    protected $table = 'educational_news';

    protected $fillable = [
        'title',
        'content',
        'excerpt',
        'category',
        'image_path',
        'source',
        'source_url',
        'priority',
        'status',
        'views',
        'tags',
        'event_date',
        'created_by',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'event_date' => 'date',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the author of the news
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope for published news
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope for urgent news
     */
    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    /**
     * Scope for recent news
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'urgent' => 'URGENT',
            'opportunity' => 'OPPORTUNITÉ',
            'innovation' => 'INNOVATION',
            'announcement' => 'ANNONCE',
            default => 'GÉNÉRAL'
        };
    }

    /**
     * Get category color
     */
    public function getCategoryColorAttribute(): string
    {
        return match($this->category) {
            'urgent' => 'red',
            'opportunity' => 'blue',
            'innovation' => 'purple',
            'announcement' => 'orange',
            default => 'gray'
        };
    }

    /**
     * Get time ago
     */
    public function getTimeAgoAttribute(): string
    {
        $diff = Carbon::parse($this->published_at)->diffForHumans();
        return $diff;
    }

    /**
     * Get formatted date
     */
    public function getFormattedDateAttribute(): string
    {
        return Carbon::parse($this->published_at)->format('d M Y');
    }

    /**
     * Increment views
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get icon based on category
     */
    public function getIconAttribute(): string
    {
        return match($this->category) {
            'urgent' => 'fas fa-exclamation-triangle',
            'opportunity' => 'fas fa-coins',
            'innovation' => 'fas fa-laptop-code',
            'announcement' => 'fas fa-bullhorn',
            default => 'fas fa-newspaper'
        };
    }
}