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

    <!-- Hero Section Compact -->
    <section class="relative py-8 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-100 to-teal-100 opacity-30"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Calendrier Scolaire 2024-2025
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Année académique ivoirienne
                    </p>
                </div>
                <!-- Quick Stats Inline -->
                <div class="hidden md:flex gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-emerald-700">180</div>
                        <div class="text-xs text-gray-600">Jours cours</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-teal-700">3</div>
                        <div class="text-xs text-gray-600">Trimestres</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-emerald-600">12</div>
                        <div class="text-xs text-gray-600">Jours fériés</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Month View -->
    <section class="py-4" x-data="calendarApp()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Month Navigation -->
            <div class="flex justify-between items-center mb-4">
                <button @click="previousMonth()" class="glass px-3 py-1.5 rounded-lg hover:bg-white transition text-sm">
                    <i class="fas fa-chevron-left mr-1"></i>Précédent
                </button>
                <h2 class="text-2xl font-bold text-gray-900" x-text="currentMonthYear"></h2>
                <button @click="nextMonth()" class="glass px-3 py-1.5 rounded-lg hover:bg-white transition text-sm">
                    Suivant<i class="fas fa-chevron-right ml-1"></i>
                </button>
            </div>

            <!-- Calendar Grid Compact -->
            <div class="bg-white rounded-xl shadow-lg p-4 border border-gray-100">
                <div class="grid grid-cols-7 gap-1 mb-2">
                    <template x-for="day in ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']">
                        <div class="text-center font-semibold text-gray-600 text-xs py-1" x-text="day"></div>
                    </template>
                </div>

                <div class="grid grid-cols-7 gap-1">
                    <template x-for="day in calendarDays" :key="day.date">
                        <div class="p-1 border border-gray-200 rounded hover:bg-gray-50 transition relative group min-h-[60px]" 
                             :class="{'bg-gray-100': !day.currentMonth, 'bg-emerald-50': day.isToday}">
                            <div class="text-xs font-semibold" :class="day.currentMonth ? 'text-gray-700' : 'text-gray-400'" x-text="day.day"></div>
                        
                            <template x-if="day.event">
                                <div class="mt-0.5">
                                    <span class="inline-block w-full text-[10px] px-0.5 py-0.5 rounded truncate"
                                          :class="{
                                              'bg-red-100 text-red-700': day.event.type === 'holiday',
                                              'bg-emerald-100 text-emerald-700': day.event.type === 'school',
                                              'bg-teal-100 text-teal-700': day.event.type === 'meeting'
                                          }" 
                                          x-text="day.event.title"></span>
                                </div>
                            </template>

                            <!-- Hover Tooltip -->
                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block z-10">
                                <div class="bg-gray-900 text-white text-xs rounded-lg py-1 px-2 whitespace-nowrap">
                                    <span x-text="day.fullDate"></span>
                                    <template x-if="day.event">
                                        <div x-text="': ' + day.event.title"></div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Événements à venir</h2>
            
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
        function calendarApp() {
            return {
                currentDate: new Date(),
                currentMonth: new Date().getMonth(),
                currentYear: new Date().getFullYear(),
                calendarDays: [],
                events: {
                    '2025-01-01': { title: 'Nouvel An', type: 'holiday' },
                    '2025-01-06': { title: 'Rentrée', type: 'school' },
                    '2025-01-15': { title: 'Réunion', type: 'meeting' },
                    '2025-02-03': { title: 'Examens', type: 'school' },
                    '2025-02-14': { title: 'St-Valentin', type: 'holiday' },
                    '2025-03-08': { title: 'Fête Femmes', type: 'holiday' },
                    '2025-04-21': { title: 'Pâques', type: 'holiday' },
                    '2025-05-01': { title: 'Fête Travail', type: 'holiday' },
                    '2025-06-15': { title: 'Fin Année', type: 'school' },
                    '2025-08-07': { title: 'Indépendance', type: 'holiday' },
                    '2025-09-15': { title: 'Rentrée', type: 'school' },
                    '2025-12-25': { title: 'Noël', type: 'holiday' }
                },
                
                get currentMonthYear() {
                    const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
                                   'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                    return months[this.currentMonth] + ' ' + this.currentYear;
                },
                
                init() {
                    this.generateCalendar();
                },
                
                generateCalendar() {
                    this.calendarDays = [];
                    const firstDay = new Date(this.currentYear, this.currentMonth, 1);
                    const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
                    const prevLastDay = new Date(this.currentYear, this.currentMonth, 0);
                    
                    // Ajuster pour commencer par lundi (0 = dimanche, 1 = lundi)
                    let startDay = firstDay.getDay();
                    startDay = startDay === 0 ? 6 : startDay - 1;
                    
                    // Jours du mois précédent
                    for (let i = startDay; i > 0; i--) {
                        const day = prevLastDay.getDate() - i + 1;
                        const date = new Date(this.currentYear, this.currentMonth - 1, day);
                        this.calendarDays.push(this.createDayObject(date, false));
                    }
                    
                    // Jours du mois actuel
                    for (let day = 1; day <= lastDay.getDate(); day++) {
                        const date = new Date(this.currentYear, this.currentMonth, day);
                        this.calendarDays.push(this.createDayObject(date, true));
                    }
                    
                    // Jours du mois suivant pour compléter la grille
                    const remainingDays = 42 - this.calendarDays.length;
                    for (let day = 1; day <= remainingDays; day++) {
                        const date = new Date(this.currentYear, this.currentMonth + 1, day);
                        this.calendarDays.push(this.createDayObject(date, false));
                    }
                },
                
                createDayObject(date, currentMonth) {
                    const dateStr = date.toISOString().split('T')[0];
                    const today = new Date();
                    const isToday = date.toDateString() === today.toDateString();
                    
                    return {
                        date: dateStr,
                        day: date.getDate(),
                        fullDate: date.toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }),
                        currentMonth: currentMonth,
                        isToday: isToday,
                        event: this.events[dateStr] || null
                    };
                },
                
                previousMonth() {
                    if (this.currentMonth === 0) {
                        this.currentMonth = 11;
                        this.currentYear--;
                    } else {
                        this.currentMonth--;
                    }
                    this.generateCalendar();
                },
                
                nextMonth() {
                    if (this.currentMonth === 11) {
                        this.currentMonth = 0;
                        this.currentYear++;
                    } else {
                        this.currentMonth++;
                    }
                    this.generateCalendar();
                }
            }
        }
    </script>
</body>
</html>