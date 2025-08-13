<?php
/**
 * TEST DÉBOGAGE MESSAGE - MAMA ÉCOLE
 * Vérifie exactement ce qui est envoyé
 */

require_once 'vendor/autoload.php';

echo "\n===== TEST DÉBOGAGE MESSAGE =====\n\n";

$sid = 'YOUR_TWILIO_SID';
$token = 'YOUR_TWILIO_TOKEN';
$from = 'YOUR_TWILIO_PHONE';
$to = 'DESTINATION_PHONE';

// Message exact comme dans le controller
$messages = [
    'grades' => "Bonjour, c'est l'école. Votre enfant a obtenu 15 sur 20 en mathématiques. Félicitations!",
    'absence' => "Bonjour, c'est l'école. Votre enfant était absent aujourd'hui. Merci de nous contacter.",
    'meeting' => "Bonjour, c'est l'école. Une réunion importante aura lieu vendredi à 14 heures.",
    'urgent' => "Message urgent de l'école. Votre enfant est à l'infirmerie. Merci de venir."
];

$message = $messages['grades'];

echo "1. TEST SANS VOIX SPÉCIFIQUE\n";
echo "─────────────────────────────\n";

try {
    $client = new \Twilio\Rest\Client($sid, $token);
    
    // Test 1: Sans spécifier de voix
    $twiml1 = '<Response><Say language="fr-FR">' . 
              htmlspecialchars($message) . 
              '</Say></Response>';
    
    echo "TwiML envoyé:\n$twiml1\n\n";
    
    $call1 = $client->calls->create(
        $to,
        $from,
        ['twiml' => $twiml1]
    );
    
    echo "✅ Appel 1 lancé: " . $call1->sid . "\n";
    echo "Status: " . $call1->status . "\n\n";
    
    echo "Attendre 20 secondes...\n";
    sleep(20);
    
    echo "\n2. TEST AVEC VOICE='woman'\n";
    echo "─────────────────────────────\n";
    
    // Test 2: Avec voice="woman" (standard)
    $twiml2 = '<Response><Say language="fr-FR" voice="woman">' . 
              htmlspecialchars($message) . 
              '</Say></Response>';
    
    echo "TwiML envoyé:\n$twiml2\n\n";
    
    $call2 = $client->calls->create(
        $to,
        $from,
        ['twiml' => $twiml2]
    );
    
    echo "✅ Appel 2 lancé: " . $call2->sid . "\n";
    echo "Status: " . $call2->status . "\n\n";
    
    echo "Attendre 20 secondes...\n";
    sleep(20);
    
    echo "\n3. TEST AVEC POLLY (SI DISPONIBLE)\n";
    echo "─────────────────────────────────\n";
    
    // Test 3: Avec Polly (peut ne pas être disponible en trial)
    $twiml3 = '<Response><Say language="fr-FR" voice="Polly.Celine">' . 
              htmlspecialchars($message) . 
              '</Say></Response>';
    
    echo "TwiML envoyé:\n$twiml3\n\n";
    
    $call3 = $client->calls->create(
        $to,
        $from,
        ['twiml' => $twiml3]
    );
    
    echo "✅ Appel 3 lancé: " . $call3->sid . "\n";
    echo "Status: " . $call3->status . "\n\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

echo "\n===== ANALYSE =====\n";
echo "Message attendu:\n";
echo "\"$message\"\n\n";
echo "Si vous entendez un message robotique:\n";
echo "1. C'est peut-être le message 'Sent from Twilio trial' en début\n";
echo "2. La voix Polly peut ne pas être disponible en trial\n";
echo "3. La voix 'woman' devrait fonctionner\n";
echo "\n";
echo "SOLUTION: Utiliser voice='woman' au lieu de 'Polly.Celine'\n";
echo "====================\n\n";