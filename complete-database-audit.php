<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "\n╔══════════════════════════════════════════════════════════════════════════════╗\n";
echo "║                    AUDIT COMPLET ET RIGOUREUX DE LA BASE DE DONNÉES          ║\n";
echo "╚══════════════════════════════════════════════════════════════════════════════╝\n\n";

$totalBooks = Book::count();
$issues = [];
$statistics = [];

// 1. ANALYSE DE LA STRUCTURE
echo "1. ANALYSE DE LA STRUCTURE DE LA TABLE 'books'\n";
echo "═══════════════════════════════════════════════\n\n";

$columns = Schema::getColumnListing('books');
$columnTypes = [];
foreach ($columns as $column) {
    $columnTypes[$column] = DB::getSchemaBuilder()->getColumnType('books', $column);
}

$criticalColumns = [
    'title' => 'string',
    'author_name' => 'string',
    'category' => 'string',
    'level' => 'string',
    'language' => 'string',
    'status' => 'string',
    'description' => 'text',
    'publication_year' => 'integer',
    'pages' => 'integer'
];

echo "Colonnes critiques à vérifier:\n";
foreach ($criticalColumns as $col => $type) {
    $actualType = $columnTypes[$col] ?? 'NOT FOUND';
    $status = ($actualType == $type) ? '✓' : '✗';
    echo "  $status $col (type attendu: $type, actuel: $actualType)\n";
}

// 2. ANALYSE DES VALEURS NULL
echo "\n2. ANALYSE DES VALEURS NULL ET VIDES\n";
echo "══════════════════════════════════════\n\n";

foreach ($criticalColumns as $column => $type) {
    $nullCount = Book::whereNull($column)->count();
    $emptyCount = Book::where($column, '')->count();
    $totalMissing = $nullCount + $emptyCount;
    $percentage = round(($totalMissing / $totalBooks) * 100, 2);
    
    $statistics[$column] = [
        'null' => $nullCount,
        'empty' => $emptyCount,
        'total_missing' => $totalMissing,
        'percentage' => $percentage
    ];
    
    if ($totalMissing > 0) {
        $severity = $percentage > 50 ? '🔴' : ($percentage > 20 ? '🟡' : '🟢');
        echo "$severity $column: $totalMissing valeurs manquantes ({$percentage}%)\n";
        echo "    - NULL: $nullCount | Vides: $emptyCount\n";
        
        if ($percentage > 20) {
            $issues[] = "Colonne '$column' a {$percentage}% de valeurs manquantes";
        }
    } else {
        echo "✅ $column: Toutes les valeurs sont remplies\n";
    }
}

// 3. VALIDATION DES VALEURS
echo "\n3. VALIDATION DES MODALITÉS ET VALEURS\n";
echo "════════════════════════════════════════\n\n";

// Validation du STATUS
echo "→ STATUS (valeurs attendues: approved, pending, rejected):\n";
$statusValues = Book::select('status', DB::raw('COUNT(*) as count'))
    ->groupBy('status')
    ->get();

foreach ($statusValues as $sv) {
    $status = $sv->status ?: 'NULL';
    $valid = in_array($sv->status, ['approved', 'pending', 'rejected']);
    $icon = $valid ? '✓' : '✗';
    echo "  $icon '$status': {$sv->count} livres\n";
    
    if (!$valid && $sv->count > 0) {
        $issues[] = "Status invalide '$status' pour {$sv->count} livres";
    }
}

// Validation des NIVEAUX
echo "\n→ LEVEL (valeurs attendues: primaire, college, lycee, superieur, professionnel, NULL):\n";
$levelValues = Book::select('level', DB::raw('COUNT(*) as count'))
    ->groupBy('level')
    ->get();

$validLevels = ['primaire', 'college', 'lycee', 'superieur', 'professionnel', null];
foreach ($levelValues as $lv) {
    $level = $lv->level ?: 'NULL';
    $valid = in_array($lv->level, $validLevels);
    $icon = $valid ? '✓' : '✗';
    echo "  $icon '$level': {$lv->count} livres\n";
    
    if (!$valid && $lv->count > 0) {
        $issues[] = "Niveau invalide '$level' pour {$lv->count} livres";
    }
}

