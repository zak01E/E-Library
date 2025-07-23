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
                        <a href="#accueil" class="text-gray-900 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">{{ site_setting('nav_menu_accueil', 'Accueil') }}</a>
                        <a href="{{ route('books.public.index') }}" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">{{ site_setting('nav_menu_bibliotheque', 'Bibliothèque') }}</a>
                        <a href="{{ route('authors.index') }}" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">{{ site_setting('nav_menu_auteurs', 'Auteurs') }}</a>
                        <a href="#a-propos" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">{{ site_setting('nav_menu_apropos', 'À propos') }}</a>
                    </div>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                {{ site_setting('nav_button_dashboard', 'Dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-500 hover:text-emerald-600 px-3 py-2 text-sm font-medium transition-colors">
                                {{ site_setting('nav_button_connexion', 'Connexion') }}
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    {{ site_setting('nav_button_inscription', 'S\'inscrire') }}
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
                <a href="#accueil" class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">{{ site_setting('nav_menu_accueil', 'Accueil') }}</a>
                <a href="{{ route('books.public.index') }}" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">{{ site_setting('nav_menu_bibliotheque', 'Bibliothèque') }}</a>
                <a href="{{ route('authors.index') }}" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">{{ site_setting('nav_menu_auteurs', 'Auteurs') }}</a>
                <a href="#a-propos" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">{{ site_setting('nav_menu_apropos', 'À propos') }}</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-indigo-600 text-white block px-3 py-2 rounded-md text-base font-medium">{{ site_setting('nav_button_dashboard', 'Dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">{{ site_setting('nav_button_connexion', 'Connexion') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-indigo-600 text-white block px-3 py-2 rounded-md text-base font-medium">{{ site_setting('nav_button_inscription', 'S\'inscrire') }}</a>
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
                    {{ site_setting('hero_welcome_text', 'Bienvenue sur') }}<br>
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
                                   placeholder="{{ site_setting('hero_search_placeholder', 'Rechercher un livre...') }}"
                                   class="w-full pl-10 pr-3 py-2.5 text-gray-900 border-0 focus:outline-none focus:ring-0 text-sm">
                        </div>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 font-semibold transition-colors text-sm">
                            {{ site_setting('hero_search_button', 'Rechercher') }}
                        </button>
                    </form>
                </div>

                <!-- CTA Buttons Compact -->
                <div class="flex flex-col sm:flex-row gap-2 justify-center items-center mb-6">
                    <a href="{{ route('books.public.index') }}" class="bg-white text-emerald-600 px-5 py-2.5 rounded-lg font-semibold hover:bg-gray-100 transition-colors shadow text-sm">
                        <i class="fas fa-book-open mr-2"></i>
                        {{ site_setting('hero_cta_explorer', 'Explorer la Bibliothèque') }}
                    </a>

                    @guest
                        <a href="{{ route('register') }}" class="bg-white/20 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-white/30 transition-colors border border-white/30 text-sm">
                            <i class="fas fa-user-plus mr-2"></i>
                            {{ site_setting('hero_cta_rejoindre', 'Rejoindre') }}
                        </a>
                    @endguest
                </div>

                <!-- Stats Compact with Animation -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-w-lg mx-auto" x-data="statsCounter()">
                    <div class="text-center">
                        <div class="text-xl font-bold text-white mb-1" x-text="animatedBooks + '+'"></div>
                        <div class="text-white/70 text-xs">{{ site_setting('hero_stats_livres', 'Livres') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-white mb-1" x-text="animatedUsers + '+'"></div>
                        <div class="text-white/70 text-xs">{{ site_setting('hero_stats_lecteurs', 'Lecteurs') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-white mb-1" x-text="animatedDownloads + '+'"></div>
                        <div class="text-white/70 text-xs">{{ site_setting('hero_stats_telechargements', 'Téléchargements') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-white mb-1" x-text="animatedAuthors + '+'"></div>
                        <div class="text-white/70 text-xs">{{ site_setting('hero_stats_auteurs', 'Auteurs') }}</div>
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
                    {{ site_setting('features_title', 'Nos Fonctionnalités') }}
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    {{ site_setting('features_subtitle', 'Découvrez ce qui rend notre bibliothèque numérique unique') }}
                </p>
            </div>

            <div class="grid grid-cols-3 gap-3 sm:gap-6">
                <!-- Feature 1: Lecture -->
                <div class="bg-white rounded-lg p-3 sm:p-6 shadow-sm">
                    <div class="w-8 h-8 sm:w-12 sm:h-12 bg-{{ site_setting('feature1_color', 'emerald') }}-500 rounded-lg flex items-center justify-center mb-2 sm:mb-4">
                        <i class="{{ site_setting('feature1_icon', 'fas fa-book-reader') }} text-white text-sm sm:text-xl"></i>
                    </div>
                    <h3 class="text-sm sm:text-lg font-semibold text-gray-900 mb-2 sm:mb-3 font-heading">{{ site_setting('feature1_title', 'Lecture Simple') }}</h3>
                    <p class="text-xs sm:text-base text-gray-600 mb-2 sm:mb-4">
                        {{ site_setting('feature1_description', 'Lisez vos livres préférés avec notre lecteur intégré et intuitif.') }}
                    </p>
                    <ul class="space-y-1 sm:space-y-2 text-xs sm:text-sm text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-{{ site_setting('feature1_color', 'emerald') }}-500 text-xs mr-2"></i>
                            {{ site_setting('feature1_point1', 'Lecteur PDF intégré') }}
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-{{ site_setting('feature1_color', 'emerald') }}-500 text-xs mr-2"></i>
                            {{ site_setting('feature1_point2', 'Mode sombre/clair') }}
                        </li>
                    </ul>
                </div>

                <!-- Feature 2: Publication -->
                <div class="bg-white rounded-lg p-3 sm:p-6 shadow-sm">
                    <div class="w-8 h-8 sm:w-12 sm:h-12 bg-{{ site_setting('feature2_color', 'green') }}-500 rounded-lg flex items-center justify-center mb-2 sm:mb-4">
                        <i class="{{ site_setting('feature2_icon', 'fas fa-pen-fancy') }} text-white text-sm sm:text-xl"></i>
                    </div>
                    <h3 class="text-sm sm:text-lg font-semibold text-gray-900 mb-2 sm:mb-3">{{ site_setting('feature2_title', 'Publication') }}</h3>
                    <p class="text-xs sm:text-base text-gray-600 mb-2 sm:mb-4">
                        {{ site_setting('feature2_description', 'Publiez vos œuvres facilement et partagez-les avec la communauté.') }}
                    </p>
                    <ul class="space-y-1 sm:space-y-2 text-xs sm:text-sm text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-{{ site_setting('feature2_color', 'green') }}-500 text-xs mr-2"></i>
                            {{ site_setting('feature2_point1', 'Upload simple') }}
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-{{ site_setting('feature2_color', 'green') }}-500 text-xs mr-2"></i>
                            {{ site_setting('feature2_point2', 'Validation rapide') }}
                        </li>
                    </ul>
                </div>

                <!-- Feature 3: Recherche -->
                <div class="bg-white rounded-lg p-3 sm:p-6 shadow-sm">
                    <div class="w-8 h-8 sm:w-12 sm:h-12 bg-{{ site_setting('feature3_color', 'orange') }}-500 rounded-lg flex items-center justify-center mb-2 sm:mb-4">
                        <i class="{{ site_setting('feature3_icon', 'fas fa-search') }} text-white text-sm sm:text-xl"></i>
                    </div>
                    <h3 class="text-sm sm:text-lg font-semibold text-gray-900 mb-2 sm:mb-3">{{ site_setting('feature3_title', 'Recherche') }}</h3>
                    <p class="text-xs sm:text-base text-gray-600 mb-2 sm:mb-4">
                        {{ site_setting('feature3_description', 'Trouvez rapidement vos livres préférés.') }}
                    </p>
                    <ul class="space-y-1 sm:space-y-2 text-xs sm:text-sm text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-{{ site_setting('feature3_color', 'orange') }}-500 text-xs mr-2"></i>
                            {{ site_setting('feature3_point1', 'Recherche par titre') }}
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-{{ site_setting('feature3_color', 'orange') }}-500 text-xs mr-2"></i>
                            {{ site_setting('feature3_point2', 'Filtres par catégorie') }}
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
                    {{ site_setting('books_section_title', 'Découvrez nos Livres') }}
                </h2>

                <!-- Filters Section -->
                <div class="max-w-4xl mx-auto">
                    <x-book-filters
                        :action="route('home')"
                        :categories="$categories"
                        :languages="$languages"
                        :authors="$authors"
                        :show-sort="false"
                    />
                </div>

                <!-- Section Tabs -->
                <div class="flex justify-center mb-8">
                    <div class="bg-gray-100 rounded-lg p-1 inline-flex" x-data="{ activeTab: 'recent' }" x-cloak>
                        <button @click="activeTab = 'recent'"
                                :class="activeTab === 'recent' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                            <i class="fas fa-clock mr-2"></i>{{ site_setting('books_tab_recent', 'Récents') }}
                        </button>
                        <button @click="activeTab = 'popular'"
                                :class="activeTab === 'popular' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                            <i class="fas fa-fire mr-2"></i>{{ site_setting('books_tab_popular', 'Populaires') }}
                        </button>
                        <button @click="activeTab = 'viewed'"
                                :class="activeTab === 'viewed' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                            <i class="fas fa-eye mr-2"></i>{{ site_setting('books_tab_viewed', 'Les plus vus') }}
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

    @php
        // Calculer les livres uniques pour la section simple
        $usedInTabs = collect($featuredBooks['popular'])
            ->merge($featuredBooks['recent'])
            ->merge($featuredBooks['most_viewed'])
            ->pluck('id')
            ->unique();

        // Obtenir des livres différents pour cette section
        $simpleBooks = collect($featuredBooks['popular'])
            ->merge($featuredBooks['recent'])
            ->merge($featuredBooks['most_viewed'])
            ->unique('id')
            ->take(4);

        // Si on a moins de 8 livres uniques au total, masquer cette section
        $totalUniqueBooks = $simpleBooks->count();
        $showSimpleSection = $totalUniqueBooks >= 8;
    @endphp

    @if($showSimpleSection)
    <!-- Books Section Simple -->
    <section id="bibliotheque" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    {{ site_setting('simple_books_title', 'Sélection Spéciale') }}
                </h2>
                <p class="text-lg text-gray-600">
                    {{ site_setting('simple_books_subtitle', 'Découvrez notre sélection de livres') }}
                </p>
            </div>

            <!-- Books Grid Simple -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $colors = ['emerald', 'green', 'orange', 'blue'];
                    $icons = ['fas fa-book', 'fas fa-leaf', 'fas fa-brain', 'fas fa-star'];
                @endphp

                @forelse($simpleBooks as $index => $book)
                    @php
                        $color = $colors[$index % count($colors)];
                        $icon = $icons[$index % count($icons)];
                    @endphp
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                        <div class="aspect-[3/4] bg-{{ $color }}-500 flex items-center justify-center">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}"
                                     alt="{{ $book->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="text-white text-center p-4">
                                    <i class="{{ $icon }} text-3xl mb-2"></i>
                                    <div class="font-semibold">{{ Str::limit($book->title, 20) }}</div>
                                    <div class="text-sm opacity-80">par {{ $book->author_name }}</div>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-2">{{ Str::limit($book->title, 25) }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($book->description ?? $book->category, 40) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-{{ $color }}-600 font-semibold">
                                    {{ $book->price > 0 ? number_format($book->price, 2) . '€' : 'Gratuit' }}
                                </span>
                                <a href="{{ route('books.public.show', $book) }}"
                                   class="bg-{{ $color }}-600 hover:bg-{{ $color }}-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                    Lire
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Fallback si pas de livres -->
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">Aucun livre disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>

            <!-- View All Button -->
            <div class="text-center mt-8">
                <a href="{{ route('books.public.index') }}" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-book-open mr-2"></i>
                    {{ site_setting('simple_books_button', 'Voir Tous les Livres') }}
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Authors Section -->
    <section id="auteurs" class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    {{ site_setting('simple_authors_title', 'Auteurs Vedettes') }}
                </h2>
                <p class="text-lg text-gray-600">
                    {{ site_setting('simple_authors_subtitle', 'Découvrez les auteurs les plus appréciés de notre communauté') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $simpleAuthors = $featuredAuthors->take(4);
                    $colors = [
                        ['from' => 'blue-400', 'to' => 'blue-600', 'text' => 'blue-600'],
                        ['from' => 'green-400', 'to' => 'green-600', 'text' => 'green-600'],
                        ['from' => 'purple-400', 'to' => 'purple-600', 'text' => 'purple-600'],
                        ['from' => 'orange-400', 'to' => 'orange-600', 'text' => 'orange-600']
                    ];
                @endphp

                @forelse($simpleAuthors as $index => $author)
                    @php
                        $color = $colors[$index % count($colors)];
                        $initials = collect(explode(' ', $author->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(2)->join('');
                    @endphp
                    <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="w-20 h-20 bg-gradient-to-br from-{{ $color['from'] }} to-{{ $color['to'] }} rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-white font-bold text-xl">{{ $initials }}</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">{{ $author->name }}</h3>
                        <p class="text-gray-600 text-sm mb-3">{{ $author->author_bio ?? 'Auteur sur E-Library' }}</p>
                        <div class="flex items-center justify-center space-x-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-book text-{{ explode('-', $color['text'])[0] }}-500 mr-1"></i>{{ $author->approved_books_count }} livre{{ $author->approved_books_count > 1 ? 's' : '' }}</span>
                            <span><i class="fas fa-heart text-red-500 mr-1"></i>{{ number_format($author->total_views / 1000, 1) }}K</span>
                        </div>
                        <a href="{{ route('authors.show', $author) }}" class="text-{{ $color['text'] }} hover:text-{{ $color['text'] }} font-medium text-sm transition-colors">
                            {{ site_setting('simple_authors_button', 'Voir les livres') }}
                        </a>
                    </div>
                @empty
                    <!-- Fallback si pas d'auteurs -->
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">Aucun auteur disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>

            <!-- View All Authors Button -->
            <div class="text-center mt-8">
                <a href="{{ route('authors.index') }}" class="inline-flex items-center bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-users mr-2"></i>
                    {{ site_setting('simple_authors_view_all', 'Voir tous les auteurs') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section Simple -->
    <section id="temoignages" class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                    {{ site_setting('testimonials_title', 'Témoignages') }}
                </h2>
                <p class="text-lg text-gray-600">
                    {{ site_setting('testimonials_subtitle', 'Ce que disent nos utilisateurs') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gradient-to-br from-{{ site_setting('testimonial1_color', 'blue') }}-50 to-{{ site_setting('testimonial1_color', 'blue') }}-100 rounded-2xl p-8 relative">
                    <div class="absolute top-4 left-4 text-{{ site_setting('testimonial1_color', 'blue') }}-200">
                        <i class="fas fa-quote-left text-3xl"></i>
                    </div>
                    <div class="pt-8">
                        <p class="text-gray-700 mb-6 italic">
                            "{{ site_setting('testimonial1_text', 'E-Library a révolutionné ma façon de lire. L\'interface est intuitive et la qualité des livres exceptionnelle. Je recommande vivement !') }}"
                        </p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-{{ site_setting('testimonial1_color', 'blue') }}-400 to-{{ site_setting('testimonial1_color', 'blue') }}-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ site_setting('testimonial1_initials', 'SM') }}
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">{{ site_setting('testimonial1_name', 'Sophie Martin') }}</div>
                                <div class="text-gray-600 text-sm">{{ site_setting('testimonial1_role', 'Lectrice passionnée') }}</div>
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
                <div class="bg-gradient-to-br from-{{ site_setting('testimonial2_color', 'green') }}-50 to-{{ site_setting('testimonial2_color', 'green') }}-100 rounded-2xl p-8 relative">
                    <div class="absolute top-4 left-4 text-{{ site_setting('testimonial2_color', 'green') }}-200">
                        <i class="fas fa-quote-left text-3xl"></i>
                    </div>
                    <div class="pt-8">
                        <p class="text-gray-700 mb-6 italic">
                            "{{ site_setting('testimonial2_text', 'En tant qu\'auteur, publier mes livres sur E-Library a été un jeu d\'enfant. Les outils d\'analytics m\'aident à comprendre mon audience.') }}"
                        </p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-{{ site_setting('testimonial2_color', 'green') }}-400 to-{{ site_setting('testimonial2_color', 'green') }}-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ site_setting('testimonial2_initials', 'JD') }}
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">{{ site_setting('testimonial2_name', 'Jean Dubois') }}</div>
                                <div class="text-gray-600 text-sm">{{ site_setting('testimonial2_role', 'Auteur publié') }}</div>
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
                <div class="bg-{{ site_setting('testimonial3_color', 'gray') }}-50 rounded-2xl p-8">
                    <div class="text-{{ site_setting('testimonial3_color', 'gray') }}-400 mb-4">
                        <i class="fas fa-quote-left text-2xl"></i>
                    </div>
                    <p class="text-gray-700 mb-6 italic">
                        "{{ site_setting('testimonial3_text', 'Interface simple et efficace. Je trouve facilement mes livres préférés.') }}"
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-{{ site_setting('testimonial3_color', 'gray') }}-400 rounded-full flex items-center justify-center text-white font-bold">
                            {{ site_setting('testimonial3_initials', 'AL') }}
                        </div>
                        <div class="ml-4">
                            <div class="font-semibold text-gray-900">{{ site_setting('testimonial3_name', 'Alice Leroy') }}</div>
                            <div class="text-gray-600 text-sm">{{ site_setting('testimonial3_role', 'Étudiante') }}</div>
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
                    {{ site_setting('faq_title', 'Questions Fréquentes') }}
                </h2>
                <p class="text-lg text-gray-600">
                    {{ site_setting('faq_subtitle', 'Trouvez rapidement les réponses à vos questions') }}
                </p>
            </div>

            <div class="space-y-4" x-data="{ openFaq: null }">
                <!-- FAQ 1 -->
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 1 ? null : 1"
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-100 transition-colors">
                        <span class="font-semibold text-gray-900">{{ site_setting('faq1_question', 'Comment puis-je télécharger un livre ?') }}</span>
                        <i class="fas fa-chevron-down transition-transform duration-200"
                           :class="{ 'rotate-180': openFaq === 1 }"></i>
                    </button>
                    <div x-show="openFaq === 1" x-transition class="px-6 pb-4">
                        <p class="text-gray-600">
                            {{ site_setting('faq1_answer', 'Pour télécharger un livre, il suffit de cliquer sur le bouton "Télécharger" sur la page du livre. Vous devez être connecté à votre compte pour accéder aux téléchargements.') }}
                        </p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 2 ? null : 2"
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-100 transition-colors">
                        <span class="font-semibold text-gray-900">{{ site_setting('faq2_question', 'L\'inscription est-elle vraiment gratuite ?') }}</span>
                        <i class="fas fa-chevron-down transition-transform duration-200"
                           :class="{ 'rotate-180': openFaq === 2 }"></i>
                    </button>
                    <div x-show="openFaq === 2" x-transition class="px-6 pb-4">
                        <p class="text-gray-600">
                            {{ site_setting('faq2_answer', 'Oui, l\'inscription et l\'utilisation de notre bibliothèque sont entièrement gratuites. Aucun frais caché, aucun abonnement requis.') }}
                        </p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 3 ? null : 3"
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-100 transition-colors">
                        <span class="font-semibold text-gray-900">{{ site_setting('faq3_question', 'Comment publier mon propre livre ?') }}</span>
                        <i class="fas fa-chevron-down transition-transform duration-200"
                           :class="{ 'rotate-180': openFaq === 3 }"></i>
                    </button>
                    <div x-show="openFaq === 3" x-transition class="px-6 pb-4">
                        <p class="text-gray-600">
                            {{ site_setting('faq3_answer', 'Connectez-vous à votre compte, allez dans votre dashboard et cliquez sur "Publier un livre". Suivez les étapes pour uploader votre fichier PDF et remplir les informations nécessaires.') }}
                        </p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 4 ? null : 4"
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-100 transition-colors">
                        <span class="font-semibold text-gray-900">{{ site_setting('faq4_question', 'Quels formats de fichiers sont acceptés ?') }}</span>
                        <i class="fas fa-chevron-down transition-transform duration-200"
                           :class="{ 'rotate-180': openFaq === 4 }"></i>
                    </button>
                    <div x-show="openFaq === 4" x-transition class="px-6 pb-4">
                        <p class="text-gray-600">
                            {{ site_setting('faq4_answer', 'Nous acceptons principalement les fichiers PDF. D\'autres formats comme EPUB pourront être supportés dans le futur selon les demandes de la communauté.') }}
                        </p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 5 ? null : 5"
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-100 transition-colors">
                        <span class="font-semibold text-gray-900">{{ site_setting('faq5_question', 'Puis-je lire les livres hors ligne ?') }}</span>
                        <i class="fas fa-chevron-down transition-transform duration-200"
                           :class="{ 'rotate-180': openFaq === 5 }"></i>
                    </button>
                    <div x-show="openFaq === 5" x-transition class="px-6 pb-4">
                        <p class="text-gray-600">
                            {{ site_setting('faq5_answer', 'Oui, une fois téléchargé, vous pouvez lire le livre hors ligne avec n\'importe quel lecteur PDF sur votre appareil (ordinateur, tablette, smartphone).') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="text-center mt-8 p-6 bg-emerald-50 rounded-lg">
                <h3 class="font-semibold text-gray-900 mb-2">{{ site_setting('faq_support_title', 'Vous ne trouvez pas votre réponse ?') }}</h3>
                <p class="text-gray-600 mb-4">{{ site_setting('faq_support_subtitle', 'Notre équipe support est là pour vous aider') }}</p>
                <a href="#" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-envelope mr-2"></i>
                    {{ site_setting('faq_support_button', 'Contacter le Support') }}
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-bg relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-5xl font-heading font-bold text-white mb-6">
                {{ site_setting('cta_title', 'Prêt à Commencer Votre Aventure Littéraire ?') }}
            </h2>
            <p class="text-xl text-white text-opacity-90 mb-8 max-w-3xl mx-auto">
                {{ site_setting('cta_subtitle', 'Rejoignez notre communauté de passionnés et découvrez un monde de connaissances à portée de clic') }}
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                @guest
                    <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>
                        {{ site_setting('cta_button_register', 'Créer un Compte Gratuit') }}
                    </a>
                    <a href="{{ route('books.public.index') }}" class="glass-effect text-white px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-white hover:bg-opacity-20 transition-colors border border-white border-opacity-30">
                        <i class="fas fa-book-open mr-2"></i>
                        {{ site_setting('cta_button_explore', 'Explorer Sans Compte') }}
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        {{ site_setting('cta_button_dashboard', 'Accéder au Dashboard') }}
                    </a>
                @endguest
            </div>

            <!-- Features List -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-infinity text-white text-2xl"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">{{ site_setting('cta_feature1_title', 'Accès Illimité') }}</h3>
                    <p class="text-white text-opacity-80 text-sm">{{ site_setting('cta_feature1_description', 'Lisez autant que vous voulez, quand vous voulez') }}</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">{{ site_setting('cta_feature2_title', '100% Gratuit') }}</h3>
                    <p class="text-white text-opacity-80 text-sm">{{ site_setting('cta_feature2_description', 'Aucun frais caché, aucun abonnement requis') }}</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">{{ site_setting('cta_feature3_title', 'Communauté') }}</h3>
                    <p class="text-white text-opacity-80 text-sm">{{ site_setting('cta_feature3_description', 'Rejoignez des milliers de lecteurs passionnés') }}</p>
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
                        {{ site_setting('newsletter_title', 'Restez Informé') }}
                    </h2>
                    <p class="text-white/90 text-lg">
                        {{ site_setting('newsletter_subtitle', 'Recevez les dernières nouveautés et recommandations directement dans votre boîte mail') }}
                    </p>
                </div>

                <form class="max-w-md mx-auto" action="#" method="POST">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1">
                            <input type="email" name="email" required
                                   placeholder="{{ site_setting('newsletter_placeholder', 'Votre adresse email...') }}"
                                   class="w-full px-4 py-3 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-white/50 text-gray-900 placeholder-gray-500">
                        </div>
                        <button type="submit"
                                class="bg-white text-emerald-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors whitespace-nowrap">
                            <i class="fas fa-paper-plane mr-2"></i>
                            {{ site_setting('newsletter_button', 'S\'abonner') }}
                        </button>
                    </div>
                </form>

                <div class="mt-6 flex items-center justify-center space-x-6 text-white/80 text-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-300"></i>
                        <span>{{ site_setting('newsletter_feature1', 'Nouveautés hebdomadaires') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-300"></i>
                        <span>{{ site_setting('newsletter_feature2', 'Recommandations personnalisées') }}</span>
                    </div>
                </div>

                <p class="text-white/60 text-xs mt-4">
                    {{ site_setting('newsletter_privacy', 'Pas de spam, désinscription en un clic. Nous respectons votre vie privée.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Footer Compact -->
    <footer id="a-propos" class="bg-gray-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="footer-grid grid grid-cols-1 md:grid-cols-3 gap-6">
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
                    <h3 class="text-base font-semibold mb-4">{{ site_setting('footer_links_title', 'Liens Rapides') }}</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('books.public.index') }}" class="text-gray-300 hover:text-white transition-colors text-sm">{{ site_setting('footer_link_library', 'Bibliothèque') }}</a></li>
                        <li><a href="{{ route('books.search') }}" class="text-gray-300 hover:text-white transition-colors text-sm">{{ site_setting('footer_link_search', 'Recherche') }}</a></li>
                        <li><a href="{{ route('books.categories') }}" class="text-gray-300 hover:text-white transition-colors text-sm">{{ site_setting('footer_link_categories', 'Catégories') }}</a></li>
                        @auth
                            <li><a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-white transition-colors text-sm">{{ site_setting('footer_link_dashboard', 'Dashboard') }}</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors text-sm">{{ site_setting('footer_link_login', 'Connexion') }}</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition-colors text-sm">{{ site_setting('footer_link_register', 'Inscription') }}</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-base font-semibold mb-4">{{ site_setting('footer_support_title', 'Support') }}</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">{{ site_setting('footer_support_help', 'Centre d\'aide') }}</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">{{ site_setting('footer_support_faq', 'FAQ') }}</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">{{ site_setting('footer_support_contact', 'Contact') }}</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">{{ site_setting('footer_support_privacy', 'Confidentialité') }}</a></li>
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

        // Book filters are handled by the external book-filters.js script




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
