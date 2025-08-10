@extends('layouts.user-dashboard')

@section('page-title', 'En cours de lecture')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">En cours de lecture</h1>
            <p class="text-gray-600 mt-1">Suivez votre progression et reprenez là où vous vous êtes arrêté</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="relative">
                <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Tous les genres</option>
                    <option>Fiction</option>
                    <option>Science-fiction</option>
                    <option>Romance</option>
                    <option>Thriller</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
            <div class="relative">
                <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Trier par progression</option>
                    <option>Récemment lu</option>
                    <option>Titre A-Z</option>
                    <option>Auteur A-Z</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Reading Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-book-open text-3xl opacity-80"></i>
                <span class="text-sm opacity-90">Actuellement</span>
            </div>
            <h3 class="text-3xl font-bold mb-1">{{ $currentBooks->count() ?? 4 }}</h3>
            <p class="text-sm opacity-90">Livres en cours</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-clock text-2xl text-gray-400"></i>
                <span class="text-sm text-gray-500">Moyenne</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $averageProgress ?? 65 }}%</h3>
            <p class="text-sm text-gray-600">Progression</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-calendar text-2xl text-gray-400"></i>
                <span class="text-sm text-gray-500">Cette semaine</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $weeklyReadingTime ?? '8h' }}</h3>
            <p class="text-sm text-gray-600">Temps de lecture</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-target text-2xl text-gray-400"></i>
                <span class="text-sm text-gray-500">Objectif</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $monthlyGoal ?? 5 }}</h3>
            <p class="text-sm text-gray-600">Livres/mois</p>
        </div>
    </div>

    <!-- Books Grid -->
    @if(isset($currentBooks) && $currentBooks->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($currentBooks as $book)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="relative">
                    <img src="{{ $book->cover_image ?? '/images/default-book-cover.jpg' }}" 
                         alt="{{ $book->title }}" 
                         class="w-full h-48 object-cover">
                    <div class="absolute top-3 right-3">
                        <span class="bg-blue-600 text-white text-xs font-medium px-2 py-1 rounded-full">
                            {{ $book->progress ?? 45 }}%
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $book->title }}</h3>
                    <p class="text-gray-600 text-sm mb-3">par {{ $book->author }}</p>
                    
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-1">
                            <span>Progression</span>
                            <span>{{ $book->progress ?? 45 }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ $book->progress ?? 45 }}%"></div>
                        </div>
                    </div>

                    <!-- Reading Info -->
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                        <span>
                            <i class="fas fa-bookmark mr-1"></i>
                            Page {{ $book->current_page ?? 120 }} / {{ $book->total_pages ?? 280 }}
                        </span>
                        <span>
                            <i class="fas fa-clock mr-1"></i>
                            {{ $book->estimated_time ?? '2h 30min' }} restant
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('user.reading-room.read', $book->id) }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-play mr-2"></i>Continuer
                        </a>
                        <button class="p-2 text-gray-400 hover:text-red-500 transition-colors" 
                                title="Retirer de la liste">
                            <i class="fas fa-times"></i>
                        </button>
                        <button class="p-2 text-gray-400 hover:text-yellow-500 transition-colors" 
                                title="Marquer comme favori">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if(method_exists($currentBooks, 'links'))
            <div class="mt-8">
                {{ $currentBooks->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-book-open text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Aucune lecture en cours</h3>
                <p class="text-gray-600 mb-6">
                    Vous n'avez pas encore commencé de lecture. Découvrez notre collection et commencez votre première lecture !
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('books.public.index') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Découvrir des livres
                    </a>
                    <a href="{{ route('user.discover.new') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fas fa-sparkles mr-2"></i>
                        Voir les nouveautés
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Reading Goals Modal -->
<div x-data="{ showGoalsModal: false }" x-show="showGoalsModal" 
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
     x-transition style="display: none;">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Objectifs de lecture</h3>
            <button @click="showGoalsModal = false" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Livres par mois</label>
                <input type="number" value="5" min="1" max="50" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Minutes par jour</label>
                <input type="number" value="60" min="15" max="480" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex justify-end space-x-3 pt-4">
                <button @click="showGoalsModal = false" 
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Annuler
                </button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Sauvegarder
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
