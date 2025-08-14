<!-- Alpine.js pour les dropdowns -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
    /* Cache les dropdowns par défaut */
    [x-cloak] { display: none !important; }
</style>

<!-- Top bar annonce -->
<div class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white py-2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center text-sm">
            <div class="flex items-center space-x-4">
                <span class="hidden sm:inline-flex items-center">
                    <i class="fas fa-phone mr-2"></i>+225 27 22 55 66 77
                </span>
                <span class="hidden md:inline-flex items-center">
                    <i class="fas fa-envelope mr-2"></i>contact@elibrary.ci
                </span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/mama-ecole" class="inline-flex items-center bg-white/20 px-3 py-1 rounded-full hover:bg-white/30 transition">
                    <i class="fas fa-phone-alt mr-2 text-xs"></i>
                    MAMA ÉCOLE
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Navigation principale -->
<nav class="bg-white shadow-lg sticky top-0 z-50">
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
                <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="text-gray-700 hover:text-emerald-600 px-4 py-2 font-medium transition flex items-center group">
                        <span class="bg-gradient-to-r from-emerald-500 to-teal-600 bg-clip-text text-transparent group-hover:from-emerald-600 group-hover:to-teal-700">
                            <i class="fas fa-book mr-2 text-sm text-emerald-600"></i>
                            Ressources
                        </span>
                        <i class="fas fa-chevron-down ml-1 text-xs text-gray-400"></i>
                    </button>
                    <div x-show="open" x-transition x-cloak class="absolute top-full left-0 mt-1 w-56 bg-white rounded-xl shadow-2xl border border-emerald-100">
                        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-t-xl px-4 py-2 border-b border-emerald-100">
                            <span class="text-xs font-semibold text-emerald-700">CONTENUS ÉDUCATIFS</span>
                        </div>
                        <a href="{{ route('books.search') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition group">
                            <i class="fas fa-book-open mr-2 w-4 text-emerald-500"></i>Bibliothèque numérique
                            <span class="text-xs text-gray-500 block ml-6">50,000+ livres</span>
                        </a>
                        <a href="/actualites" class="block px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700 transition">
                            <i class="fas fa-newspaper mr-2 w-4 text-orange-500"></i>Actualités éducatives
                            <span class="text-xs text-gray-500 block ml-6">Mises à jour quotidiennes</span>
                        </a>
                        <a href="/calendrier" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                            <i class="fas fa-calendar-alt mr-2 w-4 text-blue-500"></i>Calendrier scolaire
                            <span class="text-xs text-gray-500 block ml-6">2024-2025</span>
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <a href="/parrainage" class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition rounded-b-xl">
                            <i class="fas fa-user-graduate mr-2 w-4 text-amber-500"></i>Programme mentorat
                            <span class="text-xs text-gray-500 block ml-6">250+ mentors</span>
                        </a>
                    </div>
                </div>

                <!-- Niveaux scolaires -->
                <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="text-gray-700 hover:text-teal-600 px-4 py-2 font-medium transition flex items-center">
                        <i class="fas fa-graduation-cap mr-2 text-sm text-teal-600"></i>
                        Niveaux
                        <i class="fas fa-chevron-down ml-1 text-xs text-gray-400"></i>
                    </button>
                    <div x-show="open" x-transition x-cloak class="absolute top-full left-0 mt-1 w-48 bg-white rounded-xl shadow-2xl border border-teal-100">
                        <a href="/search?level=primaire" class="block px-4 py-3 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition rounded-t-xl">
                            <i class="fas fa-child mr-2 w-4 text-yellow-500"></i>Primaire
                        </a>
                        <a href="/search?level=college" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                            <i class="fas fa-school mr-2 w-4 text-blue-500"></i>Collège
                        </a>
                        <a href="/search?level=lycee" class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition">
                            <i class="fas fa-university mr-2 w-4 text-emerald-500"></i>Lycée
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <a href="/search?level=superieur" class="block px-4 py-3 text-sm text-gray-700 hover:bg-slate-50 hover:text-slate-700 transition rounded-b-xl">
                            <i class="fas fa-user-graduate mr-2 w-4 text-slate-500"></i>Supérieur
                        </a>
                    </div>
                </div>

                <!-- Examens -->
                <a href="/search?category=Examens" class="text-gray-700 hover:text-orange-600 px-4 py-2 font-medium transition flex items-center group">
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
                    <i class="fas fa-search text-lg"></i>
                </button>

                @auth
                    <!-- Notifications -->
                    <div class="relative">
                        <button class="text-gray-500 hover:text-amber-600 p-2 transition relative">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">3</span>
                        </button>
                    </div>

                    <!-- User Menu avec Avatar -->
                    <div class="relative group" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-emerald-600 transition">
                            <img src="{{ auth()->user()->profile_photo_url }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="w-10 h-10 rounded-full object-cover ring-2 ring-emerald-400 shadow-md hover:ring-emerald-500 transition-all"
                                 style="min-width: 40px; min-height: 40px;">
                            <span class="font-medium text-gray-800">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border border-gray-100">
                            <a href="{{ url('/dashboard') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition rounded-t-xl">
                                <i class="fas fa-tachometer-alt mr-2"></i>Tableau de bord
                            </a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <i class="fas fa-user-circle mr-2"></i>Mon profil
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition rounded-b-xl">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Dropdown Connexion -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" 
                                class="text-gray-700 hover:text-emerald-600 font-medium transition flex items-center gap-1">
                            <i class="fas fa-sign-in-alt mr-1"></i>
                            Connexion
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div x-show="open" x-transition x-cloak 
                             class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-4 py-2 border-b border-emerald-100">
                                <span class="text-xs font-semibold text-emerald-700">CHOISIR VOTRE ESPACE</span>
                            </div>
                            <a href="{{ route('login') }}" 
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition group">
                                <i class="fas fa-user mr-2 w-4 text-emerald-500"></i>Espace Lecteur
                                <span class="text-xs text-gray-500 block ml-6">Accéder à votre bibliothèque</span>
                            </a>
                            <a href="{{ route('author.login') }}" 
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition">
                                <i class="fas fa-pen-fancy mr-2 w-4 text-amber-500"></i>Espace Auteur
                                <span class="text-xs text-gray-500 block ml-6">Publier et gérer vos livres</span>
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <a href="{{ route('admin.login') }}" 
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition">
                                <i class="fas fa-shield-alt mr-2 w-4 text-purple-500"></i>Administration
                                <span class="text-xs text-gray-500 block ml-6">Réservé aux administrateurs</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Dropdown Inscription -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                                class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-xl transform hover:-translate-y-0.5 flex items-center gap-1">
                            <i class="fas fa-user-plus mr-1"></i>
                            Créer un compte
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div x-show="open" x-transition x-cloak 
                             class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-4 py-2 border-b border-emerald-100">
                                <span class="text-xs font-semibold text-emerald-700">S'INSCRIRE COMME</span>
                            </div>
                            <a href="{{ route('register') }}" 
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <i class="fas fa-book-reader mr-2 w-4 text-emerald-500"></i>Lecteur
                                <span class="text-xs text-gray-500 block ml-6">Lire et télécharger des livres</span>
                            </a>
                            <a href="{{ route('author.register') }}" 
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition">
                                <i class="fas fa-feather-alt mr-2 w-4 text-amber-500"></i>Auteur
                                <span class="text-xs text-gray-500 block ml-6">Publier vos œuvres</span>
                            </a>
                        </div>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Search Modal -->
<div id="search-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-start justify-center pt-20">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4">
        <form action="/search" method="GET" class="p-6">
            <div class="flex items-center space-x-4">
                <i class="fas fa-search text-emerald-500 text-xl"></i>
                <input type="text" name="q" placeholder="Rechercher des livres, auteurs, matières..." 
                       class="flex-1 text-lg outline-none focus:ring-2 focus:ring-emerald-500 rounded-lg px-3 py-2" autofocus>
                <button type="button" onclick="document.getElementById('search-modal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="mt-4 flex gap-2">
                <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-xl">
                    Rechercher
                </button>
            </div>
        </form>
    </div>
</div>