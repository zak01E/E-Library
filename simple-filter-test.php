<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Illuminate\Support\Facades\DB;

echo "═══════════════════════════════════════════════════════════════\n";
echo "           TEST SIMPLE DES FILTRES DE RECHERCHE\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

// 1. Test direct de la base de données
echo "1. VÉRIFICATION DIRECTE DANS LA BASE DE DONNÉES\n";
echo "------------------------------------------------\n\n";

$levels = ['primaire', 'college', 'lycee', 'superieur', 'professionnel'];

foreach ($levels as $level) {
    $count = Book::where('status', 'approved')
                 ->where('level', $level)
                 ->count();
    echo "Niveau '$level': $count livres approuvés\n";
    
    // Afficher 2 exemples
    $examples = Book::where('status', 'approved')
                    ->where('level', $level)
                    ->limit(2)
                    ->get(['id', 'title', 'category']);
    
    if ($examples->count() > 0) {
        foreach ($examples as $book) {
            echo "  → ID {$book->id}: {$book->title} (Cat: {$book->category})\n";
        }
    }
    echo "\n";
}

// 2. Test du trait BookFilterTrait
echo "2. TEST DU TRAIT DE FILTRAGE\n";
echo "-----------------------------\n\n";

// Simuler une requête pour college
$request = new \Illuminate\Http\Request();
$request->merge(['level' => 'college']);

$query = Book::query()->where('status', 'approved');

// Appliquer le filtre manuellement comme dans le trait
if ($request->filled('level') && $request->level !== 'all') {
    echo "Application du filtre: level = '{$request->level}'\n";
    $query->where('level', $request->level);
}

$result = $query->count();
echo "Résultat avec le trait: $result livres\n\n";

// 3. Test avec une vraie requête HTTP
echo "3. TEST AVEC REQUÊTE HTTP SIMULÉE\n";
echo "----------------------------------\n\n";

foreach ($levels as $level) {
    $request = \Illuminate\Http\Request::create('/search', 'GET', ['level' => $level]);
    $response = $kernel->handle($request);
    
    if ($response->getStatusCode() == 200) {
        $content = $response->getContent();
        
        // Extraire le nombre depuis le HTML
        if (preg_match('/(\d+) livre\(s\) trouvé\(s\)/', $content, $matches)) {
            echo "URL /search?level=$level → {$matches[1]} livres\n";
            
            // Vérifier si le filtre est affiché
            if (strpos($content, 'Niveau filtré') !== false) {
                echo "  ✓ Le filtre est affiché dans l'interface\n";
            } else {
                echo "  ✗ Le filtre n'est PAS affiché\n";
            }
        } else {
            echo "URL /search?level=$level → Impossible d'extraire le nombre\n";
        }
    } else {
        echo "URL /search?level=$level → Erreur HTTP {$response->getStatusCode()}\n";
    }
}

echo "\n4. DIAGNOSTIC DU PROBLÈME\n";
echo "-------------------------\n\n";

// Vérifier s'il y a des middlewares qui pourraient interférer
$route = app('router')->getRoutes()->match($request);
echo "Route matchée: " . $route->uri() . "\n";
echo "Action: " . $route->getActionName() . "\n";
echo "Middlewares: " . implode(', ', $route->middleware()) . "\n\n";

// Vérifier les sessions
echo "5. URLS DE TEST POUR LE NAVIGATEUR\n";
echo "-----------------------------------\n\n";
echo "Testez ces URLs directement dans votre navigateur:\n\n";
echo "• http://127.0.0.1:8000/search?level=college\n";
echo "  → Devrait afficher 956 livres du collège\n\n";
echo "• http://127.0.0.1:8000/search?level=primaire\n";
echo "  → Devrait afficher 248 livres du primaire\n\n";
echo "• http://127.0.0.1:8000/search?level=lycee\n";
echo "  → Devrait afficher 249 livres du lycée\n\n";

echo "Si les nombres ne correspondent pas, vérifiez:\n";
echo "1. Videz le cache du navigateur (Ctrl+F5)\n";
echo "2. Ouvrez la console du navigateur (F12) pour voir les erreurs\n";
echo "3. Vérifiez l'onglet Network pour voir la requête exacte\n";