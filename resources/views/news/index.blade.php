<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualités Éducatives - {{ site_name() }}</title>
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
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .news-card {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .ticker {
            animation: scroll 30s linear infinite;
        }
        @keyframes scroll {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #14b8a6 50%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ mobileMenuOpen: false }">

    @include('partials.public-header')

    <!-- Hero Section -->
    <section class="relative py-16 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-100 to-teal-100 opacity-30"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl font-bold text-gray-900 mb-4">
                    <span class="gradient-text">Actualités Éducatives</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Restez informé des dernières nouvelles du système éducatif ivoirien
                </p>
            </div>

            <!-- Categories -->
            <div class="flex flex-wrap justify-center gap-3 mt-8">
                <button class="glass px-6 py-2 rounded-full text-gray-700 hover:bg-white hover:shadow-md transition-all duration-200">
                    <i class="fas fa-fire text-orange-500 mr-2"></i>Tendances
                </button>
                <button class="glass px-6 py-2 rounded-full text-gray-700 hover:bg-white hover:shadow-md transition-all duration-200">
                    <i class="fas fa-graduation-cap text-emerald-500 mr-2"></i>Examens
                </button>
                <button class="glass px-6 py-2 rounded-full text-gray-700 hover:bg-white hover:shadow-md transition-all duration-200">
                    <i class="fas fa-school text-teal-600 mr-2"></i>Établissements
                </button>
                <button class="glass px-6 py-2 rounded-full text-gray-700 hover:bg-white hover:shadow-md transition-all duration-200">
                    <i class="fas fa-bullhorn text-emerald-600 mr-2"></i>Annonces
                </button>
                <button class="glass px-6 py-2 rounded-full text-gray-700 hover:bg-white hover:shadow-md transition-all duration-200">
                    <i class="fas fa-lightbulb text-amber-500 mr-2"></i>Innovations
                </button>
            </div>
        </div>
    </section>

    <!-- Featured Article -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden news-card card-hover border border-gray-100">
                <div class="grid md:grid-cols-2">
                    <div class="h-64 md:h-auto bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                        <i class="fas fa-trophy text-white text-8xl opacity-50"></i>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center mb-4">
                            <span class="bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold">
                                À LA UNE
                            </span>
                            <span class="text-gray-500 text-sm ml-3">Il y a 2 heures</span>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">
                            Résultats exceptionnels au BEPC 2024 : 78% de réussite nationale
                        </h2>
                        <p class="text-gray-600 mb-6">
                            Le ministère de l'Éducation nationale annonce des résultats historiques pour la session 2024 
                            du BEPC avec un taux de réussite national de 78%, en hausse de 12 points par rapport à 2023. 
                            Les filles enregistrent particulièrement d'excellentes performances...
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-500">
                                    <i class="fas fa-eye mr-1"></i>15.2k vues
                                </span>
                                <span class="text-sm text-gray-500">
                                    <i class="fas fa-share mr-1"></i>2.3k partages
                                </span>
                            </div>
                            <a href="#" class="text-emerald-600 font-semibold hover:text-emerald-700 transition-colors">
                                Lire plus <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Grid -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Dernières actualités</h2>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- News Card 1 -->
                <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 news-card card-hover border border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                        <i class="fas fa-university text-white text-6xl opacity-50"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-xs font-semibold">
                                UNIVERSITÉ
                            </span>
                            <span class="text-gray-500 text-xs ml-2">Il y a 4 heures</span>
                        </div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            Ouverture de 3 nouvelles filières à l'Université FHB
                        </h3>
                        <p class="text-gray-600 text-sm mb-4">
                            L'université Félix Houphouët-Boigny annonce l'ouverture de nouvelles filières en IA, 
                            cybersécurité et énergies renouvelables pour la rentrée 2025...
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3 text-xs text-gray-500">
                                <span><i class="fas fa-eye mr-1"></i>8.5k</span>
                                <span><i class="fas fa-comment mr-1"></i>245</span>
                            </div>
                            <a href="#" class="text-emerald-600 text-sm font-semibold hover:text-emerald-700 transition-colors">
                                Lire <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </article>

                <!-- News Card 2 -->
                <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 news-card card-hover border border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center">
                        <i class="fas fa-laptop text-white text-6xl opacity-50"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs font-semibold">
                                NUMÉRIQUE
                            </span>
                            <span class="text-gray-500 text-xs ml-2">Il y a 6 heures</span>
                        </div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            Distribution de 50,000 tablettes aux élèves du secondaire
                        </h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Le gouvernement lance un programme ambitieux de distribution de tablettes éducatives 
                            pour digitaliser l'apprentissage dans les collèges et lycées...
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3 text-xs text-gray-500">
                                <span><i class="fas fa-eye mr-1"></i>12k</span>
                                <span><i class="fas fa-comment mr-1"></i>567</span>
                            </div>
                            <a href="#" class="text-green-600 text-sm font-semibold hover:text-green-700">
                                Lire <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </article>

                <!-- News Card 3 -->
                <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 news-card card-hover border border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                        <i class="fas fa-award text-white text-6xl opacity-50"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-teal-100 text-teal-600 px-2 py-1 rounded text-xs font-semibold">
                                EXCELLENCE
                            </span>
                            <span class="text-gray-500 text-xs ml-2">Il y a 8 heures</span>
                        </div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            Bourses d'excellence pour 1000 meilleurs bacheliers
                        </h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Le programme présidentiel de bourses d'excellence offre des opportunités d'études 
                            à l'étranger pour les meilleurs élèves du BAC 2024...
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3 text-xs text-gray-500">
                                <span><i class="fas fa-eye mr-1"></i>9.8k</span>
                                <span><i class="fas fa-comment mr-1"></i>432</span>
                            </div>
                            <a href="#" class="text-teal-600 text-sm font-semibold hover:text-purple-700">
                                Lire <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-12 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Ne manquez aucune actualité</h2>
            <p class="text-xl opacity-90 mb-8">
                Recevez les dernières nouvelles éducatives directement dans votre boîte mail
            </p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" placeholder="Votre email" 
                       class="flex-1 px-4 py-3 rounded-lg text-gray-900 placeholder-gray-500">
                <button type="submit" class="bg-white text-emerald-600 px-6 py-3 rounded-lg font-semibold hover:bg-emerald-50 transition-all duration-200 shadow-md hover:shadow-lg">
                    S'abonner
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-600">
            <p>&copy; 2025 E-Library Côte d'Ivoire - Source officielle d'actualités éducatives</p>
        </div>
    </footer>
</body>
</html>