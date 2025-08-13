<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'author_name',
        'isbn',
        'publisher',
        'publication_year',
        'category',
        'language',
        'pages',
        'pdf_path',
        'cover_image',
        'uploaded_by',
        'is_approved',
        'status',
        'status_reason',
        'status_changed_at',
        'status_changed_by',
        'is_public',
        'visibility',
        'views',
        'downloads',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_public' => 'boolean',
        'pages' => 'integer',
        'downloads' => 'integer',
        'views' => 'integer',
        'publication_year' => 'integer',
        'status_changed_at' => 'datetime',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Relation avec la catégorie
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'name');
    }

    /**
     * Relation avec l'utilisateur qui a changé le statut
     */
    public function statusChangedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'status_changed_by');
    }

    /**
     * Relation avec l'historique des changements de statut
     */
    public function statusHistory()
    {
        return $this->hasMany(BookStatusHistory::class)->orderBy('created_at', 'desc');
    }

    /**
     * Vérifie si le fichier PDF existe physiquement
     */
    public function pdfExists(): bool
    {
        if (!$this->pdf_path) {
            return false;
        }

        return file_exists(storage_path('app/' . $this->pdf_path));
    }

    /**
     * Vérifie si le livre est approuvé
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Vérifie si le livre est en attente
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Vérifie si le livre est rejeté
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Vérifie si le livre est en révision
     */
    public function isUnderReview(): bool
    {
        return $this->status === 'under_review';
    }

    /**
     * Vérifie si le livre est suspendu
     */
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /**
     * Vérifie si le livre est visible au public
     */
    public function isPubliclyVisible(): bool
    {
        return $this->is_public && in_array($this->status, ['approved']);
    }

    /**
     * Vérifie si le livre peut être téléchargé
     */
    public function isDownloadable(): bool
    {
        return $this->status === 'approved' && $this->is_public;
    }

    /**
     * Obtient le libellé du statut en français
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'approved' => 'Approuvé',
            'pending' => 'En attente',
            'rejected' => 'Rejeté',
            'under_review' => 'En révision',
            'suspended' => 'Suspendu',
            default => 'Inconnu'
        };
    }

    /**
     * Obtient la classe CSS pour le badge de statut
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'approved' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'rejected' => 'bg-red-100 text-red-800',
            'under_review' => 'bg-blue-100 text-blue-800',
            'suspended' => 'bg-orange-100 text-orange-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }



    /**
     * Change le statut du livre et enregistre l'historique
     */
    public function changeStatus(string $newStatus, string $reason = null, string $adminNotes = null, int $changedBy = null): void
    {
        $oldStatus = $this->status;

        // Mettre à jour le livre
        $this->update([
            'status' => $newStatus,
            'status_reason' => $reason,
            'status_changed_at' => now(),
            'status_changed_by' => $changedBy ?? auth()->id(),
            'is_approved' => $newStatus === 'approved',
            'is_public' => in_array($newStatus, ['approved']) // Seuls les livres approuvés sont publics par défaut
        ]);

        // Enregistrer dans l'historique
        BookStatusHistory::create([
            'book_id' => $this->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'reason' => $reason,
            'admin_notes' => $adminNotes,
            'changed_by' => $changedBy ?? auth()->id(),
        ]);
    }

    /**
     * Obtient la taille du fichier PDF en MB de manière sécurisée
     */
    public function getPdfSizeMB(): ?float
    {
        if (!$this->pdfExists()) {
            return null;
        }

        $sizeBytes = filesize(storage_path('app/' . $this->pdf_path));
        return round($sizeBytes / 1024 / 1024, 2);
    }

    /**
     * Obtient le chemin complet du fichier PDF
     */
    public function getPdfPath(): ?string
    {
        if (!$this->pdf_path) {
            return null;
        }

        return storage_path('app/' . $this->pdf_path);
    }

    /**
     * Obtient le nom du fichier PDF
     */
    public function getPdfFilename(): ?string
    {
        if (!$this->pdf_path) {
            return null;
        }

        return basename($this->pdf_path);
    }
}