<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MentorshipRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'mentor_id',
        'subject',
        'level',
        'message',
        'goals',
        'preferred_schedule',
        'status',
    ];

    protected $casts = [
        'preferred_schedule' => 'array',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class);
    }
}
