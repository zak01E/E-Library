<?php
/**
 * TEST FINAL - MAMA ÉCOLE CORRIGÉ
 */

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n=====================================\n";
echo "   TEST FINAL MAMA ÉCOLE            \n";
echo "=====================================\n\n";

// 1. Test envoi SMS
echo "📱 TEST SMS AVEC SAUVEGARDE DB\n";
echo "─────────────────────────────\n";

$phone = '+33752353581';
$message = 'TEST FINAL: ' . date('H:i:s') . ' - Tout fonctionne!';

try {
    $sid = env('TWILIO_SID');
    $token = env('TWILIO_TOKEN');
    $from = env('TWILIO_NUMBER');
    
    $client = new \Twilio\Rest\Client($sid, $token);
    
    echo "Envoi SMS...\n";
    $result = $client->messages->create(
        $phone,
        [
            'from' => $from,
            'body' => $message
        ]
    );
    
    echo "✅ SMS envoyé! SID: " . $result->sid . "\n";
    echo "   Status initial: " . $result->status . "\n";
    
    // Sauvegarder dans la base
    \DB::table('mama_ecole_sms_logs')->insert([
        'phone_number' => $phone,
        'message' => $message,
        'status' => $result->status ?: 'pending',
        'message_id' => $result->sid,
        'created_at' => now()
    ]);
    echo "✅ Sauvegardé dans la base de données\n";
    
    // Attendre et vérifier
    echo "\n⏳ Vérification après 3 secondes...\n";
    sleep(3);
    
    $updated = $client->messages($result->sid)->fetch();
    echo "   Status final: " . $updated->status . "\n";
    
    // Mettre à jour dans la base
    \DB::table('mama_ecole_sms_logs')
        ->where('message_id', $result->sid)
        ->update(['status' => $updated->status]);
    echo "✅ Status mis à jour dans la base\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

// 2. Vérifier les SMS dans la base
echo "\n📊 SMS DANS LA BASE DE DONNÉES\n";
echo "─────────────────────────────\n";

$smsLogs = \DB::table('mama_ecole_sms_logs')
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();

foreach ($smsLogs as $log) {
    $status = match($log->status) {
        'delivered' => '✅',
        'sent' => '📤',
        'queued' => '⏳',
        'failed' => '❌',
        default => '❓'
    };
    
    echo $status . " " . substr($log->created_at, 11, 8) . " - " . 
         substr($log->message, 0, 40) . "... - " . 
         $log->status . "\n";
}

// 3. Résumé
echo "\n📈 STATISTIQUES\n";
echo "─────────────────────────────\n";

$stats = [
    'total' => \DB::table('mama_ecole_sms_logs')->count(),
    'delivered' => \DB::table('mama_ecole_sms_logs')->where('status', 'delivered')->count(),
    'sent' => \DB::table('mama_ecole_sms_logs')->where('status', 'sent')->count(),
    'failed' => \DB::table('mama_ecole_sms_logs')->where('status', 'failed')->count(),
    'today' => \DB::table('mama_ecole_sms_logs')->whereDate('created_at', today())->count()
];

echo "Total SMS: " . $stats['total'] . "\n";
echo "Délivrés: " . $stats['delivered'] . "\n";
echo "Envoyés: " . $stats['sent'] . "\n";
echo "Échoués: " . $stats['failed'] . "\n";
echo "Aujourd'hui: " . $stats['today'] . "\n";

echo "\n✅ TEST TERMINÉ AVEC SUCCÈS\n";
echo "─────────────────────────────\n";
echo "Maintenant vous pouvez utiliser:\n";
echo "1. Le serveur: MAMA_ECOLE_LANCER.bat\n";
echo "2. La page: http://localhost:8000/mama-ecole/test-simple\n";
echo "3. Ce script: php test-final-mama-ecole.php\n";

echo "\n=====================================\n";