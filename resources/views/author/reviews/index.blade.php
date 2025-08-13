@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Avis et commentaires</h1>
            <p class="text-gray-600 dark:text-gray-400">Gérez les avis de vos lecteurs</p>
        </div>
        <div class="flex space-x-3">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-download mr-2"></i>Exporter
            </button>
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-chart-bar mr-2"></i>Rapport
            </button>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <i class="fas fa-comments text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total avis</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_reviews'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                    <i class="fas fa-star text-yellow-600 dark:text-yellow-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Note moyenne</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['average_rating'], 1) }}/5</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="fas fa-thumbs-up text-green-600 dark:text-green-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Avis positifs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['five_star'] + $stats['four_star'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-teal-100 dark:bg-purple-900 rounded-lg">
                    <i class="fas fa-clock text-teal-600 dark:text-purple-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Récents (7j)</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['recent_reviews'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Distribution -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Répartition des notes</h3>
        <div class="space-y-3">
            @for($i = 5; $i >= 1; $i--)
            <div class="flex items-center">
                <div class="flex items-center w-20">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $i }}</span>
                    <i class="fas fa-star text-yellow-400 ml-1"></i>
                </div>
                <div class="flex-1 mx-4">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        @php
                            $count = $stats[['one_star', 'two_star', 'three_star', 'four_star', 'five_star'][$i-1]];
                            $percentage = $stats['total_reviews'] > 0 ? ($count / $stats['total_reviews']) * 100 : 0;
                        @endphp
                        <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                <span class="text-sm text-gray-600 dark:text-gray-400 w-12 text-right">{{ $count }}</span>
            </div>
            @endfor
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filtres</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Livre</label>
                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                    <option>Tous les livres</option>
                    <option>Livre Example 1</option>
                    <option>Livre Example 2</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Note</label>
                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                    <option>Toutes les notes</option>
                    <option>5 étoiles</option>
                    <option>4 étoiles</option>
                    <option>3 étoiles</option>
                    <option>2 étoiles</option>
                    <option>1 étoile</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Période</label>
                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                    <option>Toutes les périodes</option>
                    <option>7 derniers jours</option>
                    <option>30 derniers jours</option>
                    <option>3 derniers mois</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Appliquer
                </button>
            </div>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Avis récents</h3>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg">Tous</button>
                    <button class="px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Non lus</button>
                    <button class="px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Sans réponse</button>
                </div>
            </div>
        </div>
        <div class="p-6">
            @if($reviews->isEmpty())
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-comments text-6xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Aucun avis pour le moment</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Les avis de vos lecteurs apparaîtront ici une fois que vos livres seront évalués.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('author.books.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Publier un livre
                    </a>
                    <a href="{{ route('author.promotions.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-bullhorn mr-2"></i>Créer une promotion
                    </a>
                </div>
            </div>
            @else
            <div class="space-y-4">
                @foreach($reviews as $review)
                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-gray-600 dark:text-gray-400"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $review->user_name }}</p>
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $review->book_title }}</span>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">{{ $review->comment }}</p>
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                                <i class="fas fa-reply mr-1"></i>Répondre
                            </button>
                            <button class="px-3 py-1 bg-gray-600 text-white rounded text-sm hover:bg-gray-700">
                                <i class="fas fa-flag mr-1"></i>Signaler
                            </button>
                        </div>
                        <span class="text-sm text-gray-500">
                            @if($review->author_response)
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>Répondu
                            @else
                                <i class="fas fa-clock text-yellow-500 mr-1"></i>En attente
                            @endif
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- Tips for Authors -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900 dark:to-indigo-900 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-lightbulb mr-2 text-yellow-500"></i>Conseils pour gérer vos avis
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Répondez avec professionnalisme</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Remerciez vos lecteurs pour leurs avis, même les critiques constructives.
                </p>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Utilisez les retours</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Les avis peuvent vous aider à améliorer vos prochaines œuvres.
                </p>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Encouragez les avis</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Demandez poliment à vos lecteurs de laisser un avis après la lecture.
                </p>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Restez positif</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Gardez une attitude positive même face aux critiques négatives.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
