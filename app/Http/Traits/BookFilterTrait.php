<?php

namespace App\Http\Traits;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

trait BookFilterTrait
{
    /**
     * Apply filters to a book query
     */
    public function applyBookFilters(Builder $query, Request $request): Builder
    {
        // Filter by level (primaire, collège, lycée, etc.)
        if ($request->filled('level') && $request->level !== 'all') {
            $query->where('level', $request->level);
        }

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Filter by language
        if ($request->filled('language') && $request->language !== 'all') {
            $query->where('language', $request->language);
        }

        // Filter by author
        if ($request->filled('author') && $request->author !== 'all') {
            $query->where('author_name', $request->author);
        }

        // Search functionality - support both 'search' and 'q' parameters
        $searchTerm = $request->get('search') ?: $request->get('q');
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('author_name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('isbn', 'like', "%{$searchTerm}%")
                  ->orWhere('publisher', 'like', "%{$searchTerm}%")
                  ->orWhere('category', 'like', "%{$searchTerm}%");
            });
            
            // Add relevance scoring for better search results
            $query->selectRaw('*, 
                CASE 
                    WHEN title LIKE ? THEN 100
                    WHEN category LIKE ? THEN 80
                    WHEN author_name LIKE ? THEN 60
                    WHEN publisher LIKE ? THEN 40
                    WHEN description LIKE ? THEN 20
                    ELSE 10
                END as relevance_score', 
                ["%{$searchTerm}%", "%{$searchTerm}%", "%{$searchTerm}%", "%{$searchTerm}%", "%{$searchTerm}%"]
            )->orderByDesc('relevance_score');
        }

        return $query;
    }

    /**
     * Apply sorting to a book query
     */
    public function applyBookSorting(Builder $query, Request $request): Builder
    {
        // Support both 'sort' and 'sort_by' parameters
        $sortBy = $request->get('sort_by') ?: $request->get('sort', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        switch ($sortBy) {
            case 'popular':
            case 'views':
                $query->orderBy('views', $sortOrder);
                break;
            case 'downloads':
                $query->orderBy('downloads', $sortOrder);
                break;
            case 'alphabetical':
            case 'title':
                $query->orderBy('title', $sortOrder);
                break;
            case 'author_name':
                $query->orderBy('author_name', $sortOrder);
                break;
            case 'publication_year':
                $query->orderBy('publication_year', $sortOrder);
                break;
            case 'latest':
            case 'created_at':
            default:
                $query->orderBy('created_at', $sortOrder);
                break;
        }

        return $query;
    }

    /**
     * Get filter options for dropdowns
     */
    public function getFilterOptions(): array
    {
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

        $authors = Book::where('status', 'approved')
            ->whereNotNull('author_name')
            ->distinct()
            ->pluck('author_name')
            ->sort();

        return [
            'categories' => $categories,
            'languages' => $languages,
            'authors' => $authors,
        ];
    }

    /**
     * Get filtered and sorted books with pagination
     */
    public function getFilteredBooks(Request $request, int $perPage = 12)
    {
        $query = Book::where('status', 'approved')->with('uploader');
        
        // Apply filters
        $query = $this->applyBookFilters($query, $request);
        
        // Apply sorting
        $query = $this->applyBookSorting($query, $request);
        
        return $query->paginate($perPage)->withQueryString();
    }
}
