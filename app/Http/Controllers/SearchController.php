<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Traits\BookFilterTrait;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use BookFilterTrait;
    public function index(Request $request)
    {
        $query = Book::query()->with('uploader');

        // Only show approved books for non-admin users
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            $query->where('status', 'approved');
        }

        // Apply filters using the trait
        $query = $this->applyBookFilters($query, $request);

        // Apply sorting using the trait
        $query = $this->applyBookSorting($query, $request);

        // Add year range filters (specific to search)
        if ($request->filled('year_from')) {
            $query->where('publication_year', '>=', $request->year_from);
        }
        if ($request->filled('year_to')) {
            $query->where('publication_year', '<=', $request->year_to);
        }

        $books = $query->paginate(12)->withQueryString();

        // Get filter options using the trait
        $filterOptions = $this->getFilterOptions();

        return view('books.search', [
            'books' => $books,
            'categories' => $filterOptions['categories'],
            'languages' => $filterOptions['languages'],
        ]);
    }
}