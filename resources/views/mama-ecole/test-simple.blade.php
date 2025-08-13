<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test SMS - MAMA ÉCOLE</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    
    @include('partials.public-header')
    
    <!-- Header Section -->
    <section class="relative py-12 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-100 to-teal-100 opacity-30"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Test SMS - MAMA ÉCOLE</h1>
                    <p class="text-lg text-gray-600">Envoyez des SMS de test aux parents</p>
                </div>
                <a href="{{ route('mama-ecole.index') }}" class="glass px-6 py-3 rounded-lg hover:bg-white transition text-gray-700 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl shadow-xl p-8 max-w-3xl mx-auto border border-gray-100">
            
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                        <p class="text-emerald-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('mama-ecole.test.sms.simple') }}" method="POST">
                @csrf
                
                <!-- Numéro de téléphone -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-3 text-lg">
                        <i class="fas fa-phone text-emerald-500 mr-2"></i>
                        Numéro de téléphone
                    </label>
                    <input type="text" 
                           name="phone_number" 
                           value="+33752353581"
                           class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-lg focus:border-emerald-500 focus:outline-none transition"
                           placeholder="+33612345678">
                    <p class="text-sm text-gray-500 mt-2 flex items-center">
                        <i class="fas fa-info-circle mr-1"></i>
                        Format international requis (ex: +33... ou +225...)
                    </p>
                </div>

                <!-- Message prédéfini ou personnalisé -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-3 text-lg">
                        <i class="fas fa-comment-dots text-teal-500 mr-2"></i>
                        Message à envoyer
                    </label>
                    
                    <!-- Messages prédéfinis -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                        <button type="button" onclick="setMessage('Bonjour, votre enfant a obtenu 15 sur 20 en mathématiques. Félicitations!')" 
                                class="text-left p-3 border-2 border-gray-200 rounded-lg hover:border-emerald-500 hover:bg-emerald-50 transition">
                            <div class="font-semibold text-emerald-600">📚 Notes</div>
                            <div class="text-sm text-gray-600">Note de l'élève</div>
                        </button>
                        
                        <button type="button" onclick="setMessage('Bonjour, votre enfant était absent aujourd\'hui. Merci de nous contacter.')" 
                                class="text-left p-3 border-2 border-gray-200 rounded-lg hover:border-red-500 hover:bg-red-50 transition">
                            <div class="font-semibold text-red-600">🚨 Absence</div>
                            <div class="text-sm text-gray-600">Absence signalée</div>
                        </button>
                        
                        <button type="button" onclick="setMessage('Bonjour, une réunion importante aura lieu vendredi à 14 heures.')" 
                                class="text-left p-3 border-2 border-gray-200 rounded-lg hover:border-yellow-500 hover:bg-yellow-50 transition">
                            <div class="font-semibold text-yellow-600">📅 Réunion</div>
                            <div class="text-sm text-gray-600">Convocation parents</div>
                        </button>
                        
                        <button type="button" onclick="setMessage('Message urgent de l\'école. Votre enfant est à l\'infirmerie.')" 
                                class="text-left p-3 border-2 border-gray-200 rounded-lg hover:border-orange-500 hover:bg-orange-50 transition">
                            <div class="font-semibold text-orange-600">⚠️ Urgent</div>
                            <div class="text-sm text-gray-600">Message urgent</div>
                        </button>
                    </div>
                    
                    <textarea name="message" 
                              id="message"
                              rows="4" 
                              maxlength="160"
                              class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-lg focus:border-emerald-500 focus:outline-none transition"
                              placeholder="Tapez votre message ici...">Bonjour, c'est Mama École. Votre enfant a obtenu 15 sur 20 en maths. Félicitations!</textarea>
                    <div class="flex justify-between mt-2">
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Maximum 160 caractères
                        </p>
                        <p class="text-sm text-gray-500">
                            <span id="charCount">0</span>/160
                        </p>
                    </div>
                </div>

                <!-- Bouton d'envoi -->
                <div class="flex justify-center">
                    <button type="submit" 
                            class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-10 py-4 rounded-full text-lg font-semibold hover:from-emerald-600 hover:to-teal-600 transform hover:scale-105 transition shadow-lg">
                        <i class="fas fa-paper-plane mr-3"></i>
                        Envoyer SMS de Test
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Statistiques -->
        @php
            $stats = [
                'sms_today' => \DB::table('mama_ecole_sms_logs')->whereDate('created_at', today())->count(),
                'last_sms' => \DB::table('mama_ecole_sms_logs')->orderBy('created_at', 'desc')->first()
            ];
        @endphp
        
        <div class="max-w-3xl mx-auto mt-8">
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl p-6 border border-emerald-200">
                <h3 class="font-bold text-lg mb-4 text-gray-800">
                    <i class="fas fa-chart-bar text-emerald-500 mr-2"></i>
                    Statistiques du jour
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white rounded-lg p-4">
                        <div class="text-2xl font-bold text-emerald-600">{{ $stats['sms_today'] }}</div>
                        <div class="text-sm text-gray-600">SMS envoyés aujourd'hui</div>
                    </div>
                    <div class="bg-white rounded-lg p-4">
                        @if(isset($stats['last_sms']) && is_object($stats['last_sms']))
                            <div class="text-sm font-semibold text-gray-700">Dernier SMS</div>
                            <div class="text-xs text-gray-500 mt-1">{{ substr($stats['last_sms']->message, 0, 50) }}...</div>
                            <div class="mt-2">
                                @if($stats['last_sms']->status == 'delivered' || $stats['last_sms']->status == 'sent')
                                    <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        {{ $stats['last_sms']->status }}
                                    </span>
                                @else
                                    <span class="inline-block bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $stats['last_sms']->status }}
                                    </span>
                                @endif
                            </div>
                        @else
                            <div class="text-gray-400">
                                <i class="fas fa-inbox text-2xl"></i>
                                <div class="text-sm mt-1">Aucun SMS envoyé</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Info -->
        <div class="max-w-3xl mx-auto mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-yellow-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>Mode Test Twilio</strong> - Les SMS sont envoyés via Twilio Trial. 
                        Seuls les numéros vérifiés peuvent recevoir des messages.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setMessage(msg) {
            document.getElementById('message').value = msg;
            updateCharCount();
        }
        
        function updateCharCount() {
            const msg = document.getElementById('message').value;
            document.getElementById('charCount').textContent = msg.length;
        }
        
        document.getElementById('message').addEventListener('input', updateCharCount);
        updateCharCount();
    </script>
</body>
</html>