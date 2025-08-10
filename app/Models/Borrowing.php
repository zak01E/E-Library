<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
        'renewal_count',
        'notes',
        'fine_amount',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
        'renewal_count' => 'integer',
        'fine_amount' => 'decimal:2',
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_RETURNED = 'returned';
    const STATUS_OVERDUE = 'overdue';
    const STATUS_LOST = 'lost';
    const STATUS_DAMAGED = 'damaged';

    /**
     * Get the user that borrowed the book.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was borrowed.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Scope to get active borrowings
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope to get overdue borrowings
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', self::STATUS_OVERDUE)
                    ->orWhere(function ($q) {
                        $q->where('status', self::STATUS_ACTIVE)
                          ->where('due_date', '<', now());
                    });
    }

    /**
     * Scope to get returned borrowings
     */
    public function scopeReturned($query)
    {
        return $query->where('status', self::STATUS_RETURNED);
    }

    /**
     * Scope to get borrowings for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Check if borrowing is overdue
     */
    public function getIsOverdueAttribute()
    {
        return $this->status === self::STATUS_ACTIVE && $this->due_date < now();
    }

    /**
     * Get days until due or overdue
     */
    public function getDaysUntilDueAttribute()
    {
        if ($this->status !== self::STATUS_ACTIVE) {
            return null;
        }

        return now()->diffInDays($this->due_date, false);
    }

    /**
     * Get formatted due status
     */
    public function getDueStatusAttribute()
    {
        if ($this->status !== self::STATUS_ACTIVE) {
            return ucfirst($this->status);
        }

        $days = $this->days_until_due;
        
        if ($days < 0) {
            return 'En retard de ' . abs($days) . ' jour(s)';
        } elseif ($days == 0) {
            return 'À rendre aujourd\'hui';
        } elseif ($days == 1) {
            return 'À rendre demain';
        } else {
            return 'À rendre dans ' . $days . ' jours';
        }
    }

    /**
     * Check if borrowing can be renewed
     */
    public function canBeRenewed()
    {
        return $this->status === self::STATUS_ACTIVE 
            && $this->renewal_count < 3 
            && !$this->is_overdue;
    }

    /**
     * Renew the borrowing
     */
    public function renew($days = 14)
    {
        if (!$this->canBeRenewed()) {
            return false;
        }

        $this->due_date = $this->due_date->addDays($days);
        $this->renewal_count++;
        $this->save();

        return true;
    }

    /**
     * Return the book
     */
    public function returnBook()
    {
        $this->status = self::STATUS_RETURNED;
        $this->returned_at = now();
        $this->save();

        return $this;
    }

    /**
     * Mark as lost
     */
    public function markAsLost($fineAmount = null)
    {
        $this->status = self::STATUS_LOST;
        $this->fine_amount = $fineAmount;
        $this->save();

        return $this;
    }

    /**
     * Create a new borrowing
     */
    public static function createBorrowing($userId, $bookId, $daysToReturn = 14)
    {
        return static::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'borrowed_at' => now(),
            'due_date' => now()->addDays($daysToReturn),
            'status' => self::STATUS_ACTIVE,
            'renewal_count' => 0,
        ]);
    }

    /**
     * Update overdue status for all active borrowings
     */
    public static function updateOverdueStatus()
    {
        return static::where('status', self::STATUS_ACTIVE)
            ->where('due_date', '<', now())
            ->update(['status' => self::STATUS_OVERDUE]);
    }
}
