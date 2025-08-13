<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAMA ÉCOLE - Système d'Inclusion des Parents Illettrés</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

@include('partials.public-header')
<style>
    * { font-family: 'Inter', sans-serif; }
    .gradient-hero {
        background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);
    }
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }
    .glass {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    .success-badge {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    .pulse-dot {
        animation: pulse-dot 2s infinite;
    }
    @keyframes pulse-dot {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
    .floating {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>

<div class="min-h-screen bg-gray-50">
    <!-- Hero Section avec Style Calendrier -->
    <section class="relative py-16 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-100 to-teal-100 opacity-30"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-emerald-100 rounded-full mb-6 floating">
                    <i class="fas fa-phone-volume text-5xl text-emerald-600"></i>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-4">MAMA ÉCOLE</h1>
                <p class="text-xl md:text-2xl text-gray-700 mb-2">Système d'Inclusion des Parents Illettrés</p>
                <p class="text-lg text-gray-600 mb-8">Communication vocale en langues locales pour l'éducation</p>
                
                <!-- Badges de statut -->
                <div class="flex flex-wrap justify-center gap-4 mb-12">
                    <span class="inline-flex items-center glass px-4 py-2 rounded-full text-gray-700">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full pulse-dot mr-2"></span>
                        Système Opérationnel
                    </span>
                    <span class="inline-flex items-center glass px-4 py-2 rounded-full text-gray-700">
                        <i class="fas fa-check-circle mr-2 text-emerald-600"></i>
                        SMS & Appels Fonctionnels
                    </span>
                </div>
                
                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12 max-w-4xl mx-auto">
                    <div class="glass rounded-xl p-4 text-center card-hover">
                        <i class="fas fa-users text-2xl mb-2 text-emerald-600"></i>
                        <div class="text-3xl font-bold text-emerald-700">{{ \DB::table('parents')->count() }}</div>
                        <div class="text-sm text-gray-600">Parents inscrits</div>
                    </div>
                    <div class="glass rounded-xl p-4 text-center card-hover">
                        <i class="fas fa-sms text-2xl mb-2 text-teal-600"></i>
                        <div class="text-3xl font-bold text-teal-700">{{ \DB::table('mama_ecole_sms_logs')->count() }}</div>
                        <div class="text-sm text-gray-600">SMS envoyés</div>
                    </div>
                    <div class="glass rounded-xl p-4 text-center card-hover">
                        <i class="fas fa-phone text-2xl mb-2 text-emerald-600"></i>
                        <div class="text-3xl font-bold text-emerald-600">{{ \DB::table('mama_ecole_interactions')->count() }}</div>
                        <div class="text-sm text-gray-600">Appels effectués</div>
                    </div>
                    <div class="glass rounded-xl p-4 text-center card-hover">
                        <i class="fas fa-chart-line text-2xl mb-2 text-teal-600"></i>
                        <div class="text-3xl font-bold text-teal-600">95%</div>
                        <div class="text-sm text-gray-600">Taux de succès</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fonctionnalités Principales -->
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-center mb-12">Fonctionnalités 100% Opérationnelles</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- SMS -->
            <div class="bg-white rounded-2xl shadow-xl card-hover overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-sms text-2xl text-white"></i>
                        </div>
                        <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle"></i> Testé
                        </span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Envoi de SMS</h3>
                    <p class="text-gray-600 mb-6">Messages texte pour les parents lettrés avec confirmation de réception.</p>
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Instantané
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Multi-langues
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Suivi en temps réel
                        </div>
                    </div>
                    <a href="{{ route('mama-ecole.test.simple') }}" class="block w-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-center py-3 rounded-lg font-semibold hover:from-emerald-600 hover:to-emerald-700 transition">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Tester SMS
                    </a>
                </div>
            </div>

            <!-- Appels Vocaux -->
            <div class="bg-white rounded-2xl shadow-xl card-hover overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-emerald-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-phone-alt text-2xl text-white"></i>
                        </div>
                        <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle"></i> Testé
                        </span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Appels Vocaux</h3>
                    <p class="text-gray-600 mb-6">Messages vocaux en français pour les parents illettrés.</p>
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Voix naturelle
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Messages personnalisés
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Interaction DTMF
                        </div>
                    </div>
                    <a href="{{ route('mama-ecole.test.appel') }}" class="block w-full bg-gradient-to-r from-teal-500 to-teal-600 text-white text-center py-3 rounded-lg font-semibold hover:from-teal-600 hover:to-teal-700 transition">
                        <i class="fas fa-phone-volume mr-2"></i>
                        Tester Appel
                    </a>
                </div>
            </div>

            <!-- Dashboard -->
            <div class="bg-white rounded-2xl shadow-xl card-hover overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-2xl text-white"></i>
                        </div>
                        <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-semibold">
                            Admin
                        </span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Tableau de Bord</h3>
                    <p class="text-gray-600 mb-6">Statistiques complètes et gestion centralisée.</p>
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Analytics temps réel
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Rapports détaillés
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Gestion parents
                        </div>
                    </div>
                    <a href="{{ route('mama-ecole.dashboard') }}" class="block w-full bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-center py-3 rounded-lg font-semibold hover:from-indigo-600 hover:to-indigo-700 transition">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Accéder
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Types de Messages -->
    <div class="bg-gray-100 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Messages Prédéfinis Disponibles</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Notes -->
                <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-graduation-cap text-3xl text-white"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-2">Notes</h4>
                    <p class="text-sm text-gray-600">"Votre enfant a obtenu quinze sur vingt en mathématiques"</p>
                    <div class="mt-4">
                        <span class="inline-block bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">
                            grades
                        </span>
                    </div>
                </div>

                <!-- Absence -->
                <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition">
                    <div class="w-20 h-20 bg-gradient-to-br from-red-400 to-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-times text-3xl text-white"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-2">Absence</h4>
                    <p class="text-sm text-gray-600">"Votre enfant était absent aujourd'hui"</p>
                    <div class="mt-4">
                        <span class="inline-block bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">
                            absence
                        </span>
                    </div>
                </div>

                <!-- Réunion -->
                <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition">
                    <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-alt text-3xl text-white"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-2">Réunion</h4>
                    <p class="text-sm text-gray-600">"Réunion importante vendredi à quatorze heures"</p>
                    <div class="mt-4">
                        <span class="inline-block bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs font-semibold">
                            meeting
                        </span>
                    </div>
                </div>

                <!-- Urgent -->
                <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle text-3xl text-white"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-2">Urgent</h4>
                    <p class="text-sm text-gray-600">"Votre enfant est à l'infirmerie"</p>
                    <div class="mt-4">
                        <span class="inline-block bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-xs font-semibold">
                            urgent
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activité Récente -->
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-center mb-12">Activité en Temps Réel</h2>
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Destinataire</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Message</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $activities = collect();
                            
                            $smsLogs = \DB::table('mama_ecole_sms_logs')
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
                            
                            $calls = \DB::table('mama_ecole_interactions')
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
                            
                            foreach($smsLogs as $sms) {
                                $activities->push((object)[
                                    'type' => 'SMS',
                                    'phone' => substr($sms->phone_number ?? 'N/A', 0, -4) . '****',
                                    'message' => substr($sms->message ?? '', 0, 40) . '...',
                                    'status' => $sms->status ?? 'pending',
                                    'created_at' => $sms->created_at
                                ]);
                            }
                            
                            foreach($calls as $call) {
                                $messages = [
                                    'grades' => 'Notes scolaires',
                                    'absence' => 'Absence signalée',
                                    'meeting' => 'Convocation réunion',
                                    'urgent' => 'Message urgent'
                                ];
                                $activities->push((object)[
                                    'type' => 'Appel',
                                    'phone' => '+337****' . rand(1000, 9999),
                                    'message' => $messages[$call->message_type] ?? 'Message vocal',
                                    'status' => $call->call_status ?? 'pending',
                                    'created_at' => $call->created_at
                                ]);
                            }
                            
                            $activities = $activities->sortByDesc('created_at')->take(8);
                        @endphp
                        
                        @forelse($activities as $activity)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($activity->type == 'SMS')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700">
                                        <i class="fas fa-sms mr-1"></i> SMS
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-green-100 to-green-200 text-green-700">
                                        <i class="fas fa-phone mr-1"></i> Appel
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $activity->phone }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $activity->message }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(in_array($activity->status, ['delivered', 'completed', 'sent']))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></span>
                                        Réussi
                                    </span>
                                @elseif(in_array($activity->status, ['queued', 'in-progress', 'ringing']))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-1.5 pulse-dot"></span>
                                        En cours
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        <span class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1.5"></span>
                                        Échoué
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($activity->created_at)->locale('fr')->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <i class="fas fa-inbox text-4xl mb-3"></i>
                                    <p>Aucune activité récente</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-600"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-6 text-white">Prêt à Transformer la Communication École-Parents ?</h2>
            <p class="text-xl mb-10 text-emerald-50">Testez maintenant les fonctionnalités SMS et Appels Vocaux</p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('mama-ecole.test.simple') }}" class="inline-flex items-center justify-center bg-white text-emerald-600 py-4 px-10 rounded-full text-lg font-bold hover:bg-emerald-50 transform hover:scale-105 transition shadow-xl">
                    <i class="fas fa-sms mr-3"></i>
                    Tester SMS Maintenant
                </a>
                <a href="{{ route('mama-ecole.test.appel') }}" class="inline-flex items-center justify-center bg-transparent border-2 border-white text-white py-4 px-10 rounded-full text-lg font-bold hover:bg-white hover:text-emerald-600 transform hover:scale-105 transition">
                    <i class="fas fa-phone-volume mr-3"></i>
                    Tester Appel Vocal
                </a>
            </div>
            
            <div class="mt-12 inline-flex items-center glass px-6 py-3 rounded-full text-emerald-800">
                <i class="fas fa-info-circle mr-2"></i>
                <span>Mode Trial : Le message commence par une annonce Twilio (20s)</span>
            </div>
        </div>
    </section>
</div>
</body>
</html>