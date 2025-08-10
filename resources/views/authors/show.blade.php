<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $author->name }} - Auteur - {{ site_name() }}</title>
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

    <!-- Author Hero Section -->
    <section class="bg-gradient-to-br from-emerald-600 to-emerald-800 py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                <!-- Author Avatar -->
                <div class="flex-shrink-0">
                    <img src="{{ $author->profile_photo_url }}"
                         alt="{{ $author->name }}"
                         class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                </div>

                <!-- Author Info -->
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-4">{{ $author->name }}</h1>
                    <p class="text-lg text-white/90 mb-6 max-w-2xl">{{ $author->author_bio ?? 'Auteur sur ' . site_name() }}</p>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white mb-1">{{ $stats['total_books'] }}</div>
                            <div class="text-white/70 text-sm uppercase tracking-wide">Livre{{ $stats['total_books'] > 1 ? 's' : '' }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white mb-1">{{ number_format($stats['total_downloads']) }}</div>
                            <div class="text-white/70 text-sm uppercase tracking-wide">Téléchargements</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white mb-1">{{ number_format($stats['total_views']) }}</div>
                            <div class="text-white/70 text-sm uppercase tracking-wide">Vues</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white mb-1">{{ $stats['member_since']->format('Y') }}</div>
                            <div class="text-white/70 text-sm uppercase tracking-wide">Membre depuis</div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <a href="{{ route('authors.index') }}"
                       class="inline-flex items-center bg-white text-emerald-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Tous les auteurs
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Sections -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Popular Books Section -->
            @if($popularBooks->count() > 0)
            <section class="mb-16">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">Livres Populaires</h2>
                    <p class="text-lg text-gray-600">Les œuvres les plus appréciées de {{ $author->name }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($popularBooks as $book)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                        <div class="aspect-w-3 aspect-h-4 bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center h-64">
                            @if($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="text-white text-center p-6">
                                    <i class="fas fa-book text-5xl mb-4"></i>
                                    <p class="font-medium">{{ Str::limit($book->title, 40) }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-gray-900 mb-3 line-clamp-2 text-lg">{{ $book->title }}</h3>
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span class="flex items-center"><i class="fas fa-eye mr-2 text-emerald-500"></i>{{ number_format($book->views) }} vues</span>
                                <span class="flex items-center"><i class="fas fa-download mr-2 text-emerald-500"></i>{{ number_format($book->downloads) }}</span>
                            </div>
                            <a href="{{ route('books.public.show', $book) }}"
                               class="inline-flex items-center justify-center w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors group-hover:shadow-md">
                                Voir le livre
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- All Books Section -->
            <section>
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-heading font-bold text-gray-900 mb-4">
                        Tous les Livres
                        <span class="text-emerald-600">({{ $books->total() }})</span>
                    </h2>
                    <p class="text-lg text-gray-600">Découvrez l'ensemble des œuvres de {{ $author->name }}</p>
                </div>

                @if($books->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 books-grid-container">
                        @foreach($books as $book)
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group book-card">
                            <div class="aspect-w-3 aspect-h-4 bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center h-48">
                                @if($book->cover_image)
                                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="text-white text-center p-4">
                                        <i class="fas fa-book text-4xl mb-3"></i>
                                        <p class="text-sm font-medium">{{ Str::limit($book->title, 30) }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $book->title }}</h3>
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($book->description, 80) }}</p>
                                <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                    <span class="flex items-center"><i class="fas fa-eye mr-1 text-emerald-500"></i>{{ number_format($book->views) }}</span>
                                    <span class="flex items-center"><i class="fas fa-download mr-1 text-emerald-500"></i>{{ number_format($book->downloads) }}</span>
                                </div>
                                <a href="{{ route('books.public.show', $book) }}"
                                   class="inline-flex items-center justify-center w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm group-hover:shadow-md">
                                    Découvrir
                                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center">
                        {{ $books->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-book-open text-3xl text-emerald-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Aucun livre disponible</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            {{ $author->name }} n'a pas encore publié de livres sur notre plateforme.
                        </p>
                        <a href="{{ route('authors.index') }}"
                           class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            <i class="fas fa-users mr-2"></i>
                            Découvrir d'autres auteurs
                        </a>
                    </div>
                @endif
            </section>
        </div>
    </div>

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
