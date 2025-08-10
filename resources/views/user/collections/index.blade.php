@extends('layouts.user-dashboard')

@section('page-title', 'Mes Collections')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Mes Collections</h1>
            <p class="text-gray-600 mt-1">Organisez vos livres en collections personnalisées</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="text" placeholder="Rechercher une collection..." 
                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-plus mr-2"></i>Nouvelle collection
            </button>
        </div>
    </div>

    <!-- Collections Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-folder text-3xl opacity-80"></i>
                <span class="text-sm opacity-90">Total</span>
            </div>
            <h3 class="text-3xl font-bold mb-1">{{ $collections->count() ?? 8 }}</h3>
            <p class="text-sm opacity-90">Collections</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-book text-2xl text-gray-400"></i>
                <span class="text-sm text-gray-500">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalBooks ?? 156 }}</h3>
            <p class="text-sm text-gray-600">Livres organisés</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-star text-2xl text-yellow-400"></i>
                <span class="text-sm text-gray-500">Favorite</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $favoriteCollection ?? 'Sci-Fi' }}</h3>
            <p class="text-sm text-gray-600">{{ $favoriteCollectionCount ?? 24 }} livres</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-plus text-2xl text-gray-400"></i>
                <span class="text-sm text-gray-500">Ce mois</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $newCollections ?? 2 }}</h3>
            <p class="text-sm text-gray-600">Nouvelles</p>
        </div>
    </div>

    <!-- Collections Grid -->
    @if(isset($collections) && $collections->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($collections as $collection)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                <!-- Collection Header -->
                <div class="relative h-32 bg-gradient-to-br from-{{ $collection->color ?? 'blue' }}-400 to-{{ $collection->color ?? 'blue' }}-600">
                    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fas fa-{{ $collection->icon ?? 'folder' }} text-4xl text-white opacity-80"></i>
                    </div>
                    
                    <!-- Collection Actions -->
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="flex space-x-2">
                            <button class="p-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full text-white transition-colors"
                                    title="Modifier">
                                <i class="fas fa-edit text-sm"></i>
                            </button>
                            <button class="p-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full text-white transition-colors"
                                    title="Supprimer">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Book Count -->
                    <div class="absolute bottom-3 left-3">
                        <span class="bg-white bg-opacity-20 text-white text-xs font-medium px-2 py-1 rounded-full">
                            {{ $collection->books_count ?? rand(5, 25) }} livre{{ ($collection->books_count ?? rand(5, 25)) > 1 ? 's' : '' }}
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $collection->name ?? 'Collection ' . ($loop->index + 1) }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $collection->description ?? 'Une collection personnalisée de mes livres préférés.' }}</p>
                    
                    <!-- Book Preview -->
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="text-xs text-gray-500">Aperçu :</span>
                        <div class="flex -space-x-1">
                            @for($i = 0; $i < min(4, $collection->books_count ?? 4); $i++)
                            <div class="w-6 h-8 bg-gray-200 rounded border-2 border-white"></div>
                            @endfor
                            @if(($collection->books_count ?? 4) > 4)
                            <div class="w-6 h-8 bg-gray-100 rounded border-2 border-white flex items-center justify-center">
                                <span class="text-xs text-gray-500">+{{ ($collection->books_count ?? 4) - 4 }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Collection Stats -->
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-calendar mr-1"></i>
                            <span>{{ $collection->created_at ? $collection->created_at->format('M Y') : 'Mar 2024' }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-eye mr-1"></i>
                            <span>{{ $collection->views ?? rand(10, 100) }} vues</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('user.collections.show', $collection->id ?? 1) }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-eye mr-2"></i>Voir
                        </a>
                        <button class="p-2 text-gray-400 hover:text-blue-500 transition-colors" 
                                title="Ajouter des livres">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="p-2 text-gray-400 hover:text-green-500 transition-colors" 
                                title="Partager">
                            <i class="fas fa-share"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if(method_exists($collections, 'links'))
            <div class="mt-8">
                {{ $collections->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-folder-plus text-3xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Aucune collection créée</h3>
                <p class="text-gray-600 mb-6">
                    Créez votre première collection pour organiser vos livres par thème, genre ou tout autre critère qui vous convient.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <button class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Créer ma première collection
                    </button>
                    <a href="{{ route('books.public.index') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fas fa-book mr-2"></i>
                        Parcourir les livres
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <button class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <i class="fas fa-plus text-2xl text-blue-600 mb-2"></i>
                <span class="text-sm font-medium text-blue-900">Nouvelle collection</span>
            </button>
            
            <button class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <i class="fas fa-download text-2xl text-green-600 mb-2"></i>
                <span class="text-sm font-medium text-green-900">Importer</span>
            </button>
            
            <button class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                <i class="fas fa-share text-2xl text-purple-600 mb-2"></i>
                <span class="text-sm font-medium text-purple-900">Partager</span>
            </button>
            
            <button class="flex flex-col items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                <i class="fas fa-cog text-2xl text-orange-600 mb-2"></i>
                <span class="text-sm font-medium text-orange-900">Gérer</span>
            </button>
        </div>
    </div>
</div>

<!-- Create Collection Modal -->
<div x-data="{ showCreateModal: false }" x-show="showCreateModal" 
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
     x-transition style="display: none;">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Nouvelle collection</h3>
            <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form class="space-y-4">
            <div>
                <label for="collection_name" class="block text-sm font-medium text-gray-700 mb-2">Nom de la collection</label>
                <input type="text" id="collection_name" name="name" placeholder="Ex: Mes romans préférés"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div>
                <label for="collection_description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="collection_description" name="description" rows="3" placeholder="Décrivez votre collection..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Couleur</label>
                    <div class="flex space-x-2">
                        <button type="button" class="w-8 h-8 bg-blue-500 rounded-full border-2 border-blue-600"></button>
                        <button type="button" class="w-8 h-8 bg-green-500 rounded-full border-2 border-transparent hover:border-green-600"></button>
                        <button type="button" class="w-8 h-8 bg-purple-500 rounded-full border-2 border-transparent hover:border-purple-600"></button>
                        <button type="button" class="w-8 h-8 bg-red-500 rounded-full border-2 border-transparent hover:border-red-600"></button>
                    </div>
                </div>
                
                <div>
                    <label for="collection_icon" class="block text-sm font-medium text-gray-700 mb-2">Icône</label>
                    <select id="collection_icon" name="icon"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="folder">📁 Dossier</option>
                        <option value="book">📚 Livre</option>
                        <option value="star">⭐ Étoile</option>
                        <option value="heart">❤️ Cœur</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" @click="showCreateModal = false" 
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Créer la collection
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