// Validation des LANGUES
echo "\n→ LANGUAGE (codes ISO 639-1 attendus: fr, en, es, de, it, etc.):\n";
$languageValues = Book::select('language', DB::raw('COUNT(*) as count'))
    ->whereNotNull('language')
    ->groupBy('language')
    ->orderBy('count', 'desc')
    ->limit(15)
    ->get();

$validLanguageCodes = ['fr', 'en', 'es', 'de', 'it', 'pt', 'ru', 'ja', 'zh', 'ar', 'ko', 'hi', 'nl', 'pl', 'tr'];
foreach ($languageValues as $lang) {
    $valid = strlen($lang->language) == 2 && in_array($lang->language, $validLanguageCodes);
    $icon = $valid ? '✓' : '⚠';
    echo "  $icon '{$lang->language}': {$lang->count} livres\n";
    
    if (!$valid && $lang->count > 10) {
        $issues[] = "Code langue non standard '{$lang->language}' pour {$lang->count} livres";
    }
}

// Validation des ANNÉES DE PUBLICATION
echo "\n→ PUBLICATION_YEAR (années raisonnables: 1900-2025):\n";
$yearStats = Book::selectRaw('
    MIN(publication_year) as min_year,
    MAX(publication_year) as max_year,
    AVG(publication_year) as avg_year,
    COUNT(CASE WHEN publication_year < 1900 THEN 1 END) as too_old,
    COUNT(CASE WHEN publication_year > 2025 THEN 1 END) as future,
    COUNT(CASE WHEN publication_year IS NULL THEN 1 END) as null_years
')->first();

echo "  Année min: " . ($yearStats->min_year ?: 'NULL') . "\n";
echo "  Année max: " . ($yearStats->max_year ?: 'NULL') . "\n";
echo "  Année moyenne: " . round($yearStats->avg_year) . "\n";

if ($yearStats->too_old > 0) {
    echo "  ⚠️ {$yearStats->too_old} livres avec année < 1900\n";
    $issues[] = "{$yearStats->too_old} livres avec année de publication < 1900";
}
if ($yearStats->future > 0) {
    echo "  ⚠️ {$yearStats->future} livres avec année > 2025\n";
    $issues[] = "{$yearStats->future} livres avec année de publication > 2025";
}
if ($yearStats->null_years > 0) {
    echo "  🟡 {$yearStats->null_years} livres sans année de publication\n";
}

// 4. COHÉRENCE DES DONNÉES
echo "\n4. VÉRIFICATION DE LA COHÉRENCE DES DONNÉES\n";
echo "═════════════════════════════════════════════\n\n";

// Catégories par niveau
echo "→ Cohérence Catégorie/Niveau:\n";
$incoherent = Book::where('level', 'primaire')
    ->whereIn('category', ['Philosophy', 'Philosophie', 'Medicine', 'Médecine', 'Law', 'Droit'])
    ->count();
if ($incoherent > 0) {
    echo "  ⚠️ $incoherent livres avancés marqués comme 'primaire'\n";
    $issues[] = "$incoherent livres avec catégories avancées en niveau primaire";
} else {
    echo "  ✓ Pas de livres avancés en primaire\n";
}

// Titres dupliqués
echo "\n→ Détection des doublons:\n";
$duplicates = DB::select("
    SELECT title, author_name, COUNT(*) as count 
    FROM books 
    WHERE title IS NOT NULL AND author_name IS NOT NULL
    GROUP BY title, author_name 
    HAVING COUNT(*) > 1
");
$totalDuplicates = count($duplicates);
if ($totalDuplicates > 0) {
    echo "  ⚠️ $totalDuplicates combinaisons titre/auteur en double\n";
    $totalDupBooks = array_sum(array_column($duplicates, 'count')) - $totalDuplicates;
    echo "     Soit $totalDupBooks livres en trop\n";
    $issues[] = "$totalDuplicates doublons détectés ($totalDupBooks livres)";
} else {
    echo "  ✓ Aucun doublon détecté\n";
}

// ISBN valides
echo "\n→ Validation des ISBN:\n";
$withIsbn = Book::whereNotNull('isbn')->where('isbn', '!=', '')->count();
$validIsbn = Book::whereNotNull('isbn')
    ->where('isbn', 'REGEXP', '^[0-9]{10}$|^[0-9]{13}$')
    ->count();

echo "  Total avec ISBN: $withIsbn\n";
echo "  ISBN valides (10 ou 13 chiffres): $validIsbn\n";
if ($withIsbn > $validIsbn) {
    $invalid = $withIsbn - $validIsbn;
    echo "  ⚠️ $invalid ISBN mal formatés\n";
    $issues[] = "$invalid ISBN mal formatés";
}

// 5. DONNÉES NUMÉRIQUES
echo "\n5. VALIDATION DES DONNÉES NUMÉRIQUES\n";
echo "══════════════════════════════════════\n\n";

// Pages
$pageStats = Book::selectRaw('
    MIN(pages) as min_pages,
    MAX(pages) as max_pages,
    AVG(pages) as avg_pages,
    COUNT(CASE WHEN pages <= 0 THEN 1 END) as zero_pages,
    COUNT(CASE WHEN pages > 5000 THEN 1 END) as huge_books,
    COUNT(CASE WHEN pages IS NULL THEN 1 END) as null_pages
')->first();

echo "→ Nombre de pages:\n";
echo "  Min: " . ($pageStats->min_pages ?: 'NULL') . " | Max: " . ($pageStats->max_pages ?: 'NULL');
echo " | Moyenne: " . round($pageStats->avg_pages) . "\n";

if ($pageStats->zero_pages > 0) {
    echo "  ⚠️ {$pageStats->zero_pages} livres avec 0 pages ou moins\n";
    $issues[] = "{$pageStats->zero_pages} livres avec nombre de pages invalide";
}
if ($pageStats->huge_books > 0) {
    echo "  🟡 {$pageStats->huge_books} livres avec plus de 5000 pages\n";
}

// Views et Downloads
$statsViews = Book::selectRaw('
    COUNT(CASE WHEN views < 0 THEN 1 END) as negative_views,
    COUNT(CASE WHEN downloads < 0 THEN 1 END) as negative_downloads,
    COUNT(CASE WHEN downloads > views THEN 1 END) as downloads_exceed_views
')->first();

echo "\n→ Statistiques de consultation:\n";
if ($statsViews->negative_views > 0) {
    echo "  ❌ {$statsViews->negative_views} livres avec vues négatives\n";
    $issues[] = "{$statsViews->negative_views} livres avec vues négatives";
}
if ($statsViews->negative_downloads > 0) {
    echo "  ❌ {$statsViews->negative_downloads} livres avec téléchargements négatifs\n";
    $issues[] = "{$statsViews->negative_downloads} livres avec téléchargements négatifs";
}
if ($statsViews->downloads_exceed_views > 0) {
    echo "  ⚠️ {$statsViews->downloads_exceed_views} livres avec plus de téléchargements que de vues\n";
}

// 6. RÉSUMÉ ET RECOMMANDATIONS
echo "\n╔══════════════════════════════════════════════════════════════════════════════╗\n";
echo "║                                RÉSUMÉ DE L'AUDIT                              ║\n";
echo "╚══════════════════════════════════════════════════════════════════════════════╝\n\n";

$issueCount = count($issues);
if ($issueCount == 0) {
    echo "🎉 EXCELLENT! Aucun problème critique détecté dans la base de données.\n";
} else {
    echo "⚠️ $issueCount PROBLÈMES DÉTECTÉS:\n\n";
    foreach ($issues as $i => $issue) {
        echo ($i + 1) . ". $issue\n";
    }
}

echo "\n📊 STATISTIQUES GLOBALES:\n";
echo "  • Total de livres: $totalBooks\n";
echo "  • Livres approuvés: " . Book::where('status', 'approved')->count() . "\n";
echo "  • Livres avec niveau défini: " . Book::whereNotNull('level')->count() . "\n";
echo "  • Langues différentes: " . Book::distinct('language')->count('language') . "\n";
echo "  • Catégories différentes: " . Book::distinct('category')->count('category') . "\n";

echo "\n💡 RECOMMANDATIONS:\n";
echo "  1. Corriger les valeurs NULL dans les colonnes critiques\n";
echo "  2. Standardiser tous les codes de langue en ISO 639-1\n";
echo "  3. Valider et corriger les années de publication\n";
echo "  4. Supprimer ou fusionner les doublons\n";
echo "  5. Ajouter des contraintes de validation dans la base de données\n";