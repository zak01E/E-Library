<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier Scolaire - {{ site_name() }}</title>
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
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
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
<body class="bg-gray-50 min-h-screen" x-data="{ mobileMenuOpen: false }">

    @include('partials.public-header')

    <!-- Hero Section -->
    <section class="relative py-16 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-100 to-teal-100 opacity-30"></div>
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
                <div class="glass rounded-xl p-4 text-center card-hover">
                    <div class="text-3xl font-bold text-emerald-700">180</div>
                    <div class="text-sm text-gray-600">Jours de cours</div>
                </div>
                <div class="glass rounded-xl p-4 text-center card-hover">
                    <div class="text-3xl font-bold text-teal-700">3</div>
                    <div class="text-sm text-gray-600">Trimestres</div>
                </div>
                <div class="glass rounded-xl p-4 text-center card-hover">
                    <div class="text-3xl font-bold text-emerald-600">12</div>
                    <div class="text-sm text-gray-600">Jours fériés</div>
                </div>
                <div class="glass rounded-xl p-4 text-center card-hover">
                    <div class="text-3xl font-bold text-teal-600">4</div>
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
                <h2 class="text-3xl font-bold text-gray-900">{{ $startDate->format('F Y') ?? 'Janvier 2025' }}</h2>
                <button onclick="nextMonth()" class="glass px-4 py-2 rounded-lg hover:bg-white transition">
                    Suivant<i class="fas fa-chevron-right ml-2"></i>
                </button>
            </div>

            <!-- Calendar Grid -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
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
                            <span class="inline-block w-full bg-emerald-100 text-emerald-700 text-xs px-1 py-0.5 rounded">
                                Rentrée
                            </span>
                        </div>
                        @elseif($i == 15)
                        <div class="mt-1">
                            <span class="inline-block w-full bg-teal-100 text-teal-700 text-xs px-1 py-0.5 rounded">
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
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 event-badge card-hover border border-gray-100">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-4 text-white">
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
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 event-badge card-hover border border-gray-100">
                    <div class="bg-gradient-to-r from-teal-500 to-emerald-600 p-4 text-white">
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
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 event-badge card-hover border border-gray-100">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-700 p-4 text-white">
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
    </script>
</body>
</html>