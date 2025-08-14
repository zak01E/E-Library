<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Illuminate\Support\Facades\DB;

echo "╔══════════════════════════════════════════════════════════════════╗\n";
echo "║         ANALYSE DES LIVRES AVEC TITRES GÉNÉRIQUES                ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

// 1. Compter les livres avec titres génériques
echo "1. LIVRES AVEC TITRES 'Livre Numéro X'\n";
echo "---------------------------------------\n";

$genericBooks = Book::where('title', 'LIKE', 'Livre Numéro %')->count();
echo "Total de livres avec titre générique: $genericBooks\n\n";

// Exemples par niveau
$levels = ['primaire', 'college', 'lycee', 'superieur', 'professionnel', null];
foreach ($levels as $level) {
    $count = Book::where('title', 'LIKE', 'Livre Numéro %')
                 ->where('level', $level)
                 ->count();
    if ($count > 0) {
        $levelName = $level ?: 'Sans niveau';
        echo "  - $levelName: $count livres\n";
        
        // Afficher quelques exemples
        $examples = Book::where('title', 'LIKE', 'Livre Numéro %')
                        ->where('level', $level)
                        ->limit(3)
                        ->get(['id', 'title', 'category', 'author_name']);
        
        foreach ($examples as $book) {
            echo "      → ID {$book->id}: {$book->title} (Cat: {$book->category}, Auteur: {$book->author_name})\n";
        }
    }
}

// 2. Analyser la structure de ces livres
echo "\n2. ANALYSE DE LA STRUCTURE DES LIVRES GÉNÉRIQUES\n";
echo "-------------------------------------------------\n";

$sampleBook = Book::where('title', 'LIKE', 'Livre Numéro %')->first();
if ($sampleBook) {
    echo "Exemple détaillé (ID {$sampleBook->id}):\n";
    echo "  Titre: {$sampleBook->title}\n";
    echo "  Description: " . Str::limit($sampleBook->description, 100) . "\n";
    echo "  Catégorie: {$sampleBook->category}\n";
    echo "  Niveau: " . ($sampleBook->level ?: 'NULL') . "\n";
    echo "  Auteur: {$sampleBook->author_name}\n";
    echo "  ISBN: {$sampleBook->isbn}\n";
    echo "  Langue: {$sampleBook->language}\n";
    echo "  Date création: {$sampleBook->created_at}\n";
}

// 3. Vérifier l'affichage des badges de niveau dans la vue
echo "\n3. VÉRIFICATION DE L'AFFICHAGE DES NIVEAUX\n";
echo "-------------------------------------------\n";

$viewPath = resource_path('views/books/search.blade.php');
$viewContent = file_get_contents($viewPath);

// Chercher si le niveau est affiché
if (strpos($viewContent, '$book->level') !== false) {
    echo "✓ La variable \$book->level est utilisée dans la vue\n";
} else {
    echo "✗ La variable \$book->level N'EST PAS utilisée dans la vue\n";
    echo "  → Les badges de niveau ne sont pas affichés!\n";
}

// Chercher les badges existants
if (preg_match_all('/@if\(\$book->(\w+)\).*?badge.*?@endif/s', $viewContent, $matches)) {
    echo "\nBadges trouvés dans la vue:\n";
    foreach ($matches[1] as $field) {
        echo "  - Badge pour le champ: $field\n";
    }
} else {
    echo "\nAucun badge conditionnel trouvé dans la vue\n";
}

// 4. Solution proposée
echo "\n╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                      SOLUTIONS PROPOSÉES                         ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

echo "PROBLÈME 1: Titres génériques 'Livre Numéro X'\n";
echo "  → $genericBooks livres ont des titres non descriptifs\n";
echo "  → Solution: Mettre à jour ces titres avec des vrais titres\n\n";

echo "PROBLÈME 2: Pas de badge de niveau affiché\n";
echo "  → Les utilisateurs ne voient pas le niveau éducatif\n";
echo "  → Solution: Ajouter un badge pour afficher le niveau\n\n";

echo "Actions à effectuer:\n";
echo "1. Corriger les titres génériques\n";
echo "2. Ajouter l'affichage du niveau dans la carte de livre\n";
echo "3. Différencier visuellement les niveaux (couleurs)\n";