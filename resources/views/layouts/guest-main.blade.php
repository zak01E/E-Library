<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Library - Bibliothèque Numérique')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicon.png">
    
    <!-- Une seule police pour la performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons optimisés (chargement asynchrone) -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Critical CSS inline pour performance */
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }
    </style>
    @yield('styles')
</head>
<body class="font-sans antialiased bg-white">

    <!-- Header Moderne et Fonctionnel -->
    <header class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <!-- Barre d'info supérieure - Couleurs Côte d'Ivoire -->
        <div class="bg-gradient-to-r from-orange-500 via-white to-green-600 py-0.5">
            <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white py-1.5 px-4 text-xs">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <span class="flex items-center text-orange-300">
                            <i class="fas fa-star mr-1"></i>
                            Plateforme éducative nationale
                        </span>
                        <span class="hidden sm:flex items-center text-green-300">
                            <i class="fas fa-chart-line mr-1"></i>
                            +89% de réussite scolaire
                        </span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="#" class="hover:text-orange-300 transition hidden sm:flex items-center">
                            <i class="fas fa-headset mr-1"></i>
                            Aide 24/7
                        </a>
                        <span class="text-gray-500">•</span>
                        <a href="{{ route('mama-ecole.index') }}" class="hover:text-green-300 transition flex items-center">
                            <span class="relative flex h-2 w-2 mr-1">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                            MAMA ÉCOLE
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation principale -->
        <nav class="bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo et Nom -->
                    <div class="flex items-center">
                        <a href="/" class="flex items-center group">
                            @if(site_logo())
                                <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-10 w-auto group-hover:scale-105 transition">
                            @else
                                <div class="bg-gradient-to-br from-emerald-50 to-teal-100 p-2 rounded-lg group-hover:shadow-md transition border border-emerald-200">
                                    <svg class="w-8 h-8 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385V4.804z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="ml-3">
                                <span class="text-xl font-bold text-gray-900">{{ site_name() }}</span>
                                <span class="hidden lg:block text-xs text-gray-500">Excellence & Innovation</span>
                            </div>
                        </a>
                    </div>

                    <!-- Menu Desktop -->
                    <div class="hidden md:flex items-center space-x-1">
                        <!-- Dropdown Ressources -->
                        <div class="relative group">
                            <button class="text-gray-700 hover:text-emerald-600 px-4 py-2 font-medium transition flex items-center group">
                                <span class="bg-gradient-to-r from-emerald-500 to-teal-600 bg-clip-text text-transparent group-hover:from-emerald-600 group-hover:to-teal-700">
                                    <i class="fas fa-book mr-2 text-sm text-emerald-600"></i>
                                    Ressources
                                </span>
                                <i class="fas fa-chevron-down ml-1 text-xs text-gray-400"></i>
                            </button>
                            <div class="absolute top-full left-0 mt-1 w-56 bg-white rounded-xl shadow-2xl border border-emerald-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-t-xl px-4 py-2 border-b border-emerald-100">
                                    <span class="text-xs font-semibold text-emerald-700">CONTENUS ÉDUCATIFS</span>
                                </div>
                                <a href="{{ route('books.public.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition group">
                                    <i class="fas fa-book-open mr-2 w-4 text-emerald-500"></i>Bibliothèque numérique
                                    <span class="text-xs text-gray-500 block ml-6">50,000+ livres</span>
                                </a>
                                <a href="{{ route('news.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700 transition">
                                    <i class="fas fa-newspaper mr-2 w-4 text-orange-500"></i>Actualités éducatives
                                    <span class="text-xs text-gray-500 block ml-6">Mises à jour quotidiennes</span>
                                </a>
                                <a href="{{ route('calendar.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                                    <i class="fas fa-calendar-alt mr-2 w-4 text-blue-500"></i>Calendrier scolaire
                                    <span class="text-xs text-gray-500 block ml-6">2024-2025</span>
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <a href="{{ route('mentorship.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition rounded-b-xl">
                                    <i class="fas fa-user-graduate mr-2 w-4 text-amber-500"></i>Programme mentorat
                                    <span class="text-xs text-gray-500 block ml-6">250+ mentors</span>
                                </a>
                            </div>
                        </div>

                        <!-- Niveaux scolaires -->
                        <div class="relative group">
                            <button class="text-gray-700 hover:text-teal-600 px-4 py-2 font-medium transition flex items-center">
                                <i class="fas fa-graduation-cap mr-2 text-sm text-teal-600"></i>
                                Niveaux
                                <i class="fas fa-chevron-down ml-1 text-xs text-gray-400"></i>
                            </button>
                            <div class="absolute top-full left-0 mt-1 w-48 bg-white rounded-xl shadow-2xl border border-teal-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <a href="{{ route('books.search', ['level' => 'primaire']) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition rounded-t-xl">
                                    <i class="fas fa-child mr-2 w-4 text-yellow-500"></i>Primaire
                                </a>
                                <a href="{{ route('books.search', ['level' => 'college']) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                                    <i class="fas fa-school mr-2 w-4 text-blue-500"></i>Collège
                                </a>
                                <a href="{{ route('books.search', ['level' => 'lycee']) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                    <i class="fas fa-university mr-2 w-4 text-emerald-500"></i>Lycée
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <a href="{{ route('books.search', ['level' => 'superieur']) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-slate-50 hover:text-slate-700 transition rounded-b-xl">
                                    <i class="fas fa-user-graduate mr-2 w-4 text-slate-500"></i>Supérieur
                                </a>
                            </div>
                        </div>

                        <!-- Examens -->
                        <a href="{{ route('books.search', ['category' => 'examens']) }}" class="text-gray-700 hover:text-orange-600 px-4 py-2 font-medium transition flex items-center group">
                            <i class="fas fa-medal mr-2 text-sm text-orange-500"></i>
                            <span class="group-hover:text-orange-600">Examens</span>
                        </a>

                        <!-- Auteurs -->
                        <a href="{{ route('author.login') }}" class="text-gray-700 hover:text-amber-600 px-4 py-2 font-medium transition flex items-center group">
                            <i class="fas fa-pen-fancy mr-2 text-sm text-amber-500"></i>
                            <span class="group-hover:text-amber-600">Espace Auteur</span>
                        </a>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex items-center space-x-3">
                        <!-- Bouton de recherche mobile -->
                        <button class="md:hidden p-2 text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition">
                            <i class="fas fa-search"></i>
                        </button>

                        @guest
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-emerald-600 font-medium transition">
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-5 py-2 rounded-full hover:from-emerald-600 hover:to-teal-700 transition font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                                S'inscrire
                            </a>
                        @else
                            <div class="relative group">
                                <button class="flex items-center space-x-2 text-gray-700 hover:text-emerald-600 transition">
                                    <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition rounded-t-xl">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Tableau de bord
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                                        <i class="fas fa-user-cog mr-2"></i>Mon profil
                                    </a>
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition rounded-b-xl">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endguest

                        <!-- Menu mobile -->
                        <button class="md:hidden p-2 text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Contenu Principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer moderne -->
    <footer class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- À propos -->
                <div>
                    <h3 class="text-lg font-bold mb-4 text-emerald-400">À propos</h3>
                    <p class="text-gray-400 text-sm">
                        {{ site_name() }} - La plateforme éducative de référence en Côte d'Ivoire pour l'excellence scolaire.
                    </p>
                    <div class="mt-4 flex space-x-3">
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Liens rapides -->
                <div>
                    <h3 class="text-lg font-bold mb-4 text-emerald-400">Liens rapides</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('books.public.index') }}" class="text-gray-400 hover:text-emerald-400 transition">Bibliothèque</a></li>
                        <li><a href="{{ route('news.index') }}" class="text-gray-400 hover:text-emerald-400 transition">Actualités</a></li>
                        <li><a href="{{ route('calendar.index') }}" class="text-gray-400 hover:text-emerald-400 transition">Calendrier</a></li>
                        <li><a href="{{ route('mentorship.index') }}" class="text-gray-400 hover:text-emerald-400 transition">Mentorat</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-lg font-bold mb-4 text-emerald-400">Support</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-emerald-400 transition">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-emerald-400 transition">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-emerald-400 transition">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-emerald-400 transition">Conditions d'utilisation</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="text-lg font-bold mb-4 text-emerald-400">Newsletter</h3>
                    <p class="text-gray-400 text-sm mb-4">
                        Restez informé de nos dernières actualités
                    </p>
                    <form class="flex">
                        <input type="email" placeholder="Votre email" class="flex-1 px-4 py-2 bg-slate-700 text-white rounded-l-lg focus:outline-none focus:bg-slate-600">
                        <button type="submit" class="bg-emerald-500 text-white px-4 py-2 rounded-r-lg hover:bg-emerald-600 transition">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-slate-700 mt-8 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    © 2025 {{ site_name() }}. Tous droits réservés. | 
                    <span class="text-orange-400">🇨🇮</span> Fait avec <span class="text-red-500">❤️</span> en Côte d'Ivoire
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @yield('scripts')
</body>
</html>