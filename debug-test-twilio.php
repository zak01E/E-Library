<?php
/**
 * Script de débogage pour comprendre pourquoi le test Twilio ne fonctionne pas
 */

echo "\n===== DÉBOGAGE TEST TWILIO =====\n\n";

// Charger Laravel
require_once __DIR__ . '/vendor/autoload.php';

// 1. Vérifier la configuration
echo "1. CONFIGURATION TWILIO:\n";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$sid = $_ENV['TWILIO_SID'] ?? null;
$token = $_ENV['TWILIO_TOKEN'] ?? null;
$number = $_ENV['TWILIO_NUMBER'] ?? null;

echo "   SID: " . ($sid ? substr($sid, 0, 20) . '...' : 'NON CONFIGURÉ') . "\n";
echo "   Token: " . ($token ? '***CONFIGURÉ***' : 'NON CONFIGURÉ') . "\n";
echo "   Numéro: " . ($number ?: 'NON CONFIGURÉ') . "\n\n";

// 2. Test direct d'envoi SMS
echo "2. TEST DIRECT SMS:\n";

$testNumber = '+33752353581'; // Votre numéro vérifié
$testMessage = 'DEBUG TEST: ' . date('H:i:s');

if ($sid && $token && $number) {
    try {
        $client = new \Twilio\Rest\Client($sid, $token);
        
        echo "   Envoi vers: $testNumber\n";
        echo "   Message: $testMessage\n";
        
        $message = $client->messages->create(
            $testNumber,
            [
                'from' => $number,
                'body' => $testMessage
            ]
        );
        
        echo "   ✅ SMS envoyé! SID: " . $message->sid . "\n";
        echo "   Status: " . $message->status . "\n";
        
        // Attendre et vérifier
        sleep(3);
        $updatedMessage = $client->messages($message->sid)->fetch();
        echo "   Status final: " . $updatedMessage->status . "\n";
        
        if ($updatedMessage->errorCode) {
            echo "   ❌ Erreur: " . $updatedMessage->errorMessage . "\n";
        }
        
    } catch (Exception $e) {
        echo "   ❌ Erreur: " . $e->getMessage() . "\n";
    }
} else {
    echo "   ❌ Configuration manquante\n";
}

echo "\n3. VÉRIFICATION DES ROUTES:\n";

// Simuler une requête POST vers testSMS
$postData = [
    'phone_number' => $testNumber,
    'message' => 'Test depuis interface'
];

echo "   Données à envoyer:\n";
echo "   - phone_number: " . $postData['phone_number'] . "\n";
echo "   - message: " . $postData['message'] . "\n";

echo "\n4. PROBLÈMES POTENTIELS:\n";

// Vérifier CSRF
$envFile = file_get_contents(__DIR__ . '/.env');
if (strpos($envFile, 'APP_KEY=') === false || strpos($envFile, 'APP_KEY=base64:') === false) {
    echo "   ⚠️ APP_KEY peut être invalide\n";
} else {
    echo "   ✅ APP_KEY configuré\n";
}

// Vérifier si le numéro est vérifié (Trial)
if ($sid && $token) {
    try {
        $client = new \Twilio\Rest\Client($sid, $token);
        $account = $client->api->v2010->accounts($sid)->fetch();
        
        if ($account->type == 'Trial') {
            echo "   ⚠️ Compte TRIAL - Seuls les numéros vérifiés fonctionnent\n";
            
            // Lister les numéros vérifiés
            $callerIds = $client->outgoingCallerIds->read();
            echo "   Numéros vérifiés:\n";
            foreach ($callerIds as $callerId) {
                echo "     - " . $callerId->phoneNumber . "\n";
            }
        } else {
            echo "   ✅ Compte non-Trial\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Impossible de vérifier le type de compte\n";
    }
}

echo "\n5. SOLUTION IMMÉDIATE:\n";
echo "   Au lieu d'utiliser l'interface web, utilisez ce script:\n";
echo "   php test-mama-ecole-direct.php\n";
echo "   Ou exécutez directement:\n";
echo "   php debug-test-twilio.php\n";

echo "\n===== FIN DU DÉBOGAGE =====\n";