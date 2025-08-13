<?php

namespace App\Services\MamaEcole;

use App\Models\ParentModel;
use App\Models\Student;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class VoiceService
{
    private $twilioClient;
    private $twilioNumber;
    private $languages;
    
    public function __construct()
    {
        // Twilio est optionnel pour la démo
        if (class_exists('\Twilio\Rest\Client')) {
            $this->twilioClient = new \Twilio\Rest\Client(
                config('services.twilio.sid', 'demo_sid'),
                config('services.twilio.token', 'demo_token')
            );
            $this->twilioNumber = config('services.twilio.number', '+2250000000000');
        } else {
            $this->twilioClient = null;
            $this->twilioNumber = '+2250000000000';
        }
        
        $this->languages = [
            'french' => 'fr-FR',
            'dioula' => 'custom-dioula',
            'baoule' => 'custom-baoule',
            'bete' => 'custom-bete',
            'senoufo' => 'custom-senoufo'
        ];
    }
    
    /**
     * Envoyer notification vocale au parent
     */
    public function notifyParent(ParentModel $parent, string $messageType, array $data): array
    {
        try {
            // Générer le message selon le type
            $message = $this->generateMessage($messageType, $data, $parent->preferred_language);
            
            // Mode démo si Twilio n'est pas configuré
            if (!$this->twilioClient) {
                $callSid = 'DEMO_' . uniqid();
                
                // Logger l'interaction en mode démo
                $this->logInteraction($parent, $messageType, $callSid);
                
                return [
                    'success' => true,
                    'call_sid' => $callSid,
                    'status' => 'demo',
                    'message' => $message,
                    'demo_mode' => true
                ];
            }
            
            // Créer l'URL TwiML pour le message
            $twimlUrl = $this->createTwimlUrl($message, $parent->preferred_language);
            
            // Passer l'appel
            $call = $this->twilioClient->calls->create(
                $parent->phone_number,
                $this->twilioNumber,
                [
                    'url' => $twimlUrl,
                    'statusCallback' => route('mama-ecole.callback'),
                    'statusCallbackEvent' => ['completed', 'failed'],
                    'timeout' => 60,
                    'record' => false
                ]
            );
            
            // Logger l'interaction
            $this->logInteraction($parent, $messageType, $call->sid);
            
            return [
                'success' => true,
                'call_sid' => $call->sid,
                'status' => $call->status
            ];
            
        } catch (\Exception $e) {
            Log::error('MamaEcole Voice Error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Générer le message selon le type et la langue
     */
    private function generateMessage(string $type, array $data, string $language): string
    {
        $templates = [
            'grades' => [
                'french' => "Bonjour. Votre enfant {student_name} a obtenu {grade} sur 20 en {subject}. {comment}",
                'dioula' => "I ni ce. I den {student_name} ye nota {grade} sɔrɔ 20 la {subject} la. {comment}",
                'baoule' => "Akwaba. Wo ba {student_name} asi {grade} su 20 min {subject} su. {comment}"
            ],
            'absence' => [
                'french' => "Bonjour. Votre enfant {student_name} était absent le {date}. Merci de justifier cette absence.",
                'dioula' => "I ni ce. I den {student_name} tun tɛ kalanso la {date}. I ka sabati di.",
                'baoule' => "Akwaba. Wo ba {student_name} te sukulu {date}. Fa kundo min."
            ],
            'meeting' => [
                'french' => "Bonjour. Une réunion parents-professeurs aura lieu le {date} à {time}. Votre présence est importante.",
                'dioula' => "I ni ce. Bangebaga ni karamɔgɔw ka lajɛ bɛna kɛ {date} {time} la. I ka na.",
                'baoule' => "Akwaba. Awlowle kpe fuwe be si {date} {time}. Wo ba wun."
            ],
            'urgent' => [
                'french' => "Message urgent concernant {student_name}: {message}",
                'dioula' => "Kunnafonin juguman {student_name} kan: {message}",
                'baoule' => "Kpa kple {student_name} su: {message}"
            ]
        ];
        
        // Récupérer le template
        $template = $templates[$type][$language] ?? $templates[$type]['french'];
        
        // Remplacer les variables
        foreach ($data as $key => $value) {
            $template = str_replace('{' . $key . '}', $value, $template);
        }
        
        return $template;
    }
    
    /**
     * Créer l'URL TwiML pour Twilio
     */
    private function createTwimlUrl(string $message, string $language): string
    {
        // Générer un ID unique pour ce message
        $messageId = uniqid('mama_', true);
        
        // Stocker le message en cache pour 1 heure
        Cache::put('mama_ecole_message_' . $messageId, [
            'message' => $message,
            'language' => $language
        ], 3600);
        
        // Retourner l'URL qui générera le TwiML
        return route('mama-ecole.twiml', ['id' => $messageId]);
    }
    
    /**
     * Logger l'interaction pour analytics
     */
    private function logInteraction(ParentModel $parent, string $messageType, string $callSid): void
    {
        \DB::table('mama_ecole_interactions')->insert([
            'parent_id' => $parent->id,
            'message_type' => $messageType,
            'language' => $parent->preferred_language,
            'call_sid' => $callSid,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
    
    /**
     * Appel interactif avec réponse clavier
     */
    public function interactiveCall(ParentModel $parent, array $options): array
    {
        if (!class_exists('\Twilio\TwiML\VoiceResponse')) {
            return [
                'demo_mode' => true,
                'parent_id' => $parent->id,
                'message' => $this->generateInteractiveMenu($parent->preferred_language, $options)
            ];
        }
        
        $twiml = new \Twilio\TwiML\VoiceResponse();
        
        // Message d'accueil
        $gather = $twiml->gather([
            'numDigits' => 1,
            'action' => route('mama-ecole.handle-input'),
            'method' => 'POST',
            'timeout' => 10,
            'language' => $this->getVoiceLanguage($parent->preferred_language)
        ]);
        
        // Options vocales
        $gather->say($this->generateInteractiveMenu($parent->preferred_language, $options));
        
        // Si pas de réponse, raccrocher
        $twiml->say($this->getNoResponseMessage($parent->preferred_language));
        
        return [
            'twiml' => $twiml->asXML(),
            'parent_id' => $parent->id
        ];
    }
    
    /**
     * Générer menu interactif
     */
    private function generateInteractiveMenu(string $language, array $options): string
    {
        $menus = [
            'french' => "Pour écouter les notes, tapez 1. Pour confirmer votre présence à la réunion, tapez 2. Pour laisser un message, tapez 3.",
            'dioula' => "Nota mɛnni walasa, 1 digi. Lajɛ la i bɛ na walasa, 2 digi. Cɛn bila walasa, 3 digi.",
            'baoule' => "Nota se wun man, si 1. Kpe wun be man, si 2. Wo nun ble man, si 3."
        ];
        
        return $menus[$language] ?? $menus['french'];
    }
    
    /**
     * Message si pas de réponse
     */
    private function getNoResponseMessage(string $language): string
    {
        $messages = [
            'french' => "Nous n'avons pas reçu de réponse. Au revoir.",
            'dioula' => "Jaabi ma sɔrɔ. K'an bɛn.",
            'baoule' => "Gbessi te. Akpe."
        ];
        
        return $messages[$language] ?? $messages['french'];
    }
    
    /**
     * Obtenir la voix Twilio pour la langue
     */
    private function getVoiceLanguage(string $language): string
    {
        // Pour les langues locales, on utilise le français avec accent adapté
        $voiceMap = [
            'french' => 'fr-FR',
            'dioula' => 'fr-FR',  // Utiliser voix française pour l'instant
            'baoule' => 'fr-FR',
            'bete' => 'fr-FR',
            'senoufo' => 'fr-FR'
        ];
        
        return $voiceMap[$language] ?? 'fr-FR';
    }
    
    /**
     * Envoyer notification en masse
     */
    public function bulkNotify(array $parentIds, string $messageType, array $data): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'details' => []
        ];
        
        foreach ($parentIds as $parentId) {
            $parent = ParentModel::find($parentId);
            
            if (!$parent) {
                $results['failed']++;
                continue;
            }
            
            $result = $this->notifyParent($parent, $messageType, $data);
            
            if ($result['success']) {
                $results['success']++;
            } else {
                $results['failed']++;
            }
            
            $results['details'][] = [
                'parent_id' => $parentId,
                'status' => $result['success'] ? 'success' : 'failed',
                'call_sid' => $result['call_sid'] ?? null
            ];
            
            // Délai pour éviter surcharge
            usleep(500000); // 0.5 seconde entre chaque appel
        }
        
        return $results;
    }
}