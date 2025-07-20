<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $siteSettings['site_name'] ?? config('app.name', 'eLibrary') }} - {{ $title ?? 'Dashboard' }}</title>

    <!-- Favicon -->
    @if(isset($siteSettings['site_favicon']) && $siteSettings['site_favicon'])
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings['site_favicon']) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
        <!-- Sidebar for mobile -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden"></div>

        <!-- Sidebar -->
        <div :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
             class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
            
            <!-- Logo Section -->
            <div class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                <div class="flex items-center">
                    @if(isset($siteSettings['site_logo']) && $siteSettings['site_logo'])
                        <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'eLibrary' }}" class="h-10 w-auto brightness-0 invert">
                    @else
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="text-xl font-bold">{{ $siteSettings['site_name'] ?? 'eLibrary' }}</span>
                    @endif
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- User Info -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">Membre Standard</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium">Tableau de bord</span>
                </a>

                <!-- Bibliothèque -->
                <div x-data="{ open: {{ request()->is('user/library*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                            <span class="font-medium">Ma Bibliothèque</span>
                        </div>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="mt-1 ml-8 space-y-1">
                        <a href="{{ route('user.library.current') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md">Emprunts actuels</a>
                        <a href="{{ route('user.library.history') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md">Historique</a>
                        <a href="{{ route('user.library.favorites') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md">Favoris</a>
                        <a href="{{ route('user.library.wishlist') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md">Liste de souhaits</a>
                    </div>
                </div>

                <!-- Découverte -->
                <div x-data="{ open: {{ request()->is('user/discover*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span class="font-medium">Découvrir</span>
                        </div>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="mt-1 ml-8 space-y-1">
                        <a href="{{ route('books.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md">Tous les livres</a>
                        <a href="{{ route('user.discover.new') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md">Nouveautés</a>
                        <a href="{{ route('user.discover.popular') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md">Populaires</a>
                        <a href="{{ route('user.discover.categories') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md">Catégories</a>
                        <a href="{{ route('user.discover.authors') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md">Auteurs</a>
                    </div>
                </div>

                <!-- Lecture -->
                <a href="{{ route('user.reading-room') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 {{ request()->routeIs('user.reading-room') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="font-medium">Salle de lecture</span>
                </a>

                <!-- Statistiques -->
                <a href="{{ route('user.stats') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 {{ request()->routeIs('user.stats') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="font-medium">Mes statistiques</span>
                </a>

                <!-- Réservations -->
                <a href="{{ route('user.reservations') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 {{ request()->routeIs('user.reservations') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium">Réservations</span>
                </a>

                <!-- Aide -->
                <div x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="font-medium">Aide & Support</span>
                        </div>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="mt-1 ml-8 space-y-1">
                        <a href="{{ route('user.help.faq') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md">FAQ</a>
                        <a href="{{ route('user.help.guide') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md">Guide d'utilisation</a>
                        <a href="{{ route('user.help.contact') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md">Nous contacter</a>
                    </div>
                </div>
            </nav>

            <!-- Bottom Section -->
            <div class="px-4 py-4 border-t border-gray-200">
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Paramètres
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:pl-64 flex flex-col flex-1">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700 lg:hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h1 class="ml-4 lg:ml-0 text-2xl font-semibold text-gray-900">{{ $header ?? 'Dashboard' }}</h1>
                    </div>

                    <!-- Header Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="relative hidden sm:block">
                            <input type="text" 
                                   placeholder="Rechercher un livre..." 
                                   class="pl-10 pr-4 py-2 w-64 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-red-400"></span>
                        </button>

                        <!-- User Menu -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            </button>
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mon profil</a>
                                <a href="{{ route('user.stats') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mes statistiques</a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>