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
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'pages' => 'integer',
        'downloads' => 'integer',
        'views' => 'integer',
        'publication_year' => 'integer',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
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
     * Obtient le libellé du statut en français
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'approved' => 'Approuvé',
            'pending' => 'En attente',
            'rejected' => 'Rejeté',
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
            default => 'bg-gray-100 text-gray-800'
        };
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