<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ site_name() }} - {{ site_setting('site_description', 'Votre Bibliothèque Numérique Moderne') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ site_favicon() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-gray-50 overflow-x-hidden">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-lg sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        @if(site_logo())
                            <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-10 w-auto">
                        @else
                            <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book-open text-white text-lg"></i>
                            </div>
                        @endif
                        <span class="ml-3 text-xl font-heading font-bold text-gray-900">{{ site_name() }}</span>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#accueil" class="text-gray-900 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Accueil</a>
                        <a href="#bibliotheque" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Bibliothèque</a>
                        <a href="#auteurs" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Auteurs</a>
                        <a href="#a-propos" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">À propos</a>
                    </div>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-500 hover:text-emerald-600 px-3 py-2 text-sm font-medium transition-colors">
                                Connexion
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    S'inscrire
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#accueil" class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Accueil</a>
                <a href="#bibliotheque" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Bibliothèque</a>
                <a href="#auteurs" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Auteurs</a>
                <a href="#a-propos" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">À propos</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-indigo-600 text-white block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-indigo-600 text-white block px-3 py-2 rounded-md text-base font-medium">S'inscrire</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section Compact -->
    <section id="accueil" class="bg-gradient-to-br from-emerald-600 to-emerald-800 py-16">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-2xl md:text-3xl font-heading font-bold text-white mb-3">
                    Bienvenue sur<br>
                    <span class="text-emerald-200">{{ site_name() }}</span>
                </h1>
                <h2 class="text-base md:text-lg font-display text-white/90 mb-5">
                    {{ site_setting('site_description', 'Votre Bibliothèque Numérique Moderne') }}
                </h2>
                </div>

                <p class="text-sm md:text-base text-white/80 mb-6 max-w-lg mx-auto">
                    {{ site_setting('hero_description', 'Découvrez, lisez et partagez des milliers de livres numériques.') }}
                </p>

                <!-- Search Bar Compact -->
                <div class="max-w-md mx-auto mb-6">
                    <form id="heroSearchForm" class="flex bg-white rounded-lg overflow-hidden shadow">
                        <div class="flex-1 relative">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" id="heroSearchInput"
                                   placeholder="Rechercher un livre..."
                                   class="w-full pl-10 pr-3 py-2.5 text-gray-900 border-0 focus:outline-none focus:ring-0 text-sm">
                        </div>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 font-semibold transition-colors text-sm">
                            Rechercher
                        </button>
                    </form>
                </div>

                <!-- CTA Buttons Compact -->
                <div class="flex flex-col sm:flex-row gap-2 justify-center items-center mb-6">
                    <a href="{{ route('books.public.index') }}" class="bg-white text-emerald-600 px-5 py-2.5 rounded-lg font-semibold hover:bg-gray-100 transition-colors shadow text-sm">
                        <i class="fas fa-book-open mr-2"></i>
                        Explorer la Bibliothèque
                    </a>

                    @guest
                        <a href="{{ route('register') }}" class="bg-white/20 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-white/30 transition-colors border border-white/30 text-sm">
                            <i class="fas fa-user-plus mr-2"></i>
                            Rejoindre
                        </a>
                    @endguest
                </div>

                <!-- Stats Compact with Animation -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-w-lg mx-auto" x-data="statsCounter()">
                    <div class="text-center">
                        <div class="text-xl font-bold text-white mb-1" x-text="animatedBooks + '+'"></div>
                        <div class="text-white/70 text-xs">Livres</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-white mb-1" x-text="animatedUsers + '+'"></div>
                        <div class="text-white/70 text-xs">Lecteurs</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-white mb-1" x-text="animatedDownloads + '+'"></div>
                        <div class="text-white/70 text-xs">Téléchargements</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-white mb-1" x-text="animatedAuthors + '+'"></div>
                        <div class="text-white/70 text-xs">Auteurs</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section Simple -->
    <section id="fonctionnalites" class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    Nos Fonctionnalités
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Découvrez ce qui rend notre bibliothèque numérique unique
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Feature 1: Lecture -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="w-12 h-12 bg-emerald-500 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-book-reader text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 font-heading">Lecture Simple</h3>
                    <p class="text-gray-600 mb-4">
                        Lisez vos livres préférés avec notre lecteur intégré et intuitif.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-500 text-xs mr-2"></i>
                            Lecteur PDF intégré
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-500 text-xs mr-2"></i>
                            Mode sombre/clair
                        </li>
                    </ul>
                </div>

                <!-- Feature 2: Publication -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-pen-fancy text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Publication</h3>
                    <p class="text-gray-600 mb-4">
                        Publiez vos œuvres facilement et partagez-les avec la communauté.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 text-xs mr-2"></i>
                            Upload simple
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 text-xs mr-2"></i>
                            Validation rapide
                        </li>
                    </ul>
                </div>

                <!-- Feature 3: Recherche -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-search text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Recherche</h3>
                    <p class="text-gray-600 mb-4">
                        Trouvez rapidement vos livres préférés.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-orange-500 text-xs mr-2"></i>
                            Recherche par titre
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-orange-500 text-xs mr-2"></i>
                            Filtres par catégorie
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- Featured Books Section -->
    <section id="nouveautes" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-6">
                    Découvrez nos Livres
                </h2>

                <!-- Filters Section -->
                <div class="bg-gray-50 rounded-xl p-4 mb-8 max-w-4xl mx-auto">
                    <form id="homeFiltersForm" class="flex flex-wrap items-center justify-center gap-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-filter text-gray-500 text-sm"></i>
                            <span class="text-gray-700 font-medium text-sm">Filtres:</span>
                        </div>

                        <!-- Search -->
                        <input type="text"
                               name="search"
                               placeholder="Rechercher..."
                               class="bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-48">

                        <!-- Category Filter -->
                        <select name="category" class="bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="all">📚 Toutes catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">
                                    @switch($category)
                                        @case('Fiction')
                                            📖 {{ $category }}
                                            @break
                                        @case('Science')
                                            🔬 {{ $category }}
                                            @break
                                        @case('Technologie')
                                            💻 {{ $category }}
                                            @break
                                        @case('Histoire')
                                            🏛️ {{ $category }}
                                            @break
                                        @case('Biographie')
                                            👤 {{ $category }}
                                            @break
                                        @default
                                            📚 {{ $category }}
                                    @endswitch
                                </option>
                            @endforeach
                        </select>

                        <!-- Language Filter -->
                        <select name="language" class="bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="all">🌍 Toutes langues</option>
                            @foreach($languages as $language)
                                <option value="{{ $language }}">
                                    @switch($language)
                                        @case('Français')
                                            🇫🇷 {{ $language }}
                                            @break
                                        @case('Anglais')
                                            🇬🇧 {{ $language }}
                                            @break
                                        @case('Espagnol')
                                            🇪🇸 {{ $language }}
                                            @break
                                        @default
                                            🌍 {{ $language }}
                                    @endswitch
                                </option>
                            @endforeach
                        </select>

                        <!-- Author Filter -->
                        <div class="relative">
                            <input type="text"
                                   name="author"
                                   id="authorSearch"
                                   placeholder="👤 Rechercher un auteur..."
                                   class="bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-48"
                                   autocomplete="off">
                            <div id="authorSuggestions" class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-lg shadow-lg z-50 max-h-60 overflow-y-auto hidden">
                                <!-- Suggestions will be populated by JavaScript -->
                            </div>
                        </div>

                        <!-- Clear Filters Button -->
                        <button type="button" id="clearFilters" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm transition-colors">
                            <i class="fas fa-times mr-1"></i>Effacer
                        </button>
                    </form>
                </div>

                <!-- Section Tabs -->
                <div class="flex justify-center mb-8">
                    <div class="bg-gray-100 rounded-lg p-1 inline-flex" x-data="{ activeTab: 'recent' }" x-cloak>
                        <button @click="activeTab = 'recent'"
                                :class="activeTab === 'recent' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                            <i class="fas fa-clock mr-2"></i>Récents
                        </button>
                        <button @click="activeTab = 'popular'"
                                :class="activeTab === 'popular' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                            <i class="fas fa-fire mr-2"></i>Populaires
                        </button>
                        <button @click="activeTab = 'viewed'"
                                :class="activeTab === 'viewed' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                            <i class="fas fa-eye mr-2"></i>Les plus vus
                        </button>
                    </div>
                </div>

                <!-- Recent Books -->
                <div x-show="activeTab === 'recent'" x-transition class="books-grid-container">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($featuredBooks['recent'] as $book)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 group h-96 flex flex-col">
                                <div class="relative h-56 flex-shrink-0">
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                                             alt="{{ $book->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center group-hover:from-emerald-600 group-hover:to-emerald-700 transition-all duration-300">
                                            <div class="text-white text-center p-3 max-w-full">
                                                <i class="fas fa-book text-2xl mb-2"></i>
                                                <div class="font-bold text-xs leading-tight break-words line-clamp-3">{{ Str::limit($book->title, 30) }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        NOUVEAU
                                    </div>
                                </div>
                                <div class="p-4 flex-1 flex flex-col justify-between">
                                    <div>
                                        <h3 class="font-heading font-bold text-gray-900 mb-2 text-sm group-hover:text-emerald-600 transition-colors line-clamp-2">
                                            {{ $book->title }}
                                        </h3>
                                        <p class="text-gray-600 text-xs mb-3 leading-relaxed line-clamp-2">{{ $book->description }}</p>
                                    </div>
                                    <div class="flex items-center justify-between mt-auto">
                                        <div class="flex items-center text-xs text-gray-500">
                                            <i class="fas fa-user mr-1"></i>
                                            <span>{{ Str::limit($book->author_name ?: $book->uploader->name, 12) }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @guest
                                                <span class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded-full">
                                                    <i class="fas fa-lock mr-1"></i>Connexion requise
                                                </span>
                                            @endguest
                                            <a href="{{ route('books.public.show', $book) }}"
                                               class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded text-xs font-semibold transition-all duration-300">
                                                @auth Découvrir @else Aperçu @endauth
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <i class="fas fa-book text-gray-400 text-4xl mb-4"></i>
                                <p class="text-gray-500">Aucun livre récent disponible</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Popular Books -->
                <div x-show="activeTab === 'popular'" x-transition class="books-grid-container">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($featuredBooks['popular'] as $book)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 group h-96 flex flex-col">
                                <div class="relative h-56 flex-shrink-0">
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                                             alt="{{ $book->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center group-hover:from-blue-600 group-hover:to-blue-700 transition-all duration-300">
                                            <div class="text-white text-center p-3 max-w-full">
                                                <i class="fas fa-book text-2xl mb-2"></i>
                                                <div class="font-bold text-xs leading-tight break-words line-clamp-3">{{ Str::limit($book->title, 30) }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    <!-- Stats Badge -->
                                    <div class="absolute top-2 right-2 bg-blue-600 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-download mr-1"></i>{{ number_format($book->downloads) }}
                                    </div>
                                </div>
                                <div class="p-4 flex-1 flex flex-col justify-between">
                                    <div>
                                        <h3 class="font-heading font-bold text-gray-900 mb-2 text-sm group-hover:text-blue-600 transition-colors line-clamp-2">
                                            {{ $book->title }}
                                        </h3>
                                        <p class="text-gray-600 text-xs mb-3 leading-relaxed line-clamp-2">{{ $book->description }}</p>
                                    </div>
                                    <div class="flex items-center justify-between mt-auto">
                                        <div class="flex items-center text-xs text-gray-500">
                                            <i class="fas fa-user mr-1"></i>
                                            <span>{{ Str::limit($book->author_name ?: $book->uploader->name, 12) }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @guest
                                                <span class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded-full">
                                                    <i class="fas fa-lock mr-1"></i>Connexion requise
                                                </span>
                                            @endguest
                                            <a href="{{ route('books.public.show', $book) }}"
                                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold transition-all duration-300">
                                                @auth Découvrir @else Aperçu @endauth
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <i class="fas fa-fire text-gray-400 text-4xl mb-4"></i>
                                <p class="text-gray-500">Aucun livre populaire disponible</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Most Viewed Books -->
                <div x-show="activeTab === 'viewed'" x-transition class="books-grid-container">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($featuredBooks['most_viewed'] as $book)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 group h-96 flex flex-col">
                                <div class="relative h-56 flex-shrink-0">
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                                             alt="{{ $book->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center group-hover:from-purple-600 group-hover:to-purple-700 transition-all duration-300">
                                            <div class="text-white text-center p-3 max-w-full">
                                                <i class="fas fa-book text-2xl mb-2"></i>
                                                <div class="font-bold text-xs leading-tight break-words line-clamp-3">{{ Str::limit($book->title, 30) }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    <!-- Stats Badge -->
                                    <div class="absolute top-2 right-2 bg-purple-600 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-eye mr-1"></i>{{ number_format($book->views) }}
                                    </div>
                                </div>
                                <div class="p-4 flex-1 flex flex-col justify-between">
                                    <div>
                                        <h3 class="font-heading font-bold text-gray-900 mb-2 text-sm group-hover:text-purple-600 transition-colors line-clamp-2">
                                            {{ $book->title }}
                                        </h3>
                                        <p class="text-gray-600 text-xs mb-3 leading-relaxed line-clamp-2">{{ $book->description }}</p>
                                    </div>
                                    <div class="flex items-center justify-between mt-auto">
                                        <div class="flex items-center text-xs text-gray-500">
                                            <i class="fas fa-user mr-1"></i>
                                            <span>{{ Str::limit($book->author_name ?: $book->uploader->name, 12) }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @guest
                                                <span class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded-full">
                                                    <i class="fas fa-lock mr-1"></i>Connexion requise
                                                </span>
                                            @endguest
                                            <a href="{{ route('books.public.show', $book) }}"
                                               class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-xs font-semibold transition-all duration-300">
                                                @auth Découvrir @else Aperçu @endauth
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <i class="fas fa-eye text-gray-400 text-4xl mb-4"></i>
                                <p class="text-gray-500">Aucun livre consulté disponible</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- View All Books Button -->
            <div class="text-center mt-8">
                <a href="{{ route('books.public.index') }}"
                   class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold transition-colors">
                    Voir toute la bibliothèque
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    Catégories Populaires
                </h2>
                <p class="text-lg text-gray-600">
                    Explorez nos collections par genre
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-2">
                @forelse($popularCategories as $category)
                    <a href="{{ route('books.public.index', ['category' => $category->category]) }}"
                       class="bg-white rounded-xl p-6 text-center hover:shadow-lg transition-all duration-300 cursor-pointer group border border-gray-100 mb-4">
                        <div class="w-12 h-12 bg-emerald-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <i class="{{ $category->icon }} text-white text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1 text-sm">{{ $category->category }}</h3>
                        <p class="text-emerald-600 text-xs font-medium">{{ number_format($category->books_count) }} livre{{ $category->books_count > 1 ? 's' : '' }}</p>
                    </a>
                @empty
                    <div class="col-span-full text-center py-8">
                        <i class="fas fa-folder-open text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">Aucune catégorie disponible</p>
                    </div>
                @endforelse
            </div>

            <!-- View All Categories Button -->
            <div class="text-center mt-8">
                <a href="{{ route('books.public.index') }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold transition-colors">
                    Voir toutes les catégories
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Authors Section -->
    <section id="auteurs" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    Auteurs en Vedette
                </h2>
                <p class="text-lg text-gray-600">
                    Découvrez les auteurs les plus actifs de notre plateforme
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 px-2">
                @forelse($featuredAuthors as $author)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-lg transition-all duration-300 group mb-6">
                        <div class="relative mb-4">
                            <img src="{{ $author->profile_photo_url }}"
                                 alt="{{ $author->name }}"
                                 class="w-16 h-16 rounded-full mx-auto object-cover border-4 border-emerald-100 group-hover:border-emerald-200 transition-colors">
                            <div class="absolute -bottom-2 -right-2 bg-emerald-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-xs font-bold">
                                {{ $author->approved_books_count }}
                            </div>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">{{ $author->name }}</h3>
                        <p class="text-sm text-gray-600 mb-3">Auteur</p>

                        <div class="space-y-2 text-xs text-gray-500">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-book mr-2"></i>
                                <span>{{ $author->approved_books_count }} livre{{ $author->approved_books_count > 1 ? 's' : '' }}</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <i class="fas fa-download mr-2"></i>
                                <span>{{ number_format($author->total_downloads) }} téléchargements</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <i class="fas fa-eye mr-2"></i>
                                <span>{{ number_format($author->total_views) }} vues</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('books.public.index', ['author' => $author->id]) }}"
                               class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold text-sm transition-colors">
                                Voir ses livres
                                <i class="fas fa-arrow-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">Aucun auteur disponible</p>
                    </div>
                @endforelse
            </div>

            <!-- View All Authors Button -->
            <div class="text-center mt-8">
                <a href="{{ route('books.public.index') }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold transition-colors">
                    Voir tous les auteurs
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Books Section Simple -->
    <section id="bibliotheque" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    Livres Populaires
                </h2>
                <p class="text-lg text-gray-600">
                    Découvrez notre sélection de livres
                </p>
            </div>

            <!-- Books Grid Simple -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Book 1 -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="aspect-[3/4] bg-emerald-500 flex items-center justify-center">
                        <div class="text-white text-center p-4">
                            <i class="fas fa-book text-3xl mb-2"></i>
                            <div class="font-semibold">L'Art du Code</div>
                            <div class="text-sm opacity-80">par Jean Dupont</div>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">L'Art du Code</h3>
                        <p class="text-gray-600 text-sm mb-3">Guide de programmation moderne</p>
                        <div class="flex items-center justify-between">
                            <span class="text-emerald-600 font-semibold">Gratuit</span>
                            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded text-sm">
                                Lire
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Book 2 -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="aspect-[3/4] bg-green-500 flex items-center justify-center">
                        <div class="text-white text-center p-4">
                            <i class="fas fa-leaf text-3xl mb-2"></i>
                            <div class="font-semibold">Écologie Moderne</div>
                            <div class="text-sm opacity-80">par Marie Martin</div>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Écologie Moderne</h3>
                        <p class="text-gray-600 text-sm mb-3">Enjeux environnementaux</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-semibold">Gratuit</span>
                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                Lire
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Book 3 -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="aspect-[3/4] bg-orange-500 flex items-center justify-center">
                        <div class="text-white text-center p-4">
                            <i class="fas fa-brain text-3xl mb-2"></i>
                            <div class="font-semibold">Psychologie</div>
                            <div class="text-sm opacity-80">par Dr. Sophie</div>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Psychologie Positive</h3>
                        <p class="text-gray-600 text-sm mb-3">Bien-être mental</p>
                        <div class="flex items-center justify-between">
                            <span class="text-orange-600 font-semibold">Gratuit</span>
                            <button class="bg-orange-600 hover:bg-orange-700 text-white px-3 py-1 rounded text-sm">
                                Lire
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-8">
                <a href="{{ route('books.public.index') }}" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-book-open mr-2"></i>
                    Voir Tous les Livres
                </a>
            </div>
        </div>
    </section>

    <!-- Authors Section -->
    <section id="auteurs" class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    Auteurs Vedettes
                </h2>
                <p class="text-lg text-gray-600">
                    Découvrez les auteurs les plus appréciés de notre communauté
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Author 1 -->
                <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold text-xl">JD</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Jean Dupont</h3>
                    <p class="text-gray-600 text-sm mb-3">Spécialiste en programmation et technologies modernes</p>
                    <div class="flex items-center justify-center space-x-4 text-sm text-gray-500 mb-4">
                        <span><i class="fas fa-book text-emerald-500 mr-1"></i>12 livres</span>
                        <span><i class="fas fa-heart text-red-500 mr-1"></i>2.5K</span>
                    </div>
                    <a href="#" class="text-emerald-600 hover:text-emerald-700 font-medium text-sm transition-colors">
                        Voir les livres
                    </a>
                </div>

                <!-- Author 2 -->
                <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold text-xl">MM</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Marie Martin</h3>
                    <p class="text-gray-600 text-sm mb-3">Experte en écologie et développement durable</p>
                    <div class="flex items-center justify-center space-x-4 text-sm text-gray-500 mb-4">
                        <span><i class="fas fa-book text-green-500 mr-1"></i>8 livres</span>
                        <span><i class="fas fa-heart text-red-500 mr-1"></i>1.8K</span>
                    </div>
                    <a href="#" class="text-green-600 hover:text-green-700 font-medium text-sm transition-colors">
                        Voir les livres
                    </a>
                </div>

                <!-- Author 3 -->
                <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold text-xl">SL</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Dr. Sophie Leroy</h3>
                    <p class="text-gray-600 text-sm mb-3">Psychologue clinicienne et auteure reconnue</p>
                    <div class="flex items-center justify-center space-x-4 text-sm text-gray-500 mb-4">
                        <span><i class="fas fa-book text-purple-500 mr-1"></i>15 livres</span>
                        <span><i class="fas fa-heart text-red-500 mr-1"></i>3.2K</span>
                    </div>
                    <a href="#" class="text-purple-600 hover:text-purple-700 font-medium text-sm transition-colors">
                        Voir les livres
                    </a>
                </div>

                <!-- Author 4 -->
                <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold text-xl">PB</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Pierre Bernard</h3>
                    <p class="text-gray-600 text-sm mb-3">Historien et passionné d'art contemporain</p>
                    <div class="flex items-center justify-center space-x-4 text-sm text-gray-500 mb-4">
                        <span><i class="fas fa-book text-orange-500 mr-1"></i>9 livres</span>
                        <span><i class="fas fa-heart text-red-500 mr-1"></i>1.4K</span>
                    </div>
                    <a href="#" class="text-orange-600 hover:text-orange-700 font-medium text-sm transition-colors">
                        Voir les livres
                    </a>
                </div>
            </div>

            <!-- View All Authors Button -->
            <div class="text-center mt-8">
                <a href="{{ route('authors.index') }}" class="inline-flex items-center bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-users mr-2"></i>
                    Voir tous les auteurs
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section Simple -->
    <section id="temoignages" class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    Témoignages
                </h2>
                <p class="text-lg text-gray-600">
                    Ce que disent nos utilisateurs
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 relative">
                    <div class="absolute top-4 left-4 text-indigo-200">
                        <i class="fas fa-quote-left text-3xl"></i>
                    </div>
                    <div class="pt-8">
                        <p class="text-gray-700 mb-6 italic">
                            "E-Library a révolutionné ma façon de lire. L'interface est intuitive et la qualité des livres exceptionnelle. Je recommande vivement !"
                        </p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                SM
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">Sophie Martin</div>
                                <div class="text-gray-600 text-sm">Lectrice passionnée</div>
                                <div class="flex text-yellow-400 text-sm mt-1">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 relative">
                    <div class="absolute top-4 left-4 text-green-200">
                        <i class="fas fa-quote-left text-3xl"></i>
                    </div>
                    <div class="pt-8">
                        <p class="text-gray-700 mb-6 italic">
                            "En tant qu'auteur, publier mes livres sur E-Library a été un jeu d'enfant. Les outils d'analytics m'aident à comprendre mon audience."
                        </p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold">
                                JD
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">Jean Dubois</div>
                                <div class="text-gray-600 text-sm">Auteur publié</div>
                                <div class="flex text-yellow-400 text-sm mt-1">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gray-50 rounded-2xl p-8">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-quote-left text-2xl"></i>
                    </div>
                    <p class="text-gray-700 mb-6 italic">
                        "Interface simple et efficace. Je trouve facilement mes livres préférés."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center text-white font-bold">
                            AL
                        </div>
                        <div class="ml-4">
                            <div class="font-semibold text-gray-900">Alice Leroy</div>
                            <div class="text-gray-600 text-sm">Étudiante</div>
                            <div class="flex text-yellow-400 text-sm mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    Questions Fréquentes
                </h2>
                <p class="text-lg text-gray-600">
                    Trouvez rapidement les réponses à vos questions
                </p>
            </div>

            <div class="space-y-4" x-data="{ openFaq: null }">
                <!-- FAQ 1 -->
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 1 ? null : 1"
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-100 transition-colors">
                        <span class="font-semibold text-gray-900">Comment puis-je télécharger un livre ?</span>
                        <i class="fas fa-chevron-down transition-transform duration-200"
                           :class="{ 'rotate-180': openFaq === 1 }"></i>
                    </button>
                    <div x-show="openFaq === 1" x-transition class="px-6 pb-4">
                        <p class="text-gray-600">
                            Pour télécharger un livre, il suffit de cliquer sur le bouton "Télécharger" sur la page du livre.
                            Vous devez être connecté à votre compte pour accéder aux téléchargements.
                        </p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 2 ? null : 2"
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-100 transition-colors">
                        <span class="font-semibold text-gray-900">L'inscription est-elle vraiment gratuite ?</span>
                        <i class="fas fa-chevron-down transition-transform duration-200"
                           :class="{ 'rotate-180': openFaq === 2 }"></i>
                    </button>
                    <div x-show="openFaq === 2" x-transition class="px-6 pb-4">
                        <p class="text-gray-600">
                            Oui, l'inscription et l'utilisation de notre bibliothèque sont entièrement gratuites.
                            Aucun frais caché, aucun abonnement requis.
                        </p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 3 ? null : 3"
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-100 transition-colors">
                        <span class="font-semibold text-gray-900">Comment publier mon propre livre ?</span>
                        <i class="fas fa-chevron-down transition-transform duration-200"
                           :class="{ 'rotate-180': openFaq === 3 }"></i>
                    </button>
                    <div x-show="openFaq === 3" x-transition class="px-6 pb-4">
                        <p class="text-gray-600">
                            Connectez-vous à votre compte, allez dans votre dashboard et cliquez sur "Publier un livre".
                            Suivez les étapes pour uploader votre fichier PDF et remplir les informations nécessaires.
                        </p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 4 ? null : 4"
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-100 transition-colors">
                        <span class="font-semibold text-gray-900">Quels formats de fichiers sont acceptés ?</span>
                        <i class="fas fa-chevron-down transition-transform duration-200"
                           :class="{ 'rotate-180': openFaq === 4 }"></i>
                    </button>
                    <div x-show="openFaq === 4" x-transition class="px-6 pb-4">
                        <p class="text-gray-600">
                            Nous acceptons principalement les fichiers PDF. D'autres formats comme EPUB pourront être
                            supportés dans le futur selon les demandes de la communauté.
                        </p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 5 ? null : 5"
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-100 transition-colors">
                        <span class="font-semibold text-gray-900">Puis-je lire les livres hors ligne ?</span>
                        <i class="fas fa-chevron-down transition-transform duration-200"
                           :class="{ 'rotate-180': openFaq === 5 }"></i>
                    </button>
                    <div x-show="openFaq === 5" x-transition class="px-6 pb-4">
                        <p class="text-gray-600">
                            Oui, une fois téléchargé, vous pouvez lire le livre hors ligne avec n'importe quel lecteur PDF
                            sur votre appareil (ordinateur, tablette, smartphone).
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="text-center mt-8 p-6 bg-emerald-50 rounded-lg">
                <h3 class="font-semibold text-gray-900 mb-2">Vous ne trouvez pas votre réponse ?</h3>
                <p class="text-gray-600 mb-4">Notre équipe support est là pour vous aider</p>
                <a href="#" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-envelope mr-2"></i>
                    Contacter le Support
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-bg relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-5xl font-heading font-bold text-white mb-6">
                Prêt à Commencer Votre Aventure Littéraire ?
            </h2>
            <p class="text-xl text-white text-opacity-90 mb-8 max-w-3xl mx-auto">
                Rejoignez notre communauté de passionnés et découvrez un monde de connaissances à portée de clic
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                @guest
                    <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>
                        Créer un Compte Gratuit
                    </a>
                    <a href="{{ route('books.public.index') }}" class="glass-effect text-white px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-white hover:bg-opacity-20 transition-colors border border-white border-opacity-30">
                        <i class="fas fa-book-open mr-2"></i>
                        Explorer Sans Compte
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Accéder au Dashboard
                    </a>
                @endguest
            </div>

            <!-- Features List -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-infinity text-white text-2xl"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Accès Illimité</h3>
                    <p class="text-white text-opacity-80 text-sm">Lisez autant que vous voulez, quand vous voulez</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">100% Gratuit</h3>
                    <p class="text-white text-opacity-80 text-sm">Aucun frais caché, aucun abonnement requis</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Communauté</h3>
                    <p class="text-white text-opacity-80 text-sm">Rejoignez des milliers de lecteurs passionnés</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                <div class="mb-6">
                    <i class="fas fa-envelope-open text-white text-4xl mb-4"></i>
                    <h2 class="text-2xl md:text-3xl font-heading font-bold text-white mb-4">
                        Restez Informé
                    </h2>
                    <p class="text-white/90 text-lg">
                        Recevez les dernières nouveautés et recommandations directement dans votre boîte mail
                    </p>
                </div>

                <form class="max-w-md mx-auto" action="#" method="POST">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1">
                            <input type="email" name="email" required
                                   placeholder="Votre adresse email..."
                                   class="w-full px-4 py-3 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-white/50 text-gray-900 placeholder-gray-500">
                        </div>
                        <button type="submit"
                                class="bg-white text-emerald-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors whitespace-nowrap">
                            <i class="fas fa-paper-plane mr-2"></i>
                            S'abonner
                        </button>
                    </div>
                </form>

                <div class="mt-6 flex items-center justify-center space-x-6 text-white/80 text-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-300"></i>
                        <span>Nouveautés hebdomadaires</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-300"></i>
                        <span>Recommandations personnalisées</span>
                    </div>
                </div>

                <p class="text-white/60 text-xs mt-4">
                    Pas de spam, désinscription en un clic. Nous respectons votre vie privée.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer Compact -->
    <footer id="a-propos" class="bg-gray-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center mb-4">
                        @if(site_logo())
                            <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-8 w-auto">
                        @else
                            <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book-open text-white text-sm"></i>
                            </div>
                        @endif
                        <span class="ml-2 text-lg font-heading font-bold">{{ site_name() }}</span>
                    </div>
                    <p class="text-gray-300 mb-4 text-sm max-w-xs">
                        {{ site_setting('footer_description', 'Votre bibliothèque numérique moderne pour découvrir et partager des livres.') }}
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition-colors">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition-colors">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition-colors">
                            <i class="fab fa-linkedin-in text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-base font-semibold mb-4">Liens Rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('books.public.index') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Bibliothèque</a></li>
                        <li><a href="{{ route('books.search') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Recherche</a></li>
                        <li><a href="{{ route('books.categories') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Catégories</a></li>
                        @auth
                            <li><a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Connexion</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Inscription</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-base font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">FAQ</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Contact</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Confidentialité</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar Compact -->
            <div class="border-t border-gray-800 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-xs">
                    &copy; {{ date('Y') }} {{ site_name() }}. {{ site_setting('copyright_text', 'Tous droits réservés.') }}
                </p>
                <div class="flex items-center mt-2 md:mt-0">
                    <span class="text-gray-400 text-xs">{{ site_setting('footer_tagline', 'Fait avec ❤️ pour les amoureux des livres') }}</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Next-Gen Floating Action Button -->
    <button id="scrollToTop" class="fab opacity-0 invisible magnetic-hover ripple-effect particle-burst" onclick="scrollToTop()">
        <i class="fas fa-arrow-up transition-smooth"></i>
        <div class="absolute inset-0 rounded-full animate-pulse-glow opacity-0 hover:opacity-100 transition-smooth"></div>
    </button>

    <!-- Progress Indicator -->
    <div class="fixed top-0 left-0 w-full h-1 bg-gray-200 z-50">
        <div class="scroll-progress h-full bg-gradient-to-r from-primary-500 to-secondary-500 transition-smooth" style="width: 0%;"></div>
    </div>


    <!-- Next-Gen Motion Design Initialization -->
    <script>
        // Initialize advanced motion features when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize cursor trail effect (optional)
            if (window.innerWidth > 768) {
                initCursorTrail();
            }

            // Initialize gesture support for mobile
            initGestureSupport();

            // Add custom event listeners for swipe gestures
            document.addEventListener('swipeLeft', () => {
                console.log('Swipe left detected');
                // Add custom swipe left behavior
            });

            document.addEventListener('swipeRight', () => {
                console.log('Swipe right detected');
                // Add custom swipe right behavior
            });

            // Initialize performance monitoring
            if ('performance' in window) {
                window.addEventListener('load', () => {
                    const perfData = performance.getEntriesByType('navigation')[0];
                    console.log('Page load time:', perfData.loadEventEnd - perfData.loadEventStart, 'ms');
                });
            }

            // Add smooth scroll behavior for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Initialize scroll progress indicator
            window.addEventListener('scroll', () => {
                const scrollProgress = document.querySelector('.scroll-progress');
                if (scrollProgress) {
                    const scrollPercent = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
                    scrollProgress.style.width = Math.min(scrollPercent, 100) + '%';
                }
            }, { passive: true });
        });

        // Add CSS custom properties for dynamic animations
        document.documentElement.style.setProperty('--mouse-x', '0px');
        document.documentElement.style.setProperty('--mouse-y', '0px');

        // Global mouse tracking for magnetic effects
        document.addEventListener('mousemove', (e) => {
            document.documentElement.style.setProperty('--mouse-x', e.clientX + 'px');
            document.documentElement.style.setProperty('--mouse-y', e.clientY + 'px');
        });

        // Stats Counter Animation
        function statsCounter() {
            return {
                animatedBooks: 0,
                animatedUsers: 0,
                animatedDownloads: 0,
                animatedAuthors: 0,
                targetBooks: {{ $stats['total_books'] }},
                targetUsers: {{ $stats['total_users'] }},
                targetDownloads: {{ $stats['total_downloads'] }},
                targetAuthors: {{ $stats['total_authors'] }},

                init() {
                    this.animateCounters();
                },

                animateCounters() {
                    const duration = 2000; // 2 seconds
                    const steps = 60;
                    const stepDuration = duration / steps;

                    let currentStep = 0;

                    const interval = setInterval(() => {
                        currentStep++;
                        const progress = currentStep / steps;

                        this.animatedBooks = Math.floor(this.targetBooks * this.easeOutQuart(progress));
                        this.animatedUsers = Math.floor(this.targetUsers * this.easeOutQuart(progress));
                        this.animatedDownloads = Math.floor(this.targetDownloads * this.easeOutQuart(progress));
                        this.animatedAuthors = Math.floor(this.targetAuthors * this.easeOutQuart(progress));

                        if (currentStep >= steps) {
                            clearInterval(interval);
                            this.animatedBooks = this.targetBooks;
                            this.animatedUsers = this.targetUsers;
                            this.animatedDownloads = this.targetDownloads;
                            this.animatedAuthors = this.targetAuthors;
                        }
                    }, stepDuration);
                },

                easeOutQuart(t) {
                    return 1 - Math.pow(1 - t, 4);
                }
            }
        }

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        }, observerOptions);

        // Observe all sections for animation
        document.querySelectorAll('section').forEach(section => {
            observer.observe(section);
        });

        // Add hover effects to book cards
        document.addEventListener('DOMContentLoaded', function() {
            const bookCards = document.querySelectorAll('.group');
            bookCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.02)';
                    this.style.transition = 'all 0.3s ease';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });

        // Real-time data updates (optional)
        @if(Route::has('home.trending'))
        setInterval(() => {
            fetch('{{ route("home.trending") }}')
                .then(response => response.json())
                .then(data => {
                    console.log('Updated trending data:', data);
                })
                .catch(error => console.log('Trending data update failed:', error));
        }, 300000); // Update every 5 minutes
        @endif

        // Home page filters functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filtersForm = document.getElementById('homeFiltersForm');
            const clearFiltersBtn = document.getElementById('clearFilters');
            const heroSearchForm = document.getElementById('heroSearchForm');
            const heroSearchInput = document.getElementById('heroSearchInput');
            const authorSearchInput = document.getElementById('authorSearch');
            const authorSuggestions = document.getElementById('authorSuggestions');
            let searchTimeout;

            // Liste des auteurs disponibles
            const availableAuthors = @json($authors);

            // Function to apply filters
            function applyFilters(activeTab = 'recent') {
                const formData = new FormData(filtersForm);
                const params = new URLSearchParams();

                // Add form data to params
                for (let [key, value] of formData.entries()) {
                    if (value && value !== 'all') {
                        params.append(key, value);
                    }
                }

                // Ensure author filter is included
                if (authorSearchInput && authorSearchInput.value.trim()) {
                    params.set('author', authorSearchInput.value.trim());
                }

                // Add active tab
                params.append('tab', activeTab);

                // Show loading state
                showLoadingState();

                // Debug: log the parameters being sent
                console.log('Applying filters with params:', params.toString());
                console.log('Author input value:', authorSearchInput ? authorSearchInput.value : 'null');
                console.log('Form data entries:', Array.from(new FormData(filtersForm).entries()));

                // Fetch filtered books
                fetch('{{ route("home.filtered-books") }}?' + params.toString())
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateBooksDisplay(data.books, activeTab);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching filtered books:', error);
                    })
                    .finally(() => {
                        hideLoadingState();
                    });
            }

            // Function to update books display
            function updateBooksDisplay(books, activeTab) {
                const container = document.querySelector(`[x-show="activeTab === '${activeTab}'] .grid`);
                if (!container) return;

                if (books.length === 0) {
                    container.innerHTML = `
                        <div class="col-span-full text-center py-12">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-book text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun livre trouvé</h3>
                            <p class="text-gray-500">Essayez de modifier vos critères de recherche</p>
                        </div>
                    `;
                    return;
                }

                container.innerHTML = books.map(book => `
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 group h-96 flex flex-col">
                        <div class="relative h-56 flex-shrink-0">
                            ${book.cover_image ?
                                `<img src="${book.cover_image}" alt="${book.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">` :
                                `<div class="w-full h-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center group-hover:from-emerald-600 group-hover:to-emerald-700 transition-all duration-300">
                                    <div class="text-white text-center p-3 max-w-full">
                                        <i class="fas fa-book text-2xl mb-2 opacity-80"></i>
                                        <p class="text-xs font-medium leading-tight break-words">${book.title}</p>
                                    </div>
                                </div>`
                            }
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm mb-1 line-clamp-2">${book.title}</h3>
                                <p class="text-gray-600 text-xs mb-2">par ${book.author_name}</p>
                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                                    <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full">${book.category || 'Non classé'}</span>
                                    <span>${book.language || 'FR'}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3 text-xs text-gray-500">
                                    <span><i class="fas fa-eye mr-1"></i>${book.views}</span>
                                    <span><i class="fas fa-download mr-1"></i>${book.downloads}</span>
                                </div>
                                <a href="${book.url}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded text-xs font-semibold transition-all duration-300">
                                    Découvrir
                                </a>
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            // Function to show loading state
            function showLoadingState() {
                const loadingDiv = document.createElement('div');
                loadingDiv.id = 'booksLoading';
                loadingDiv.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                loadingDiv.innerHTML = `
                    <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-emerald-600"></div>
                        <span class="text-gray-700">Chargement des livres...</span>
                    </div>
                `;
                document.body.appendChild(loadingDiv);
            }

            // Function to hide loading state
            function hideLoadingState() {
                const loadingDiv = document.getElementById('booksLoading');
                if (loadingDiv) {
                    loadingDiv.remove();
                }
            }

            // Event listeners for filters
            filtersForm.addEventListener('input', function(e) {
                if (e.target.name === 'search') {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        const activeTab = document.querySelector('[x-data] button[class*="bg-white"]')?.getAttribute('@click')?.match(/'(\w+)'/)?.[1] || 'recent';
                        applyFilters(activeTab);
                    }, 500);
                } else {
                    const activeTab = document.querySelector('[x-data] button[class*="bg-white"]')?.getAttribute('@click')?.match(/'(\w+)'/)?.[1] || 'recent';
                    applyFilters(activeTab);
                }
            });

            filtersForm.addEventListener('change', function(e) {
                if (e.target.tagName === 'SELECT') {
                    const activeTab = document.querySelector('[x-data] button[class*="bg-white"]')?.getAttribute('@click')?.match(/'(\w+)'/)?.[1] || 'recent';
                    applyFilters(activeTab);
                }
            });

            // Clear filters
            clearFiltersBtn.addEventListener('click', function() {
                filtersForm.reset();

                // Hide author suggestions
                if (authorSuggestions) {
                    authorSuggestions.classList.add('hidden');
                }

                const activeTab = document.querySelector('[x-data] button[class*="bg-white"]')?.getAttribute('@click')?.match(/'(\w+)'/)?.[1] || 'recent';
                applyFilters(activeTab);
            });

            // Listen for tab changes
            document.addEventListener('click', function(e) {
                if (e.target.matches('[x-data] button')) {
                    const tabMatch = e.target.getAttribute('@click')?.match(/'(\w+)'/);
                    if (tabMatch) {
                        setTimeout(() => {
                            applyFilters(tabMatch[1]);
                        }, 100);
                    }
                }
            });

            // Hero search functionality
            if (heroSearchForm && heroSearchInput) {
                heroSearchForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const searchTerm = heroSearchInput.value.trim();
                    if (searchTerm) {
                        // Set the search term in the filters form
                        const searchInput = filtersForm.querySelector('input[name="search"]');
                        if (searchInput) {
                            searchInput.value = searchTerm;
                        }

                        // Scroll to the books section
                        const booksSection = document.getElementById('nouveautes');
                        if (booksSection) {
                            booksSection.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });

                            // Apply filters after scrolling
                            setTimeout(() => {
                                const activeTab = document.querySelector('[x-data] button[class*="bg-white"]')?.getAttribute('@click')?.match(/'(\w+)'/)?.[1] || 'recent';
                                applyFilters(activeTab);
                            }, 500);
                        }
                    }
                });

                // Also handle Enter key in hero search input
                heroSearchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        heroSearchForm.dispatchEvent(new Event('submit'));
                    }
                });
            }

            // Author autocomplete functionality
            if (authorSearchInput && authorSuggestions) {
                let selectedAuthorIndex = -1;

                // Show suggestions on input
                authorSearchInput.addEventListener('input', function() {
                    const query = this.value.toLowerCase().trim();
                    selectedAuthorIndex = -1;

                    if (query.length === 0) {
                        authorSuggestions.classList.add('hidden');
                        // Apply filters with no author filter
                        const activeTab = document.querySelector('[x-data] button[class*="bg-white"]')?.getAttribute('@click')?.match(/'(\w+)'/)?.[1] || 'recent';
                        applyFilters(activeTab);
                        return;
                    }

                    // Filter authors based on query
                    const filteredAuthors = availableAuthors.filter(author =>
                        author.toLowerCase().includes(query)
                    ).slice(0, 8); // Limit to 8 suggestions

                    if (filteredAuthors.length > 0) {
                        authorSuggestions.innerHTML = filteredAuthors.map((author, index) =>
                            `<div class="px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm author-suggestion" data-author="${author}" data-index="${index}">
                                ✍️ ${author}
                            </div>`
                        ).join('');
                        authorSuggestions.classList.remove('hidden');
                    } else {
                        authorSuggestions.classList.add('hidden');
                    }
                });

                // Handle keyboard navigation
                authorSearchInput.addEventListener('keydown', function(e) {
                    const suggestions = authorSuggestions.querySelectorAll('.author-suggestion');

                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        selectedAuthorIndex = Math.min(selectedAuthorIndex + 1, suggestions.length - 1);
                        updateSelectedSuggestion(suggestions);
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        selectedAuthorIndex = Math.max(selectedAuthorIndex - 1, -1);
                        updateSelectedSuggestion(suggestions);
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        if (selectedAuthorIndex >= 0 && suggestions[selectedAuthorIndex]) {
                            selectAuthor(suggestions[selectedAuthorIndex].dataset.author);
                        }
                    } else if (e.key === 'Escape') {
                        authorSuggestions.classList.add('hidden');
                        selectedAuthorIndex = -1;
                    }
                });

                // Handle click on suggestions
                authorSuggestions.addEventListener('click', function(e) {
                    const suggestion = e.target.closest('.author-suggestion');
                    if (suggestion) {
                        selectAuthor(suggestion.dataset.author);
                    }
                });

                // Hide suggestions when clicking outside
                document.addEventListener('click', function(e) {
                    if (!authorSearchInput.contains(e.target) && !authorSuggestions.contains(e.target)) {
                        authorSuggestions.classList.add('hidden');
                        selectedAuthorIndex = -1;
                    }
                });

                function updateSelectedSuggestion(suggestions) {
                    suggestions.forEach((suggestion, index) => {
                        if (index === selectedAuthorIndex) {
                            suggestion.classList.add('bg-emerald-100');
                        } else {
                            suggestion.classList.remove('bg-emerald-100');
                        }
                    });
                }

                function selectAuthor(author) {
                    authorSearchInput.value = author;
                    authorSuggestions.classList.add('hidden');
                    selectedAuthorIndex = -1;

                    // Apply filters with selected author
                    const activeTab = document.querySelector('[x-data] button[class*="bg-white"]')?.getAttribute('@click')?.match(/'(\w+)'/)?.[1] || 'recent';
                    applyFilters(activeTab);
                }
            }
        });
    </script>

    <style>
        /* Custom animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* Hover effects */
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Glass effect */
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
        }

        /* Smooth transitions for interactive elements */
        .group {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .group:hover {
            transform: translateY(-2px);
        }

        /* Enhanced Grid Spacing - Fix for colliding blocks */
        .grid {
            gap: 2rem !important;
        }

        .grid > * {
            margin-bottom: 1.5rem;
        }

        /* Ensure proper spacing on mobile */
        @media (max-width: 768px) {
            .grid {
                gap: 1.5rem !important;
            }

            .grid > * {
                margin-bottom: 1rem;
            }
        }

        /* Fix for Alpine.js transitions */
        [x-cloak] {
            display: none !important;
        }

        /* Enhanced card spacing */
        .card-spacing {
            margin-bottom: 1.5rem !important;
        }

        /* Specific fixes for book cards */
        .books-grid-container {
            padding: 0 0.5rem;
        }

        .books-grid-container .grid {
            gap: 2rem !important;
            margin-bottom: 2rem;
        }

        /* Prevent cards from touching */
        .book-card {
            margin-bottom: 1.5rem !important;
        }

        /* Line clamp utilities for uniform text display */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-4 {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Ensure text breaks properly in placeholders */
        .break-words {
            word-wrap: break-word;
            word-break: break-word;
            hyphens: auto;
        }
    </style>

</body>
</html>
