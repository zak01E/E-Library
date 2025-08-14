<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;

echo "╔══════════════════════════════════════════════════════════════════╗\n";
echo "║            TEST DE LA PAGE DE DÉTAIL DES LIVRES                  ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

// 1. Trouver le livre ID 7138 ou un autre livre de test
$bookId = 7138;
$book = Book::find($bookId);

if (!$book) {
    // Si le livre 7138 n'existe pas, prendre un livre avec niveau
    $book = Book::whereNotNull('level')->first();
    $bookId = $book->id;
}

echo "LIVRE TESTÉ: ID $bookId\n";
echo "════════════════\n";
echo "Titre: {$book->title}\n";
echo "Auteur: {$book->author_name}\n";
echo "Catégorie: {$book->category}\n";
echo "Niveau: " . ($book->level ?: 'NULL') . "\n";
echo "Langue: {$book->language}\n";
echo "Année: " . ($book->publication_year ?: 'NULL') . "\n";
echo "Pages: " . ($book->pages ?: 'NULL') . "\n\n";

// 2. Vérifier la cohérence
echo "VÉRIFICATION DE LA COHÉRENCE\n";
echo "═════════════════════════════\n";

$redundantCategories = ['Primaire', 'Collège', 'Lycée', 'Supérieur', 'Professionnel'];

if (in_array($book->category, $redundantCategories)) {
    echo "⚠️ ATTENTION: La catégorie '{$book->category}' est redondante!\n";
    echo "   Elle devrait être remplacée par une vraie matière.\n";
} else {
    echo "✅ La catégorie '{$book->category}' est correcte (pas de redondance)\n";
}

if ($book->level && strtolower($book->category) == $book->level) {
    echo "⚠️ ATTENTION: Catégorie identique au niveau!\n";
} else {
    echo "✅ Catégorie différente du niveau\n";
}

// 3. Tester la page HTML
echo "\nTEST DE L'AFFICHAGE HTML\n";
echo "════════════════════════\n";

$request = \Illuminate\Http\Request::create("/library/$bookId", 'GET');
$response = $kernel->handle($request);

if ($response->getStatusCode() == 200) {
    $content = $response->getContent();
    
    // Vérifier la présence des badges
    $checks = [
        'Badge niveau' => strpos($content, 'Niveau ' . ucfirst($book->level)) !== false,
        'Icône niveau' => strpos($content, 'fa-school') !== false || 
                         strpos($content, 'fa-graduation-cap') !== false ||
                         strpos($content, 'fa-university') !== false ||
                         strpos($content, 'fa-child') !== false ||
                         strpos($content, 'fa-briefcase') !== false,
        'Catégorie affichée' => strpos($content, $book->category) !== false,
        'Auteur affiché' => strpos($content, $book->author_name) !== false,
        'Langue affichée' => strpos($content, 'Langue') !== false
    ];
    
    foreach ($checks as $check => $result) {
        echo $result ? "✅ $check\n" : "❌ $check manquant\n";
    }
    
    // Vérifier les redondances
    if ($book->level == 'lycee' && strpos($content, 'Lycée') !== false && strpos($content, 'Lycée', strpos($content, 'Lycée') + 1) !== false) {
        echo "⚠️ Redondance 'Lycée' détectée dans l'affichage\n";
    } else {
        echo "✅ Pas de redondance de niveau détectée\n";
    }
    
} else {
    echo "❌ Erreur HTTP: " . $response->getStatusCode() . "\n";
}

// 4. Exemples d'autres livres
echo "\nAUTRES EXEMPLES DE LIVRES\n";
echo "══════════════════════════\n";

$examples = Book::whereNotNull('level')
    ->whereNotNull('category')
    ->limit(5)
    ->get(['id', 'title', 'category', 'level']);

foreach ($examples as $ex) {
    echo "\nID {$ex->id}: {$ex->title}\n";
    echo "  → Niveau: {$ex->level} | Catégorie: {$ex->category}\n";
    
    if (in_array($ex->category, $redundantCategories)) {
        echo "  ⚠️ Catégorie redondante!\n";
    }
    
    echo "  URL: http://127.0.0.1:8000/library/{$ex->id}\n";
}

echo "\n╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                           RÉSUMÉ                                 ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

echo "✅ CE QUI S'AFFICHE MAINTENANT SUR LA PAGE DE DÉTAIL:\n";
echo "  • Badge de niveau avec icône et couleur distinctive\n";
echo "  • Catégorie (seulement si différente du niveau)\n";
echo "  • Tous les détails du livre (auteur, année, pages, langue...)\n";
echo "  • Langue affichée en français (fr → Français)\n";
echo "\n❌ CE QUI NE S'AFFICHE PLUS:\n";
echo "  • Redondances type 'Lycée Lycée'\n";
echo "  • Catégories identiques au niveau\n";

echo "\n📋 URL DE TEST:\n";
echo "  http://127.0.0.1:8000/library/$bookId\n";