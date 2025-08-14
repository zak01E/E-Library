<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $author->name }} - Profil Auteur - {{ site_name() }}</title>
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

    <!-- Author Hero Section -->
    <section class="relative py-20 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute inset-0">
            <div class="absolute transform rotate-45 -right-40 -top-40 w-80 h-80 bg-white opacity-5 rounded-full"></div>
            <div class="absolute transform rotate-45 -left-40 -bottom-40 w-80 h-80 bg-white opacity-5 rounded-full"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <!-- Author Avatar -->
                <div class="relative">
                    <img class="w-40 h-40 rounded-full border-4 border-white shadow-2xl" 
                         src="https://ui-avatars.com/api/?name={{ urlencode($author->name) }}&background=10b981&color=fff&size=300" 
                         alt="{{ $author->name }}">
                    @if($stats['total_books'] > 20)
                    <span class="absolute bottom-0 right-0 bg-amber-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                        <i class="fas fa-star mr-1"></i>Vedette
                    </span>
                    @endif
                </div>

                <!-- Author Info -->
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-3">{{ $author->name }}</h1>
                    <p class="text-xl text-emerald-100 mb-4">
                        {{ $author->author_bio ?: 'Auteur passionné partageant ses connaissances' }}
                    </p>
                    
                    <!-- Stats -->
                    <div class="flex flex-wrap gap-6 justify-center md:justify-start mb-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">{{ $stats['total_books'] }}</div>
                            <div class="text-emerald-200 text-sm">Livres publiés</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">{{ number_format($stats['total_views']) }}</div>
                            <div class="text-emerald-200 text-sm">Vues totales</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">{{ number_format($stats['total_downloads']) }}</div>
                            <div class="text-emerald-200 text-sm">Téléchargements</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                        <button class="bg-white text-emerald-600 px-6 py-3 rounded-lg font-semibold hover:bg-emerald-50 transition-colors shadow-lg">
                            <i class="fas fa-heart mr-2"></i>Suivre l'auteur
                        </button>
                        <button class="bg-emerald-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-emerald-800 transition-colors shadow-lg">
                            <i class="fas fa-share-alt mr-2"></i>Partager
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats Bar -->
    <section class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar text-gray-400"></i>
                        <span class="text-sm text-gray-600">Membre depuis {{ $stats['member_since']->format('F Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= 4)
                                    <i class="fas fa-star text-sm"></i>
                                @else
                                    <i class="fas fa-star-half-alt text-sm"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600">4.5/5 ({{ rand(100, 999) }} avis)</span>
                    </div>
                </div>
                <div class="flex gap-3">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500">
                        <option>Tous les livres</option>
                        <option>Plus récents</option>
                        <option>Plus populaires</option>
                        <option>Mieux notés</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8">
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- About Author -->
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-emerald-600 mr-2"></i>À propos
                        </h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">
                            {{ $author->author_bio ?: 'Cet auteur n\'a pas encore ajouté de biographie. Découvrez ses œuvres pour en apprendre plus sur son style et ses thématiques.' }}
                        </p>
                        @if($author->specialties)
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $author->specialties) as $specialty)
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">
                                {{ trim($specialty) }}
                            </span>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <!-- Popular Books -->
                    @if($popularBooks->count() > 0)
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-fire text-orange-500 mr-2"></i>Livres populaires
                        </h3>
                        <div class="space-y-3">
                            @foreach($popularBooks as $book)
                            <a href="{{ route('books.public.show', $book->id) }}" class="flex items-center gap-3 hover:bg-gray-50 p-2 rounded-lg transition-colors">
                                <div class="w-12 h-16 bg-emerald-100 rounded flex items-center justify-center">
                                    <i class="fas fa-book text-emerald-600"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 text-sm line-clamp-1">{{ $book->title }}</h4>
                                    <p class="text-xs text-gray-500">{{ number_format($book->views) }} vues</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Recent Activity -->
                    @if($recentBooks->count() > 0)
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-clock text-blue-500 mr-2"></i>Publications récentes
                        </h3>
                        <div class="space-y-3">
                            @foreach($recentBooks as $book)
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-700">{{ $book->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $book->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Books Grid -->
                <div class="lg:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Tous les livres ({{ $books->total() }})</h2>
                    
                    @if($books->count() > 0)
                        <div class="grid md:grid-cols-2 gap-6">
                            @foreach($books as $book)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                                <!-- Book Cover -->
                                <div class="h-48 bg-gradient-to-br from-emerald-400 to-teal-500 relative">
                                    @if($book->cover_image)
                                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full">
                                            <i class="fas fa-book text-white text-6xl opacity-50"></i>
                                        </div>
                                    @endif
                                    @if($book->is_featured)
                                    <span class="absolute top-3 right-3 bg-amber-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                        <i class="fas fa-star mr-1"></i>Vedette
                                    </span>
                                    @endif
                                </div>

                                <!-- Book Info -->
                                <div class="p-5">
                                    <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">{{ $book->title }}</h3>
                                    
                                    @if($book->category)
                                    <span class="inline-block px-2 py-1 bg-emerald-100 text-emerald-700 rounded text-xs font-medium mb-3">
                                        {{ is_object($book->category) ? $book->category->name : $book->category }}
                                    </span>
                                    @endif

                                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                        {{ $book->description ?: 'Aucune description disponible.' }}
                                    </p>

                                    <!-- Book Stats -->
                                    <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                        <span><i class="fas fa-eye mr-1"></i>{{ number_format($book->views) }} vues</span>
                                        <span><i class="fas fa-download mr-1"></i>{{ number_format($book->downloads) }}</span>
                                        <span><i class="fas fa-file-alt mr-1"></i>{{ $book->pages ?? 'N/A' }} pages</span>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-2">
                                        <a href="{{ route('books.public.show', $book->id) }}" 
                                           class="flex-1 text-center bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg font-medium text-sm transition-colors">
                                            <i class="fas fa-book-open mr-1"></i>Lire
                                        </a>
                                        <button class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                            <i class="far fa-heart text-gray-400"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $books->links('pagination::tailwind') }}
                        </div>
                    @else
                        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                            <i class="fas fa-book text-gray-300 text-6xl mb-4"></i>
                            <p class="text-gray-500">Cet auteur n'a pas encore publié de livres.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-white font-bold mb-4">E-Library</h3>
                    <p class="text-sm">La bibliothèque numérique de l'excellence éducative.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Navigation</h4>
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