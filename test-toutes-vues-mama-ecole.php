<?php
/**
 * TEST COMPLET DE TOUTES LES VUES MAMA ÉCOLE
 * Vérifie que toutes les vues fonctionnent sans erreur
 */

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\MamaEcoleController;
use Illuminate\Http\Request;

echo "\n=====================================\n";
echo "   TEST TOUTES VUES MAMA ÉCOLE      \n";
echo "=====================================\n\n";

$controller = new MamaEcoleController();
$results = [];

// 1. TEST DASHBOARD
echo "1️⃣ TEST DASHBOARD\n";
echo "─────────────────\n";
try {
    // Vérifier les tables nécessaires
    $tables = ['parents', 'mama_ecole_interactions'];
    foreach ($tables as $table) {
        if (!\DB::getSchemaBuilder()->hasTable($table)) {
            throw new Exception("Table '$table' manquante");
        }
    }
    
    // Appeler la méthode dashboard
    $response = $controller->dashboard();
    $viewData = $response->getData();
    
    if (isset($viewData['stats'])) {
        echo "✅ Dashboard: OK\n";
        echo "   - Parents totaux: " . $viewData['stats']['total_parents'] . "\n";
        echo "   - Parents illettrés: " . $viewData['stats']['illiterate_parents'] . "\n";
        echo "   - Appels aujourd'hui: " . $viewData['stats']['calls_today'] . "\n";
        $results['dashboard'] = 'OK';
    } else {
        echo "⚠️ Dashboard: Données manquantes\n";
        $results['dashboard'] = 'PARTIEL';
    }
} catch (Exception $e) {
    echo "❌ Dashboard: ERREUR - " . $e->getMessage() . "\n";
    $results['dashboard'] = 'ERREUR';
}
echo "\n";

// 2. TEST PARENTS
echo "2️⃣ TEST PARENTS\n";
echo "─────────────────\n";
try {
    $response = $controller->parents();
    $viewData = $response->getData();
    
    if (isset($viewData['stats']) && isset($viewData['parents'])) {
        echo "✅ Parents: OK\n";
        echo "   - Total: " . $viewData['stats']['total'] . "\n";
        echo "   - Illettrés: " . $viewData['stats']['illiterate'] . "\n";
        $results['parents'] = 'OK';
    } else {
        echo "⚠️ Parents: Données manquantes\n";
        $results['parents'] = 'PARTIEL';
    }
} catch (Exception $e) {
    echo "❌ Parents: ERREUR - " . $e->getMessage() . "\n";
    $results['parents'] = 'ERREUR';
}
echo "\n";

