<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookStatusHistory;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BookStatusNotificationService
{
    /**
     * Envoie une notification à l'auteur lors du changement de statut
     */
    public function notifyAuthor(BookStatusHistory $statusHistory): void
    {
        try {
            $book = $statusHistory->book;
            $author = $book->uploader;
            
            if (!$author || !$author->email) {
                Log::warning("Impossible d'envoyer la notification : auteur ou email manquant", [
                    'book_id' => $book->id,
                    'status_history_id' => $statusHistory->id
                ]);
                return;
            }

            $emailData = $this->prepareEmailData($book, $statusHistory);
            
            // Pour l'instant, on simule l'envoi d'email en loggant
            // Dans un vrai projet, vous utiliseriez Mail::send() ou une queue
            Log::info("Notification envoyée à l'auteur", [
                'author_email' => $author->email,
                'book_title' => $book->title,
                'old_status' => $statusHistory->old_status,
                'new_status' => $statusHistory->new_status,
                'reason' => $statusHistory->reason
            ]);

            // Marquer la notification comme envoyée
            $statusHistory->update(['notification_sent' => true]);
            
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de notification", [
                'error' => $e->getMessage(),
                'book_id' => $statusHistory->book_id,
                'status_history_id' => $statusHistory->id
            ]);
        }
    }

    /**
     * Prépare les données pour l'email
     */
    private function prepareEmailData(Book $book, BookStatusHistory $statusHistory): array
    {
        $messages = [
            'approved' => [
                'subject' => '✅ Votre livre a été approuvé !',
                'message' => 'Félicitations ! Votre livre est maintenant visible par tous les utilisateurs.',
                'action' => 'Voir mon livre',
                'action_url' => route('books.public.show', $book)
            ],
            'rejected' => [
                'subject' => '❌ Votre livre a été rejeté',
                'message' => 'Votre livre ne respecte pas nos critères de publication.',
                'action' => 'Voir les détails',
                'action_url' => route('author.books.show', $book)
            ],
            'under_review' => [
                'subject' => '🔍 Votre livre est en révision',
                'message' => 'Votre livre fait l\'objet d\'une révision supplémentaire.',
                'action' => 'Voir les détails',
                'action_url' => route('author.books.show', $book)
            ],
            'suspended' => [
                'subject' => '⚠️ Votre livre a été suspendu',
                'message' => 'Votre livre a été temporairement retiré de la publication.',
                'action' => 'Voir les détails',
                'action_url' => route('author.books.show', $book)
            ],
            'pending' => [
                'subject' => '⏳ Votre livre est en attente de révision',
                'message' => 'Votre livre a été remis en attente de validation.',
                'action' => 'Voir les détails',
                'action_url' => route('author.books.show', $book)
            ]
        ];

        $statusData = $messages[$statusHistory->new_status] ?? [
            'subject' => 'Changement de statut de votre livre',
            'message' => 'Le statut de votre livre a été modifié.',
            'action' => 'Voir les détails',
            'action_url' => route('author.books.show', $book)
        ];

        return [
            'book' => $book,
            'author' => $book->uploader,
            'old_status_label' => $statusHistory->old_status_label,
            'new_status_label' => $statusHistory->new_status_label,
            'reason' => $statusHistory->reason,
            'changed_by' => $statusHistory->changedBy,
            'changed_at' => $statusHistory->created_at,
            ...$statusData
        ];
    }

    /**
     * Obtient les statistiques des notifications
     */
    public function getNotificationStats(): array
    {
        return [
            'total_sent' => BookStatusHistory::where('notification_sent', true)->count(),
            'pending_notifications' => BookStatusHistory::where('notification_sent', false)->count(),
            'by_status' => BookStatusHistory::selectRaw('new_status, COUNT(*) as count, SUM(notification_sent) as sent')
                ->groupBy('new_status')
                ->get()
                ->keyBy('new_status')
                ->toArray()
        ];
    }

    /**
     * Envoie les notifications en attente (pour les tâches cron)
     */
    public function sendPendingNotifications(): int
    {
        $pendingNotifications = BookStatusHistory::with(['book.uploader', 'changedBy'])
            ->where('notification_sent', false)
            ->where('created_at', '>', now()->subDays(7)) // Seulement les 7 derniers jours
            ->get();

        $sent = 0;
        foreach ($pendingNotifications as $notification) {
            $this->notifyAuthor($notification);
            $sent++;
        }

        return $sent;
    }
}
