<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', site_name())</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ site_favicon() }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        .gradient-emerald {
            background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        @if(site_logo())
                            <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-10 w-auto">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center shadow-md">
                                <i class="fas fa-book-open text-white text-lg"></i>
                            </div>
                        @endif
                        <span class="ml-3 text-xl font-bold text-gray-900">{{ site_name() }}</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Accueil</a>
                        <a href="{{ route('books.public.index') }}" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Bibliothèque</a>
                        <a href="{{ route('authors.index') }}" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Auteurs</a>
                        <a href="#contact" class="text-gray-500 hover:text-emerald-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Contact</a>
                    </div>
                </div>
                
                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-emerald-600 px-3 py-2 text-sm font-medium transition-colors">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg">
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
                    <a href="{{ route('books.public.index') }}" class="text-gray-500 hover:text-emerald-600 block px-3 py-2 text-sm font-medium">Bibliothèque</a>
                    <a href="{{ route('authors.index') }}" class="text-gray-500 hover:text-emerald-600 block px-3 py-2 text-sm font-medium">Auteurs</a>
                    <a href="#contact" class="text-gray-500 hover:text-emerald-600 block px-3 py-2 text-sm font-medium">Contact</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white block px-3 py-2 text-sm font-medium rounded-lg mx-3 mt-4">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-emerald-600 block px-3 py-2 text-sm font-medium">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white block px-3 py-2 text-sm font-medium rounded-lg mx-3 mt-2">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center mb-4">
                        @if(site_logo())
                            <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-8 w-auto">
                        @else
                            <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center shadow-md">
                                <i class="fas fa-book-open text-white text-sm"></i>
                            </div>
                        @endif
                        <span class="ml-2 text-lg font-bold">{{ site_name() }}</span>
                    </div>
                    <p class="text-gray-300 text-sm">
                        Votre bibliothèque numérique moderne pour découvrir et partager des livres.
                    </p>
                    <div class="flex space-x-3 mt-4">
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-gradient-to-r hover:from-emerald-500 hover:to-teal-600 transition-all duration-200">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-gradient-to-r hover:from-emerald-500 hover:to-teal-600 transition-all duration-200">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-gradient-to-r hover:from-emerald-500 hover:to-teal-600 transition-all duration-200">
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
                        <li><a href="{{ route('authors.index') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Auteurs</a></li>
                    </ul>
                </div>
                
                <!-- Categories -->
                <div>
                    <h3 class="text-base font-semibold mb-4">Catégories</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Fiction</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Non-Fiction</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Science</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Technologie</a></li>
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
            
            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} {{ site_name() }}. Tous droits réservés.
                </p>
                <div class="flex items-center mt-4 md:mt-0">
                    <span class="text-gray-400 text-sm">Fait avec <span class="text-red-500">❤️</span> pour les amoureux des livres</span>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html>