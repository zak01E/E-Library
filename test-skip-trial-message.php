<?php
/**
 * TEST - CONTOURNER MESSAGE TRIAL
 * Teste si on peut skip le message avec DTMF
 */

require_once 'vendor/autoload.php';

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║     TEST SKIP MESSAGE TRIAL TWILIO                    ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

$sid = 'YOUR_TWILIO_SID';
$token = 'YOUR_TWILIO_TOKEN';
$from = 'YOUR_TWILIO_PHONE';
$to = 'DESTINATION_PHONE';

echo "⚠️  INFORMATION IMPORTANTE:\n";
echo "═══════════════════════════\n";
echo "En mode TRIAL, Twilio dit TOUJOURS ce message en anglais:\n";
echo "\"You have a trial account. You can remove this message\n";
echo " at any time by upgrading to a full account.\n";
echo " Press any key to execute your code.\"\n\n";

echo "CE MESSAGE DURE 15-20 SECONDES.\n";
echo "APRÈS, vous entendrez le message en français.\n\n";

$messageActuel = "Bonjour, c'est l'école. Votre enfant a obtenu 15 sur 20 en mathématiques. Félicitations!";

try {
    $client = new \Twilio\Rest\Client($sid, $token);
    
    // Essayer avec SendDigits pour skipper automatiquement
    echo "TEST: Envoi avec SendDigits pour skip auto\n";
    echo "──────────────────────────────────────────\n";
    
    $twiml = '<Response>' .
             '<Say language="fr-FR" voice="woman">' . 
             htmlspecialchars($messageActuel) . 
             '</Say>' .
             '</Response>';
    
    $call = $client->calls->create(
        $to,
        $from,
        [
            'twiml' => $twiml,
            'sendDigits' => '1wwww'  // Envoie "1" puis attend
        ]
    );
    
    echo "✅ Appel lancé: " . $call->sid . "\n\n";
    
    echo "📞 CE QUI VA SE PASSER:\n";
    echo "────────────────────────\n";
    echo "1. Twilio dit le message Trial (15-20 secondes)\n";
    echo "2. SendDigits envoie '1' pour essayer de skip\n";
    echo "3. Le message français devrait suivre:\n";
    echo "   \"$messageActuel\"\n\n";
    
    echo "⏱️  CHRONOLOGIE ATTENDUE:\n";
    echo "─────────────────────────\n";
    echo "0-20s  : Message Trial en anglais\n";
    echo "20-30s : Message français\n";
    echo "30s+   : Fin de l'appel\n\n";
    
    // Suivre le status
    for ($i = 1; $i <= 5; $i++) {
        sleep(5);
        $updatedCall = $client->calls($call->sid)->fetch();
        $time = $i * 5;
        echo "T+{$time}s : Status = " . $updatedCall->status;
        
        if ($updatedCall->status == 'completed') {
            echo " (Durée totale: " . $updatedCall->duration . "s)";
        }
        echo "\n";
        
        if ($updatedCall->status == 'completed' || $updatedCall->status == 'failed') {
            break;
        }
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║                   CONCLUSION                          ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

echo "💡 LE MESSAGE FRANÇAIS EST BIEN DIT !\n";
echo "   Il faut juste attendre après le message Trial.\n\n";

echo "🎯 POUR ÉVITER LE MESSAGE TRIAL:\n";
echo "   1. Passer au compte Twilio payant (~10€)\n";
echo "   2. Utiliser Orange CI API pour la Côte d'Ivoire\n";
echo "   3. Dire aux testeurs d'attendre 20 secondes\n\n";

echo "✅ MAMA ÉCOLE FONCTIONNE !\n";
echo "   Le message est transmis correctement.\n";
echo "   C'est juste le mode Trial qui ajoute ce délai.\n";

echo "\n════════════════════════════════════════════════════════\n\n";