@extends('layouts.author-dashboard')

@section('content')
    <!-- Header de la page -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Tableau de bord Auteur</h1>
        <p class="text-gray-600 dark:text-gray-400">Gérez vos publications et suivez vos performances</p>
    </div>

    <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">Total livres</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['total_books'] }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">Approuvés</div>
                        <div class="text-3xl font-bold text-green-600">{{ $stats['approved_books'] }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">En attente</div>
                        <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending_books'] }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">Téléchargements</div>
                        <div class="text-3xl font-bold text-blue-600">{{ $stats['total_downloads'] }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">Vues</div>
                        <div class="text-3xl font-bold text-teal-600">{{ $stats['total_views'] }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Livres récents -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Mes livres récents</h3>
                        @if($recent_books->count() > 0)
                            <div class="space-y-3">
                                @foreach($recent_books as $book)
                                    <div class="border-b pb-3">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-medium">{{ $book->title }}</h4>
                                                <p class="text-sm text-gray-600">{{ $book->category }}</p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $book->is_approved ? 'Approuvé' : 'En attente' }} • 
                                                    {{ $book->downloads }} téléchargements
                                                </p>
                                            </div>
                                            <a href="{{ route('author.books.edit', $book) }}" 
                                               class="text-blue-600 hover:text-blue-900 text-sm">
                                                Éditer
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Aucun livre publié.</p>
                        @endif
                    </div>
                </div>

                <!-- Livres populaires -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Livres les plus populaires</h3>
                        @if($popular_books->count() > 0)
                            <div class="space-y-3">
                                @foreach($popular_books as $book)
                                    <div class="border-b pb-3">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h4 class="font-medium">{{ $book->title }}</h4>
                                                <p class="text-sm text-gray-600">
                                                    {{ $book->downloads }} téléchargements • 
                                                    {{ $book->views }} vues
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-lg font-bold text-green-600">
                                                    #{{ $loop->iteration }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Aucune donnée disponible.</p>
                        @endif
                    </div>
                </div>

                <!-- Répartition par catégorie -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Mes livres par catégorie</h3>
                        @if($books_by_category->count() > 0)
                            <div class="space-y-2">
                                @foreach($books_by_category as $category)
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700">{{ $category->category }}</span>
                                        <div class="flex items-center">
                                            <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-blue-600 h-2 rounded-full" 
                                                     style="width: {{ ($category->total / $stats['total_books']) * 100 }}%">
                                                </div>
                                            </div>
                                            <span class="font-medium">{{ $category->total }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Aucune donnée disponible.</p>
                        @endif
                    </div>
                </div>

                <!-- Statistiques mensuelles -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Publications mensuelles</h3>
                        @if($monthly_stats->count() > 0)
                            <div class="space-y-2">
                                @foreach($monthly_stats as $stat)
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700">
                                            {{ \Carbon\Carbon::create($stat->year, $stat->month)->format('M Y') }}
                                        </span>
                                        <span class="font-medium">{{ $stat->total }} livre(s)</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Aucune donnée disponible.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Actions rapides</h3>
                    <div class="flex space-x-4">
                        <a href="{{ route('author.books.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Publier un nouveau livre
                        </a>
                        <a href="{{ route('author.books') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Gérer mes livres
                        </a>
                        <a href="{{ route('author.analytics') }}" 
                           class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700">
                            Voir les analyses
                        </a>
                    </div>
                </div>
            </div>
@endsection