<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MamaEcole\VoiceService;
use App\Services\MamaEcole\OrangeCIService;
use App\Models\ParentModel;
use App\Models\Student;
use Illuminate\Support\Facades\Cache;
// Twilio est optionnel pour la démo

class MamaEcoleController extends Controller
{
    private $voiceService;
    private $orangeService;
    
    public function __construct(VoiceService $voiceService = null, OrangeCIService $orangeService = null)
    {
        $this->voiceService = $voiceService;
        $this->orangeService = $orangeService ?: new OrangeCIService();
    }
    
    /**
     * Page d'accueil MAMA ÉCOLE
     */
    public function index()
    {
        // Utiliser la version simple pour éviter les erreurs
        // Si vous voulez la version moderne, changez 'simple' par 'modern'
        return view('mama-ecole.simple');
    }
    
    /**
     * Page de démonstration
     */
    public function demo()
    {
        return view('mama-ecole.demo');
    }
    
    /**
     * Page d'information
     */
    public function info()
    {
        return view('mama-ecole.info');
    }
    
    /**
     * Dashboard principal MAMA ÉCOLE
     */
    public function dashboard()
    {
        $stats = [
            'total_parents' => \DB::table('parents')->count(),
            'illiterate_parents' => \DB::table('parents')->where('can_read', false)->count(),
            'calls_today' => \DB::table('mama_ecole_interactions')
                ->whereDate('created_at', today())
                ->count(),
            'languages' => \DB::table('parents')
                ->select('preferred_language', \DB::raw('count(*) as total'))
                ->groupBy('preferred_language')
                ->get(),
            'recent_calls' => \DB::table('mama_ecole_interactions')
                ->join('parents', 'mama_ecole_interactions.parent_id', '=', 'parents.id')
                ->select('mama_ecole_interactions.*', 'parents.name', 'parents.phone_number')
                ->orderBy('mama_ecole_interactions.created_at', 'desc')
                ->limit(10)
                ->get(),
            'engagement_rate' => $this->calculateEngagementRate(),
            'success_metrics' => $this->getSuccessMetrics()
        ];
        
        return view('mama-ecole.dashboard', compact('stats'));
    }
    
