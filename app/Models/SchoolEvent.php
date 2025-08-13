<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class SchoolEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'level',
        'target_classes',
        'regions',
        'color',
        'icon',
        'is_national',
        'is_recurring',
        'recurrence_pattern',
        'importance',
        'status',
        'documents',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'target_classes' => 'array',
        'regions' => 'array',
        'documents' => 'array',
        'is_national' => 'boolean',
        'is_recurring' => 'boolean',
    ];

    /**
     * Get the creator of the event
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope for upcoming events
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->toDateString())
                    ->orderBy('start_date', 'asc');
    }

    /**
     * Scope for current month events
     */
    public function scopeCurrentMonth($query)
    {
        return $query->whereMonth('start_date', now()->month)
                    ->whereYear('start_date', now()->year);
    }

    /**
     * Get type label
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'exam' => 'Examen',
            'holiday' => 'Vacances',
            'orientation' => 'Orientation',
            'registration' => 'Inscription',
            'result' => 'Résultats',
            'ceremony' => 'Cérémonie',
            default => 'Autre'
        };
    }

    /**
     * Get type color
     */
    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'exam' => '#ef4444', // red
            'holiday' => '#3b82f6', // blue
            'orientation' => '#eab308', // yellow
            'registration' => '#22c55e', // green
            'result' => '#a855f7', // purple
            'ceremony' => '#f97316', // orange
            default => '#6b7280' // gray
        };
    }

    /**
     * Get formatted date range
     */
    public function getDateRangeAttribute(): string
    {
        if (!$this->end_date || $this->start_date->equalTo($this->end_date)) {
            return $this->start_date->format('d M');
        }
        
        if ($this->start_date->month === $this->end_date->month) {
            return $this->start_date->format('d') . '-' . $this->end_date->format('d M');
        }
        
        return $this->start_date->format('d M') . ' - ' . $this->end_date->format('d M');
    }

    /**
     * Check if event is ongoing
     */
    public function getIsOngoingAttribute(): bool
    {
        $today = now()->toDateString();
        return $this->start_date <= $today && 
               ($this->end_date ? $this->end_date >= $today : $this->start_date == $today);
    }

    /**
     * Get days until event
     */
    public function getDaysUntilAttribute(): ?int
    {
        if ($this->start_date->isPast()) {
            return null;
        }
        
        return now()->diffInDays($this->start_date);
    }

    /**
     * Get level label
     */
    public function getLevelLabelAttribute(): string
    {
        return match($this->level) {
            'primaire' => 'Primaire',
            'college' => 'Collège',
            'lycee' => 'Lycée',
            'superieur' => 'Supérieur',
            default => 'Tous niveaux'
        };
    }

    /**
     * Update event status based on dates
     */
    public function updateStatus()
    {
        $today = now()->toDateString();
        
        if ($this->start_date > $today) {
            $this->status = 'upcoming';
        } elseif ($this->end_date && $this->end_date < $today) {
            $this->status = 'completed';
        } elseif ($this->start_date <= $today) {
            $this->status = 'ongoing';
        }
        
        $this->save();
    }
}