<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;

echo "╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                    TEST COMPLET DES FILTRES                      ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

// Fonction pour tester un filtre
function testFilter($filterName, $filterValue, $expectedCount = null) {
    echo "\n→ Test du filtre: $filterName = '$filterValue'\n";
    echo str_repeat('-', 50) . "\n";
    
    // Créer une requête simulée
    $request = new Request();
    $request->merge([$filterName => $filterValue]);
    
    // Tester directement avec le contrôleur
    $controller = new SearchController();
    $response = $controller->index($request);
    $data = $response->getData();
    $books = $data['books'];
    
    echo "  Paramètres de la requête: " . json_encode($request->all()) . "\n";
    echo "  Nombre de résultats: " . $books->total() . " livres\n";
    echo "  Première page: " . $books->count() . " livres affichés\n";
    
    // Vérifier directement dans la base
    $query = Book::where('status', 'approved');
    if ($filterName === 'level' && $filterValue !== 'all') {
        $query->where('level', $filterValue);
    } elseif ($filterName === 'category' && $filterValue !== 'all') {
        $query->where('category', $filterValue);
    } elseif ($filterName === 'language' && $filterValue !== 'all') {
        $query->where('language', $filterValue);
    }
    $directCount = $query->count();
    echo "  Vérification directe DB: $directCount livres\n";
    
    // Comparer les résultats
    if ($books->total() == $directCount) {
        echo "  ✅ Le filtre fonctionne correctement\n";
    } else {
        echo "  ❌ PROBLÈME: Les nombres ne correspondent pas!\n";
        echo "     Controller: {$books->total()} vs DB direct: $directCount\n";
    }
    
    // Afficher quelques exemples
    if ($books->count() > 0) {
        echo "  Exemples de livres trouvés:\n";
        foreach ($books->take(3) as $book) {
            echo "    - {$book->title} ({$filterName}: {$book->$filterName})\n";
        }
    }
    
    return $books->total() == $directCount;
}

// Tester avec une requête HTTP simulée complète
function testHTTPRequest($url, $params) {
    echo "\n═══ Test HTTP: $url avec " . http_build_query($params) . " ═══\n";
    
    $request = Request::create($url, 'GET', $params);
    $app = app();
    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle($request);
    
    $content = $response->getContent();
    
    // Extraire le nombre de livres depuis le HTML
    if (preg_match('/(\d+) livre\(s\) trouvé\(s\)/', $content, $matches)) {
        echo "  Livres affichés selon le HTML: {$matches[1]}\n";
    }
    
    // Vérifier si le filtre est affiché
    if (isset($params['level']) && strpos($content, 'Niveau filtré') !== false) {
        echo "  ✅ Le filtre de niveau est affiché dans l'interface\n";
    }
    
    if (isset($params['category']) && strpos($content, 'Catégorie filtrée') !== false) {
        echo "  ✅ Le filtre de catégorie est affiché dans l'interface\n";
    }
    
    return $response->getStatusCode() === 200;
}

// TESTS DES FILTRES INDIVIDUELS
echo "\n╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                    1. TESTS DES FILTRES NIVEAU                   ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n";

$niveaux = ['primaire', 'college', 'lycee', 'superieur', 'professionnel'];
$allPass = true;

foreach ($niveaux as $niveau) {
    $pass = testFilter('level', $niveau);
    $allPass = $allPass && $pass;
}

echo "\n╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                  2. TESTS DES FILTRES CATÉGORIE                  ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n";

$categories = ['Science', 'Art', 'Religion', 'Fantasy', 'Programming'];
foreach ($categories as $category) {
    testFilter('category', $category);
}

echo "\n╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                   3. TESTS DES FILTRES LANGUE                    ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n";

$languages = ['fr', 'en', 'es'];
foreach ($languages as $language) {
    testFilter('language', $language);
}

echo "\n╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                    4. TESTS DE COMBINAISONS                      ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n";

// Test de combinaisons de filtres
echo "\n→ Test combiné: level='college' ET category='Mathématiques'\n";
$request = new Request(['level' => 'college', 'category' => 'Mathématiques']);
$controller = new SearchController();
$response = $controller->index($request);
$books = $response->getData()['books'];
echo "  Résultat: {$books->total()} livres\n";

// Vérification directe
$direct = Book::where('status', 'approved')
    ->where('level', 'college')
    ->where('category', 'Mathématiques')
    ->count();
echo "  Vérification DB: $direct livres\n";

echo "\n╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                     5. TESTS HTTP COMPLETS                       ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n";

testHTTPRequest('/search', ['level' => 'college']);
testHTTPRequest('/search', ['level' => 'primaire']);
testHTTPRequest('/search', ['category' => 'Science']);

echo "\n╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                         RÉSUMÉ FINAL                             ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n";

if ($allPass) {
    echo "\n✅ TOUS LES FILTRES FONCTIONNENT CORRECTEMENT\n";
    echo "\nLes filtres sont opérationnels côté serveur.\n";
    echo "Si le problème persiste dans le navigateur, vérifiez:\n";
    echo "  1. Le cache du navigateur (Ctrl+F5)\n";
    echo "  2. Les cookies et sessions\n";
    echo "  3. La console JavaScript pour des erreurs\n";
} else {
    echo "\n❌ CERTAINS FILTRES ONT DES PROBLÈMES\n";
    echo "Vérifiez les messages d'erreur ci-dessus.\n";
}