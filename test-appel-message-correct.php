<?php
/**
 * TEST MESSAGE CORRECT - MAMA ÉCOLE
 * Vérifie que le message exact est transmis
 */

require_once 'vendor/autoload.php';

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║         TEST MESSAGE VOCAL CORRECT                    ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

$sid = 'YOUR_TWILIO_SID';
$token = 'YOUR_TWILIO_TOKEN';
$from = 'YOUR_TWILIO_PHONE';
$to = 'DESTINATION_PHONE';

// Message exact attendu
$messageAttendu = "Bonjour, c'est l'école. Votre enfant a obtenu 15 sur 20 en mathématiques. Félicitations!";

echo "📢 MESSAGE À TRANSMETTRE:\n";
echo "────────────────────────\n";
echo "\"$messageAttendu\"\n\n";

try {
    $client = new \Twilio\Rest\Client($sid, $token);
    
    // Utiliser la voix 'woman' pour compatibilité
    $twiml = '<Response>' .
             '<Say language="fr-FR" voice="woman">' . 
             htmlspecialchars($messageAttendu) . 
             '</Say>' .
             '</Response>';
    
    echo "📝 TWIML GÉNÉRÉ:\n";
    echo "────────────────\n";
    echo $twiml . "\n\n";
    
    echo "📞 LANCEMENT DE L'APPEL...\n";
    echo "──────────────────────────\n";
    
    $call = $client->calls->create(
        $to,
        $from,
        ['twiml' => $twiml]
    );
    
    echo "✅ Appel lancé avec succès!\n";
    echo "   SID: " . $call->sid . "\n";
    echo "   Status: " . $call->status . "\n";
    echo "   Vers: $to\n\n";
    
    // Enregistrer dans la base
    $conn = new mysqli("localhost", "root", "", "elibrary");
    if (!$conn->connect_error) {
        $sql = "INSERT INTO mama_ecole_interactions (parent_id, message_type, language, call_sid, call_status, message_data, created_at) 
                VALUES (NULL, 'grades', 'fr-FR', ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $messageData = json_encode(['message' => $messageAttendu]);
        $stmt->bind_param("sss", $call->sid, $call->status, $messageData);
        if ($stmt->execute()) {
            echo "✅ Appel enregistré dans la base de données\n";
        }
        $conn->close();
    }
    
    echo "\n⏳ VÉRIFICATION DU STATUS...\n";
    echo "────────────────────────────\n";
    
    // Vérifier après quelques secondes
    for ($i = 1; $i <= 3; $i++) {
        sleep(3);
        $updatedCall = $client->calls($call->sid)->fetch();
        echo "   Après " . ($i * 3) . "s: " . $updatedCall->status;
        
        if ($updatedCall->status == 'completed') {
            echo " (Durée: " . $updatedCall->duration . "s)";
        }
        echo "\n";
        
        if ($updatedCall->status == 'completed' || $updatedCall->status == 'failed') {
            break;
        }
    }
    
    echo "\n";
    echo "╔════════════════════════════════════════════════════════╗\n";
    echo "║                    RÉSULTAT                           ║\n";
    echo "╚════════════════════════════════════════════════════════╝\n\n";
    
    echo "✅ L'appel a été lancé avec le message:\n";
    echo "   \"$messageAttendu\"\n\n";
    
    echo "📌 CE QUE VOUS DEVRIEZ ENTENDRE:\n";
    echo "   1. Message Twilio trial (en anglais)\n";
    echo "   2. Puis le message en français:\n";
    echo "      \"$messageAttendu\"\n\n";
    
    echo "💡 SI LE MESSAGE N'EST PAS CLAIR:\n";
    echo "   - La voix 'woman' est utilisée (standard Twilio)\n";
    echo "   - Le language est défini sur 'fr-FR'\n";
    echo "   - Pour une meilleure qualité, passez au compte payant\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

echo "\n════════════════════════════════════════════════════════\n\n";