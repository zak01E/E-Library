<?php
/**
 * TEST MESSAGE OPTIMISÉ POUR LA PRONONCIATION
 * Version finale avec la meilleure prononciation
 */

require_once 'vendor/autoload.php';

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║     MESSAGE OPTIMISÉ - PRONONCIATION PARFAITE         ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

$sid = 'YOUR_TWILIO_SID';
$token = 'YOUR_TWILIO_TOKEN';
$from = 'YOUR_TWILIO_PHONE';
$to = 'DESTINATION_PHONE';

// Messages optimisés pour une bonne prononciation
$messagesOptimises = [
    'grades' => "Bonjour, c'est l'école. Votre enfant a obtenu quinze sur vingt en mathématiques. Félicitations!",
    'absence' => "Bonjour, c'est l'école. Votre enfant était absent aujourd'hui. Merci de nous contacter.",
    'meeting' => "Bonjour, c'est l'école. Une réunion importante aura lieu vendredi à quatorze heures.",
    'urgent' => "Message urgent de l'école. Votre enfant est à l'infirmerie. Merci de venir."
];

echo "📢 MESSAGES OPTIMISÉS:\n";
echo "══════════════════════\n\n";

foreach ($messagesOptimises as $type => $msg) {
    echo strtoupper($type) . ":\n";
    echo "\"$msg\"\n\n";
}

echo "Quel message tester?\n";
echo "1. Notes (quinze sur vingt)\n";
echo "2. Absence\n";
echo "3. Réunion\n";
echo "4. Urgent\n";
echo "Choix [1]: ";

$handle = fopen("php://stdin", "r");
$choice = trim(fgets($handle)) ?: '1';

$types = array_keys($messagesOptimises);
$selectedType = $types[$choice - 1] ?? $types[0];
$message = $messagesOptimises[$selectedType];

echo "\n📞 LANCEMENT DE L'APPEL\n";
echo "────────────────────────\n";
echo "Message: \"$message\"\n\n";

try {
    $client = new \Twilio\Rest\Client($sid, $token);
    
    // TwiML optimisé
    $twiml = '<Response>' .
             '<Say language="fr-FR" voice="woman">' . 
             htmlspecialchars($message) . 
             '</Say>' .
             '<Pause length="1"/>' .
             '<Say language="fr-FR" voice="woman">' .
             'Pour répéter, appuyez sur un.' .
             '</Say>' .
             '</Response>';
    
    $call = $client->calls->create(
        $to,
        $from,
        [
            'twiml' => $twiml,
            'sendDigits' => '1wwww'  // Skip le message trial
        ]
    );
    
    echo "✅ Appel lancé avec succès!\n";
    echo "   SID: " . $call->sid . "\n";
    echo "   Status: " . $call->status . "\n\n";
    
    // Log dans la base
    $conn = new mysqli("localhost", "root", "", "elibrary");
    if (!$conn->connect_error) {
        $sql = "INSERT INTO mama_ecole_interactions (parent_id, message_type, language, call_sid, call_status, message_data, created_at) 
                VALUES (NULL, ?, 'fr-FR', ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $messageData = json_encode(['message' => $message, 'optimized' => true]);
        $callSid = $call->sid;
        $callStatus = $call->status;
        $stmt->bind_param("ssss", $selectedType, $callSid, $callStatus, $messageData);
        $stmt->execute();
        echo "✅ Enregistré dans la base de données\n";
        $conn->close();
    }
    
    echo "\n⏱️  CHRONOLOGIE DE L'APPEL:\n";
    echo "──────────────────────────\n";
    echo "0-20s  : Message Trial Twilio (anglais)\n";
    echo "20-30s : VOTRE MESSAGE (français):\n";
    echo "         \"$message\"\n";
    echo "30-35s : \"Pour répéter, appuyez sur un\"\n";
    echo "35s+   : Fin de l'appel\n\n";
    
    // Suivi du status
    for ($i = 1; $i <= 4; $i++) {
        sleep(5);
        $updatedCall = $client->calls($call->sid)->fetch();
        echo "T+" . ($i * 5) . "s: " . $updatedCall->status . "\n";
        if ($updatedCall->status == 'completed') {
            echo "Durée totale: " . $updatedCall->duration . " secondes\n";
            break;
        }
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║              PRONONCIATION CORRECTE                   ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

echo "✅ CORRECTIONS APPLIQUÉES:\n";
echo "   • \"15/20\" → \"quinze sur vingt\"\n";
echo "   • \"14 heures\" → \"quatorze heures\"\n";
echo "   • Nombres écrits en lettres\n\n";

echo "📌 CE QUE VOUS ENTENDREZ:\n";
echo "   Après le message Trial (20s), vous entendrez:\n";
echo "   • \"quinze sur vingt\" (pas \"quinze barre oblique vingt\")\n";
echo "   • \"quatorze heures\" (pas \"14 heures\")\n\n";

echo "💡 MAMA ÉCOLE EST PRÊT!\n";
echo "   Les messages sont optimisés pour une prononciation parfaite.\n";

echo "\n════════════════════════════════════════════════════════\n\n";