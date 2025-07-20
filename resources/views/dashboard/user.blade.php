<x-user-dashboard>
    <div class="p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Message and Stats -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Bienvenue {{ Auth::user()->name }}!</h1>
                <p class="text-gray-600">Voici un aperçu de votre activité de lecture</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-book text-blue-600 text-xl"></i>
                        </div>
                        <span class="text-sm text-gray-500">Ce mois</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['books_read'] ?? 12 }}</h3>
                    <p class="text-sm text-gray-600">Livres lus</p>
                    <p class="text-xs text-green-600 mt-2">
                        <i class="fas fa-arrow-up"></i> +15% vs mois dernier
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <i class="fas fa-clock text-purple-600 text-xl"></i>
                        </div>
                        <span class="text-sm text-gray-500">Total</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['reading_time'] ?? '45h' }}</h3>
                    <p class="text-sm text-gray-600">Temps de lecture</p>
                    <p class="text-xs text-gray-500 mt-2">2h30 en moyenne/jour</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-trophy text-green-600 text-xl"></i>
                        </div>
                        <span class="text-sm text-gray-500">Objectif</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['goal_progress'] ?? '75%' }}</h3>
                    <p class="text-sm text-gray-600">Progression</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $stats['goal_progress'] ?? '75%' }}"></div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <div class="p-3 bg-orange-100 rounded-lg">
                            <i class="fas fa-fire text-orange-600 text-xl"></i>
                        </div>
                        <span class="text-sm text-gray-500">Série</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['reading_streak'] ?? 7 }}</h3>
                    <p class="text-sm text-gray-600">Jours consécutifs</p>
                    <p class="text-xs text-orange-600 mt-2">Record: 15 jours</p>
                </div>
            </div>

            <!-- Continue Reading Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Continuer la lecture</h3>
                    <a href="{{ route('user.library.reading') }}" class="text-sm text-blue-600 hover:text-blue-800">Voir tout →</a>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @forelse($continue_reading ?? [] as $book)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex space-x-4">
                            <div class="w-24 h-32 bg-gray-200 rounded-lg flex-shrink-0"></div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">{{ $book->title }}</h4>
                                <p class="text-sm text-gray-600 mb-2">{{ $book->author_name }}</p>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs text-gray-500">Page {{ $book->current_page ?? 125 }}/{{ $book->total_pages ?? 450 }}</span>
                                    <span class="text-xs text-gray-500">{{ $book->progress ?? 28 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $book->progress ?? 28 }}%"></div>
                                </div>
                                <a href="{{ route('books.show', $book) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                    <i class="fas fa-book-open mr-1"></i>
                                    Continuer
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-8 text-gray-500">
                            <i class="fas fa-book-open text-4xl mb-2"></i>
                            <p>Aucune lecture en cours</p>
                            <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">Découvrir des livres →</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Books -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4">Livres récents</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($recent_books as $book)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h4 class="font-semibold text-lg mb-2">{{ $book->title }}</h4>
                                <p class="text-gray-600 text-sm mb-2">Par {{ $book->author_name }}</p>
                                <p class="text-gray-500 text-sm mb-4">{{ Str::limit($book->description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">{{ $book->category }}</span>
                                    <a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                        Voir plus →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 col-span-3">Aucun livre récent disponible.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recommendations Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Recommandations pour vous</h3>
                    <a href="{{ route('books.recommendations') }}" class="text-sm text-blue-600 hover:text-blue-800">Voir plus →</a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @forelse($recommendations ?? $popular_books as $book)
                        <div class="group cursor-pointer">
                            <div class="w-full aspect-[3/4] bg-gray-200 rounded-lg mb-2 overflow-hidden">
                                <div class="w-full h-full bg-gradient-to-b from-gray-300 to-gray-400 group-hover:scale-105 transition-transform duration-300"></div>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $book->title }}</h4>
                            <p class="text-xs text-gray-600 truncate">{{ $book->author_name }}</p>
                            <div class="flex items-center mt-1">
                                <div class="flex text-yellow-400">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fas fa-star text-xs"></i>
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-500 ml-1">({{ $book->ratings_count ?? rand(10, 500) }})</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 col-span-6">Aucune recommandation disponible.</p>
                    @endforelse
                </div>
            </div>

            <!-- Popular Books -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Livres populaires cette semaine</h3>
                    <a href="{{ route('books.popular') }}" class="text-sm text-blue-600 hover:text-blue-800">Voir tout →</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($popular_books as $book)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="flex">
                                <div class="w-32 h-48 bg-gray-200 flex-shrink-0">
                                    <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400"></div>
                                </div>
                                <div class="p-4 flex-1">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-1">{{ $book->title }}</h4>
                                            <p class="text-sm text-gray-600">{{ $book->author_name }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full">
                                            <i class="fas fa-fire mr-1"></i>
                                            Populaire
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-3">{{ Str::limit($book->description, 80) }}</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3 text-sm text-gray-600">
                                            <span><i class="fas fa-download"></i> {{ $book->downloads }}</span>
                                            <span><i class="fas fa-eye"></i> {{ $book->views ?? rand(100, 5000) }}</span>
                                        </div>
                                        <a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Lire →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 col-span-3">Aucun livre populaire disponible.</p>
                    @endforelse
                </div>
            </div>

            <!-- Reading Goals -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-6 text-white mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Objectif de lecture 2025</h3>
                        <p class="text-blue-100 mb-4">Vous avez lu 18 livres sur votre objectif de 24 livres cette année</p>
                        <div class="flex items-center space-x-4">
                            <div class="flex-1">
                                <div class="w-full bg-white/20 rounded-full h-3">
                                    <div class="bg-white h-3 rounded-full" style="width: 75%"></div>
                                </div>
                            </div>
                            <span class="text-sm font-medium">75%</span>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <i class="fas fa-trophy text-6xl text-white/20"></i>
                    </div>
                </div>
                <div class="mt-4 flex space-x-4">
                    <a href="{{ route('user.goals.edit') }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-50">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier l'objectif
                    </a>
                    <a href="{{ route('user.stats') }}" class="inline-flex items-center px-4 py-2 bg-white/20 text-white rounded-lg text-sm font-medium hover:bg-white/30">
                        <i class="fas fa-chart-line mr-2"></i>
                        Voir les statistiques
                    </a>
                </div>
            </div>

            <!-- Activity Feed -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Activité récente</h3>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="divide-y divide-gray-200">
                            @forelse($recent_activity ?? [] as $activity)
                                <div class="p-4 hover:bg-gray-50">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-book text-blue-600"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-900">{{ $activity->description }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center">
                                    <i class="fas fa-history text-4xl text-gray-300 mb-2"></i>
                                    <p class="text-gray-500">Aucune activité récente</p>
                                    <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">Commencer à lire →</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Reading Challenges -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Défis de lecture</h3>
                    <div class="space-y-4">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-900">Lecteur du mois</h4>
                                <span class="text-xs text-gray-500">En cours</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Lisez 5 livres ce mois-ci</p>
                            <div class="flex items-center justify-between">
                                <div class="flex -space-x-1">
                                    @for($i = 0; $i < 5; $i++)
                                        <div class="w-6 h-6 rounded-full {{ $i < 3 ? 'bg-green-500' : 'bg-gray-300' }} border-2 border-white"></div>
                                    @endfor
                                </div>
                                <span class="text-sm font-medium text-gray-900">3/5</span>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-900">Explorateur</h4>
                                <span class="text-xs text-green-600">Complété!</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Lisez 3 genres différents</p>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span class="text-sm text-gray-500">+50 points</span>
                            </div>
                        </div>

                        <a href="{{ route('user.challenges') }}" class="block text-center py-3 bg-blue-50 text-blue-600 rounded-lg font-medium hover:bg-blue-100">
                            Voir tous les défis →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-dashboard>