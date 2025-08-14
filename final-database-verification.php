<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Illuminate\Support\Facades\DB;

echo "\n╔══════════════════════════════════════════════════════════════════════════════╗\n";
echo "║                      VÉRIFICATION FINALE DE LA BASE DE DONNÉES                ║\n";
echo "╚══════════════════════════════════════════════════════════════════════════════╝\n\n";

$totalBooks = Book::count();

// 1. STATISTIQUES GÉNÉRALES
echo "📊 STATISTIQUES GÉNÉRALES\n";
echo "═════════════════════════\n\n";

echo "Total de livres: $totalBooks\n";
echo "Livres approuvés: " . Book::where('status', 'approved')->count() . "\n";
echo "Livres en attente: " . Book::where('status', 'pending')->count() . "\n";
echo "Livres rejetés: " . Book::where('status', 'rejected')->count() . "\n\n";

// 2. ANALYSE DES COLONNES IMPORTANTES
echo "📋 ANALYSE DES COLONNES IMPORTANTES\n";
echo "════════════════════════════════════\n\n";

$columns = [
    'title' => 'Titre',
    'author_name' => 'Auteur',
    'category' => 'Catégorie',
    'level' => 'Niveau',
    'language' => 'Langue',
    'publication_year' => 'Année publication',
    'pages' => 'Nombre de pages',
    'status' => 'Statut',
    'description' => 'Description'
];

foreach ($columns as $col => $name) {
    $filled = Book::whereNotNull($col)->where($col, '!=', '')->count();
    $percentage = round(($filled / $totalBooks) * 100, 1);
    $icon = $percentage >= 95 ? '✅' : ($percentage >= 70 ? '🟡' : '🔴');
    echo "$icon $name: $filled/$totalBooks ({$percentage}% rempli)\n";
}

// 3. VALIDATION DES VALEURS
echo "\n✔️ VALIDATION DES VALEURS\n";
echo "══════════════════════════\n\n";

// Status
$statusCheck = Book::whereNotIn('status', ['approved', 'pending', 'rejected'])->count();
echo "Status invalides: " . ($statusCheck == 0 ? "✅ Aucun" : "❌ $statusCheck") . "\n";

// Niveaux
$levelCheck = Book::whereNotNull('level')
    ->whereNotIn('level', ['primaire', 'college', 'lycee', 'superieur', 'professionnel'])
    ->count();
echo "Niveaux invalides: " . ($levelCheck == 0 ? "✅ Aucun" : "❌ $levelCheck") . "\n";

// Langues (codes ISO)
$langCheck = Book::whereRaw("LENGTH(language) != 2")->count();
echo "Codes langue non-ISO: " . ($langCheck == 0 ? "✅ Aucun" : "⚠️ $langCheck") . "\n";

// Années
$yearCheck = Book::whereNotNull('publication_year')
    ->where(function($q) {
        $q->where('publication_year', '<', 1900)
          ->orWhere('publication_year', '>', 2025);
    })->count();
echo "Années invalides: " . ($yearCheck == 0 ? "✅ Aucun" : "⚠️ $yearCheck") . "\n";

// Pages négatives ou zéro
$pageCheck = Book::whereNotNull('pages')->where('pages', '<=', 0)->count();
echo "Pages invalides (≤0): " . ($pageCheck == 0 ? "✅ Aucun" : "❌ $pageCheck") . "\n";

