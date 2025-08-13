<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Appel Vocal - MAMA ÉCOLE</title>
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
        <div class="absolute inset-0 bg-gradient-to-r from-teal-100 to-emerald-100 opacity-30"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Test Appel Vocal - MAMA ÉCOLE</h1>
                    <p class="text-lg text-gray-600">Envoyez des messages vocaux aux parents illettrés</p>
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

            <form action="{{ route('mama-ecole.test.call.simple') }}" method="POST">
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

                <!-- Type de message -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-3 text-lg">
                        <i class="fas fa-list text-teal-500 mr-2"></i>
                        Type de message
                    </label>
                    <select name="message_type" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-lg focus:border-teal-500 focus:outline-none transition">
                        <option value="grades">📝 Notes de l'élève</option>
                        <option value="absence">🚨 Absence signalée</option>
                        <option value="meeting">📅 Convocation réunion</option>
                        <option value="urgent">⚠️ Message urgent</option>
                    </select>
                </div>

                <!-- Langue -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-3 text-lg">
                        <i class="fas fa-language text-indigo-500 mr-2"></i>
                        Langue
                    </label>
                    <select name="language" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-lg focus:border-indigo-500 focus:outline-none transition">
                        <option value="fr-FR">🇫🇷 Français</option>
                        <option value="en-US">🇬🇧 Anglais</option>
                    </select>
                </div>

                <!-- Message personnalisé -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-3 text-lg">
                        <i class="fas fa-comment-dots text-emerald-500 mr-2"></i>
                        Message personnalisé (optionnel)
                    </label>
                    <textarea name="custom_message" 
                              rows="3" 
                              class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-lg focus:border-emerald-500 focus:outline-none transition"
                              placeholder="Laissez vide pour utiliser le message par défaut">Bonjour, votre enfant a obtenu 15 sur 20 en mathématiques. Félicitations!</textarea>
                </div>

                <!-- Bouton d'envoi -->
                <div class="flex justify-center">
                    <button type="submit" 
                            class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-10 py-4 rounded-full text-lg font-semibold hover:from-emerald-600 hover:to-teal-600 transform hover:scale-105 transition shadow-lg">
                        <i class="fas fa-phone-volume mr-3"></i>
                        Lancer l'Appel Vocal
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Informations -->
        <div class="max-w-3xl mx-auto mt-8">
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl p-6 border border-emerald-200">
                <h3 class="font-bold text-lg mb-3 text-gray-800">
                    <i class="fas fa-info-circle text-emerald-500 mr-2"></i>
                    Informations
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-emerald-500 mt-1 mr-2"></i>
                        <div>
                            <div class="font-semibold text-gray-700">Appels vocaux Twilio</div>
                            <div class="text-sm text-gray-600">Technologie fiable et éprouvée</div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-emerald-500 mt-1 mr-2"></i>
                        <div>
                            <div class="font-semibold text-gray-700">Message en français</div>
                            <div class="text-sm text-gray-600">Prononciation naturelle</div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-emerald-500 mt-1 mr-2"></i>
                        <div>
                            <div class="font-semibold text-gray-700">Compte Trial</div>
                            <div class="text-sm text-gray-600">Numéros vérifiés uniquement</div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-emerald-500 mt-1 mr-2"></i>
                        <div>
                            <div class="font-semibold text-gray-700">Coût réduit</div>
                            <div class="text-sm text-gray-600">~0.10€/min (gratuit en trial)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Limitations -->
        <div class="max-w-3xl mx-auto mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="font-bold text-yellow-800 mb-2">Limitations compte Trial</h3>
                    <ul class="text-sm text-yellow-700 space-y-1">
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Seul le numéro +33752353581 est vérifié</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Message commence par "Sent from your Twilio trial account" (20 secondes)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Pour tester avec d'autres numéros, vérifiez-les dans Twilio Console</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>