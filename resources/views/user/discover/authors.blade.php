@extends('layouts.user-dashboard')

@section('page-title', 'Auteurs')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Découvrir les Auteurs</h1>
            <p class="text-gray-600 mt-1">Explorez les créateurs qui enrichissent notre bibliothèque</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="text" placeholder="Rechercher un auteur..." 
                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <div class="relative">
                <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Plus populaires</option>
                    <option>Plus récents</option>
                    <option>Par nom A-Z</option>
                    <option>Plus de livres</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Author Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-users text-3xl opacity-80"></i>
                <span class="text-sm opacity-90">Total</span>
            </div>
            <h3 class="text-3xl font-bold mb-1">{{ $totalAuthors ?? 48 }}</h3>
            <p class="text-sm opacity-90">Auteurs</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-book text-2xl text-gray-400"></i>
                <span class="text-sm text-gray-500">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalBooks ?? 256 }}</h3>
            <p class="text-sm text-gray-600">Livres publiés</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-star text-2xl text-yellow-400"></i>
                <span class="text-sm text-gray-500">Nouveaux</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $newAuthors ?? 5 }}</h3>
            <p class="text-sm text-gray-600">Ce mois</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-fire text-2xl text-orange-400"></i>
                <span class="text-sm text-gray-500">Tendance</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $trendingCount ?? 12 }}</h3>
            <p class="text-sm text-gray-600">Auteurs populaires</p>
        </div>
    </div>

    <!-- Featured Authors -->
    @if(isset($featuredAuthors) && $featuredAuthors->count() > 0)
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Auteurs en vedette</h2>
                <span class="text-sm text-gray-500">Les plus actifs cette semaine</span>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($featuredAuthors as $author)
                <div class="text-center group">
                    <div class="relative inline-block mb-3">
                        @if($author->avatar)
                            <img src="{{ asset('storage/' . $author->avatar) }}" 
                                 alt="{{ $author->name }}"
                                 class="w-20 h-20 rounded-full object-cover group-hover:scale-105 transition-transform">
                        @else
                            <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                {{ strtoupper(substr($author->name, 0, 2)) }}
                            </div>
                        @endif
                        @if($author->is_verified ?? false)
                            <div class="absolute -bottom-1 -right-1 bg-blue-500 text-white rounded-full p-1">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                        @endif
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">{{ $author->name }}</h3>
                    <p class="text-sm text-gray-600 mb-2">{{ $author->books_count ?? 0 }} livres</p>
                    <a href="{{ route('authors.show', $author->id) }}" 
                       class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        Voir profil
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- All Authors Grid -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Tous les auteurs</h2>
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
            </div>
        </div>
        
        <div class="p-6">
            @if(isset($authors) && $authors->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($authors as $author)
                    <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                        <div class="flex items-start space-x-3">
                            @if($author->avatar ?? false)
                                <img src="{{ asset('storage/' . $author->avatar) }}" 
                                     alt="{{ $author->name }}"
                                     class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                                    {{ strtoupper(substr($author->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-900 truncate">{{ $author->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $author->books_count ?? 0 }} livre(s)</p>
                                <p class="text-xs text-gray-500 mt-1">{{ number_format($author->total_views ?? 0) }} vues</p>
                                <a href="{{ route('authors.show', $author->id) }}" 
                                   class="text-blue-600 hover:text-blue-700 text-xs font-medium mt-2 inline-block">
                                    Voir les livres →
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if(method_exists($authors, 'links'))
                    <div class="mt-6">
                        {{ $authors->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun auteur trouvé</h3>
                    <p class="text-gray-500">Les auteurs apparaîtront ici une fois qu'ils auront publié des livres</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection