<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twilio\Rest\Client;

class TestTwilioWeb extends Command
{
    protected $signature = 'twilio:test-web {action=info}';
    protected $description = 'Tester les fonctionnalités Twilio Web';

    public function handle()
    {
        $action = $this->argument('action');
        
        $this->info('===== TEST TWILIO WEB MAMA ÉCOLE =====');
        
        // Vérifier la configuration
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $from = env('TWILIO_NUMBER');
        $mode = env('MAMA_ECOLE_MODE');
        
        $this->line('');
        $this->info('📋 CONFIGURATION ACTUELLE:');
        $this->line('   Mode: ' . $mode);
        $this->line('   SID: ' . ($sid ? substr($sid, 0, 20) . '...' : 'NON CONFIGURÉ'));
        $this->line('   Token: ' . ($token ? '****** (configuré)' : 'NON CONFIGURÉ'));
        $this->line('   Numéro: ' . $from);
        $this->line('');
        
        // Vérifier les routes
        $this->info('🛣️  ROUTES DISPONIBLES:');
        $routes = [
            'mama-ecole.index' => '/mama-ecole',
            'mama-ecole.test.twilio' => '/mama-ecole/test-twilio',
            'mama-ecole.dashboard' => '/mama-ecole/dashboard',
            'mama-ecole.parents' => '/mama-ecole/parents',
            'mama-ecole.test.call' => '/mama-ecole/test/call',
            'mama-ecole.test.sms' => '/mama-ecole/test/sms'
        ];
        
        foreach ($routes as $name => $path) {
            try {
                if (\Route::has($name)) {
                    $this->line('   ✅ ' . $path . ' -> ' . route($name));
                } else {
                    $this->line('   ❌ ' . $path . ' (route non trouvée)');
                }
            } catch (\Exception $e) {
                $this->line('   ⚠️  ' . $path . ' (erreur: ' . $e->getMessage() . ')');
            }
        }
        
        $this->line('');
        
        // Test de connexion Twilio
        if ($action == 'connect') {
            $this->info('🔌 TEST DE CONNEXION TWILIO:');
            
            try {
                $client = new Client($sid, $token);
                
                // Récupérer les infos du compte
                $account = $client->api->v2010->accounts($sid)->fetch();
                
                $this->line('   ✅ Connexion réussie!');
                $this->line('   Nom du compte: ' . $account->friendlyName);
                $this->line('   Status: ' . $account->status);
                $this->line('   Date création: ' . $account->dateCreated->format('Y-m-d'));
                $this->line('   Balance: ' . $account->balance . ' ' . $account->currency);
                
            } catch (\Exception $e) {
                $this->error('   ❌ Erreur de connexion: ' . $e->getMessage());
            }
        }
        
        // Test d'envoi SMS
        if ($action == 'sms') {
            $to = $this->ask('Numéro de destination (format international)', '+33752353581');
            
            $this->info('📱 ENVOI SMS DE TEST...');
            
            try {
                $client = new Client($sid, $token);
                
                $message = $client->messages->create(
                    $to,
                    [
                        'from' => $from,
                        'body' => 'TEST WEB: Mama École fonctionne! ' . now()->format('H:i:s')
                    ]
                );
                
                $this->info('   ✅ SMS envoyé avec succès!');
                $this->line('   SID: ' . $message->sid);
                $this->line('   Status: ' . $message->status);
                $this->line('   To: ' . $message->to);
                $this->line('   Prix: ' . $message->price . ' ' . $message->priceUnit);
                
            } catch (\Exception $e) {
                $this->error('   ❌ Erreur: ' . $e->getMessage());
            }
        }
        
        // Test d'appel
        if ($action == 'call') {
            $to = $this->ask('Numéro à appeler', '+33752353581');
            
            $this->info('📞 LANCEMENT APPEL DE TEST...');
            
            try {
                $client = new Client($sid, $token);
                
                // URL TwiML de test qui dit un message
                $twimlUrl = 'http://demo.twilio.com/docs/voice.xml';
                
                $call = $client->calls->create(
                    $to,
                    $from,
                    ['url' => $twimlUrl]
                );
                
                $this->info('   ✅ Appel lancé avec succès!');
                $this->line('   SID: ' . $call->sid);
                $this->line('   Status: ' . $call->status);
                $this->line('   To: ' . $call->to);
                
            } catch (\Exception $e) {
                $this->error('   ❌ Erreur: ' . $e->getMessage());
            }
        }
        
        $this->line('');
        $this->info('💡 COMMANDES DISPONIBLES:');
        $this->line('   php artisan twilio:test-web info     - Afficher les infos');
        $this->line('   php artisan twilio:test-web connect  - Tester la connexion');
        $this->line('   php artisan twilio:test-web sms      - Envoyer un SMS');
        $this->line('   php artisan twilio:test-web call     - Passer un appel');
        
        return 0;
    }
}