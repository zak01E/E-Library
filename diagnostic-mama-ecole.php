<?php
/**
 * DIAGNOSTIC COMPLET MAMA ÉCOLE
 * Analyse en profondeur du système
 */

echo "\n";
echo "=====================================\n";
echo "   DIAGNOSTIC COMPLET MAMA ÉCOLE    \n";
echo "=====================================\n\n";

// Charger l'autoloader Laravel
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// 1. VÉRIFICATION CONFIGURATION
echo "🔧 1. CONFIGURATION\n";
echo "─────────────────\n";

$configs = [
    'MAMA_ECOLE_MODE' => env('MAMA_ECOLE_MODE'),
    'TWILIO_SID' => env('TWILIO_SID'),
    'TWILIO_TOKEN' => env('TWILIO_TOKEN') ? '***CONFIGURÉ***' : null,
    'TWILIO_NUMBER' => env('TWILIO_NUMBER'),
    'DB_CONNECTION' => env('DB_CONNECTION'),
    'DB_DATABASE' => env('DB_DATABASE'),
];

foreach ($configs as $key => $value) {
    $status = $value ? '✅' : '❌';
    echo "  $status $key: " . ($value ?: 'NON CONFIGURÉ') . "\n";
}

// 2. VÉRIFICATION BASE DE DONNÉES
echo "\n📊 2. BASE DE DONNÉES\n";
echo "─────────────────\n";

try {
    DB::connection()->getPdo();
    echo "  ✅ Connexion à la base de données établie\n";
    
    // Vérifier les tables Mama École
    $tables = [
        'parents' => 'Parents illettrés',
        'students' => 'Élèves',
        'school_classes' => 'Classes',
        'mama_ecole_interactions' => 'Historique interactions',
        'mama_ecole_sms_logs' => 'Logs SMS',
    ];
    
    foreach ($tables as $table => $description) {
        if (DB::getSchemaBuilder()->hasTable($table)) {
            $count = DB::table($table)->count();
            echo "  ✅ Table '$table' existe ($count enregistrements)\n";
        } else {
            echo "  ❌ Table '$table' MANQUANTE - $description\n";
        }
    }
} catch (Exception $e) {
    echo "  ❌ Erreur de connexion: " . $e->getMessage() . "\n";
}

// 3. VÉRIFICATION DES ROUTES
echo "\n🛣️  3. ROUTES MAMA ÉCOLE\n";
echo "─────────────────\n";

$mamaRoutes = [];
foreach (Route::getRoutes() as $route) {
    if (strpos($route->uri(), 'mama-ecole') !== false) {
        $mamaRoutes[] = $route;
    }
}

if (count($mamaRoutes) > 0) {
    echo "  ✅ " . count($mamaRoutes) . " routes Mama École trouvées\n";
    foreach ($mamaRoutes as $route) {
        $methods = implode('|', $route->methods());
        echo "     • $methods " . $route->uri() . "\n";
    }
} else {
    echo "  ❌ AUCUNE route Mama École trouvée!\n";
}

// 4. VÉRIFICATION CONTRÔLEUR
echo "\n🎮 4. CONTRÔLEUR\n";
echo "─────────────────\n";

$controllerPath = app_path('Http/Controllers/MamaEcoleController.php');
if (file_exists($controllerPath)) {
    echo "  ✅ MamaEcoleController.php existe\n";
    
    // Vérifier les méthodes
    if (class_exists('\App\Http\Controllers\MamaEcoleController')) {
        $controller = new ReflectionClass('\App\Http\Controllers\MamaEcoleController');
        $methods = $controller->getMethods(ReflectionMethod::IS_PUBLIC);
        echo "  ✅ " . count($methods) . " méthodes publiques disponibles\n";
        
        $importantMethods = ['index', 'dashboard', 'testSMS', 'testCall', 'parents'];
        foreach ($importantMethods as $method) {
            if ($controller->hasMethod($method)) {
                echo "     ✅ Méthode $method() disponible\n";
            } else {
                echo "     ❌ Méthode $method() MANQUANTE\n";
            }
        }
    }
} else {
    echo "  ❌ MamaEcoleController.php INTROUVABLE!\n";
}

// 5. VÉRIFICATION SERVICES
echo "\n⚙️  5. SERVICES\n";
echo "─────────────────\n";

$services = [
    'Services/MamaEcole/VoiceService.php' => 'Service Voix',
    'Services/MamaEcole/OrangeCIService.php' => 'Service Orange CI',
];

foreach ($services as $path => $name) {
    $fullPath = app_path($path);
    if (file_exists($fullPath)) {
        echo "  ✅ $name existe\n";
    } else {
        echo "  ❌ $name MANQUANT\n";
    }
}

// 6. VÉRIFICATION VUES
echo "\n👁️  6. VUES\n";
echo "─────────────────\n";

