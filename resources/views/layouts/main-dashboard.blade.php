<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $siteSettings['site_name'] ?? config('app.name', 'E-Library') }} - @yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    @if(isset($siteSettings['site_favicon']) && $siteSettings['site_favicon'])
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings['site_favicon']) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div x-data="{ 
        sidebarOpen: true, 
        userMenuOpen: false, 
        notificationOpen: false,
        activeMenu: null,
        toggleSubmenu(menu) {
            this.activeMenu = this.activeMenu === menu ? null : menu;
        }
    }" class="min-h-screen flex">
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-72' : 'w-20'" 
               class="fixed inset-y-0 left-0 z-50 bg-white dark:bg-gray-800 shadow-xl transition-all duration-300 ease-in-out border-r border-gray-200 dark:border-gray-700">
            
            <!-- Logo & Toggle -->
            <div class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-indigo-600 to-purple-600">
                <div class="flex items-center">
                    <i class="fas fa-book-open text-white text-2xl"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-xl font-bold text-white">E-Library</span>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" 
                        class="text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                
                <!-- Dashboard -->
                <div class="mb-6">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-100 dark:bg-gray-700 text-indigo-700 dark:text-indigo-300' : '' }}">
                        <i class="fas fa-tachometer-alt w-5 h-5"></i>
                        <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Dashboard</span>
                    </a>
                </div>

                <!-- Content Management -->
                <div class="mb-4">
                    <div x-show="sidebarOpen" class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                        Gestion du contenu
                    </div>
                    
                    <!-- Books Management -->
                    <div class="space-y-1">
                        <button @click="toggleSubmenu('books')" 
                                class="flex items-center justify-between w-full px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-book w-5 h-5"></i>
                                <span x-show="sidebarOpen" x-transition class="ml-3">Livres</span>
                            </div>
                            <i x-show="sidebarOpen" :class="activeMenu === 'books' ? 'fa-chevron-down' : 'fa-chevron-right'" 
                               class="fas text-xs transition-transform"></i>
                        </button>
                        
                        <div x-show="activeMenu === 'books' && sidebarOpen" x-transition class="ml-8 space-y-1">
                            <a href="{{ route('books.index') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-list w-4 h-4 mr-2"></i>Tous les livres
                            </a>
                            <a href="{{ route('books.create') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-plus w-4 h-4 mr-2"></i>Ajouter un livre
                            </a>
                            <a href="{{ route('books.categories') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-tags w-4 h-4 mr-2"></i>Catégories
                            </a>
                            <a href="{{ route('books.reviews') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-star w-4 h-4 mr-2"></i>Avis & Notes
                            </a>
                        </div>
                    </div>

                    <!-- Authors Management -->
                    <div class="space-y-1">
                        <button @click="toggleSubmenu('authors')" 
                                class="flex items-center justify-between w-full px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-user-edit w-5 h-5"></i>
                                <span x-show="sidebarOpen" x-transition class="ml-3">Auteurs</span>
                            </div>
                            <i x-show="sidebarOpen" :class="activeMenu === 'authors' ? 'fa-chevron-down' : 'fa-chevron-right'" 
                               class="fas text-xs transition-transform"></i>
                        </button>
                        
                        <div x-show="activeMenu === 'authors' && sidebarOpen" x-transition class="ml-8 space-y-1">
                            <a href="{{ route('authors.index') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-users w-4 h-4 mr-2"></i>Tous les auteurs
                            </a>
                            <a href="{{ route('authors.featured') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-crown w-4 h-4 mr-2"></i>Auteurs vedettes
                            </a>
                            <a href="{{ route('authors.applications') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-file-alt w-4 h-4 mr-2"></i>Candidatures
                            </a>
                        </div>
                    </div>

                    <!-- Collections -->
                    <div class="space-y-1">
                        <button @click="toggleSubmenu('collections')" 
                                class="flex items-center justify-between w-full px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-layer-group w-5 h-5"></i>
                                <span x-show="sidebarOpen" x-transition class="ml-3">Collections</span>
                            </div>
                            <i x-show="sidebarOpen" :class="activeMenu === 'collections' ? 'fa-chevron-down' : 'fa-chevron-right'" 
                               class="fas text-xs transition-transform"></i>
                        </button>
                        
                        <div x-show="activeMenu === 'collections' && sidebarOpen" x-transition class="ml-8 space-y-1">
                            <a href="{{ route('collections.index') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-folder w-4 h-4 mr-2"></i>Toutes les collections
                            </a>
                            <a href="{{ route('collections.featured') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-fire w-4 h-4 mr-2"></i>Collections populaires
                            </a>
                            <a href="{{ route('collections.create') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-plus-circle w-4 h-4 mr-2"></i>Créer une collection
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Analytics & Reports -->
                <div class="mb-4">
                    <div x-show="sidebarOpen" class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                        Analytics & Rapports
                    </div>

                    <div class="space-y-1">
                        <button @click="toggleSubmenu('analytics')"
                                class="flex items-center justify-between w-full px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-chart-line w-5 h-5"></i>
                                <span x-show="sidebarOpen" x-transition class="ml-3">Analytics</span>
                            </div>
                            <i x-show="sidebarOpen" :class="activeMenu === 'analytics' ? 'fa-chevron-down' : 'fa-chevron-right'"
                               class="fas text-xs transition-transform"></i>
                        </button>

                        <div x-show="activeMenu === 'analytics' && sidebarOpen" x-transition class="ml-8 space-y-1">
                            <a href="{{ route('analytics.overview') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-chart-pie w-4 h-4 mr-2"></i>Vue d'ensemble
                            </a>
                            <a href="{{ route('analytics.books') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-book-open w-4 h-4 mr-2"></i>Performance des livres
                            </a>
                            <a href="{{ route('analytics.users') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-users w-4 h-4 mr-2"></i>Comportement utilisateurs
                            </a>
                            <a href="{{ route('analytics.revenue') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-dollar-sign w-4 h-4 mr-2"></i>Revenus & Abonnements
                            </a>
                            <a href="{{ route('analytics.trends') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-trending-up w-4 h-4 mr-2"></i>Tendances
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User Management -->
                <div class="mb-4">
                    <div x-show="sidebarOpen" class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                        Gestion des utilisateurs
                    </div>

                    <div class="space-y-1">
                        <button @click="toggleSubmenu('users')"
                                class="flex items-center justify-between w-full px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-users w-5 h-5"></i>
                                <span x-show="sidebarOpen" x-transition class="ml-3">Utilisateurs</span>
                            </div>
                            <i x-show="sidebarOpen" :class="activeMenu === 'users' ? 'fa-chevron-down' : 'fa-chevron-right'"
                               class="fas text-xs transition-transform"></i>
                        </button>

                        <div x-show="activeMenu === 'users' && sidebarOpen" x-transition class="ml-8 space-y-1">
                            <a href="{{ route('users.index') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-list w-4 h-4 mr-2"></i>Tous les utilisateurs
                            </a>
                            <a href="{{ route('users.active') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-user-check w-4 h-4 mr-2"></i>Utilisateurs actifs
                            </a>
                            <a href="{{ route('users.subscriptions') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-crown w-4 h-4 mr-2"></i>Abonnements
                            </a>
                            <a href="{{ route('users.permissions') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-shield-alt w-4 h-4 mr-2"></i>Permissions & Rôles
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Marketing & Promotion -->
                <div class="mb-4">
                    <div x-show="sidebarOpen" class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                        Marketing & Promotion
                    </div>

                    <div class="space-y-1">
                        <button @click="toggleSubmenu('marketing')"
                                class="flex items-center justify-between w-full px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-bullhorn w-5 h-5"></i>
                                <span x-show="sidebarOpen" x-transition class="ml-3">Marketing</span>
                            </div>
                            <i x-show="sidebarOpen" :class="activeMenu === 'marketing' ? 'fa-chevron-down' : 'fa-chevron-right'"
                               class="fas text-xs transition-transform"></i>
                        </button>

                        <div x-show="activeMenu === 'marketing' && sidebarOpen" x-transition class="ml-8 space-y-1">
                            <a href="{{ route('marketing.campaigns') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-rocket w-4 h-4 mr-2"></i>Campagnes
                            </a>
                            <a href="{{ route('marketing.newsletters') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-envelope w-4 h-4 mr-2"></i>Newsletters
                            </a>
                            <a href="{{ route('marketing.promotions') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-percent w-4 h-4 mr-2"></i>Promotions
                            </a>
                            <a href="{{ route('marketing.social') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-share-alt w-4 h-4 mr-2"></i>Réseaux sociaux
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System & Settings -->
                <div class="mb-4">
                    <div x-show="sidebarOpen" class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                        Système & Configuration
                    </div>

                    <div class="space-y-1">
                        <button @click="toggleSubmenu('system')"
                                class="flex items-center justify-between w-full px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-cogs w-5 h-5"></i>
                                <span x-show="sidebarOpen" x-transition class="ml-3">Système</span>
                            </div>
                            <i x-show="sidebarOpen" :class="activeMenu === 'system' ? 'fa-chevron-down' : 'fa-chevron-right'"
                               class="fas text-xs transition-transform"></i>
                        </button>

                        <div x-show="activeMenu === 'system' && sidebarOpen" x-transition class="ml-8 space-y-1">
                            <a href="{{ route('system.settings') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-sliders-h w-4 h-4 mr-2"></i>Paramètres généraux
                            </a>
                            <a href="{{ route('system.backup') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-database w-4 h-4 mr-2"></i>Sauvegarde
                            </a>
                            <a href="{{ route('system.logs') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-file-alt w-4 h-4 mr-2"></i>Logs système
                            </a>
                            <a href="{{ route('system.maintenance') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                                <i class="fas fa-tools w-4 h-4 mr-2"></i>Maintenance
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- User Profile -->
            <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <img class="w-10 h-10 rounded-full object-cover" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}">
                    <div x-show="sidebarOpen" x-transition class="ml-3">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main :class="sidebarOpen ? 'ml-72' : 'ml-20'" class="flex-1 transition-all duration-300 ease-in-out">
            <!-- Top Header -->
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">@yield('page-title', 'Dashboard')</h1>
                            <p class="text-gray-600 dark:text-gray-400">@yield('page-description', 'Bienvenue sur votre tableau de bord')</p>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Search -->
                            <div class="relative">
                                <input type="text" placeholder="Rechercher..." 
                                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            
                            <!-- Notifications -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 relative">
                                    <i class="fas fa-bell text-xl"></i>
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                                </button>
                            </div>
                            
                            <!-- Dark Mode Toggle -->
                            <button @click="darkMode = !darkMode" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <i :class="darkMode ? 'fa-sun' : 'fa-moon'" class="fas text-xl"></i>
                            </button>
                            
                            <!-- User Menu -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <img class="w-8 h-8 rounded-full object-cover" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" x-transition 
                                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-user w-4 h-4 mr-2"></i>Profil
                                    </a>
                                    <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-cog w-4 h-4 mr-2"></i>Paramètres
                                    </a>
                                    <hr class="border-gray-200 dark:border-gray-700">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <i class="fas fa-sign-out-alt w-4 h-4 mr-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-6">
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
