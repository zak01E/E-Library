<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Library') }} - Espace Utilisateur</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div x-data="{ 
        sidebarOpen: window.innerWidth >= 1024,
        userMenuOpen: false,
        notificationOpen: false,
        activeMenu: null,
        toggleSubmenu(menu) {
            this.activeMenu = this.activeMenu === menu ? null : menu;
        }
    }" class="min-h-screen flex">
        
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
            
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-book-open text-2xl text-blue-600"></i>
                    </div>
                    <div class="ml-3">
                        <h1 class="text-xl font-bold text-gray-900">E-Library</h1>
                        <p class="text-xs text-gray-500">Espace Utilisateur</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                
                <!-- Dashboard -->
                <div class="mb-6">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
                        <i class="fas fa-tachometer-alt w-5 h-5"></i>
                        <span class="ml-3">Tableau de bord</span>
                    </a>
                </div>

                <!-- Ma Bibliothèque -->
                <div class="mb-4">
                    <div class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                        Ma Bibliothèque
                    </div>
                    
                    <div class="space-y-1">
                        <a href="{{ route('user.library.current') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.library.current') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                            <i class="fas fa-book-reader w-4 h-4 mr-3"></i>
                            En cours de lecture
                        </a>
                        
                        <a href="{{ route('user.library.favorites') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.library.favorites') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                            <i class="fas fa-heart w-4 h-4 mr-3"></i>
                            Favoris
                        </a>
                        
                        <a href="{{ route('user.library.history') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.library.history') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                            <i class="fas fa-history w-4 h-4 mr-3"></i>
                            Historique
                        </a>
                        
                        <a href="{{ route('user.collections.index') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.collections.*') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                            <i class="fas fa-folder w-4 h-4 mr-3"></i>
                            Mes collections
                        </a>
                    </div>
                </div>

                <!-- Découvrir -->
                <div class="mb-4">
                    <div class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                        Découvrir
                    </div>
                    
                    <div class="space-y-1">
                        <a href="{{ route('books.public.index') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('books.public.index') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                            <i class="fas fa-book w-4 h-4 mr-3"></i>
                            Tous les livres
                        </a>
                        
                        <a href="{{ route('user.discover.new') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.discover.new') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                            <i class="fas fa-sparkles w-4 h-4 mr-3"></i>
                            Nouveautés
                        </a>
                        
                        <a href="{{ route('user.discover.popular') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.discover.popular') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                            <i class="fas fa-fire w-4 h-4 mr-3"></i>
                            Populaires
                        </a>
                        
                        <a href="{{ route('user.discover.categories') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.discover.categories') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                            <i class="fas fa-layer-group w-4 h-4 mr-3"></i>
                            Catégories
                        </a>
                        
                        <a href="{{ route('authors.index') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('authors.index') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                            <i class="fas fa-user-edit w-4 h-4 mr-3"></i>
                            Auteurs
                        </a>
                    </div>
                </div>

                <!-- Salle de lecture -->
                <div class="mb-4">
                    <a href="{{ route('user.reading-room.index') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-green-50 hover:text-green-700 transition-colors {{ request()->routeIs('user.reading-room.*') ? 'bg-green-100 text-green-700 font-semibold' : '' }}">
                        <i class="fas fa-glasses w-5 h-5"></i>
                        <span class="ml-3">Salle de lecture</span>
                    </a>
                </div>

                <!-- Statistiques -->
                <div class="mb-4">
                    <a href="{{ route('user.stats.index') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition-colors {{ request()->routeIs('user.stats.*') ? 'bg-purple-100 text-purple-700 font-semibold' : '' }}">
                        <i class="fas fa-chart-bar w-5 h-5"></i>
                        <span class="ml-3">Mes statistiques</span>
                    </a>
                </div>

                <!-- Paramètres -->
                <div class="mb-4">
                    <div class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                        Paramètres
                    </div>
                    
                    <div class="space-y-1">
                        <a href="{{ route('user.profile.edit') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.profile.*') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                            <i class="fas fa-user-circle w-4 h-4 mr-3"></i>
                            Mon profil
                        </a>
                        
                        <a href="{{ route('user.settings.index') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.settings.*') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                            <i class="fas fa-cog w-4 h-4 mr-3"></i>
                            Préférences
                        </a>
                    </div>
                </div>
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-white">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div class="ml-4 lg:ml-0">
                            <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Tableau de bord')</h1>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="hidden md:block">
                            <div class="relative">
                                <input type="text" placeholder="Rechercher un livre..." 
                                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400"></span>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-1 z-50">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    <div class="px-4 py-3 hover:bg-gray-50">
                                        <p class="text-sm text-gray-900">Nouveau livre disponible</p>
                                        <p class="text-xs text-gray-500">Il y a 2 heures</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50">
                                <a href="{{ route('user.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-circle mr-2"></i>Mon profil
                                </a>
                                <a href="{{ route('user.settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i>Paramètres
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container mx-auto px-6 py-8">
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>
    </div>
</body>
</html>
