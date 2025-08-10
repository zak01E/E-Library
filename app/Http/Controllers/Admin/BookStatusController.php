<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookStatusHistory;
use App\Services\BookStatusNotificationService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookStatusController extends Controller
{
    protected BookStatusNotificationService $notificationService;

    public function __construct()
    {
        // $this->notificationService = $notificationService;
    }

    /**
     * Change le statut d'un livre
     */
    public function changeStatus(Request $request, Book $book): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,under_review,suspended',
            'reason' => 'nullable|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000',
            'notify_author' => 'boolean'
        ]);

        $oldStatus = $book->status;
        $newStatus = $request->status;

        // Vérifications de sécurité
        if ($oldStatus === $newStatus) {
            return redirect()->back()->with('warning', 'Le livre a déjà ce statut.');
        }

        // Logique métier pour certains changements
        $reason = $request->reason;
        if (empty($reason)) {
            $reason = $this->getDefaultReason($oldStatus, $newStatus);
        }

        // Changer le statut
        $book->changeStatus(
            $newStatus,
            $reason,
            $request->admin_notes,
            auth()->id()
        );

        // Envoyer la notification si demandé (temporairement désactivé)
        // if ($request->boolean('notify_author', true)) {
        //     $latestHistory = $book->statusHistory()->latest()->first();
        //     if ($latestHistory) {
        //         $this->notificationService->notifyAuthor($latestHistory);
        //     }
        // }

        $message = $this->getSuccessMessage($oldStatus, $newStatus);
        return redirect()->back()->with('success', $message);
    }

    /**
     * Affiche l'historique des changements de statut d'un livre
     */
    public function showHistory(Book $book): View
    {
        $history = $book->statusHistory()
            ->with(['changedBy'])
            ->paginate(10);

        return view('admin.books.status-history', compact('book', 'history'));
    }

    /**
     * Affiche les statistiques des statuts
     */
    public function statusStats(): View
    {
        $stats = [
            'by_status' => Book::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get()
                ->keyBy('status'),
            'recent_changes' => BookStatusHistory::with(['book', 'changedBy'])
                ->latest()
                ->take(10)
                ->get(),
            // 'notification_stats' => $this->notificationService->getNotificationStats()
        ];

        return view('admin.books.status-stats', compact('stats'));
    }

    /**
     * Action en lot pour changer plusieurs statuts
     */
    public function bulkStatusChange(Request $request): RedirectResponse
    {
        $request->validate([
            'book_ids' => 'required|array',
            'book_ids.*' => 'exists:books,id',
            'status' => 'required|in:pending,approved,rejected,under_review,suspended',
            'reason' => 'nullable|string|max:1000',
            'notify_authors' => 'boolean'
        ]);

        $books = Book::whereIn('id', $request->book_ids)->get();
        $changed = 0;

        foreach ($books as $book) {
            if ($book->status !== $request->status) {
                $book->changeStatus(
                    $request->status,
                    $request->reason,
                    "Changement en lot",
                    auth()->id()
                );

                // Notification si demandée (temporairement désactivé)
                // if ($request->boolean('notify_authors', false)) {
                //     $latestHistory = $book->statusHistory()->latest()->first();
                //     if ($latestHistory) {
                //         $this->notificationService->notifyAuthor($latestHistory);
                //     }
                // }

                $changed++;
            }
        }

        return redirect()->back()->with('success', "{$changed} livre(s) mis à jour avec succès.");
    }

    /**
     * Obtient une raison par défaut selon le changement de statut
     */
    private function getDefaultReason(string $oldStatus, string $newStatus): string
    {
        return match([$oldStatus, $newStatus]) {
            ['pending', 'approved'] => 'Livre approuvé après révision',
            ['approved', 'under_review'] => 'Révision supplémentaire nécessaire',
            ['approved', 'suspended'] => 'Livre temporairement suspendu',
            ['approved', 'pending'] => 'Remis en attente pour révision',
            ['under_review', 'approved'] => 'Révision terminée, livre approuvé',
            ['suspended', 'approved'] => 'Suspension levée, livre réactivé',
            default => 'Changement de statut administratif'
        };
    }

    /**
     * Obtient le message de succès selon le changement
     */
    private function getSuccessMessage(string $oldStatus, string $newStatus): string
    {
        return match($newStatus) {
            'approved' => '✅ Livre approuvé avec succès !',
            'rejected' => '❌ Livre rejeté.',
            'under_review' => '🔍 Livre mis en révision.',
            'suspended' => '⚠️ Livre suspendu.',
            'pending' => '⏳ Livre remis en attente.',
            default => 'Statut mis à jour.'
        };
    }
}
