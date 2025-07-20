<x-user-dashboard>
    <div class="p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">En cours de lecture</h1>
                <p class="text-gray-600">Suivez votre progression et reprenez là où vous vous êtes arrêté</p>
            </div>

            <!-- Reading Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <i class="fas fa-book-open text-3xl opacity-80"></i>
                        <span class="text-sm opacity-90">Ce mois</span>
                    </div>
                    <h3 class="text-3xl font-bold mb-1">{{ $books_reading ?? 4 }}</h3>
                    <p class="text-sm opacity-90">Livres en cours</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-2">
                        <i class="fas fa-clock text-2xl text-purple-600"></i>
                        <span class="text-xs text-gray-500">Moyenne</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $avg_reading_time ?? '2h15' }}</h3>
                    <p class="text-sm text-gray-600">Temps de lecture/jour</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-2">
                        <i class="fas fa-file-alt text-2xl text-green-600"></i>
                        <span class="text-xs text-gray-500">Total</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $pages_read ?? '1,245' }}</h3>
                    <p class="text-sm text-gray-600">Pages lues ce mois</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-2">
                        <i class="fas fa-fire text-2xl text-orange-600"></i>
                        <span class="text-xs text-gray-500">Série</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $reading_streak ?? 12 }}</h3>
                    <p class="text-sm text-gray-600">Jours consécutifs</p>
                </div>
            </div>

            <!-- Currently Reading Books -->
            <div class="space-y-6">
                @forelse($reading_books ?? [] as $book)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="flex flex-col lg:flex-row">
                            <!-- Book Cover -->
                            <div class="lg:w-48 h-64 lg:h-auto bg-gray-200 flex-shrink-0">
                                <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400"></div>
                            </div>
                            
                            <!-- Book Details -->
                            <div class="flex-1 p-6">
                                <div class="mb-4">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-900 mb-1">{{ $book->title }}</h3>
                                            <p class="text-gray-600">{{ $book->author_name }}</p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                            <button class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                                <i class="fas fa-bookmark"></i>
                                            </button>
                                            <button class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                                <i class="fas fa-share-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                                        <span><i class="fas fa-layer-group mr-1"></i> {{ $book->category ?? 'Fiction' }}</span>
                                        <span><i class="fas fa-clock mr-1"></i> Commencé le {{ $book->started_at ?? '5 Jan 2025' }}</span>
                                        <span><i class="fas fa-hourglass-half mr-1"></i> ~{{ $book->estimated_time ?? '3h' }} restant</span>
                                    </div>
                                </div>

                                <!-- Progress -->
                                <div class="mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-gray-700">Progression</span>
                                        <span class="text-sm text-gray-600">{{ $book->current_page ?? 156 }}/{{ $book->total_pages ?? 420 }} pages</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                                        <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: {{ $book->progress ?? 37 }}%"></div>
                                    </div>
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span>{{ $book->progress ?? 37 }}% complété</span>
                                        <span>Chapitre {{ $book->current_chapter ?? 8 }}/{{ $book->total_chapters ?? 24 }}</span>
                                    </div>
                                </div>

                                <!-- Reading Sessions -->
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Sessions récentes</h4>
                                    <div class="flex space-x-2">
                                        @for($i = 0; $i < 7; $i++)
                                            <div class="flex-1">
                                                <div class="h-16 bg-gray-100 rounded flex items-end p-1">
                                                    <div class="w-full bg-blue-500 rounded" style="height: {{ rand(20, 100) }}%"></div>
                                                </div>
                                                <p class="text-xs text-gray-500 text-center mt-1">{{ ['L', 'M', 'M', 'J', 'V', 'S', 'D'][$i] }}</p>
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('books.read', $book) }}" class="inline-flex items-center px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-book-open mr-2"></i>
                                        Continuer la lecture
                                    </a>
                                    <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-sticky-note mr-2"></i>
                                        Notes ({{ $book->notes_count ?? 3 }})
                                    </button>
                                    <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-quote-right mr-2"></i>
                                        Citations ({{ $book->quotes_count ?? 5 }})
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                        <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun livre en cours de lecture</h3>
                        <p class="text-gray-600 mb-6">Commencez un nouveau livre pour suivre votre progression</p>
                        <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-search mr-2"></i>
                            Découvrir des livres
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Reading History -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Historique de lecture récent</h3>
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        @foreach($reading_history ?? [] as $entry)
                            <div class="p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-16 bg-gray-200 rounded flex-shrink-0"></div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $entry->book_title }}</h4>
                                            <p class="text-sm text-gray-600">Lu {{ $entry->pages_read }} pages - Chapitre {{ $entry->chapter }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">{{ $entry->duration }}</p>
                                        <p class="text-xs text-gray-500">{{ $entry->date }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-dashboard>