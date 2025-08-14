<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is-admin']);
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_authors' => User::where('role', 'author')->count(),
            'total_books' => Book::count(),
            'pending_books' => Book::where('status', 'pending')->count(),
            'approved_books' => Book::where('status', 'approved')->count(),
            'rejected_books' => Book::where('status', 'rejected')->count(),
        ];

        $recent_books = Book::with('uploader')
            ->latest()
            ->take(5)
            ->get();

        $pending_books = Book::with('uploader')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $recent_users = User::latest()
            ->take(5)
            ->get();

        $books_by_category = Book::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();

        return view('admin.dashboard.index', compact(
            'stats',
            'recent_books',
            'pending_books',
            'recent_users',
            'books_by_category'
        ));
    }

    public function users(Request $request)
    {
        $query = User::query();
        
        // Filtre par recherche (nom ou email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filtre par rôle
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }
        
        // Filtre par statut de vérification email
        if ($request->filled('verified')) {
            if ($request->verified === 'yes') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->verified === 'no') {
                $query->whereNull('email_verified_at');
            }
        }
        
        // Filtre par période d'inscription
        if ($request->filled('period')) {
            switch($request->period) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
                case 'year':
                    $query->where('created_at', '>=', now()->subYear());
                    break;
            }
        }
        
        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $users = $query->paginate(20)->withQueryString();
        
        // Statistiques pour les filtres
        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'authors' => User::where('role', 'author')->count(),
            'users' => User::where('role', 'user')->count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
            'unverified' => User::whereNull('email_verified_at')->count(),
        ];
        
        return view('admin.users', compact('users', 'stats'));
    }

    public function usersActive()
    {
        $users = User::where('created_at', '>=', now()->subDays(30))->paginate(20);
        return view('admin.users-active', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,author,admin'
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'Rôle utilisateur mis à jour avec succès.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,author,admin'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => $request->has('email_verified') ? now() : null,
        ]);

        return redirect()->back()->with('success', 'Utilisateur créé avec succès: ' . $user->name);
    }

    public function showUser(User $user)
    {
        $user->load('books');

        $stats = [
            'books_uploaded' => $user->books()->count(),
            'books_approved' => $user->books()->where('is_approved', true)->count(),
            'books_pending' => $user->books()->where('is_approved', false)->count(),
            'total_downloads' => $user->books()->sum('downloads'),
        ];

        return view('admin.user-details', compact('user', 'stats'));
    }

    public function deleteUser(User $user)
    {
        // Empêcher la suppression de son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        // Empêcher la suppression du dernier admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return redirect()->back()->with('error', 'Impossible de supprimer le dernier administrateur.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->back()->with('success', "L'utilisateur {$userName} a été supprimé avec succès.");
    }

    public function books(Request $request)
    {
        $query = Book::with('uploader');
        
        // Filtre par recherche (titre, auteur, catégorie, ISBN, éditeur)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }
        
        // Filtre par statut
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Filtre par niveau
        if ($request->filled('level') && $request->level !== 'all') {
            if ($request->level === 'null') {
                $query->whereNull('level');
            } else {
                $query->where('level', $request->level);
            }
        }
        
        // Filtre par catégorie
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        
        // Filtre par langue
        if ($request->filled('language') && $request->language !== 'all') {
            $query->where('language', $request->language);
        }
        
        // Filtre par année de publication
        if ($request->filled('year_from')) {
            $query->where('publication_year', '>=', $request->year_from);
        }
        if ($request->filled('year_to')) {
            $query->where('publication_year', '<=', $request->year_to);
        }
        
        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $books = $query->paginate(20)->withQueryString();
        
        // Obtenir les options de filtre
        $categories = Book::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->orderBy('category')
            ->pluck('category');
            
        $languages = Book::select('language')
            ->distinct()
            ->whereNotNull('language')
            ->orderBy('language')
            ->pluck('language');
            
        $levels = ['primaire', 'college', 'lycee', 'superieur', 'professionnel'];
        
        $statuses = ['approved', 'pending', 'rejected'];
        
        // Statistiques
        $stats = [
            'total' => Book::count(),
            'approved' => Book::where('status', 'approved')->count(),
            'pending' => Book::where('status', 'pending')->count(),
            'rejected' => Book::where('status', 'rejected')->count(),
            'with_level' => Book::whereNotNull('level')->count(),
            'without_level' => Book::whereNull('level')->count(),
        ];
        
        return view('admin.books', compact('books', 'categories', 'languages', 'levels', 'statuses', 'stats'));
    }

    public function showBook(Book $book)
    {
        return view('admin.book-details', compact('book'));
    }

    public function approveBook(Book $book)
    {
        $book->changeStatus('approved', 'Livre approuvé par l\'administrateur');
        return redirect()->back()->with('success', '✅ Livre approuvé avec succès !');
    }

    public function rejectBook(Book $book)
    {
        $book->changeStatus('rejected', 'Livre rejeté par l\'administrateur');
        return redirect()->back()->with('success', '❌ Livre rejeté.');
    }

    public function suspendBook(Book $book)
    {
        $book->changeStatus('suspended', 'Livre suspendu temporairement');
        return redirect()->back()->with('success', '⚠️ Livre suspendu.');
    }

    public function putUnderReview(Book $book)
    {
        $book->changeStatus('under_review', 'Livre mis en révision pour vérification supplémentaire');
        return redirect()->back()->with('success', '🔍 Livre mis en révision.');
    }

    public function deleteBook(Book $book)
    {
        // Supprimer les fichiers associés
        if ($book->pdf_path && \Storage::disk('public')->exists($book->pdf_path)) {
            \Storage::disk('public')->delete($book->pdf_path);
        }

        if ($book->cover_image && \Storage::disk('public')->exists($book->cover_image)) {
            \Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();
        return redirect()->back()->with('success', 'Livre supprimé avec succès.');
    }

    public function editBook(Book $book)
    {
        return view('admin.edit-book', compact('book'));
    }

    public function categories()
    {
        // Obtenir les catégories avec le nombre de livres
        $categories = Category::withCount(['books' => function ($query) {
            $query->whereColumn('books.category', 'categories.name');
        }])
        ->orderBy('books_count', 'desc')
        ->get();

        // Statistiques par niveau
        $levelStats = DB::table('books')
            ->select('level', DB::raw('COUNT(*) as count'))
            ->whereNotNull('level')
            ->groupBy('level')
            ->orderBy('count', 'desc')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->level => $item->count];
            });
        
        // Ajouter le compte des livres sans niveau
        $booksWithoutLevel = Book::whereNull('level')->count();
        
        // Statistiques par langue
        $languageStats = DB::table('books')
            ->select('language', DB::raw('COUNT(*) as count'))
            ->whereNotNull('language')
            ->groupBy('language')
            ->orderBy('count', 'desc')
            ->get();
        
        // Mapper les codes de langue aux noms
        $languageNames = [
            'fr' => 'Français',
            'en' => 'Anglais',
            'ar' => 'Arabe',
            'es' => 'Espagnol',
            'de' => 'Allemand',
            'it' => 'Italien',
            'pt' => 'Portugais',
            'nl' => 'Néerlandais',
            'ru' => 'Russe',
            'zh' => 'Chinois',
            'ja' => 'Japonais',
            'ko' => 'Coréen',
            'hi' => 'Hindi'
        ];
        
        // Statistiques par statut
        $statusStats = DB::table('books')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->orderBy('count', 'desc')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            });
        
        // Top catégories par niveau
        $categoriesByLevel = [];
        $levels = ['primaire', 'college', 'lycee', 'superieur', 'professionnel'];
        foreach ($levels as $level) {
            $categoriesByLevel[$level] = DB::table('books')
                ->select('category', DB::raw('COUNT(*) as count'))
                ->where('level', $level)
                ->whereNotNull('category')
                ->groupBy('category')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get();
        }
        
        // Statistiques générales
        $totalBooks = Book::count();
        $totalCategories = $categories->count();
        $averagePerCategory = $totalCategories > 0 ? round($totalBooks / $totalCategories) : 0;
        $totalWithLevel = Book::whereNotNull('level')->count();
        $percentWithLevel = $totalBooks > 0 ? round(($totalWithLevel / $totalBooks) * 100) : 0;
        
        // Croissance mensuelle (derniers 6 mois)
        $monthlyGrowth = DB::table('books')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.categories', compact(
            'categories', 
            'levelStats',
            'booksWithoutLevel',
            'languageStats',
            'languageNames',
            'statusStats',
            'categoriesByLevel',
            'totalBooks', 
            'totalCategories', 
            'averagePerCategory',
            'totalWithLevel',
            'percentWithLevel',
            'monthlyGrowth'
        ));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'slug' => 'nullable|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        Category::create($data);

        return redirect('/admin/categories')->with('success', 'Catégorie créée avec succès.');
    }

    public function editCategory(Category $category)
    {
        // Charger le nombre de livres associés
        $category->loadCount(['books' => function ($query) {
            $query->whereColumn('books.category', 'categories.name');
        }]);

        return view('admin.edit-category', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        return redirect('/admin/categories')->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function deleteCategory(Category $category)
    {
        // Vérifier s'il y a des livres dans cette catégorie
        $bookCount = Book::where('category', $category->name)->count();

        if ($bookCount > 0) {
            return redirect('/admin/categories')->with('error',
                "Impossible de supprimer cette catégorie car elle contient {$bookCount} livre(s).");
        }

        $category->delete();

        return redirect('/admin/categories')->with('success', 'Catégorie supprimée avec succès.');
    }

    public function updateBook(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'pages' => 'nullable|integer|min:1',
            'is_approved' => 'boolean',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB max
            'pdf_file' => 'nullable|file|mimes:pdf|max:51200', // 50MB max
        ]);

        // Handle cover image upload and removal
        $updateData = [
            'title' => $request->title,
            'author_name' => $request->author_name,
            'description' => $request->description,
            'category' => $request->category,
            'pages' => $request->pages,
            'is_approved' => $request->has('is_approved')
        ];

        // Handle cover image removal
        if ($request->has('remove_cover') && $book->cover_image) {
            // Delete old cover image
            if (\Storage::disk('public')->exists($book->cover_image)) {
                \Storage::disk('public')->delete($book->cover_image);
            }
            $updateData['cover_image'] = null;
        }
        // Handle new cover image upload
        elseif ($request->hasFile('cover_image')) {
            // Delete old cover image if exists
            if ($book->cover_image && \Storage::disk('public')->exists($book->cover_image)) {
                \Storage::disk('public')->delete($book->cover_image);
            }

            // Store new cover image
            $coverPath = $request->file('cover_image')->store('books/covers', 'public');
            $updateData['cover_image'] = $coverPath;
        }

        // Handle new PDF upload
        if ($request->hasFile('pdf_file')) {
            // Delete old PDF file if exists
            if ($book->pdf_path && \Storage::disk('public')->exists($book->pdf_path)) {
                \Storage::disk('public')->delete($book->pdf_path);
            }

            // Store new PDF file
            $pdfPath = $request->file('pdf_file')->store('books/pdfs', 'public');
            $updateData['pdf_path'] = $pdfPath;
        }
        // If no new PDF is uploaded, keep the existing pdf_path
        else {
            // Don't update pdf_path if no new file is uploaded
            // This prevents setting it to null which would violate the NOT NULL constraint
        }

        $book->update($updateData);

        return redirect('/admin/books')->with('success', 'Livre mis à jour avec succès.');
    }

    public function settings()
    {
        $settings = SiteSetting::getAllSettings();
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'contact_email' => 'nullable|email|max:255',
            'support_phone' => 'nullable|string|max:50',
            'default_language' => 'required|string|in:fr,en,es,de',
            'timezone' => 'required|string|max:100',
            'maintenance_mode' => 'nullable|boolean',
            'maintenance_message' => 'nullable|string|max:1000',
        ]);

        // Update text settings
        SiteSetting::set('site_name', $request->site_name);
        SiteSetting::set('site_description', $request->site_description);
        SiteSetting::set('contact_email', $request->contact_email);
        SiteSetting::set('support_phone', $request->support_phone);
        SiteSetting::set('default_language', $request->default_language);
        SiteSetting::set('timezone', $request->timezone);
        SiteSetting::set('maintenance_mode', $request->has('maintenance_mode') ? '1' : '0', 'boolean');
        SiteSetting::set('maintenance_message', $request->maintenance_message);

        return redirect('/admin/settings')->with('success', 'Paramètres mis à jour avec succès.');
    }

    public function updateLogos(Request $request)
    {
        $request->validate([
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'site_favicon' => 'nullable|image|mimes:ico,png|max:512',
            'site_logo_dark' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'admin_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        // Handle file uploads
        $imageFields = ['site_logo', 'site_favicon', 'site_logo_dark', 'admin_logo'];
        $uploadedFiles = [];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists
                $oldFile = SiteSetting::get($field);
                if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                    // Also delete from public/storage if it exists
                    $publicPath = public_path('storage/' . $oldFile);
                    if (file_exists($publicPath)) {
                        unlink($publicPath);
                    }
                }

                // Store new file
                $path = $request->file($field)->store('site-assets', 'public');
                SiteSetting::set($field, $path, 'image');
                $uploadedFiles[] = $field;

                // Synchronize to public/storage
                $this->syncFileToPublic($path);
            }
        }

        if (count($uploadedFiles) > 0) {
            $fileNames = [];
            foreach ($uploadedFiles as $field) {
                $fileNames[] = match($field) {
                    'site_logo' => 'Logo principal',
                    'site_favicon' => 'Favicon',
                    'site_logo_dark' => 'Logo sombre',
                    'admin_logo' => 'Logo admin',
                    default => $field
                };
            }
            $message = '✅ ' . implode(', ', $fileNames) . ' mis à jour avec succès.';
            return redirect('/admin/settings')->with('success', $message);
        } else {
            return redirect('/admin/settings')->with('warning', '⚠️ Aucun fichier sélectionné pour l\'upload.');
        }
    }

    /**
     * Synchronize a file from storage/app/public to public/storage
     */
    private function syncFileToPublic($relativePath)
    {
        $sourcePath = storage_path('app/public/' . $relativePath);
        $targetPath = public_path('storage/' . $relativePath);

        // Create directory if it doesn't exist
        $targetDir = dirname($targetPath);
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Copy the file
        if (file_exists($sourcePath)) {
            copy($sourcePath, $targetPath);
        }
    }

    public function deleteLogo($type)
    {
        $allowedTypes = ['site_logo', 'site_favicon', 'site_logo_dark', 'admin_logo'];

        if (!in_array($type, $allowedTypes)) {
            return redirect()->back()->with('error', '❌ Type de logo invalide.');
        }

        $logoName = match($type) {
            'site_logo' => 'Logo principal',
            'site_favicon' => 'Favicon',
            'site_logo_dark' => 'Logo sombre',
            'admin_logo' => 'Logo admin',
            default => 'Logo'
        };

        $oldFile = SiteSetting::get($type);
        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
            // Delete from storage
            Storage::disk('public')->delete($oldFile);

            // Also delete from public/storage if it exists
            $publicPath = public_path('storage/' . $oldFile);
            if (file_exists($publicPath)) {
                unlink($publicPath);
            }

            SiteSetting::set($type, null);
            return redirect('/admin/settings')->with('success', "🗑️ {$logoName} supprimé avec succès.");
        } else {
            return redirect('/admin/settings')->with('warning', "⚠️ Aucun {$logoName} à supprimer.");
        }
    }

    // Additional methods for routes that don't have implementations
    public function createBook()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function storeBook(Request $request)
    {
        // Implementation for storing a new book
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'file' => 'required|file|mimes:pdf|max:20480',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->author_name = $request->author_name;
        $book->description = $request->description;
        $book->category = $request->category;
        $book->uploaded_by = auth()->id();
        $book->status = 'pending';

        // Handle file uploads
        if ($request->hasFile('file')) {
            $book->file_path = $request->file('file')->store('books', 'public');
        }
        if ($request->hasFile('cover_image')) {
            $book->cover_image = $request->file('cover_image')->store('covers', 'public');
        }

        $book->save();
        return redirect('/admin/books')->with('success', 'Livre ajouté avec succès.');
    }

    public function featureBook(Book $book)
    {
        $book->update(['is_featured' => true]);
        return redirect()->back()->with('success', 'Livre mis en avant avec succès.');
    }

    public function unfeatureBook(Book $book)
    {
        $book->update(['is_featured' => false]);
        return redirect()->back()->with('success', 'Livre retiré de la mise en avant.');
    }

    public function bulkBookAction(Request $request)
    {
        $action = $request->input('action');
        $bookIds = $request->input('book_ids', []);

        if (empty($bookIds)) {
            return redirect()->back()->with('error', 'Aucun livre sélectionné.');
        }

        switch ($action) {
            case 'approve':
                Book::whereIn('id', $bookIds)->update(['status' => 'approved']);
                $message = 'Livres approuvés avec succès.';
                break;
            case 'reject':
                Book::whereIn('id', $bookIds)->update(['status' => 'rejected']);
                $message = 'Livres rejetés avec succès.';
                break;
            case 'delete':
                Book::whereIn('id', $bookIds)->delete();
                $message = 'Livres supprimés avec succès.';
                break;
            default:
                return redirect()->back()->with('error', 'Action invalide.');
        }

        return redirect()->back()->with('success', $message);
    }

    public function exportBooks()
    {
        // Implementation for exporting books
        $books = Book::all();
        $csvData = "ID,Title,Author,Category,Status,Created At\n";
        
        foreach ($books as $book) {
            $csvData .= "{$book->id},{$book->title},{$book->author_name},{$book->category},{$book->status},{$book->created_at}\n";
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="books.csv"');
    }

    public function importBooks(Request $request)
    {
        // Implementation for importing books
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        // Process CSV file
        $file = $request->file('file');
        $data = array_map('str_getcsv', file($file->getRealPath()));
        
        // Skip header row and process data
        foreach (array_slice($data, 1) as $row) {
            if (count($row) >= 4) {
                Book::create([
                    'title' => $row[0],
                    'author_name' => $row[1],
                    'category' => $row[2],
                    'description' => $row[3] ?? '',
                    'uploaded_by' => auth()->id(),
                    'status' => 'pending'
                ]);
            }
        }

        return redirect()->back()->with('success', 'Livres importés avec succès.');
    }

    // Method aliases for consistency
    public function bookDetails(Book $book) { return $this->showBook($book); }
    public function createCategory() { 
        return view('admin.categories.create'); 
    }
    public function activeUsers() { return $this->usersActive(); }
    public function userDetails(User $user) { return $this->showUser($user); }
}