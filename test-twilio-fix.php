<?php
require_once 'vendor/autoload.php';

use Twilio\Rest\Client;

echo "===== DIAGNOSTIC TWILIO - PROBLÈME SMS/APPELS =====\n\n";

$sid = 'YOUR_TWILIO_SID';
$token = 'YOUR_TWILIO_TOKEN';
$twilioNumber = 'YOUR_TWILIO_PHONE';
$toNumber = 'DESTINATION_PHONE';

try {
    $client = new Client($sid, $token);
    
    echo "🔍 DIAGNOSTIC:\n\n";
    
    // 1. Type de compte
    $account = $client->api->v2010->accounts($sid)->fetch();
    echo "1. COMPTE TWILIO:\n";
    echo "   Type: " . $account->type . " ⚠️\n";
    echo "   Status: " . $account->status . "\n";
    echo "   Nom: " . $account->friendlyName . "\n\n";
    
    if ($account->type == 'Trial') {
        echo "   ⚠️ ATTENTION: Compte TRIAL détecté!\n";
        echo "   - Les SMS/Appels ont un préfixe 'Sent from your Twilio trial account'\n";
        echo "   - VOUS NE POUVEZ CONTACTER QUE LES NUMÉROS VÉRIFIÉS\n\n";
    }
    
    // 2. Vérifier les numéros autorisés
    echo "2. NUMÉROS VÉRIFIÉS (Caller IDs):\n";
    $callerIds = $client->outgoingCallerIds->read();
    
    $isVerified = false;
    foreach ($callerIds as $callerId) {
        echo "   ✅ " . $callerId->phoneNumber . " (vérifié)";
        if ($callerId->phoneNumber == $toNumber || 
            $callerId->phoneNumber == str_replace(' ', '', $toNumber) ||
            $callerId->phoneNumber == '+33752353581') {
            echo " <-- VOTRE NUMÉRO";
            $isVerified = true;
        }
        echo "\n";
    }
    
    if (!$isVerified) {
        echo "\n   ❌ PROBLÈME TROUVÉ!\n";
        echo "   Le numéro $toNumber N'EST PAS dans la liste des numéros vérifiés!\n";
        echo "   C'est pourquoi vous ne recevez pas les SMS/Appels!\n\n";
        
        echo "   SOLUTION:\n";
        echo "   1. Allez sur: https://console.twilio.com/us1/develop/phone-numbers/manage/verified\n";
        echo "   2. Cliquez sur 'Add a new Caller ID'\n";
        echo "   3. Entrez: $toNumber\n";
        echo "   4. Twilio vous appellera pour vérifier le numéro\n";
        echo "   5. Entrez le code de vérification\n\n";
    } else {
        echo "   ✅ Le numéro est vérifié!\n\n";
    }
    
    // 3. Test SMS avec gestion d'erreur
    echo "3. TEST D'ENVOI SMS:\n";
    echo "   De: $twilioNumber\n";
    echo "   Vers: $toNumber\n\n";
    
    try {
        $message = $client->messages->create(
            $toNumber,
            [
                'from' => $twilioNumber,
                'body' => 'TEST: Mama École - ' . date('H:i:s')
            ]
        );
        
        echo "   ✅ SMS créé avec succès!\n";
        echo "   SID: " . $message->sid . "\n";
        echo "   Status initial: " . $message->status . "\n";
        
        // Attendre et vérifier
        echo "\n   ⏳ Vérification après 5 secondes...\n";
        sleep(5);
        
        $updatedMessage = $client->messages($message->sid)->fetch();
        echo "   Status final: " . $updatedMessage->status . "\n";
        
        if ($updatedMessage->status == 'delivered') {
            echo "   ✅ SMS DÉLIVRÉ! Vérifiez votre téléphone!\n";
        } elseif ($updatedMessage->status == 'sent') {
            echo "   ✅ SMS ENVOYÉ! Il devrait arriver bientôt.\n";
        } elseif ($updatedMessage->status == 'failed' || $updatedMessage->status == 'undelivered') {
            echo "   ❌ SMS NON DÉLIVRÉ!\n";
            if ($updatedMessage->errorCode) {
                echo "   Code erreur: " . $updatedMessage->errorCode . "\n";
                echo "   Message: " . $updatedMessage->errorMessage . "\n";
            }
        }
        
    } catch (\Twilio\Exceptions\RestException $e) {
        echo "   ❌ ERREUR lors de l'envoi!\n";
        echo "   Code: " . $e->getCode() . "\n";
        echo "   Message: " . $e->getMessage() . "\n\n";
        
        if ($e->getCode() == 21608) {
            echo "   📱 LE NUMÉRO $toNumber N'EST PAS VÉRIFIÉ!\n";
            echo "   C'est la raison pour laquelle vous ne recevez rien.\n\n";
            echo "   👉 SOLUTION IMMÉDIATE:\n";
            echo "   1. Ouvrez: https://console.twilio.com/us1/develop/phone-numbers/manage/verified\n";
            echo "   2. Ajoutez le numéro: $toNumber\n";
            echo "   3. Recevez l'appel de vérification\n";
            echo "   4. Entrez le code à 6 chiffres\n";
        }
    }
    
    // 4. Vérifier les messages récents
    echo "\n4. DERNIERS MESSAGES ENVOYÉS:\n";
    $messages = $client->messages->read(['limit' => 5]);
    
    foreach ($messages as $msg) {
        echo "   - " . $msg->dateSent->format('H:i:s') . " | ";
        echo "To: " . $msg->to . " | ";
        echo "Status: " . $msg->status;
        if ($msg->errorCode) {
            echo " | Error: " . $msg->errorCode;
        }
        echo "\n";
    }
    
    echo "\n===== RÉSUMÉ DU PROBLÈME =====\n";
    
    if (!$isVerified) {
        echo "❌ PROBLÈME PRINCIPAL: Le numéro $toNumber n'est pas vérifié!\n";
        echo "   Avec un compte Trial, vous DEVEZ vérifier chaque numéro destinataire.\n";
        echo "   Sans vérification, les SMS/Appels ne partiront pas.\n";
    } else {
        echo "✅ Le numéro est vérifié. Les SMS devraient fonctionner.\n";
        echo "   Si vous ne recevez toujours rien, vérifiez:\n";
        echo "   - Que le numéro est correct\n";
        echo "   - Que votre téléphone n'a pas de filtre anti-spam\n";
        echo "   - Les SMS Trial commencent par 'Sent from your Twilio trial account'\n";
    }
    
    echo "\n👉 Pour éviter ces limitations, passez à un compte payant Twilio.\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}