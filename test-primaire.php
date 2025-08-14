<?php
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Enable query logging
\DB::enableQueryLog();

// Test avec level=primaire
$request = Request::create('/search', 'GET', ['level' => 'primaire']);
$controller = new SearchController();
$response = $controller->index($request);

// Get queries
$queries = \DB::getQueryLog();
echo "=== TEST AVEC level=primaire ===\n";
echo "Nombre de requêtes: " . count($queries) . "\n\n";

// Afficher la requête principale
foreach ($queries as $i => $query) {
    if (strpos($query['query'], 'select * from `books`') !== false) {
        echo "Requête principale:\n";
        echo $query['query'] . "\n";
        echo "Bindings: " . json_encode($query['bindings']) . "\n\n";
        break;
    }
}

// Afficher le résultat
$books = $response->getData()['books'];
echo "Total livres trouvés: " . $books->total() . "\n";
echo "Livres sur la page: " . $books->count() . "\n";

if ($books->count() > 0) {
    echo "\nPremiers livres:\n";
    foreach ($books->take(3) as $book) {
        echo "- " . $book->title . " (Level: " . $book->level . ")\n";
    }
}