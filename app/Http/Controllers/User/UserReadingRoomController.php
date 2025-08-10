<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\ReadingSession;
use App\Models\Bookmark;
use App\Models\Note;
use App\Models\Highlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReadingRoomController extends Controller
{
    /**
     * Display the reading room dashboard
     */
    public function index()
    {
        $currentlyReading = ReadingSession::with('book')
            ->where('user_id', Auth::id())
            ->whereNull('ended_at')
            ->orderBy('started_at', 'desc')
            ->get();

        $recentBooks = ReadingSession::with('book')
            ->where('user_id', Auth::id())
            ->whereNotNull('ended_at')
            ->orderBy('ended_at', 'desc')
            ->limit(5)
            ->get()
            ->unique('book_id');

        return view('user.reading-room.index', compact('currentlyReading', 'recentBooks'));
    }

    /**
     * Read a specific book
     */
    public function read($id)
    {
        $book = Book::findOrFail($id);
        
        // Check if user has access to this book
        $hasAccess = Auth::user()->borrowings()
            ->where('book_id', $id)
            ->where('status', 'active')
            ->exists();

        if (!$hasAccess && !Auth::user()->isAdmin()) {
            return redirect()->route('books.public.show', $book)
                ->with('error', 'Vous devez emprunter ce livre pour le lire.');
        }

        // Get or create reading session
        $session = ReadingSession::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'book_id' => $id,
                'ended_at' => null
            ],
            [
                'started_at' => now(),
                'current_page' => 1,
                'current_position' => 0
            ]
        );

        // Get user's bookmarks, notes, and highlights
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->where('book_id', $id)
            ->orderBy('page_number')
            ->get();

        $notes = Note::where('user_id', Auth::id())
            ->where('book_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $highlights = Highlight::where('user_id', Auth::id())
            ->where('book_id', $id)
            ->get();

        return view('user.reading-room.read', compact('book', 'session', 'bookmarks', 'notes', 'highlights'));
    }

    /**
     * Display current reading session
     */
    public function current()
    {
        $sessions = ReadingSession::with('book')
            ->where('user_id', Auth::id())
            ->whereNull('ended_at')
            ->orderBy('started_at', 'desc')
            ->paginate(10);

        return view('user.reading-room.current', compact('sessions'));
    }

    /**
     * Display bookmarks
     */
    public function bookmarks()
    {
        $bookmarks = Bookmark::with('book')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('user.reading-room.bookmarks', compact('bookmarks'));
    }

    /**
     * Display notes
     */
    public function notes()
    {
        $notes = Note::with('book')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('user.reading-room.notes', compact('notes'));
    }

    /**
     * Display highlights
     */
    public function highlights()
    {
        $highlights = Highlight::with('book')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('user.reading-room.highlights', compact('highlights'));
    }

    /**
     * Start a reading session
     */
    public function startSession(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        $session = ReadingSession::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'started_at' => now(),
            'device_type' => $request->header('User-Agent'),
            'ip_address' => $request->ip()
        ]);

        return response()->json([
            'success' => true,
            'session_id' => $session->id
        ]);
    }

    /**
     * End a reading session
     */
    public function endSession(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:reading_sessions,id'
        ]);

        $session = ReadingSession::where('id', $request->session_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $session->update([
            'ended_at' => now(),
            'duration_seconds' => now()->diffInSeconds($session->started_at)
        ]);

        return response()->json([
            'success' => true,
            'duration' => $session->duration_seconds
        ]);
    }

    /**
     * Update reading progress
     */
    public function updateProgress(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:reading_sessions,id',
            'current_page' => 'required|integer|min:1',
            'current_position' => 'required|numeric|min:0|max:100'
        ]);

        $session = ReadingSession::where('id', $request->session_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $session->update([
            'current_page' => $request->current_page,
            'current_position' => $request->current_position,
            'pages_read' => max($session->pages_read, $request->current_page)
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Add a bookmark
     */
    public function addBookmark(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'page_number' => 'required|integer|min:1',
            'title' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:500'
        ]);

        $bookmark = Bookmark::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'page_number' => $request->page_number,
            'title' => $request->title ?? 'Page ' . $request->page_number,
            'note' => $request->note
        ]);

        return response()->json([
            'success' => true,
            'bookmark' => $bookmark
        ]);
    }

    /**
     * Remove a bookmark
     */
    public function removeBookmark(Request $request)
    {
        $request->validate([
            'bookmark_id' => 'required|exists:bookmarks,id'
        ]);

        Bookmark::where('id', $request->bookmark_id)
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Add a note
     */
    public function addNote(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'page_number' => 'nullable|integer|min:1',
            'content' => 'required|string|max:2000',
            'chapter' => 'nullable|string|max:255'
        ]);

        $note = Note::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'page_number' => $request->page_number,
            'content' => $request->content,
            'chapter' => $request->chapter
        ]);

        return response()->json([
            'success' => true,
            'note' => $note
        ]);
    }

    /**
     * Update a note
     */
    public function updateNote(Request $request)
    {
        $request->validate([
            'note_id' => 'required|exists:notes,id',
            'content' => 'required|string|max:2000'
        ]);

        $note = Note::where('id', $request->note_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $note->update([
            'content' => $request->content
        ]);

        return response()->json([
            'success' => true,
            'note' => $note
        ]);
    }

    /**
     * Delete a note
     */
    public function deleteNote(Request $request)
    {
        $request->validate([
            'note_id' => 'required|exists:notes,id'
        ]);

        Note::where('id', $request->note_id)
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json([
            'success' => true
        ]);
    }
}