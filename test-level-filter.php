<?php
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test 1: Seulement level=primaire
echo "=== TEST 1: level=primaire seul ===\n";
$request1 = Request::create('/search', 'GET', ['level' => 'primaire']);
$controller = new SearchController();
$response1 = $controller->index($request1);
$books1 = $response1->getData()['books'];
echo "Total: " . $books1->total() . " livres\n\n";

// Test 2: level=primaire avec sort_by
echo "=== TEST 2: level=primaire + sort_by=created_at ===\n";
$request2 = Request::create('/search', 'GET', [
    'level' => 'primaire',
    'sort_by' => 'created_at',
    'sort_order' => 'desc'
]);
$response2 = $controller->index($request2);
$books2 = $response2->getData()['books'];
echo "Total: " . $books2->total() . " livres\n\n";

// Test 3: level=primaire avec champs vides
echo "=== TEST 3: level=primaire + champs vides ===\n";
$request3 = Request::create('/search', 'GET', [
    'q' => '',
    'level' => 'primaire',
    'category' => '',
    'language' => '',
    'year_from' => '',
    'year_to' => '',
    'sort_by' => 'created_at',
    'sort_order' => 'desc'
]);
$response3 = $controller->index($request3);
$books3 = $response3->getData()['books'];
echo "Total: " . $books3->total() . " livres\n";
echo "Paramètres reçus: " . json_encode($request3->all()) . "\n";