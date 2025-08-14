<?php

// Ce script met à jour AdminController pour ajouter tous les filtres nécessaires

$controllerPath = __DIR__ . '/app/Http/Controllers/AdminController.php';
$content = file_get_contents($controllerPath);

// Trouver la méthode books et la remplacer
$oldMethod = <<<'PHP'
    public function books(Request $request)
    {
        $query = Book::with('uploader');
        // Filtre par recherche (titre, auteur, catégorie)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }
        // Filtre par statut
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        $books = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.books', compact('books'));
    }
PHP;

$newMethod = <<<'PHP'
    public function books(Request $request)
    {
        $query = Book::with('uploader');
        
        // Filtre par recherche (titre, auteur, catégorie, ISBN)
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
PHP;

// Remplacer la méthode
$content = str_replace($oldMethod, $newMethod, $content);

// Sauvegarder le fichier
if (file_put_contents($controllerPath, $content)) {
    echo "✅ AdminController mis à jour avec succès!\n";
    echo "\nFiltres ajoutés:\n";
    echo "- Niveau (primaire, college, lycee, superieur, professionnel, sans niveau)\n";
    echo "- Catégorie (toutes les catégories disponibles)\n";
    echo "- Langue (toutes les langues disponibles)\n";
    echo "- Année de publication (de/à)\n";
    echo "- ISBN et Éditeur dans la recherche\n";
    echo "- Tri personnalisable\n";
    echo "\nStatistiques ajoutées:\n";
    echo "- Total de livres\n";
    echo "- Livres par statut\n";
    echo "- Livres avec/sans niveau\n";
} else {
    echo "❌ Erreur lors de la mise à jour du contrôleur\n";
}