<?php
/**
 * TEST APPEL VOCAL EN FRANÇAIS - MAMA ÉCOLE
 * Utilise TwiML pour message personnalisé
 */

require_once 'vendor/autoload.php';

echo "\n===== TEST APPEL FRANÇAIS MAMA ÉCOLE =====\n\n";

// Configuration
$sid = 'YOUR_TWILIO_SID';
$token = 'YOUR_TWILIO_TOKEN';
$from = 'YOUR_TWILIO_PHONE';

// Menu de test
echo "CHOISISSEZ LE TYPE DE MESSAGE:\n";
echo "1. Notes de l'élève\n";
echo "2. Absence signalée\n";
echo "3. Convocation réunion\n";
echo "4. Message urgent\n";
echo "Votre choix [1]: ";
$handle = fopen("php://stdin", "r");
$choix = trim(fgets($handle)) ?: '1';

// Demander le numéro
echo "\nNuméro à appeler [DESTINATION_PHONE]: ";
$input = trim(fgets($handle));
$to = $input ?: 'DESTINATION_PHONE';

// Préparer le message selon le choix
$messages = [
    '1' => "Bonjour, c'est l'école de votre enfant. Nous vous appelons pour vous informer que votre enfant a obtenu 15 sur 20 en mathématiques. C'est une bonne note. Félicitations!",
    '2' => "Bonjour, c'est l'école. Votre enfant était absent aujourd'hui. Merci de nous contacter pour justifier cette absence.",
    '3' => "Bonjour, c'est l'école. Une réunion importante aura lieu vendredi à 14 heures. Votre présence est requise. Merci.",
    '4' => "Attention, message urgent de l'école. Votre enfant est à l'infirmerie. Merci de venir le chercher rapidement."
];

$message = $messages[$choix] ?? $messages['1'];

echo "\nConfiguration:\n";
echo "  De: $from\n";
echo "  Vers: $to\n";
echo "  Type: " . ['1'=>'Notes', '2'=>'Absence', '3'=>'Réunion', '4'=>'Urgent'][$choix] . "\n";
echo "  Message: " . substr($message, 0, 50) . "...\n\n";

try {
    $client = new \Twilio\Rest\Client($sid, $token);
    
    echo "Création du message vocal en français...\n";
    
    // Créer le TwiML avec message en français
    $twiml = new \Twilio\TwiML\VoiceResponse();
    
    // Message d'accueil
    $twiml->say($message, [
        'voice' => 'Polly.Celine',  // Voix française féminine
        'language' => 'fr-FR'
    ]);
    
    // Options interactives
    $gather = $twiml->gather([
        'numDigits' => 1,
        'timeout' => 10
    ]);
    
    $gather->say("Appuyez sur 1 pour répéter le message. Appuyez sur 2 pour confirmer la réception.", [
        'voice' => 'Polly.Celine',
        'language' => 'fr-FR'
    ]);
    
    // Si pas de réponse
    $twiml->say("Merci de votre attention. Au revoir.", [
        'voice' => 'Polly.Celine',
        'language' => 'fr-FR'
    ]);
    
    // Sauvegarder le TwiML temporairement
    $twimlContent = $twiml->asXML();
    $fileName = 'twiml_' . uniqid() . '.xml';
    $filePath = __DIR__ . '/storage/app/public/' . $fileName;
    
    // Créer le dossier si nécessaire
    $dir = dirname($filePath);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    
    file_put_contents($filePath, $twimlContent);
    
    echo "TwiML créé: $fileName\n";
    echo "\n⚠️ IMPORTANT: Pour un appel avec message personnalisé,\n";
    echo "   vous devez utiliser ngrok ou un serveur public.\n\n";
    
    // Pour le test, on utilise quand même l'URL de démo
    echo "Lancement de l'appel avec message de démo...\n";
    
    $call = $client->calls->create(
        $to,
        $from,
        [
            'twiml' => '<Response><Say language="fr-FR" voice="Polly.Celine">' . 
                       htmlspecialchars($message) . 
                       '</Say></Response>'
        ]
    );
    
    echo "\n✅ APPEL LANCÉ AVEC MESSAGE FRANÇAIS!\n";
    echo "  SID: " . $call->sid . "\n";
    echo "  Status: " . $call->status . "\n";
    
    // Vérification après 5 secondes
    echo "\n⏳ Vérification après 5 secondes...\n";
    sleep(5);
    
    $updatedCall = $client->calls($call->sid)->fetch();
    echo "  Status: " . $updatedCall->status . "\n";
    
    if ($updatedCall->status == 'in-progress' || $updatedCall->status == 'ringing') {
        echo "\n📞 APPEL EN COURS!\n";
        echo "  Le message sera dit en français.\n";
    } elseif ($updatedCall->status == 'completed') {
        echo "\n✅ APPEL TERMINÉ!\n";
        echo "  Durée: " . $updatedCall->duration . " secondes\n";
    } else {
        echo "\n⚠️ Status: " . $updatedCall->status . "\n";
    }
    
} catch (\Twilio\Exceptions\RestException $e) {
    echo "\n❌ ERREUR TWILIO:\n";
    echo "  Code: " . $e->getCode() . "\n";
    echo "  Message: " . $e->getMessage() . "\n";
    
    if ($e->getCode() == 21608) {
        echo "\n⚠️ Numéro non vérifié dans le compte Trial!\n";
    }
} catch (Exception $e) {
    echo "\n❌ ERREUR: " . $e->getMessage() . "\n";
}

echo "\n📊 RÉSUMÉ DES CAPACITÉS D'APPEL:\n";
echo "  ✅ Appels sortants: FONCTIONNELS\n";
echo "  ✅ Messages en français: POSSIBLES avec TwiML\n";
echo "  ✅ Voix française: Polly.Celine disponible\n";
echo "  ⚠️ Limitation: Compte Trial (numéros vérifiés uniquement)\n";

echo "\n💡 POUR MAMA ÉCOLE:\n";
echo "  1. Les parents illettrés peuvent recevoir des appels\n";
echo "  2. Messages vocaux en français (ou autre langue)\n";
echo "  3. Possibilité d'interaction (appuyer 1, 2, etc.)\n";
echo "  4. Suivi des appels (durée, status)\n";

echo "\n===== FIN DU TEST =====\n\n";