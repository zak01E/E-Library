@extends('layouts.user-dashboard')

@section('page-title', 'Livres Populaires')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Livres Populaires</h1>
            <p class="text-gray-600 mt-1">Découvrez les livres les plus appréciés par notre communauté</p>
        </div>
        <div class="flex items-center space-x-3">
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
                    <option>Cette semaine</option>
                    <option>Ce mois</option>
                    <option>Cette année</option>
                    <option>Tous les temps</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Top 3 Most Popular -->
    @if(isset($topBooks) && count($topBooks) >= 3)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($topBooks->take(3) as $index => $book)
        <div class="bg-gradient-to-br {{ $index === 0 ? 'from-yellow-400 to-yellow-600' : ($index === 1 ? 'from-gray-400 to-gray-600' : 'from-orange-400 to-orange-600') }} rounded-xl p-6 text-white relative overflow-hidden">
            <!-- Rank Badge -->
            <div class="absolute top-4 right-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <span class="text-2xl font-bold">#{{ $index + 1 }}</span>
                </div>
            </div>
            
            <div class="flex items-start space-x-4">
                <img src="{{ $book->cover_image ?? '/images/default-book-cover.jpg' }}" 
                     alt="{{ $book->title }}" 
                     class="w-16 h-20 object-cover rounded-lg shadow-lg flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-bold mb-1 line-clamp-2">{{ $book->title }}</h3>
                    <p class="text-sm opacity-90 mb-2">par {{ $book->author }}</p>
                    <div class="flex items-center mb-2">
                        <div class="flex items-center mr-3">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-sm {{ $i <= ($book->rating ?? 5) ? 'text-white' : 'text-white text-opacity-40' }}"></i>
                            @endfor
                        </div>
                        <span class="text-sm opacity-90">{{ $book->rating ?? 4.8 }}/5</span>
                    </div>
                    <p class="text-xs opacity-80">{{ $book->reads_count ?? 1250 }} lectures</p>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('books.public.show', $book->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-eye mr-2"></i>Découvrir
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Popularity Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-fire text-3xl opacity-80"></i>
                <span class="text-sm opacity-90">Total</span>
            </div>
            <h3 class="text-3xl font-bold mb-1">{{ $totalReads ?? '12.5K' }}</h3>
            <p class="text-sm opacity-90">Lectures</p>
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
                <i class="fas fa-users text-2xl text-gray-400"></i>
                <span class="text-sm text-gray-500">Lecteurs</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $activeReaders ?? '2.1K' }}</h3>
            <p class="text-sm text-gray-600">Actifs</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-heart text-2xl text-red-400"></i>
                <span class="text-sm text-gray-500">Favoris</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalFavorites ?? '856' }}</h3>
            <p class="text-sm text-gray-600">Total</p>
        </div>
    </div>

    <!-- Popular Books List -->
    @if(isset($popularBooks) && $popularBooks->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Classement des populaires</h2>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Affichage :</span>
                        <div class="flex bg-gray-100 rounded-lg p-1">
                            <button class="px-3 py-1 text-sm font-medium text-white bg-blue-600 rounded-md">
                                <i class="fas fa-list mr-1"></i>Liste
                            </button>
                            <button class="px-3 py-1 text-sm font-medium text-gray-600 hover:text-gray-900">
                                <i class="fas fa-th-large mr-1"></i>Grille
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="divide-y divide-gray-100">
                @foreach($popularBooks as $index => $book)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center space-x-4">
                        <!-- Rank -->
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 {{ $index < 3 ? 'bg-gradient-to-r from-yellow-400 to-yellow-600 text-white' : 'bg-gray-100 text-gray-600' }} rounded-full flex items-center justify-center font-bold">
                                #{{ $index + 1 }}
                            </div>
                        </div>

                        <!-- Book Cover -->
                        <div class="flex-shrink-0">
                            <img src="{{ $book->cover_image ?? '/images/default-book-cover.jpg' }}" 
                                 alt="{{ $book->title }}" 
                                 class="w-16 h-20 object-cover rounded-lg">
                        </div>

                        <!-- Book Info -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $book->title }}</h3>
                            <p class="text-gray-600 text-sm mb-2">par {{ $book->author }}</p>
                            
                            <!-- Stats -->
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <span>{{ $book->rating ?? 4.5 }}/5</span>
                                    <span class="ml-1">({{ $book->reviews_count ?? 234 }} avis)</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-eye mr-1"></i>
                                    <span>{{ $book->reads_count ?? 1250 }} lectures</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-heart mr-1"></i>
                                    <span>{{ $book->favorites_count ?? 89 }} favoris</span>
                                </div>
                            </div>

                            <!-- Genre -->
                            @if(isset($book->genre))
                            <div class="mt-2">
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                    {{ $book->genre }}
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Trending Indicator -->
                        @if($index < 5)
                        <div class="flex-shrink-0">
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center text-green-600">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span class="text-sm font-medium">+{{ rand(5, 25) }}%</span>
                                </div>
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            </div>
                        </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex-shrink-0">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('books.public.show', $book->id) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-eye mr-2"></i>Voir
                                </a>
                                <button class="p-2 text-gray-400 hover:text-red-500 transition-colors" 
                                        title="Ajouter aux favoris">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <button class="p-2 text-gray-400 hover:text-blue-500 transition-colors" 
                                        title="Ajouter à une collection">
                                    <i class="fas fa-folder-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        @if(method_exists($popularBooks, 'links'))
            <div class="mt-8">
                {{ $popularBooks->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-fire text-3xl text-red-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Aucun livre populaire trouvé</h3>
                <p class="text-gray-600 mb-6">
                    Il n'y a pas de données de popularité disponibles pour la période sélectionnée.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('books.public.index') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                        <i class="fas fa-book mr-2"></i>
                        Voir tous les livres
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

    <!-- Popular Genres -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Genres populaires</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @php
                $genres = [
                    ['name' => 'Fiction', 'count' => 156, 'color' => 'blue'],
                    ['name' => 'Romance', 'count' => 89, 'color' => 'pink'],
                    ['name' => 'Thriller', 'count' => 67, 'color' => 'red'],
                    ['name' => 'Sci-Fi', 'count' => 45, 'color' => 'purple'],
                    ['name' => 'Biographie', 'count' => 34, 'color' => 'green'],
                    ['name' => 'Fantaisie', 'count' => 28, 'color' => 'indigo']
                ];
            @endphp
            
            @foreach($genres as $genre)
            <a href="{{ route('user.discover.categories') }}?genre={{ strtolower($genre['name']) }}"
               class="p-4 bg-gray-50 hover:bg-gray-100 rounded-lg text-center transition-colors group">
                <div class="text-2xl font-bold text-gray-600 mb-1">{{ $genre['count'] }}</div>
                <div class="text-sm font-medium text-gray-800">{{ $genre['name'] }}</div>
                <div class="text-xs text-gray-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    Voir tout
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
