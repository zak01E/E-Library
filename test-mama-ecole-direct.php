<?php
/**
 * TEST DIRECT MAMA ÉCOLE
 * Test sans serveur web
 */

echo "\n";
echo "=====================================\n";
echo "   TEST DIRECT MAMA ÉCOLE           \n";
echo "=====================================\n\n";

// Charger Laravel
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\MamaEcoleController;
use Illuminate\Http\Request;

echo "📱 TEST ENVOI SMS DIRECT\n";
echo "─────────────────────────\n\n";

// Créer une instance du contrôleur
$controller = new MamaEcoleController();

// Test 1: Vérifier que le contrôleur existe
echo "✅ Contrôleur MamaEcole chargé\n\n";

// Test 2: Envoyer un SMS de test
echo "📤 Envoi d'un SMS de test...\n";

$phoneNumber = '+33752353581'; // Votre numéro vérifié
$message = 'TEST MAMA ÉCOLE DIRECT - ' . date('H:i:s');

try {
    // Utiliser Twilio directement
    $sid = env('TWILIO_SID');
    $token = env('TWILIO_TOKEN');
    $from = env('TWILIO_NUMBER');
    
    if (!$sid || !$token) {
        throw new Exception("Configuration Twilio manquante");
    }
    
    $client = new \Twilio\Rest\Client($sid, $token);
    
    echo "   Configuration:\n";
    echo "   • SID: " . substr($sid, 0, 20) . "...\n";
    echo "   • De: $from\n";
    echo "   • Vers: $phoneNumber\n";
    echo "   • Message: $message\n\n";
    
    // Envoyer le SMS
    $message = $client->messages->create(
        $phoneNumber,
        [
            'from' => $from,
            'body' => $message
        ]
    );
    
    echo "✅ SMS ENVOYÉ AVEC SUCCÈS!\n";
    echo "   • SID du message: " . $message->sid . "\n";
    echo "   • Status: " . $message->status . "\n";
    echo "   • Prix: " . $message->price . " " . $message->priceUnit . "\n";
    
    // Attendre 3 secondes et vérifier le statut
    echo "\n⏳ Vérification du statut...\n";
    sleep(3);
    
    $updatedMessage = $client->messages($message->sid)->fetch();
    echo "   • Status final: " . $updatedMessage->status . "\n";
    
    if ($updatedMessage->status == 'delivered') {
        echo "   ✅ SMS DÉLIVRÉ!\n";
    } elseif ($updatedMessage->status == 'sent') {
        echo "   ✅ SMS EN COURS DE LIVRAISON\n";
    } else {
        echo "   ⚠️ Status: " . $updatedMessage->status . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
}

echo "\n";
echo "=====================================\n";
echo "   TEST INTERFACE WEB               \n";
echo "=====================================\n\n";

// Tester les vues principales
$views = [
    'mama-ecole.index' => 'Page d\'accueil',
    'mama-ecole.dashboard' => 'Dashboard',
    'mama-ecole.parents' => 'Gestion parents',
    'mama-ecole.test-twilio' => 'Test Twilio'
];

echo "👁️ VÉRIFICATION DES VUES\n";
echo "─────────────────────\n";

foreach ($views as $view => $description) {
    try {
        if (view()->exists($view)) {
            echo "  ✅ $description ($view)\n";
        } else {
            echo "  ❌ $description - Vue non trouvée\n";
        }
    } catch (Exception $e) {
        echo "  ❌ $description - Erreur: " . $e->getMessage() . "\n";
    }
}

echo "\n";
echo "=====================================\n";
echo "   DONNÉES DE TEST                  \n";
echo "=====================================\n\n";

// Statistiques
echo "📊 STATISTIQUES MAMA ÉCOLE\n";
echo "─────────────────────\n";

$stats = [
    'Parents inscrits' => \DB::table('parents')->count(),
    'Parents illettrés' => \DB::table('parents')->where('can_read', false)->count(),
    'Étudiants' => \DB::table('students')->count(),
    'Interactions' => \DB::table('mama_ecole_interactions')->count(),
    'SMS envoyés' => \DB::table('mama_ecole_sms_logs')->count(),
];

foreach ($stats as $label => $count) {
    echo "  • $label: $count\n";
}

echo "\n";
echo "=====================================\n";
echo "   INSTRUCTIONS                     \n";
echo "=====================================\n\n";

echo "📌 POUR ACCÉDER À MAMA ÉCOLE:\n\n";

echo "1. DÉMARRER LE SERVEUR:\n";
echo "   Option A: Double-cliquez sur 'start-server.bat'\n";
echo "   Option B: Ouvrez un terminal et tapez:\n";
echo "   php artisan serve\n\n";

echo "2. OUVRIR VOTRE NAVIGATEUR:\n";
echo "   http://localhost:8000/mama-ecole\n\n";

echo "3. PAGES DISPONIBLES:\n";
echo "   • http://localhost:8000/mama-ecole - Accueil\n";
echo "   • http://localhost:8000/mama-ecole/dashboard - Tableau de bord\n";
echo "   • http://localhost:8000/mama-ecole/test-twilio - Test SMS/Appels\n";
echo "   • http://localhost:8000/mama-ecole/parents - Gestion parents\n\n";

echo "4. POUR TESTER:\n";
echo "   • Allez sur /mama-ecole/test-twilio\n";
echo "   • Entrez votre numéro: +33752353581\n";
echo "   • Cliquez 'Envoyer SMS'\n";
echo "   • Vous recevrez le SMS!\n\n";

echo "=====================================\n";
echo "   FIN DU TEST                      \n";
echo "=====================================\n\n";