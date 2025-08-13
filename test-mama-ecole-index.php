<?php
/**
 * Test de la page d'accueil Mama École
 */

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n===== TEST PAGE D'ACCUEIL MAMA ÉCOLE =====\n\n";

use App\Http\Controllers\MamaEcoleController;

try {
    $controller = new MamaEcoleController();
    
    echo "1. Test méthode index()...\n";
    $response = $controller->index();
    
    echo "✅ Méthode index() exécutée sans erreur\n";
    echo "   Vue retournée: mama-ecole.modern\n\n";
    
    // Vérifier si la vue existe
    echo "2. Vérification de la vue...\n";
    if (view()->exists('mama-ecole.modern')) {
        echo "✅ Vue 'mama-ecole.modern' existe\n\n";
        
        // Essayer de rendre la vue
        echo "3. Test de rendu de la vue...\n";
        try {
            $rendered = view('mama-ecole.modern')->render();
            echo "✅ Vue rendue avec succès\n";
            echo "   Taille: " . strlen($rendered) . " caractères\n";
            
            // Vérifier si elle hérite d'un layout
            if (strpos($rendered, '@extends') !== false || strpos($rendered, '<html') !== false) {
                echo "✅ La vue semble complète\n";
            }
            
        } catch (Exception $e) {
            echo "❌ Erreur lors du rendu: " . $e->getMessage() . "\n";
            echo "   Ligne: " . $e->getLine() . "\n";
            echo "   Fichier: " . $e->getFile() . "\n";
        }
    } else {
        echo "❌ Vue 'mama-ecole.modern' introuvable\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
    echo "   Type: " . get_class($e) . "\n";
    
    // Si c'est une erreur de vue, afficher plus de détails
    if ($e instanceof \Illuminate\View\ViewException) {
        echo "   Vue problématique: " . $e->getFile() . "\n";
        echo "   Ligne: " . $e->getLine() . "\n";
    }
}

echo "\n4. Vérification des autres vues mama-ecole...\n";
$vues = ['index', 'modern', 'demo', 'info'];
foreach ($vues as $vue) {
    if (view()->exists("mama-ecole.$vue")) {
        echo "   ✅ mama-ecole.$vue existe\n";
    } else {
        echo "   ❌ mama-ecole.$vue manquante\n";
    }
}

echo "\n===== SOLUTION =====\n";
echo "Si la page ne fonctionne pas, essayez:\n";
echo "1. Utilisez la vue 'index' au lieu de 'modern'\n";
echo "2. Ou créez une vue simple sans dépendances\n";
echo "3. Vérifiez les logs: storage/logs/laravel.log\n\n";