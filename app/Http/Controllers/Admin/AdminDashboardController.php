<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // Basic stats for admin dashboard
        $stats = [
            'total_books' => Book::count(),
            'total_users' => User::count(),
            'pending_books' => Book::where('is_approved', false)->count(),
            'active_users' => User::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return view('admin.dashboard.index', compact('stats'));
    }
}
