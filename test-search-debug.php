<?php
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Enable query logging
\DB::enableQueryLog();

// Create request and controller
$request = Request::create('/search', 'GET', ['q' => 'Histoire']);
$controller = new SearchController();

// Call the index method
$response = $controller->index($request);

// Get the queries
$queries = \DB::getQueryLog();

echo "Number of queries: " . count($queries) . "\n\n";

foreach ($queries as $i => $query) {
    echo "Query " . ($i + 1) . ":\n";
    echo $query['query'] . "\n";
    echo "Bindings: " . json_encode($query['bindings']) . "\n\n";
}

// Get books from view
$books = $response->getData()['books'];
echo "Total books: " . $books->total() . "\n";
echo "First book title: " . $books->first()->title . "\n";
echo "First book category: " . $books->first()->category . "\n";