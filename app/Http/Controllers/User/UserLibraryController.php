<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\UserFavorite;
use App\Models\UserReadingList;
use App\Models\ReadingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserLibraryController extends Controller
{
    /**
     * Display current borrowings
     */
    public function current()
    {
        try {
            $borrowings = Borrowing::with('book')
                ->where('user_id', Auth::id())
                ->where('status', 'active')
                ->orderBy('due_date', 'asc')
                ->paginate(12);

            $overdueCount = Borrowing::where('user_id', Auth::id())
                ->where('status', 'overdue')
                ->count();

            // Get current reading books (same as borrowings for now)
            $currentBooks = $borrowings;

            // Calculate statistics (mock data for now)
            $averageProgress = 65;
            $weeklyReadingTime = '8h 30min';
            $monthlyGoal = 5;

        } catch (\Exception $e) {
            // If table doesn't exist or other error, return empty data
            $borrowings = collect()->paginate(12);
            $overdueCount = 0;
            $currentBooks = collect();
            $averageProgress = 0;
            $weeklyReadingTime = '0h';
            $monthlyGoal = 5;
        }

        return view('user.library.current', compact('borrowings', 'overdueCount', 'currentBooks', 'averageProgress', 'weeklyReadingTime', 'monthlyGoal'));
    }

    /**
     * Display borrowing history
     */
    public function history()
    {
        try {
            $history = Borrowing::with('book')
                ->where('user_id', Auth::id())
                ->whereIn('status', ['returned', 'overdue', 'lost'])
                ->orderBy('returned_at', 'desc')
                ->paginate(20);

            // Get read books (same as history for now)
            $readBooks = $history;

            $stats = [
                'total_borrowed' => Borrowing::where('user_id', Auth::id())->count(),
                'currently_reading' => Borrowing::where('user_id', Auth::id())
                    ->where('status', 'active')->count(),
                'total_read' => Borrowing::where('user_id', Auth::id())
                    ->where('status', 'returned')->count(),
            ];
        } catch (\Exception $e) {
            // If table doesn't exist or other error, return empty data
            $history = collect()->paginate(20);
            $readBooks = collect();
            $stats = [
                'total_borrowed' => 0,
                'currently_reading' => 0,
                'total_read' => 0,
            ];
        }

        return view('user.library.history', compact('history', 'stats', 'readBooks'));
    }

    /**
     * Display favorite books
     */
    public function favorites()
    {
        try {
            $favorites = UserFavorite::with('book')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        } catch (\Exception $e) {
            // If table doesn't exist or other error, return empty data
            $favorites = collect()->paginate(12);
        }

        return view('user.library.favorites', compact('favorites'));
    }

    /**
     * Add book to favorites
     */
    public function addToFavorites(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        UserFavorite::firstOrCreate([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Livre ajouté aux favoris'
        ]);
    }

    /**
     * Remove book from favorites
     */
    public function removeFromFavorites(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        UserFavorite::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Livre retiré des favoris'
        ]);
    }

    /**
     * Display reading list (wishlist)
     */
    public function wishlist()
    {
        $wishlist = UserReadingList::with('book')
            ->where('user_id', Auth::id())
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('user.library.wishlist', compact('wishlist'));
    }

    /**
     * Add book to reading list
     */
    public function addToWishlist(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'priority' => 'nullable|integer|min:0|max:10',
            'notes' => 'nullable|string|max:500'
        ]);

        UserReadingList::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'book_id' => $request->book_id
            ],
            [
                'priority' => $request->priority ?? 5,
                'notes' => $request->notes
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Livre ajouté à votre liste de lecture'
        ]);
    }

    /**
     * Display currently reading books
     */
    public function reading()
    {
        $currentlyReading = ReadingSession::with('book')
            ->where('user_id', Auth::id())
            ->whereNull('ended_at')
            ->orderBy('started_at', 'desc')
            ->get()
            ->unique('book_id');

        $recentSessions = ReadingSession::with('book')
            ->where('user_id', Auth::id())
            ->whereNotNull('ended_at')
            ->orderBy('ended_at', 'desc')
            ->limit(10)
            ->get();

        return view('user.library.reading', compact('currentlyReading', 'recentSessions'));
    }

    /**
     * Borrow a book
     */
    public function borrowBook(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        // Check if user has already borrowed this book
        $existingBorrow = Borrowing::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->where('status', 'active')
            ->first();

        if ($existingBorrow) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà emprunté ce livre'
            ], 400);
        }

        // Check borrowing limit
        $activeBorrowings = Borrowing::where('user_id', Auth::id())
            ->where('status', 'active')
            ->count();

        $borrowLimit = Auth::user()->subscription_type === 'premium' ? 10 : 5;

        if ($activeBorrowings >= $borrowLimit) {
            return response()->json([
                'success' => false,
                'message' => "Vous avez atteint votre limite d'emprunts ({$borrowLimit} livres)"
            ], 400);
        }

        // Create borrowing
        $borrowing = Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'active'
        ]);

        // Start reading session
        ReadingSession::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'started_at' => now(),
            'device_type' => $request->header('User-Agent'),
            'ip_address' => $request->ip()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Livre emprunté avec succès',
            'borrowing' => $borrowing
        ]);
    }

    /**
     * Return a borrowed book
     */
    public function returnBook(Request $request)
    {
        $request->validate([
            'borrowing_id' => 'required|exists:borrowings,id'
        ]);

        $borrowing = Borrowing::where('id', $request->borrowing_id)
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->firstOrFail();

        $borrowing->update([
            'status' => 'returned',
            'returned_at' => now()
        ]);

        // End reading sessions
        ReadingSession::where('user_id', Auth::id())
            ->where('book_id', $borrowing->book_id)
            ->whereNull('ended_at')
            ->update(['ended_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Livre retourné avec succès'
        ]);
    }

    /**
     * Extend borrowing period
     */
    public function extendBorrowing(Request $request)
    {
        $request->validate([
            'borrowing_id' => 'required|exists:borrowings,id'
        ]);

        $borrowing = Borrowing::where('id', $request->borrowing_id)
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->firstOrFail();

        // Check extension limit
        if ($borrowing->extended_count >= 2) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez atteint la limite de prolongations'
            ], 400);
        }

        $borrowing->update([
            'due_date' => $borrowing->due_date->addDays(7),
            'extended_count' => $borrowing->extended_count + 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Emprunt prolongé de 7 jours',
            'new_due_date' => $borrowing->due_date->format('Y-m-d')
        ]);
    }
}