// Doublons
$duplicates = DB::select("
    SELECT COUNT(*) as total FROM (
        SELECT title, author_name, COUNT(*) as cnt
        FROM books 
        WHERE title IS NOT NULL AND author_name IS NOT NULL
        GROUP BY title, author_name 
        HAVING cnt > 1
    ) as dups
");
echo "Doublons titre/auteur: " . ($duplicates[0]->total == 0 ? "✅ Aucun" : "⚠️ {$duplicates[0]->total}") . "\n";

// 4. RÉPARTITION PAR NIVEAU
echo "\n📚 RÉPARTITION PAR NIVEAU\n";
echo "══════════════════════════\n\n";

$levels = Book::select('level', DB::raw('COUNT(*) as count'))
    ->groupBy('level')
    ->orderBy('count', 'desc')
    ->get();

foreach ($levels as $level) {
    $levelName = $level->level ?: 'Sans niveau (général)';
    $percentage = round(($level->count / $totalBooks) * 100, 1);
    $bar = str_repeat('█', (int)($percentage / 2));
    echo sprintf("%-25s %5d (%5.1f%%) %s\n", $levelName, $level->count, $percentage, $bar);
}

// 5. TOP CATÉGORIES
echo "\n📂 TOP 10 CATÉGORIES\n";
echo "═════════════════════\n\n";

$categories = Book::select('category', DB::raw('COUNT(*) as count'))
    ->groupBy('category')
    ->orderBy('count', 'desc')
    ->limit(10)
    ->get();

foreach ($categories as $i => $cat) {
    echo sprintf("%2d. %-30s: %4d livres\n", $i + 1, $cat->category, $cat->count);
}

// 6. LANGUES
echo "\n🌍 RÉPARTITION PAR LANGUE\n";
echo "══════════════════════════\n\n";

$languages = Book::select('language', DB::raw('COUNT(*) as count'))
    ->groupBy('language')
    ->orderBy('count', 'desc')
    ->limit(10)
    ->get();

$langNames = [
    'fr' => 'Français',
    'en' => 'Anglais',
    'es' => 'Espagnol',
    'de' => 'Allemand',
    'it' => 'Italien',
    'pt' => 'Portugais',
    'ru' => 'Russe',
    'ja' => 'Japonais',
    'zh' => 'Chinois',
    'ar' => 'Arabe',
    'ko' => 'Coréen',
    'hi' => 'Hindi'
];

foreach ($languages as $lang) {
    $name = $langNames[$lang->language] ?? $lang->language;
    echo sprintf("%-15s (%s): %5d livres\n", $name, $lang->language, $lang->count);
}

// 7. RÉSUMÉ QUALITÉ
echo "\n╔══════════════════════════════════════════════════════════════════════════════╗\n";
echo "║                              SCORE DE QUALITÉ                                 ║\n";
echo "╚══════════════════════════════════════════════════════════════════════════════╝\n\n";

$scores = [];

// Calculer les scores
$scores['Titres remplis'] = (Book::whereNotNull('title')->where('title', '!=', '')->count() / $totalBooks) * 100;
$scores['Auteurs remplis'] = (Book::whereNotNull('author_name')->where('author_name', '!=', '')->count() / $totalBooks) * 100;
$scores['Catégories définies'] = (Book::whereNotNull('category')->count() / $totalBooks) * 100;
$scores['Langues valides'] = (Book::whereRaw("LENGTH(language) = 2")->count() / $totalBooks) * 100;
$scores['Status valides'] = (Book::whereIn('status', ['approved', 'pending', 'rejected'])->count() / $totalBooks) * 100;

$totalScore = array_sum($scores) / count($scores);

foreach ($scores as $criterion => $score) {
    $icon = $score >= 95 ? '✅' : ($score >= 80 ? '🟡' : '🔴');
    echo sprintf("%s %-25s: %5.1f%%\n", $icon, $criterion, $score);
}

echo "\n";
echo str_repeat('═', 40) . "\n";
echo "SCORE GLOBAL DE QUALITÉ: " . round($totalScore, 1) . "%\n";

if ($totalScore >= 90) {
    echo "🎉 EXCELLENT! La base de données est en très bon état.\n";
} elseif ($totalScore >= 75) {
    echo "👍 BON. La base de données est correcte mais peut être améliorée.\n";
} else {
    echo "⚠️ À AMÉLIORER. La base de données nécessite des corrections.\n";
}

echo "\n📝 RECOMMANDATIONS FINALES:\n";
echo "───────────────────────────\n";

if (Book::whereNull('level')->count() > $totalBooks * 0.5) {
    echo "• Assigner des niveaux éducatifs à plus de livres\n";
}
if (Book::whereNull('publication_year')->count() > $totalBooks * 0.2) {
    echo "• Compléter les années de publication manquantes\n";
}
if ($duplicates[0]->total > 0) {
    echo "• Supprimer les {$duplicates[0]->total} doublons restants\n";
}
if (Book::whereNull('pages')->count() > $totalBooks * 0.1) {
    echo "• Ajouter le nombre de pages manquant\n";
}

echo "\n✨ Fin de la vérification.\n";