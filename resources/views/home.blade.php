<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ site_name() }} - {{ site_setting('site_description', 'Votre Bibliothèque Numérique Moderne') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ site_favicon() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-gray-50 overflow-x-hidden">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-lg sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        @if(site_logo())
                            <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-10 w-auto">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book-open text-white text-lg"></i>
                            </div>
                        @endif
                        <span class="ml-3 text-xl font-bold text-gray-900">{{ site_name() }}</span>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#accueil" class="text-gray-900 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Accueil</a>
                        <a href="#bibliotheque" class="text-gray-500 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Bibliothèque</a>
                        <a href="#auteurs" class="text-gray-500 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Auteurs</a>
                        <a href="#a-propos" class="text-gray-500 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">À propos</a>
                    </div>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-500 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors">
                                Connexion
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    S'inscrire
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#accueil" class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Accueil</a>
                <a href="#bibliotheque" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Bibliothèque</a>
                <a href="#auteurs" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Auteurs</a>
                <a href="#a-propos" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">À propos</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-indigo-600 text-white block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-indigo-600 text-white block px-3 py-2 rounded-md text-base font-medium">S'inscrire</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="accueil" class="gradient-bg relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center">
                <!-- Floating Books Animation -->
                <div class="absolute top-10 left-10 animate-float">
                    <div class="w-16 h-20 bg-white bg-opacity-20 rounded-lg transform rotate-12"></div>
                </div>
                <div class="absolute top-20 right-20 animate-float" style="animation-delay: 2s;">
                    <div class="w-12 h-16 bg-white bg-opacity-20 rounded-lg transform -rotate-12"></div>
                </div>
                <div class="absolute bottom-20 left-20 animate-float" style="animation-delay: 4s;">
                    <div class="w-14 h-18 bg-white bg-opacity-20 rounded-lg transform rotate-6"></div>
                </div>

                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6">
                    Bienvenue sur <span class="text-yellow-300">{{ site_name() }}</span><br>
                    {{ site_setting('site_description', 'Votre Bibliothèque Numérique Moderne') }}
                </h1>
                <p class="text-xl md:text-2xl text-white text-opacity-90 mb-8 max-w-3xl mx-auto">
                    {{ site_setting('hero_description', 'Découvrez, lisez et partagez des milliers de livres numériques. Une expérience de lecture révolutionnaire vous attend.') }}
                </p>

                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto mb-12">
                    <form action="{{ route('books.search') }}" method="GET" class="relative">
                        <div class="flex">
                            <input type="text" name="q" placeholder="Rechercher un livre, un auteur, une catégorie..."
                                   class="flex-1 px-6 py-4 text-lg rounded-l-2xl border-0 focus:ring-4 focus:ring-white focus:ring-opacity-30 focus:outline-none">
                            <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-8 py-4 rounded-r-2xl font-semibold transition-colors">
                                <i class="fas fa-search text-xl"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
                    <a href="{{ route('books.public.index') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg">
                        <i class="fas fa-book-open mr-2"></i>
                        Explorer la Bibliothèque
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="glass-effect text-white px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-white hover:bg-opacity-20 transition-colors border border-white border-opacity-30">
                            <i class="fas fa-user-plus mr-2"></i>
                            Rejoindre Gratuitement
                        </a>
                    @endguest
                </div>

                <!-- Stats Counter -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto" x-data="{
                    books: 0,
                    users: 0,
                    downloads: 0,
                    authors: 0,
                    animateCounters() {
                        this.countUp('books', 15420);
                        this.countUp('users', 8750);
                        this.countUp('downloads', 125000);
                        this.countUp('authors', 1250);
                    },
                    countUp(property, target) {
                        let current = 0;
                        const increment = target / 100;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                current = target;
                                clearInterval(timer);
                            }
                            this[property] = Math.floor(current);
                        }, 20);
                    }
                }" x-init="setTimeout(() => animateCounters(), 500)">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white" x-text="books.toLocaleString()">0</div>
                        <div class="text-white text-opacity-80 text-sm md:text-base">Livres Disponibles</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white" x-text="users.toLocaleString()">0</div>
                        <div class="text-white text-opacity-80 text-sm md:text-base">Lecteurs Actifs</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white" x-text="downloads.toLocaleString()">0</div>
                        <div class="text-white text-opacity-80 text-sm md:text-base">Téléchargements</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white" x-text="authors.toLocaleString()">0</div>
                        <div class="text-white text-opacity-80 text-sm md:text-base">Auteurs Publiés</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fonctionnalites" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Pourquoi Choisir E-Library ?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Une plateforme complète qui révolutionne votre expérience de lecture et d'écriture
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1: Lecture -->
                <div class="group bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-book-reader text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Lecture Immersive</h3>
                    <p class="text-gray-600 mb-6">
                        Profitez d'une expérience de lecture optimisée avec notre lecteur PDF intégré,
                        annotations et marque-pages synchronisés.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>Lecteur PDF avancé</li>
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>Mode sombre/clair</li>
                        <li class="flex items-center"><i class="fas fa-check text-blue-500 mr-2"></i>Annotations personnelles</li>
                    </ul>
                </div>

                <!-- Feature 2: Publication -->
                <div class="group bg-gradient-to-br from-green-50 to-emerald-100 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-pen-fancy text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Publication Facile</h3>
                    <p class="text-gray-600 mb-6">
                        Publiez vos œuvres en quelques clics. Système de validation,
                        gestion des droits et analytics détaillés inclus.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Upload simple et rapide</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Validation automatique</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Analytics en temps réel</li>
                    </ul>
                </div>

                <!-- Feature 3: Recherche -->
                <div class="group bg-gradient-to-br from-purple-50 to-violet-100 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-purple-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-search-plus text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Recherche Intelligente</h3>
                    <p class="text-gray-600 mb-6">
                        Trouvez exactement ce que vous cherchez grâce à notre moteur de recherche
                        avancé avec filtres et recommandations personnalisées.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Filtres avancés</li>
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Recommandations IA</li>
                        <li class="flex items-center"><i class="fas fa-check text-purple-500 mr-2"></i>Recherche dans le contenu</li>
                    </ul>
                </div>

                <!-- Feature 4: Communauté -->
                <div class="group bg-gradient-to-br from-orange-50 to-red-100 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Communauté Active</h3>
                    <p class="text-gray-600 mb-6">
                        Rejoignez une communauté passionnée de lecteurs et d'auteurs.
                        Partagez, commentez et découvrez de nouveaux talents.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check text-orange-500 mr-2"></i>Avis et commentaires</li>
                        <li class="flex items-center"><i class="fas fa-check text-orange-500 mr-2"></i>Groupes de lecture</li>
                        <li class="flex items-center"><i class="fas fa-check text-orange-500 mr-2"></i>Événements littéraires</li>
                    </ul>
                </div>

                <!-- Feature 5: Accessibilité -->
                <div class="group bg-gradient-to-br from-teal-50 to-cyan-100 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-teal-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-universal-access text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Accessible à Tous</h3>
                    <p class="text-gray-600 mb-6">
                        Conçu pour être accessible à tous, avec support des technologies d'assistance
                        et interface adaptative.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check text-teal-500 mr-2"></i>Lecteur d'écran compatible</li>
                        <li class="flex items-center"><i class="fas fa-check text-teal-500 mr-2"></i>Contraste adaptatif</li>
                        <li class="flex items-center"><i class="fas fa-check text-teal-500 mr-2"></i>Navigation au clavier</li>
                    </ul>
                </div>

                <!-- Feature 6: Synchronisation -->
                <div class="group bg-gradient-to-br from-pink-50 to-rose-100 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-pink-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-sync-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Synchronisation Cloud</h3>
                    <p class="text-gray-600 mb-6">
                        Vos livres, annotations et préférences synchronisés sur tous vos appareils.
                        Continuez votre lecture où que vous soyez.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check text-pink-500 mr-2"></i>Multi-appareils</li>
                        <li class="flex items-center"><i class="fas fa-check text-pink-500 mr-2"></i>Sauvegarde automatique</li>
                        <li class="flex items-center"><i class="fas fa-check text-pink-500 mr-2"></i>Accès hors ligne</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Books Section -->
    <section id="bibliotheque" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Livres Populaires
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Découvrez les livres les plus appréciés par notre communauté
                </p>
            </div>

            <!-- Books Carousel -->
            <div class="relative" x-data="{ currentSlide: 0, totalSlides: 3 }">
                <div class="overflow-hidden rounded-2xl">
                    <div class="flex transition-transform duration-500 ease-in-out"
                         :style="`transform: translateX(-${currentSlide * 100}%)`">

                        <!-- Slide 1 -->
                        <div class="w-full flex-shrink-0">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <!-- Book 1 -->
                                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow group">
                                    <div class="aspect-[3/4] bg-gradient-to-br from-blue-400 to-blue-600 relative overflow-hidden">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="text-white text-center p-4">
                                                <i class="fas fa-book text-4xl mb-2"></i>
                                                <div class="font-bold text-lg">L'Art du Code</div>
                                                <div class="text-sm opacity-80">par Jean Dupont</div>
                                            </div>
                                        </div>
                                        <div class="absolute top-2 right-2 bg-yellow-400 text-gray-900 px-2 py-1 rounded-full text-xs font-bold">
                                            ⭐ 4.8
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">L'Art du Code</h3>
                                        <p class="text-gray-600 text-sm mb-3">Un guide complet pour maîtriser l'art de la programmation moderne...</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-indigo-600 font-semibold">Gratuit</span>
                                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-sm transition-colors">
                                                Lire
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Book 2 -->
                                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow group">
                                    <div class="aspect-[3/4] bg-gradient-to-br from-green-400 to-green-600 relative overflow-hidden">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="text-white text-center p-4">
                                                <i class="fas fa-leaf text-4xl mb-2"></i>
                                                <div class="font-bold text-lg">Écologie Moderne</div>
                                                <div class="text-sm opacity-80">par Marie Martin</div>
                                            </div>
                                        </div>
                                        <div class="absolute top-2 right-2 bg-yellow-400 text-gray-900 px-2 py-1 rounded-full text-xs font-bold">
                                            ⭐ 4.9
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">Écologie Moderne</h3>
                                        <p class="text-gray-600 text-sm mb-3">Comprendre les enjeux environnementaux du 21ème siècle...</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-indigo-600 font-semibold">Gratuit</span>
                                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-sm transition-colors">
                                                Lire
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Book 3 -->
                                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow group">
                                    <div class="aspect-[3/4] bg-gradient-to-br from-purple-400 to-purple-600 relative overflow-hidden">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="text-white text-center p-4">
                                                <i class="fas fa-brain text-4xl mb-2"></i>
                                                <div class="font-bold text-lg">Psychologie</div>
                                                <div class="text-sm opacity-80">par Dr. Sophie</div>
                                            </div>
                                        </div>
                                        <div class="absolute top-2 right-2 bg-yellow-400 text-gray-900 px-2 py-1 rounded-full text-xs font-bold">
                                            ⭐ 4.7
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">Psychologie Positive</h3>
                                        <p class="text-gray-600 text-sm mb-3">Les clés du bien-être mental et de l'épanouissement personnel...</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-indigo-600 font-semibold">Gratuit</span>
                                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-sm transition-colors">
                                                Lire
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Book 4 -->
                                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow group">
                                    <div class="aspect-[3/4] bg-gradient-to-br from-red-400 to-red-600 relative overflow-hidden">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="text-white text-center p-4">
                                                <i class="fas fa-rocket text-4xl mb-2"></i>
                                                <div class="font-bold text-lg">Innovation</div>
                                                <div class="text-sm opacity-80">par Alex Tech</div>
                                            </div>
                                        </div>
                                        <div class="absolute top-2 right-2 bg-yellow-400 text-gray-900 px-2 py-1 rounded-full text-xs font-bold">
                                            ⭐ 4.6
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">Innovation Digitale</h3>
                                        <p class="text-gray-600 text-sm mb-3">Comment les technologies transforment notre société...</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-indigo-600 font-semibold">Gratuit</span>
                                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-sm transition-colors">
                                                Lire
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button @click="currentSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1"
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white shadow-lg rounded-full p-3 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                <button @click="currentSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white shadow-lg rounded-full p-3 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>

                <!-- Dots Indicator -->
                <div class="flex justify-center mt-8 space-x-2">
                    <template x-for="i in totalSlides" :key="i">
                        <button @click="currentSlide = i - 1"
                                :class="currentSlide === i - 1 ? 'bg-indigo-600' : 'bg-gray-300'"
                                class="w-3 h-3 rounded-full transition-colors"></button>
                    </template>
                </div>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-12">
                <a href="{{ route('books.public.index') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-2xl font-semibold text-lg transition-colors shadow-lg">
                    <i class="fas fa-book-open mr-2"></i>
                    Voir Tous les Livres
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="temoignages" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Ce Que Disent Nos Utilisateurs
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Rejoignez des milliers d'utilisateurs satisfaits qui ont transformé leur expérience de lecture
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 relative">
                    <div class="absolute top-4 left-4 text-indigo-200">
                        <i class="fas fa-quote-left text-3xl"></i>
                    </div>
                    <div class="pt-8">
                        <p class="text-gray-700 mb-6 italic">
                            "E-Library a révolutionné ma façon de lire. L'interface est intuitive et la qualité des livres exceptionnelle. Je recommande vivement !"
                        </p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                SM
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">Sophie Martin</div>
                                <div class="text-gray-600 text-sm">Lectrice passionnée</div>
                                <div class="flex text-yellow-400 text-sm mt-1">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 relative">
                    <div class="absolute top-4 left-4 text-green-200">
                        <i class="fas fa-quote-left text-3xl"></i>
                    </div>
                    <div class="pt-8">
                        <p class="text-gray-700 mb-6 italic">
                            "En tant qu'auteur, publier mes livres sur E-Library a été un jeu d'enfant. Les outils d'analytics m'aident à comprendre mon audience."
                        </p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold">
                                JD
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">Jean Dubois</div>
                                <div class="text-gray-600 text-sm">Auteur publié</div>
                                <div class="flex text-yellow-400 text-sm mt-1">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-2xl p-8 relative">
                    <div class="absolute top-4 left-4 text-purple-200">
                        <i class="fas fa-quote-left text-3xl"></i>
                    </div>
                    <div class="pt-8">
                        <p class="text-gray-700 mb-6 italic">
                            "La fonction de recherche est incroyable ! Je trouve toujours exactement ce que je cherche. La synchronisation entre appareils est parfaite."
                        </p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                AL
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">Alice Leroy</div>
                                <div class="text-gray-600 text-sm">Étudiante en littérature</div>
                                <div class="flex text-yellow-400 text-sm mt-1">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-bg relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">
                Prêt à Commencer Votre Aventure Littéraire ?
            </h2>
            <p class="text-xl text-white text-opacity-90 mb-8 max-w-3xl mx-auto">
                Rejoignez notre communauté de passionnés et découvrez un monde de connaissances à portée de clic
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                @guest
                    <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>
                        Créer un Compte Gratuit
                    </a>
                    <a href="{{ route('books.public.index') }}" class="glass-effect text-white px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-white hover:bg-opacity-20 transition-colors border border-white border-opacity-30">
                        <i class="fas fa-book-open mr-2"></i>
                        Explorer Sans Compte
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Accéder au Dashboard
                    </a>
                @endguest
            </div>

            <!-- Features List -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-infinity text-white text-2xl"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Accès Illimité</h3>
                    <p class="text-white text-opacity-80 text-sm">Lisez autant que vous voulez, quand vous voulez</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">100% Gratuit</h3>
                    <p class="text-white text-opacity-80 text-sm">Aucun frais caché, aucun abonnement requis</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Communauté</h3>
                    <p class="text-white text-opacity-80 text-sm">Rejoignez des milliers de lecteurs passionnés</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="a-propos" class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center mb-6">
                        @if(site_logo())
                            <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-12 w-auto">
                        @else
                            <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book-open text-white text-xl"></i>
                            </div>
                        @endif
                        <span class="ml-3 text-2xl font-bold">{{ site_name() }}</span>
                    </div>
                    <p class="text-gray-300 mb-6 max-w-md">
                        {{ site_setting('footer_description', site_name() . ' révolutionne l\'accès à la connaissance en offrant une plateforme moderne, intuitive et accessible pour la lecture et la publication de livres numériques.') }}
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-6">Liens Rapides</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('books.public.index') }}" class="text-gray-300 hover:text-white transition-colors">Bibliothèque</a></li>
                        <li><a href="{{ route('books.search') }}" class="text-gray-300 hover:text-white transition-colors">Recherche</a></li>
                        <li><a href="{{ route('books.categories') }}" class="text-gray-300 hover:text-white transition-colors">Catégories</a></li>
                        <li><a href="{{ route('authors.index') }}" class="text-gray-300 hover:text-white transition-colors">Auteurs</a></li>
                        @auth
                            <li><a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-white transition-colors">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors">Connexion</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition-colors">Inscription</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-lg font-semibold mb-6">Support</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Signaler un problème</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Conditions d'utilisation</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} {{ site_name() }}. {{ site_setting('copyright_text', 'Tous droits réservés.') }}
                </p>
                <div class="flex items-center space-x-6 mt-4 md:mt-0">
                    <span class="text-gray-400 text-sm">{{ site_setting('footer_tagline', 'Fait avec ❤️ pour les amoureux des livres') }}</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scrollToTop" class="fixed bottom-8 right-8 bg-indigo-600 hover:bg-indigo-700 text-white w-12 h-12 rounded-full shadow-lg transition-all duration-300 opacity-0 invisible" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>


</body>
</html>
