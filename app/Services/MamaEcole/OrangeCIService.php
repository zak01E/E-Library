<?php

namespace App\Services\MamaEcole;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class OrangeCIService
{
    private $apiKey;
    private $apiSecret;
    private $senderName;
    private $smsEndpoint;
    private $oauthEndpoint;
    private $accessToken;
    
    public function __construct()
    {
        $this->apiKey = env('ORANGE_API_KEY');
        $this->apiSecret = env('ORANGE_API_SECRET');
        $this->senderName = env('ORANGE_SENDER_NAME', 'MAMA ECOLE');
        $this->smsEndpoint = env('ORANGE_SMS_ENDPOINT', 'https://api.orange.ci/sms/v1');
        $this->oauthEndpoint = env('ORANGE_OAUTH_ENDPOINT', 'https://api.orange.ci/oauth/v2/token');
    }
    
    /**
     * Obtenir le token d'accès OAuth2
     */
    private function getAccessToken()
    {
        // Vérifier si token en cache
        $token = Cache::get('orange_ci_token');
        if ($token) {
            return $token;
        }
        
        try {
            $response = Http::asForm()->post($this->oauthEndpoint, [
                'grant_type' => 'client_credentials',
                'client_id' => $this->apiKey,
                'client_secret' => $this->apiSecret
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                $token = $data['access_token'];
                $expiresIn = $data['expires_in'] ?? 3600;
                
                // Mettre en cache le token (avec marge de sécurité)
                Cache::put('orange_ci_token', $token, $expiresIn - 60);
                
                return $token;
            }
            
            Log::error('Orange CI OAuth Error: ' . $response->body());
            return null;
            
        } catch (\Exception $e) {
            Log::error('Orange CI OAuth Exception: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Envoyer un SMS
     */
    public function sendSMS(string $phoneNumber, string $message, array $options = [])
    {
        // Mode démo
        if (env('MAMA_ECOLE_MODE') === 'demo') {
            return $this->mockSendSMS($phoneNumber, $message);
        }
        
        $token = $this->getAccessToken();
        if (!$token) {
            return [
                'success' => false,
                'error' => 'Failed to get access token'
            ];
        }
        
        try {
            // Formater le numéro (enlever le + si présent)
            $phoneNumber = str_replace('+', '', $phoneNumber);
            
            $response = Http::withToken($token)->post($this->smsEndpoint . '/outbound', [
                'outboundSMSMessageRequest' => [
                    'address' => 'tel:+' . $phoneNumber,
                    'senderAddress' => $this->senderName,
                    'outboundSMSTextMessage' => [
                        'message' => $message
                    ],
                    'clientCorrelator' => uniqid('mama_', true),
                    'receiptRequest' => [
                        'notifyURL' => route('mama-ecole.sms-callback'),
                        'callbackData' => $options['callback_data'] ?? null
                    ]
                ]
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Logger l'envoi
                $this->logSMS($phoneNumber, $message, 'success', $data);
                
                return [
                    'success' => true,
                    'message_id' => $data['outboundSMSMessageRequest']['resourceURL'] ?? uniqid(),
                    'data' => $data
                ];
            }
            
            Log::error('Orange CI SMS Error: ' . $response->body());
            return [
                'success' => false,
                'error' => 'SMS sending failed',
                'details' => $response->json()
            ];
            
        } catch (\Exception $e) {
            Log::error('Orange CI SMS Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Envoyer SMS en masse
     */
    public function bulkSMS(array $recipients, string $message, array $options = [])
    {
        $results = [
            'total' => count($recipients),
            'success' => 0,
            'failed' => 0,
            'details' => []
        ];
        
        foreach ($recipients as $recipient) {
            $phoneNumber = is_array($recipient) ? $recipient['phone'] : $recipient;
            
            $result = $this->sendSMS($phoneNumber, $message, $options);
            
            if ($result['success']) {
                $results['success']++;
            } else {
                $results['failed']++;
            }
            
            $results['details'][] = [
                'phone' => $phoneNumber,
                'status' => $result['success'] ? 'sent' : 'failed',
                'message_id' => $result['message_id'] ?? null,
                'error' => $result['error'] ?? null
            ];
            
            // Délai pour éviter rate limiting
            usleep(200000); // 0.2 seconde
        }
        
        return $results;
    }
    
    /**
     * Recevoir et traiter un SMS entrant
     */
    public function handleIncomingSMS(array $data)
    {
        try {
            $message = $data['inboundSMSMessageList']['inboundSMSMessage'][0] ?? null;
            
            if (!$message) {
                return ['success' => false, 'error' => 'Invalid message format'];
            }
            
            $phoneNumber = str_replace('tel:+', '', $message['senderAddress']);
            $text = $message['message'];
            $messageId = $message['messageId'];
            
            // Logger le message reçu
            \DB::table('mama_ecole_sms_received')->insert([
                'phone_number' => $phoneNumber,
                'message' => $text,
                'message_id' => $messageId,
                'raw_data' => json_encode($data),
                'created_at' => now()
            ]);
            
            // Traiter le message selon le contenu
            $response = $this->processIncomingMessage($phoneNumber, $text);
            
            // Envoyer réponse automatique si nécessaire
            if ($response) {
                $this->sendSMS($phoneNumber, $response);
            }
            
            return ['success' => true, 'message_id' => $messageId];
            
        } catch (\Exception $e) {
            Log::error('Handle Incoming SMS Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Traiter le contenu du message entrant
     */
    private function processIncomingMessage(string $phoneNumber, string $message)
    {
        $message = strtoupper(trim($message));
        
        // Commandes disponibles
        $commands = [
            'NOTES' => 'sendGrades',
            'PRESENCE' => 'sendAttendance',
            'REUNION' => 'sendMeetingInfo',
            'AIDE' => 'sendHelp',
            'STOP' => 'unsubscribe',
            'START' => 'subscribe'
        ];
        
        foreach ($commands as $command => $method) {
            if (str_contains($message, $command)) {
                return $this->$method($phoneNumber);
            }
        }
        
        // Message par défaut
        return "MAMA ECOLE: Commandes disponibles:\nNOTES - Notes de votre enfant\nPRESENCE - Présence aujourd'hui\nREUNION - Prochaine réunion\nAIDE - Assistance";
    }
    
    /**
     * Envoyer les notes par SMS
     */
    private function sendGrades(string $phoneNumber)
    {
        $parent = \DB::table('parents')->where('phone_number', $phoneNumber)->first();
        
        if (!$parent) {
            return "Numéro non enregistré. Contactez l'école pour vous inscrire à MAMA ECOLE.";
        }
        
        // Récupérer les dernières notes
        $grades = \DB::table('student_grades')
            ->join('students', 'student_grades.student_id', '=', 'students.id')
            ->join('parent_student', 'students.id', '=', 'parent_student.student_id')
            ->where('parent_student.parent_id', $parent->id)
            ->orderBy('student_grades.created_at', 'desc')
            ->limit(3)
            ->get();
        
        if ($grades->isEmpty()) {
            return "Aucune note disponible pour le moment.";
        }
        
        $message = "NOTES RECENTES:\n";
        foreach ($grades as $grade) {
            $message .= sprintf("%s: %s/20 en %s\n", 
                $grade->student_name,
                $grade->grade,
                $grade->subject
            );
        }
        
        return $message;
    }
    
    /**
     * Mode démo pour les tests
     */
    private function mockSendSMS(string $phoneNumber, string $message)
    {
        Log::info('DEMO SMS Sent', [
            'to' => $phoneNumber,
            'message' => $message,
            'timestamp' => now()
        ]);
        
        // Simuler l'envoi
        return [
            'success' => true,
            'message_id' => 'DEMO_' . uniqid(),
            'demo_mode' => true,
            'phone' => $phoneNumber,
            'message' => $message
        ];
    }
    
    /**
     * Logger les SMS envoyés
     */
    private function logSMS(string $phoneNumber, string $message, string $status, $data = null)
    {
        \DB::table('mama_ecole_sms_logs')->insert([
            'phone_number' => $phoneNumber,
            'message' => $message,
            'status' => $status,
            'response_data' => json_encode($data),
            'created_at' => now()
        ]);
    }
    
    /**
     * Obtenir le statut de livraison d'un SMS
     */
    public function getDeliveryStatus(string $messageId)
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return null;
        }
        
        try {
            $response = Http::withToken($token)->get($this->smsEndpoint . '/query/' . $messageId);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('Get Delivery Status Error: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Implémenter USSD pour interactions rapides
     */
    public function handleUSSD(string $sessionId, string $phoneNumber, string $input)
    {
        // Récupérer l'état de la session
        $session = Cache::get('ussd_session_' . $sessionId, [
            'step' => 'menu',
            'data' => []
        ]);
        
        $response = '';
        $continue = true;
        
        switch ($session['step']) {
            case 'menu':
                if (empty($input)) {
                    $response = "MAMA ECOLE\n";
                    $response .= "1. Notes de votre enfant\n";
                    $response .= "2. Présence aujourd'hui\n";
                    $response .= "3. Prochaine réunion\n";
                    $response .= "4. Messages de l'école\n";
                    $response .= "5. Vos points Learn&Earn";
                    $session['step'] = 'choice';
                } else {
                    $session['step'] = 'choice';
                }
                break;
                
            case 'choice':
                switch ($input) {
                    case '1':
                        $response = $this->getUSSDGrades($phoneNumber);
                        $continue = false;
                        break;
                    case '2':
                        $response = $this->getUSSDAttendance($phoneNumber);
                        $continue = false;
                        break;
                    case '3':
                        $response = $this->getUSSDMeeting($phoneNumber);
                        $continue = false;
                        break;
                    case '4':
                        $response = $this->getUSSDMessages($phoneNumber);
                        $continue = false;
                        break;
                    case '5':
                        $response = $this->getUSSDPoints($phoneNumber);
                        $continue = false;
                        break;
                    default:
                        $response = "Option invalide. Veuillez réessayer.";
                        $continue = false;
                }
                break;
        }
        
        // Sauvegarder la session
        if ($continue) {
            Cache::put('ussd_session_' . $sessionId, $session, 300); // 5 minutes
        } else {
            Cache::forget('ussd_session_' . $sessionId);
        }
        
        return [
            'response' => $response,
            'continue' => $continue
        ];
    }
    
    private function getUSSDGrades($phoneNumber)
    {
        // Logique pour récupérer les notes
        return "Notes de la semaine:\nMaths: 15/20\nFrançais: 12/20\nSciences: 18/20";
    }
    
    private function getUSSDAttendance($phoneNumber)
    {
        return "Présence aujourd'hui: OUI\nHeures: 8h-17h\nStatut: Bon comportement";
    }
    
    private function getUSSDMeeting($phoneNumber)
    {
        return "Prochaine réunion:\nDate: 20 Janvier 2025\nHeure: 15h\nSalle: A12";
    }
    
    private function getUSSDMessages($phoneNumber)
    {
        return "Derniers messages:\n1. Vacances du 15/02\n2. Paiement scolarité avant 30/01";
    }
    
    private function getUSSDPoints($phoneNumber)
    {
        $parent = \DB::table('parents')->where('phone_number', $phoneNumber)->first();
        
        if (!$parent) {
            return "Non inscrit à Learn&Earn";
        }
        
        $points = \DB::table('mama_ecole_rewards')
            ->where('parent_id', $parent->id)
            ->where('paid_out', false)
            ->sum('points_earned');
        
        $fcfa = $points * 10;
        
        return "Vos points: {$points}\nValeur: {$fcfa} FCFA\nProchain paiement: Fin du mois";
    }
}