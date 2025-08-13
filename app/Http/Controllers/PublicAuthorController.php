<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;

class PublicAuthorController extends Controller
{
    /**
     * Display a listing of all authors
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'author')
            ->withCount(['books as approved_books_count' => function ($query) {
                $query->where('status', 'approved');
            }])
            ->with(['books' => function ($query) {
                $query->where('status', 'approved');
            }])
            ->having('approved_books_count', '>', 0); // Only authors with approved books

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('author_bio', 'like', "%{$search}%");
            });
        }

        // Sort functionality
        $sort = $request->get('sort', 'popular');
        switch ($sort) {
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'books':
                $query->orderBy('approved_books_count', 'desc');
                break;
            case 'popular':
            default:
                $query->withSum(['books as total_views' => function ($query) {
                    $query->where('status', 'approved');
                }], 'views')
                ->orderBy('total_views', 'desc');
                break;
        }

        $authors = $query->paginate(12)->withQueryString();

        return view('authors.public', compact('authors'));
    }

    /**
     * Display the specified author's profile and books
     */
    public function show(User $author)
    {
        // Ensure the user is an author
        if ($author->role !== 'author') {
            abort(404);
        }

        // Get author's approved books
        $books = $author->books()
            ->where('status', 'approved')
            ->with(['uploader'])
            ->latest()
            ->paginate(12);

        // Calculate author stats
        $stats = [
            'total_books' => $author->books()->where('status', 'approved')->count(),
            'total_downloads' => $author->books()->where('status', 'approved')->sum('downloads'),
            'total_views' => $author->books()->where('status', 'approved')->sum('views'),
            'member_since' => $author->created_at,
        ];

        // Get popular books
        $popularBooks = $author->books()
            ->where('status', 'approved')
            ->orderBy('views', 'desc')
            ->take(3)
            ->get();

        // Get recent books
        $recentBooks = $author->books()
            ->where('status', 'approved')
            ->latest()
            ->take(3)
            ->get();

        return view('authors.show', compact('author', 'books', 'stats', 'popularBooks', 'recentBooks'));
    }
}
