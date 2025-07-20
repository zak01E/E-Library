@extends('layouts.admin-dashboard')

@section('page-title', 'Gestion des Thèmes')
@section('page-description', 'Personnalisez l\'apparence et les thèmes de votre plateforme')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Gestion des thèmes</h1>
            <button class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Créer un thème
            </button>
        </div>

        <!-- Thème actif -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-4">Thème actif</h3>
            <div class="bg-gradient-to-r from-red-50 to-red-100 border-2 border-red-300 rounded-lg p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h4 class="text-xl font-bold text-gray-900">E-Library Classic</h4>
                        <p class="text-gray-600 mt-2">Thème par défaut avec un design moderne et épuré, optimisé pour la lecture</p>
                        <div class="flex items-center mt-4 space-x-4">
                            <span class="text-sm text-gray-500">Version 2.1.0</span>
                            <span class="text-sm text-gray-500">•</span>
                            <span class="text-sm text-gray-500">Mis à jour le 15/07/2025</span>
                            <span class="text-sm text-gray-500">•</span>
                            <span class="text-sm text-green-600 font-medium">Actif</span>
                        </div>
                    </div>
                    <div class="ml-6">
                        <img src="https://via.placeholder.com/200x150" alt="Aperçu du thème" class="rounded-lg shadow-md">
                    </div>
                </div>
                <div class="mt-6 flex space-x-3">
                    <button class="bg-white text-gray-700 px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-50">
                        Personnaliser
                    </button>
                    <button class="bg-white text-gray-700 px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-50">
                        Prévisualiser
                    </button>
                </div>
            </div>
        </div>

        <!-- Thèmes disponibles -->
        <div>
            <h3 class="text-lg font-semibold mb-4">Thèmes disponibles</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Thème Dark Mode -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-40 bg-gray-900 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-white text-4xl font-bold opacity-20">DARK MODE</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-900">Dark Mode Pro</h4>
                        <p class="text-sm text-gray-600 mt-1">Thème sombre pour une lecture confortable la nuit</p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-xs text-gray-500">v1.5.2</span>
                            <div class="flex space-x-2">
                                <button class="text-sm text-blue-600 hover:text-blue-800">Prévisualiser</button>
                                <button class="text-sm text-green-600 hover:text-green-800 font-medium">Activer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thème Minimaliste -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-40 bg-gray-50 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="space-y-2">
                                <div class="h-2 bg-gray-300 w-32 rounded"></div>
                                <div class="h-2 bg-gray-300 w-24 rounded"></div>
                                <div class="h-2 bg-gray-300 w-28 rounded"></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-900">Minimal Clean</h4>
                        <p class="text-sm text-gray-600 mt-1">Design épuré centré sur le contenu</p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-xs text-gray-500">v2.0.0</span>
                            <div class="flex space-x-2">
                                <button class="text-sm text-blue-600 hover:text-blue-800">Prévisualiser</button>
                                <button class="text-sm text-green-600 hover:text-green-800 font-medium">Activer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thème Coloré -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-40 bg-gradient-to-br from-purple-400 via-pink-500 to-red-500 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-white text-4xl font-bold opacity-50">VIBRANT</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-900">Vibrant Colors</h4>
                        <p class="text-sm text-gray-600 mt-1">Thème coloré et dynamique pour une expérience vivante</p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-xs text-gray-500">v1.2.1</span>
                            <div class="flex space-x-2">
                                <button class="text-sm text-blue-600 hover:text-blue-800">Prévisualiser</button>
                                <button class="text-sm text-green-600 hover:text-green-800 font-medium">Activer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thème Nature -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-40 bg-gradient-to-b from-green-300 to-green-600 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="w-20 h-20 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-900">Nature Green</h4>
                        <p class="text-sm text-gray-600 mt-1">Thème apaisant inspiré de la nature</p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-xs text-gray-500">v1.0.0</span>
                            <div class="flex space-x-2">
                                <button class="text-sm text-blue-600 hover:text-blue-800">Prévisualiser</button>
                                <button class="text-sm text-green-600 hover:text-green-800 font-medium">Activer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thème Vintage -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-40 bg-gradient-to-br from-yellow-100 to-amber-200 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="transform rotate-3">
                                <div class="bg-amber-900 w-24 h-32 rounded shadow-lg opacity-30"></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-900">Vintage Paper</h4>
                        <p class="text-sm text-gray-600 mt-1">Style rétro rappelant les vieux livres</p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-xs text-gray-500">v1.3.0</span>
                            <div class="flex space-x-2">
                                <button class="text-sm text-blue-600 hover:text-blue-800">Prévisualiser</button>
                                <button class="text-sm text-green-600 hover:text-green-800 font-medium">Activer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thème Tech -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-40 bg-gradient-to-br from-blue-900 to-indigo-900 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="grid grid-cols-3 gap-1">
                                @for($i = 0; $i < 9; $i++)
                                <div class="w-4 h-4 bg-blue-400 opacity-30 rounded-sm"></div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-900">Tech Modern</h4>
                        <p class="text-sm text-gray-600 mt-1">Design futuriste pour les amateurs de technologie</p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-xs text-gray-500">v2.1.0</span>
                            <div class="flex space-x-2">
                                <button class="text-sm text-blue-600 hover:text-blue-800">Prévisualiser</button>
                                <button class="text-sm text-green-600 hover:text-green-800 font-medium">Activer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Marketplace -->
        <div class="mt-12 bg-gray-50 rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Marketplace de thèmes</h3>
                <a href="#" class="text-red-600 hover:text-red-700 text-sm font-medium">Voir tout →</a>
            </div>
            <p class="text-gray-600 mb-4">Découvrez des centaines de thèmes créés par la communauté</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-red-600">250+</div>
                    <div class="text-sm text-gray-600">Thèmes disponibles</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-blue-600">50+</div>
                    <div class="text-sm text-gray-600">Créateurs actifs</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-green-600">4.8/5</div>
                    <div class="text-sm text-gray-600">Note moyenne</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-purple-600">Gratuit</div>
                    <div class="text-sm text-gray-600">Accès illimité</div>
                </div>
            </div>
        </div>

        <!-- Éditeur de thème -->
        <div class="mt-8 border-t pt-8">
            <h3 class="text-lg font-semibold mb-4">Personnalisation rapide</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Couleur principale</label>
                        <div class="flex items-center space-x-2">
                            <input type="color" value="#DC2626" class="h-10 w-20">
                            <input type="text" value="#DC2626" class="flex-1 rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Couleur secondaire</label>
                        <div class="flex items-center space-x-2">
                            <input type="color" value="#1F2937" class="h-10 w-20">
                            <input type="text" value="#1F2937" class="flex-1 rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Police principale</label>
                        <select class="w-full rounded-md border-gray-300 shadow-sm">
                            <option>Inter</option>
                            <option>Roboto</option>
                            <option>Open Sans</option>
                            <option>Lato</option>
                            <option>Montserrat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Taille de police de base</label>
                        <input type="range" min="14" max="20" value="16" class="w-full">
                    </div>
                </div>
                <div class="bg-gray-100 rounded-lg p-6">
                    <h4 class="font-medium mb-4">Aperçu en temps réel</h4>
                    <div class="bg-white rounded p-4 shadow-sm">
                        <div class="h-8 bg-red-600 rounded mb-4"></div>
                        <div class="space-y-2">
                            <div class="h-4 bg-gray-300 rounded w-3/4"></div>
                            <div class="h-4 bg-gray-300 rounded w-full"></div>
                            <div class="h-4 bg-gray-300 rounded w-5/6"></div>
                        </div>
                        <div class="mt-4 flex space-x-2">
                            <div class="h-8 bg-red-600 rounded px-4 w-24"></div>
                            <div class="h-8 bg-gray-200 rounded px-4 w-24"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                    Réinitialiser
                </button>
                <button class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                    Appliquer les modifications
                </button>
            </div>
        </div>
    </div>
</div>
@endsection