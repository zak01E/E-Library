@extends('layouts.app')

@section('title', 'Livres')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Découvrez nos livres</h1>
            <p class="text-gray-600 dark:text-gray-400">Explorez notre collection de livres numériques gratuits</p>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rechercher</label>
                    <input type="text" placeholder="Titre, auteur..." 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catégorie</label>
                    <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                        <option>Toutes les catégories</option>
                        <option>Fiction</option>
                        <option>Non-fiction</option>
                        <option>Science</option>
                        <option>Histoire</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Langue</label>
                    <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                        <option>Toutes les langues</option>
                        <option>Français</option>
                        <option>Anglais</option>
                        <option>Espagnol</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Trier par</label>
                    <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                        <option>Plus récents</option>
                        <option>Plus populaires</option>
                        <option>Mieux notés</option>
                        <option>Alphabétique</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($books as $book)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                <!-- Cover Image -->
                <div class="aspect-[3/4] relative">
                    @if($book->cover_image)
                        <img src="{{ Storage::url($book->cover_image) }}" 
                             alt="{{ $book->title }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-book text-white text-4xl"></i>
                        </div>
                    @endif
                    
                    <!-- Quick Actions -->
                    <div class="absolute top-2 right-2 flex space-x-1">
                        <button class="w-8 h-8 bg-white/80 hover:bg-white rounded-full flex items-center justify-center transition-colors">
                            <i class="fas fa-heart text-gray-600 text-sm"></i>
                        </button>
                        <button class="w-8 h-8 bg-white/80 hover:bg-white rounded-full flex items-center justify-center transition-colors">
                            <i class="fas fa-share text-gray-600 text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Book Info -->
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                        <a href="{{ route('books.public.show', $book) }}" class="hover:text-blue-600">
                            {{ $book->title }}
                        </a>
                    </h3>
                    
                    <!-- Author -->
                    <div class="flex items-center mb-3">
                        <div class="w-6 h-6 rounded-full overflow-hidden mr-2">
                            @if($book->uploader && $book->uploader->profile_photo_path)
                                <img src="{{ Storage::url($book->uploader->profile_photo_path) }}" 
                                     alt="{{ $book->uploader->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                                    <i class="fas fa-user text-white text-xs"></i>
                                </div>
                            @endif
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $book->uploader ? $book->uploader->name : 'Auteur inconnu' }}
                        </span>
                    </div>

                    <!-- Description -->
                    @if($book->description)
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                        {{ Str::limit($book->description, 100) }}
                    </p>
                    @endif

                    <!-- Stats -->
                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-3">
                        <div class="flex items-center">
                            <i class="fas fa-download mr-1"></i>
                            {{ number_format($book->downloads) }}
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-eye mr-1"></i>
                            {{ number_format($book->views) }}
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star mr-1 text-yellow-400"></i>
                            4.{{ rand(0, 9) }}
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex space-x-2">
                        <a href="{{ route('books.public.show', $book) }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-3 rounded-lg transition-colors text-center">
                            Voir détails
                        </a>
                        @if($book->file_path)
                        <a href="{{ route('books.download', $book) }}"
                           class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium py-2 px-3 rounded-lg transition-colors">
                            <i class="fas fa-download"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-book text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Aucun livre disponible</h3>
                <p class="text-gray-600 dark:text-gray-400">Revenez bientôt pour découvrir de nouveaux livres !</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($books->hasPages())
        <div class="mt-8">
            {{ $books->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
