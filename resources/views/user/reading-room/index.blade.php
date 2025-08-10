@extends('layouts.user-dashboard')

@section('page-title', 'Salle de lecture')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Salle de lecture</h1>
            <p class="text-gray-600 mt-1">Votre espace de lecture personnalisé et tranquille</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="relative">
                <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Mode lecture</option>
                    <option>Mode nuit</option>
                    <option>Mode sépia</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-play mr-2"></i>Continuer la lecture
            </button>
        </div>
    </div>

    <!-- Reading Environment -->
    <div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-xl p-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-glasses text-2xl text-green-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Bienvenue dans votre salle de lecture</h2>
                <p class="text-gray-600">Un environnement calme et personnalisé pour une expérience de lecture optimale</p>
            </div>

            <!-- Current Reading -->
            @if(isset($currentBook))
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <div class="flex items-center space-x-6">
                    <img src="{{ $currentBook->cover_image ?? '/images/default-book-cover.jpg' }}" 
                         alt="{{ $currentBook->title }}" 
                         class="w-24 h-32 object-cover rounded-lg shadow-md">
                    
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $currentBook->title }}</h3>
                        <p class="text-gray-600 mb-3">par {{ $currentBook->author }}</p>
                        
                        <!-- Progress -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-1">
                                <span>Progression</span>
                                <span>{{ $currentBook->progress ?? 45 }}% (Page {{ $currentBook->current_page ?? 120 }}/{{ $currentBook->total_pages ?? 280 }})</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full transition-all duration-300" 
                                     style="width: {{ $currentBook->progress ?? 45 }}%"></div>
                            </div>
                        </div>

                        <!-- Reading Stats -->
                        <div class="flex items-center space-x-6 text-sm text-gray-500 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-1"></i>
                                <span>{{ $currentBook->estimated_time ?? '2h 30min' }} restant</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-1"></i>
                                <span>Commencé le {{ $currentBook->started_at ?? '15 mars' }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('user.reading-room.read', $currentBook->id) }}" 
                               class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-play mr-2"></i>Continuer la lecture
                            </a>
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-bookmark mr-2"></i>Marque-pages
                            </button>
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-sticky-note mr-2"></i>Notes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Reading Tools -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bookmark text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Marque-pages</h3>
                    <p class="text-gray-600 text-sm mb-4">Sauvegardez vos passages préférés</p>
                    <button class="text-blue-600 hover:text-blue-700 font-medium">
                        Voir mes marque-pages ({{ $bookmarksCount ?? 12 }})
                    </button>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sticky-note text-yellow-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Notes</h3>
                    <p class="text-gray-600 text-sm mb-4">Prenez des notes pendant votre lecture</p>
                    <button class="text-yellow-600 hover:text-yellow-700 font-medium">
                        Mes notes ({{ $notesCount ?? 8 }})
                    </button>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-highlighter text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Surlignages</h3>
                    <p class="text-gray-600 text-sm mb-4">Mettez en évidence les passages importants</p>
                    <button class="text-purple-600 hover:text-purple-700 font-medium">
                        Mes surlignages ({{ $highlightsCount ?? 15 }})
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reading Activity -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Activité de lecture récente</h2>
                <a href="{{ route('user.library.history') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Voir tout l'historique
                </a>
            </div>
        </div>
        
        <div class="p-6">
            <div class="space-y-4">
                @php
                    $recentActivity = [
                        ['type' => 'reading', 'book' => 'Le Petit Prince', 'time' => '2h 15min', 'date' => 'Aujourd\'hui'],
                        ['type' => 'bookmark', 'book' => '1984', 'page' => 'Page 156', 'date' => 'Hier'],
                        ['type' => 'note', 'book' => 'Dune', 'content' => 'Passage intéressant sur...', 'date' => 'Il y a 2 jours'],
                        ['type' => 'highlight', 'book' => 'Pride and Prejudice', 'content' => 'Citation mémorable', 'date' => 'Il y a 3 jours']
                    ];
                @endphp
                
                @foreach($recentActivity as $activity)
                <div class="flex items-start space-x-4 p-4 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="flex-shrink-0">
                        @if($activity['type'] === 'reading')
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-book-reader text-green-600"></i>
                            </div>
                        @elseif($activity['type'] === 'bookmark')
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-bookmark text-blue-600"></i>
                            </div>
                        @elseif($activity['type'] === 'note')
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-sticky-note text-yellow-600"></i>
                            </div>
                        @else
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-highlighter text-purple-600"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-medium text-gray-900">{{ $activity['book'] }}</h4>
                            <span class="text-xs text-gray-500">{{ $activity['date'] }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">
                            @if($activity['type'] === 'reading')
                                Temps de lecture : {{ $activity['time'] }}
                            @elseif($activity['type'] === 'bookmark')
                                Marque-page ajouté - {{ $activity['page'] }}
                            @elseif($activity['type'] === 'note')
                                Note ajoutée : {{ $activity['content'] }}
                            @else
                                Texte surligné : {{ $activity['content'] }}
                            @endif
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Reading Preferences -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900">Préférences de lecture</h2>
            <p class="text-sm text-gray-600 mt-1">Personnalisez votre environnement de lecture</p>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Font Size -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Taille de police</label>
                    <div class="flex items-center space-x-2">
                        <button class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            <i class="fas fa-minus text-sm"></i>
                        </button>
                        <span class="px-4 py-2 bg-gray-50 rounded-lg text-sm font-medium">16px</span>
                        <button class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            <i class="fas fa-plus text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Theme -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Thème</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Clair</option>
                        <option>Sombre</option>
                        <option>Sépia</option>
                    </select>
                </div>

                <!-- Line Height -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Espacement</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Compact</option>
                        <option selected>Normal</option>
                        <option>Large</option>
                    </select>
                </div>

                <!-- Font Family -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Police</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Georgia</option>
                        <option selected>Times New Roman</option>
                        <option>Arial</option>
                        <option>Verdana</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="auto_bookmark" class="mr-3 text-blue-600 focus:ring-blue-500" checked>
                            <label for="auto_bookmark" class="text-sm text-gray-700">Marque-page automatique</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="reading_timer" class="mr-3 text-blue-600 focus:ring-blue-500">
                            <label for="reading_timer" class="text-sm text-gray-700">Minuteur de lecture</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="focus_mode" class="mr-3 text-blue-600 focus:ring-blue-500">
                            <label for="focus_mode" class="text-sm text-gray-700">Mode concentration (masquer les distractions)</label>
                        </div>
                    </div>
                    
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Sauvegarder
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Start -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-8 text-white">
        <div class="max-w-2xl mx-auto text-center">
            <h3 class="text-2xl font-bold mb-4">Prêt à commencer une nouvelle lecture ?</h3>
            <p class="text-blue-100 mb-6">
                Découvrez notre collection et trouvez votre prochain livre coup de cœur.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('books.public.index') }}" 
                   class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                    <i class="fas fa-search mr-2"></i>Parcourir les livres
                </a>
                <a href="{{ route('user.discover.new') }}" 
                   class="bg-blue-500 bg-opacity-50 text-white px-6 py-3 rounded-lg font-semibold hover:bg-opacity-70 transition-colors">
                    <i class="fas fa-sparkles mr-2"></i>Voir les nouveautés
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
