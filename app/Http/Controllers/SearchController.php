<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query()->with('uploader');

        // Only show approved books for non-admin users
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            $query->where('is_approved', true);
        }

        // Search by title, author, description
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        // Filter by language
        if ($language = $request->get('language')) {
            $query->where('language', $language);
        }

        // Filter by year range
        if ($yearFrom = $request->get('year_from')) {
            $query->where('publication_year', '>=', $yearFrom);
        }
        if ($yearTo = $request->get('year_to')) {
            $query->where('publication_year', '<=', $yearTo);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSorts = ['title', 'author_name', 'publication_year', 'created_at', 'views', 'downloads'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $books = $query->paginate(12)->withQueryString();

        // Get unique categories and languages for filters
        $categories = Book::when(!auth()->check() || auth()->user()->role !== 'admin', function ($q) {
                $q->where('is_approved', true);
            })
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort();

        $languages = Book::when(!auth()->check() || auth()->user()->role !== 'admin', function ($q) {
                $q->where('is_approved', true);
            })
            ->distinct()
            ->pluck('language')
            ->sort();

        return view('books.search', compact('books', 'categories', 'languages'));
    }
}