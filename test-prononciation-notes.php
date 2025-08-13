<?php
/**
 * TEST PRONONCIATION DES NOTES
 * Vérifie que les notes sont bien prononcées
 */

require_once 'vendor/autoload.php';

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║        TEST PRONONCIATION DES NOTES                   ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

$sid = 'YOUR_TWILIO_SID';
$token = 'YOUR_TWILIO_TOKEN';
$from = 'YOUR_TWILIO_PHONE';
$to = 'DESTINATION_PHONE';

// Différentes façons d'écrire les notes
$tests = [
    "15/20" => "quinze barre oblique vingt",  // MAUVAIS
    "15 sur 20" => "quinze sur vingt",        // BON
    "15 / 20" => "quinze barre oblique vingt", // MAUVAIS
    "note de 15 sur 20" => "note de quinze sur vingt", // BON
    "15 divisé par 20" => "quinze divisé par vingt",
    "quinze sur vingt" => "quinze sur vingt"  // PARFAIT
];

echo "📊 FORMATS DE NOTES À TESTER:\n";
echo "──────────────────────────────\n";
$i = 1;
foreach ($tests as $format => $prononciation) {
    echo "$i. \"$format\" → $prononciation\n";
    $i++;
}

echo "\nQuel format tester? [2]: ";
$handle = fopen("php://stdin", "r");
$choice = trim(fgets($handle)) ?: '2';

$formats = array_keys($tests);
$selectedFormat = $formats[$choice - 1] ?? $formats[1];

$message = "Bonjour, c'est l'école. Votre enfant a obtenu " . $selectedFormat . " en mathématiques. Félicitations!";

echo "\n📢 MESSAGE À ENVOYER:\n";
echo "────────────────────\n";
echo "\"$message\"\n\n";

echo "💬 PRONONCIATION ATTENDUE:\n";
echo "─────────────────────────\n";
$expectedPronunciation = str_replace($selectedFormat, $tests[$selectedFormat], $message);
echo "\"$expectedPronunciation\"\n\n";

try {
    $client = new \Twilio\Rest\Client($sid, $token);
    
    // Pour une meilleure prononciation, on peut utiliser SSML
    $ssmlMessage = '<speak>' .
                   'Bonjour, c\'est l\'école. ' .
                   'Votre enfant a obtenu ' .
                   '<say-as interpret-as="cardinal">15</say-as> sur ' .
                   '<say-as interpret-as="cardinal">20</say-as> ' .
                   'en mathématiques. Félicitations!' .
                   '</speak>';
    
    // Version simple (recommandée)
    $simpleMessage = "Bonjour, c'est l'école. Votre enfant a obtenu quinze sur vingt en mathématiques. Félicitations!";
    
    echo "TEST 1: Version avec format choisi\n";
    echo "───────────────────────────────────\n";
    
    $twiml = '<Response>' .
             '<Say language="fr-FR" voice="woman">' . 
             htmlspecialchars($message) . 
             '</Say>' .
             '</Response>';
    
    $call1 = $client->calls->create(
        $to,
        $from,
        ['twiml' => $twiml, 'sendDigits' => '1wwww']
    );
    
    echo "✅ Appel 1 lancé: " . $call1->sid . "\n";
    echo "   Format: \"$selectedFormat\"\n\n";
    
    echo "⏸️  Attendre 20 secondes...\n";
    sleep(20);
    
    echo "\nTEST 2: Version optimisée (quinze sur vingt)\n";
    echo "──────────────────────────────────────────────\n";
    
    $twiml2 = '<Response>' .
              '<Say language="fr-FR" voice="woman">' . 
              htmlspecialchars($simpleMessage) . 
              '</Say>' .
              '</Response>';
    
    $call2 = $client->calls->create(
        $to,
        $from,
        ['twiml' => $twiml2, 'sendDigits' => '1wwww']
    );
    
    echo "✅ Appel 2 lancé: " . $call2->sid . "\n";
    echo "   Message: \"quinze sur vingt\"\n\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║                   RECOMMANDATIONS                     ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

echo "✅ FORMATS RECOMMANDÉS:\n";
echo "   • \"15 sur 20\" (avec espaces)\n";
echo "   • \"quinze sur vingt\" (en toutes lettres)\n";
echo "   • \"note de 15 sur 20\"\n\n";

echo "❌ FORMATS À ÉVITER:\n";
echo "   • \"15/20\" → dit \"quinze barre oblique vingt\"\n";
echo "   • \"15 / 20\" → dit \"quinze barre oblique vingt\"\n\n";

echo "💡 SOLUTION ADOPTÉE:\n";
echo "   Utiliser \"15 sur 20\" dans tous les messages\n";
echo "   Cela sera prononcé correctement: \"quinze sur vingt\"\n";

echo "\n════════════════════════════════════════════════════════\n\n";