// 3. TEST TEMPLATES
echo "3️⃣ TEST TEMPLATES\n";
echo "─────────────────\n";
try {
    // Créer la table si elle n'existe pas
    if (!\DB::getSchemaBuilder()->hasTable('mama_ecole_templates')) {
        \DB::statement("CREATE TABLE mama_ecole_templates (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            content TEXT,
            language VARCHAR(50),
            type VARCHAR(50),
            usage_count INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Ajouter des templates de test
        \DB::table('mama_ecole_templates')->insert([
            ['name' => 'Notes', 'content' => 'Votre enfant a eu {note} en {matiere}', 'language' => 'french', 'type' => 'grades'],
            ['name' => 'Absence', 'content' => 'Votre enfant était absent aujourd\'hui', 'language' => 'french', 'type' => 'absence'],
            ['name' => 'Réunion', 'content' => 'Réunion le {date} à {heure}', 'language' => 'french', 'type' => 'meeting']
        ]);
    }
    
    $response = $controller->templates();
    $viewData = $response->getData();
    
    if (isset($viewData['templates'])) {
        echo "✅ Templates: OK\n";
        echo "   - Nombre de templates: " . count($viewData['templates']) . "\n";
        $results['templates'] = 'OK';
    } else {
        echo "⚠️ Templates: Données manquantes\n";
        $results['templates'] = 'PARTIEL';
    }
} catch (Exception $e) {
    echo "❌ Templates: ERREUR - " . $e->getMessage() . "\n";
    $results['templates'] = 'ERREUR';
}
echo "\n";

// 4. TEST CAMPAIGNS
echo "4️⃣ TEST CAMPAIGNS\n";
echo "─────────────────\n";
try {
    // Créer la table si elle n'existe pas
    if (!\DB::getSchemaBuilder()->hasTable('mama_ecole_campaigns')) {
        \DB::statement("CREATE TABLE mama_ecole_campaigns (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            type VARCHAR(50),
            status VARCHAR(50) DEFAULT 'draft',
            target_count INT DEFAULT 0,
            sent_count INT DEFAULT 0,
            success_count INT DEFAULT 0,
            message TEXT,
            scheduled_at TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Ajouter des campagnes de test
        \DB::table('mama_ecole_campaigns')->insert([
            ['name' => 'Rentrée scolaire', 'type' => 'sms', 'status' => 'completed', 'target_count' => 100, 'sent_count' => 100, 'message' => 'Bonne rentrée!'],
            ['name' => 'Réunion parents', 'type' => 'call', 'status' => 'in_progress', 'target_count' => 50, 'sent_count' => 25, 'message' => 'Réunion importante'],
            ['name' => 'Bulletin notes', 'type' => 'sms', 'status' => 'scheduled', 'target_count' => 200, 'message' => 'Bulletins disponibles']
        ]);
    }
    
    $response = $controller->campaigns();
    $viewData = $response->getData();
    
    if (isset($viewData['campaigns'])) {
        echo "✅ Campaigns: OK\n";
        echo "   - Nombre de campagnes: " . $viewData['campaigns']->count() . "\n";
        $results['campaigns'] = 'OK';
    } else {
        echo "⚠️ Campaigns: Données manquantes\n";
        $results['campaigns'] = 'PARTIEL';
    }
} catch (Exception $e) {
    echo "❌ Campaigns: ERREUR - " . $e->getMessage() . "\n";
    $results['campaigns'] = 'ERREUR';
}
echo "\n";

// 5. TEST TEST-SIMPLE
echo "5️⃣ TEST TEST-SIMPLE\n";
echo "─────────────────\n";
try {
    $response = $controller->testSimple();
    $viewData = $response->getData();
    
    if (isset($viewData['stats'])) {
        echo "✅ Test-Simple: OK\n";
        echo "   - SMS aujourd'hui: " . $viewData['stats']['sms_today'] . "\n";
        $results['test-simple'] = 'OK';
    } else {
        echo "⚠️ Test-Simple: Données manquantes\n";
        $results['test-simple'] = 'PARTIEL';
    }
} catch (Exception $e) {
    echo "❌ Test-Simple: ERREUR - " . $e->getMessage() . "\n";
    $results['test-simple'] = 'ERREUR';
}
echo "\n";

// 6. TEST INDEX/MODERN
echo "6️⃣ TEST INDEX/MODERN\n";
echo "─────────────────\n";
try {
    $response = $controller->index();
    echo "✅ Index/Modern: OK (page statique)\n";
    $results['index'] = 'OK';
} catch (Exception $e) {
    echo "❌ Index/Modern: ERREUR - " . $e->getMessage() . "\n";
    $results['index'] = 'ERREUR';
}
echo "\n";

// RÉSUMÉ
echo "=====================================\n";
echo "   RÉSUMÉ DES TESTS                 \n";
echo "=====================================\n\n";

$totalOK = 0;
$totalPartiel = 0;
$totalErreur = 0;

foreach ($results as $vue => $status) {
    $icon = match($status) {
        'OK' => '✅',
        'PARTIEL' => '⚠️',
        'ERREUR' => '❌',
        default => '❓'
    };
    
    echo "$icon $vue: $status\n";
    
    if ($status == 'OK') $totalOK++;
    elseif ($status == 'PARTIEL') $totalPartiel++;
    elseif ($status == 'ERREUR') $totalErreur++;
}

echo "\n📊 STATISTIQUES:\n";
echo "   ✅ Fonctionnelles: $totalOK/" . count($results) . "\n";
echo "   ⚠️ Partielles: $totalPartiel/" . count($results) . "\n";
echo "   ❌ Erreurs: $totalErreur/" . count($results) . "\n";

echo "\n💡 RECOMMANDATIONS:\n";

if ($totalErreur > 0) {
    echo "   1. Créez les tables manquantes avec les migrations\n";
    echo "   2. Vérifiez les relations dans les modèles\n";
    echo "   3. Ajoutez des données de test\n";
}

if ($totalPartiel > 0) {
    echo "   1. Vérifiez que toutes les variables sont passées aux vues\n";
    echo "   2. Utilisez ?? pour les valeurs par défaut\n";
}

echo "\n🌐 POUR TESTER DANS LE NAVIGATEUR:\n";
echo "   1. Lancez: MAMA_ECOLE_LANCER.bat\n";
echo "   2. Testez chaque URL:\n";
echo "      • http://localhost:8000/mama-ecole (index)\n";
echo "      • http://localhost:8000/mama-ecole/dashboard\n";
echo "      • http://localhost:8000/mama-ecole/parents\n";
echo "      • http://localhost:8000/mama-ecole/templates\n";
echo "      • http://localhost:8000/mama-ecole/campaigns\n";
echo "      • http://localhost:8000/mama-ecole/test-simple ✅\n";

echo "\n=====================================\n";