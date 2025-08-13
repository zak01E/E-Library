<?php
/**
 * TEST SMS SIMPLE - SOLUTION DIRECTE
 */

require_once 'vendor/autoload.php';

echo "\n===== TEST SMS MAMA ÉCOLE =====\n\n";

// Configuration
$sid = 'YOUR_TWILIO_SID';
$token = 'YOUR_TWILIO_TOKEN';
$from = 'YOUR_TWILIO_PHONE';

// Demander le numéro ou utiliser celui par défaut
echo "Numéro destinataire [DESTINATION_PHONE]: ";
$handle = fopen("php://stdin", "r");
$input = trim(fgets($handle));
$to = $input ?: 'DESTINATION_PHONE';

// Message
$message = 'MAMA ÉCOLE TEST: ' . date('H:i:s') . ' - Votre enfant a obtenu 15/20 en Maths!';

echo "\nConfiguration:\n";
echo "  De: $from\n";
echo "  Vers: $to\n";
echo "  Message: $message\n\n";

try {
    // Créer le client Twilio
    $client = new \Twilio\Rest\Client($sid, $token);
    
    echo "Envoi du SMS...\n";
    
    // Envoyer le SMS
    $result = $client->messages->create(
        $to,
        [
            'from' => $from,
            'body' => $message
        ]
    );
    
    echo "\n✅ SMS ENVOYÉ AVEC SUCCÈS!\n";
    echo "  SID: " . $result->sid . "\n";
    echo "  Status: " . $result->status . "\n";
    
    // Attendre 3 secondes et vérifier
    echo "\nVérification après 3 secondes...\n";
    sleep(3);
    
    $updated = $client->messages($result->sid)->fetch();
    echo "  Status final: " . $updated->status . "\n";
    
    if ($updated->status == 'delivered') {
        echo "\n🎉 SMS DÉLIVRÉ! Vérifiez votre téléphone!\n";
    } elseif ($updated->status == 'sent') {
        echo "\n✅ SMS en cours de livraison...\n";
    } else {
        echo "\n⚠️ Status: " . $updated->status . "\n";
        if ($updated->errorCode) {
            echo "  Erreur: " . $updated->errorMessage . "\n";
        }
    }
    
} catch (\Twilio\Exceptions\RestException $e) {
    echo "\n❌ ERREUR TWILIO:\n";
    echo "  Code: " . $e->getCode() . "\n";
    echo "  Message: " . $e->getMessage() . "\n";
    
    if ($e->getCode() == 21608) {
        echo "\n⚠️ Ce numéro n'est pas vérifié dans votre compte Trial!\n";
        echo "  Allez sur: https://console.twilio.com/us1/develop/phone-numbers/manage/verified\n";
        echo "  Et ajoutez le numéro: $to\n";
    }
} catch (Exception $e) {
    echo "\n❌ ERREUR: " . $e->getMessage() . "\n";
}

echo "\n===== FIN DU TEST =====\n\n";