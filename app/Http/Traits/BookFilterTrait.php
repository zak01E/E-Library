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

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    /**
     * Apply sorting to a book query
     */
    public function applyBookSorting(Builder $query, Request $request): Builder
    {
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
