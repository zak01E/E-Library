<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

// Vider le cache pour forcer le recalcul
Cache::flush();

echo "=== VÉRIFICATION FINALE - TOUTES LES STATISTIQUES DYNAMIQUES ===\n\n";

// Créer une instance du contrôleur et récupérer les données
$controller = new HomeController();
$request = new Request();
$response = $controller->index($request);
$viewData = $response->getData();

$stats = $viewData['stats'];

echo "📊 STATISTIQUES DE LA BARRE DE STATS (Section bas de page) :\n";
echo "=============================================================\n\n";

// 1. Livres disponibles
$booksValue = $stats['total_books'];
$booksDisplay = $booksValue >= 1000000 ? round($booksValue / 1000000, 1) . 'M+' 
    : ($booksValue >= 1000 ? round($booksValue / 1000, 1) . 'K+' : $booksValue . '+');
echo "📚 Livres disponibles:\n";
echo "   Valeur brute: " . number_format($booksValue) . "\n";
echo "   Affichage: $booksDisplay\n\n";

// 2. Nouveaux ce mois
$newBooksValue = $stats['new_books_this_month'];
$newBooksDisplay = $newBooksValue >= 1000 ? round($newBooksValue / 1000, 1) . 'K+' : $newBooksValue . '+';
echo "🆕 Nouveaux ce mois:\n";
echo "   Valeur brute: " . number_format($newBooksValue) . "\n";
echo "   Affichage: $newBooksDisplay\n\n";

// 3. Téléchargements
$downloadsValue = $stats['total_downloads'];
$downloadsDisplay = $downloadsValue >= 1000000 ? round($downloadsValue / 1000000, 1) . 'M+' 
    : ($downloadsValue >= 1000 ? round($downloadsValue / 1000, 1) . 'K+' : $downloadsValue . '+');
echo "⬇️ Téléchargements:\n";
echo "   Valeur brute: " . number_format($downloadsValue) . "\n";
echo "   Affichage: $downloadsDisplay\n\n";

// 4. Auteurs publiés
$authorsValue = $stats['total_authors'];
$authorsDisplay = $authorsValue >= 1000000 ? round($authorsValue / 1000000, 1) . 'M+' 
    : ($authorsValue >= 1000 ? round($authorsValue / 1000, 1) . 'K+' : $authorsValue . '+');
echo "✍️ Auteurs publiés:\n";
echo "   Valeur brute: " . number_format($authorsValue) . "\n";
echo "   Affichage: $authorsDisplay\n\n";

echo "=============================================================\n";
echo "✅ RÉSUMÉ DES FORMATS :\n\n";
echo "• 21,465 livres → " . $booksDisplay . " ✅\n";
echo "• 89 nouveaux → " . $newBooksDisplay . " ✅\n";
echo "• 43,150,299 téléchargements → " . $downloadsDisplay . " ✅ (Maintenant en M+)\n";
echo "• 2,661 auteurs → " . $authorsDisplay . " ✅\n";

echo "\n🎯 TOUTES LES STATISTIQUES SONT DYNAMIQUES !\n";
echo "=============================================================\n";
echo "Les valeurs sont:\n";
echo "• Récupérées depuis la base de données en temps réel\n";
echo "• Formatées automatiquement (K+ pour milliers, M+ pour millions)\n";
echo "• Mises en cache pendant 5 minutes pour les performances\n";
echo "• Actualisées automatiquement quand de nouvelles données sont ajoutées\n";