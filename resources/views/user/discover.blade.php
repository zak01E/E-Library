@extends('layouts.user-dashboard')

@section('page-title', 'Découvrir')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-sm p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Découvrir de nouveaux livres</h1>
                <p class="text-blue-100 text-lg">Explorez notre bibliothèque et trouvez votre prochaine lecture</p>
            </div>
            <div class="hidden md:block">
                <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-compass text-4xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('user.discover.new') }}" 
           class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow text-center group">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-green-200 transition-colors">
                <i class="fas fa-sparkles text-green-600 text-xl"></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Nouveautés</h3>
            <p class="text-sm text-gray-600">Livres récents</p>
        </a>

        <a href="{{ route('user.discover.popular') }}" 
           class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow text-center group">
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-red-200 transition-colors">
                <i class="fas fa-fire text-red-600 text-xl"></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Populaires</h3>
            <p class="text-sm text-gray-600">Les plus lus</p>
        </a>

        <a href="{{ route('user.discover.categories') }}" 
           class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow text-center group">
            <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-200 transition-colors">
                <i class="fas fa-layer-group text-teal-600 text-xl"></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Catégories</h3>
            <p class="text-sm text-gray-600">Par genre</p>
        </a>

        <a href="{{ route('books.public.index') }}" 
           class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow text-center group">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-200 transition-colors">
                <i class="fas fa-globe text-blue-600 text-xl"></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Bibliothèque</h3>
            <p class="text-sm text-gray-600">Catalogue complet</p>
        </a>
    </div>

    <!-- Recommendations personnalisées -->
    @if(isset($recommendations) && $recommendations->count() > 0)
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Recommandé pour vous</h2>
                <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Voir plus
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($recommendations as $book)
                <div class="group">
                    <div class="relative aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden mb-2">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                 alt="{{ $book->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-book text-gray-400 text-2xl"></i>
                            </div>
                        @endif
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 truncate">{{ $book->title }}</h4>
                    <p class="text-xs text-gray-600">{{ $book->author_name }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Trending Books -->
    @if(isset($trending) && $trending->count() > 0)
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-chart-line text-orange-500 mr-2"></i>
                    <h2 class="text-lg font-semibold text-gray-900">Tendances actuelles</h2>
                </div>
                <a href="{{ route('user.discover.popular') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Voir tout
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($trending->take(6) as $book)
                <a href="{{ route('books.public.show', $book) }}" class="group">
                    <div class="relative aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden mb-2">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                 alt="{{ $book->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                                <i class="fas fa-book text-white text-2xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2 bg-orange-500 text-white text-xs px-2 py-1 rounded-full">
                            <i class="fas fa-fire mr-1"></i>{{ $book->views }}
                        </div>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 truncate">{{ $book->title }}</h4>
                    <p class="text-xs text-gray-600">{{ $book->author_name }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- New Releases -->
    @if(isset($newReleases) && $newReleases->count() > 0)
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-sparkles text-green-500 mr-2"></i>
                    <h2 class="text-lg font-semibold text-gray-900">Nouvelles sorties</h2>
                </div>
                <a href="{{ route('user.discover.new') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Voir tout
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($newReleases->take(6) as $book)
                <a href="{{ route('books.public.show', $book) }}" class="group">
                    <div class="relative aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden mb-2">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                 alt="{{ $book->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                                <i class="fas fa-book text-white text-2xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                            Nouveau
                        </div>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 truncate">{{ $book->title }}</h4>
                    <p class="text-xs text-gray-600">{{ $book->author_name }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Popular Categories -->
    @if(isset($popularCategories) && $popularCategories->count() > 0)
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Catégories populaires</h2>
                <a href="{{ route('user.discover.categories') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Toutes les catégories
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($popularCategories->take(8) as $category)
                <a href="{{ route('user.discover.category', $category->slug ?? strtolower($category->name)) }}" 
                   class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors group">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                        <i class="fas fa-folder text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">{{ $category->name }}</h4>
                        <p class="text-xs text-gray-600">{{ $category->books_count }} livres</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection