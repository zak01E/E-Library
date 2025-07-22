<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('uploader')
            ->when(!auth()->check() || auth()->user()->role !== 'admin', function ($query) {
                $query->where('status', 'approved');
            })
            ->latest()
            ->paginate(12);

        return view('books.index', compact('books'));
    }

    public function create(): View|RedirectResponse
    {
        // Redirect authors to their specific book creation route if they're on the general route
        if (auth()->user()->role === 'author' && !request()->routeIs('author.books.create')) {
            return redirect()->route('author.books.create');
        }

        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author_name' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'category' => 'nullable|string|max:100',
            'language' => 'required|string|max:10',
            'pages' => 'nullable|integer|min:1',
            'pdf_file' => 'required|file|mimes:pdf|max:20480', // 20MB max
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB max
        ]);

        // Handle PDF upload
        $pdfPath = $request->file('pdf_file')->store('books/pdfs', 'public');

        // Handle cover image upload
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('books/covers', 'public');
        }

        $book = Book::create([
            ...$validated,
            'pdf_path' => $pdfPath,
            'cover_image' => $coverPath,
            'uploaded_by' => auth()->id(),
            'is_approved' => auth()->check() && auth()->user()->role === 'admin',
        ]);

        return redirect()->route('books.show', $book)
            ->with('success', 'Book uploaded successfully. ' . 
                (auth()->check() && auth()->user()->role !== 'admin' ? 'It will be visible after admin approval.' : ''));
    }

    public function show(Book $book)
    {
        if ($book->status !== 'approved' && (!auth()->check() || (auth()->user()->role !== 'admin' && auth()->id() !== $book->uploaded_by))) {
            abort(404);
        }

        $book->increment('views');

        return view('admin.book-details', compact('book'));
    }

    public function preview(Book $book)
    {
        if ($book->status !== 'approved') {
            abort(404);
        }

        // Vérifier si le fichier existe
        if (!Storage::disk('public')->exists($book->pdf_path)) {
            abort(404, 'Le fichier PDF n\'existe pas.');
        }

        try {
            $filePath = Storage::disk('public')->path($book->pdf_path);

            // Lire seulement les premières pages (limité pour l'aperçu)
            $headers = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="preview-' . Str::slug($book->title) . '.pdf"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ];

            // Pour l'aperçu, on peut retourner le PDF complet mais avec des restrictions côté client
            return response()->file($filePath, $headers);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'aperçu du livre ID ' . $book->id . ': ' . $e->getMessage());
            abort(404, 'Impossible d\'afficher l\'aperçu.');
        }
    }

    public function download(Book $book)
    {
        if ($book->status !== 'approved' && (!auth()->check() || (auth()->user()->role !== 'admin' && auth()->id() !== $book->uploaded_by))) {
            abort(404);
        }

        // Vérifier si le fichier existe
        if (!Storage::disk('public')->exists($book->pdf_path)) {
            abort(404, 'Le fichier PDF n\'existe pas.');
        }

        $book->increment('downloads');

        try {
            return Storage::disk('public')->download($book->pdf_path, Str::slug($book->title) . '.pdf');
        } catch (\Exception $e) {
            // Log l'erreur pour le débogage
            \Log::error('Erreur lors du téléchargement du livre ID ' . $book->id . ': ' . $e->getMessage());

            return back()->with('error', 'Impossible de télécharger le fichier. Veuillez contacter l\'administrateur.');
        }
    }

    public function approve(Book $book)
    {
        $book->update(['is_approved' => true]);

        return back()->with('success', 'Book approved successfully.');
    }

    public function destroy(Book $book)
    {
        // Delete files
        Storage::disk('public')->delete($book->pdf_path);
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }

    // Public methods for non-authenticated users
    public function publicIndex(Request $request)
    {
        $query = Book::with('uploader')->where('status', 'approved');

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Filter by language
        if ($request->filled('language') && $request->language !== 'all') {
            $query->where('language', $request->language);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort functionality
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'downloads':
                $query->orderBy('downloads', 'desc');
                break;
            case 'alphabetical':
                $query->orderBy('title', 'asc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $books = $query->paginate(12)->withQueryString();

        // Get unique categories and languages for filters
        $categories = Book::where('status', 'approved')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort();

        $languages = Book::where('status', 'approved')
            ->whereNotNull('language')
            ->distinct()
            ->pluck('language')
            ->sort();

        return view('books.public.index', compact('books', 'categories', 'languages'));
    }

    public function publicShow(Book $book)
    {
        // Only show approved books to public
        if ($book->status !== 'approved') {
            abort(404);
        }

        // Increment views count
        $book->increment('views');

        // Load the author relationship
        $book->load('uploader');

        return view('books.public.show', compact('book'));
    }
}