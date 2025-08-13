<?php
// Test direct Twilio - Exécuter avec: php test-twilio.php

require_once 'vendor/autoload.php';

use Twilio\Rest\Client;

// Vos credentials Twilio
$sid = 'YOUR_TWILIO_SID';
$token = 'YOUR_TWILIO_TOKEN';
$twilioNumber = 'YOUR_TWILIO_PHONE';

// Numéro de test (votre numéro vérifié)
$toNumber = 'DESTINATION_PHONE'; // Votre numéro français vérifié

try {
    echo "===== TEST TWILIO MAMA ÉCOLE =====\n\n";
    
    // Initialiser le client Twilio
    $client = new Client($sid, $token);
    echo "✅ Client Twilio initialisé\n";
    
    // Test 1: Envoyer un SMS
    echo "\n📱 TEST SMS...\n";
    $message = $client->messages->create(
        $toNumber,
        [
            'from' => $twilioNumber,
            'body' => 'MAMA ÉCOLE TEST: Bonjour! Le système fonctionne correctement. ' . date('H:i:s')
        ]
    );
    
    echo "✅ SMS envoyé avec succès!\n";
    echo "   Message SID: " . $message->sid . "\n";
    echo "   Status: " . $message->status . "\n";
    echo "   To: " . $message->to . "\n";
    
    // Test 2: Passer un appel
    echo "\n📞 TEST APPEL VOCAL...\n";
    echo "Voulez-vous tester l'appel vocal? (o/n): ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    
    if(trim($line) == 'o' || trim($line) == 'O'){
        // Créer un TwiML pour dire un message
        $twimlUrl = 'http://demo.twilio.com/docs/voice.xml'; // URL de démo Twilio
        
        $call = $client->calls->create(
            $toNumber,
            $twilioNumber,
            [
                'url' => $twimlUrl,
                'statusCallback' => 'http://postb.in/1234567890',
                'statusCallbackEvent' => ['initiated', 'ringing', 'answered', 'completed'],
                'statusCallbackMethod' => 'POST'
            ]
        );
        
        echo "✅ Appel lancé avec succès!\n";
        echo "   Call SID: " . $call->sid . "\n";
        echo "   Status: " . $call->status . "\n";
        echo "   To: " . $call->to . "\n";
    }
    
    echo "\n===== TEST TERMINÉ AVEC SUCCÈS =====\n";
    echo "\n📌 Configuration validée:\n";
    echo "   - Account SID: " . substr($sid, 0, 10) . "...\n";
    echo "   - Twilio Number: $twilioNumber\n";
    echo "   - Test Number: $toNumber\n";
    
} catch (Exception $e) {
    echo "\n❌ ERREUR: " . $e->getMessage() . "\n\n";
    echo "Détails:\n";
    echo "- Vérifiez que vos credentials sont corrects\n";
    echo "- Vérifiez que le numéro $toNumber est vérifié dans Twilio\n";
    echo "- Vérifiez votre connexion internet\n";
}