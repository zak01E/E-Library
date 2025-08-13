<?php
// Script de diagnostic Twilio
require_once 'vendor/autoload.php';

use Twilio\Rest\Client;

echo "===== DIAGNOSTIC TWILIO MAMA ÉCOLE =====\n\n";

// Configuration
$sid = 'YOUR_TWILIO_SID';
$token = 'YOUR_TWILIO_TOKEN';
$twilioNumber = 'YOUR_TWILIO_PHONE';
$toNumber = 'DESTINATION_PHONE';

try {
    $client = new Client($sid, $token);
    
    // 1. Vérifier le compte
    echo "1. VÉRIFICATION DU COMPTE:\n";
    $account = $client->api->v2010->accounts($sid)->fetch();
    echo "   ✅ Compte actif: " . $account->friendlyName . "\n";
    echo "   Status: " . $account->status . "\n";
    echo "   Type: " . $account->type . "\n\n";
    
    // 2. Vérifier le numéro Twilio
    echo "2. VÉRIFICATION DU NUMÉRO TWILIO:\n";
    $incomingPhoneNumbers = $client->incomingPhoneNumbers->read([], 20);
    foreach ($incomingPhoneNumbers as $number) {
        if ($number->phoneNumber == $twilioNumber) {
            echo "   ✅ Numéro trouvé: " . $number->phoneNumber . "\n";
            echo "   Capacités: ";
            if ($number->capabilities->voice) echo "VOICE ";
            if ($number->capabilities->sms) echo "SMS ";
            if ($number->capabilities->mms) echo "MMS ";
            echo "\n\n";
        }
    }
    
    // 3. Vérifier les numéros vérifiés (Trial)
    echo "3. NUMÉROS VÉRIFIÉS (Account Trial):\n";
    $verifiedNumbers = $client->validationRequests->read();
    $callerIds = $client->outgoingCallerIds->read();
    
    echo "   Numéros autorisés pour Trial:\n";
    foreach ($callerIds as $callerId) {
        echo "   - " . $callerId->phoneNumber;
        if ($callerId->phoneNumber == $toNumber) {
            echo " ✅ (Votre numéro)";
        }
        echo "\n";
    }
    echo "\n";
    
    // 4. Test SMS avec détails
    echo "4. TEST SMS DÉTAILLÉ:\n";
    echo "   De: $twilioNumber\n";
    echo "   Vers: $toNumber\n";
    
    $message = $client->messages->create(
        $toNumber,
        [
            'from' => $twilioNumber,
            'body' => 'TEST DEBUG: ' . date('H:i:s'),
            'statusCallback' => 'https://webhook.site/unique-id' // Pour debug
        ]
    );
    
    echo "   ✅ SMS créé!\n";
    echo "   SID: " . $message->sid . "\n";
    echo "   Status: " . $message->status . "\n";
    echo "   Direction: " . $message->direction . "\n";
    echo "   Prix: " . $message->price . " " . $message->priceUnit . "\n";
    
    // Attendre 3 secondes et vérifier le statut
    echo "\n   ⏳ Vérification du statut après 3 secondes...\n";
    sleep(3);
    
    $messageStatus = $client->messages($message->sid)->fetch();
    echo "   Status final: " . $messageStatus->status . "\n";
    if ($messageStatus->errorCode) {
        echo "   ❌ Code erreur: " . $messageStatus->errorCode . "\n";
        echo "   Message erreur: " . $messageStatus->errorMessage . "\n";
    }
    echo "\n";
    
    // 5. Vérifier les logs d'erreurs récents
    echo "5. DERNIÈRES ALERTES/ERREURS:\n";
    $alerts = $client->monitor->v1->alerts->read(['limit' => 5]);
    
    if (count($alerts) > 0) {
        foreach ($alerts as $alert) {
            echo "   ⚠️ " . $alert->alertText . "\n";
            echo "      Date: " . $alert->dateCreated->format('Y-m-d H:i:s') . "\n";
        }
    } else {
        echo "   ✅ Aucune alerte récente\n";
    }
    echo "\n";
    
    // 6. Informations importantes pour Trial
    echo "6. LIMITATIONS COMPTE TRIAL:\n";
    echo "   ⚠️ Les SMS/Appels commencent par: 'Sent from your Twilio trial account'\n";
    echo "   ⚠️ Vous pouvez uniquement contacter les numéros vérifiés\n";
    echo "   ⚠️ Le numéro $toNumber doit être vérifié dans Twilio Console\n";
    echo "\n";
    
    // 7. Test d'appel
    echo "7. TEST APPEL (optionnel - tapez 'o' pour lancer):\n";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    
    if(trim($line) == 'o'){
        $call = $client->calls->create(
            $toNumber,
            $twilioNumber,
            [
                'twiml' => '<Response><Say language="fr-FR">Ceci est un test de Mama École</Say></Response>'
            ]
        );
        
        echo "   ✅ Appel lancé!\n";
        echo "   SID: " . $call->sid . "\n";
        echo "   Status: " . $call->status . "\n";
        
        sleep(3);
        $callStatus = $client->calls($call->sid)->fetch();
        echo "   Status après 3s: " . $callStatus->status . "\n";
    }
    
    echo "\n===== DIAGNOSTIC TERMINÉ =====\n";
    
} catch (\Twilio\Exceptions\RestException $e) {
    echo "\n❌ ERREUR TWILIO:\n";
    echo "   Code: " . $e->getCode() . "\n";
    echo "   Message: " . $e->getMessage() . "\n";
    echo "   Plus d'infos: " . $e->getMoreInfo() . "\n";
    
    if ($e->getCode() == 21608) {
        echo "\n   ⚠️ Le numéro $toNumber n'est pas vérifié!\n";
        echo "   👉 Allez sur: https://console.twilio.com/us1/develop/phone-numbers/manage/verified\n";
        echo "   👉 Ajoutez et vérifiez le numéro $toNumber\n";
    }
} catch (Exception $e) {
    echo "\n❌ ERREUR: " . $e->getMessage() . "\n";
}