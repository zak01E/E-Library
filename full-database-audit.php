<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "╔══════════════════════════════════════════════════════════════════╗\n";
echo "║           AUDIT COMPLET DE LA BASE DE DONNÉES E-LIBRARY          ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

// 1. STRUCTURE DE LA TABLE
echo "═══ 1. STRUCTURE DE LA TABLE BOOKS ═══\n";
$columns = Schema::getColumnListing('books');
echo "Colonnes disponibles: " . implode(', ', $columns) . "\n\n";

// 2. STATISTIQUES GÉNÉRALES
echo "═══ 2. STATISTIQUES GÉNÉRALES ═══\n";
$total = Book::count();
$approved = Book::where('status', 'approved')->count();
$pending = Book::where('status', 'pending')->count();
$rejected = Book::where('status', 'rejected')->count();

echo "Total de livres: $total\n";
echo "- Approuvés: $approved\n";
echo "- En attente: $pending\n";
echo "- Rejetés: $rejected\n\n";

// 3. ANALYSE DU CHAMP 'LEVEL'
echo "═══ 3. ANALYSE DU CHAMP 'LEVEL' ═══\n";
$levels = DB::select("SELECT level, COUNT(*) as count FROM books GROUP BY level ORDER BY count DESC");
echo "Distribution des niveaux:\n";
foreach ($levels as $level) {
    $levelName = $level->level ?: 'NULL (non défini)';
    echo "  - $levelName: {$level->count} livres\n";
}

// Vérifier les valeurs exactes (avec espaces, casse, etc.)
echo "\nValeurs exactes du champ level (avec détection d'espaces):\n";
$rawLevels = DB::select("
    SELECT DISTINCT 
        level,
        LENGTH(level) as length,
        HEX(level) as hex_value,
        COUNT(*) as count
    FROM books 
    WHERE level IS NOT NULL 
    GROUP BY level, LENGTH(level), HEX(level)
");
foreach ($rawLevels as $raw) {
    echo "  - '{$raw->level}' (longueur: {$raw->length}, hex: {$raw->hex_value}): {$raw->count} livres\n";
}

// 4. ANALYSE DU CHAMP 'CATEGORY'
echo "\n═══ 4. ANALYSE DU CHAMP 'CATEGORY' ═══\n";
$categories = Book::select('category', DB::raw('COUNT(*) as count'))
    ->groupBy('category')
    ->orderBy('count', 'desc')
    ->limit(20)
    ->get();
echo "Top 20 catégories:\n";
foreach ($categories as $cat) {
    $catName = $cat->category ?: 'NULL';
    echo "  - $catName: {$cat->count} livres\n";
}

// 5. ANALYSE DU CHAMP 'LANGUAGE'
echo "\n═══ 5. ANALYSE DU CHAMP 'LANGUAGE' ═══\n";
$languages = Book::select('language', DB::raw('COUNT(*) as count'))
    ->whereNotNull('language')
    ->groupBy('language')
    ->orderBy('count', 'desc')
    ->get();
echo "Langues disponibles:\n";
foreach ($languages as $lang) {
    echo "  - {$lang->language}: {$lang->count} livres\n";
}

// 6. PROBLÈMES DÉTECTÉS
echo "\n═══ 6. PROBLÈMES DÉTECTÉS ═══\n";

// Espaces dans les valeurs
$spaceProblem = DB::select("
    SELECT COUNT(*) as count FROM books 
    WHERE level LIKE ' %' OR level LIKE '% ' 
    OR category LIKE ' %' OR category LIKE '% '
    OR language LIKE ' %' OR language LIKE '% '
");
echo "Livres avec espaces au début/fin: {$spaceProblem[0]->count}\n";

// Valeurs NULL
$nullLevel = Book::whereNull('level')->count();
$nullCategory = Book::whereNull('category')->count();
$nullLanguage = Book::whereNull('language')->count();
echo "Valeurs NULL:\n";
echo "  - Level NULL: $nullLevel livres\n";
echo "  - Category NULL: $nullCategory livres\n";
echo "  - Language NULL: $nullLanguage livres\n";

// Doublons potentiels (même titre et auteur)
$duplicates = DB::select("
    SELECT title, author_name, COUNT(*) as count 
    FROM books 
    WHERE title IS NOT NULL AND author_name IS NOT NULL
    GROUP BY title, author_name 
    HAVING COUNT(*) > 1
    LIMIT 5
");
echo "\nDoublons potentiels (même titre et auteur):\n";
foreach ($duplicates as $dup) {
    echo "  - '{$dup->title}' par {$dup->author_name}: {$dup->count} fois\n";
}

// 7. TEST DES FILTRES
echo "\n═══ 7. TEST DES FILTRES (REQUÊTES SIMULÉES) ═══\n";

// Test filtre niveau=college
echo "\n→ Test: ?level=college\n";
$test1 = Book::where('status', 'approved')->where('level', 'college')->count();
echo "  Résultat: $test1 livres\n";

// Test avec LIKE pour voir si c'est un problème de casse
$test2 = Book::where('status', 'approved')->where('level', 'LIKE', '%college%')->count();
echo "  Avec LIKE '%college%': $test2 livres\n";

// Test avec lower
$test3 = Book::where('status', 'approved')->whereRaw('LOWER(level) = ?', ['college'])->count();
echo "  Avec LOWER(level) = 'college': $test3 livres\n";

// Test filtre niveau=primaire
echo "\n→ Test: ?level=primaire\n";
$test4 = Book::where('status', 'approved')->where('level', 'primaire')->count();
echo "  Résultat: $test4 livres\n";

// Test filtre catégorie
echo "\n→ Test: ?category=Science\n";
$test5 = Book::where('status', 'approved')->where('category', 'Science')->count();
echo "  Résultat: $test5 livres\n";

// 8. RECOMMANDATIONS
echo "\n═══ 8. ACTIONS CORRECTIVES NÉCESSAIRES ═══\n";
echo "□ Nettoyer les espaces dans les champs\n";
echo "□ Standardiser la casse (minuscules)\n";
echo "□ Définir des valeurs par défaut pour les champs NULL\n";
echo "□ Créer des index sur les colonnes filtrables\n";
echo "□ Vérifier les contraintes de la base de données\n";