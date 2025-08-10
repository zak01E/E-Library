@extends('layouts.user-dashboard')

@section('page-title', 'Catégories')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Catégories</h1>
            <p class="text-gray-600 mt-1">Explorez notre collection par genre et thématique</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="text" placeholder="Rechercher une catégorie..." 
                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <div class="relative">
                <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Trier par popularité</option>
                    <option>Trier par nom</option>
                    <option>Trier par nombre de livres</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Categories Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-layer-group text-3xl opacity-80"></i>
                <span class="text-sm opacity-90">Total</span>
            </div>
            <h3 class="text-3xl font-bold mb-1">{{ $totalCategories ?? 24 }}</h3>
            <p class="text-sm opacity-90">Catégories</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-book text-2xl text-gray-400"></i>
                <span class="text-sm text-gray-500">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalBooks ?? '1.2K' }}</h3>
            <p class="text-sm text-gray-600">Livres</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-fire text-2xl text-orange-400"></i>
                <span class="text-sm text-gray-500">Plus populaire</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $mostPopularCategory ?? 'Fiction' }}</h3>
            <p class="text-sm text-gray-600">{{ $mostPopularCount ?? 156 }} livres</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-plus text-2xl text-gray-400"></i>
                <span class="text-sm text-gray-500">Ce mois</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $newBooksThisMonth ?? 45 }}</h3>
            <p class="text-sm text-gray-600">Nouveaux livres</p>
        </div>
    </div>

    <!-- Featured Categories -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $featuredCategories = [
                [
                    'name' => 'Fiction',
                    'description' => 'Romans, nouvelles et récits imaginaires',
                    'count' => 156,
                    'color' => 'blue',
                    'icon' => 'fas fa-book',
                    'image' => '/images/categories/fiction.jpg'
                ],
                [
                    'name' => 'Science-Fiction',
                    'description' => 'Explorez les mondes futuristes et technologies avancées',
                    'count' => 89,
                    'color' => 'purple',
                    'icon' => 'fas fa-rocket',
                    'image' => '/images/categories/scifi.jpg'
                ],
                [
                    'name' => 'Romance',
                    'description' => 'Histoires d\'amour et relations passionnées',
                    'count' => 67,
                    'color' => 'pink',
                    'icon' => 'fas fa-heart',
                    'image' => '/images/categories/romance.jpg'
                ],
                [
                    'name' => 'Thriller',
                    'description' => 'Suspense, mystère et frissons garantis',
                    'count' => 45,
                    'color' => 'red',
                    'icon' => 'fas fa-mask',
                    'image' => '/images/categories/thriller.jpg'
                ],
                [
                    'name' => 'Biographie',
                    'description' => 'Vies extraordinaires et témoignages authentiques',
                    'count' => 34,
                    'color' => 'green',
                    'icon' => 'fas fa-user',
                    'image' => '/images/categories/biography.jpg'
                ],
                [
                    'name' => 'Fantaisie',
                    'description' => 'Magie, créatures mythiques et mondes enchantés',
                    'count' => 28,
                    'color' => 'indigo',
                    'icon' => 'fas fa-magic',
                    'image' => '/images/categories/fantasy.jpg'
                ]
            ];
        @endphp

        @foreach($featuredCategories as $category)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
            <div class="relative h-32 bg-gradient-to-br from-{{ $category['color'] }}-400 to-{{ $category['color'] }}-600">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <i class="{{ $category['icon'] }} text-4xl text-white opacity-80"></i>
                </div>
                <div class="absolute top-3 right-3">
                    <span class="bg-white bg-opacity-20 text-white text-xs font-medium px-2 py-1 rounded-full">
                        {{ $category['count'] }} livres
                    </span>
                </div>
            </div>
            
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $category['name'] }}</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $category['description'] }}</p>
                
                <!-- Popular Books Preview -->
                <div class="flex items-center space-x-2 mb-4">
                    <span class="text-xs text-gray-500">Populaires :</span>
                    <div class="flex -space-x-1">
                        @for($i = 0; $i < 3; $i++)
                        <div class="w-6 h-8 bg-gray-200 rounded border-2 border-white"></div>
                        @endfor
                    </div>
                    <span class="text-xs text-gray-500">+{{ $category['count'] - 3 }}</span>
                </div>

                <!-- Stats -->
                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        <span>4.{{ rand(2, 8) }}/5</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-eye mr-1"></i>
                        <span>{{ number_format($category['count'] * rand(10, 50)) }} vues</span>
                    </div>
                </div>

                <!-- Action -->
                <a href="{{ route('books.public.index') }}?category={{ strtolower($category['name']) }}" 
                   class="block w-full bg-{{ $category['color'] }}-600 hover:bg-{{ $category['color'] }}-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-arrow-right mr-2"></i>Explorer
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- All Categories Grid -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900">Toutes les catégories</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                @php
                    $allCategories = [
                        'Action' => 23, 'Aventure' => 34, 'Comédie' => 18, 'Drame' => 45,
                        'Horreur' => 12, 'Mystère' => 28, 'Policier' => 31, 'Historique' => 22,
                        'Philosophie' => 15, 'Psychologie' => 19, 'Santé' => 14, 'Cuisine' => 8,
                        'Voyage' => 16, 'Art' => 11, 'Musique' => 9, 'Sport' => 7,
                        'Technologie' => 25, 'Business' => 33, 'Éducation' => 41, 'Jeunesse' => 67,
                        'Poésie' => 13, 'Théâtre' => 6, 'Essai' => 29, 'Autobiographie' => 21
                    ];
                @endphp
                
                @foreach($allCategories as $name => $count)
                <a href="{{ route('books.public.index') }}?category={{ strtolower($name) }}" 
                   class="p-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-center transition-colors group">
                    <div class="text-lg font-semibold text-gray-900 mb-1">{{ $name }}</div>
                    <div class="text-xs text-gray-500">{{ $count }} livre{{ $count > 1 ? 's' : '' }}</div>
                    <div class="text-xs text-blue-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        Voir →
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Category Suggestions -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-8 text-white">
        <div class="max-w-2xl mx-auto text-center">
            <h3 class="text-2xl font-bold mb-4">Découvrez de nouveaux horizons</h3>
            <p class="text-blue-100 mb-6">
                Sortez de votre zone de confort et explorez des genres que vous n'avez jamais essayés. 
                Nos recommandations personnalisées vous aideront à découvrir vos prochains coups de cœur.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                    <i class="fas fa-magic mr-2"></i>Recommandations personnalisées
                </button>
                <a href="{{ route('user.discover.popular') }}" 
                   class="bg-blue-500 bg-opacity-50 text-white px-6 py-3 rounded-lg font-semibold hover:bg-opacity-70 transition-colors">
                    <i class="fas fa-fire mr-2"></i>Voir les populaires
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Category Filter Modal -->
<div x-data="{ showFilterModal: false }" x-show="showFilterModal" 
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
     x-transition style="display: none;">
    <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Filtrer par catégories</h3>
            <button @click="showFilterModal = false" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            @foreach($allCategories as $name => $count)
            <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                <input type="checkbox" class="mr-3 text-blue-600 focus:ring-blue-500">
                <div class="flex-1">
                    <div class="text-sm font-medium text-gray-900">{{ $name }}</div>
                    <div class="text-xs text-gray-500">{{ $count }} livre{{ $count > 1 ? 's' : '' }}</div>
                </div>
            </label>
            @endforeach
        </div>
        <div class="flex justify-end space-x-3 pt-4 mt-4 border-t">
            <button @click="showFilterModal = false" 
                    class="px-4 py-2 text-gray-600 hover:text-gray-800">
                Annuler
            </button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Appliquer les filtres
            </button>
        </div>
    </div>
</div>
@endsection
