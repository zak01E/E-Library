<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'author') {
            return redirect()->route('author.dashboard');
        }

        return $this->userDashboard();
    }

    private function adminDashboard()
    {
        $stats = [
            'total_books' => Book::count(),
            'approved_books' => Book::where('is_approved', true)->count(),
            'pending_books' => Book::where('is_approved', false)->count(),
            'total_users' => User::count(),
            'authors' => User::where('role', 'author')->count(),
            'total_downloads' => Book::sum('downloads'),
            'total_views' => Book::sum('views'),
        ];

        $recent_books = Book::with('uploader')
            ->latest()
            ->take(5)
            ->get();

        $pending_books = Book::with('uploader')
            ->where('is_approved', false)
            ->latest()
            ->take(5)
            ->get();

        $top_books = Book::orderBy('downloads', 'desc')
            ->take(5)
            ->get();

        $users_by_role = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get();

        return view('dashboard.admin', compact('stats', 'recent_books', 'pending_books', 'top_books', 'users_by_role'));
    }

    private function authorDashboard()
    {
        $user = auth()->user();

        $stats = [
            'my_books' => Book::where('uploaded_by', $user->id)->count(),
            'approved_books' => Book::where('uploaded_by', $user->id)->where('is_approved', true)->count(),
            'pending_books' => Book::where('uploaded_by', $user->id)->where('is_approved', false)->count(),
            'total_downloads' => Book::where('uploaded_by', $user->id)->sum('downloads'),
            'total_views' => Book::where('uploaded_by', $user->id)->sum('views'),
        ];

        $my_books = Book::where('uploaded_by', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $top_books = Book::where('uploaded_by', $user->id)
            ->orderBy('downloads', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.author', compact('stats', 'my_books', 'top_books'));
    }

    private function userDashboard()
    {
        $recent_books = Book::where('is_approved', true)
            ->latest()
            ->take(6)
            ->get();

        $popular_books = Book::where('is_approved', true)
            ->orderBy('downloads', 'desc')
            ->take(6)
            ->get();

        return view('dashboard.user', compact('recent_books', 'popular_books'));
    }
}