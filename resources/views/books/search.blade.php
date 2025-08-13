<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de livres - {{ site_name() }}</title>
    <link rel="icon" type="image/x-icon" href="{{ site_favicon() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #14b8a6 50%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ mobileMenuOpen: false }">

    @include('partials.public-header')

    <!-- Hero Section -->
    <section class="relative py-12 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Recherche Avancée
                </h1>
                <p class="text-xl text-emerald-100 max-w-2xl mx-auto">
                    Explorez notre collection de {{ $books->total() }} livres numériques
                </p>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-gray-100">
                <form method="GET" action="{{ route('books.search') }}" class="space-y-6">
                    <!-- Search Bar -->
                    <div class="relative">
                        <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-search mr-2 text-emerald-500"></i>Rechercher
                        </label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="Rechercher par titre, auteur, ISBN, éditeur..."
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-200">
                    </div>

                    <!-- Filters Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Category Filter -->
                        <div>
                            <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-folder mr-2 text-teal-500"></i>Catégorie
                            </label>
                            <select name="category" id="category" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-200">
                                <option value="">Toutes les catégories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Language Filter -->
                        <div>
                            <label for="language" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-language mr-2 text-emerald-500"></i>Langue
                            </label>
                            <select name="language" id="language" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-200">
                                <option value="">Toutes les langues</option>
                                @foreach($languages as $lang)
                                    <option value="{{ $lang }}" {{ request('language') == $lang ? 'selected' : '' }}>
                                        @if($lang == 'fr') Français
                                        @elseif($lang == 'en') English
                                        @elseif($lang == 'ar') العربية
                                        @else {{ $lang }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Year From -->
                        <div>
                            <label for="year_from" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt mr-2 text-teal-500"></i>Année (de)
                            </label>
                            <input type="number" name="year_from" id="year_from" value="{{ request('year_from') }}" 
                                   min="1800" max="{{ date('Y') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-200">
                        </div>

                        <!-- Year To -->
                        <div>
                            <label for="year_to" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-check mr-2 text-emerald-500"></i>Année (à)
                            </label>
                            <input type="number" name="year_to" id="year_to" value="{{ request('year_to') }}" 
                                   min="1800" max="{{ date('Y') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-200">
                        </div>
                    </div>

                    <!-- Sort Options -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="sort_by" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-sort mr-2 text-teal-500"></i>Trier par
                            </label>
                            <select name="sort_by" id="sort_by" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-200">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date d'ajout</option>
                                <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Titre</option>
                                <option value="author_name" {{ request('sort_by') == 'author_name' ? 'selected' : '' }}>Auteur</option>
                                <option value="publication_year" {{ request('sort_by') == 'publication_year' ? 'selected' : '' }}>Année de publication</option>
                                <option value="views" {{ request('sort_by') == 'views' ? 'selected' : '' }}>Plus consultés</option>
                                <option value="downloads" {{ request('sort_by') == 'downloads' ? 'selected' : '' }}>Plus téléchargés</option>
                            </select>
                        </div>

                        <div>
                            <label for="sort_order" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-sort-amount-down mr-2 text-emerald-500"></i>Ordre
                            </label>
                            <select name="sort_order" id="sort_order" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-200">
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Décroissant</option>
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Croissant</option>
                            </select>
                        </div>
                    </div>

                    <!-- Level Filter (if present) -->
                    @if(request('level'))
                        <input type="hidden" name="level" value="{{ request('level') }}">
                        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-3">
                            <span class="text-sm text-emerald-700">
                                <i class="fas fa-graduation-cap mr-2"></i>
                                Niveau filtré : <strong>{{ ucfirst(request('level')) }}</strong>
                            </span>
                        </div>
                    @endif

                    <!-- Submit Buttons -->
                    <div class="flex items-center space-x-4">
                        <button type="submit" 
                                class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-search mr-2"></i>Rechercher
                        </button>
                        <a href="{{ route('books.search') }}" 
                           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold transition-all duration-200">
                            <i class="fas fa-redo mr-2"></i>Réinitialiser
                        </a>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                <!-- Results Header -->
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Résultats de recherche</h2>
                        <p class="text-gray-600 mt-1">{{ $books->total() }} livre(s) trouvé(s)</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Affichage</span>
                        <span class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $books->firstItem() ?? 0 }}-{{ $books->lastItem() ?? 0 }}
                        </span>
                    </div>
                </div>

                @if($books->count() > 0)
                    <!-- Books Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($books as $book)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group h-96 flex flex-col card-hover border border-gray-100">
                                <div class="relative h-56 flex-shrink-0">
                                    @if($book->cover_image)
                                        <img src="{{ Storage::url($book->cover_image) }}" 
                                             alt="{{ $book->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center group-hover:from-emerald-600 group-hover:to-teal-700 transition-all duration-300">
                                            <div class="text-white text-center p-3 max-w-full">
                                                <i class="fas fa-book text-3xl mb-2"></i>
                                                <div class="font-bold text-sm leading-tight break-words line-clamp-3">{{ Str::limit($book->title, 40) }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Stats Badges -->
                                    <div class="absolute top-2 right-2 flex flex-col gap-1">
                                        <span class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-2 py-1 rounded-full text-xs font-semibold shadow-md">
                                            <i class="fas fa-eye mr-1"></i>{{ number_format($book->views) }}
                                        </span>
                                        <span class="bg-gradient-to-r from-teal-500 to-emerald-600 text-white px-2 py-1 rounded-full text-xs font-semibold shadow-md">
                                            <i class="fas fa-download mr-1"></i>{{ number_format($book->downloads) }}
                                        </span>
                                    </div>

                                    @if(!$book->is_approved && auth()->check() && auth()->user()->role === 'admin')
                                        <div class="absolute top-2 left-2">
                                            <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded-full text-xs font-semibold">
                                                <i class="fas fa-clock mr-1"></i>En attente
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="p-4 flex-1 flex flex-col justify-between">
                                    <div>
                                        <h3 class="font-bold text-gray-900 mb-2 text-sm group-hover:text-emerald-600 transition-colors line-clamp-2">
                                            {{ $book->title }}
                                        </h3>
                                        <p class="text-gray-600 text-xs mb-2">
                                            <i class="fas fa-user mr-1 text-gray-400"></i>{{ $book->author_name }}
                                        </p>
                                        @if($book->category)
                                            <span class="inline-block bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-700 border border-emerald-200 rounded-full px-3 py-1 text-xs font-semibold">
                                                {{ $book->category }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="mt-auto pt-3 border-t border-gray-100">
                                        <a href="{{ route('books.show', $book) }}" 
                                           class="block w-full text-center bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                            <i class="fas fa-eye mr-2"></i>Voir détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($books->hasPages())
                        <div class="mt-8 flex justify-center">
                            {{ $books->withQueryString()->links() }}
                        </div>
                    @endif
                @else
                    <!-- No Results -->
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-search text-emerald-500 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun livre trouvé</h3>
                        <p class="text-gray-500 max-w-md mx-auto">
                            Essayez de modifier vos critères de recherche ou explorez notre bibliothèque complète
                        </p>
                        <a href="{{ route('books.public.index') }}" 
                           class="inline-block mt-4 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-xl">
                            <i class="fas fa-book-open mr-2"></i>Explorer la bibliothèque
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-12 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Restez informé</h2>
            <p class="text-xl opacity-90 mb-8">
                Recevez nos dernières nouveautés et recommandations de lecture
            </p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" placeholder="Votre email" 
                       class="flex-1 px-4 py-3 rounded-lg text-gray-900 placeholder-gray-500">
                <button type="submit" class="bg-white text-emerald-600 px-6 py-3 rounded-lg font-semibold hover:bg-emerald-50 transition-all duration-200 shadow-md hover:shadow-lg">
                    S'abonner
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} {{ site_name() }} - Tous droits réservés</p>
        </div>
    </footer>
</body>
</html>