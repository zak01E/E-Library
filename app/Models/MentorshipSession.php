<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MentorshipSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'student_id',
        'mentorship_request_id',
        'subject',
        'status',
        'scheduled_at',
        'started_at',
        'ended_at',
        'duration_minutes',
        'notes',
        'mentor_notes',
        'session_type',
        'meeting_url',
        'location',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function mentorshipRequest(): BelongsTo
    {
        return $this->belongsTo(MentorshipRequest::class);
    }
}
