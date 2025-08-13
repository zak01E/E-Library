<?php

return [
    /**
     * Configuration MAMA ÉCOLE
     */
    
    // Mode de fonctionnement
    'mode' => env('MAMA_ECOLE_MODE', 'demo'), // 'demo' ou 'production'
    
    // Configuration Twilio
    'twilio' => [
        'sid' => env('TWILIO_SID', 'DEMO_SID'),
        'token' => env('TWILIO_TOKEN', 'DEMO_TOKEN'),
        'number' => env('TWILIO_NUMBER', '+2250000000000'),
        'webhook_url' => env('TWILIO_WEBHOOK_URL', config('app.url') . '/mama-ecole/webhook'),
    ],
    
    // Configuration Orange CI API (pour SMS)
    'orange' => [
        'api_key' => env('ORANGE_API_KEY'),
        'api_secret' => env('ORANGE_API_SECRET'),
        'sender_name' => env('ORANGE_SENDER_NAME', 'MAMA ECOLE'),
    ],
    
    // Langues supportées
    'languages' => [
        'french' => 'Français',
        'dioula' => 'Dioula',
        'baoule' => 'Baoulé',
        'bete' => 'Bété',
        'senoufo' => 'Sénoufo',
    ],
    
    // Horaires d'appel autorisés
    'call_times' => [
        'morning' => ['start' => '08:00', 'end' => '12:00'],
        'afternoon' => ['start' => '14:00', 'end' => '18:00'],
        'evening' => ['start' => '18:30', 'end' => '20:30'],
    ],
    
    // Paramètres de récompenses LEARN & EARN
    'rewards' => [
        'listen_full' => 50,        // Points pour écoute complète
        'attend_meeting' => 200,    // Points pour présence réunion
        'respond_survey' => 100,    // Points pour réponse enquête
        'child_improvement' => 500, // Points pour amélioration enfant
        'refer_parent' => 150,      // Points pour parrainage
        'complete_training' => 300, // Points pour formation complète
        'points_to_fcfa' => 10,     // 1 point = 10 FCFA
    ],
    
    // Paramètres de notification
    'notifications' => [
        'max_retries' => 3,
        'retry_delay' => 300, // 5 minutes en secondes
        'batch_size' => 50,
        'rate_limit' => 100, // Appels par minute
    ],
    
    // Messages système
    'messages' => [
        'welcome' => [
            'french' => "Bienvenue sur MAMA ÉCOLE, le système qui vous aide à suivre la scolarité de votre enfant.",
            'dioula' => "Aw ni ce MAMA ÉCOLE la, système min bɛ aw dɛmɛ ka aw den ka kalanso kɔlɔsi.",
        ],
        'no_response' => [
            'french' => "Nous n'avons pas reçu de réponse. Au revoir.",
            'dioula' => "Jaabi ma sɔrɔ. K'an bɛn.",
        ],
    ],
];