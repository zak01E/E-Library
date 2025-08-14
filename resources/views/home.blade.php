<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library Côte d'Ivoire - La Bibliothèque Numérique de l'Excellence Éducative</title>
    <meta name="description" content="Accédez à des milliers de livres et ressources éducatives adaptés au système ivoirien. Gratuit pour tous les étudiants.">
    <link rel="icon" type="image/x-icon" href="{{ site_favicon() }}">
    
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
                                    <span class="text-xs text-gray-500 block ml-6">{{ number_format($stats['total_books'] ?? 0) }}+ livres</span>
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
                                    <span class="text-xs text-gray-500 block ml-6">{{ $stats['total_authors'] ?? 0 }}+ mentors</span>
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
                        <a href="{{ route('authors.index') }}" class="text-gray-700 hover:text-amber-600 px-4 py-2 font-medium transition flex items-center group">
                            <i class="fas fa-pen-fancy mr-2 text-sm text-amber-500"></i>
                            <span class="group-hover:text-amber-600">Auteurs</span>
                        </a>
                    </div>

                    <!-- Actions droite -->
                    <div class="hidden md:flex items-center space-x-3">
                        <!-- Recherche rapide -->
                        <button onclick="document.getElementById('search-modal').classList.remove('hidden')" class="text-gray-500 hover:text-emerald-600 p-2 transition group">
                            <div class="relative">
                                <i class="fas fa-search text-lg"></i>
                                <span class="absolute -top-1 -right-1 h-2 w-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            </div>
                        </button>

                        @auth
                            <!-- Notifications -->
                            <div class="relative">
                                <button class="text-gray-500 hover:text-amber-600 p-2 transition relative">
                                    <i class="fas fa-bell text-lg"></i>
                                    <span class="absolute top-0 right-0 h-2 w-2 bg-orange-500 rounded-full animate-ping"></span>
                                    <span class="absolute top-0 right-0 h-2 w-2 bg-orange-500 rounded-full"></span>
                                </button>
                            </div>

                            <!-- User Menu -->
                            <div class="relative group">
                                <button class="flex items-center space-x-2 text-gray-700 hover:text-emerald-600 transition">
                                    <img src="{{ Auth::user()->profile_photo_url }}" 
                                         alt="{{ Auth::user()->name }}" 
                                         class="w-9 h-9 rounded-full object-cover ring-2 ring-emerald-400 shadow-md hover:ring-emerald-500 transition-all">
                                    <span class="font-medium">{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                <div class="absolute top-full right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border border-emerald-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-t-xl px-4 py-2 border-b border-emerald-100">
                                        <span class="text-xs font-semibold text-emerald-700">MON COMPTE</span>
                                    </div>
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                        <i class="fas fa-tachometer-alt mr-2 text-emerald-500"></i>Tableau de bord
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition">
                                        <i class="fas fa-user-cog mr-2 text-teal-500"></i>Mon profil
                                    </a>
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="block w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition rounded-b-xl">
                                            <i class="fas fa-sign-out-alt mr-2 text-red-500"></i>Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Dropdown Connexion avec choix -->
                            <div class="relative group">
                                <button class="text-gray-700 hover:text-emerald-600 px-4 py-2 font-medium transition flex items-center">
                                    Connexion
                                    <i class="fas fa-chevron-down ml-1 text-xs text-gray-400"></i>
                                </button>
                                <div class="absolute top-full right-0 mt-1 w-64 bg-white rounded-xl shadow-2xl border border-emerald-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-t-xl px-4 py-2 border-b border-emerald-100">
                                        <span class="text-xs font-semibold text-emerald-700">CHOISIR VOTRE ESPACE</span>
                                    </div>
                                    <a href="{{ route('login') }}" 
                                       class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition group">
                                        <i class="fas fa-user mr-2 w-4 text-emerald-500"></i>Espace Lecteur
                                        <span class="text-xs text-gray-500 block ml-6">Accéder à votre bibliothèque</span>
                                    </a>
                                    <a href="{{ route('author.login') }}" 
                                       class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition rounded-b-xl">
                                        <i class="fas fa-pen-fancy mr-2 w-4 text-amber-500"></i>Espace Auteur
                                        <span class="text-xs text-gray-500 block ml-6">Publier et gérer vos œuvres</span>
                                    </a>
                                </div>
                            </div>
                            <!-- Dropdown Inscription avec choix -->
                            <div class="relative group">
                                <button class="relative overflow-hidden bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-5 py-2 rounded-full hover:shadow-lg transition font-medium flex items-center">
                                    <span class="relative z-10">Inscription</span>
                                    <i class="fas fa-chevron-down ml-1 text-xs text-white/80 relative z-10"></i>
                                </button>
                                <div class="absolute top-full right-0 mt-1 w-64 bg-white rounded-xl shadow-2xl border border-emerald-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-t-xl px-4 py-2 border-b border-emerald-100">
                                        <span class="text-xs font-semibold text-emerald-700">CRÉER VOTRE COMPTE</span>
                                    </div>
                                    <a href="{{ route('register') }}" 
                                       class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition group">
                                        <i class="fas fa-user-plus mr-2 w-4 text-emerald-500"></i>Compte Lecteur
                                        <span class="text-xs text-gray-500 block ml-6">Accédez à des milliers de livres</span>
                                    </a>
                                    <a href="{{ route('author.register') }}" 
                                       class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition rounded-b-xl">
                                        <i class="fas fa-pen-nib mr-2 w-4 text-amber-500"></i>Compte Auteur
                                        <span class="text-xs text-gray-500 block ml-6">Publiez et partagez vos œuvres</span>
                                    </a>
                                </div>
                            </div>
                        @endauth
                    </div>

                    <!-- Menu Mobile -->
                    <div class="md:hidden flex items-center space-x-2">
                        <button onclick="document.getElementById('search-modal').classList.remove('hidden')" class="text-gray-600 p-2">
                            <i class="fas fa-search"></i>
                        </button>
                        <button id="mobile-menu-btn" class="text-gray-600 hover:text-gray-900 p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
                <div class="px-4 py-3 space-y-1">
                    <a href="{{ route('books.public.index') }}" class="block text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 px-3 py-2 rounded-lg transition">
                        <i class="fas fa-book mr-2"></i>Bibliothèque
                    </a>
                    <a href="{{ route('news.index') }}" class="block text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 px-3 py-2 rounded-lg transition">
                        <i class="fas fa-newspaper mr-2"></i>Actualités
                    </a>
                    <a href="{{ route('calendar.index') }}" class="block text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 px-3 py-2 rounded-lg transition">
                        <i class="fas fa-calendar mr-2"></i>Calendrier
                    </a>
                    <a href="{{ route('mentorship.index') }}" class="block text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 px-3 py-2 rounded-lg transition">
                        <i class="fas fa-user-graduate mr-2"></i>Mentorat
                    </a>
                    <div class="border-t border-gray-100 my-2"></div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="block text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 px-3 py-2 rounded-lg transition">
                            <i class="fas fa-tachometer-alt mr-2"></i>Mon Tableau de bord
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="block w-full text-left text-gray-700 hover:bg-red-50 hover:text-red-600 px-3 py-2 rounded-lg transition">
                                <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                            </button>
                        </form>
                    @else
                        <div class="border-t border-gray-100 my-2"></div>
                        <p class="text-xs text-gray-500 px-3 py-1">CONNEXION</p>
                        <a href="{{ route('login') }}" class="block text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 px-3 py-2 rounded-lg transition">
                            <i class="fas fa-user mr-2"></i>Espace Lecteur
                        </a>
                        <a href="{{ route('author.login') }}" class="block text-gray-700 hover:bg-amber-50 hover:text-amber-600 px-3 py-2 rounded-lg transition">
                            <i class="fas fa-pen-fancy mr-2"></i>Espace Auteur
                        </a>
                        <div class="border-t border-gray-100 my-2"></div>
                        <p class="text-xs text-gray-500 px-3 py-1">INSCRIPTION</p>
                        <a href="{{ route('register') }}" class="block text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 px-3 py-2 rounded-lg transition">
                            <i class="fas fa-user-plus mr-2"></i>Compte Lecteur
                        </a>
                        <a href="{{ route('author.register') }}" class="block text-gray-700 hover:bg-amber-50 hover:text-amber-600 px-3 py-2 rounded-lg transition">
                            <i class="fas fa-pen-nib mr-2"></i>Compte Auteur
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- Modal de recherche -->
    <div id="search-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-start justify-center pt-20">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl mx-4">
            <form action="{{ route('books.search') }}" method="GET" class="p-6">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-search text-gray-400 text-xl"></i>
                    <input type="text" name="q" placeholder="Rechercher des livres, auteurs, matières..." 
                           class="flex-1 text-lg outline-none" autofocus>
                    <button type="button" onclick="document.getElementById('search-modal').classList.add('hidden')" 
                            class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="text-xs text-gray-500">Suggestions:</span>
                    <a href="{{ route('books.search', ['q' => 'BAC 2024']) }}" class="text-xs bg-gray-100 px-3 py-1 rounded-full hover:bg-gray-200">BAC 2024</a>
                    <a href="{{ route('books.search', ['q' => 'BEPC']) }}" class="text-xs bg-gray-100 px-3 py-1 rounded-full hover:bg-gray-200">BEPC</a>
                    <a href="{{ route('books.search', ['q' => 'Mathématiques']) }}" class="text-xs bg-gray-100 px-3 py-1 rounded-full hover:bg-gray-200">Mathématiques</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Hero Section Minimaliste avec Recherche Prominente -->
    <section class="bg-gradient-to-br from-indigo-50 via-white to-blue-50 py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <!-- Proposition de Valeur Claire -->
                <h1 class="text-3xl md:text-5xl font-bold mb-4 text-gray-900">
                    La Bibliothèque Numérique<br>
                    <span class="text-emerald-600">de l'Excellence Ivoirienne</span>
                </h1>
                
                <p class="text-lg md:text-xl mb-6 text-gray-600 max-w-3xl mx-auto">
                    Accédez gratuitement à des milliers de livres et ressources adaptés au programme éducatif ivoirien
                </p>

                <!-- Social Proof -->
                <div class="flex justify-center items-center space-x-4 mb-6 text-sm">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="ml-1 font-medium text-gray-700">{{ $stats['average_rating'] ?? '4.6' }}/5</span>
                    </div>
                    <span class="text-gray-400">•</span>
                    <span class="font-medium text-gray-700">{{ number_format($stats['total_users'] ?? 0) }}+ étudiants</span>
                    <span class="text-gray-400">•</span>
                    <span class="font-medium text-gray-700">{{ number_format($stats['total_books'] ?? 0) }}+ livres</span>
                </div>

                <!-- Barre de Recherche Géante -->
                <div class="max-w-2xl mx-auto">
                    <form action="{{ route('books.search') }}" method="GET" class="relative">
                        <input type="text" 
                               name="q" 
                               placeholder="Recherchez par titre, auteur, matière..."
                               class="w-full px-5 py-3 pr-12 text-gray-900 rounded-full border-2 border-emerald-200 shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white/90 backdrop-blur"
                               autofocus>
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white p-2.5 rounded-full hover:shadow-lg transition group">
                            <svg class="w-5 h-5 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
                    
                    <!-- Suggestions de recherche -->
                    <div class="mt-3 flex flex-wrap justify-center gap-2">
                        <span class="text-xs text-gray-500">Populaires:</span>
                        <a href="{{ route('books.search', ['q' => 'Mathématiques']) }}" class="text-xs bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full hover:bg-gray-200 transition">Mathématiques</a>
                        <a href="{{ route('books.search', ['q' => 'BAC']) }}" class="text-xs bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full hover:bg-gray-200 transition">BAC 2024</a>
                        <a href="{{ route('books.search', ['q' => 'BEPC']) }}" class="text-xs bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full hover:bg-gray-200 transition">BEPC</a>
                        <a href="{{ route('books.search', ['q' => 'Histoire']) }}" class="text-xs bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full hover:bg-gray-200 transition">Histoire CI</a>
                    </div>
                </div>

                <!-- CTA Secondaires -->
                <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="#catalogue" class="bg-white text-emerald-600 px-6 py-2.5 rounded-full font-medium hover:bg-gray-50 transition border border-emerald-200">
                        <i class="fas fa-book-open mr-2 text-sm"></i>Explorer le Catalogue
                    </a>
                    @guest
                    <a href="{{ route('register') }}" class="bg-emerald-600 text-white px-6 py-2.5 rounded-full font-medium hover:bg-emerald-700 transition shadow-md">
                        <i class="fas fa-user-plus mr-2 text-sm"></i>Inscription Gratuite
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Catégories Principales (Visuelles et Simples) -->
    <section id="catalogue" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
                    Explorez par Niveau Scolaire
                </h2>
                <p class="text-lg text-gray-600">
                    Ressources adaptées à chaque étape du parcours éducatif ivoirien
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                $niveaux = [
                    ['name' => 'Primaire', 'value' => 'primaire', 'icon' => 'fa-child', 'color' => 'bg-gradient-to-br from-yellow-400 to-amber-500', 'count' => number_format($levelStats['primaire'] ?? 0)],
                    ['name' => 'Collège', 'value' => 'college', 'icon' => 'fa-school', 'color' => 'bg-gradient-to-br from-blue-400 to-cyan-500', 'count' => number_format($levelStats['college'] ?? 0)],
                    ['name' => 'Lycée', 'value' => 'lycee', 'icon' => 'fa-graduation-cap', 'color' => 'bg-gradient-to-br from-emerald-400 to-teal-500', 'count' => number_format($levelStats['lycee'] ?? 0)],
                    ['name' => 'Supérieur', 'value' => 'superieur', 'icon' => 'fa-university', 'color' => 'bg-gradient-to-br from-slate-500 to-gray-600', 'count' => number_format($levelStats['superieur'] ?? 0)],
                    ['name' => 'Professionnel', 'value' => 'professionnel', 'icon' => 'fa-briefcase', 'color' => 'bg-gradient-to-br from-amber-400 to-orange-500', 'count' => number_format($levelStats['professionnel'] ?? 0)],
                    ['name' => 'Examens', 'value' => 'Examens', 'icon' => 'fa-clipboard-check', 'color' => 'bg-gradient-to-br from-orange-400 to-red-500', 'count' => number_format($levelStats['examens'] ?? 0), 'isCategory' => true],
                ];
                @endphp

                @foreach($niveaux as $niveau)
                <a href="{{ route('books.search', isset($niveau['isCategory']) ? ['category' => $niveau['value']] : ['level' => $niveau['value']]) }}" 
                   class="bg-white rounded-xl p-6 text-center hover:shadow-xl transition-all card-hover group">
                    <div class="{{ $niveau['color'] }} w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition shadow-lg">
                        <i class="fas {{ $niveau['icon'] }} text-white text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">{{ $niveau['name'] }}</h3>
                    <p class="text-sm text-gray-500">
                        @if($niveau['count'] > 0)
                            {{ $niveau['count'] }}+ livres
                        @else
                            Aucun livre
                        @endif
                    </p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Livres Populaires (Une seule section) -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">
                    Les Plus Consultés Cette Semaine
                </h2>
                <a href="{{ route('books.public.index') }}" class="text-emerald-600 hover:text-teal-700 font-semibold transition">
                    Voir tout <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
                @php
                // Utiliser les vraies données depuis le contrôleur
                $popularBooks = isset($featuredBooks['popular']) ? $featuredBooks['popular']->take(8) : collect([]);
                @endphp

                @forelse($popularBooks as $book)
                <div class="group cursor-pointer">
                    <a href="{{ route('books.public.show', $book->id) }}" class="block">
                        <div class="bg-gray-200 rounded-lg aspect-[3/4] mb-3 overflow-hidden group-hover:shadow-lg transition">
                            @if(isset($book->cover_image) && $book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                     alt="{{ $book->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition"
                                     loading="lazy">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                    <i class="fas fa-book text-white text-3xl opacity-50"></i>
                                </div>
                            @endif
                        </div>
                        <h3 class="font-semibold text-sm text-gray-900 line-clamp-2 group-hover:text-emerald-600 transition">
                            {{ $book->title }}
                        </h3>
                        <p class="text-xs text-gray-500 truncate">
                            {{ $book->author ?? ($book->uploader ? $book->uploader->name : 'Auteur inconnu') }}
                        </p>
                        <div class="flex items-center mt-1">
                            <div class="flex text-yellow-400">
                                @php
                                    $rating = $book->rating ?? ($book->views > 1000 ? 4.5 : 4.0);
                                @endphp
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < floor($rating))
                                        <i class="fas fa-star text-xs"></i>
                                    @else
                                        <i class="far fa-star text-xs"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 ml-1">{{ number_format($rating, 1) }}</span>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">Aucun livre populaire cette semaine</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Section "Plus qu'une bibliothèque" (Discrète mais visible) -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Plus qu'une simple bibliothèque
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Découvrez l'écosystème complet pour votre réussite éducative
                </p>
            </div>

            <!-- Features Grid - 4 features uniformes -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Actualités -->
                <a href="{{ route('news.index') }}" class="group">
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-6 text-center hover:shadow-lg transition-all card-hover h-full">
                        <div class="bg-orange-500 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                            <i class="fas fa-newspaper text-white text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Actualités Éducatives</h3>
                        <p class="text-sm text-gray-600">Restez informé des dernières nouvelles du système éducatif</p>
                        <span class="inline-block mt-3 text-orange-600 font-medium text-sm">
                            Découvrir <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </span>
                    </div>
                </a>

                <!-- Calendrier -->
                <a href="{{ route('calendar.index') }}" class="group">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 text-center hover:shadow-lg transition-all card-hover h-full">
                        <div class="bg-blue-500 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                            <i class="fas fa-calendar-alt text-white text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Calendrier Scolaire</h3>
                        <p class="text-sm text-gray-600">Toutes les dates importantes de l'année académique</p>
                        <span class="inline-block mt-3 text-blue-600 font-medium text-sm">
                            Consulter <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </span>
                    </div>
                </a>

                <!-- Mentorat -->
                <a href="{{ route('mentorship.index') }}" class="group">
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 text-center hover:shadow-lg transition-all card-hover h-full">
                        <div class="bg-teal-500 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                            <i class="fas fa-hands-helping text-white text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Programme Mentorat</h3>
                        <p class="text-sm text-gray-600">Connectez-vous avec des mentors expérimentés</p>
                        <span class="inline-block mt-3 text-teal-600 font-medium text-sm">
                            Explorer <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </span>
                    </div>
                </a>

                <!-- NOUVEAU : MAMA ÉCOLE -->
                <a href="{{ route('mama-ecole.index') }}" class="group">
                    <div class="bg-gradient-to-br from-pink-50 to-red-100 rounded-xl p-6 text-center hover:shadow-lg transition-all card-hover h-full relative">
                        <!-- Badge NOUVEAU -->
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full animate-pulse">
                            NEW
                        </span>
                        <div class="bg-red-500 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                            <i class="fas fa-phone-volume text-white text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">MAMA ÉCOLE</h3>
                        <p class="text-sm text-gray-600">Parents illettrés inclus par messages vocaux</p>
                        <span class="inline-block mt-3 text-red-600 font-medium text-sm">
                            Découvrir <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </span>
                    </div>
                </a>
            </div>

            <!-- Stats Bar (Social Proof) -->
            <div class="bg-gray-50 rounded-xl p-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-center">
                    <div>
                        <div class="text-xl md:text-2xl font-bold text-emerald-600">
                            @if($stats['total_books'] >= 1000000)
                                {{ round($stats['total_books'] / 1000000, 1) }}M+
                            @elseif($stats['total_books'] >= 1000)
                                {{ round($stats['total_books'] / 1000, 1) }}K+
                            @else
                                {{ $stats['total_books'] }}+
                            @endif
                        </div>
                        <div class="text-xs text-gray-600">Livres disponibles</div>
                    </div>
                    <div>
                        <div class="text-xl md:text-2xl font-bold text-orange-600">
                            @if($stats['new_books_this_month'] >= 1000)
                                {{ round($stats['new_books_this_month'] / 1000, 1) }}K+
                            @else
                                {{ $stats['new_books_this_month'] ?? 0 }}+
                            @endif
                        </div>
                        <div class="text-xs text-gray-600">Nouveaux ce mois</div>
                    </div>
                    <div>
                        <div class="text-xl md:text-2xl font-bold text-teal-600">
                            @if($stats['total_downloads'] >= 1000000)
                                {{ round($stats['total_downloads'] / 1000000, 1) }}M+
                            @elseif($stats['total_downloads'] >= 1000)
                                {{ round($stats['total_downloads'] / 1000, 1) }}K+
                            @else
                                {{ $stats['total_downloads'] }}+
                            @endif
                        </div>
                        <div class="text-xs text-gray-600">Téléchargements</div>
                    </div>
                    <div>
                        <div class="text-xl md:text-2xl font-bold text-green-600">
                            @if($stats['total_authors'] >= 1000000)
                                {{ round($stats['total_authors'] / 1000000, 1) }}M+
                            @elseif($stats['total_authors'] >= 1000)
                                {{ round($stats['total_authors'] / 1000, 1) }}K+
                            @else
                                {{ $stats['total_authors'] }}+
                            @endif
                        </div>
                        <div class="text-xs text-gray-600">Auteurs publiés</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Comment ça marche (Ultra Simple) -->
    <section id="comment" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
                    Comment ça marche ?
                </h2>
                <p class="text-lg text-gray-600">
                    Commencez à lire en 3 étapes simples
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="bg-emerald-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-2xl font-bold text-emerald-600">1</span>
                    </div>
                    <h3 class="font-semibold text-lg mb-1">Inscrivez-vous</h3>
                    <p class="text-gray-600 text-sm">Créez votre compte gratuit en 30 secondes</p>
                </div>

                <div class="text-center">
                    <div class="bg-emerald-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-2xl font-bold text-emerald-600">2</span>
                    </div>
                    <h3 class="font-semibold text-lg mb-1">Recherchez</h3>
                    <p class="text-gray-600 text-sm">Trouvez vos livres par niveau ou matière</p>
                </div>

                <div class="text-center">
                    <div class="bg-emerald-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-2xl font-bold text-emerald-600">3</span>
                    </div>
                    <h3 class="font-semibold text-lg mb-1">Lisez</h3>
                    <p class="text-gray-600 text-sm">Accédez instantanément à vos livres</p>
                </div>
            </div>

            <!-- CTA Final -->
            <div class="text-center mt-8">
                <a href="{{ route('register') }}" class="bg-emerald-600 text-white px-8 py-3 rounded-full font-medium hover:bg-emerald-700 transition shadow-lg inline-block">
                    Commencer Maintenant - C'est Gratuit
                </a>
                <p class="mt-3 text-xs text-gray-500">
                    Aucune carte bancaire requise • Accès illimité
                </p>
            </div>
        </div>
    </section>

    <!-- Footer Amélioré -->
    <footer class="bg-gradient-to-b from-gray-900 to-black text-gray-300">
        <!-- Newsletter Section -->
        <div class="bg-emerald-600 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h3 class="text-xl font-bold text-white mb-1">Restez informé des nouveautés</h3>
                        <p class="text-emerald-100 text-sm">Recevez les derniers livres et actualités directement dans votre boîte mail</p>
                    </div>
                    <form class="flex flex-col sm:flex-row gap-3 max-w-md">
                        <input type="email" placeholder="Votre email" 
                               class="flex-1 px-4 py-2 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white">
                        <button type="submit" class="bg-white text-emerald-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                            S'abonner
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Footer Content -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-8">
                    <!-- Logo & Description -->
                    <div class="col-span-2">
                        <div class="flex items-center mb-4">
                            @if(site_logo())
                                <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-10 w-auto">
                            @else
                                <div class="bg-gradient-to-br from-emerald-50 to-teal-100 p-2.5 rounded-lg shadow-lg">
                                    <svg class="w-8 h-8 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385V4.804z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="ml-3">
                                <span class="text-xl font-bold text-white">{{ site_name() }}</span>
                                <span class="block text-xs text-emerald-400">Excellence & Innovation</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-400 mb-4 max-w-xs">
                            La première bibliothèque numérique dédiée à l'excellence éducative en Côte d'Ivoire. 
                            Plus de {{ number_format($stats['total_books'] ?? 21000) }} ressources pour votre réussite.
                        </p>
                        <!-- Social Media -->
                        <div class="flex space-x-3">
                            <a href="#" class="bg-gray-800 hover:bg-emerald-600 p-2 rounded-lg transition">
                                <i class="fab fa-facebook-f w-5 h-5 text-center"></i>
                            </a>
                            <a href="#" class="bg-gray-800 hover:bg-emerald-600 p-2 rounded-lg transition">
                                <i class="fab fa-twitter w-5 h-5 text-center"></i>
                            </a>
                            <a href="#" class="bg-gray-800 hover:bg-emerald-600 p-2 rounded-lg transition">
                                <i class="fab fa-linkedin-in w-5 h-5 text-center"></i>
                            </a>
                            <a href="#" class="bg-gray-800 hover:bg-emerald-600 p-2 rounded-lg transition">
                                <i class="fab fa-whatsapp w-5 h-5 text-center"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Resources -->
                    <div>
                        <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Ressources</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('books.public.index') }}" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>Bibliothèque
                            </a></li>
                            <li><a href="{{ route('news.index') }}" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>Actualités
                            </a></li>
                            <li><a href="{{ route('calendar.index') }}" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>Calendrier
                            </a></li>
                            <li><a href="{{ route('mentorship.index') }}" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>Mentorat
                            </a></li>
                            <li><a href="{{ route('mama-ecole.index') }}" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>MAMA ÉCOLE
                                <span class="ml-1 bg-red-500 text-white text-xs px-1 rounded">NEW</span>
                            </a></li>
                        </ul>
                    </div>

                    <!-- Niveaux -->
                    <div>
                        <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Niveaux</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('books.search', ['level' => 'primaire']) }}" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>Primaire
                            </a></li>
                            <li><a href="{{ route('books.search', ['level' => 'college']) }}" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>Collège
                            </a></li>
                            <li><a href="{{ route('books.search', ['level' => 'lycee']) }}" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>Lycée
                            </a></li>
                            <li><a href="{{ route('books.search', ['level' => 'superieur']) }}" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>Supérieur
                            </a></li>
                            <li><a href="{{ route('books.search', ['category' => 'examens']) }}" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>Examens
                            </a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Support</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>Centre d'aide
                            </a></li>
                            <li><a href="#" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>FAQ
                            </a></li>
                            <li><a href="#" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>Contact
                            </a></li>
                            <li><a href="#" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>À propos
                            </a></li>
                            <li><a href="#" class="text-sm hover:text-emerald-400 transition flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-gray-600"></i>Politique de confidentialité
                            </a></li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Info Bar -->
                <div class="mt-8 pt-8 border-t border-gray-800">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <i class="fas fa-phone text-emerald-400"></i>
                            <span class="text-sm">+225 27 22 48 48 48</span>
                        </div>
                        <div class="flex items-center justify-center space-x-2">
                            <i class="fas fa-envelope text-emerald-400"></i>
                            <span class="text-sm">contact@elibrary.ci</span>
                        </div>
                        <div class="flex items-center justify-center space-x-2">
                            <i class="fas fa-map-marker-alt text-emerald-400"></i>
                            <span class="text-sm">Abidjan, Côte d'Ivoire</span>
                        </div>
                        <div class="flex items-center justify-center space-x-2">
                            <i class="fas fa-clock text-emerald-400"></i>
                            <span class="text-sm">24/7 Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="bg-black py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="text-xs text-gray-500">
                        &copy; 2024 E-Library Côte d'Ivoire. Tous droits réservés.
                    </div>
                    <div class="mt-2 md:mt-0 flex items-center space-x-4 text-xs">
                        <span class="text-gray-500">Propulsé par</span>
                        <div class="flex items-center space-x-2">
                            <span class="text-orange-400">🇨🇮</span>
                            <span class="text-white font-semibold">Innovation Ivoirienne</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Script minimal -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if(target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>