$viewsPath = resource_path('views/mama-ecole');
if (is_dir($viewsPath)) {
    $views = glob($viewsPath . '/*.blade.php');
    $adminViews = glob($viewsPath . '/admin/*.blade.php');
    $totalViews = count($views) + count($adminViews);
    
    echo "  ✅ $totalViews vues Mama École trouvées\n";
    
    $importantViews = ['dashboard', 'parents', 'test-twilio', 'templates', 'campaigns'];
    foreach ($importantViews as $view) {
        if (file_exists($viewsPath . "/$view.blade.php")) {
            echo "     ✅ $view.blade.php existe\n";
        } else {
            echo "     ❌ $view.blade.php MANQUANT\n";
        }
    }
} else {
    echo "  ❌ Dossier views/mama-ecole INTROUVABLE!\n";
}

// 7. TEST TWILIO
echo "\n📱 7. TEST TWILIO\n";
echo "─────────────────\n";

if (class_exists('\Twilio\Rest\Client')) {
    echo "  ✅ SDK Twilio installé\n";
    
    $sid = env('TWILIO_SID');
    $token = env('TWILIO_TOKEN');
    
    if ($sid && $token) {
        try {
            $client = new \Twilio\Rest\Client($sid, $token);
            $account = $client->api->v2010->accounts($sid)->fetch();
            
            echo "  ✅ Connexion Twilio réussie\n";
            echo "     • Nom: " . $account->friendlyName . "\n";
            echo "     • Type: " . $account->type . "\n";
            echo "     • Status: " . $account->status . "\n";
            
            if ($account->type == 'Trial') {
                echo "  ⚠️  Compte TRIAL - Limitations actives\n";
            }
            
        } catch (Exception $e) {
            echo "  ❌ Erreur Twilio: " . $e->getMessage() . "\n";
        }
    } else {
        echo "  ❌ Credentials Twilio non configurés\n";
    }
} else {
    echo "  ❌ SDK Twilio NON INSTALLÉ!\n";
}

// 8. DIAGNOSTIC DES PROBLÈMES
echo "\n🔍 8. DIAGNOSTIC DES PROBLÈMES\n";
echo "─────────────────\n";

$problems = [];

// Vérifier si le serveur est accessible
$serverUrl = 'http://localhost:8000';
$ch = curl_init($serverUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_NOBODY, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200 || $httpCode == 302) {
    echo "  ✅ Serveur Laravel accessible sur $serverUrl\n";
} else {
    echo "  ❌ Serveur Laravel NON ACCESSIBLE sur $serverUrl\n";
    $problems[] = "Serveur non démarré";
}

// Vérifier les migrations
try {
    $pendingMigrations = \Artisan::call('migrate:status', [], new \Symfony\Component\Console\Output\BufferedOutput());
    if (strpos($pendingMigrations, 'Pending') !== false) {
        echo "  ⚠️  Migrations en attente\n";
        $problems[] = "Migrations non exécutées";
    } else {
        echo "  ✅ Toutes les migrations exécutées\n";
    }
} catch (Exception $e) {
    echo "  ❌ Impossible de vérifier les migrations\n";
}

// 9. RÉSUMÉ ET SOLUTIONS
echo "\n📋 9. RÉSUMÉ\n";
echo "─────────────────\n";

if (empty($problems)) {
    echo "  ✅ SYSTÈME MAMA ÉCOLE OPÉRATIONNEL\n";
    echo "\n";
    echo "  👉 Pour utiliser Mama École:\n";
    echo "     1. Démarrez le serveur: php artisan serve\n";
    echo "     2. Accédez à: http://localhost:8000/mama-ecole\n";
    echo "     3. Testez: http://localhost:8000/mama-ecole/test-twilio\n";
} else {
    echo "  ❌ PROBLÈMES DÉTECTÉS:\n";
    foreach ($problems as $problem) {
        echo "     • $problem\n";
    }
    
    echo "\n  🔧 SOLUTIONS:\n";
    
    if (in_array("Serveur non démarré", $problems)) {
        echo "     1. Démarrez le serveur:\n";
        echo "        php artisan serve\n";
    }
    
    if (in_array("Migrations non exécutées", $problems)) {
        echo "     2. Exécutez les migrations:\n";
        echo "        php artisan migrate\n";
    }
}

// 10. TEST RAPIDE
echo "\n⚡ 10. TEST RAPIDE\n";
echo "─────────────────\n";
echo "  Pour tester immédiatement:\n";
echo "  1. php artisan serve\n";
echo "  2. Ouvrir: http://localhost:8000/mama-ecole/test-twilio\n";
echo "  3. Entrer votre numéro: +33752353581\n";
echo "  4. Cliquer 'Envoyer SMS'\n";

echo "\n=====================================\n";
echo "     FIN DU DIAGNOSTIC\n";
echo "=====================================\n\n";