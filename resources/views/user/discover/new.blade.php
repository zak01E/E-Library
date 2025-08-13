@extends('layouts.user-dashboard')

@section('page-title', 'Nouveautés')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Nouveautés</h1>
            <p class="text-gray-600 mt-1">Découvrez les derniers livres ajoutés à notre collection</p>
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
                    <option>Ces 3 derniers mois</option>
                    <option>Cette année</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Featured New Release -->
    @if(isset($featuredBook))
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg overflow-hidden">
        <div class="flex items-center p-8">
            <div class="flex-shrink-0 mr-8">
                <img src="{{ $featuredBook->cover_image ?? '/images/default-book-cover.jpg' }}" 
                     alt="{{ $featuredBook->title }}" 
                     class="w-32 h-40 object-cover rounded-lg shadow-lg">
            </div>
            <div class="flex-1 text-white">
                <div class="flex items-center mb-2">
                    <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full mr-3">
                        NOUVEAUTÉ
                    </span>
                    <span class="text-blue-100 text-sm">
                        Ajouté le {{ $featuredBook->created_at ? $featuredBook->created_at->format('d/m/Y') : '10/08/2024' }}
                    </span>
                </div>
                <h2 class="text-3xl font-bold mb-2">{{ $featuredBook->title }}</h2>
                <p class="text-xl text-blue-100 mb-4">par {{ $featuredBook->author }}</p>
                <p class="text-blue-100 mb-6 line-clamp-3">{{ $featuredBook->description ?? 'Une nouvelle aventure captivante qui vous tiendra en haleine du début à la fin.' }}</p>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('books.public.show', $featuredBook->id) }}" 
                       class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                        <i class="fas fa-eye mr-2"></i>Découvrir
                    </a>
                    <button class="bg-blue-500 bg-opacity-50 text-white px-6 py-3 rounded-lg font-semibold hover:bg-opacity-70 transition-colors">
                        <i class="fas fa-heart mr-2"></i>Ajouter aux favoris
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- New Releases Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-plus-circle text-3xl opacity-80"></i>
                <span class="text-sm opacity-90">Cette semaine</span>
            </div>
            <h3 class="text-3xl font-bold mb-1">{{ $weeklyCount ?? 12 }}</h3>
            <p class="text-sm opacity-90">Nouveaux livres</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-calendar text-2xl text-gray-400"></i>
                <span class="text-sm text-gray-500">Ce mois</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $monthlyCount ?? 45 }}</h3>
            <p class="text-sm text-gray-600">Nouveaux livres</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-fire text-2xl text-orange-400"></i>
                <span class="text-sm text-gray-500">Tendance</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $trendingGenre ?? 'Sci-Fi' }}</h3>
            <p class="text-sm text-gray-600">Genre populaire</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-star text-2xl text-yellow-400"></i>
                <span class="text-sm text-gray-500">Moyenne</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $averageRating ?? 4.5 }}/5</h3>
            <p class="text-sm text-gray-600">Note nouveautés</p>
        </div>
    </div>

    <!-- New Books Grid -->
    @if(isset($newBooks) && $newBooks->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($newBooks as $book)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                <div class="relative">
                    <img src="{{ $book->cover_image ?? '/images/default-book-cover.jpg' }}" 
                         alt="{{ $book->title }}" 
                         class="w-full h-48 object-cover">
                    
                    <!-- New Badge -->
                    <div class="absolute top-3 left-3">
                        <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                            NOUVEAU
                        </span>
                    </div>

                    <!-- Quick Actions -->
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="flex flex-col space-y-2">
                            <button class="p-2 bg-white rounded-full text-gray-700 hover:text-red-500 shadow-md transition-colors"
                                    title="Ajouter aux favoris">
                                <i class="fas fa-heart text-sm"></i>
                            </button>
                            <button class="p-2 bg-white rounded-full text-gray-700 hover:text-blue-500 shadow-md transition-colors"
                                    title="Ajouter à une collection">
                                <i class="fas fa-folder-plus text-sm"></i>
                            </button>
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
                    
                    <!-- Genre and Date -->
                    <div class="flex items-center justify-between mb-3">
                        @if(isset($book->genre))
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                            {{ $book->genre }}
                        </span>
                        @endif
                        <span class="text-xs text-gray-500">
                            {{ $book->created_at ? $book->created_at->diffForHumans() : 'Il y a 2 jours' }}
                        </span>
                    </div>

                    <!-- Description -->
                    @if(isset($book->description))
                    <p class="text-gray-600 text-xs mb-4 line-clamp-2">{{ $book->description }}</p>
                    @endif

                    <!-- Book Info -->
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                        @if(isset($book->pages))
                        <span>
                            <i class="fas fa-file-alt mr-1"></i>
                            {{ $book->pages }} pages
                        </span>
                        @endif
                        @if(isset($book->language))
                        <span>
                            <i class="fas fa-language mr-1"></i>
                            {{ $book->language }}
                        </span>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('books.public.show', $book->id) }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-eye mr-2"></i>Découvrir
                        </a>
                        <button class="p-2 text-gray-400 hover:text-green-500 transition-colors" 
                                title="Commencer la lecture">
                            <i class="fas fa-play"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if(method_exists($newBooks, 'links'))
            <div class="mt-8">
                {{ $newBooks->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-plus-circle text-3xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Aucune nouveauté pour le moment</h3>
                <p class="text-gray-600 mb-6">
                    Il n'y a pas de nouveaux livres dans la période sélectionnée. Revenez bientôt pour découvrir nos dernières additions !
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('books.public.index') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                        <i class="fas fa-book mr-2"></i>
                        Voir tous les livres
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

    <!-- Newsletter Subscription -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl p-8 text-white">
        <div class="max-w-2xl mx-auto text-center">
            <h3 class="text-2xl font-bold mb-4">Ne ratez aucune nouveauté !</h3>
            <p class="text-purple-100 mb-6">
                Inscrivez-vous à notre newsletter pour être informé en premier des nouvelles sorties et des recommandations personnalisées.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                <input type="email" placeholder="Votre adresse email" 
                       class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white">
                <button class="bg-white text-teal-600 px-6 py-3 rounded-lg font-semibold hover:bg-purple-50 transition-colors">
                    S'abonner
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
