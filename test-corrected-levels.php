<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;

echo "=== TEST DES NIVEAUX CORRIGÉS ===\n\n";

// 1. Statistiques par niveau
echo "Répartition des livres par niveau:\n";
echo "--------------------------------\n";
$levels = ['primaire', 'college', 'lycee', 'superieur', 'professionnel'];

foreach ($levels as $level) {
    $count = Book::where('status', 'approved')->where('level', $level)->count();
    echo ucfirst($level) . ": $count livres approuvés\n";
    
    // Afficher quelques exemples
    $examples = Book::where('status', 'approved')
        ->where('level', $level)
        ->limit(3)
        ->get(['title', 'category']);
    
    if ($examples->count() > 0) {
        echo "  Exemples:\n";
        foreach ($examples as $book) {
            echo "    - {$book->title} (Catégorie: {$book->category})\n";
        }
    }
    echo "\n";
}

// Livres sans niveau
$no_level = Book::where('status', 'approved')->whereNull('level')->count();
echo "Sans niveau (livres généraux): $no_level livres\n\n";

// 2. Vérifier la cohérence
echo "=== VÉRIFICATION DE LA COHÉRENCE ===\n\n";

// Primaire
$primaire_books = Book::where('level', 'primaire')->limit(5)->get(['title', 'category']);
echo "Livres du primaire (devrait être des livres pour enfants):\n";
foreach ($primaire_books as $book) {
    echo "  - {$book->title} ({$book->category})\n";
}

echo "\n";

// Supérieur
$superieur_books = Book::where('level', 'superieur')->limit(5)->get(['title', 'category']);
echo "Livres du supérieur (devrait être des livres universitaires/avancés):\n";
foreach ($superieur_books as $book) {
    echo "  - {$book->title} ({$book->category})\n";
}

echo "\n=== URLS DE TEST ===\n";
echo "Testez ces URLs dans votre navigateur:\n\n";
echo "1. Livres du primaire: http://127.0.0.1:8000/search?level=primaire\n";
echo "   → Devrait afficher $count livres de la catégorie Primaire\n\n";
echo "2. Livres du collège: http://127.0.0.1:8000/search?level=college\n";
echo "   → Devrait afficher les livres de Français, Maths, Histoire-Géo, etc.\n\n";
echo "3. Livres du supérieur: http://127.0.0.1:8000/search?level=superieur\n";
echo "   → Devrait afficher les livres de Philosophie, Médecine, Droit, etc.\n\n";
echo "4. Tous les livres: http://127.0.0.1:8000/search\n";
echo "   → Devrait afficher tous les livres\n";