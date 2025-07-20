@extends('layouts.author-dashboard')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Gestion des collections</h1>
            <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouvelle collection
            </button>
        </div>

        <!-- Statistiques des collections -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-600">Total collections</p>
                        <p class="text-2xl font-bold text-blue-800">8</p>
                    </div>
                    <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-green-600">Livres publiés</p>
                        <p class="text-2xl font-bold text-green-800">42</p>
                    </div>
                    <svg class="w-10 h-10 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-purple-600">Lecteurs actifs</p>
                        <p class="text-2xl font-bold text-purple-800">1.2K</p>
                    </div>
                    <svg class="w-10 h-10 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-orange-50 to-orange-100 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-orange-600">Note moyenne</p>
                        <p class="text-2xl font-bold text-orange-800">4.7/5</p>
                    </div>
                    <svg class="w-10 h-10 text-orange-300" fill="currentColor" stroke="none" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Collections actives -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4">Mes collections</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Collection 1 -->
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-32 bg-gradient-to-r from-blue-400 to-blue-600 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <h3 class="text-white text-xl font-bold">Science Fiction</h3>
                        </div>
                        <div class="absolute top-2 right-2">
                            <span class="bg-white/20 backdrop-blur text-white px-2 py-1 rounded-full text-xs">
                                12 livres
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-gray-600 mb-3">Une collection de mes meilleures œuvres de science-fiction, explorant des futurs possibles et des technologies imaginaires.</p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Créée il y a 2 ans</span>
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800">Modifier</button>
                                <button class="text-green-600 hover:text-green-800">Voir</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Collection 2 -->
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-32 bg-gradient-to-r from-purple-400 to-pink-600 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <h3 class="text-white text-xl font-bold">Romance Historique</h3>
                        </div>
                        <div class="absolute top-2 right-2">
                            <span class="bg-white/20 backdrop-blur text-white px-2 py-1 rounded-full text-xs">
                                8 livres
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-gray-600 mb-3">Des histoires d'amour intemporelles se déroulant dans des époques fascinantes de l'histoire.</p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Créée il y a 1 an</span>
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800">Modifier</button>
                                <button class="text-green-600 hover:text-green-800">Voir</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Collection 3 -->
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-32 bg-gradient-to-r from-green-400 to-teal-600 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <h3 class="text-white text-xl font-bold">Guides Pratiques</h3>
                        </div>
                        <div class="absolute top-2 right-2">
                            <span class="bg-white/20 backdrop-blur text-white px-2 py-1 rounded-full text-xs">
                                5 livres
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-gray-600 mb-3">Des guides pratiques pour améliorer différents aspects de votre vie quotidienne.</p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Créée il y a 6 mois</span>
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800">Modifier</button>
                                <button class="text-green-600 hover:text-green-800">Voir</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Collection 4 - Nouvelle -->
                <div class="bg-white border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-green-400 transition-colors cursor-pointer">
                    <div class="text-center">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <p class="text-gray-600 font-medium">Créer une nouvelle collection</p>
                        <p class="text-sm text-gray-500 mt-2">Organisez vos livres par thème</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gérer une collection spécifique -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Gérer la collection "Science Fiction"</h2>
            
            <!-- Actions de collection -->
            <div class="flex flex-wrap gap-3 mb-6">
                <button class="bg-white px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-50 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajouter un livre
                </button>
                <button class="bg-white px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-50 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier les détails
                </button>
                <button class="bg-white px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-50 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Changer la couverture
                </button>
                <button class="bg-white px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-50 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    Partager
                </button>
            </div>

            <!-- Livres de la collection -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @for($i = 1; $i <= 8; $i++)
                <div class="bg-white rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="aspect-[3/4] bg-gradient-to-br from-blue-400 to-blue-600 rounded mb-3 flex items-center justify-center">
                        <span class="text-white text-4xl font-bold opacity-50">SF</span>
                    </div>
                    <h4 class="font-medium text-sm mb-1">Titre du livre {{ $i }}</h4>
                    <p class="text-xs text-gray-600 mb-2">Publié en 2024</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            <span class="text-xs ml-1">4.5</span>
                        </div>
                        <button class="text-xs text-red-600 hover:text-red-800">Retirer</button>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <!-- Outils de promotion -->
        <div class="mt-8">
            <h2 class="text-lg font-semibold mb-4">Outils de promotion</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Widget de partage -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold">Widget de partage</h4>
                            <p class="text-sm text-gray-600">Intégrez sur votre site</p>
                        </div>
                    </div>
                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                        Générer le code
                    </button>
                </div>

                <!-- Bannières promotionnelles -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold">Bannières</h4>
                            <p class="text-sm text-gray-600">Pour réseaux sociaux</p>
                        </div>
                    </div>
                    <button class="w-full bg-purple-600 text-white py-2 rounded hover:bg-purple-700">
                        Créer des bannières
                    </button>
                </div>

                <!-- Codes promo -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold">Codes promo</h4>
                            <p class="text-sm text-gray-600">Offres spéciales</p>
                        </div>
                    </div>
                    <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                        Gérer les codes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection