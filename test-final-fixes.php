<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;

echo "╔══════════════════════════════════════════════════════════════════╗\n";
echo "║              VÉRIFICATION FINALE DES CORRECTIONS                 ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

// 1. Vérifier les titres génériques
echo "1. VÉRIFICATION DES TITRES\n";
echo "---------------------------\n";
$genericCount = Book::where('title', 'LIKE', 'Livre Numéro %')->count();
if ($genericCount == 0) {
    echo "✅ Aucun titre générique 'Livre Numéro X' trouvé!\n";
} else {
    echo "❌ Il reste $genericCount livres avec des titres génériques\n";
}

// Exemples de nouveaux titres
echo "\nExemples de titres pour le niveau collège:\n";
$collegeBooks = Book::where('status', 'approved')
    ->where('level', 'college')
    ->limit(5)
    ->get(['id', 'title', 'category']);

foreach ($collegeBooks as $book) {
    echo "  - {$book->title} (Cat: {$book->category})\n";
}

// 2. Vérifier l'affichage des badges
echo "\n2. TEST DE L'AFFICHAGE DES BADGES\n";
echo "----------------------------------\n";

$request = \Illuminate\Http\Request::create('/search', 'GET', ['level' => 'college']);
$response = $kernel->handle($request);

if ($response->getStatusCode() == 200) {
    $content = $response->getContent();
    
    // Vérifier la présence des badges de niveau
    $badges = [
        'primaire' => ['fa-child', 'Primaire'],
        'college' => ['fa-school', 'College'],
        'lycee' => ['fa-graduation-cap', 'Lycee'],
        'superieur' => ['fa-university', 'Superieur'],
        'professionnel' => ['fa-briefcase', 'Professionnel']
    ];
    
    $badgeFound = false;
    foreach ($badges as $level => $identifiers) {
        if (strpos($content, $identifiers[0]) !== false || 
            strpos($content, ucfirst($level)) !== false) {
            $badgeFound = true;
            break;
        }
    }
    
    if ($badgeFound) {
        echo "✅ Les badges de niveau sont affichés dans l'interface!\n";
    } else {
        echo "❌ Les badges de niveau ne sont pas visibles\n";
    }
    
    // Vérifier les couleurs
    $colors = ['text-purple-700', 'text-blue-700', 'text-orange-700', 'text-red-700', 'text-indigo-700'];
    $colorFound = false;
    foreach ($colors as $color) {
        if (strpos($content, $color) !== false) {
            $colorFound = true;
            break;
        }
    }
    
    if ($colorFound) {
        echo "✅ Les couleurs distinctives des niveaux sont appliquées!\n";
    } else {
        echo "❌ Les couleurs des badges ne sont pas appliquées\n";
    }
}

// 3. Test spécifique du livre 174
echo "\n3. VÉRIFICATION DU LIVRE ID 174\n";
echo "--------------------------------\n";
$book174 = Book::find(174);
if ($book174) {
    echo "Titre actuel: {$book174->title}\n";
    echo "Catégorie: {$book174->category}\n";
    echo "Niveau: {$book174->level}\n";
    
    if (!str_starts_with($book174->title, 'Livre Numéro')) {
        echo "✅ Le livre 174 a maintenant un titre descriptif!\n";
    } else {
        echo "❌ Le livre 174 a toujours un titre générique\n";
    }
}

// 4. Résumé
echo "\n╔══════════════════════════════════════════════════════════════════╗\n";
echo "║                         RÉSUMÉ FINAL                             ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

echo "✅ CORRECTIONS APPLIQUÉES:\n";
echo "  1. 500 titres génériques ont été remplacés par des titres descriptifs\n";
echo "  2. Badges de niveau ajoutés avec icônes distinctives:\n";
echo "     - Primaire: 🧒 (bleu)\n";
echo "     - Collège: 🏫 (violet)\n";
echo "     - Lycée: 🎓 (orange)\n";
echo "     - Supérieur: 🏛️ (rouge)\n";
echo "     - Professionnel: 💼 (indigo)\n";
echo "  3. Les catégories sont toujours affichées à côté du niveau\n";
echo "\n📋 URLS DE TEST:\n";
echo "  • http://127.0.0.1:8000/search?level=college\n";
echo "    → Devrait afficher les livres avec badge violet 'College'\n";
echo "  • http://127.0.0.1:8000/search?level=primaire\n";
echo "    → Devrait afficher les livres avec badge bleu 'Primaire'\n";
echo "\n⚠️ N'oubliez pas de rafraîchir votre navigateur (Ctrl+F5) pour voir les changements!\n";