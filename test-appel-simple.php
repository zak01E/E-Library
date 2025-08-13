<?php
/**
 * TEST APPEL VOCAL SIMPLE - MAMA ÉCOLE
 */

require_once 'vendor/autoload.php';

echo "\n===== TEST APPEL MAMA ÉCOLE =====\n\n";

// Configuration
$sid = 'YOUR_TWILIO_SID';
$token = 'YOUR_TWILIO_TOKEN';
$from = 'YOUR_TWILIO_PHONE';

// Demander le numéro ou utiliser celui par défaut
echo "Numéro à appeler [DESTINATION_PHONE]: ";
$handle = fopen("php://stdin", "r");
$input = trim(fgets($handle));
$to = $input ?: 'DESTINATION_PHONE';

// Message à dire
$message = "Bonjour, ceci est un test de Mama École. Votre enfant a obtenu 15 sur 20 en mathématiques. Félicitations!";

echo "\nConfiguration:\n";
echo "  De: $from\n";
echo "  Vers: $to\n";
echo "  Message: $message\n\n";

echo "⚠️  ATTENTION: L'appel vocal nécessite une URL publique pour TwiML.\n";
echo "   Avec un compte Trial, l'appel peut être limité.\n\n";

try {
    // Créer le client Twilio
    $client = new \Twilio\Rest\Client($sid, $token);
    
    echo "Lancement de l'appel...\n";
    
    // Option 1: Utiliser TwiML direct (nécessite une URL publique)
    // Pour test, on utilise l'URL de démo Twilio
    $twimlUrl = 'http://demo.twilio.com/docs/voice.xml';
    
    // Option 2: Créer un TwiML personnalisé avec TwiML Bins
    // (nécessite configuration dans Twilio Console)
    
    // Lancer l'appel avec l'URL de démo
    $call = $client->calls->create(
        $to,
        $from,
        [
            'url' => $twimlUrl,
            'method' => 'GET',
            'statusCallback' => 'https://webhook.site/unique-id', // Pour debug
            'statusCallbackMethod' => 'POST'
        ]
    );
    
    echo "\n✅ APPEL LANCÉ!\n";
    echo "  SID: " . $call->sid . "\n";
    echo "  Status: " . $call->status . "\n";
    echo "  Direction: " . $call->direction . "\n";
    
    // Attendre 5 secondes et vérifier le status
    echo "\n⏳ Vérification après 5 secondes...\n";
    sleep(5);
    
    $updatedCall = $client->calls($call->sid)->fetch();
    echo "  Status mis à jour: " . $updatedCall->status . "\n";
    
    if ($updatedCall->status == 'in-progress' || $updatedCall->status == 'ringing') {
        echo "\n📞 L'APPEL EST EN COURS!\n";
        echo "  Votre téléphone devrait sonner maintenant.\n";
    } elseif ($updatedCall->status == 'completed') {
        echo "\n✅ APPEL TERMINÉ!\n";
        echo "  Durée: " . $updatedCall->duration . " secondes\n";
    } elseif ($updatedCall->status == 'failed' || $updatedCall->status == 'no-answer') {
        echo "\n❌ APPEL ÉCHOUÉ!\n";
        echo "  Raison possible:\n";
        echo "  - Numéro non vérifié (compte Trial)\n";
        echo "  - Numéro incorrect\n";
        echo "  - Téléphone éteint\n";
    }
    
    echo "\n📊 DÉTAILS DE L'APPEL:\n";
    echo "  Prix: " . $updatedCall->price . " " . $updatedCall->priceUnit . "\n";
    echo "  De: " . $updatedCall->from . "\n";
    echo "  Vers: " . $updatedCall->to . "\n";
    
} catch (\Twilio\Exceptions\RestException $e) {
    echo "\n❌ ERREUR TWILIO:\n";
    echo "  Code: " . $e->getCode() . "\n";
    echo "  Message: " . $e->getMessage() . "\n";
    
    if ($e->getCode() == 21608) {
        echo "\n⚠️ Ce numéro n'est pas vérifié dans votre compte Trial!\n";
        echo "  Solution:\n";
        echo "  1. Allez sur: https://console.twilio.com/us1/develop/phone-numbers/manage/verified\n";
        echo "  2. Ajoutez et vérifiez: $to\n";
    } elseif ($e->getCode() == 21214) {
        echo "\n⚠️ Le numéro '$to' est invalide!\n";
        echo "  Utilisez le format international: +33612345678\n";
    }
} catch (Exception $e) {
    echo "\n❌ ERREUR: " . $e->getMessage() . "\n";
}

echo "\n💡 NOTES IMPORTANTES:\n";
echo "  1. Avec un compte Trial, seuls les numéros vérifiés peuvent être appelés\n";
echo "  2. L'appel utilise un message de démo en anglais\n";
echo "  3. Pour un message personnalisé en français, il faut:\n";
echo "     - Créer un TwiML Bin dans Twilio Console\n";
echo "     - Ou avoir un serveur web public pour héberger le TwiML\n";

echo "\n===== FIN DU TEST =====\n\n";