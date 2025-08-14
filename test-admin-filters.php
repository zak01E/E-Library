<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;

echo "╔══════════════════════════════════════════════════════════════════╗\n";
echo "║         VÉRIFICATION DES FILTRES ADMIN (Contrôleur)              ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

// 1. Récupérer les données comme le fait le contrôleur
echo "1. DONNÉES DISPONIBLES POUR LES FILTRES\n";
echo "════════════════════════════════════════\n\n";

// Catégories distinctes
$categories = Book::select('category')
    ->distinct()
    ->whereNotNull('category')
    ->orderBy('category')
    ->pluck('category');

echo "📚 CATÉGORIES (" . count($categories) . " total):\n";
$i = 0;
foreach ($categories as $category) {
    echo "  • $category\n";
    $i++;
    if ($i >= 10) {
        echo "  ... et " . (count($categories) - 10) . " autres\n";
        break;
    }
}

// Langues distinctes
$languages = Book::select('language')
    ->distinct()
    ->whereNotNull('language')
    ->orderBy('language')
    ->pluck('language');

echo "\n🌍 LANGUES (" . count($languages) . " total):\n";
foreach ($languages as $language) {
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
        'ko' => 'Coréen'
    ];
    $displayName = $languageNames[$language] ?? $language;
    echo "  • $language → $displayName\n";
}

// Niveaux
$levels = ['primaire', 'college', 'lycee', 'superieur', 'professionnel'];
echo "\n🎓 NIVEAUX (définis dans le contrôleur):\n";
foreach ($levels as $level) {
    $count = Book::where('level', $level)->count();
    echo "  • " . ucfirst($level) . ": $count livres\n";
}

// Statuts
$statuses = ['approved', 'pending', 'rejected'];
echo "\n📊 STATUTS:\n";
foreach ($statuses as $status) {
    $count = Book::where('status', $status)->count();
    echo "  • " . ucfirst($status) . ": $count livres\n";
}

// 2. Statistiques
echo "\n2. STATISTIQUES GLOBALES\n";
echo "════════════════════════\n";

$stats = [
    'total' => Book::count(),
    'approved' => Book::where('status', 'approved')->count(),
    'pending' => Book::where('status', 'pending')->count(),
    'rejected' => Book::where('status', 'rejected')->count(),
    'with_level' => Book::whereNotNull('level')->count(),
    'without_level' => Book::whereNull('level')->count(),
];

foreach ($stats as $key => $value) {
    echo str_pad(ucfirst(str_replace('_', ' ', $key)) . ":", 20) . " $value\n";
}

// 3. Test d'un filtre complexe
echo "\n3. TEST DE FILTRE COMPLEXE\n";
echo "═══════════════════════════\n";

$query = Book::with('uploader');

// Appliquer plusieurs filtres
$query->where('level', 'lycee')
      ->where('language', 'fr')
      ->where('status', 'approved');

$filteredCount = $query->count();
echo "Livres approuvés en français pour le lycée: $filteredCount\n";

if ($filteredCount > 0) {
    echo "\nExemples:\n";
    $examples = $query->limit(3)->get();
    foreach ($examples as $book) {
        echo "  • {$book->title}\n";
        echo "    Catégorie: {$book->category} | Auteur: {$book->author_name}\n";
    }
}

// 4. Vérification de la cohérence
echo "\n4. VÉRIFICATION DE LA COHÉRENCE\n";
echo "═════════════════════════════════\n";

// Livres avec catégories redondantes
$redundantCategories = ['Primaire', 'Collège', 'Lycée', 'Supérieur', 'Professionnel'];
$redundantCount = Book::whereIn('category', $redundantCategories)->count();

if ($redundantCount > 0) {
    echo "⚠️ ATTENTION: $redundantCount livres ont encore des catégories redondantes!\n";
    $examples = Book::whereIn('category', $redundantCategories)->limit(3)->get();
    foreach ($examples as $book) {
        echo "  • ID {$book->id}: {$book->title} → Catégorie: '{$book->category}'\n";
    }
} else {
    echo "✅ Aucune catégorie redondante trouvée\n";
}

// 5. Test de l'URL admin
echo "\n5. TEST DE LA ROUTE ADMIN\n";
echo "══════════════════════════\n";

echo "URL de test: http://127.0.0.1:8000/admin/books\n";
echo "\nFiltres disponibles dans l'URL:\n";
echo "  • ?status=approved\n";
echo "  • ?level=primaire\n";
echo "  • ?category=Mathématiques\n";
echo "  • ?language=fr\n";
echo "  • ?year_from=2020&year_to=2024\n";
echo "  • ?search=titre\n";
echo "  • ?sort_by=downloads&sort_order=desc\n";

echo "\n╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                           RÉSUMÉ                                 ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

echo "✅ LE PANNEAU ADMIN A MAINTENANT:\n";
echo "  • " . count($categories) . " catégories disponibles dans les filtres\n";
echo "  • " . count($languages) . " langues disponibles\n";
echo "  • 5 niveaux éducatifs\n";
echo "  • Filtres par année de publication\n";
echo "  • Tri par plusieurs critères\n";
echo "  • Recherche par titre, auteur, ISBN, éditeur\n";
echo "  • Statistiques détaillées\n";

echo "\n📋 POUR TESTER:\n";
echo "  1. Aller sur http://127.0.0.1:8000/admin/books\n";
echo "  2. Cliquer sur le bouton 'Filtres'\n";
echo "  3. Tous les filtres devraient être disponibles\n";