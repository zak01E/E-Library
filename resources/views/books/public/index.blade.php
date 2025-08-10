<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque - {{ site_name() }}</title>
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
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Accueil</a>
                        <a href="{{ route('books.public.index') }}" class="text-gray-900 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Bibliothèque</a>
                        <a href="#auteurs" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Auteurs</a>
                        <a href="#a-propos" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">À propos</a>
                    </div>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-emerald-600 px-3 py-2 text-sm font-medium transition-colors">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Inscription
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div x-show="mobileMenuOpen" x-transition class="md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-emerald-600 block px-3 py-2 text-sm font-medium">Accueil</a>
                    <a href="{{ route('books.public.index') }}" class="text-gray-900 hover:text-emerald-600 block px-3 py-2 text-sm font-medium">Bibliothèque</a>
                    <a href="#auteurs" class="text-gray-500 hover:text-emerald-600 block px-3 py-2 text-sm font-medium">Auteurs</a>
                    <a href="#a-propos" class="text-gray-500 hover:text-emerald-600 block px-3 py-2 text-sm font-medium">À propos</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-emerald-600 text-white block px-3 py-2 text-sm font-medium rounded-lg mx-3 mt-4">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-emerald-600 block px-3 py-2 text-sm font-medium">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-emerald-600 text-white block px-3 py-2 text-sm font-medium rounded-lg mx-3 mt-2">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section Compact (same as home page) -->
    <section class="bg-gradient-to-br from-emerald-600 to-emerald-800 py-16">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-2xl md:text-3xl font-heading font-bold text-white mb-3">
                    Découvrez Notre<br>
                    <span class="text-emerald-200">Bibliothèque</span>
                </h1>
                <p class="text-emerald-100 mb-6 text-base leading-relaxed">
                    Explorez notre collection de {{ $books->total() }} livres numériques gratuits et trouvez votre prochaine lecture
                </p>

                <!-- Search Bar -->
                <div class="max-w-md mx-auto mb-6">
                    <form method="GET" action="{{ route('books.public.index') }}" id="searchForm">
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Rechercher un livre..."
                                   class="w-full px-4 py-3 pr-12 rounded-xl text-base border-0 focus:ring-4 focus:ring-white/20 shadow-lg">
                            <button type="submit" class="absolute right-2 top-2 bg-emerald-600 hover:bg-emerald-700 text-white p-2 rounded-lg transition-colors">
                                <i class="fas fa-search text-sm"></i>
                            </button>
                        </div>
                        <!-- Hidden inputs to preserve filters -->
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <input type="hidden" name="language" value="{{ request('language') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    </form>
                </div>

                <!-- Quick Stats -->
                <div class="flex justify-center space-x-6 text-emerald-100">
                    <div class="text-center">
                        <div class="text-lg font-bold">{{ $books->total() }}</div>
                        <div class="text-xs opacity-80">Livres</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-bold">{{ \App\Models\Book::sum('downloads') }}</div>
                        <div class="text-xs opacity-80">Téléchargements</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-bold">{{ \App\Models\User::count() }}</div>
                        <div class="text-xs opacity-80">Lecteurs</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="py-6 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-book-filters
                :action="route('books.public.index')"
                :categories="$categories"
                :languages="$languages"
                :authors="collect()"
                :show-authors="false"
            />
        </div>
    </section>

    <!-- Books Grid Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-heading font-bold text-gray-900 mb-4">
                    Livres Populaires
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Découvrez les livres les plus appréciés par notre communauté de lecteurs
                </p>
            </div>

            <!-- Books Grid -->
            <div class="books-grid-container">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($books as $book)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 group h-96 flex flex-col">
                        <div class="relative h-56 flex-shrink-0">
                            @if($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}"
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

                            <!-- Stats Badge -->
                            <div class="absolute top-2 right-2 bg-emerald-600 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-download mr-1"></i>{{ number_format($book->downloads) }}
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
                                    <span>{{ Str::limit($book->uploader->name, 12) }}</span>
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
                    <div class="col-span-full text-center py-12">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-book text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun livre trouvé</h3>
                        <p class="text-gray-500">Essayez de modifier vos critères de recherche</p>
                    </div>
                @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($books->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $books->links() }}
                </div>
            @endif
        </div>
    </section>

    <!-- Footer Compact (same as home page) -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center mb-4">
                        @if(site_logo())
                            <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-8 w-auto">
                        @else
                            <div class="w-8 h-8 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book-open text-white text-sm"></i>
                            </div>
                        @endif
                        <span class="ml-2 text-lg font-heading font-bold">{{ site_name() }}</span>
                    </div>
                    <p class="text-gray-300 mb-4 text-sm max-w-xs">
                        {{ site_setting('footer_description', 'Votre bibliothèque numérique moderne pour découvrir et partager des livres.') }}
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-emerald-600 transition-colors">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-emerald-600 transition-colors">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-emerald-600 transition-colors">
                            <i class="fab fa-linkedin-in text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-base font-semibold mb-4">Liens Rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Accueil</a></li>
                        <li><a href="{{ route('books.public.index') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Bibliothèque</a></li>
                        <li><a href="{{ route('books.search') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Recherche</a></li>
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

    <!-- Scripts (same as home page) -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Smooth scrolling for anchor links
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

        // Add scroll effect to navigation
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-lg');
            } else {
                nav.classList.remove('shadow-lg');
            }
        });

        // Add hover effects to book cards
        document.querySelectorAll('.group').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add loading animation for images
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });
        });

        // Search with delay to avoid too many requests
        let searchTimeout;
        const searchInput = document.querySelector('input[name="search"]');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('searchForm').submit();
                }, 500); // 500ms delay
            });
        }

        // Book filters are handled by the external book-filters.js script
    </script>
</body>
</html>
