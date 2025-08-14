<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/search', 'GET', ['q' => 'Histoire']);
$response = $kernel->handle($request);

// Get the view data
$view = $response->original;
if ($view instanceof Illuminate\View\View) {
    $data = $view->getData();
    $books = $data['books'] ?? null;
    
    if ($books) {
        echo "Total books returned: " . $books->total() . PHP_EOL;
        echo "Books on current page: " . $books->count() . PHP_EOL;
        echo "Search parameter q: " . $request->get('q') . PHP_EOL;
        echo "Search parameter search: " . $request->get('search') . PHP_EOL;
        
        // Show first 3 book titles
        echo "\nFirst 3 books:\n";
        foreach ($books->take(3) as $book) {
            echo "- " . $book->title . " (Category: " . $book->category . ")\n";
        }
    } else {
        echo "No books data found in view\n";
    }
} else {
    echo "Response is not a view\n";
}

$kernel->terminate($request, $response);