<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

echo "=== CAPTURE DU HTML POUR level=college ===\n\n";

// Faire la requête
$request = \Illuminate\Http\Request::create('/search', 'GET', ['level' => 'college']);
$response = $kernel->handle($request);

if ($response->getStatusCode() == 200) {
    $content = $response->getContent();
    
    // Sauvegarder le HTML complet
    file_put_contents('search-college-output.html', $content);
    echo "✓ HTML complet sauvegardé dans search-college-output.html\n\n";
    
    // Extraire la section des livres
    if (preg_match('/<div class="grid grid-cols-1.*?gap-6">(.*?)<\/div>\s*@else/s', $content, $matches)) {
        $booksSection = $matches[1];
        
        // Extraire chaque carte de livre
        preg_match_all('/<h3[^>]*>(.*?)<\/h3>/s', $booksSection, $titles);
        
        echo "TITRES DES LIVRES AFFICHÉS:\n";
        echo "----------------------------\n";
        foreach ($titles[1] as $index => $title) {
            $cleanTitle = strip_tags(trim($title));
            echo ($index + 1) . ". $cleanTitle\n";
            
            // Vérifier si c'est "Livre Numéro X"
            if (strpos($cleanTitle, 'Livre Numéro') !== false) {
                echo "   ⚠️ TITRE GÉNÉRIQUE DÉTECTÉ!\n";
            }
        }
        
        // Compter les livres
        $bookCount = substr_count($booksSection, 'class="bg-white rounded-xl shadow-lg');
        echo "\nNombre de cartes de livres: $bookCount\n";
    }
    
    // Vérifier le nombre affiché
    if (preg_match('/(\d+) livre\(s\) trouvé\(s\)/', $content, $matches)) {
        echo "Nombre affiché dans l'interface: {$matches[1]} livres\n";
    }
    
    // Vérifier si le filtre est actif
    if (strpos($content, 'Niveau filtré') !== false) {
        echo "✓ Le filtre de niveau est affiché comme actif\n";
        if (preg_match('/Niveau filtré[^<]*<strong>([^<]+)<\/strong>/', $content, $matches)) {
            echo "  Valeur du filtre: {$matches[1]}\n";
        }
    }
    
    echo "\n=== VÉRIFICATION DE LA SOURCE DES DONNÉES ===\n";
    
    // Vérifier directement ce que retourne le contrôleur
    $controller = new \App\Http\Controllers\SearchController();
    $response = $controller->index($request);
    $viewData = $response->getData();
    $books = $viewData['books'];
    
    echo "\nLivres retournés par le contrôleur:\n";
    foreach ($books->take(5) as $index => $book) {
        echo ($index + 1) . ". ID {$book->id}: {$book->title} (Cat: {$book->category}, Level: {$book->level})\n";
    }
    
} else {
    echo "❌ Erreur HTTP: " . $response->getStatusCode() . "\n";
}

echo "\n📝 Vérifiez le fichier search-college-output.html pour voir le HTML complet\n";