<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Illuminate\Support\Facades\DB;

echo "=== ANALYSE DES PROBLÈMES DE CATÉGORISATION ===\n\n";

// 1. Vérifier quelques livres du niveau "primaire"
echo "Exemples de livres marqués comme 'primaire' :\n";
$primaire_books = Book::where('level', 'primaire')->limit(10)->get(['id', 'title', 'category', 'level']);
foreach ($primaire_books as $book) {
    echo "- ID: {$book->id}, Titre: {$book->title}\n";
    echo "  Catégorie: {$book->category}, Niveau: {$book->level}\n\n";
}

// 2. Analyser la distribution des catégories par niveau
echo "\n=== DISTRIBUTION DES CATÉGORIES PAR NIVEAU ===\n\n";
$levels = ['primaire', 'college', 'lycee', 'superieur', 'professionnel'];

foreach ($levels as $level) {
    echo "Niveau: " . strtoupper($level) . "\n";
    $categories = Book::where('level', $level)
        ->select('category', DB::raw('count(*) as count'))
        ->groupBy('category')
        ->orderBy('count', 'desc')
        ->limit(10)
        ->get();
    
    foreach ($categories as $cat) {
        echo "  - {$cat->category}: {$cat->count} livres\n";
    }
    echo "\n";
}

// 3. Identifier les incohérences évidentes
echo "=== INCOHÉRENCES DÉTECTÉES ===\n\n";

// Livres de philosophie, sciences avancées dans le primaire
$incoherent = Book::where('level', 'primaire')
    ->whereIn('category', ['Philosophie', 'Science', 'Technology', 'Médecine', 'Droit', 'Économie'])
    ->count();
echo "Livres de catégories avancées marqués comme 'primaire': $incoherent\n";

// Livres pour enfants dans le supérieur
$incoherent2 = Book::where('level', 'superieur')
    ->whereIn('category', ['Contes', 'Albums jeunesse', 'Littérature jeunesse'])
    ->count();
echo "Livres jeunesse marqués comme 'supérieur': $incoherent2\n";

// 4. Vérifier si les niveaux ont été mal assignés
echo "\n=== ANALYSE DES PATTERNS ===\n";
$sample = Book::whereNotNull('level')
    ->whereNotNull('category')
    ->limit(50)
    ->get(['title', 'category', 'level']);

$mismatch_count = 0;
foreach ($sample as $book) {
    $expected_level = null;
    
    // Déterminer le niveau attendu basé sur la catégorie
    $category_lower = strtolower($book->category);
    
    if (in_array($category_lower, ['contes', 'albums jeunesse', 'littérature jeunesse', 'éveil'])) {
        $expected_level = 'primaire';
    } elseif (in_array($category_lower, ['philosophie', 'médecine', 'droit', 'économie', 'sciences politiques'])) {
        $expected_level = 'superieur';
    } elseif (in_array($category_lower, ['lycée', 'baccalauréat', 'terminale'])) {
        $expected_level = 'lycee';
    } elseif (in_array($category_lower, ['collège', 'brevet'])) {
        $expected_level = 'college';
    }
    
    if ($expected_level && $expected_level != $book->level) {
        $mismatch_count++;
        if ($mismatch_count <= 5) { // Afficher seulement les 5 premiers
            echo "\nProblème détecté:\n";
            echo "  Livre: {$book->title}\n";
            echo "  Catégorie: {$book->category}\n";
            echo "  Niveau actuel: {$book->level}\n";
            echo "  Niveau attendu: $expected_level\n";
        }
    }
}

echo "\n\nNombre total d'incohérences dans l'échantillon: $mismatch_count sur 50\n";

// 5. Proposer une solution
echo "\n=== SOLUTION PROPOSÉE ===\n";
echo "Il semble que les niveaux ont été assignés aléatoirement aux livres.\n";
echo "Nous devons :\n";
echo "1. Réinitialiser les niveaux à NULL\n";
echo "2. Réassigner les niveaux basés sur les catégories réelles des livres\n";
echo "3. Ou simplement supprimer le filtre par niveau si ce n'est pas pertinent\n";