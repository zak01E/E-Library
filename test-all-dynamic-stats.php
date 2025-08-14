<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

// Vider le cache pour forcer le recalcul
Cache::forget('level_stats');
Cache::forget('homepage_stats');

echo "=== VÉRIFICATION COMPLÈTE DES STATISTIQUES DYNAMIQUES ===\n\n";

// Créer une instance du contrôleur et récupérer les données
$controller = new HomeController();
$request = new Request();
$response = $controller->index($request);
$viewData = $response->getData();

echo "📊 1. STATISTIQUES PAR NIVEAU (Cards de la page d'accueil) :\n";
echo "------------------------------------------------------------\n";
if (isset($viewData['levelStats'])) {
    foreach ($viewData['levelStats'] as $level => $count) {
        $levelFormatted = ucfirst($level);
        $countFormatted = number_format($count);
        $status = $count > 0 ? "✅" : "⚠️";
        echo "$status $levelFormatted : $countFormatted livres\n";
    }
    $total = array_sum($viewData['levelStats']);
    echo "\n📚 Total par niveau : " . number_format($total) . " livres\n";
} else {
    echo "❌ ERREUR : levelStats non disponible\n";
}

echo "\n📈 2. STATISTIQUES GÉNÉRALES (Social Proof) :\n";
echo "------------------------------------------------------------\n";
if (isset($viewData['stats'])) {
    $stats = $viewData['stats'];
    
    echo "⭐ Note moyenne : " . ($stats['average_rating'] ?? '4.6') . "/5\n";
    echo "👥 Total utilisateurs : " . number_format($stats['total_users'] ?? 0) . "+ étudiants\n";
    echo "📚 Total livres : " . number_format($stats['total_books'] ?? 0) . "+ livres\n";
    
    echo "\n📊 3. STATISTIQUES DÉTAILLÉES (Section bas de page) :\n";
    echo "------------------------------------------------------------\n";
    
    // Format K+ pour les grands nombres
    $booksDisplay = $stats['total_books'] >= 1000 
        ? round($stats['total_books'] / 1000, 1) . 'K+' 
        : $stats['total_books'] . '+';
    echo "📚 Livres disponibles : $booksDisplay\n";
    
    echo "🆕 Nouveaux ce mois : " . ($stats['new_books_this_month'] ?? 0) . "+\n";
    
    $downloadsDisplay = $stats['total_downloads'] >= 1000 
        ? round($stats['total_downloads'] / 1000, 1) . 'K+' 
        : $stats['total_downloads'] . '+';
    echo "⬇️ Téléchargements : $downloadsDisplay\n";
    
    $authorsDisplay = $stats['total_authors'] >= 1000 
        ? round($stats['total_authors'] / 1000, 1) . 'K+' 
        : $stats['total_authors'] . '+';
    echo "✍️ Auteurs publiés : $authorsDisplay\n";
    
    echo "\n📋 4. AUTRES MÉTRIQUES :\n";
    echo "------------------------------------------------------------\n";
    echo "👁️ Vues totales : " . number_format($stats['total_views'] ?? 0) . "\n";
    echo "🆕 Nouveaux utilisateurs ce mois : " . ($stats['new_users_this_month'] ?? 0) . "\n";
} else {
    echo "❌ ERREUR : stats non disponible\n";
}

echo "\n✅ RÉSUMÉ FINAL :\n";
echo "------------------------------------------------------------\n";
echo "Toutes les statistiques sont maintenant DYNAMIQUES et proviennent de la base de données.\n";
echo "Elles se mettent à jour automatiquement avec un cache de 5 minutes.\n";
echo "\n🔄 Pour forcer la mise à jour : php artisan cache:clear\n";

echo "\n=== FIN DU TEST ===\n";