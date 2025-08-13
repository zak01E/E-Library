<?php
/**
 * TEST MESSAGE VOCAL PRÉCIS
 * Vérifie que le bon message est dit
 */

require_once 'vendor/autoload.php';

echo "\n===== TEST MESSAGE VOCAL PRÉCIS =====\n\n";

$sid = 'YOUR_TWILIO_SID';
$token = 'YOUR_TWILIO_TOKEN';
$from = 'YOUR_TWILIO_PHONE';
$to = 'DESTINATION_PHONE';

// Message à dire
$message = "Bonjour, c'est l'école. Votre enfant a obtenu 15 sur 20 en mathématiques. Félicitations!";

echo "Message à envoyer:\n";
echo "\"$message\"\n\n";

try {
    $client = new \Twilio\Rest\Client($sid, $token);
    
    // Méthode 1: TwiML inline (recommandé)
    echo "Test 1: TwiML inline\n";
    echo "------------------------\n";
    
    $call = $client->calls->create(
        $to,
        $from,
        [
            'twiml' => '<Response>' .
                      '<Say language="fr-FR" voice="Polly.Celine">' . 
                      htmlspecialchars($message) . 
                      '</Say>' .
                      '</Response>'
        ]
    );
    
    echo "✅ Appel lancé: " . $call->sid . "\n";
    echo "Status: " . $call->status . "\n";
    
    // Attendre un peu et vérifier
    sleep(5);
    $updatedCall = $client->calls($call->sid)->fetch();
    echo "Status après 5s: " . $updatedCall->status . "\n";
    
    if ($updatedCall->status == 'in-progress' || $updatedCall->status == 'completed') {
        echo "\n✅ SUCCÈS! Le message devrait être:\n";
        echo "   \"$message\"\n";
    }
    
    echo "\n⏸️  Attendre 15 secondes avant le test suivant...\n";
    sleep(15);
    
    // Méthode 2: TwiML avec Gather pour interaction
    echo "\nTest 2: TwiML avec options\n";
    echo "------------------------\n";
    
    $twiml = '<Response>' .
             '<Say language="fr-FR" voice="Polly.Celine">' . 
             htmlspecialchars($message) . 
             '</Say>' .
             '<Pause length="1"/>' .
             '<Say language="fr-FR" voice="Polly.Celine">' . 
             'Appuyez sur 1 pour répéter le message.' .
             '</Say>' .
             '</Response>';
    
    $call2 = $client->calls->create(
        $to,
        $from,
        ['twiml' => $twiml]
    );
    
    echo "✅ Appel 2 lancé: " . $call2->sid . "\n";
    echo "Status: " . $call2->status . "\n";
    
    sleep(5);
    $updatedCall2 = $client->calls($call2->sid)->fetch();
    echo "Status après 5s: " . $updatedCall2->status . "\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

echo "\n===== INFORMATIONS IMPORTANTES =====\n";
echo "1. Voix utilisée: Polly.Celine (française)\n";
echo "2. Langue: fr-FR\n";
echo "3. Message exact attendu:\n";
echo "   \"$message\"\n";
echo "\n";
echo "Si vous entendez un message robotique différent:\n";
echo "- Vérifiez que vous avez bien reçu l'appel\n";
echo "- Le message commence par 'Sent from Twilio trial' (normal en trial)\n";
echo "- Puis devrait dire le message en français\n";
echo "=====================================\n\n";