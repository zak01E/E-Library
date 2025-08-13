<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Démo Interactive MAMA ÉCOLE</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-50 to-violet-50 min-h-screen font-['Plus_Jakarta_Sans']">
    
    <!-- Navigation Simple -->
    <nav class="bg-white/90 backdrop-blur shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('mama-ecole.index') }}" class="flex items-center">
                    <i class="fas fa-phone-volume text-emerald-600 text-2xl mr-3"></i>
                    <span class="text-xl font-bold text-gray-900">MAMA ÉCOLE - Démo</span>
                </a>
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-emerald-600">
                    <i class="fas fa-times text-2xl"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid lg:grid-cols-2 gap-8">
            
            <!-- Simulateur Téléphone -->
            <div class="flex items-center justify-center">
                <div class="relative">
                    <!-- Phone Frame -->
                    <div class="bg-gray-900 rounded-[2.5rem] p-4 shadow-2xl w-80">
                        <div class="bg-black rounded-[2rem] p-6 h-[650px] relative overflow-hidden">
                            
                            <!-- Status Bar -->
                            <div class="flex justify-between text-white text-xs mb-6 opacity-70">
                                <span>9:41</span>
                                <div class="flex items-center gap-1">
                                    <i class="fas fa-signal"></i>
                                    <i class="fas fa-wifi"></i>
                                    <i class="fas fa-battery-full"></i>
                                </div>
                            </div>

                            <!-- Call Screen -->
                            <div id="callScreen" class="text-white text-center">
                                <div class="mb-4">
                                    <p class="text-sm text-gray-400">Appel entrant</p>
                                    <h2 class="text-2xl font-bold mt-2">MAMA ÉCOLE</h2>
                                    <p class="text-gray-400">+225 07 00 00 00 00</p>
                                </div>

                                <!-- Avatar -->
                                <div class="my-8">
                                    <div class="w-32 h-32 mx-auto bg-gradient-to-br from-indigo-500 to-violet-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-phone-volume text-5xl text-white animate-pulse"></i>
                                    </div>
                                </div>

                                <!-- Voice Message Display -->
                                <div id="messageBox" class="hidden bg-gray-800 rounded-2xl p-4 mb-6 text-left">
                                    <div class="flex items-center mb-2">
                                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-2"></span>
                                        <span class="text-green-400 text-sm">Message vocal</span>
                                    </div>
                                    <p id="voiceText" class="text-green-300 italic mb-2"></p>
                                    <p id="translationText" class="text-gray-400 text-sm"></p>
                                </div>

                                <!-- Interactive Buttons -->
                                <div id="interactiveButtons" class="hidden grid grid-cols-3 gap-3 mb-6">
                                    <button onclick="handleOption(1)" class="bg-gray-700 py-3 rounded-xl hover:bg-gray-600 transition">
                                        <span class="block text-2xl">1️⃣</span>
                                        <span class="text-xs">Répéter</span>
                                    </button>
                                    <button onclick="handleOption(2)" class="bg-gray-700 py-3 rounded-xl hover:bg-gray-600 transition">
                                        <span class="block text-2xl">2️⃣</span>
                                        <span class="text-xs">Détails</span>
                                    </button>
                                    <button onclick="handleOption(3)" class="bg-gray-700 py-3 rounded-xl hover:bg-gray-600 transition">
                                        <span class="block text-2xl">3️⃣</span>
                                        <span class="text-xs">Message</span>
                                    </button>
                                </div>

                                <!-- Call Actions -->
                                <div class="absolute bottom-8 left-6 right-6 grid grid-cols-2 gap-4">
                                    <button id="declineBtn" onclick="declineCall()" class="bg-red-500 hover:bg-red-600 py-4 rounded-full transition">
                                        <i class="fas fa-phone-slash text-2xl"></i>
                                    </button>
                                    <button id="answerBtn" onclick="answerCall()" class="bg-green-500 hover:bg-green-600 py-4 rounded-full transition">
                                        <i class="fas fa-phone text-2xl"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Control Panel -->
            <div class="space-y-6">
                <!-- Scenario Selection -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-sliders-h text-emerald-600 mr-2"></i>
                        Configuration de la démo
                    </h3>
                    
                    <!-- Language Selection -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Langue du parent</label>
                        <select id="languageSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                            <option value="dioula">Dioula</option>
                            <option value="baoule">Baoulé</option>
                            <option value="french">Français</option>
                            <option value="bete">Bété</option>
                            <option value="senoufo">Sénoufo</option>
                        </select>
                    </div>

                    <!-- Message Type -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type de notification</label>
                        <select id="messageType" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                            <option value="grades">Notes scolaires</option>
                            <option value="absence">Absence signalée</option>
                            <option value="meeting">Réunion parents-profs</option>
                            <option value="urgent">Message urgent</option>
                        </select>
                    </div>

                    <!-- Start Demo Button -->
                    <button onclick="startDemo()" class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white py-3 rounded-lg font-semibold hover:shadow-lg transition">
                        <i class="fas fa-play mr-2"></i>
                        Lancer l'appel démo
                    </button>
                </div>

                <!-- Live Stats -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-chart-line text-emerald-600 mr-2"></i>
                        Statistiques simulées
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600">Durée appel</p>
                            <p class="text-2xl font-bold text-gray-900"><span id="callDuration">0:00</span></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600">Interactions</p>
                            <p class="text-2xl font-bold text-gray-900"><span id="interactions">0</span></p>
                        </div>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-emerald-50 border-l-4 border-emerald-400 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-emerald-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-emerald-700">
                                Cette démo simule un appel réel MAMA ÉCOLE. Configurez les options, 
                                lancez l'appel et interagissez avec les boutons pour tester le système.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Messages database
        const messages = {
            grades: {
                dioula: {
                    voice: "I ni ce! I den Kouadio ye nota 15 sɔrɔ 20 la Mathématiques la.",
                    translation: "Bonjour! Votre enfant Kouadio a eu 15/20 en Mathématiques."
                },
                baoule: {
                    voice: "Akwaba. Wo ba Kouadio asi 15 su 20 min Mathématiques su.",
                    translation: "Bonjour. Votre enfant Kouadio a obtenu 15/20 en Mathématiques."
                },
                french: {
                    voice: "Bonjour. Votre enfant Kouadio a obtenu 15 sur 20 en Mathématiques.",
                    translation: ""
                },
                bete: {
                    voice: "Nya wleu. Mɔ bi Kouadio gba 15 20 ni Mathématiques su.",
                    translation: "Bonjour. Votre enfant Kouadio a eu 15/20 en Mathématiques."
                },
                senoufo: {
                    voice: "An sogoma. Wo den Kouadio ka 15 ye 20 ni Mathématiques lo.",
                    translation: "Bonjour. Votre enfant Kouadio a obtenu 15/20 en Mathématiques."
                }
            },
            absence: {
                dioula: {
                    voice: "I ni ce. I den Kouadio tun tɛ kalanso la bi.",
                    translation: "Bonjour. Votre enfant Kouadio était absent aujourd'hui."
                },
                baoule: {
                    voice: "Akwaba. Wo ba Kouadio te sukulu nnɛ.",
                    translation: "Bonjour. Votre enfant n'était pas à l'école aujourd'hui."
                },
                french: {
                    voice: "Bonjour. Votre enfant Kouadio était absent de l'école aujourd'hui.",
                    translation: ""
                },
                bete: {
                    voice: "Nya wleu. Mɔ bi Kouadio ma ta sikolo bi.",
                    translation: "Bonjour. Votre enfant n'était pas à l'école aujourd'hui."
                },
                senoufo: {
                    voice: "An sogoma. Wo den ma ta sikolo bi.",
                    translation: "Bonjour. Votre enfant n'était pas à l'école aujourd'hui."
                }
            },
            meeting: {
                dioula: {
                    voice: "I ni ce. Bangebaga ni karamɔgɔw ka lajɛ bɛna kɛ siɲɛ 3 sira 14h.",
                    translation: "Bonjour. Réunion parents-professeurs mercredi à 14h."
                },
                baoule: {
                    voice: "Akwaba. Awlowle kpe fuwe be si nnran'n 3 14h.",
                    translation: "Bonjour. Réunion parents-professeurs mercredi à 14h."
                },
                french: {
                    voice: "Bonjour. Une réunion parents-professeurs aura lieu mercredi à 14 heures.",
                    translation: ""
                },
                bete: {
                    voice: "Nya wleu. Gonin kpe be si gbɛ 3 14h.",
                    translation: "Bonjour. Réunion parents-professeurs mercredi à 14h."
                },
                senoufo: {
                    voice: "An sogoma. Nafolo kpe be si tan 3 14h.",
                    translation: "Bonjour. Réunion parents-professeurs mercredi à 14h."
                }
            },
            urgent: {
                dioula: {
                    voice: "I ni ce. I ka na kalanso la joona. Kunnafonin juguman bɛ yen.",
                    translation: "Bonjour. Venez à l'école rapidement. Information importante."
                },
                baoule: {
                    voice: "Akwaba. Ba sukulu sa kpɛngbɛn. Sɛ kpli bɛ.",
                    translation: "Bonjour. Venez vite à l'école. C'est important."
                },
                french: {
                    voice: "Bonjour. Merci de venir rapidement à l'école. C'est urgent.",
                    translation: ""
                },
                bete: {
                    voice: "Nya wleu. Wa sikolo sa mlɛmlɛ. Sɛ juguman.",
                    translation: "Bonjour. Venez vite à l'école. C'est urgent."
                },
                senoufo: {
                    voice: "An sogoma. Ta sikolo sa. Sɛ kpli bɛ.",
                    translation: "Bonjour. Venez à l'école. C'est important."
                }
            }
        };

        let callTimer = null;
        let callSeconds = 0;
        let interactionCount = 0;
        let currentMessage = null;

        function startDemo() {
            // Reset
            callSeconds = 0;
            interactionCount = 0;
            
            // Simulate incoming call
            document.getElementById('answerBtn').classList.add('animate-pulse');
            document.getElementById('declineBtn').classList.add('animate-pulse');
            
            // Play ringtone sound effect (simulated)
            console.log('🔔 Sonnerie...');
        }

        function answerCall() {
            // Get selected options
            const language = document.getElementById('languageSelect').value;
            const messageType = document.getElementById('messageType').value;
            
            // Get message
            currentMessage = messages[messageType][language];
            
            // Show message
            document.getElementById('messageBox').classList.remove('hidden');
            document.getElementById('voiceText').textContent = currentMessage.voice;
            document.getElementById('translationText').textContent = currentMessage.translation || '';
            
            // Show interactive buttons
            document.getElementById('interactiveButtons').classList.remove('hidden');
            
            // Hide call buttons
            document.getElementById('answerBtn').classList.add('hidden');
            document.getElementById('declineBtn').classList.add('hidden');
            
            // Start timer
            startCallTimer();
        }

        function declineCall() {
            // Reset everything
            resetCall();
        }

        function handleOption(option) {
            interactionCount++;
            document.getElementById('interactions').textContent = interactionCount;
            
            switch(option) {
                case 1:
                    // Replay message
                    alert('Message répété:\n\n' + currentMessage.voice);
                    break;
                case 2:
                    // Show details
                    alert('Détails complets:\n\nÉlève: Kouadio Jean\nClasse: 6ème A\nProfesseur: M. Diabaté\nMoyenne classe: 12/20\nRang: 5ème sur 30');
                    break;
                case 3:
                    // Leave message
                    const message = prompt('Laissez votre message vocal (simulation):');
                    if(message) {
                        alert('Message enregistré: ' + message + '\n\nLe professeur recevra votre message.');
                    }
                    break;
            }
        }

        function startCallTimer() {
            callTimer = setInterval(() => {
                callSeconds++;
                const minutes = Math.floor(callSeconds / 60);
                const seconds = callSeconds % 60;
                document.getElementById('callDuration').textContent = 
                    `${minutes}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }

        function resetCall() {
            // Clear timer
            if(callTimer) {
                clearInterval(callTimer);
                callTimer = null;
            }
            
            // Hide elements
            document.getElementById('messageBox').classList.add('hidden');
            document.getElementById('interactiveButtons').classList.add('hidden');
            
            // Show call buttons
            document.getElementById('answerBtn').classList.remove('hidden');
            document.getElementById('declineBtn').classList.remove('hidden');
            document.getElementById('answerBtn').classList.remove('animate-pulse');
            document.getElementById('declineBtn').classList.remove('animate-pulse');
            
            // Reset counters
            callSeconds = 0;
            interactionCount = 0;
            document.getElementById('callDuration').textContent = '0:00';
            document.getElementById('interactions').textContent = '0';
        }
    </script>
</body>
</html>