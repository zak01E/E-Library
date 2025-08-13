<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MentorReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'student_id',
        'mentorship_session_id',
        'rating',
        'comment',
        'is_verified',
        'is_anonymous',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_anonymous' => 'boolean',
    ];

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function mentorshipSession(): BelongsTo
    {
        return $this->belongsTo(MentorshipSession::class);
    }
}
