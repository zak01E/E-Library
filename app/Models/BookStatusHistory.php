<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'old_status',
        'new_status',
        'reason',
        'admin_notes',
        'changed_by',
        'notification_sent',
    ];

    protected $casts = [
        'notification_sent' => 'boolean',
    ];

    /**
     * Relation avec le livre
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Relation avec l'utilisateur qui a fait le changement
     */
    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    /**
     * Obtient le libellé du statut en français
     */
    public function getStatusLabel(string $status): string
    {
        return match($status) {
            'approved' => 'Approuvé',
            'pending' => 'En attente',
            'rejected' => 'Rejeté',
            'under_review' => 'En révision',
            'suspended' => 'Suspendu',
            default => 'Inconnu'
        };
    }

    /**
     * Obtient le libellé de l'ancien statut
     */
    public function getOldStatusLabelAttribute(): string
    {
        return $this->old_status ? $this->getStatusLabel($this->old_status) : 'Nouveau';
    }

    /**
     * Obtient le libellé du nouveau statut
     */
    public function getNewStatusLabelAttribute(): string
    {
        return $this->getStatusLabel($this->new_status);
    }

    /**
     * Obtient la classe CSS pour le badge de l'ancien statut
     */
    public function getOldStatusBadgeClassAttribute(): string
    {
        if (!$this->old_status) return 'bg-gray-100 text-gray-800';

        return match($this->old_status) {
            'approved' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'rejected' => 'bg-red-100 text-red-800',
            'under_review' => 'bg-blue-100 text-blue-800',
            'suspended' => 'bg-orange-100 text-orange-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Obtient la classe CSS pour le badge du nouveau statut
     */
    public function getNewStatusBadgeClassAttribute(): string
    {
        return match($this->new_status) {
            'approved' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'rejected' => 'bg-red-100 text-red-800',
            'under_review' => 'bg-blue-100 text-blue-800',
            'suspended' => 'bg-orange-100 text-orange-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}
