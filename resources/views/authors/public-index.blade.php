<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tous les Auteurs - {{ site_name() }}</title>
    <link rel="icon" type="image/x-icon" href="{{ site_favicon() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 overflow-x-hidden">
    <!-- Navigation Header (same as home page) -->
    <nav class="bg-white shadow-lg sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ url('/') }}" class="flex items-center">
                            @if(site_logo())
                                <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-10 w-auto">
                            @else
                                <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book-open text-white text-lg"></i>
                                </div>
                            @endif
                            <span class="ml-3 text-xl font-heading font-bold text-gray-900">{{ site_name() }}</span>
                        </a>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ url('/') }}" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">{{ site_setting('nav_menu_accueil', 'Accueil') }}</a>
                        <a href="{{ route('books.public.index') }}" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">{{ site_setting('nav_menu_bibliotheque', 'Bibliothèque') }}</a>
                        <a href="{{ route('authors.index') }}" class="text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">{{ site_setting('nav_menu_auteurs', 'Auteurs') }}</a>
                        <a href="{{ url('/') }}#a-propos" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">{{ site_setting('nav_menu_apropos', 'À propos') }}</a>
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
                <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">{{ site_setting('nav_menu_accueil', 'Accueil') }}</a>
                <a href="{{ route('books.public.index') }}" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">{{ site_setting('nav_menu_bibliotheque', 'Bibliothèque') }}</a>
                <a href="{{ route('authors.index') }}" class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">{{ site_setting('nav_menu_auteurs', 'Auteurs') }}</a>
                <a href="{{ url('/') }}#a-propos" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">{{ site_setting('nav_menu_apropos', 'À propos') }}</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-emerald-600 text-white block px-3 py-2 rounded-md text-base font-medium">{{ site_setting('nav_button_dashboard', 'Dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">{{ site_setting('nav_button_connexion', 'Connexion') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-emerald-600 text-white block px-3 py-2 rounded-md text-base font-medium">{{ site_setting('nav_button_inscription', 'S\'inscrire') }}</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section for Authors -->
    <section class="bg-gradient-to-br from-emerald-600 to-emerald-800 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-4">
                    Nos Auteurs Talentueux
                </h1>
                <p class="text-lg md:text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                    Découvrez les créateurs qui donnent vie à notre bibliothèque numérique
                </p>

                <!-- Search and Filters -->
                <div class="max-w-2xl mx-auto">
                    <form method="GET" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1 relative">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Rechercher un auteur..."
                                   class="w-full pl-12 pr-4 py-3 border-0 rounded-lg focus:ring-2 focus:ring-emerald-300 focus:outline-none shadow-sm">
                        </div>
                        <div class="flex gap-2">
                            <select name="sort" class="px-4 py-3 border-0 rounded-lg focus:ring-2 focus:ring-emerald-300 focus:outline-none shadow-sm bg-white">
                                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Plus populaires</option>
                                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Par nom</option>
                                <option value="books" {{ request('sort') === 'books' ? 'selected' : '' }}>Plus de livres</option>
                            </select>
                            <button type="submit" class="px-6 py-3 bg-white text-emerald-600 rounded-lg font-semibold hover:bg-gray-100 transition-colors shadow-sm">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Authors Grid Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($authors->count() > 0)
                <!-- Authors Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 authors-grid">
                    @foreach($authors as $author)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 text-center group">
                        <!-- Author Avatar -->
                        <div class="mb-6">
                            <img src="{{ $author->profile_photo_url }}"
                                 alt="{{ $author->name }}"
                                 class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-emerald-100 group-hover:border-emerald-200 transition-colors">
                        </div>

                        <!-- Author Info -->
                        <h3 class="text-lg font-bold text-gray-900 mb-2 font-heading">{{ $author->name }}</h3>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2 min-h-[2.5rem]">{{ $author->author_bio ?? 'Auteur sur ' . site_name() }}</p>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-emerald-600 mb-1">{{ $author->approved_books_count }}</div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide">Livre{{ $author->approved_books_count > 1 ? 's' : '' }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-emerald-600 mb-1">{{ $author->total_views ? number_format($author->total_views) : '0' }}</div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide">Vues</div>
                            </div>
                        </div>

                        <!-- View Profile Button -->
                        <a href="{{ route('authors.show', $author) }}"
                           class="inline-flex items-center justify-center w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors group-hover:shadow-md">
                            Voir le profil
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $authors->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-3xl text-emerald-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Aucun auteur trouvé</h3>
                    @if(request('search'))
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            Aucun auteur ne correspond à votre recherche "<strong>{{ request('search') }}</strong>".
                            Essayez avec d'autres mots-clés.
                        </p>
                        <a href="{{ route('authors.index') }}"
                           class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            <i class="fas fa-users mr-2"></i>
                            Voir tous les auteurs
                        </a>
                    @else
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            Il n'y a pas encore d'auteurs avec des livres publiés sur notre plateforme.
                        </p>
                        <a href="{{ route('books.public.index') }}"
                           class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            <i class="fas fa-book-open mr-2"></i>
                            Explorer la bibliothèque
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Footer (same as home page) -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo and Description -->
                <div class="md:col-span-2">
                    <div class="flex items-center mb-4">
                        @if(site_logo())
                            <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-8 w-auto">
                        @else
                            <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book-open text-white"></i>
                            </div>
                        @endif
                        <span class="ml-3 text-lg font-bold">{{ site_name() }}</span>
                    </div>
                    <p class="text-gray-400 mb-4 max-w-md">
                        {{ site_setting('site_description', 'Votre Bibliothèque Numérique Moderne') }}
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Navigation</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-gray-400 hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="{{ route('books.public.index') }}" class="text-gray-400 hover:text-white transition-colors">Bibliothèque</a></li>
                        <li><a href="{{ route('authors.index') }}" class="text-gray-400 hover:text-white transition-colors">Auteurs</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2">
                        @if(site_setting('contact_email'))
                            <li class="text-gray-400">{{ site_setting('contact_email') }}</li>
                        @endif
                        @if(site_setting('contact_phone'))
                            <li class="text-gray-400">{{ site_setting('contact_phone') }}</li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; {{ date('Y') }} {{ site_name() }}. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
