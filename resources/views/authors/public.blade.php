<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Auteurs - {{ site_name() }}</title>
    <link rel="icon" type="image/x-icon" href="{{ site_favicon() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #14b8a6 50%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .author-card {
            animation: fadeInUp 0.5s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ mobileMenuOpen: false }">

    @include('partials.public-header')

    <!-- Hero Section -->
    <section class="relative py-16 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Découvrez nos <span class="text-emerald-200">Auteurs</span>
                </h1>
                <p class="text-xl text-emerald-100 max-w-2xl mx-auto">
                    Plus de 1,200 auteurs talentueux partagent leur savoir et leur passion
                </p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12 max-w-4xl mx-auto">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="text-3xl font-bold text-white">1,247</div>
                    <div class="text-sm text-emerald-100">Auteurs</div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="text-3xl font-bold text-white">892</div>
                    <div class="text-sm text-emerald-100">Actifs</div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="text-3xl font-bold text-white">47</div>
                    <div class="text-sm text-emerald-100">Vedettes</div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="text-3xl font-bold text-white">23K+</div>
                    <div class="text-sm text-emerald-100">Livres publiés</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-2">
                    <button class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                        Tous
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                        Fiction
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                        Science
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                        Technologie
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                        Histoire
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                        Philosophie
                    </button>
                </div>

                <!-- Search -->
                <div class="relative w-full lg:w-auto">
                    <input type="text" placeholder="Rechercher un auteur..." 
                           class="w-full lg:w-80 pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Authors Grid -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Featured Authors -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-crown text-yellow-500 mr-3"></i>
                    Auteurs Vedettes
                </h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Featured Author 1 -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 author-card card-hover border border-gray-100">
                        <div class="h-32 bg-gradient-to-br from-emerald-400 to-teal-500 relative">
                            <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2">
                                <img class="w-24 h-24 rounded-full border-4 border-white shadow-lg" 
                                     src="https://ui-avatars.com/api/?name=Marie+Dubois&background=10b981&color=fff&size=200" 
                                     alt="Marie Dubois">
                            </div>
                        </div>
                        <div class="pt-14 pb-6 px-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">Marie Dubois</h3>
                            <p class="text-emerald-600 font-medium mb-3">Spécialiste IA</p>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                Experte en intelligence artificielle avec plus de 15 ans d'expérience dans le domaine.
                            </p>
                            
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-900">23</div>
                                    <div class="text-xs text-gray-500">Livres</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-900">12.4k</div>
                                    <div class="text-xs text-gray-500">Lecteurs</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-900">4.8</div>
                                    <div class="text-xs text-gray-500">Note</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-center mb-4">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-500 ml-2">(234 avis)</span>
                            </div>
                            
                            <a href="#" class="block w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white py-2 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                                Voir le profil
                            </a>
                        </div>
                    </div>

                    <!-- Featured Author 2 -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 author-card card-hover border border-gray-100">
                        <div class="h-32 bg-gradient-to-br from-teal-400 to-emerald-500 relative">
                            <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2">
                                <img class="w-24 h-24 rounded-full border-4 border-white shadow-lg" 
                                     src="https://ui-avatars.com/api/?name=Pierre+Durand&background=14b8a6&color=fff&size=200" 
                                     alt="Pierre Durand">
                            </div>
                        </div>
                        <div class="pt-14 pb-6 px-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">Pierre Durand</h3>
                            <p class="text-teal-600 font-medium mb-3">Scientifique</p>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                Professeur de physique quantique et vulgarisateur scientifique reconnu.
                            </p>
                            
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-900">31</div>
                                    <div class="text-xs text-gray-500">Livres</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-900">18.9k</div>
                                    <div class="text-xs text-gray-500">Lecteurs</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-900">4.7</div>
                                    <div class="text-xs text-gray-500">Note</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-center mb-4">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-sm text-gray-500 ml-2">(389 avis)</span>
                            </div>
                            
                            <a href="#" class="block w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white py-2 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                                Voir le profil
                            </a>
                        </div>
                    </div>

                    <!-- Featured Author 3 -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 author-card card-hover border border-gray-100">
                        <div class="h-32 bg-gradient-to-br from-emerald-500 to-teal-600 relative">
                            <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2">
                                <img class="w-24 h-24 rounded-full border-4 border-white shadow-lg" 
                                     src="https://ui-avatars.com/api/?name=Sophie+Laurent&background=0d9488&color=fff&size=200" 
                                     alt="Sophie Laurent">
                            </div>
                        </div>
                        <div class="pt-14 pb-6 px-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">Sophie Laurent</h3>
                            <p class="text-emerald-600 font-medium mb-3">Romancière</p>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                Auteure à succès de romans historiques et contemporains primés.
                            </p>
                            
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-900">15</div>
                                    <div class="text-xs text-gray-500">Livres</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-900">25.3k</div>
                                    <div class="text-xs text-gray-500">Lecteurs</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-900">4.9</div>
                                    <div class="text-xs text-gray-500">Note</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-center mb-4">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-500 ml-2">(567 avis)</span>
                            </div>
                            
                            <a href="#" class="block w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white py-2 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                                Voir le profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- All Authors -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Tous nos Auteurs</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $authors = [
                            ['name' => 'Jean Martin', 'specialty' => 'Historien', 'books' => 18, 'rating' => 4.6],
                            ['name' => 'Anne Moreau', 'specialty' => 'Philosophe', 'books' => 12, 'rating' => 4.5],
                            ['name' => 'Thomas Bernard', 'specialty' => 'Développeur', 'books' => 7, 'rating' => 4.3],
                            ['name' => 'Emma Wilson', 'specialty' => 'Biologiste', 'books' => 9, 'rating' => 4.7],
                            ['name' => 'Lucas Petit', 'specialty' => 'Économiste', 'books' => 14, 'rating' => 4.4],
                            ['name' => 'Léa Rousseau', 'specialty' => 'Journaliste', 'books' => 21, 'rating' => 4.8],
                            ['name' => 'Hugo Martin', 'specialty' => 'Architecte', 'books' => 5, 'rating' => 4.2],
                            ['name' => 'Chloé Dubois', 'specialty' => 'Psychologue', 'books' => 11, 'rating' => 4.6],
                        ];
                    @endphp

                    @foreach($authors as $author)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 author-card card-hover border border-gray-100">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <img class="w-12 h-12 rounded-full mr-3" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode($author['name']) }}&background=10b981&color=fff" 
                                     alt="{{ $author['name'] }}">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $author['name'] }}</h3>
                                    <p class="text-sm text-gray-500">{{ $author['specialty'] }}</p>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm text-gray-600">
                                    <i class="fas fa-book mr-1 text-emerald-500"></i>
                                    {{ $author['books'] }} livres
                                </span>
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                                    <span class="text-sm text-gray-600 ml-1">{{ $author['rating'] }}</span>
                                </div>
                            </div>
                            
                            <a href="#" class="block w-full text-center bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white py-2 rounded-lg text-sm font-medium transition-all duration-200">
                                Voir profil
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between mt-12">
                <div class="text-sm text-gray-700">
                    Affichage de <span class="font-medium">1</span> à <span class="font-medium">12</span> sur <span class="font-medium">1,247</span> auteurs
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-4 py-2 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Précédent
                    </button>
                    <button class="px-3 py-2 text-sm bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-lg">1</button>
                    <button class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">2</button>
                    <button class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">3</button>
                    <span class="px-2 text-gray-500">...</span>
                    <button class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">104</button>
                    <button class="px-4 py-2 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Suivant
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-emerald-600 to-teal-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Devenez Auteur</h2>
            <p class="text-xl opacity-90 mb-8">
                Partagez votre savoir et rejoignez notre communauté d'auteurs passionnés
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/auth/author-login" class="px-8 py-3 bg-white text-emerald-600 rounded-lg font-semibold hover:bg-emerald-50 transition-all duration-200 shadow-md hover:shadow-xl">
                    <i class="fas fa-pen-fancy mr-2"></i>Commencer à écrire
                </a>
                <button class="px-8 py-3 bg-teal-500 text-white rounded-lg font-semibold hover:bg-teal-400 transition-all duration-200">
                    <i class="fas fa-info-circle mr-2"></i>En savoir plus
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} {{ site_name() }} - Tous droits réservés</p>
        </div>
    </footer>

    <script>
        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.author-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });
    </script>
</body>
</html>