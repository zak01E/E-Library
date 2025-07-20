@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <i class="fas fa-home mr-2"></i>Accueil
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('books.public.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">Livres</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ Str::limit($book->title, 30) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Book Cover and Actions -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-8">
                    <!-- Cover Image -->
                    <div class="aspect-[3/4] mb-6">
                        @if($book->cover_image)
                            <img src="{{ Storage::url($book->cover_image) }}" 
                                 alt="{{ $book->title }}" 
                                 class="w-full h-full object-cover rounded-lg shadow-md">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-600 rounded-lg shadow-md flex items-center justify-center">
                                <i class="fas fa-book text-white text-6xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Download Button -->
                    <div class="space-y-3">
                        @if($book->file_path)
                            <a href="{{ route('books.download', $book) }}"
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center">
                                <i class="fas fa-download mr-2"></i>
                                Télécharger
                            </a>
                        @endif
                        
                        <button class="w-full bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-heart mr-2"></i>
                            Ajouter aux favoris
                        </button>
                        
                        <button class="w-full bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-share mr-2"></i>
                            Partager
                        </button>
                    </div>

                    <!-- Stats -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($book->downloads) }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Téléchargements</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($book->views) }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Vues</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title and Basic Info -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $book->title }}</h1>
                    
                    <!-- Author Info -->
                    <div class="flex items-center mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-16 h-16 rounded-full overflow-hidden mr-4">
                            @if($book->uploader && $book->uploader->profile_photo_path)
                                <img src="{{ Storage::url($book->uploader->profile_photo_path) }}" 
                                     alt="{{ $book->uploader->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                                    <i class="fas fa-user text-white text-xl"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $book->uploader ? $book->uploader->name : 'Auteur inconnu' }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Auteur</p>
                            @if($book->uploader && $book->uploader->bio)
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ Str::limit($book->uploader->bio, 100) }}</p>
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm hover:bg-blue-200 transition-colors">
                                <i class="fas fa-plus mr-1"></i>Suivre
                            </button>
                            <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition-colors">
                                <i class="fas fa-envelope mr-1"></i>Contact
                            </button>
                        </div>
                    </div>

                    <!-- Book Metadata -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-sm text-gray-600 dark:text-gray-400">Catégorie</div>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $book->category ?? 'Non spécifiée' }}</div>
                        </div>
                        <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-sm text-gray-600 dark:text-gray-400">Pages</div>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $book->pages ?? 'N/A' }}</div>
                        </div>
                        <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-sm text-gray-600 dark:text-gray-400">Langue</div>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $book->language ?? 'Français' }}</div>
                        </div>
                        <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-sm text-gray-600 dark:text-gray-400">Publié</div>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $book->created_at->format('Y') }}</div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($book->description)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Description</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $book->description }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Reviews Section -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Avis des lecteurs</h3>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-star mr-2"></i>Laisser un avis
                        </button>
                    </div>
                    
                    <!-- Rating Summary -->
                    <div class="flex items-center mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="text-center mr-6">
                            <div class="text-3xl font-bold text-gray-900 dark:text-white">4.2</div>
                            <div class="flex justify-center mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">23 avis</div>
                        </div>
                        <div class="flex-1">
                            @for($i = 5; $i >= 1; $i--)
                            <div class="flex items-center mb-1">
                                <span class="text-sm text-gray-600 dark:text-gray-400 w-8">{{ $i }}★</span>
                                <div class="flex-1 mx-3">
                                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                        <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ rand(10, 80) }}%"></div>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400 w-8">{{ rand(1, 15) }}</span>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Sample Reviews -->
                    <div class="space-y-4">
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-gray-600 dark:text-gray-400 text-sm"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Marie Dupont</div>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= 5 ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                        @endfor
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Il y a 2 jours</span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">Excellent livre ! L'histoire est captivante et bien écrite. Je le recommande vivement.</p>
                        </div>
                        
                        <div class="text-center">
                            <button class="text-blue-600 hover:text-blue-700 font-medium">
                                Voir tous les avis →
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Related Books -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Autres livres de cet auteur</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @for($i = 1; $i <= 4; $i++)
                        <div class="text-center">
                            <div class="aspect-[3/4] bg-gray-200 dark:bg-gray-700 rounded-lg mb-2 flex items-center justify-center">
                                <i class="fas fa-book text-gray-400 text-2xl"></i>
                            </div>
                            <h4 class="font-medium text-gray-900 dark:text-white text-sm">Livre {{ $i }}</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ rand(50, 200) }} téléchargements</p>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
