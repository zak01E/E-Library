<?php
/**
 * TEST VOIX FRANÇAISE - MAMA ÉCOLE
 * Teste différentes configurations de voix
 */

require_once 'vendor/autoload.php';

echo "\n===== TEST VOIX FRANÇAISE =====\n\n";

$sid = 'YOUR_TWILIO_SID';
$token = 'YOUR_TWILIO_TOKEN';
$from = 'YOUR_TWILIO_PHONE';
$to = 'DESTINATION_PHONE';

$message = "Bonjour. Votre enfant a obtenu quinze sur vingt en mathématiques. Félicitations.";

echo "Message à tester: \"$message\"\n\n";

// Différentes configurations à tester
$configs = [
    [
        'name' => 'Polly.Celine (FR)',
        'voice' => 'Polly.Celine',
        'language' => 'fr-FR'
    ],
    [
        'name' => 'Polly.Mathieu (FR)',
        'voice' => 'Polly.Mathieu',
        'language' => 'fr-FR'
    ],
    [
        'name' => 'Polly.Lea (FR)',
        'voice' => 'Polly.Lea',
        'language' => 'fr-FR'
    ],
    [
        'name' => 'alice (standard)',
        'voice' => 'alice',
        'language' => 'fr-FR'
    ],
    [
        'name' => 'woman (standard)',
        'voice' => 'woman',
        'language' => 'fr-FR'
    ]
];

echo "Quelle voix tester?\n";
foreach ($configs as $i => $config) {
    echo ($i + 1) . ". " . $config['name'] . "\n";
}
echo "6. Toutes (avec 20s entre chaque)\n";
echo "\nVotre choix [1]: ";

$handle = fopen("php://stdin", "r");
$choice = trim(fgets($handle)) ?: '1';

try {
    $client = new \Twilio\Rest\Client($sid, $token);
    
    if ($choice == '6') {
        // Tester toutes les voix
        foreach ($configs as $i => $config) {
            echo "\n" . ($i + 1) . ". Test avec " . $config['name'] . "\n";
            testVoice($client, $to, $from, $message, $config);
            
            if ($i < count($configs) - 1) {
                echo "⏸️  Attente 20 secondes...\n";
                sleep(20);
            }
        }
    } else {
        // Tester une seule voix
        $index = intval($choice) - 1;
        if (isset($configs[$index])) {
            echo "\nTest avec " . $configs[$index]['name'] . "\n";
            testVoice($client, $to, $from, $message, $configs[$index]);
        }
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

function testVoice($client, $to, $from, $message, $config) {
    // Créer le TwiML avec la configuration spécifique
    $twiml = '<Response>';
    
    // Message principal
    $sayTag = '<Say';
    if ($config['language']) {
        $sayTag .= ' language="' . $config['language'] . '"';
    }
    if ($config['voice']) {
        $sayTag .= ' voice="' . $config['voice'] . '"';
    }
    $sayTag .= '>' . htmlspecialchars($message) . '</Say>';
    
    $twiml .= $sayTag;
    
    // Ajouter une pause et info sur la voix
    $twiml .= '<Pause length="1"/>';
    $twiml .= '<Say language="' . $config['language'] . '" voice="' . $config['voice'] . '">';
    $twiml .= 'Ceci était la voix ' . str_replace('Polly.', '', $config['voice']) . '.';
    $twiml .= '</Say>';
    
    $twiml .= '</Response>';
    
    echo "TwiML généré:\n";
    echo substr($twiml, 0, 150) . "...\n\n";
    
    // Lancer l'appel
    $call = $client->calls->create(
        $to,
        $from,
        ['twiml' => $twiml]
    );
    
    echo "✅ Appel lancé: " . $call->sid . "\n";
    echo "   Voix: " . $config['voice'] . "\n";
    echo "   Langue: " . $config['language'] . "\n";
    echo "   Status: " . $call->status . "\n";
    
    // Vérifier après 5 secondes
    sleep(5);
    $updatedCall = $client->calls($call->sid)->fetch();
    echo "   Status après 5s: " . $updatedCall->status . "\n";
    
    if ($updatedCall->status == 'completed') {
        echo "   Durée: " . $updatedCall->duration . " secondes\n";
    }
}

echo "\n===== NOTES =====\n";
echo "• Polly = Voix Amazon (haute qualité)\n";
echo "• Celine = Voix féminine française\n";
echo "• Mathieu = Voix masculine française\n";
echo "• Lea = Voix féminine française (alternative)\n";
echo "• alice/woman = Voix standard Twilio\n";
echo "\n";
echo "Recommandation: Polly.Celine ou Polly.Lea\n";
echo "==================\n\n";