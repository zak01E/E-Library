<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/authors', 'GET');
$response = $kernel->handle($request);

echo "Status Code: " . $response->getStatusCode() . "\n";
echo "Headers:\n";
foreach ($response->headers->all() as $key => $value) {
    echo "  $key: " . implode(', ', $value) . "\n";
}

if ($response->getStatusCode() === 302 || $response->getStatusCode() === 301) {
    echo "\nRedirect Location: " . $response->headers->get('Location') . "\n";
}

// Check the route
$router = app('router');
$route = $router->getRoutes()->match($request);
echo "\nMatched Route: " . $route->getName() . "\n";
echo "Route Action: " . $route->getActionName() . "\n";
echo "Route Middleware: " . implode(', ', $route->middleware()) . "\n";