<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/authors', 'GET');
$response = $kernel->handle($request);

$content = $response->getContent();

// Chercher des redirections dans le contenu
if (stripos($content, 'author/login') !== false) {
    echo "FOUND: Reference to author/login in content\n\n";
}

if (stripos($content, 'window.location') !== false) {
    echo "FOUND: JavaScript redirect in content\n\n";
}

if (stripos($content, 'meta http-equiv="refresh"') !== false) {
    echo "FOUND: Meta refresh redirect in content\n\n";
}

// Afficher les 50 premières lignes du contenu
$lines = explode("\n", $content);
echo "First 50 lines of content:\n";
echo "=========================\n";
for ($i = 0; $i < min(50, count($lines)); $i++) {
    echo ($i + 1) . ": " . $lines[$i] . "\n";
}