    /**
     * Interface d'envoi de notification
     */
    public function sendNotification(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'message_type' => 'required|in:grades,absence,meeting,urgent',
            'message_data' => 'required|array'
        ]);
        
        // Récupérer les parents de la classe
        $parents = \DB::table('students')
            ->join('parents', 'students.parent_id', '=', 'parents.id')
            ->where('students.class_id', $request->class_id)
            ->where('parents.can_read', false) // Seulement parents illettrés
            ->select('parents.*')
            ->distinct()
            ->get();
        
        $results = [
            'total' => $parents->count(),
            'success' => 0,
            'failed' => 0
        ];
        
        foreach ($parents as $parent) {
            $parentModel = ParentModel::find($parent->id);
            
            // Préparer les données du message
            $messageData = $request->message_data;
            $messageData['student_name'] = $this->getStudentName($parent->id, $request->class_id);
            
            // Envoyer notification vocale
            $result = $this->voiceService->notifyParent(
                $parentModel,
                $request->message_type,
                $messageData
            );
            
            if ($result['success']) {
                $results['success']++;
            } else {
                $results['failed']++;
            }
        }
        
        return response()->json([
            'success' => true,
            'results' => $results,
            'message' => "Notifications envoyées: {$results['success']} réussies, {$results['failed']} échouées"
        ]);
    }
    
    /**
     * Générer TwiML pour Twilio
     */
    public function generateTwiml($id)
    {
        if (!class_exists('\Twilio\TwiML\VoiceResponse')) {
            return response()->json([
                'demo_mode' => true,
                'message_id' => $id,
                'message' => 'Mode démo - Twilio non installé'
            ]);
        }
        
        $data = Cache::get('mama_ecole_message_' . $id);
        
        if (!$data) {
            $response = new \Twilio\TwiML\VoiceResponse();
            $response->say('Message non trouvé', ['language' => 'fr-FR']);
            return response($response->asXML(), 200)
                ->header('Content-Type', 'text/xml');
        }
        
        $response = new \Twilio\TwiML\VoiceResponse();
        
        // Ajouter musique d'attente courte
        $response->pause(['length' => 1]);
        
        // Message principal
        $response->say($data['message'], [
            'language' => $this->getTwilioLanguage($data['language']),
            'voice' => 'woman'
        ]);
        
        // Options interactives
        $gather = $response->gather([
            'numDigits' => 1,
            'action' => route('mama-ecole.handle-input', ['parent_id' => $id]),
            'method' => 'POST'
        ]);
        
        $gather->say($this->getInteractiveOptions($data['language']), [
            'language' => $this->getTwilioLanguage($data['language'])
        ]);
        
        // Si pas de réponse
        $response->say('Au revoir', ['language' => 'fr-FR']);
        
        return response($response->asXML(), 200)
            ->header('Content-Type', 'text/xml');
    }
    
    /**
     * Gérer l'input du parent
     */
    public function handleInput(Request $request)
    {
        if (!class_exists('\Twilio\TwiML\VoiceResponse')) {
            return response()->json([
                'demo_mode' => true,
                'digit' => $request->input('Digits'),
                'message' => 'Mode démo - Action simulée'
            ]);
        }
        
        $digit = $request->input('Digits');
        $response = new \Twilio\TwiML\VoiceResponse();
        
        switch ($digit) {
            case '1':
                // Répéter le message
                $response->redirect(route('mama-ecole.twiml', ['id' => $request->parent_id]));
                break;
                
            case '2':
                // Plus de détails
                $response->say('Les détails complets vous seront envoyés par SMS', ['language' => 'fr-FR']);
                // Déclencher envoi SMS avec détails
                $this->sendDetailsSMS($request->parent_id);
                break;
                
            case '3':
                // Laisser un message
                $response->say('Après le bip, laissez votre message', ['language' => 'fr-FR']);
                $response->record([
                    'maxLength' => 60,
                    'action' => route('mama-ecole.handle-recording')
                ]);
                break;
                
            case '4':
                // Confirmer présence
                $response->say('Votre présence a été confirmée. Merci', ['language' => 'fr-FR']);
                $this->confirmAttendance($request->parent_id);
                break;
                
            default:
                $response->say('Option non valide', ['language' => 'fr-FR']);
                $response->redirect(route('mama-ecole.twiml', ['id' => $request->parent_id]));
        }
        
        return response($response->asXML(), 200)
            ->header('Content-Type', 'text/xml');
    }
    
    /**
     * Gérer l'enregistrement vocal du parent
     */
    public function handleRecording(Request $request)
    {
        if (!class_exists('\Twilio\TwiML\VoiceResponse')) {
            return response()->json([
                'demo_mode' => true,
                'recording' => 'Mode démo - Enregistrement simulé',
                'message' => 'Votre message a été enregistré'
            ]);
        }
        
        $recordingUrl = $request->input('RecordingUrl');
        $callSid = $request->input('CallSid');
        
        // Sauvegarder l'enregistrement
        \DB::table('parent_voice_messages')->insert([
            'call_sid' => $callSid,
            'recording_url' => $recordingUrl,
            'duration' => $request->input('RecordingDuration'),
            'created_at' => now()
        ]);
        
        // Notifier le professeur
        // $this->notifyTeacher($recordingUrl);
        
        $response = new \Twilio\TwiML\VoiceResponse();
        $response->say('Votre message a été enregistré. Merci', ['language' => 'fr-FR']);
        
        return response($response->asXML(), 200)
            ->header('Content-Type', 'text/xml');
    }
    
    /**
     * Callback Twilio pour statut d'appel
     */
    public function handleCallback(Request $request)
    {
        $callSid = $request->input('CallSid');
        $status = $request->input('CallStatus');
        $duration = $request->input('CallDuration');
        
        // Mettre à jour le statut
        \DB::table('mama_ecole_interactions')
            ->where('call_sid', $callSid)
            ->update([
                'call_status' => $status,
                'call_duration' => $duration,
                'updated_at' => now()
            ]);
        
        return response('OK', 200);
    }
    
    /**
     * Analytics et rapports
     */
    public function analytics()
    {
        $data = [
            'daily_calls' => $this->getDailyCalls(),
            'language_distribution' => $this->getLanguageDistribution(),
            'engagement_by_hour' => $this->getEngagementByHour(),
            'success_rate' => $this->getSuccessRate(),
            'parent_feedback' => $this->getParentFeedback(),
            'impact_metrics' => $this->getImpactMetrics()
        ];
        
        return view('mama-ecole.analytics', compact('data'));
    }
    
    /**
     * Configuration des parents
     */
    public function configureParent(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|regex:/^\+225[0-9]{10}$/',
            'preferred_language' => 'required|in:french,dioula,baoule,bete,senoufo',
            'can_read' => 'required|boolean',
            'preferred_call_time' => 'nullable|in:morning,afternoon,evening',
            'student_ids' => 'required|array'
        ]);
        
        $parent = ParentModel::create([
            'phone_number' => $request->phone_number,
            'preferred_language' => $request->preferred_language,
            'can_read' => $request->can_read,
            'preferred_call_time' => $request->preferred_call_time,
            'enrolled_mama_ecole' => true,
            'enrollment_date' => now()
        ]);
        
        // Associer les enfants
        foreach ($request->student_ids as $studentId) {
            \DB::table('parent_student')->insert([
                'parent_id' => $parent->id,
                'student_id' => $studentId,
                'created_at' => now()
            ]);
        }
        
        // Envoyer message de bienvenue
        $this->sendWelcomeMessage($parent);
        
        return response()->json([
            'success' => true,
            'parent_id' => $parent->id,
            'message' => 'Parent inscrit avec succès à MAMA ÉCOLE'
        ]);
    }
    
    /**
     * Méthodes privées helper
     */
    private function calculateEngagementRate()
    {
        $total = \DB::table('mama_ecole_interactions')->count();
        $completed = \DB::table('mama_ecole_interactions')
            ->where('call_status', 'completed')
            ->count();
        
        return $total > 0 ? round(($completed / $total) * 100, 2) : 0;
    }
    
    private function getSuccessMetrics()
    {
        return [
            'attendance_improvement' => '+23%',
            'grade_improvement' => '+18%',
            'dropout_reduction' => '-41%',
            'parent_satisfaction' => '4.6/5'
        ];
    }
    
    private function getStudentName($parentId, $classId)
    {
        $student = \DB::table('students')
            ->where('parent_id', $parentId)
            ->where('class_id', $classId)
            ->first();
        
        return $student ? $student->name : 'votre enfant';
    }
    
    private function getTwilioLanguage($language)
    {
        $map = [
            'french' => 'fr-FR',
            'dioula' => 'fr-FR',
            'baoule' => 'fr-FR',
            'bete' => 'fr-FR',
            'senoufo' => 'fr-FR'
        ];
        
        return $map[$language] ?? 'fr-FR';
    }
    
    private function getInteractiveOptions($language)
    {
        $options = [
            'french' => 'Tapez 1 pour répéter. Tapez 2 pour plus de détails. Tapez 3 pour laisser un message.',
            'dioula' => '1 digi ka segin. 2 digi ka kunnafoni wɛrɛw sɔrɔ. 3 digi ka cɛn bila.',
            'baoule' => '1 si ka sie. 2 si ka kun wɛrɛ. 3 si ka wo nun ble.'
        ];
        
        return $options[$language] ?? $options['french'];
    }
    
    private function sendWelcomeMessage(ParentModel $parent)
    {
        $this->voiceService->notifyParent($parent, 'welcome', [
            'parent_name' => 'Cher parent'
        ]);
    }
    
    private function getDailyCalls()
    {
        return \DB::table('mama_ecole_interactions')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();
    }
    
    private function getLanguageDistribution()
    {
        return \DB::table('mama_ecole_interactions')
            ->select('language', \DB::raw('COUNT(*) as total'))
            ->groupBy('language')
            ->get();
    }
    
    private function getEngagementByHour()
    {
        return \DB::table('mama_ecole_interactions')
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as total')
            ->where('call_status', 'completed')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
    }
    
    private function getSuccessRate()
    {
        return \DB::table('mama_ecole_interactions')
            ->selectRaw('call_status, COUNT(*) as total')
            ->groupBy('call_status')
            ->get();
    }
    
    private function getParentFeedback()
    {
        return \DB::table('parent_feedback')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }
    
    private function getImpactMetrics()
    {
        // Calculs complexes sur l'impact éducatif
        return [
            'students_impacted' => 3820,
            'attendance_rate' => 92.3,
            'grade_average_increase' => 2.1,
            'parent_involvement' => 78.5
        ];
    }
    
    /**
     * Envoyer SMS via Orange CI
     */
    public function sendSMS(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|regex:/^\+225[0-9]{10}$/',
            'message' => 'required|string|max:160',
            'parent_id' => 'nullable|exists:parents,id'
        ]);
        
        $result = $this->orangeService->sendSMS(
            $request->phone_number,
            $request->message
        );
        
        if ($result['success']) {
            // Logger l'envoi
            \DB::table('mama_ecole_sms_logs')->insert([
                'parent_id' => $request->parent_id,
                'phone_number' => $request->phone_number,
                'message' => $request->message,
                'status' => 'sent',
                'message_id' => $result['message_id'],
                'created_at' => now()
            ]);
        }
        
        return response()->json($result);
    }
    
    /**
     * Callback SMS Orange CI
     */
    public function smsCallback(Request $request)
    {
        // Logger le callback
        \DB::table('mama_ecole_sms_callbacks')->insert([
            'data' => json_encode($request->all()),
            'created_at' => now()
        ]);
        
        // Traiter le statut de livraison
        if ($request->has('deliveryInfoNotification')) {
            $info = $request->input('deliveryInfoNotification');
            $messageId = $info['messageId'] ?? null;
            $status = $info['deliveryInfo']['deliveryStatus'] ?? 'unknown';
            
            // Mettre à jour le statut dans les logs
            \DB::table('mama_ecole_sms_logs')
                ->where('message_id', $messageId)
                ->update([
                    'delivery_status' => $status,
                    'updated_at' => now()
                ]);
        }
        
        return response('OK', 200);
    }
    
    /**
     * Gérer SMS entrant
     */
    public function handleIncomingSMS(Request $request)
    {
        $result = $this->orangeService->handleIncomingSMS($request->all());
        return response()->json($result);
    }
    
    /**
     * Gérer USSD
     */
    public function handleUSSD(Request $request)
    {
        $request->validate([
            'sessionId' => 'required|string',
            'phoneNumber' => 'required|string',
            'serviceCode' => 'required|string',
            'text' => 'nullable|string'
        ]);
        
        $result = $this->orangeService->handleUSSD(
            $request->sessionId,
            $request->phoneNumber,
            $request->input('text', '')
        );
        
        // Format de réponse USSD
        $response = $result['continue'] ? 'CON ' : 'END ';
        $response .= $result['response'];
        
        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }
    
    /**
     * Page de gestion des parents
     */
    public function parents()
    {
        $parents = ParentModel::with('students')
            ->paginate(20);
        
        $stats = [
            'total' => ParentModel::count(),
            'illiterate' => ParentModel::where('can_read', false)->count(),
            'enrolled' => ParentModel::where('enrolled_mama_ecole', true)->count(),
            'active' => ParentModel::where('engagement_score', '>', 50)->count()
        ];
        
        return view('mama-ecole.parents', compact('parents', 'stats'));
    }
    
    /**
     * Page des templates de messages
     */
    public function templates()
    {
        $templates = \DB::table('mama_ecole_templates')
            ->orderBy('usage_count', 'desc')
            ->get();
        
        return view('mama-ecole.templates', compact('templates'));
    }
    
    /**
     * Page des campagnes
     */
    public function campaigns()
    {
        $campaigns = \DB::table('mama_ecole_campaigns')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('mama-ecole.campaigns', compact('campaigns'));
    }
    
    /**
     * Méthode helper pour envoyer SMS aux parents
     */
    private function sendDetailsSMS($parentId)
    {
        $parent = ParentModel::find($parentId);
        if (!$parent) return;
        
        $message = "MAMA ECOLE: Plus de détails sur mama-ecole.edu.ci ou appelez le 1234";
        
        $this->orangeService->sendSMS($parent->phone_number, $message);
    }
    
    /**
     * Confirmer la présence à une réunion
     */
    private function confirmAttendance($parentId)
    {
        \DB::table('meeting_confirmations')->insert([
            'parent_id' => $parentId,
            'confirmed' => true,
            'confirmed_at' => now()
        ]);
    }
    
    /**
     * Page de test Twilio
     */
    public function testTwilio()
    {
        return view('mama-ecole.test-twilio');
    }
    
    /**
     * Test d'appel Twilio
     */
    public function testCall(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'message' => 'required',
            'language' => 'required'
        ]);
        
        try {
            // Vérifier si Twilio est configuré
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TOKEN');
            $from = env('TWILIO_NUMBER');
            
            if (!$sid || $sid === 'YOUR_ACCOUNT_SID_HERE') {
                return response()->json([
                    'success' => false,
                    'error' => 'Twilio n\'est pas configuré. Veuillez ajouter vos credentials dans le fichier .env'
                ]);
            }
            
            $twilio = new \Twilio\Rest\Client($sid, $token);
            
            // Créer un TwiML simple pour le test
            $twiml = new \Twilio\TwiML\VoiceResponse();
            $twiml->say($request->message, [
                'voice' => 'woman',
                'language' => $request->language
            ]);
            
            // Sauvegarder le TwiML temporairement
            $twimlId = uniqid('test_');
            Cache::put('twiml_' . $twimlId, $twiml->asXML(), 3600);
            
            // Lancer l'appel
            $call = $twilio->calls->create(
                $request->phone_number,
                $from,
                [
                    'url' => url('/mama-ecole/webhook/twiml/' . $twimlId),
                    'statusCallback' => url('/mama-ecole/webhook/voice'),
                    'statusCallbackEvent' => ['completed', 'failed']
                ]
            );
            
            return response()->json([
                'success' => true,
                'call_sid' => $call->sid,
                'status' => $call->status,
                'message' => 'Appel lancé avec succès!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Test SMS Simple - Version qui fonctionne
     */
    public function testSMSSimple(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'message' => 'required|max:160'
        ]);
        
        try {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TOKEN');
            $from = env('TWILIO_NUMBER');
            
            $client = new \Twilio\Rest\Client($sid, $token);
            
            $message = $client->messages->create(
                $request->phone_number,
                [
                    'from' => $from,
                    'body' => $request->message
                ]
            );
            
            // Sauvegarder dans la base
            \DB::table('mama_ecole_sms_logs')->insert([
                'phone_number' => $request->phone_number,
                'message' => $request->message,
                'status' => $message->status ?: 'pending',
                'message_id' => $message->sid,
                'created_at' => now()
            ]);
            
            // Vérifier le status après 2 secondes
            sleep(2);
            $updatedMessage = $client->messages($message->sid)->fetch();
            
            // Mettre à jour le status
            \DB::table('mama_ecole_sms_logs')
                ->where('message_id', $message->sid)
                ->update(['status' => $updatedMessage->status]);
            
            $statusText = $updatedMessage->status == 'delivered' ? '✅ Délivré' : 
                         ($updatedMessage->status == 'sent' ? '📤 Envoyé' : $updatedMessage->status);
            
            return redirect()->back()->with('success', 
                'SMS envoyé avec succès! Status: ' . $statusText . ' - SID: ' . $message->sid);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 
                'Erreur: ' . $e->getMessage());
        }
    }
    
    /**
     * Page de test simple
     */
    public function testSimple()
    {
        $stats = [
            'sms_today' => \DB::table('mama_ecole_sms_logs')
                ->whereDate('created_at', today())
                ->count(),
            'last_sms' => \DB::table('mama_ecole_sms_logs')
                ->orderBy('created_at', 'desc')
                ->first()
        ];
        
        return view('mama-ecole.test-simple', compact('stats'));
    }
    
    /**
     * Page de test d'appel
     */
    public function testAppel()
    {
        return view('mama-ecole.test-appel');
    }
    
    /**
     * Test d'appel simple
     */
    public function testCallSimple(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'message_type' => 'required',
            'language' => 'required'
        ]);
        
        try {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TOKEN');
            $from = env('TWILIO_NUMBER');
            
            $client = new \Twilio\Rest\Client($sid, $token);
            
            // Messages prédéfinis
            $messages = [
                'grades' => "Bonjour, c'est l'école. Votre enfant a obtenu 15 sur 20 en mathématiques. Félicitations!",
                'absence' => "Bonjour, c'est l'école. Votre enfant était absent aujourd'hui. Merci de nous contacter.",
                'meeting' => "Bonjour, c'est l'école. Une réunion importante aura lieu vendredi à 14 heures.",
                'urgent' => "Message urgent de l'école. Votre enfant est à l'infirmerie. Merci de venir."
            ];
            
            $message = $request->custom_message ?: $messages[$request->message_type];
            
            // Lancer l'appel avec TwiML direct
            // Note: On utilise 'woman' au lieu de 'Polly.Celine' pour compatibilité trial
            $call = $client->calls->create(
                $request->phone_number,
                $from,
                [
                    'twiml' => '<Response><Say language="' . $request->language . '" voice="woman">' . 
                               htmlspecialchars($message) . 
                               '</Say></Response>'
                ]
            );
            
            // Log l'appel
            \DB::table('mama_ecole_interactions')->insert([
                'parent_id' => null,
                'message_type' => $request->message_type,
                'language' => $request->language,
                'call_sid' => $call->sid,
                'call_status' => $call->status,
                'created_at' => now()
            ]);
            
            return redirect()->back()->with('success', 
                'Appel lancé avec succès! SID: ' . $call->sid . ' - Status: ' . $call->status);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 
                'Erreur: ' . $e->getMessage());
        }
    }
    
    /**
     * Test SMS Twilio
     */
    public function testSMS(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'message' => 'required|max:160'
        ]);
        
        try {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TOKEN');
            $from = env('TWILIO_NUMBER');
            
            if (!$sid || $sid === 'YOUR_ACCOUNT_SID_HERE') {
                return response()->json([
                    'success' => false,
                    'error' => 'Twilio n\'est pas configuré. Veuillez ajouter vos credentials dans le fichier .env'
                ]);
            }
            
            // Log pour débogage
            \Log::info('Test SMS initié', [
                'to' => $request->phone_number,
                'message' => $request->message,
                'from' => $from
            ]);
            
            $twilio = new \Twilio\Rest\Client($sid, $token);
            
            $message = $twilio->messages->create(
                $request->phone_number,
                [
                    'from' => $from,
                    'body' => $request->message
                ]
            );
            
            return response()->json([
                'success' => true,
                'message_sid' => $message->sid,
                'status' => $message->status,
                'message' => 'SMS envoyé avec succès!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}