@extends('layouts.user-dashboard')

@section('page-title', 'Mes Favoris')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Mes Favoris</h1>
            <p class="text-gray-600 mt-1">Vos livres préférés, toujours à portée de main</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="text" placeholder="Rechercher dans mes favoris..." 
                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <div class="relative">
                <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Tous les genres</option>
                    <option>Fiction</option>
                    <option>Science-fiction</option>
                    <option>Romance</option>
                    <option>Thriller</option>
                    <option>Biographie</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
            <div class="relative">
                <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Récemment ajouté</option>
                    <option>Titre A-Z</option>
                    <option>Auteur A-Z</option>
                    <option>Note décroissante</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Favorites Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-heart text-3xl opacity-80"></i>
                <span class="text-sm opacity-90">Total</span>
            </div>
            <h3 class="text-3xl font-bold mb-1">{{ $favorites->count() ?? 24 }}</h3>
            <p class="text-sm opacity-90">Favoris</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-star text-2xl text-yellow-400"></i>
                <span class="text-sm text-gray-500">Moyenne</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $averageRating ?? 4.3 }}/5</h3>
            <p class="text-sm text-gray-600">Note moyenne</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-layer-group text-2xl text-gray-400"></i>
                <span class="text-sm text-gray-500">Genres</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $genreCount ?? 8 }}</h3>
            <p class="text-sm text-gray-600">Différents</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-plus text-2xl text-gray-400"></i>
                <span class="text-sm text-gray-500">Ce mois</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $monthlyAdded ?? 3 }}</h3>
            <p class="text-sm text-gray-600">Ajoutés</p>
        </div>
    </div>

    <!-- View Toggle -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-600">Affichage :</span>
            <div class="flex bg-gray-100 rounded-lg p-1">
                <button class="px-3 py-1 text-sm font-medium text-white bg-blue-600 rounded-md">
                    <i class="fas fa-th-large mr-1"></i>Grille
                </button>
                <button class="px-3 py-1 text-sm font-medium text-gray-600 hover:text-gray-900">
                    <i class="fas fa-list mr-1"></i>Liste
                </button>
            </div>
        </div>
        <div class="text-sm text-gray-600">
            {{ $favorites->count() ?? 24 }} livre(s) favori(s)
        </div>
    </div>

    <!-- Books Grid -->
    @if(isset($favorites) && $favorites->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($favorites as $book)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                <div class="relative">
                    <img src="{{ $book->cover_image ?? '/images/default-book-cover.jpg' }}" 
                         alt="{{ $book->title }}" 
                         class="w-full h-48 object-cover">
                    
                    <!-- Overlay Actions -->
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <div class="flex space-x-2">
                            <a href="{{ route('books.public.show', $book->id) }}" 
                               class="p-2 bg-white rounded-full text-gray-700 hover:text-blue-600 transition-colors">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="p-2 bg-white rounded-full text-gray-700 hover:text-green-600 transition-colors"
                                    title="Commencer la lecture">
                                <i class="fas fa-play"></i>
                            </button>
                            <button class="p-2 bg-white rounded-full text-red-500 hover:text-red-600 transition-colors"
                                    title="Retirer des favoris">
                                <i class="fas fa-heart-broken"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Favorite Badge -->
                    <div class="absolute top-3 right-3">
                        <div class="bg-red-500 text-white p-2 rounded-full">
                            <i class="fas fa-heart text-sm"></i>
                        </div>
                    </div>

                    <!-- Rating -->
                    @if(isset($book->rating))
                    <div class="absolute bottom-3 left-3">
                        <div class="bg-black bg-opacity-70 text-white px-2 py-1 rounded-full text-xs flex items-center">
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                            {{ $book->rating }}
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $book->title }}</h3>
                    <p class="text-gray-600 text-sm mb-3">par {{ $book->author }}</p>
                    
                    <!-- Genre -->
                    @if(isset($book->genre))
                    <div class="mb-3">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                            {{ $book->genre }}
                        </span>
                    </div>
                    @endif

                    <!-- Description -->
                    @if(isset($book->description))
                    <p class="text-gray-600 text-xs mb-3 line-clamp-2">{{ $book->description }}</p>
                    @endif

                    <!-- Added Date -->
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                        <span>
                            <i class="fas fa-calendar-plus mr-1"></i>
                            Ajouté le {{ $book->favorited_at ?? '15 mars 2024' }}
                        </span>
                        @if(isset($book->pages))
                        <span>
                            <i class="fas fa-file-alt mr-1"></i>
                            {{ $book->pages }} pages
                        </span>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('books.public.show', $book->id) }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-eye mr-2"></i>Voir
                        </a>
                        <button class="p-2 text-gray-400 hover:text-green-500 transition-colors" 
                                title="Commencer la lecture">
                            <i class="fas fa-play"></i>
                        </button>
                        <button class="p-2 text-gray-400 hover:text-blue-500 transition-colors" 
                                title="Ajouter à une collection">
                            <i class="fas fa-folder-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if(method_exists($favorites, 'links'))
            <div class="mt-8">
                {{ $favorites->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-heart text-3xl text-red-500"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Aucun favori pour le moment</h3>
                <p class="text-gray-600 mb-6">
                    Vous n'avez pas encore ajouté de livres à vos favoris. Explorez notre collection et marquez vos coups de cœur !
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('books.public.index') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Découvrir des livres
                    </a>
                    <a href="{{ route('user.discover.popular') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fas fa-fire mr-2"></i>
                        Voir les populaires
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Remove from Favorites Modal -->
<div x-data="{ showRemoveModal: false, bookToRemove: null }" 
     x-show="showRemoveModal" 
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
     x-transition style="display: none;">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Retirer des favoris</h3>
            <button @click="showRemoveModal = false" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <p class="text-gray-600 mb-6">
            Êtes-vous sûr de vouloir retirer ce livre de vos favoris ? Vous pourrez toujours l'ajouter à nouveau plus tard.
        </p>
        <div class="flex justify-end space-x-3">
            <button @click="showRemoveModal = false" 
                    class="px-4 py-2 text-gray-600 hover:text-gray-800">
                Annuler
            </button>
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Retirer
            </button>
        </div>
    </div>
</div>
@endsection
