<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Author Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform lg:translate-x-0 transition-transform duration-300 ease-in-out" x-data="{ open: false }">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-green-600">
                <h1 class="text-white text-xl font-bold">eLibrary Auteur</h1>
            </div>

            <!-- Navigation -->
            <nav class="mt-5 px-2 overflow-y-auto h-full pb-20">
                <!-- Dashboard -->
                <div class="space-y-1">
                    <a href="{{ route('author.dashboard') }}" class="bg-green-50 border-green-500 text-green-700 hover:bg-green-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md border-l-4">
                        <svg class="text-green-500 mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z" />
                        </svg>
                        Dashboard
                    </a>
                </div>

                <!-- My Books -->
                <div class="space-y-1 mt-6" x-data="{ expanded: false }">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Mes Livres</div>
                    <button @click="expanded = !expanded" class="text-gray-700 hover:bg-gray-50 group flex w-full items-center px-2 py-2 text-sm font-medium rounded-md">
                        <svg class="text-gray-400 mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Mes Publications
                        <svg :class="expanded ? 'rotate-90' : ''" class="text-gray-400 ml-auto h-5 w-5 transform transition-colors duration-150" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="expanded" class="space-y-1 pl-6">
                        <a href="{{ route('author.books.create') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <svg class="text-gray-400 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Ajouter un livre
                        </a>
                        <a href="{{ route('author.books') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Tous mes livres
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Livres approuvés
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            En attente
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Brouillons
                        </a>
                    </div>
                </div>

                <!-- Analytics & Performance -->
                <div class="space-y-1 mt-6" x-data="{ expanded: false }">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Performance</div>
                    <button @click="expanded = !expanded" class="text-gray-700 hover:bg-gray-50 group flex w-full items-center px-2 py-2 text-sm font-medium rounded-md">
                        <svg class="text-gray-400 mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Statistiques
                        <svg :class="expanded ? 'rotate-90' : ''" class="text-gray-400 ml-auto h-5 w-5 transform transition-colors duration-150" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="expanded" class="space-y-1 pl-6">
                        <a href="{{ route('author.analytics') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Vue d'ensemble
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Téléchargements
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Vues de livres
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Tendances
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Rapports
                        </a>
                    </div>
                </div>

                <!-- Reading Community -->
                <div class="space-y-1 mt-6" x-data="{ expanded: false }">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Communauté</div>
                    <button @click="expanded = !expanded" class="text-gray-700 hover:bg-gray-50 group flex w-full items-center px-2 py-2 text-sm font-medium rounded-md">
                        <svg class="text-gray-400 mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Lecteurs
                        <svg :class="expanded ? 'rotate-90' : ''" class="text-gray-400 ml-auto h-5 w-5 transform transition-colors duration-150" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="expanded" class="space-y-1 pl-6">
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Commentaires
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Évaluations
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Followers
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Messages
                        </a>
                    </div>
                </div>

                <!-- Tools & Resources -->
                <div class="space-y-1 mt-6" x-data="{ expanded: false }">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Outils</div>
                    <button @click="expanded = !expanded" class="text-gray-700 hover:bg-gray-50 group flex w-full items-center px-2 py-2 text-sm font-medium rounded-md">
                        <svg class="text-gray-400 mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        Ressources
                        <svg :class="expanded ? 'rotate-90' : ''" class="text-gray-400 ml-auto h-5 w-5 transform transition-colors duration-150" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="expanded" class="space-y-1 pl-6">
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Guide de publication
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Éditeur de couverture
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Outils de formatage
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Templates PDF
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            SEO & Mots-clés
                        </a>
                    </div>
                </div>

                <!-- Settings -->
                <div class="space-y-1 mt-6" x-data="{ expanded: false }">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Paramètres</div>
                    <button @click="expanded = !expanded" class="text-gray-700 hover:bg-gray-50 group flex w-full items-center px-2 py-2 text-sm font-medium rounded-md">
                        <svg class="text-gray-400 mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Configuration
                        <svg :class="expanded ? 'rotate-90' : ''" class="text-gray-400 ml-auto h-5 w-5 transform transition-colors duration-150" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="expanded" class="space-y-1 pl-6">
                        <a href="{{ route('author.profile.edit') }}" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Profil auteur
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Préférences
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Notifications
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            Sécurité
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-64 overflow-y-auto">
            <!-- Top Navigation -->
            <header class="bg-white shadow">
                <div class="flex items-center justify-between px-6 py-4">
                    <h1 class="text-2xl font-semibold text-gray-900">Dashboard Auteur</h1>
                    <div class="flex items-center space-x-4">
                        <!-- Quick Actions -->
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('author.books.create') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Nouveau livre
                            </a>
                        </div>
                        
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <span class="sr-only">Open user menu</span>
                                <div class="h-8 w-8 rounded-full bg-green-600 flex items-center justify-center">
                                    <span class="text-sm font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="ml-3 text-gray-700">{{ auth()->user()->name }}</span>
                            </button>
                            <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                <div class="py-1">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
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
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="p-6">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Mes Livres</dt>
                                        <dd class="text-lg font-medium text-gray-900">{{ $stats['my_books'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Approuvés</dt>
                                        <dd class="text-lg font-medium text-green-600">{{ $stats['approved_books'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">En Attente</dt>
                                        <dd class="text-lg font-medium text-yellow-600">{{ $stats['pending_books'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Vues</dt>
                                        <dd class="text-lg font-medium text-purple-600">{{ $stats['total_views'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Téléchargements</dt>
                                        <dd class="text-lg font-medium text-indigo-600">{{ $stats['total_downloads'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- My Recent Books -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Mes Livres Récents</h3>
                            <div class="mt-5">
                                @if($my_books->count() > 0)
                                    <div class="space-y-3">
                                        @foreach($my_books as $book)
                                        <div class="p-4 border border-gray-200 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <a href="{{ route('books.show', $book) }}" class="text-sm font-medium text-gray-900 hover:text-green-600">
                                                        {{ $book->title }}
                                                    </a>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $book->created_at->diffForHumans() }}
                                                        @if(!$book->is_approved)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                En attente
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                                Approuvé
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $book->views }} vues • {{ $book->downloads }} téléchargements
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-6">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun livre</h3>
                                        <p class="mt-1 text-sm text-gray-500">Commencez par publier votre premier livre.</p>
                                        <div class="mt-6">
                                            <a href="{{ route('author.books.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                Ajouter un livre
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Top Performing Books -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Mes Livres les Plus Populaires</h3>
                            <div class="mt-5">
                                @if($top_books->count() > 0)
                                    <div class="space-y-3">
                                        @foreach($top_books as $book)
                                        <div class="p-4 border border-gray-200 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <a href="{{ route('books.show', $book) }}" class="text-sm font-medium text-gray-900 hover:text-green-600">
                                                        {{ $book->title }}
                                                    </a>
                                                    <p class="text-sm text-gray-500">
                                                        Publié {{ $book->publication_year ?? 'N/A' }}
                                                    </p>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm font-medium text-gray-900">{{ $book->downloads }} téléchargements</div>
                                                    <div class="text-sm text-gray-500">{{ $book->views }} vues</div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 text-center py-6">Aucun livre avec des téléchargements pour le moment.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>