<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Book;

echo "╔══════════════════════════════════════════════════════════════════╗\n";
echo "║         NETTOYAGE DES CATÉGORIES OBSOLÈTES                       ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

// Catégories qui sont maintenant des niveaux
$obsoleteCategories = ['Primaire', 'Collège', 'Lycée', 'Supérieur', 'Professionnel'];

echo "CATÉGORIES À SUPPRIMER (car ce sont des niveaux, pas des catégories):\n";
echo "═══════════════════════════════════════════════════════════════════\n";

foreach ($obsoleteCategories as $catName) {
    $category = Category::where('name', $catName)->first();
    
    if ($category) {
        // Vérifier combien de livres utilisent cette catégorie
        $bookCount = Book::where('category', $catName)->count();
        
        echo "\n❌ $catName:\n";
        echo "   - ID dans la table categories: {$category->id}\n";
        echo "   - Livres avec cette catégorie: $bookCount\n";
        
        if ($bookCount == 0) {
            // Supprimer la catégorie
            $category->delete();
            echo "   ✅ SUPPRIMÉE (aucun livre n'utilise cette catégorie)\n";
        } else {
            echo "   ⚠️ NON SUPPRIMÉE (des livres utilisent encore cette catégorie)\n";
            echo "   → Ces livres doivent d'abord être mis à jour\n";
        }
    } else {
        echo "\n• $catName: ✓ Déjà supprimée ou n'existe pas\n";
    }
}

// Vérifier les catégories valides
echo "\n\nCATÉGORIES VALIDES (avec nombre de livres):\n";
echo "═══════════════════════════════════════════════\n";

$validCategories = Category::whereNotIn('name', $obsoleteCategories)
    ->withCount(['books' => function ($query) {
        $query->whereColumn('books.category', 'categories.name');
    }])
    ->orderBy('books_count', 'desc')
    ->limit(20)
    ->get();

foreach ($validCategories as $cat) {
    if ($cat->books_count > 0) {
        echo sprintf("  %-30s : %d livres\n", $cat->name, $cat->books_count);
    }
}

// Statistiques finales
echo "\n\nSTATISTIQUES FINALES:\n";
echo "════════════════════\n";

$totalCategories = Category::count();
$obsoleteCount = Category::whereIn('name', $obsoleteCategories)->count();
$validCount = $totalCategories - $obsoleteCount;

echo "Total de catégories: $totalCategories\n";
echo "Catégories obsolètes restantes: $obsoleteCount\n";
echo "Catégories valides: $validCount\n";

// Suggestion
if ($obsoleteCount > 0) {
    echo "\n⚠️ ATTENTION: Il reste $obsoleteCount catégories obsolètes.\n";
    echo "Ces catégories représentent des niveaux éducatifs, pas des matières.\n";
    echo "Elles devraient être supprimées pour éviter la confusion.\n";
} else {
    echo "\n✅ Toutes les catégories obsolètes ont été supprimées!\n";
    echo "La table categories ne contient plus que des vraies catégories de contenu.\n";
}

echo "\n📝 RAPPEL:\n";
echo "- Les niveaux (primaire, collège, lycée...) sont dans la colonne 'level' des livres\n";
echo "- Les catégories doivent être des matières ou genres (Mathématiques, Histoire, Fiction...)\n";