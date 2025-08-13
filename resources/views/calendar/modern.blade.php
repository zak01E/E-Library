<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier Scolaire 2025 - E-Library Côte d'Ivoire</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .event-badge {
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from { transform: translateX(-10px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .floating {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-violet-50 min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white/90 backdrop-blur shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <i class="fas fa-calendar-alt text-emerald-600 text-2xl mr-3"></i>
                        <span class="text-xl font-bold text-gray-900">Calendrier Scolaire CI</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="exportCalendar()" class="text-gray-600 hover:text-emerald-600">
                        <i class="fas fa-download text-xl"></i>
                    </button>
                    <button onclick="printCalendar()" class="text-gray-600 hover:text-emerald-600">
                        <i class="fas fa-print text-xl"></i>
                    </button>
                    <a href="{{ route('home') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700">
                        <i class="fas fa-home mr-2"></i>Accueil
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative py-16 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-600 opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl font-bold text-gray-900 mb-4">
                    Calendrier Scolaire 2024-2025
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Toutes les dates importantes de l'année académique ivoirienne en un coup d'œil
                </p>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12 max-w-4xl mx-auto">
                <div class="glass rounded-xl p-4 text-center">
                    <div class="text-3xl font-bold text-emerald-600">180</div>
                    <div class="text-sm text-gray-600">Jours de cours</div>
                </div>
                <div class="glass rounded-xl p-4 text-center">
                    <div class="text-3xl font-bold text-emerald-600">3</div>
                    <div class="text-sm text-gray-600">Trimestres</div>
                </div>
                <div class="glass rounded-xl p-4 text-center">
                    <div class="text-3xl font-bold text-orange-600">12</div>
                    <div class="text-sm text-gray-600">Jours fériés</div>
                </div>
                <div class="glass rounded-xl p-4 text-center">
                    <div class="text-3xl font-bold text-violet-600">4</div>
                    <div class="text-sm text-gray-600">Examens nationaux</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Month View -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Month Navigation -->
            <div class="flex justify-between items-center mb-8">
                <button onclick="previousMonth()" class="glass px-4 py-2 rounded-lg hover:bg-white transition">
                    <i class="fas fa-chevron-left mr-2"></i>Précédent
                </button>
                <h2 class="text-3xl font-bold text-gray-900">Janvier 2025</h2>
                <button onclick="nextMonth()" class="glass px-4 py-2 rounded-lg hover:bg-white transition">
                    Suivant<i class="fas fa-chevron-right ml-2"></i>
                </button>
            </div>

            <!-- Calendar Grid -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="grid grid-cols-7 gap-4 mb-4">
                    @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $day)
                    <div class="text-center font-semibold text-gray-600 text-sm">{{ $day }}</div>
                    @endforeach
                </div>

                <div class="grid grid-cols-7 gap-2">
                    @for($i = 1; $i <= 31; $i++)
                    <div class="aspect-square p-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition relative group">
                        <div class="text-sm font-semibold text-gray-700">{{ $i }}</div>
                        
                        @if($i == 1)
                        <div class="mt-1">
                            <span class="inline-block w-full bg-red-100 text-red-700 text-xs px-1 py-0.5 rounded">
                                Nouvel An
                            </span>
                        </div>
                        @elseif($i == 6)
                        <div class="mt-1">
                            <span class="inline-block w-full bg-blue-100 text-blue-700 text-xs px-1 py-0.5 rounded">
                                Rentrée
                            </span>
                        </div>
                        @elseif($i == 15)
                        <div class="mt-1">
                            <span class="inline-block w-full bg-green-100 text-green-700 text-xs px-1 py-0.5 rounded">
                                Réunion
                            </span>
                        </div>
                        @endif

                        <!-- Hover Tooltip -->
                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block z-10">
                            <div class="bg-gray-900 text-white text-xs rounded-lg py-2 px-3 whitespace-nowrap">
                                {{ $i }} Janvier 2025
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Événements à venir</h2>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Event Card 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition event-badge">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-4 text-white">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg">Rentrée Scolaire</h3>
                                <p class="text-sm opacity-90">6 Janvier 2025</p>
                            </div>
                            <i class="fas fa-school text-2xl opacity-50"></i>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 text-sm mb-3">
                            Reprise des cours pour tous les niveaux du primaire au lycée
                        </p>
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="far fa-clock mr-2"></i>
                            Dans 5 jours
                        </div>
                    </div>
                </div>

                <!-- Event Card 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition event-badge">
                    <div class="bg-gradient-to-r from-emerald-500 to-green-600 p-4 text-white">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg">Réunion Parents-Profs</h3>
                                <p class="text-sm opacity-90">15 Janvier 2025</p>
                            </div>
                            <i class="fas fa-users text-2xl opacity-50"></i>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 text-sm mb-3">
                            Rencontre trimestrielle avec les enseignants
                        </p>
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="far fa-clock mr-2"></i>
                            Dans 14 jours
                        </div>
                    </div>
                </div>

                <!-- Event Card 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition event-badge">
                    <div class="bg-gradient-to-r from-orange-500 to-red-600 p-4 text-white">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg">Examens Blancs</h3>
                                <p class="text-sm opacity-90">3 Février 2025</p>
                            </div>
                            <i class="fas fa-clipboard-check text-2xl opacity-50"></i>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 text-sm mb-3">
                            Début des examens blancs pour les classes d'examen
                        </p>
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="far fa-clock mr-2"></i>
                            Dans 1 mois
                        </div>
                    </div>
                </div>

                <!-- Event Card 4 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition event-badge">
                    <div class="bg-gradient-to-r from-purple-500 to-violet-600 p-4 text-white">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg">Vacances de Février</h3>
                                <p class="text-sm opacity-90">17 Février 2025</p>
                            </div>
                            <i class="fas fa-umbrella-beach text-2xl opacity-50"></i>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 text-sm mb-3">
                            Début des vacances scolaires - 2 semaines
                        </p>
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="far fa-clock mr-2"></i>
                            Dans 6 semaines
                        </div>
                    </div>
                </div>

                <!-- Event Card 5 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition event-badge">
                    <div class="bg-gradient-to-r from-pink-500 to-rose-600 p-4 text-white">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg">Journée Pédagogique</h3>
                                <p class="text-sm opacity-90">28 Mars 2025</p>
                            </div>
                            <i class="fas fa-chalkboard-teacher text-2xl opacity-50"></i>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 text-sm mb-3">
                            Formation continue des enseignants - Pas de cours
                        </p>
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="far fa-clock mr-2"></i>
                            Dans 2 mois
                        </div>
                    </div>
                </div>

                <!-- Event Card 6 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition event-badge">
                    <div class="bg-gradient-to-r from-indigo-500 to-blue-600 p-4 text-white">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg">BEPC 2025</h3>
                                <p class="text-sm opacity-90">15 Juin 2025</p>
                            </div>
                            <i class="fas fa-graduation-cap text-2xl opacity-50"></i>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 text-sm mb-3">
                            Début des épreuves du BEPC session 2025
                        </p>
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="far fa-clock mr-2"></i>
                            Dans 5 mois
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Legend -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="font-bold text-gray-900 mb-4">Légende des événements</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="flex items-center">
                        <span class="w-4 h-4 bg-red-500 rounded mr-2"></span>
                        <span class="text-sm text-gray-600">Jours fériés</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 bg-blue-500 rounded mr-2"></span>
                        <span class="text-sm text-gray-600">Rentrées/Reprises</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 bg-green-500 rounded mr-2"></span>
                        <span class="text-sm text-gray-600">Réunions</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 bg-orange-500 rounded mr-2"></span>
                        <span class="text-sm text-gray-600">Examens</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 bg-teal-500 rounded mr-2"></span>
                        <span class="text-sm text-gray-600">Vacances</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 bg-pink-500 rounded mr-2"></span>
                        <span class="text-sm text-gray-600">Événements spéciaux</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 bg-gray-500 rounded mr-2"></span>
                        <span class="text-sm text-gray-600">Journées pédagogiques</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 bg-emerald-500 rounded mr-2"></span>
                        <span class="text-sm text-gray-600">Examens nationaux</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section class="py-12 bg-gradient-to-r from-emerald-500 to-teal-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Ne manquez aucun événement</h2>
            <p class="text-xl opacity-90 mb-8">
                Synchronisez le calendrier scolaire avec votre téléphone
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="exportCalendar()" class="bg-white text-emerald-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    <i class="fas fa-download mr-2"></i>Télécharger (.ics)
                </button>
                <button onclick="shareCalendar()" class="bg-emerald-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-400 transition">
                    <i class="fas fa-share-alt mr-2"></i>Partager
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-600">
            <p>&copy; 2025 E-Library Côte d'Ivoire - Calendrier officiel MENET-FP</p>
        </div>
    </footer>

    <script>
        function previousMonth() {
            console.log('Navigation vers le mois précédent');
        }

        function nextMonth() {
            console.log('Navigation vers le mois suivant');
        }

        function exportCalendar() {
            alert('Téléchargement du calendrier au format .ics');
        }

        function printCalendar() {
            window.print();
        }

        function shareCalendar() {
            if (navigator.share) {
                navigator.share({
                    title: 'Calendrier Scolaire CI 2025',
                    text: 'Consultez le calendrier scolaire officiel de Côte d\'Ivoire',
                    url: window.location.href
                });
            } else {
                alert('Lien copié : ' + window.location.href);
            }
        }
    </script>
</body>
</html>