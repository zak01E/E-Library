<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>MAMA ÉCOLE - Révolution Éducative | E-Library CI</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.9); opacity: 1; }
            100% { transform: scale(1.3); opacity: 0; }
        }
        .notification-slide {
            animation: slideIn 0.5s ease-out;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .wave {
            animation: wave 2.5s ease-in-out infinite;
        }
        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            20%, 60% { transform: rotate(-25deg); }
            40%, 80% { transform: rotate(10deg); }
        }
        .terminal-text {
            font-family: 'Courier New', monospace;
            text-shadow: 0 0 10px rgba(74, 222, 128, 0.5);
        }
        .gradient-border {
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe, #a5b4fc);
            padding: 2px;
            border-radius: 20px;
        }
        .hero-bg {
            background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 50%, #c7d2fe 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            animation: move 20s linear infinite;
        }
        @keyframes move {
            0% { transform: translate(0, 0); }
            100% { transform: translate(20px, 20px); }
        }
    </style>
</head>
<body class="bg-gray-50 overflow-x-hidden">

    <!-- Hero Section Moderne -->
    <section class="hero-bg text-gray-800 min-h-screen relative">
        <!-- Navigation flottante -->
        <nav class="absolute top-0 left-0 right-0 z-50 p-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <a href="{{ route('home') }}" class="bg-white/80 backdrop-blur px-4 py-2 rounded-full text-gray-700 hover:bg-white transition shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i>Accueil
                </a>
                <div class="flex gap-4">
                    @auth
                        <a href="{{ route('mama-ecole.dashboard') }}" class="bg-white/80 backdrop-blur px-6 py-2 rounded-full text-gray-700 hover:bg-white transition shadow-md">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-emerald-600 text-white px-6 py-2 rounded-full font-semibold hover:bg-emerald-700 transition shadow-lg">
                            Commencer
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Contenu Hero -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 pt-32 pb-20">
            <div class="text-center mb-16">
                <!-- Badge animé -->
                <div class="inline-flex items-center bg-white/90 backdrop-blur px-6 py-3 rounded-full mb-8 shadow-lg">
                    <span class="pulse-ring absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex items-center text-gray-700">
                        <i class="fas fa-star text-amber-500 mr-2"></i>
                        Innovation Primée 2025
                        <i class="fas fa-star text-amber-500 ml-2"></i>
                    </span>
                </div>

                <!-- Titre principal -->
                <h1 class="text-6xl md:text-8xl font-bold mb-6" style="font-family: 'Space Grotesk', sans-serif;">
                    MAMA ÉCOLE
                </h1>
                <p class="text-2xl md:text-3xl mb-4 text-gray-600">
                    L'inclusion par la voix
                </p>
                <p class="text-xl max-w-3xl mx-auto text-gray-600">
                    Premier système mondial permettant aux parents illettrés de suivre 
                    la scolarité de leurs enfants par <span class="font-bold text-emerald-600">messages vocaux</span> 
                    dans leur langue maternelle
                </p>

                <!-- Statistiques animées -->
                <div class="grid grid-cols-3 gap-8 max-w-2xl mx-auto mt-12">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-emerald-600 floating">47%</div>
                        <div class="text-sm text-gray-600">Parents illettrés inclus</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-emerald-600 floating" style="animation-delay: 0.5s;">+89%</div>
                        <div class="text-sm text-gray-600">Engagement parental</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-violet-600 floating" style="animation-delay: 1s;">-41%</div>
                        <div class="text-sm text-gray-600">Abandon scolaire</div>
                    </div>
                </div>
            </div>

            <!-- Démo Interactive Moderne -->
            <div class="grid lg:grid-cols-2 gap-8 items-center px-4 sm:px-6">
                <!-- Simulation iPhone -->
                <div class="relative mx-auto w-full max-w-sm">
                    <div class="bg-gray-900 rounded-[2.5rem] sm:rounded-[3rem] p-4 sm:p-6 shadow-2xl mx-auto border-4 sm:border-8 border-gray-800">
                        <!-- Notch -->
                        <div class="absolute top-4 sm:top-6 left-1/2 transform -translate-x-1/2 w-24 sm:w-32 h-4 sm:h-6 bg-gray-900 rounded-full"></div>
                        
                        <!-- Écran -->
                        <div class="bg-black rounded-[1.5rem] sm:rounded-[2rem] p-3 sm:p-4 h-[500px] sm:h-[600px] relative overflow-hidden">
                            <!-- Status bar -->
                            <div class="flex justify-between text-white text-xs mb-4 opacity-70">
                                <span>9:41</span>
                                <span><i class="fas fa-signal mr-1"></i><i class="fas fa-wifi mr-1"></i><i class="fas fa-battery-full"></i></span>
                            </div>

                            <!-- Interface d'appel -->
                            <div id="callInterface" class="text-white">
                                <div class="text-center mb-8">
                                    <div class="text-sm text-gray-400 mb-2">Appel entrant</div>
                                    <div class="text-2xl font-bold mb-1">MAMA ÉCOLE</div>
                                    <div class="text-sm text-gray-400">+225 07 00 00 00 00</div>
                                </div>

                                <!-- Avatar animé -->
                                <div class="relative w-24 sm:w-32 h-24 sm:h-32 mx-auto mb-6 sm:mb-8">
                                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-violet-400 rounded-full pulse-ring"></div>
                                    <div class="relative w-24 sm:w-32 h-24 sm:h-32 bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-phone-volume text-3xl sm:text-4xl text-white wave"></i>
                                    </div>
                                </div>

                                <!-- Message vocal -->
                                <div class="bg-gray-800 rounded-xl sm:rounded-2xl p-3 sm:p-4 mb-4 sm:mb-6">
                                    <div class="flex items-center mb-3">
                                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse mr-2"></div>
                                        <span class="text-green-400 text-sm terminal-text">Message vocal en cours...</span>
                                    </div>
                                    <div id="voiceMessage" class="text-green-300 italic mb-3 hidden">
                                        "I ni ce! I den Kouadio ye nota 15 sɔrɔ 20 la Mathématiques la."
                                    </div>
                                    <div id="translation" class="text-gray-400 text-sm hidden">
                                        <i class="fas fa-language mr-2"></i>Bonjour! Votre enfant Kouadio a eu 15/20 en Maths.
                                    </div>
                                </div>

                                <!-- Boutons d'action -->
                                <div class="grid grid-cols-2 gap-2 sm:gap-4">
                                    <button onclick="replayMessage()" class="bg-gray-700 hover:bg-gray-600 text-white py-2 sm:py-3 rounded-xl sm:rounded-2xl transition text-sm sm:text-base">
                                        <i class="fas fa-redo mr-1 sm:mr-2"></i>Répéter
                                    </button>
                                    <button onclick="getDetails()" class="bg-gray-700 hover:bg-gray-600 text-white py-2 sm:py-3 rounded-xl sm:rounded-2xl transition text-sm sm:text-base">
                                        <i class="fas fa-info-circle mr-1 sm:mr-2"></i>Détails
                                    </button>
                                </div>

                                <!-- Boutons principaux -->
                                <div class="absolute bottom-4 sm:bottom-8 left-3 right-3 sm:left-4 sm:right-4 grid grid-cols-2 gap-3 sm:gap-4">
                                    <button onclick="declineCall()" class="bg-red-500 hover:bg-red-600 text-white py-3 sm:py-4 rounded-full transition">
                                        <i class="fas fa-phone-slash"></i>
                                    </button>
                                    <button onclick="answerCall()" class="bg-green-500 hover:bg-green-600 text-white py-3 sm:py-4 rounded-full transition">
                                        <i class="fas fa-phone"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panneau de contrôle -->
                <div class="space-y-4 sm:space-y-6 mt-8 lg:mt-0">
                    <div class="bg-white/90 backdrop-blur rounded-2xl sm:rounded-3xl p-6 sm:p-8 shadow-xl">
                        <h3 class="text-2xl font-bold mb-6 flex items-center text-gray-800">
                            <i class="fas fa-rocket text-emerald-500 mr-3"></i>
                            Testez la Démo
                        </h3>
                        
                        <!-- Sélection de langue -->
                        <div class="mb-4 sm:mb-6">
                            <label class="text-sm text-gray-600 mb-2 block">Choisir la langue</label>
                            <div class="grid grid-cols-2 gap-2 sm:gap-3">
                                <button onclick="setLanguage('dioula')" class="bg-gray-100 hover:bg-gray-200 px-3 sm:px-4 py-2 rounded-lg sm:rounded-xl transition text-xs sm:text-sm text-gray-700">
                                    🗣️ Dioula
                                </button>
                                <button onclick="setLanguage('baoule')" class="bg-gray-100 hover:bg-gray-200 px-3 sm:px-4 py-2 rounded-lg sm:rounded-xl transition text-xs sm:text-sm text-gray-700">
                                    🗣️ Baoulé
                                </button>
                                <button onclick="setLanguage('french')" class="bg-gray-100 hover:bg-gray-200 px-3 sm:px-4 py-2 rounded-lg sm:rounded-xl transition text-xs sm:text-sm text-gray-700">
                                    🇫🇷 Français
                                </button>
                                <button onclick="setLanguage('senoufo')" class="bg-gray-100 hover:bg-gray-200 px-3 sm:px-4 py-2 rounded-lg sm:rounded-xl transition text-xs sm:text-sm text-gray-700">
                                    🗣️ Sénoufo
                                </button>
                            </div>
                        </div>

                        <!-- Type de message -->
                        <div class="mb-4 sm:mb-6">
                            <label class="text-sm text-gray-600 mb-2 block">Type de notification</label>
                            <select onchange="changeMessageType(this.value)" class="w-full bg-gray-100 border border-gray-200 rounded-lg sm:rounded-xl px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base text-gray-700">
                                <option value="grades">Notes scolaires</option>
                                <option value="absence">Absence signalée</option>
                                <option value="meeting">Réunion parents</option>
                                <option value="urgent">Message urgent</option>
                            </select>
                        </div>

                        <!-- Bouton de test -->
                        <button onclick="startDemo()" class="w-full bg-gradient-to-r from-indigo-500 to-violet-500 text-white py-3 sm:py-4 rounded-xl sm:rounded-2xl font-bold hover:scale-105 transition shadow-xl text-sm sm:text-base">
                            <i class="fas fa-play mr-1 sm:mr-2"></i>Lancer la Démo
                        </button>
                    </div>

                    <!-- Statistiques en temps réel -->
                    <div class="bg-white/90 backdrop-blur rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-xl">
                        <h4 class="font-semibold mb-4 text-gray-800">Activité en temps réel</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Parents connectés</span>
                                <span class="font-bold text-emerald-600">
                                    <span id="connectedCount">1,234</span>
                                    <i class="fas fa-circle text-green-500 text-xs ml-2 animate-pulse"></i>
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Appels aujourd'hui</span>
                                <span class="font-bold text-violet-600" id="callsCount">456</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Taux de réponse</span>
                                <span class="font-bold text-emerald-600">89%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Fonctionnement -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">
                    <span class="gradient-text">Comment ça marche ?</span>
                </h2>
                <p class="text-xl text-gray-600">Un processus simple et efficace</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                @php
                $steps = [
                    ['icon' => 'fa-user-plus', 'title' => 'Inscription', 'desc' => 'Parent donne son numéro et choisit sa langue', 'color' => 'purple'],
                    ['icon' => 'fa-school', 'title' => 'École notifie', 'desc' => 'Professeur envoie infos via dashboard', 'color' => 'blue'],
                    ['icon' => 'fa-phone-volume', 'title' => 'Appel vocal', 'desc' => 'Parent reçoit message dans sa langue', 'color' => 'green'],
                    ['icon' => 'fa-comments', 'title' => 'Interaction', 'desc' => 'Parent peut répondre par touches', 'color' => 'orange']
                ];
                @endphp

                @foreach($steps as $index => $step)
                <div class="relative">
                    @if($index < 3)
                    <div class="hidden md:block absolute top-1/3 left-full w-full h-0.5 bg-gradient-to-r from-{{$step['color']}}-400 to-{{$step['color']}}-600 z-0"></div>
                    @endif
                    <div class="relative z-10 text-center group">
                        <div class="gradient-border mx-auto w-24 h-24 mb-4 group-hover:scale-110 transition">
                            <div class="w-full h-full bg-white rounded-2xl flex items-center justify-center">
                                <i class="fas {{$step['icon']}} text-3xl text-{{$step['color']}}-500"></i>
                            </div>
                        </div>
                        <h3 class="font-bold text-lg mb-2">{{$step['title']}}</h3>
                        <p class="text-sm text-gray-600">{{$step['desc']}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Section Impact -->
    <section class="py-20 bg-gradient-to-br from-indigo-50 to-violet-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 text-gray-800">Impact Révolutionnaire</h2>
                <p class="text-xl text-gray-600">Des résultats qui transforment l'éducation</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-6xl font-bold mb-2 floating text-emerald-600">89,000</div>
                    <p class="text-gray-600">Parents illettrés engagés</p>
                </div>
                <div class="text-center">
                    <div class="text-6xl font-bold mb-2 floating text-emerald-600" style="animation-delay: 0.5s;">+23%</div>
                    <p class="text-gray-600">Amélioration présence</p>
                </div>
                <div class="text-center">
                    <div class="text-6xl font-bold mb-2 floating text-violet-600" style="animation-delay: 1s;">-41%</div>
                    <p class="text-gray-600">Réduction abandon</p>
                </div>
                <div class="text-center">
                    <div class="text-6xl font-bold mb-2 floating text-amber-600" style="animation-delay: 1.5s;">4.6/5</div>
                    <p class="text-gray-600">Satisfaction parents</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">
                <span class="gradient-text">Prêt à transformer l'éducation ?</span>
            </h2>
            <p class="text-xl text-gray-600 mb-8">
                Rejoignez les écoles pilotes qui révolutionnent déjà l'inclusion parentale
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-8 py-4 rounded-full text-lg font-bold hover:scale-105 transition shadow-xl">
                    <i class="fas fa-rocket mr-2"></i>Démarrer Maintenant
                </a>
                <a href="{{ route('mama-ecole.info') }}" class="bg-white border-2 border-emerald-600 text-emerald-600 px-8 py-4 rounded-full text-lg font-bold hover:bg-emerald-50 transition">
                    <i class="fas fa-book mr-2"></i>Documentation
                </a>
            </div>
        </div>
    </section>

    <!-- Notification Toast Moderne -->
    <div id="toast" class="fixed top-4 right-4 left-4 sm:left-auto z-50 hidden notification-slide">
        <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 sm:min-w-[400px] shadow-2xl border border-gray-200">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-gradient-to-r from-emerald-400 to-indigo-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check text-white"></i>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-gray-800 mb-1">Démonstration terminée!</h4>
                    <p class="text-gray-600 text-sm">Dans la vraie vie, vous recevriez cet appel sur votre téléphone.</p>
                    <div class="mt-3 flex gap-2">
                        <button onclick="closeToast()" class="bg-emerald-600 hover:bg-emerald-700 px-3 py-1 rounded-lg text-white text-sm transition">
                            OK
                        </button>
                        <button onclick="restartDemo()" class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-lg text-gray-700 text-sm transition">
                            Recommencer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentLanguage = 'dioula';
        let currentMessageType = 'grades';
        let demoActive = false;
        let audioContext = null;
        let isRinging = false;
        let messageQueue = [];

        const messages = {
            grades: {
                dioula: "I ni ce! I den Kouadio ye nota 15 sɔrɔ 20 la Mathématiques la.",
                baoule: "Akwaba. Wo ba Kouadio asi 15 su 20 min Mathématiques su.",
                french: "Bonjour. Votre enfant Kouadio a obtenu 15/20 en Mathématiques.",
                senoufo: "An sogoma. Wo den Kouadio ka 15 ye 20 ni Mathématiques lo.",
                translation: "Votre enfant Kouadio a obtenu 15/20 en Mathématiques"
            },
            absence: {
                dioula: "I ni ce. I den tun tɛ kalanso la bi.",
                baoule: "Akwaba. Wo ba te sukulu nnɛ.",
                french: "Bonjour. Votre enfant était absent aujourd'hui.",
                senoufo: "An sogoma. Wo den ma ta sikolo bi.",
                translation: "Votre enfant était absent aujourd'hui"
            },
            meeting: {
                dioula: "I ni ce. Bangebaga lajɛ bɛna kɛ sini sɔgɔma 10h. I ka na.",
                baoule: "Akwaba. Awon fofoe blɛ sran 10h. Wo si ba.",
                french: "Bonjour. Réunion parents demain à 10h. Votre présence est importante.",
                senoufo: "An sogoma. Yaa lajɛ be kɛ sini 10h. Ka ta.",
                translation: "Réunion parents demain à 10h"
            },
            urgent: {
                dioula: "I ni ce. Ko gɛlɛn don! I ka na kalanso la sisan.",
                baoule: "Akwaba. Sɛ kpa! Wo si ba sukulu sɛsɛ.",
                french: "Bonjour. Message urgent! Veuillez venir à l'école immédiatement.",
                senoufo: "An sogoma. Ko fila! Ka ta sikolo sisan.",
                translation: "Message urgent - Venez à l'école immédiatement"
            }
        };

        function startDemo() {
            if (demoActive) return;
            demoActive = true;
            isRinging = true;
            
            // Réinitialiser l'interface
            document.getElementById('voiceMessage').classList.add('hidden');
            document.getElementById('translation').classList.add('hidden');
            
            // Animation de l'appel entrant
            const phone = document.getElementById('callInterface');
            phone.classList.add('animate-pulse');
            
            // Créer effet de sonnerie
            playRingtone();
            
            // Vibration visuelle du téléphone
            animatePhoneRinging();
            
            // Afficher notification d'appel
            showIncomingCallNotification();
        }

        function playRingtone() {
            if (!audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }
            
            const duration = 0.5;
            const oscillator1 = audioContext.createOscillator();
            const oscillator2 = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator1.connect(gainNode);
            oscillator2.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator1.frequency.value = 440;
            oscillator2.frequency.value = 480;
            
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + duration);
            
            oscillator1.start(audioContext.currentTime);
            oscillator2.start(audioContext.currentTime);
            oscillator1.stop(audioContext.currentTime + duration);
            oscillator2.stop(audioContext.currentTime + duration);
            
            if (isRinging) {
                setTimeout(() => {
                    if (isRinging) playRingtone();
                }, 1000);
            }
        }

        function animatePhoneRinging() {
            const phone = document.querySelector('.bg-gray-900.rounded-\\[3rem\\]');
            phone.style.animation = 'phoneRing 0.5s ease-in-out infinite';
            
            // Ajouter l'animation CSS dynamiquement
            if (!document.getElementById('phone-ring-style')) {
                const style = document.createElement('style');
                style.id = 'phone-ring-style';
                style.textContent = `
                    @keyframes phoneRing {
                        0%, 100% { transform: rotate(0deg); }
                        10%, 30% { transform: rotate(-2deg); }
                        20%, 40% { transform: rotate(2deg); }
                    }
                `;
                document.head.appendChild(style);
            }
        }

        function showIncomingCallNotification() {
            // Créer une notification flottante
            const notification = document.createElement('div');
            notification.id = 'incoming-call-notification';
            notification.className = 'fixed top-20 left-4 right-4 sm:left-1/2 sm:right-auto sm:transform sm:-translate-x-1/2 bg-white rounded-xl sm:rounded-2xl p-3 sm:p-4 shadow-2xl z-50 notification-slide max-w-sm mx-auto sm:mx-0';
            notification.innerHTML = `
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-500 rounded-full flex items-center justify-center animate-pulse flex-shrink-0">
                        <i class="fas fa-phone text-white text-sm sm:text-base"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-800 text-sm sm:text-base">Appel Entrant</div>
                        <div class="text-xs sm:text-sm text-gray-600">MAMA ÉCOLE - Message scolaire</div>
                    </div>
                </div>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 3000);
        }

        function answerCall() {
            isRinging = false;
            
            // Arrêter l'animation de sonnerie
            const phone = document.querySelector('.bg-gray-900.rounded-\\[3rem\\]');
            phone.style.animation = '';
            document.getElementById('callInterface').classList.remove('animate-pulse');
            
            // Supprimer la notification d'appel entrant
            const notification = document.getElementById('incoming-call-notification');
            if (notification) notification.remove();
            
            // Jouer son de décrochage
            playAnswerSound();
            
            // Animation de transition
            const callInterface = document.getElementById('callInterface');
            callInterface.style.opacity = '0.5';
            setTimeout(() => {
                callInterface.style.opacity = '1';
                
                // Afficher progressivement le message
                simulateVoiceMessage();
            }, 500);
            
            // Incrémenter les compteurs
            updateCounters();
        }

        function playAnswerSound() {
            if (!audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }
            
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
            oscillator.frequency.exponentialRampToValueAtTime(400, audioContext.currentTime + 0.1);
            
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.2);
        }

        function simulateVoiceMessage() {
            const voiceMessageEl = document.getElementById('voiceMessage');
            const translationEl = document.getElementById('translation');
            const message = messages[currentMessageType][currentLanguage];
            const translation = messages[currentMessageType].translation;
            
            // Réinitialiser
            voiceMessageEl.textContent = '';
            voiceMessageEl.classList.remove('hidden');
            
            // Effet machine à écrire pour le message vocal
            let index = 0;
            const typeInterval = setInterval(() => {
                if (index < message.length) {
                    voiceMessageEl.textContent = `"${message.substring(0, index + 1)}"`;
                    index++;
                    
                    // Jouer un petit son pour chaque caractère
                    if (index % 3 === 0) playTypingSound();
                } else {
                    clearInterval(typeInterval);
                    
                    // Afficher la traduction après le message
                    setTimeout(() => {
                        translationEl.innerHTML = `<i class="fas fa-language mr-2"></i>${translation}`;
                        translationEl.classList.remove('hidden');
                        translationEl.style.animation = 'fadeIn 0.5s ease-in';
                        
                        // Afficher options après 2 secondes
                        setTimeout(() => {
                            showInteractionOptions();
                        }, 2000);
                    }, 1000);
                }
            }, 50);
        }

        function playTypingSound() {
            if (!audioContext) return;
            
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.value = 1000 + Math.random() * 500;
            gainNode.gain.setValueAtTime(0.05, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.05);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.05);
        }

        function showInteractionOptions() {
            // Créer un panneau d'options interactives
            const optionsPanel = document.createElement('div');
            optionsPanel.id = 'interaction-options';
            optionsPanel.className = 'bg-gray-800/90 backdrop-blur rounded-lg sm:rounded-xl p-2 sm:p-3 mt-3 sm:mt-4';
            optionsPanel.innerHTML = `
                <div class="text-xs text-gray-400 mb-1 sm:mb-2">Tapez sur le clavier:</div>
                <div class="grid grid-cols-3 gap-1 sm:gap-2 text-xs">
                    <button onclick="simulateKeyPress('1')" class="bg-gray-700 hover:bg-gray-600 p-1.5 sm:p-2 rounded transition">
                        <span class="font-bold block sm:inline">1</span><span class="hidden sm:inline"> Répéter</span>
                    </button>
                    <button onclick="simulateKeyPress('2')" class="bg-gray-700 hover:bg-gray-600 p-1.5 sm:p-2 rounded transition">
                        <span class="font-bold block sm:inline">2</span><span class="hidden sm:inline"> Confirmer</span>
                    </button>
                    <button onclick="simulateKeyPress('3')" class="bg-gray-700 hover:bg-gray-600 p-1.5 sm:p-2 rounded transition">
                        <span class="font-bold block sm:inline">3</span><span class="hidden sm:inline"> Aide</span>
                    </button>
                </div>
            `;
            
            const container = document.querySelector('.bg-gray-800.rounded-2xl.p-4.mb-6');
            if (!document.getElementById('interaction-options')) {
                container.appendChild(optionsPanel);
            }
            
            // Afficher le toast après 3 secondes
            setTimeout(() => {
                showToast();
            }, 3000);
        }

        function updateCounters() {
            const connectedEl = document.getElementById('connectedCount');
            const callsEl = document.getElementById('callsCount');
            
            let connected = parseInt(connectedEl.textContent.replace(',', ''));
            let calls = parseInt(callsEl.textContent);
            
            connectedEl.textContent = (connected + 1).toLocaleString();
            callsEl.textContent = calls + 1;
        }

        function showToast() {
            const toast = document.getElementById('toast');
            toast.classList.remove('hidden');
            
            // Auto-hide après 5 secondes
            setTimeout(() => {
                if (!toast.classList.contains('hidden')) {
                    closeToast();
                }
            }, 5000);
        }

        function closeToast() {
            document.getElementById('toast').classList.add('hidden');
            demoActive = false;
        }

        function restartDemo() {
            closeToast();
            document.getElementById('voiceMessage').classList.add('hidden');
            document.getElementById('translation').classList.add('hidden');
            startDemo();
        }

        function setLanguage(lang) {
            currentLanguage = lang;
        }

        function changeMessageType(type) {
            currentMessageType = type;
        }

        function replayMessage() {
            if (demoActive) {
                // Animation de replay
                const voiceMessageEl = document.getElementById('voiceMessage');
                voiceMessageEl.style.animation = 'pulse 0.5s ease-in-out';
                
                // Jouer le son de replay
                playReplaySound();
                
                // Réafficher le message avec animation
                setTimeout(() => {
                    voiceMessageEl.style.animation = '';
                    simulateVoiceMessage();
                }, 500);
            }
        }

        function playReplaySound() {
            if (!audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }
            
            // Son de notification de replay
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.setValueAtTime(600, audioContext.currentTime);
            oscillator.frequency.linearRampToValueAtTime(800, audioContext.currentTime + 0.1);
            oscillator.frequency.linearRampToValueAtTime(600, audioContext.currentTime + 0.2);
            
            gainNode.gain.setValueAtTime(0.2, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.3);
        }

        function getDetails() {
            // Créer un modal personnalisé au lieu d'une alerte
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 w-full max-w-md transform scale-95 animate-scale-in">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>Détails du Message
                    </h3>
                    <div class="space-y-3 text-gray-600">
                        <div class="flex justify-between">
                            <span class="font-medium">Élève:</span>
                            <span>Kouadio Yao</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Classe:</span>
                            <span>CM2 A</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Matière:</span>
                            <span>Mathématiques</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Note obtenue:</span>
                            <span class="font-bold text-green-600">15/20</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Moyenne classe:</span>
                            <span>12/20</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Rang:</span>
                            <span class="text-blue-600">5ème/30</span>
                        </div>
                        <div class="border-t pt-3">
                            <span class="font-medium">Commentaire prof:</span>
                            <p class="text-sm mt-1 italic">"Bon travail! Continue tes efforts en résolution de problèmes."</p>
                        </div>
                    </div>
                    <button onclick="this.closest('.fixed').remove()" class="mt-6 w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-xl transition">
                        Fermer
                    </button>
                </div>
            `;
            document.body.appendChild(modal);
            
            // Ajouter l'animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes scale-in {
                    from { transform: scale(0.9); opacity: 0; }
                    to { transform: scale(1); opacity: 1; }
                }
                .animate-scale-in { animation: scale-in 0.3s ease-out forwards; }
            `;
            document.head.appendChild(style);
        }

        function simulateKeyPress(key) {
            // Animation du bouton pressé
            event.target.style.transform = 'scale(0.95)';
            setTimeout(() => {
                event.target.style.transform = '';
            }, 100);
            
            // Jouer le son DTMF
            playDTMFTone(key);
            
            // Actions selon la touche
            switch(key) {
                case '1':
                    replayMessage();
                    showNotification('Message en cours de répétition...');
                    break;
                case '2':
                    showNotification('Réception confirmée! Merci.');
                    messageQueue.push({
                        type: 'confirmation',
                        time: new Date().toLocaleTimeString()
                    });
                    break;
                case '3':
                    showNotification('Un agent vous rappellera sous peu.');
                    messageQueue.push({
                        type: 'help_request',
                        time: new Date().toLocaleTimeString()
                    });
                    break;
            }
        }

        function playDTMFTone(digit) {
            if (!audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }
            
            const frequencies = {
                '1': [697, 1209],
                '2': [697, 1336],
                '3': [697, 1477]
            };
            
            const [low, high] = frequencies[digit];
            const duration = 0.2;
            
            const osc1 = audioContext.createOscillator();
            const osc2 = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            osc1.connect(gainNode);
            osc2.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            osc1.frequency.value = low;
            osc2.frequency.value = high;
            
            gainNode.gain.setValueAtTime(0.25, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + duration);
            
            osc1.start(audioContext.currentTime);
            osc2.start(audioContext.currentTime);
            osc1.stop(audioContext.currentTime + duration);
            osc2.stop(audioContext.currentTime + duration);
        }

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white px-6 py-3 rounded-full shadow-lg z-50';
            notification.textContent = message;
            notification.style.animation = 'slideUp 0.3s ease-out';
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideDown 0.3s ease-out';
                setTimeout(() => notification.remove(), 300);
            }, 2000);
        }

        function declineCall() {
            isRinging = false;
            demoActive = false;
            
            // Arrêter les animations
            const phone = document.querySelector('.bg-gray-900.rounded-\\[3rem\\]');
            phone.style.animation = '';
            document.getElementById('callInterface').classList.remove('animate-pulse');
            
            // Masquer les messages
            document.getElementById('voiceMessage').classList.add('hidden');
            document.getElementById('translation').classList.add('hidden');
            
            // Supprimer les options d'interaction
            const options = document.getElementById('interaction-options');
            if (options) options.remove();
            
            // Supprimer la notification d'appel
            const notification = document.getElementById('incoming-call-notification');
            if (notification) notification.remove();
            
            // Jouer son de raccrochage
            playHangupSound();
            
            // Afficher message de fin
            showNotification('Appel décliné');
        }

        function playHangupSound() {
            if (!audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }
            
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.setValueAtTime(400, audioContext.currentTime);
            oscillator.frequency.exponentialRampToValueAtTime(200, audioContext.currentTime + 0.2);
            
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.3);
        }

        // Animation automatique des compteurs
        setInterval(() => {
            if (!demoActive && Math.random() > 0.7) {
                const connectedEl = document.getElementById('connectedCount');
                let connected = parseInt(connectedEl.textContent.replace(',', ''));
                const change = Math.floor(Math.random() * 10) - 5;
                connected = Math.max(1200, connected + change);
                connectedEl.textContent = connected.toLocaleString();
            }
        }, 3000);

        // Ajouter les styles d'animation
        const animationStyles = document.createElement('style');
        animationStyles.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes slideUp {
                from { transform: translate(-50%, 100%); opacity: 0; }
                to { transform: translate(-50%, 0); opacity: 1; }
            }
            @keyframes slideDown {
                from { transform: translate(-50%, 0); opacity: 1; }
                to { transform: translate(-50%, 100%); opacity: 0; }
            }
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }
        `;
        document.head.appendChild(animationStyles);

        // Écouter les touches du clavier pour la démo
        document.addEventListener('keypress', (e) => {
            if (demoActive && ['1', '2', '3'].includes(e.key)) {
                simulateKeyPress(e.key);
            }
        });

        // Initialiser l'AudioContext au premier clic
        document.addEventListener('click', () => {
            if (!audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }
        }, { once: true });
    </script>
</body>
</html>