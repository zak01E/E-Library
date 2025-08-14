<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;

echo "=== INVESTIGATION DU LIVRE ID 174 ===\n\n";

// 1. Vérifier le livre ID 174
$book174 = Book::find(174);
if ($book174) {
    echo "LIVRE ID 174:\n";
    echo "-------------\n";
    echo "Titre: {$book174->title}\n";
    echo "Auteur: {$book174->author_name}\n";
    echo "Catégorie: {$book174->category}\n";
    echo "Niveau: " . ($book174->level ?: 'NULL') . "\n";
    echo "Status: {$book174->status}\n";
    echo "Langue: {$book174->language}\n";
    echo "ID Uploader: {$book174->uploader_id}\n\n";
} else {
    echo "❌ Le livre ID 174 n'existe pas!\n\n";
}

// 2. Vérifier ce qui devrait s'afficher pour level=college
echo "LIVRES QUI DEVRAIENT S'AFFICHER POUR level=college:\n";
echo "----------------------------------------------------\n";
$collegeBooks = Book::where('status', 'approved')
    ->where('level', 'college')
    ->orderBy('id', 'asc')
    ->limit(10)
    ->get(['id', 'title', 'category', 'level']);

echo "Premiers 10 livres du niveau collège:\n";
foreach ($collegeBooks as $book) {
    echo "  ID {$book->id}: {$book->title} (Cat: {$book->category})\n";
}

echo "\nNombre total de livres niveau collège: " . Book::where('status', 'approved')->where('level', 'college')->count() . "\n";

// 3. Vérifier si le livre 174 pourrait apparaître par défaut
echo "\n=== HYPOTHÈSES SUR LE PROBLÈME ===\n";

// Le livre 174 est-il dans les premiers résultats sans filtre?
$position = Book::where('status', 'approved')
    ->where('id', '<=', 174)
    ->count();
echo "Position du livre 174 sans filtre: $position\n";

// Est-ce que le filtre est ignoré?
$bookInCollege = Book::where('id', 174)->where('level', 'college')->exists();
if ($bookInCollege) {
    echo "✓ Le livre 174 EST bien de niveau collège\n";
} else {
    echo "✗ Le livre 174 N'EST PAS de niveau collège\n";
}

// 4. Tester la requête exacte
echo "\n=== TEST DE LA REQUÊTE SIMULÉE ===\n";
$request = \Illuminate\Http\Request::create('/search', 'GET', ['level' => 'college']);
$response = $kernel->handle($request);

if ($response->getStatusCode() == 200) {
    $content = $response->getContent();
    
    // Vérifier si le livre 174 est dans le contenu
    if (strpos($content, 'Livre Numéro 174') !== false) {
        echo "❌ PROBLÈME CONFIRMÉ: 'Livre Numéro 174' apparaît dans la réponse!\n";
    } else {
        echo "✓ 'Livre Numéro 174' n'apparaît PAS dans la réponse serveur\n";
    }
    
    // Extraire les IDs des livres affichés
    preg_match_all('/data-book-id="(\d+)"/', $content, $matches);
    if (!empty($matches[1])) {
        echo "\nIDs des livres dans la réponse: " . implode(', ', array_slice($matches[1], 0, 10)) . "...\n";
    }
    
    // Vérifier le filtre actif
    if (strpos($content, 'Niveau filtré') !== false && strpos($content, 'College') !== false) {
        echo "✓ Le filtre 'College' est bien affiché comme actif\n";
    }
}

// 5. Vérifier le template
echo "\n=== DIAGNOSTIC PROBABLE ===\n";
echo "1. Si vous voyez 'Livre Numéro 174', c'est probablement:\n";
echo "   - Un problème de cache navigateur\n";
echo "   - Un problème JavaScript qui empêche le rechargement\n";
echo "   - Un titre générique par défaut dans le template\n";
echo "\n2. Actions recommandées:\n";
echo "   - Faire Ctrl+F5 dans le navigateur\n";
echo "   - Vérifier la console JavaScript (F12)\n";
echo "   - Tester en navigation privée\n";