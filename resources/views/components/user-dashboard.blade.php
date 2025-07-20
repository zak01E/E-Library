<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-Library') }} - Tableau de bord</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div x-data="{ sidebarOpen: false, userMenuOpen: false, notificationOpen: false }" class="min-h-screen">
            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
                   class="fixed inset-y-0 left-0 z-50 w-72 bg-white shadow-xl transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
                <div class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-blue-600 to-blue-700">
                    <h2 class="text-xl font-bold text-white">E-Library</h2>
                    <button @click="sidebarOpen = false" class="lg:hidden text-white hover:text-blue-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <nav class="mt-8 px-4">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 mb-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-home w-5 h-5 mr-3"></i>
                        <span class="font-medium">Tableau de bord</span>
                    </a>

                    <!-- Ma bibliothèque -->
                    <div x-data="{ open: {{ request()->is('user/library*') ? 'true' : 'false' }} }" class="mb-2">
                        <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">
                            <span class="flex items-center">
                                <i class="fas fa-book-reader w-5 h-5 mr-3"></i>
                                <span class="font-medium">Ma bibliothèque</span>
                            </span>
                            <i class="fas fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-transition class="mt-2 ml-8 space-y-1">
                            <a href="{{ route('user.library.favorites') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.library.favorites') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-heart w-4 h-4 mr-2"></i>
                                Mes favoris
                            </a>
                            <a href="{{ route('user.library.reading') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.library.reading') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-book-open w-4 h-4 mr-2"></i>
                                En cours de lecture
                            </a>
                            <a href="{{ route('user.library.finished') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.library.finished') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-check-circle w-4 h-4 mr-2"></i>
                                Livres terminés
                            </a>
                            <a href="{{ route('user.library.downloads') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.library.downloads') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-download w-4 h-4 mr-2"></i>
                                Téléchargements
                            </a>
                        </div>
                    </div>

                    <!-- Découvrir -->
                    <div x-data="{ open: {{ request()->is('books*') || request()->is('categories*') ? 'true' : 'false' }} }" class="mb-2">
                        <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">
                            <span class="flex items-center">
                                <i class="fas fa-compass w-5 h-5 mr-3"></i>
                                <span class="font-medium">Découvrir</span>
                            </span>
                            <i class="fas fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-transition class="mt-2 ml-8 space-y-1">
                            <a href="{{ route('books.index') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('books.index') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-th-large w-4 h-4 mr-2"></i>
                                Tous les livres
                            </a>
                            <a href="{{ route('books.search') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('books.search') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-search w-4 h-4 mr-2"></i>
                                Recherche avancée
                            </a>
                            <a href="{{ route('categories.index') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('categories.index') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-layer-group w-4 h-4 mr-2"></i>
                                Catégories
                            </a>
                            <a href="{{ route('books.popular') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('books.popular') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-fire w-4 h-4 mr-2"></i>
                                Populaires
                            </a>
                            <a href="{{ route('books.new') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('books.new') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-sparkles w-4 h-4 mr-2"></i>
                                Nouveautés
                            </a>
                        </div>
                    </div>

                    <!-- Collections -->
                    <div x-data="{ open: {{ request()->is('user/collections*') ? 'true' : 'false' }} }" class="mb-2">
                        <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">
                            <span class="flex items-center">
                                <i class="fas fa-folder-open w-5 h-5 mr-3"></i>
                                <span class="font-medium">Mes collections</span>
                            </span>
                            <i class="fas fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-transition class="mt-2 ml-8 space-y-1">
                            <a href="{{ route('user.collections.index') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.collections.index') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-list w-4 h-4 mr-2"></i>
                                Toutes mes collections
                            </a>
                            <a href="{{ route('user.collections.create') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.collections.create') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-plus-circle w-4 h-4 mr-2"></i>
                                Créer une collection
                            </a>
                            <a href="{{ route('user.collections.shared') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.collections.shared') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-share-alt w-4 h-4 mr-2"></i>
                                Collections partagées
                            </a>
                        </div>
                    </div>

                    <!-- Statistiques -->
                    <a href="{{ route('user.stats') }}" class="flex items-center px-4 py-3 mb-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('user.stats') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-chart-line w-5 h-5 mr-3"></i>
                        <span class="font-medium">Mes statistiques</span>
                    </a>

                    <!-- Paramètres -->
                    <div x-data="{ open: {{ request()->is('user/settings*') || request()->is('profile*') ? 'true' : 'false' }} }" class="mb-2">
                        <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">
                            <span class="flex items-center">
                                <i class="fas fa-cog w-5 h-5 mr-3"></i>
                                <span class="font-medium">Paramètres</span>
                            </span>
                            <i class="fas fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-transition class="mt-2 ml-8 space-y-1">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('profile.edit') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-user-edit w-4 h-4 mr-2"></i>
                                Mon profil
                            </a>
                            <a href="{{ route('user.settings.preferences') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.settings.preferences') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-sliders-h w-4 h-4 mr-2"></i>
                                Préférences
                            </a>
                            <a href="{{ route('user.settings.notifications') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.settings.notifications') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-bell w-4 h-4 mr-2"></i>
                                Notifications
                            </a>
                            <a href="{{ route('user.settings.privacy') }}" class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.settings.privacy') ? 'bg-gray-100 text-gray-900' : '' }}">
                                <i class="fas fa-lock w-4 h-4 mr-2"></i>
                                Confidentialité
                            </a>
                        </div>
                    </div>
                </nav>

                <!-- Support Section -->
                <div class="absolute bottom-0 w-full p-4 border-t border-gray-200">
                    <a href="{{ route('user.help') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">
                        <i class="fas fa-question-circle w-5 h-5 mr-3"></i>
                        <span class="font-medium">Aide & Support</span>
                    </a>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="lg:ml-72 flex-1">
                <!-- Top Navigation -->
                <header class="bg-white shadow-sm sticky top-0 z-40">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bars text-xl"></i>
                        </button>

                        <!-- Search Bar -->
                        <div class="flex-1 max-w-xl mx-4">
                            <form action="{{ route('books.search') }}" method="GET" class="relative">
                                <input type="text" 
                                       name="q" 
                                       placeholder="Rechercher un livre, un auteur..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </form>
                        </div>

                        <!-- Right side items -->
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative" x-data>
                                <button @click="notificationOpen = !notificationOpen" class="relative text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-bell text-xl"></i>
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                                </button>
                                
                                <!-- Notification dropdown -->
                                <div x-show="notificationOpen" 
                                     @click.away="notificationOpen = false"
                                     x-transition
                                     class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-2 z-50">
                                    <div class="px-4 py-2 border-b border-gray-200">
                                        <h3 class="font-semibold text-gray-900">Notifications</h3>
                                    </div>
                                    <div class="max-h-64 overflow-y-auto">
                                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                                            <p class="text-sm font-medium text-gray-900">Nouveau livre disponible</p>
                                            <p class="text-sm text-gray-500">Un nouveau livre de votre auteur favori est disponible</p>
                                            <p class="text-xs text-gray-400 mt-1">Il y a 2 heures</p>
                                        </a>
                                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                                            <p class="text-sm font-medium text-gray-900">Livre terminé</p>
                                            <p class="text-sm text-gray-500">Félicitations! Vous avez terminé "Le Petit Prince"</p>
                                            <p class="text-xs text-gray-400 mt-1">Hier</p>
                                        </a>
                                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                                            <p class="text-sm font-medium text-gray-900">Recommandation</p>
                                            <p class="text-sm text-gray-500">Découvrez des livres similaires à vos lectures</p>
                                            <p class="text-xs text-gray-400 mt-1">Il y a 3 jours</p>
                                        </a>
                                    </div>
                                    <div class="px-4 py-2 border-t border-gray-200">
                                        <a href="{{ route('user.notifications') }}" class="text-sm text-blue-600 hover:text-blue-800">Voir toutes les notifications</a>
                                    </div>
                                </div>
                            </div>

                            <!-- User Menu -->
                            <div class="relative" x-data>
                                <button @click="userMenuOpen = !userMenuOpen" class="flex items-center space-x-3 text-gray-700 hover:text-gray-900">
                                    <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff" alt="{{ Auth::user()->name }}">
                                    <span class="hidden md:block font-medium">{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down text-sm"></i>
                                </button>

                                <!-- User dropdown -->
                                <div x-show="userMenuOpen" 
                                     @click.away="userMenuOpen = false"
                                     x-transition
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user-circle mr-2"></i>
                                        Mon profil
                                    </a>
                                    <a href="{{ route('user.library.favorites') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-heart mr-2"></i>
                                        Mes favoris
                                    </a>
                                    <a href="{{ route('user.settings.preferences') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cog mr-2"></i>
                                        Paramètres
                                    </a>
                                    <hr class="my-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i>
                                            Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>
    </body>
</html>