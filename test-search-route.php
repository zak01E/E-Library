<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/search', 'GET', ['level' => 'primaire'])
);

// Afficher les informations de la requête
echo "=== TEST DE LA ROUTE /search?level=primaire ===\n\n";
echo "URL: " . $request->url() . "\n";
echo "Query String: " . $request->getQueryString() . "\n";
echo "Paramètre level: " . $request->get('level') . "\n";
echo "Status HTTP: " . $response->getStatusCode() . "\n\n";

// Extraire les données du contrôleur
$content = $response->getContent();

// Compter les livres affichés
preg_match_all('/class="bg-white rounded-xl shadow-lg/', $content, $matches);
$bookCount = count($matches[0]);
echo "Nombre de livres affichés dans le HTML: $bookCount\n";

// Vérifier si le filtre est affiché
if (strpos($content, 'Niveau filtré : <strong>Primaire</strong>') !== false) {
    echo "✓ Le filtre de niveau est bien affiché dans l'interface\n";
} else {
    echo "✗ Le filtre de niveau n'est pas affiché\n";
}

// Extraire le nombre total depuis le HTML
if (preg_match('/(\d+) livre\(s\) trouvé\(s\)/', $content, $matches)) {
    echo "Nombre total de livres selon le HTML: {$matches[1]}\n";
}

// Tester directement le contrôleur
echo "\n=== TEST DIRECT DU CONTRÔLEUR ===\n";
$controller = new \App\Http\Controllers\SearchController();
$testRequest = new \Illuminate\Http\Request(['level' => 'primaire']);
$response = $controller->index($testRequest);
$viewData = $response->getData();

echo "Nombre de livres dans les données de la vue: " . $viewData['books']->total() . "\n";
echo "Nombre de livres sur cette page: " . $viewData['books']->count() . "\n";

// Afficher quelques livres pour vérifier
echo "\nPremiers livres retournés:\n";
foreach ($viewData['books']->take(3) as $book) {
    echo "- {$book->title} (Niveau: {$book->level})\n";
}