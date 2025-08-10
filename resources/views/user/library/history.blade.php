@extends('layouts.user-dashboard')

@section('page-title', 'Historique de lecture')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Historique de lecture</h1>
            <p class="text-gray-600 mt-1">Retrouvez tous les livres que vous avez lus</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="text" placeholder="Rechercher dans l'historique..." 
                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <div class="relative">
                <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Toutes les périodes</option>
                    <option>Cette semaine</option>
                    <option>Ce mois</option>
                    <option>Cette année</option>
                    <option>Année dernière</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
            <div class="relative">
                <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Récemment lu</option>
                    <option>Titre A-Z</option>
                    <option>Auteur A-Z</option>
                    <option>Note décroissante</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Reading Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-check-circle text-3xl opacity-80"></i>
                <span class="text-sm opacity-90">Total</span>
            </div>
            <h3 class="text-3xl font-bold mb-1">{{ $totalBooksRead ?? 47 }}</h3>
            <p class="text-sm opacity-90">Livres lus</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-calendar text-2xl text-gray-400"></i>
                <span class="text-sm text-gray-500">Cette année</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $yearlyCount ?? 23 }}</h3>
            <p class="text-sm text-gray-600">Livres lus</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-star text-2xl text-yellow-400"></i>
                <span class="text-sm text-gray-500">Moyenne</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $averageRating ?? 4.2 }}/5</h3>
            <p class="text-sm text-gray-600">Note donnée</p>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-clock text-2xl text-gray-400"></i>
                <span class="text-sm text-gray-500">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalReadingTime ?? '156h' }}</h3>
            <p class="text-sm text-gray-600">Temps de lecture</p>
        </div>
    </div>

    <!-- Timeline View Toggle -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-600">Affichage :</span>
            <div class="flex bg-gray-100 rounded-lg p-1">
                <button class="px-3 py-1 text-sm font-medium text-white bg-blue-600 rounded-md">
                    <i class="fas fa-list mr-1"></i>Chronologique
                </button>
                <button class="px-3 py-1 text-sm font-medium text-gray-600 hover:text-gray-900">
                    <i class="fas fa-th-large mr-1"></i>Grille
                </button>
            </div>
        </div>
        <div class="text-sm text-gray-600">
            {{ $readBooks->count() ?? 47 }} livre(s) lu(s)
        </div>
    </div>

    <!-- Reading History Timeline -->
    @if(isset($readBooks) && $readBooks->count() > 0)
        <div class="space-y-6">
            @php
                $currentMonth = null;
            @endphp
            
            @foreach($readBooks as $book)
                @php
                    $bookMonth = $book->returned_at ? $book->returned_at->format('F Y') : 'Mars 2024';
                @endphp
                
                @if($currentMonth !== $bookMonth)
                    @php $currentMonth = $bookMonth; @endphp
                    <div class="flex items-center my-8">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <div class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                            {{ $bookMonth }}
                        </div>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>
                @endif

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start space-x-4">
                        <!-- Book Cover -->
                        <div class="flex-shrink-0">
                            <img src="{{ $book->book->cover_image ?? $book->cover_image ?? '/images/default-book-cover.jpg' }}"
                                 alt="{{ $book->book->title ?? $book->title ?? 'Livre' }}"
                                 class="w-16 h-20 object-cover rounded-lg">
                        </div>

                        <!-- Book Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $book->book->title ?? $book->title ?? 'Titre non disponible' }}</h3>
                                    <p class="text-gray-600 text-sm mb-2">par {{ $book->book->author_name ?? $book->author ?? 'Auteur inconnu' }}</p>
                                    
                                    <!-- Reading Details -->
                                    <div class="flex items-center space-x-4 text-sm text-gray-500 mb-3">
                                        <span>
                                            <i class="fas fa-calendar-check mr-1"></i>
                                            Terminé le {{ $book->returned_at ? $book->returned_at->format('d/m/Y') : '15/03/2024' }}
                                        </span>
                                        @if(isset($book->reading_duration))
                                        <span>
                                            <i class="fas fa-clock mr-1"></i>
                                            Lu en {{ $book->reading_duration ?? '5 jours' }}
                                        </span>
                                        @endif
                                        @if(isset($book->book->pages) || isset($book->pages))
                                        <span>
                                            <i class="fas fa-file-alt mr-1"></i>
                                            {{ $book->book->pages ?? $book->pages ?? 0 }} pages
                                        </span>
                                        @endif
                                    </div>

                                    <!-- User Rating -->
                                    @if(isset($book->user_rating))
                                    <div class="flex items-center mb-3">
                                        <span class="text-sm text-gray-600 mr-2">Ma note :</span>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-sm {{ $i <= $book->user_rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                            @endfor
                                            <span class="text-sm text-gray-600 ml-2">({{ $book->user_rating }}/5)</span>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- User Review -->
                                    @if(isset($book->user_review))
                                    <div class="bg-gray-50 rounded-lg p-3 mb-3">
                                        <p class="text-sm text-gray-700 italic">"{{ $book->user_review }}"</p>
                                    </div>
                                    @endif

                                    <!-- Genre Tags -->
                                    @if(isset($book->genre))
                                    <div class="flex flex-wrap gap-2">
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                            {{ $book->genre }}
                                        </span>
                                    </div>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="flex flex-col space-y-2 ml-4">
                                    <a href="{{ route('books.public.show', $book->id) }}" 
                                       class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-eye mr-2"></i>Voir
                                    </a>
                                    <button class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors"
                                            title="Relire">
                                        <i class="fas fa-redo mr-2"></i>Relire
                                    </button>
                                    <button class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors"
                                            title="Ajouter aux favoris">
                                        <i class="fas fa-heart mr-2"></i>Favori
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if(method_exists($readBooks, 'links'))
            <div class="mt-8">
                {{ $readBooks->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-history text-3xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Aucun livre lu pour le moment</h3>
                <p class="text-gray-600 mb-6">
                    Votre historique de lecture est vide. Commencez à lire pour voir vos livres terminés apparaître ici !
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('books.public.index') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Découvrir des livres
                    </a>
                    <a href="{{ route('user.library.current') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fas fa-book-reader mr-2"></i>
                        Mes lectures en cours
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Reading Stats Modal -->
<div x-data="{ showStatsModal: false }" x-show="showStatsModal" 
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
     x-transition style="display: none;">
    <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Statistiques détaillées</h3>
            <button @click="showStatsModal = false" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-gray-900 mb-3">Par genre</h4>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Fiction</span>
                        <span class="text-sm font-medium">15 livres</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Science-fiction</span>
                        <span class="text-sm font-medium">8 livres</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Romance</span>
                        <span class="text-sm font-medium">6 livres</span>
                    </div>
                </div>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 mb-3">Par mois</h4>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Mars 2024</span>
                        <span class="text-sm font-medium">5 livres</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Février 2024</span>
                        <span class="text-sm font-medium">4 livres</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Janvier 2024</span>
                        <span class="text-sm font-medium">3 livres</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
