<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

// Créer une instance du contrôleur
$controller = new HomeController();

// Créer une requête factice
$request = new Request();

// Appeler la méthode index
$response = $controller->index($request);

// Récupérer les données passées à la vue
$viewData = $response->getData();

echo "=== STATISTIQUES DYNAMIQUES SUR LA PAGE D'ACCUEIL ===\n\n";

if (isset($viewData['levelStats'])) {
    echo "✅ Les statistiques par niveau sont disponibles dans la vue !\n\n";
    echo "📊 Valeurs actuelles :\n";
    echo "----------------------------------------\n";
    
    foreach ($viewData['levelStats'] as $level => $count) {
        $levelFormatted = ucfirst($level);
        $countFormatted = number_format($count);
        echo "• $levelFormatted : $countFormatted livres\n";
    }
    
    echo "\n✅ SUCCÈS : Les données dynamiques sont bien passées à la vue home.blade.php\n";
    echo "Ces valeurs seront affichées automatiquement sur la page d'accueil.\n";
} else {
    echo "❌ ERREUR : Les statistiques par niveau ne sont pas disponibles dans la vue.\n";
    echo "Données disponibles : " . implode(', ', array_keys((array)$viewData)) . "\n";
}

echo "\n=== INFORMATIONS SUPPLÉMENTAIRES ===\n";
if (isset($viewData['stats'])) {
    echo "📚 Total des livres approuvés : " . number_format($viewData['stats']['total_books']) . "\n";
    echo "👥 Total des utilisateurs : " . number_format($viewData['stats']['total_users']) . "\n";
    echo "✍️ Total des auteurs : " . number_format($viewData['stats']['total_authors']) . "\n";
}