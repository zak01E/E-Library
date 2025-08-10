@extends('layouts.user-dashboard')

@section('page-title', 'Tableau de bord')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-sm p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Bienvenue, {{ auth()->user()->name }}!</h1>
                <p class="text-blue-100 text-lg">Découvrez votre univers de lecture personnalisé</p>
            </div>
            <div class="hidden md:block">
                <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-book-reader text-4xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Livres lus -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-book-open text-green-600 text-xl"></i>
                </div>
                <span class="text-sm text-gray-500">Ce mois</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['books_read'] ?? 8 }}</h3>
            <p class="text-sm text-gray-600">Livres lus</p>
            <div class="mt-2 flex items-center text-xs">
                <span class="text-green-600 font-medium">
                    <i class="fas fa-arrow-up mr-1"></i>+12%
                </span>
                <span class="text-gray-500 ml-1">vs mois dernier</span>
            </div>
        </div>

        <!-- En cours de lecture -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-book-reader text-blue-600 text-xl"></i>
                </div>
                <span class="text-sm text-gray-500">Actuellement</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['books_reading'] ?? 3 }}</h3>
            <p class="text-sm text-gray-600">En cours</p>
            <div class="mt-2">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                </div>
                <span class="text-xs text-gray-500 mt-1">Progression moyenne: 65%</span>
            </div>
        </div>

        <!-- Favoris -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-heart text-red-600 text-xl"></i>
                </div>
                <span class="text-sm text-gray-500">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['favorites'] ?? 24 }}</h3>
            <p class="text-sm text-gray-600">Favoris</p>
            <div class="mt-2 flex items-center text-xs">
                <span class="text-red-600 font-medium">
                    <i class="fas fa-plus mr-1"></i>2 nouveaux
                </span>
                <span class="text-gray-500 ml-1">cette semaine</span>
            </div>
        </div>

        <!-- Temps de lecture -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-clock text-purple-600 text-xl"></i>
                </div>
                <span class="text-sm text-gray-500">Cette semaine</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['reading_time'] ?? '12h' }}</h3>
            <p class="text-sm text-gray-600">Temps de lecture</p>
            <div class="mt-2 flex items-center text-xs">
                <span class="text-purple-600 font-medium">
                    <i class="fas fa-arrow-up mr-1"></i>+2h
                </span>
                <span class="text-gray-500 ml-1">vs semaine dernière</span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Continuer la lecture -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Continuer la lecture</h2>
                        <a href="{{ route('user.library.current') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            Voir tout
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if(isset($currentBooks) && count($currentBooks) > 0)
                        <div class="space-y-4">
                            @foreach($currentBooks as $book)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0">
                                    <img src="{{ $book->cover_image ?? '/images/default-book-cover.jpg' }}" 
                                         alt="{{ $book->title }}" 
                                         class="w-12 h-16 object-cover rounded">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-medium text-gray-900 truncate">{{ $book->title }}</h3>
                                    <p class="text-sm text-gray-500">{{ $book->author }}</p>
                                    <div class="mt-2">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $book->progress ?? 45 }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-500 mt-1">{{ $book->progress ?? 45 }}% terminé</span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('user.reading-room.read', $book->id) }}" 
                                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Lire
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-book-open text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune lecture en cours</h3>
                            <p class="text-gray-500 mb-4">Commencez à lire un livre pour le voir apparaître ici</p>
                            <a href="{{ route('books.public.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Découvrir des livres
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Recommandations -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Recommandé pour vous</h2>
                </div>
                <div class="p-6">
                    @if(isset($recommendations) && count($recommendations) > 0)
                        <div class="space-y-4">
                            @foreach($recommendations as $book)
                            <div class="flex items-start space-x-3">
                                <img src="{{ $book->cover_image ?? '/images/default-book-cover.jpg' }}" 
                                     alt="{{ $book->title }}" 
                                     class="w-10 h-12 object-cover rounded flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 truncate">{{ $book->title }}</h4>
                                    <p class="text-xs text-gray-500">{{ $book->author }}</p>
                                    <div class="flex items-center mt-1">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-xs {{ $i <= ($book->rating ?? 4) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="text-xs text-gray-500 ml-1">({{ $book->reviews_count ?? 12 }})</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-lightbulb text-2xl text-gray-300 mb-2"></i>
                            <p class="text-sm text-gray-500">Aucune recommandation disponible</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activité récente -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Activité récente</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900">Livre terminé</p>
                                <p class="text-xs text-gray-500">"Le Petit Prince" - Il y a 2 jours</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-bookmark text-blue-600 text-xs"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900">Ajouté aux favoris</p>
                                <p class="text-xs text-gray-500">"1984" - Il y a 3 jours</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-star text-purple-600 text-xs"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900">Avis laissé</p>
                                <p class="text-xs text-gray-500">"Dune" - 5 étoiles - Il y a 5 jours</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('books.public.index') }}" 
               class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <i class="fas fa-search text-2xl text-blue-600 mb-2"></i>
                <span class="text-sm font-medium text-blue-900">Découvrir</span>
            </a>
            
            <a href="{{ route('user.library.favorites') }}" 
               class="flex flex-col items-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                <i class="fas fa-heart text-2xl text-red-600 mb-2"></i>
                <span class="text-sm font-medium text-red-900">Favoris</span>
            </a>
            
            <a href="{{ route('user.stats.index') }}" 
               class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                <i class="fas fa-chart-bar text-2xl text-purple-600 mb-2"></i>
                <span class="text-sm font-medium text-purple-900">Statistiques</span>
            </a>
            
            <a href="{{ route('user.collections.index') }}" 
               class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <i class="fas fa-folder text-2xl text-green-600 mb-2"></i>
                <span class="text-sm font-medium text-green-900">Collections</span>
            </a>
        </div>
    </div>
</div>
@endsection
