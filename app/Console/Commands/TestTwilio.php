<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twilio\Rest\Client;

class TestTwilio extends Command
{
    protected $signature = 'twilio:test {phone?}';
    protected $description = 'Tester l\'intégration Twilio pour Mama École';

    public function handle()
    {
        $this->info('===== TEST TWILIO MAMA ÉCOLE =====');
        
        // Récupérer les credentials
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $from = env('TWILIO_NUMBER');
        
        // Numéro de destination
        $to = $this->argument('phone') ?? '+33752353581';
        
        $this->info("Configuration:");
        $this->line("- SID: " . substr($sid, 0, 10) . "...");
        $this->line("- From: $from");
        $this->line("- To: $to");
        
        try {
            // Initialiser Twilio
            $client = new Client($sid, $token);
            $this->info("✅ Client Twilio initialisé");
            
            // Test SMS
            if ($this->confirm('Voulez-vous envoyer un SMS de test?', true)) {
                $this->info("📱 Envoi du SMS...");
                
                $message = $client->messages->create(
                    $to,
                    [
                        'from' => $from,
                        'body' => 'MAMA ÉCOLE: Test réussi! ' . now()->format('H:i:s')
                    ]
                );
                
                $this->info("✅ SMS envoyé!");
                $this->line("   SID: " . $message->sid);
                $this->line("   Status: " . $message->status);
            }
            
            // Test Appel
            if ($this->confirm('Voulez-vous passer un appel de test?', false)) {
                $this->info("📞 Lancement de l'appel...");
                
                // Utiliser une URL TwiML de démo
                $call = $client->calls->create(
                    $to,
                    $from,
                    [
                        'url' => 'http://demo.twilio.com/docs/voice.xml'
                    ]
                );
                
                $this->info("✅ Appel lancé!");
                $this->line("   SID: " . $call->sid);
                $this->line("   Status: " . $call->status);
            }
            
            $this->info("\n✅ TEST TERMINÉ AVEC SUCCÈS!");
            
        } catch (\Exception $e) {
            $this->error("❌ ERREUR: " . $e->getMessage());
            $this->line("\nVérifiez:");
            $this->line("1. Vos credentials Twilio dans .env");
            $this->line("2. Le numéro $to est vérifié dans Twilio");
            $this->line("3. Votre compte a du crédit");
            
            return 1;
        }
        
        return 0;
    }
}