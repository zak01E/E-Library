<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ site_name() }} - Espace Utilisateur</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ site_favicon() }}">

    <!-- Fonts (même police que home.blade.php) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* Styles uniformes avec home.blade.php */
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
             class="fixed inset-y-0 left-0 z-50 w-72 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 border-r border-gray-100">
            
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-emerald-600 to-teal-600">
                <div class="flex items-center">
                    @if(site_logo())
                        <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-8 w-auto brightness-0 invert">
                    @else
                        <div class="bg-white/20 p-2 rounded-lg">
                            <i class="fas fa-book-open text-2xl text-white"></i>
                        </div>
                    @endif
                    <div class="ml-3">
                        <h1 class="text-lg font-bold text-white">{{ site_name() }}</h1>
                        <p class="text-xs text-emerald-100">Espace Utilisateur</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-white hover:bg-white/10 p-2 rounded-lg transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                
                <!-- Dashboard -->
                <div class="mb-6">
                    <a href="{{ route('user.dashboard') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-emerald-50 transition-colors group {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-700 border-l-4 border-emerald-500' : '' }}">
                        <div class="{{ request()->routeIs('dashboard') ? 'bg-emerald-500' : 'bg-gray-400' }} w-8 h-8 rounded-full flex items-center justify-center group-hover:bg-emerald-500 transition">
                            <i class="fas fa-tachometer-alt text-white text-sm"></i>
                        </div>
                        <span class="ml-3 font-semibold">Tableau de bord</span>
                    </a>
                </div>

                <!-- Ma Bibliothèque -->
                <div class="mb-4">
                    <div class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                        Ma Bibliothèque
                    </div>
                    
                    <div class="space-y-1">
                        <a href="{{ route('user.library.current') }}" 
                           class="flex items-center px-4 py-2.5 text-sm text-gray-600 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition-all group {{ request()->routeIs('user.library.current') ? 'bg-emerald-50 text-emerald-700 font-medium' : '' }}">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center mr-3 {{ request()->routeIs('user.library.current') ? 'bg-emerald-500' : 'bg-gray-300' }} group-hover:bg-emerald-400 transition">
                                <i class="fas fa-book-reader text-white text-xs"></i>
                            </div>
                            En cours de lecture
                        </a>
                        
                        <a href="{{ route('user.library.favorites') }}" 
                           class="flex items-center px-4 py-2.5 text-sm text-gray-600 rounded-lg hover:bg-red-50 hover:text-red-700 transition-all group {{ request()->routeIs('user.library.favorites') ? 'bg-red-50 text-red-700 font-medium' : '' }}">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center mr-3 {{ request()->routeIs('user.library.favorites') ? 'bg-red-500' : 'bg-gray-300' }} group-hover:bg-red-400 transition">
                                <i class="fas fa-heart text-white text-xs"></i>
                            </div>
                            Favoris
                        </a>
                        
                        <a href="{{ route('user.library.history') }}" 
                           class="flex items-center px-4 py-2.5 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all group {{ request()->routeIs('user.library.history') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center mr-3 {{ request()->routeIs('user.library.history') ? 'bg-blue-500' : 'bg-gray-300' }} group-hover:bg-blue-400 transition">
                                <i class="fas fa-history text-white text-xs"></i>
                            </div>
                            Historique
                        </a>
                        
                        <a href="{{ route('user.collections.index') }}" 
                           class="flex items-center px-4 py-2.5 text-sm text-gray-600 rounded-lg hover:bg-amber-50 hover:text-amber-700 transition-all group {{ request()->routeIs('user.collections.*') ? 'bg-amber-50 text-amber-700 font-medium' : '' }}">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center mr-3 {{ request()->routeIs('user.collections.*') ? 'bg-amber-500' : 'bg-gray-300' }} group-hover:bg-amber-400 transition">
                                <i class="fas fa-folder text-white text-xs"></i>
                            </div>
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
                        <a href="{{ route('user.discover.index') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.discover.index') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
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
                        
                        <a href="{{ route('user.discover.authors') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('user.discover.authors') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
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
                       class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition-colors {{ request()->routeIs('user.stats.*') ? 'bg-teal-100 text-purple-700 font-semibold' : '' }}">
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
                                {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'G' }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ auth()->check() ? auth()->user()->name : 'Guest' }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">
                            {{ auth()->check() ? auth()->user()->email : '' }}
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
                                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'G' }}
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
