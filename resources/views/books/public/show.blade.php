<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} - {{ site_name() }}</title>
    <link rel="icon" type="image/x-icon" href="{{ site_favicon() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .book-shadow {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);
        }
        
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .book-cover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .book-cover:hover {
            transform: translateY(-5px);
        }

        .stats-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .action-button {
            transition: all 0.3s ease;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* PDF Preview Styles */
        #previewModal {
            backdrop-filter: blur(5px);
        }

        #pdfViewer {
            border-radius: 0 0 12px 12px;
        }

        /* Disable text selection in preview */
        #previewModal .pointer-events-none {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* PDF Container Scrolling */
        #pdfPreviewContainer {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        #pdfPreviewContainer::-webkit-scrollbar {
            width: 8px;
        }

        #pdfPreviewContainer::-webkit-scrollbar-track {
            background: #f7fafc;
        }

        #pdfPreviewContainer::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }

        #pdfPreviewContainer::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* PDF Canvas Container */
        .pdf-canvas-container {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        .pdf-canvas-container::-webkit-scrollbar {
            width: 8px;
        }

        .pdf-canvas-container::-webkit-scrollbar-track {
            background: #f7fafc;
        }

        .pdf-canvas-container::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }

        .pdf-canvas-container::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Loading animation for PDF */
        .pdf-loading {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 overflow-x-hidden" x-data="{ mobileMenuOpen: false }">
    @include('partials.public-header')

    <!-- Hero Section with Book Details -->
    <section class="relative py-16 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-medium text-emerald-200 hover:text-white transition-colors">
                            <i class="fas fa-home mr-1"></i>Accueil
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-emerald-300 mx-1"></i>
                            <a href="{{ route('books.public.index') }}" class="text-xs font-medium text-emerald-200 hover:text-white transition-colors">Bibliothèque</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-emerald-300 mx-1"></i>
                            <span class="text-xs font-medium text-emerald-100">{{ Str::limit($book->title, 25) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Main Content -->
            <div class="flex flex-col lg:flex-row gap-8 items-center lg:items-start">
                <!-- Book Cover -->
                <div class="flex-shrink-0 mb-6 lg:mb-0">
                    <div class="relative">
                        @if($book->cover_image)
                            <img src="{{ Storage::url($book->cover_image) }}"
                                 alt="{{ $book->title }}"
                                 class="w-64 h-80 object-cover rounded-xl shadow-xl card-hover">
                        @else
                            <div class="w-64 h-80 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow-xl flex items-center justify-center card-hover">
                                <div class="text-center text-white p-4 max-w-full">
                                    <i class="fas fa-book text-4xl mb-3"></i>
                                    <div class="font-bold text-sm leading-tight break-words line-clamp-4">{{ Str::limit($book->title, 40) }}</div>
                                </div>
                            </div>
                        @endif

                        <!-- Floating Stats (Style subtil) -->
                        <div class="absolute bottom-2 right-2 flex gap-2">
                            <div class="bg-emerald-500/20 backdrop-blur-sm rounded-md px-2 py-1 opacity-85 hover:opacity-100 transition-opacity">
                                <div class="flex items-center gap-1">
                                    <i class="fas fa-eye text-emerald-600" style="font-size: 10px;"></i>
                                    <span class="text-emerald-700 text-xs font-medium">{{ number_format($book->views, 0, '', ' ') }}</span>
                                </div>
                            </div>
                            <div class="bg-teal-500/20 backdrop-blur-sm rounded-md px-2 py-1 opacity-85 hover:opacity-100 transition-opacity">
                                <div class="flex items-center gap-1">
                                    <i class="fas fa-download text-teal-600" style="font-size: 10px;"></i>
                                    <span class="text-teal-700 text-xs font-medium">{{ number_format($book->downloads, 0, '', ' ') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book Info -->
                <div class="text-white flex-1 lg:max-w-lg">
                    <div class="mb-4">
                        <h1 class="text-2xl lg:text-3xl font-heading font-bold mb-3">{{ $book->title }}</h1>
                        <div class="flex items-center text-base text-emerald-200 mb-3">
                            <i class="fas fa-user mr-2"></i>
                            <span>{{ $book->uploader->name }}</span>
                        </div>

                        @php
                            // Définir les couleurs et icônes pour les niveaux
                            $levelColors = [
                                'primaire' => 'bg-blue-500/20 border-blue-400/30 text-blue-100',
                                'college' => 'bg-purple-500/20 border-purple-400/30 text-purple-100',
                                'lycee' => 'bg-orange-500/20 border-orange-400/30 text-orange-100',
                                'superieur' => 'bg-red-500/20 border-red-400/30 text-red-100',
                                'professionnel' => 'bg-indigo-500/20 border-indigo-400/30 text-indigo-100'
                            ];
                            $levelIcons = [
                                'primaire' => 'fa-child',
                                'college' => 'fa-school',
                                'lycee' => 'fa-graduation-cap',
                                'superieur' => 'fa-university',
                                'professionnel' => 'fa-briefcase'
                            ];
                            
                            // Éviter la redondance
                            $redundantCategories = ['Primaire', 'Collège', 'Lycée', 'Supérieur', 'Professionnel'];
                            $showCategory = $book->category && !in_array($book->category, $redundantCategories) && 
                                           strtolower($book->category) !== $book->level;
                        @endphp
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if($book->level)
                                @php
                                    $levelColor = $levelColors[$book->level] ?? 'bg-gray-500/20 border-gray-400/30 text-gray-100';
                                    $levelIcon = $levelIcons[$book->level] ?? 'fa-book';
                                @endphp
                                <div class="inline-flex items-center {{ $levelColor }} rounded-full px-3 py-1 text-sm font-semibold border">
                                    <i class="fas {{ $levelIcon }} mr-1.5"></i>
                                    Niveau {{ ucfirst($book->level) }}
                                </div>
                            @endif
                            
                            @if($showCategory)
                                <div class="inline-flex items-center bg-emerald-500/20 rounded-full px-3 py-1 text-sm font-medium border border-emerald-400/30">
                                    <i class="fas fa-tag mr-1"></i>
                                    {{ $book->category }}
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($book->description)
                        <div class="text-emerald-100 mb-6 leading-relaxed text-sm">
                            <p>{{ auth()->check() ? $book->description : Str::limit($book->description, 200) }}</p>
                        </div>
                    @endif

                    @guest
                        <!-- Info for non-authenticated users -->
                        <div class="bg-emerald-500/20 border border-emerald-400/30 rounded-lg p-4 mb-6">
                            <div class="flex items-center text-emerald-100">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span class="text-sm">
                                    <strong>Aperçu limité :</strong> Connectez-vous pour accéder au contenu complet et télécharger ce livre gratuitement.
                                </span>
                            </div>
                        </div>
                    @endguest

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 mb-6">
                        @auth
                            @if($book->pdf_path)
                                <a href="{{ route('books.public.download', $book) }}"
                                   class="bg-white text-emerald-600 px-6 py-3 rounded-xl font-semibold text-base transition-all duration-300 hover:bg-emerald-50 shadow-md hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center">
                                    <i class="fas fa-download mr-2"></i>
                                    Télécharger Gratuitement
                                </a>
                            @endif

                            <button class="bg-emerald-500/20 text-white px-6 py-3 rounded-xl font-semibold text-base hover:bg-emerald-500/30 transition-all duration-300 border border-emerald-400/30 flex items-center justify-center">
                                <i class="fas fa-heart mr-2"></i>
                                Favoris
                            </button>
                        @else
                            <button onclick="showPreview()" class="bg-white text-emerald-600 px-6 py-3 rounded-xl font-semibold text-base transition-all duration-300 hover:bg-emerald-50 shadow-md hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center">
                                <i class="fas fa-eye mr-2"></i>
                                Aperçu Gratuit
                            </button>

                            <a href="{{ route('login') }}" class="bg-emerald-500/20 text-white px-6 py-3 rounded-xl font-semibold text-base hover:bg-emerald-500/30 transition-all duration-300 border border-emerald-400/30 flex items-center justify-center">
                                <i class="fas fa-lock mr-2"></i>
                                Se connecter pour télécharger
                            </a>
                        @endauth
                    </div>

                    <!-- Book Details -->
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        @if($book->author_name)
                            <div class="flex flex-col">
                                <span class="text-emerald-200 text-xs uppercase tracking-wide mb-1">Auteur</span>
                                <span class="text-white font-medium">{{ $book->author_name }}</span>
                            </div>
                        @endif

                        @if($book->publication_year)
                            <div class="flex flex-col">
                                <span class="text-emerald-200 text-xs uppercase tracking-wide mb-1">Année</span>
                                <span class="text-white font-medium">{{ $book->publication_year }}</span>
                            </div>
                        @endif

                        @if($book->language)
                            <div class="flex flex-col">
                                <span class="text-emerald-200 text-xs uppercase tracking-wide mb-1">Langue</span>
                                @php
                                    $langNames = [
                                        'fr' => 'Français',
                                        'en' => 'Anglais',
                                        'es' => 'Espagnol',
                                        'de' => 'Allemand',
                                        'it' => 'Italien',
                                        'pt' => 'Portugais',
                                        'ar' => 'Arabe',
                                        'zh' => 'Chinois',
                                        'ja' => 'Japonais',
                                        'ru' => 'Russe',
                                        'ko' => 'Coréen',
                                        'hi' => 'Hindi'
                                    ];
                                    $langDisplay = $langNames[$book->language] ?? strtoupper($book->language);
                                @endphp
                                <span class="text-white font-medium">{{ $langDisplay }}</span>
                            </div>
                        @endif

                        @if($book->pages)
                            <div class="flex flex-col">
                                <span class="text-emerald-200 text-xs uppercase tracking-wide mb-1">Pages</span>
                                <span class="text-white font-medium">{{ $book->pages }}</span>
                            </div>
                        @endif

                        @if($book->level)
                            <div class="flex flex-col">
                                <span class="text-emerald-200 text-xs uppercase tracking-wide mb-1">Niveau</span>
                                <span class="text-white font-medium">{{ ucfirst($book->level) }}</span>
                            </div>
                        @endif

                        @if($showCategory)
                            <div class="flex flex-col">
                                <span class="text-emerald-200 text-xs uppercase tracking-wide mb-1">Catégorie</span>
                                <span class="text-white font-medium">{{ $book->category }}</span>
                            </div>
                        @endif

                        @if($book->isbn)
                            <div class="flex flex-col">
                                <span class="text-emerald-200 text-xs uppercase tracking-wide mb-1">ISBN</span>
                                <span class="text-white font-medium">{{ $book->isbn }}</span>
                            </div>
                        @endif

                        @if($book->publisher)
                            <div class="flex flex-col">
                                <span class="text-emerald-200 text-xs uppercase tracking-wide mb-1">Éditeur</span>
                                <span class="text-white font-medium">{{ $book->publisher }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Similar Books Section -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-heading font-bold text-gray-900 mb-3">
                    Livres Similaires
                </h2>
                <p class="text-base text-gray-600 max-w-xl mx-auto">
                    Découvrez d'autres livres dans la même catégorie
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @php
                    $similarBooks = \App\Models\Book::where('status', 'approved')
                        ->where('id', '!=', $book->id)
                        ->where(function($query) use ($book) {
                            if ($book->category) {
                                $query->where('category', $book->category);
                            }
                        })
                        ->with('uploader')
                        ->take(4)
                        ->get();
                @endphp

                @forelse($similarBooks as $similarBook)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 group h-96 flex flex-col">
                        <div class="relative h-56 flex-shrink-0">
                            @if($similarBook->cover_image)
                                <img src="{{ Storage::url($similarBook->cover_image) }}"
                                     alt="{{ $similarBook->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center group-hover:from-emerald-600 group-hover:to-teal-700 transition-all duration-300">
                                    <div class="text-white text-center p-3 max-w-full">
                                        <i class="fas fa-book text-2xl mb-2"></i>
                                        <div class="font-bold text-xs leading-tight break-words line-clamp-3">{{ Str::limit($similarBook->title, 30) }}</div>
                                    </div>
                                </div>
                            @endif

                            <!-- Stats Badge (Subtil mais visible) -->
                            <div class="absolute bottom-2 right-2 bg-emerald-500/15 backdrop-blur-sm text-emerald-700 px-1.5 py-0.5 rounded text-[10px] font-medium opacity-75 hover:opacity-100 transition-opacity">
                                <i class="fas fa-download mr-0.5 text-emerald-600" style="font-size: 8px;"></i>{{ number_format($similarBook->downloads, 0, '', ' ') }}
                            </div>
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-heading font-bold text-gray-900 mb-2 text-sm group-hover:text-emerald-600 transition-colors line-clamp-2">
                                    {{ $similarBook->title }}
                                </h3>
                                <p class="text-gray-600 text-xs mb-3 leading-relaxed line-clamp-2">{{ $similarBook->description }}</p>
                            </div>
                            <div class="flex items-center justify-between mt-auto">
                                <div class="flex items-center text-xs text-gray-500">
                                    <i class="fas fa-user mr-1"></i>
                                    <span>{{ Str::limit($similarBook->uploader->name, 12) }}</span>
                                </div>
                                <a href="{{ route('books.public.show', $similarBook) }}"
                                   class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded text-xs font-semibold transition-all duration-300">
                                    Voir
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-book text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 mb-2">Aucun livre similaire</h3>
                        <p class="text-gray-500 text-sm">Explorez notre bibliothèque pour découvrir d'autres livres</p>
                    </div>
                @endforelse
            </div>

            <!-- Back to Library Button -->
            <div class="text-center mt-10">
                <a href="{{ route('books.public.index') }}"
                   class="inline-flex items-center bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-6 py-3 rounded-xl font-semibold text-base transition-all duration-200 shadow-md hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la Bibliothèque
                </a>
            </div>
        </div>
    </section>

    <!-- Preview Section (for non-authenticated users) -->
    @guest
    <section class="py-12 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-heading font-bold text-gray-900 mb-4">
                    Aperçu du Livre
                </h2>
                <p class="text-gray-600">
                    Découvrez un extrait de ce livre. Connectez-vous pour accéder au contenu complet.
                </p>
            </div>

            <!-- Preview Content -->
            <div class="bg-gray-50 rounded-xl p-8 mb-8">
                <div class="prose max-w-none">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Extrait - {{ $book->title }}</h3>
                    <div class="text-gray-700 leading-relaxed space-y-4">
                        <p>{{ Str::limit($book->description, 300) }}</p>

                        <!-- Simulated book content preview -->
                        <div class="border-l-4 border-emerald-500 pl-4 italic text-gray-600">
                            <p>"Ceci est un aperçu du contenu du livre. Le texte complet, les illustrations et tous les détails sont disponibles après connexion..."</p>
                        </div>

                        <!-- Blur effect to indicate more content -->
                        <div class="relative">
                            <div class="text-gray-400 blur-sm">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation...</p>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident...</p>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-white flex items-end justify-center pb-4">
                                <div class="text-center">
                                    <p class="text-gray-600 mb-4">Contenu complet disponible après connexion</p>
                                    <a href="{{ route('login') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                                        Se connecter maintenant
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl p-6 text-center border border-emerald-100 card-hover">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Accédez au contenu complet</h3>
                <p class="text-gray-600 mb-4">Créez un compte gratuit pour télécharger ce livre et accéder à notre bibliothèque complète</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-user-plus mr-2"></i>
                        Créer un compte gratuit
                    </a>
                    <a href="{{ route('login') }}" class="bg-white text-emerald-600 border border-emerald-600 hover:bg-emerald-50 px-6 py-3 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Se connecter
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endguest

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b flex-shrink-0">
                <h3 class="text-xl font-bold text-gray-900">Aperçu - {{ $book->title }}</h3>
                <button onclick="closePreview()" class="text-gray-500 hover:text-gray-700 p-2">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- PDF Viewer Container -->
            <div class="flex-1 relative overflow-hidden min-h-0">
                @if($book->pdf_path)
                    <div class="h-full relative">
                        <!-- Custom PDF Viewer with scroll -->
                        <div id="pdfPreviewContainer" class="h-full"></div>
                    </div>
                @else
                    <div class="flex items-center justify-center h-64">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-file-pdf text-4xl mb-4"></i>
                            <p>Aperçu non disponible</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Bottom Call to Action - Always visible -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-4 flex-shrink-0">
                <div class="text-center text-white">
                    <h4 class="text-lg font-semibold mb-2">Vous lisez un aperçu limité</h4>
                    <p class="text-sm mb-4 opacity-90">Connectez-vous pour accéder au livre complet et le télécharger gratuitement</p>
                    <div class="flex gap-3 justify-center">
                        <a href="{{ route('login') }}" class="bg-white text-emerald-600 hover:bg-gray-100 px-6 py-2 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-teal-600 to-emerald-700 hover:from-teal-700 hover:to-emerald-800 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-xl">
                            <i class="fas fa-user-plus mr-2"></i>Créer un compte
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Compact -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center mb-3">
                        @if(site_logo())
                            <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-6 w-auto">
                        @else
                            <div class="w-6 h-6 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded flex items-center justify-center">
                                <i class="fas fa-book-open text-white text-xs"></i>
                            </div>
                        @endif
                        <span class="ml-2 text-base font-heading font-bold">{{ site_name() }}</span>
                    </div>
                    <p class="text-gray-300 mb-3 text-xs max-w-xs">
                        {{ site_setting('footer_description', 'Votre bibliothèque numérique moderne.') }}
                    </p>
                    <div class="flex space-x-2">
                        <a href="#" class="w-6 h-6 bg-gray-800 rounded flex items-center justify-center hover:bg-emerald-600 transition-colors">
                            <i class="fab fa-facebook-f text-xs"></i>
                        </a>
                        <a href="#" class="w-6 h-6 bg-gray-800 rounded flex items-center justify-center hover:bg-emerald-600 transition-colors">
                            <i class="fab fa-twitter text-xs"></i>
                        </a>
                        <a href="#" class="w-6 h-6 bg-gray-800 rounded flex items-center justify-center hover:bg-emerald-600 transition-colors">
                            <i class="fab fa-linkedin-in text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-sm font-semibold mb-3">Liens Rapides</h3>
                    <ul class="space-y-1">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors text-xs">Accueil</a></li>
                        <li><a href="{{ route('books.public.index') }}" class="text-gray-300 hover:text-white transition-colors text-xs">Bibliothèque</a></li>
                        @auth
                            <li><a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-white transition-colors text-xs">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors text-xs">Connexion</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition-colors text-xs">Inscription</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-sm font-semibold mb-3">Support</h3>
                    <ul class="space-y-1">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-xs">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-xs">FAQ</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-xs">Contact</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar Compact -->
            <div class="border-t border-gray-800 mt-6 pt-4 text-center">
                <p class="text-gray-400 text-xs">
                    &copy; {{ date('Y') }} {{ site_name() }}. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts (same as home page) -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="{{ asset('js/pdf-preview.js') }}"></script>
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to navigation
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-lg');
            } else {
                nav.classList.remove('shadow-lg');
            }
        });

        // Add hover effects to book cards
        document.querySelectorAll('.group').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add loading animation for images
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });
        });

        // PDF Preview instance
        let pdfPreviewInstance = null;

        // Preview modal functions
        function showPreview() {
            const modal = document.getElementById('previewModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            // Initialize PDF preview if not already done
            if (!pdfPreviewInstance) {
                const container = document.getElementById('pdfPreviewContainer');
                const pdfUrl = '{{ route("books.public.preview", $book) }}';

                pdfPreviewInstance = new PDFPreview(container, pdfUrl, {
                    maxPages: 3,
                    scale: 1.5,
                    showWatermark: true
                });
            }
        }

        function closePreview() {
            const modal = document.getElementById('previewModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }



        // Close modal when clicking outside
        document.getElementById('previewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePreview();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePreview();
            }
        });

        // Prevent right-click on PDF preview
        document.getElementById('previewModal').addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });

        // Disable keyboard shortcuts in preview
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('previewModal');
            if (!modal.classList.contains('hidden')) {
                // Disable Ctrl+S, Ctrl+P, etc.
                if (e.ctrlKey && (e.key === 's' || e.key === 'p' || e.key === 'a')) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    </script>
</body>
</html>
