<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReservationController extends Controller
{
    /**
     * Display reservations list
     */
    public function index()
    {
        $reservations = Reservation::with('book')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('user.reservations.index', compact('reservations'));
    }
    
    /**
     * Display active reservations
     */
    public function active()
    {
        $reservations = Reservation::with('book')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('expires_at', '>', now())
            ->orderBy('priority', 'desc')
            ->orderBy('reserved_at', 'asc')
            ->paginate(10);
            
        return view('user.reservations.active', compact('reservations'));
    }
    
    /**
     * Display reservation history
     */
    public function history()
    {
        $reservations = Reservation::with('book')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['cancelled', 'expired'])
            ->orWhere('expires_at', '<=', now())
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('user.reservations.history', compact('reservations'));
    }
    
    /**
     * Create a new reservation
     */
    public function create(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);
        
        // Check if book is available
        $book = Book::findOrFail($request->book_id);
        
        // Check if user already has a reservation for this book
        $existingReservation = Reservation::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();
            
        if ($existingReservation) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà une réservation pour ce livre'
            ], 400);
        }
        
        // Create reservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'reserved_at' => now(),
            'expires_at' => now()->addDays(3),
            'status' => 'pending',
            'priority' => 0
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Réservation créée avec succès',
            'reservation' => $reservation
        ]);
    }
    
    /**
     * Cancel a reservation
     */
    public function cancel(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id'
        ]);
        
        $reservation = Reservation::where('id', $request->reservation_id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'confirmed'])
            ->firstOrFail();
            
        $reservation->update(['status' => 'cancelled']);
        
        return response()->json([
            'success' => true,
            'message' => 'Réservation annulée'
        ]);
    }
    
    /**
     * Confirm a reservation
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id'
        ]);
        
        $reservation = Reservation::where('id', $request->reservation_id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();
            
        $reservation->update([
            'status' => 'confirmed',
            'expires_at' => now()->addDays(7)
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Réservation confirmée'
        ]);
    }
    
    /**
     * Check book availability
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);
        
        $book = Book::findOrFail($request->book_id);
        
        // Check active borrowings
        $activeBorrowings = $book->borrowings()
            ->where('status', 'active')
            ->count();
            
        // Check pending reservations
        $pendingReservations = $book->reservations()
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('expires_at', '>', now())
            ->count();
            
        $available = true; // Simplified - implement your availability logic
        
        return response()->json([
            'available' => $available,
            'active_borrowings' => $activeBorrowings,
            'pending_reservations' => $pendingReservations
        ]);
    }
}