<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAMA ÉCOLE - Inclusion des Parents Illettrés | {{ site_name() }}</title>
    <link rel="icon" type="image/x-icon" href="{{ site_favicon() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        .phone-animation {
            animation: ring 2s ease-in-out infinite;
        }
        @keyframes ring {
            0%, 100% { transform: rotate(0deg); }
            10%, 30% { transform: rotate(-10deg); }
            20%, 40% { transform: rotate(10deg); }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ mobileMenuOpen: false }">

    @include('partials.public-header')

    <!-- Hero Section -->
    <section class="relative py-20 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center p-4 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                    <i class="fas fa-phone-volume text-white text-4xl phone-animation"></i>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">
                    MAMA <span class="text-emerald-200">ÉCOLE</span>
                </h1>
                <p class="text-2xl text-emerald-100 mb-4">
                    Chaque parent compte, chaque enfant réussit
                </p>
                <p class="text-xl text-emerald-50 max-w-3xl mx-auto">
                    Premier système au monde qui permet aux parents illettrés de suivre 
                    la scolarité de leurs enfants par <span class="font-bold text-emerald-200">messages vocaux</span> 
                    dans leur langue maternelle
                </p>
            </div>

            <!-- Demo Live -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-16 card-hover border border-gray-100">
                <h2 class="text-2xl font-bold text-center mb-8">
                    <i class="fas fa-play-circle text-red-500 mr-2"></i>
                    Démonstration en Direct
                </h2>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Simulation Téléphone -->
                    <div class="bg-gray-900 rounded-3xl p-6 relative">
                        <div class="bg-gray-800 rounded-2xl p-4">
                            <div class="text-green-400 font-mono text-sm mb-4">
                                <i class="fas fa-phone animate-pulse mr-2"></i>Appel entrant...
                            </div>
                            <div class="bg-black rounded-lg p-4 space-y-3">
                                <div class="text-white">
                                    <span class="text-gray-400">🔊 Message vocal:</span>
                                </div>
                                <div class="text-green-300 italic">
                                    "I ni ce! I den Kouadio ye nota 15 sɔrɔ 20 la Mathématiques la."
                                </div>
                                <div class="text-gray-400 text-sm">
                                    Traduction: Bonjour! Votre enfant Kouadio a eu 15/20 en Maths.
                                </div>
                                <div class="grid grid-cols-2 gap-2 mt-4">
                                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded transition-colors">1️⃣ Répéter</button>
                                    <button class="bg-teal-600 hover:bg-teal-700 text-white py-2 rounded transition-colors">2️⃣ Détails</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques Live -->
                    <div class="space-y-6">
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-6 border border-emerald-100">
                            <h3 class="font-semibold text-gray-900 mb-4">En temps réel</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Parents connectés</span>
                                    <span class="font-bold text-emerald-600">1,234</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Appels aujourd'hui</span>
                                    <span class="font-bold text-teal-600">456</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Langues actives</span>
                                    <span class="font-bold text-emerald-600">5</span>
                                </div>
                            </div>
                        </div>

                        <!-- Langues supportées -->
                        <div class="bg-gradient-to-r from-teal-50 to-emerald-50 rounded-xl p-6 border border-teal-100">
                            <h3 class="font-semibold text-gray-900 mb-4">Langues disponibles</h3>
                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-white rounded-full text-sm">🇫🇷 Français</span>
                                <span class="px-3 py-1 bg-white rounded-full text-sm">🗣️ Dioula</span>
                                <span class="px-3 py-1 bg-white rounded-full text-sm">🗣️ Baoulé</span>
                                <span class="px-3 py-1 bg-white rounded-full text-sm">🗣️ Bété</span>
                                <span class="px-3 py-1 bg-white rounded-full text-sm">🗣️ Sénoufo</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton Test -->
                <div class="text-center mt-8">
                    <button onclick="simulateCall()" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-200 shadow-md hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-phone-alt mr-2"></i>
                        Tester un Appel Démo
                    </button>
                </div>
            </div>

            <!-- Comment ça marche -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-center mb-12">Comment ça marche ?</h2>
                <div class="grid md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="bg-gradient-to-br from-emerald-100 to-teal-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 card-hover">
                            <span class="text-2xl font-bold text-emerald-600">1</span>
                        </div>
                        <h3 class="font-semibold mb-2">Inscription Simple</h3>
                        <p class="text-sm text-gray-600">Parent donne son numéro et choisit sa langue</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-gradient-to-br from-teal-100 to-emerald-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 card-hover">
                            <span class="text-2xl font-bold text-teal-600">2</span>
                        </div>
                        <h3 class="font-semibold mb-2">École Envoie Info</h3>
                        <p class="text-sm text-gray-600">Notes, absences, réunions via dashboard</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-gradient-to-br from-emerald-100 to-teal-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 card-hover">
                            <span class="text-2xl font-bold text-emerald-600">3</span>
                        </div>
                        <h3 class="font-semibold mb-2">Appel Automatique</h3>
                        <p class="text-sm text-gray-600">Parent reçoit message vocal dans sa langue</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-gradient-to-br from-teal-100 to-emerald-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 card-hover">
                            <span class="text-2xl font-bold text-teal-600">4</span>
                        </div>
                        <h3 class="font-semibold mb-2">Interaction Simple</h3>
                        <p class="text-sm text-gray-600">Touche 1 répéter, 2 détails, 3 message</p>
                    </div>
                </div>
            </div>

            <!-- Impact Social -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-2xl p-12 mb-16 card-hover">
                <h2 class="text-3xl font-bold text-center mb-8">Impact Révolutionnaire</h2>
                <div class="grid md:grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="text-5xl font-bold mb-2">47%</div>
                        <p>Parents illettrés en CI enfin inclus</p>
                    </div>
                    <div>
                        <div class="text-5xl font-bold mb-2">+41%</div>
                        <p>Réduction abandon scolaire</p>
                    </div>
                    <div>
                        <div class="text-5xl font-bold mb-2">89%</div>
                        <p>Satisfaction des parents</p>
                    </div>
                </div>
            </div>

            <!-- Témoignages -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-center mb-12">Ce qu'ils en disent</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl p-6 shadow-lg card-hover border border-gray-100">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-300 rounded-full mr-3"></div>
                            <div>
                                <div class="font-semibold">Maman Aminata</div>
                                <div class="text-sm text-gray-500">Parent, Yopougon</div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">
                            "Maintenant je sais quand mon enfant a des problèmes à l'école. 
                            Les messages en Dioula, c'est vraiment bien!"
                        </p>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg card-hover border border-gray-100">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-300 rounded-full mr-3"></div>
                            <div>
                                <div class="font-semibold">M. Kouassi</div>
                                <div class="text-sm text-gray-500">Directeur École</div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">
                            "L'engagement des parents a explosé! Même ceux qui ne savent pas lire 
                            participent maintenant aux réunions."
                        </p>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg card-hover border border-gray-100">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-300 rounded-full mr-3"></div>
                            <div>
                                <div class="font-semibold">Dr. Diabaté</div>
                                <div class="text-sm text-gray-500">MENET-FP</div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">
                            "Une innovation majeure pour l'inclusion éducative. 
                            C'est exactement ce dont la Côte d'Ivoire avait besoin."
                        </p>
                    </div>
                </div>
            </div>

            <!-- CTA Final -->
            <div class="text-center bg-white rounded-2xl shadow-xl p-12 card-hover border border-gray-100">
                <h2 class="text-3xl font-bold mb-4">Prêt à transformer l'éducation ivoirienne ?</h2>
                <p class="text-xl text-gray-600 mb-8">
                    Rejoignez les 10 écoles pilotes qui changent déjà la vie de milliers de familles
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('mama-ecole.dashboard') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-200 shadow-md hover:shadow-xl">
                            <i class="fas fa-dashboard mr-2"></i>Accéder au Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-200 shadow-md hover:shadow-xl">
                            <i class="fas fa-school mr-2"></i>Inscrire mon École
                        </a>
                    @endauth
                    <a href="{{ route('mama-ecole.info') }}" class="bg-white border-2 border-emerald-600 text-emerald-600 px-8 py-4 rounded-xl text-lg font-semibold hover:bg-emerald-50 transition-all duration-200">
                        <i class="fas fa-info-circle mr-2"></i>En savoir plus
                    </a>
                </div>
                
                <div class="mt-8 text-sm text-gray-500">
                    <i class="fas fa-phone mr-2"></i>Contact : +225 07 XX XX XX XX | 
                    <i class="fas fa-envelope mr-2 ml-4"></i>mama.ecole@education.gouv.ci
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} {{ site_name() }} - Programme MAMA ÉCOLE</p>
        </div>
    </footer>

    <script>
        function simulateCall() {
            // Animation de simulation d'appel
            const messages = [
                { lang: 'Français', text: 'Bonjour, votre enfant a obtenu 15/20 en mathématiques.' },
                { lang: 'Dioula', text: 'I ni ce! I den ye nota 15 sɔrɔ 20 la.' },
                { lang: 'Baoulé', text: 'Akwaba. Wo ba asi 15 su 20 min.' }
            ];
            
            let index = 0;
            const interval = setInterval(() => {
                if (index < messages.length) {
                    console.log(`[${messages[index].lang}] ${messages[index].text}`);
                    // Vous pourriez ajouter une notification visuelle ici
                    index++;
                } else {
                    clearInterval(interval);
                    alert('Démonstration terminée! Dans la vraie vie, vous recevriez cet appel sur votre téléphone.');
                }
            }, 2000);
        }
    </script>
</body>
</html>