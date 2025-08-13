<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'parents';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'phone_number',
        'preferred_language',
        'can_read',
        'preferred_call_time',
        'enrolled_mama_ecole',
        'enrollment_date',
        'total_calls_received',
        'total_calls_answered',
        'engagement_score',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'can_read' => 'boolean',
        'enrolled_mama_ecole' => 'boolean',
        'enrollment_date' => 'datetime',
        'engagement_score' => 'decimal:2',
    ];

    /**
     * Get the students for the parent.
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'parent_student', 'parent_id', 'student_id')
            ->withPivot('relationship', 'is_primary_contact')
            ->withTimestamps();
    }

    /**
     * Get the interactions for the parent.
     */
    public function interactions()
    {
        return $this->hasMany(MamaEcoleInteraction::class, 'parent_id');
    }

    /**
     * Get the voice messages for the parent.
     */
    public function voiceMessages()
    {
        return $this->hasMany(ParentVoiceMessage::class, 'parent_id');
    }

    /**
     * Get the feedback for the parent.
     */
    public function feedback()
    {
        return $this->hasMany(ParentFeedback::class, 'parent_id');
    }

    /**
     * Get the rewards for the parent.
     */
    public function rewards()
    {
        return $this->hasMany(MamaEcoleReward::class, 'parent_id');
    }

    /**
     * Calculate engagement score
     */
    public function calculateEngagementScore()
    {
        if ($this->total_calls_received == 0) {
            return 0;
        }

        $answerRate = ($this->total_calls_answered / $this->total_calls_received) * 100;
        
        // Add other factors like feedback, voice messages, etc.
        $interactionScore = $this->interactions()->where('listened_full', true)->count() * 5;
        $feedbackScore = $this->feedback()->count() * 10;
        
        return min(100, $answerRate + $interactionScore + $feedbackScore);
    }

    /**
     * Get formatted phone number
     */
    public function getFormattedPhoneAttribute()
    {
        // Format: +225 07 XX XX XX XX
        return preg_replace('/(\+225)(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1 $2 $3 $4 $5 $6', $this->phone_number);
    }

    /**
     * Get language display name
     */
    public function getLanguageDisplayAttribute()
    {
        $languages = [
            'french' => 'Français',
            'dioula' => 'Dioula',
            'baoule' => 'Baoulé',
            'bete' => 'Bété',
            'senoufo' => 'Sénoufo'
        ];

        return $languages[$this->preferred_language] ?? $this->preferred_language;
    }
}