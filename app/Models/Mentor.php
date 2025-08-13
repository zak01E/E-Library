<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mentor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'subjects',
        'levels',
        'bio',
        'qualification',
        'years_experience',
        'certifications',
        'languages_spoken',
        'availability',
        'hourly_rate',
        'is_volunteer',
        'is_verified',
        'is_active',
        'students_helped',
        'rating',
        'total_reviews',
        'total_sessions',
        'total_hours',
        'regions_covered',
        'mentoring_type',
        'linkedin_url',
        'verified_at',
    ];

    protected $casts = [
        'subjects' => 'array',
        'levels' => 'array',
        'certifications' => 'array',
        'languages_spoken' => 'array',
        'availability' => 'array',
        'regions_covered' => 'array',
        'is_volunteer' => 'boolean',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'hourly_rate' => 'decimal:2',
        'rating' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user associated with the mentor
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get mentorship requests
     */
    public function mentorshipRequests(): HasMany
    {
        return $this->hasMany(MentorshipRequest::class);
    }

    /**
     * Get mentorship sessions
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(MentorshipSession::class);
    }

    /**
     * Get reviews
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(MentorReview::class);
    }

    /**
     * Scope for active mentors
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for verified mentors
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope for volunteer mentors
     */
    public function scopeVolunteers($query)
    {
        return $query->where('is_volunteer', true);
    }

    /**
     * Scope by specialization
     */
    public function scopeBySpecialization($query, $specialization)
    {
        return $query->where('specialization', $specialization);
    }

    /**
     * Get badge based on experience
     */
    public function getBadgeAttribute(): string
    {
        if ($this->total_sessions >= 100) {
            return 'Expert';
        } elseif ($this->total_sessions >= 50) {
            return 'Confirmé';
        } elseif ($this->total_sessions >= 20) {
            return 'Expérimenté';
        } elseif ($this->total_sessions >= 5) {
            return 'Débutant';
        }
        return 'Nouveau';
    }

    /**
     * Get badge color
     */
    public function getBadgeColorAttribute(): string
    {
        return match($this->badge) {
            'Expert' => 'purple',
            'Confirmé' => 'blue',
            'Expérimenté' => 'green',
            'Débutant' => 'yellow',
            default => 'gray'
        };
    }

    /**
     * Check if mentor is available at a specific time
     */
    public function isAvailableAt($dayOfWeek, $hour): bool
    {
        if (!isset($this->availability[$dayOfWeek])) {
            return false;
        }

        $dayAvailability = $this->availability[$dayOfWeek];
        
        foreach ($dayAvailability as $slot) {
            if ($hour >= $slot['start'] && $hour < $slot['end']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Update rating based on reviews
     */
    public function updateRating()
    {
        $avgRating = $this->reviews()->avg('rating');
        $totalReviews = $this->reviews()->count();
        
        $this->update([
            'rating' => $avgRating ?: 0,
            'total_reviews' => $totalReviews
        ]);
    }

    /**
     * Get success rate
     */
    public function getSuccessRateAttribute(): float
    {
        if ($this->total_sessions === 0) {
            return 0;
        }

        $completedSessions = $this->sessions()
            ->where('status', 'completed')
            ->count();

        return round(($completedSessions / $this->total_sessions) * 100, 1);
    }

    /**
     * Get response time in hours
     */
    public function getAverageResponseTimeAttribute(): ?float
    {
        $avgHours = $this->mentorshipRequests()
            ->whereNotNull('responded_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, responded_at)) as avg_hours')
            ->value('avg_hours');

        return $avgHours ? round($avgHours, 1) : null;
    }
}