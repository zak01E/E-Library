@extends('layouts.user-dashboard')

@section('page-title', 'Mes Statistiques')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Mes Statistiques</h1>
            <p class="text-gray-600 mt-1">Suivez votre progression et vos habitudes de lecture</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="relative">
                <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Cette année</option>
                    <option>Ce mois</option>
                    <option>Cette semaine</option>
                    <option>Tous les temps</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-download mr-2"></i>Exporter
            </button>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <i class="fas fa-book text-2xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-sm opacity-90">Cette année</div>
                    <div class="text-xs opacity-75">+15% vs 2023</div>
                </div>
            </div>
            <h3 class="text-3xl font-bold mb-1">{{ $stats['books_read_year'] ?? 47 }}</h3>
            <p class="text-sm opacity-90">Livres lus</p>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-sm opacity-90">Total</div>
                    <div class="text-xs opacity-75">~2.5h/jour</div>
                </div>
            </div>
            <h3 class="text-3xl font-bold mb-1">{{ $stats['total_reading_time'] ?? '156h' }}</h3>
            <p class="text-sm opacity-90">Temps de lecture</p>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <i class="fas fa-star text-2xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-sm opacity-90">Moyenne</div>
                    <div class="text-xs opacity-75">Sur 47 livres</div>
                </div>
            </div>
            <h3 class="text-3xl font-bold mb-1">{{ $stats['average_rating'] ?? '4.3' }}/5</h3>
            <p class="text-sm opacity-90">Note donnée</p>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <i class="fas fa-target text-2xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-sm opacity-90">Objectif</div>
                    <div class="text-xs opacity-75">5 livres/mois</div>
                </div>
            </div>
            <h3 class="text-3xl font-bold mb-1">{{ $stats['goal_progress'] ?? '94' }}%</h3>
            <p class="text-sm opacity-90">Atteint</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Reading Progress Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Progression mensuelle</h2>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Livres lus</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Objectif</span>
                    </div>
                </div>
            </div>
            
            <!-- Simple Chart Placeholder -->
            <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-chart-line text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Graphique de progression</p>
                    <p class="text-sm text-gray-400">Chart.js sera intégré ici</p>
                </div>
            </div>
        </div>

        <!-- Genre Distribution -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Répartition par genre</h2>
                <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Voir détails
                </button>
            </div>
            
            <div class="space-y-4">
                @php
                    $genres = [
                        ['name' => 'Fiction', 'count' => 15, 'percentage' => 32, 'color' => 'blue'],
                        ['name' => 'Science-fiction', 'count' => 8, 'percentage' => 17, 'color' => 'purple'],
                        ['name' => 'Romance', 'count' => 6, 'percentage' => 13, 'color' => 'pink'],
                        ['name' => 'Thriller', 'count' => 5, 'percentage' => 11, 'color' => 'red'],
                        ['name' => 'Biographie', 'count' => 4, 'percentage' => 9, 'color' => 'green'],
                        ['name' => 'Autres', 'count' => 9, 'percentage' => 18, 'color' => 'gray']
                    ];
                @endphp
                
                @foreach($genres as $genre)
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <div class="w-3 h-3 bg-{{ $genre['color'] }}-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 flex-1">{{ $genre['name'] }}</span>
                        <span class="text-sm text-gray-500 mr-4">{{ $genre['count'] }} livres</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-20 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-{{ $genre['color'] }}-500 h-2 rounded-full" style="width: {{ $genre['percentage'] }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 w-8">{{ $genre['percentage'] }}%</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Detailed Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Reading Habits -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Habitudes de lecture</h2>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Temps moyen par livre</span>
                    <span class="text-sm font-medium text-gray-900">3.2 heures</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Pages moyennes par livre</span>
                    <span class="text-sm font-medium text-gray-900">284 pages</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Vitesse de lecture</span>
                    <span class="text-sm font-medium text-gray-900">89 pages/h</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Jour préféré</span>
                    <span class="text-sm font-medium text-gray-900">Dimanche</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Heure préférée</span>
                    <span class="text-sm font-medium text-gray-900">20h-22h</span>
                </div>
            </div>
        </div>

        <!-- Monthly Goals -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Objectifs mensuels</h2>
                <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Modifier
                </button>
            </div>
            
            <div class="space-y-4">
                <!-- Current Month Goal -->
                <div class="p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-blue-900">Août 2024</span>
                        <span class="text-sm text-blue-700">4/5 livres</span>
                    </div>
                    <div class="w-full bg-blue-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 80%"></div>
                    </div>
                    <p class="text-xs text-blue-700 mt-1">80% atteint - Plus que 1 livre !</p>
                </div>
                
                <!-- Previous Months -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between p-2">
                        <span class="text-sm text-gray-600">Juillet 2024</span>
                        <div class="flex items-center">
                            <span class="text-sm text-green-600 mr-2">5/5</span>
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-2">
                        <span class="text-sm text-gray-600">Juin 2024</span>
                        <div class="flex items-center">
                            <span class="text-sm text-green-600 mr-2">6/5</span>
                            <i class="fas fa-trophy text-yellow-500"></i>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-2">
                        <span class="text-sm text-gray-600">Mai 2024</span>
                        <div class="flex items-center">
                            <span class="text-sm text-red-600 mr-2">3/5</span>
                            <i class="fas fa-times-circle text-red-500"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Achievements -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Réalisations</h2>
            
            <div class="space-y-4">
                <div class="flex items-center p-3 bg-yellow-50 rounded-lg">
                    <div class="p-2 bg-yellow-100 rounded-full mr-3">
                        <i class="fas fa-trophy text-yellow-600"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-yellow-900">Lecteur assidu</h4>
                        <p class="text-xs text-yellow-700">50 livres lus cette année</p>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                    <div class="p-2 bg-blue-100 rounded-full mr-3">
                        <i class="fas fa-star text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-blue-900">Critique éclairé</h4>
                        <p class="text-xs text-blue-700">25 avis laissés</p>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-green-50 rounded-lg">
                    <div class="p-2 bg-green-100 rounded-full mr-3">
                        <i class="fas fa-calendar-check text-green-600"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-green-900">Régularité</h4>
                        <p class="text-xs text-green-700">30 jours consécutifs</p>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-purple-50 rounded-lg">
                    <div class="p-2 bg-teal-100 rounded-full mr-3">
                        <i class="fas fa-layer-group text-teal-600"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-purple-900">Explorateur</h4>
                        <p class="text-xs text-purple-700">10 genres différents</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Activité récente</h2>
                <a href="{{ route('user.library.history') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Voir tout l'historique
                </a>
            </div>
        </div>
        
        <div class="p-6">
            <div class="space-y-4">
                @php
                    $activities = [
                        ['type' => 'completed', 'book' => 'Le Petit Prince', 'date' => 'Il y a 2 jours', 'rating' => 5],
                        ['type' => 'started', 'book' => '1984', 'date' => 'Il y a 3 jours', 'rating' => null],
                        ['type' => 'reviewed', 'book' => 'Dune', 'date' => 'Il y a 5 jours', 'rating' => 4],
                        ['type' => 'favorited', 'book' => 'Pride and Prejudice', 'date' => 'Il y a 1 semaine', 'rating' => null]
                    ];
                @endphp
                
                @foreach($activities as $activity)
                <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="flex-shrink-0">
                        @if($activity['type'] === 'completed')
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                        @elseif($activity['type'] === 'started')
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-play text-blue-600 text-sm"></i>
                            </div>
                        @elseif($activity['type'] === 'reviewed')
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-star text-yellow-600 text-sm"></i>
                            </div>
                        @else
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-heart text-red-600 text-sm"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-900">
                            @if($activity['type'] === 'completed')
                                Livre terminé : <span class="font-medium">{{ $activity['book'] }}</span>
                            @elseif($activity['type'] === 'started')
                                Lecture commencée : <span class="font-medium">{{ $activity['book'] }}</span>
                            @elseif($activity['type'] === 'reviewed')
                                Avis laissé sur : <span class="font-medium">{{ $activity['book'] }}</span>
                            @else
                                Ajouté aux favoris : <span class="font-medium">{{ $activity['book'] }}</span>
                            @endif
                        </p>
                        <p class="text-xs text-gray-500">{{ $activity['date'] }}</p>
                    </div>
                    
                    @if($activity['rating'])
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-xs {{ $i <= $activity['rating'] ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
