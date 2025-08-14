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
    </style>
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ mobileMenuOpen: false }">

    @include('partials.public-header')

    <!-- Hero Section -->
    <section class="relative py-20 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute inset-0">
            <div class="absolute transform rotate-45 -right-40 -top-40 w-80 h-80 bg-white opacity-5 rounded-full"></div>
            <div class="absolute transform rotate-45 -left-40 -bottom-40 w-80 h-80 bg-white opacity-5 rounded-full"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                Découvrez nos <span class="text-emerald-200">Auteurs</span>
            </h1>
            <p class="text-xl text-emerald-100 max-w-2xl mx-auto mb-8">
                Plus de 1,200 auteurs talentueux partagent leur savoir et leur passion
            </p>
            
            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto">
                <form action="{{ route('authors.index') }}" method="GET" class="relative">
                    <input type="text" 
                           name="search" 
                           placeholder="Rechercher un auteur, une spécialité..."
                           class="w-full px-6 py-4 pr-12 rounded-full text-gray-900 placeholder-gray-500 bg-white shadow-xl focus:outline-none focus:ring-4 focus:ring-emerald-300 transition-all">
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-emerald-600 hover:bg-emerald-700 text-white p-3 rounded-full transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="py-8 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap gap-3">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option>Toutes les spécialités</option>
                        <option>Fiction</option>
                        <option>Science</option>
                        <option>Technologie</option>
                        <option>Histoire</option>
                        <option>Philosophie</option>
                        <option>Économie</option>
                    </select>
                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option>Trier par : Popularité</option>
                        <option>Nom (A-Z)</option>
                        <option>Nom (Z-A)</option>
                        <option>Nombre de livres</option>
                        <option>Note moyenne</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <button class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-th-large text-gray-600"></i>
                    </button>
                    <button class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-list text-gray-600"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Authors Grid -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($authors as $author)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <!-- Card Header with gradient -->
                    <div class="h-24 bg-gradient-to-br from-emerald-400 via-emerald-500 to-teal-500 relative">
                        @if($author->approved_books_count > 20)
                        <span class="absolute top-3 right-3 px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">
                            Vedette
                        </span>
                        @elseif($author->approved_books_count > 10)
                        <span class="absolute top-3 right-3 px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                            Top auteur
                        </span>
                        @elseif($author->created_at->diffInDays(now()) < 30)
                        <span class="absolute top-3 right-3 px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            Nouveau
                        </span>
                        @endif
                        <!-- Avatar -->
                        <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                            <img class="w-20 h-20 rounded-full border-4 border-white shadow-lg" 
                                 src="https://ui-avatars.com/api/?name={{ urlencode($author->name) }}&background=10b981&color=fff&size=200" 
                                 alt="{{ $author->name }}">
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="pt-12 pb-6 px-6">
                        <!-- Author Info -->
                        <div class="text-center mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $author->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $author->author_bio ? Str::limit($author->author_bio, 30) : 'Auteur' }}</p>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            <div class="text-center">
                                <div class="text-lg font-bold text-gray-900">{{ $author->approved_books_count }}</div>
                                <div class="text-xs text-gray-500">Livres</div>
                            </div>
                            <div class="text-center border-x border-gray-200">
                                <div class="text-lg font-bold text-gray-900">{{ $author->total_views > 1000 ? number_format($author->total_views / 1000, 1) . 'k' : $author->total_views }}</div>
                                <div class="text-xs text-gray-500">Lecteurs</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-gray-900">{{ number_format($author->average_rating, 1) }}</div>
                                <div class="text-xs text-gray-500">Note</div>
                            </div>
                        </div>

                        <!-- Rating Stars -->
                        <div class="flex items-center justify-center mb-4">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($author->average_rating))
                                        <i class="fas fa-star text-sm"></i>
                                    @elseif($i - 0.5 <= $author->average_rating)
                                        <i class="fas fa-star-half-alt text-sm"></i>
                                    @else
                                        <i class="far fa-star text-sm"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 ml-2">({{ rand(10, 500) }} avis)</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('authors.show', $author->id) }}" 
                               class="flex-1 text-center bg-emerald-600 hover:bg-emerald-700 text-white py-2 px-4 rounded-lg font-medium text-sm transition-colors">
                                Voir profil
                            </a>
                            <button class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors group">
                                <i class="far fa-heart text-gray-400 group-hover:text-red-500 transition-colors"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-600">
                    Affichage de <span class="font-semibold">{{ $authors->firstItem() }}</span> à <span class="font-semibold">{{ $authors->lastItem() }}</span> sur <span class="font-semibold">{{ $authors->total() }}</span> auteurs
                </div>
                {{ $authors->links('pagination::tailwind') }}
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-br from-emerald-600 to-teal-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">
                Vous êtes auteur ?
            </h2>
            <p class="text-xl text-emerald-100 mb-8">
                Rejoignez notre communauté d'auteurs et partagez votre savoir avec des milliers de lecteurs
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('author.login') }}" 
                   class="inline-block px-8 py-3 bg-white text-emerald-600 rounded-lg font-semibold hover:bg-emerald-50 transition-colors shadow-lg">
                    Espace Auteur
                </a>
                <a href="#" 
                   class="inline-block px-8 py-3 bg-emerald-700 text-white rounded-lg font-semibold hover:bg-emerald-800 transition-colors shadow-lg">
                    En savoir plus
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-white font-bold mb-4">E-Library</h3>
                    <p class="text-sm">La bibliothèque numérique de l'excellence éducative.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Liens rapides</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/" class="hover:text-white transition">Accueil</a></li>
                        <li><a href="{{ route('books.search') }}" class="hover:text-white transition">Bibliothèque</a></li>
                        <li><a href="{{ route('authors.index') }}" class="hover:text-white transition">Auteurs</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Aide</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Suivez-nous</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-white transition"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="hover:text-white transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-white transition"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="hover:text-white transition"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-sm">
                <p>&copy; {{ date('Y') }} E-Library. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

</body>
</html>