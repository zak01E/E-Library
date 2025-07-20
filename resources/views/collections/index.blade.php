@extends('layouts.main-dashboard')

@section('title', 'Collections de Livres')
@section('page-title', 'Collections')
@section('page-description', 'Organisez vos livres en collections thématiques pour une meilleure découverte')

@section('content')
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-layer-group text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Collections</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">47</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+5 ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <i class="fas fa-fire text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Collections Populaires</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">12</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+2 ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                    <i class="fas fa-book text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Livres dans Collections</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">1,247</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+89 ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900">
                    <i class="fas fa-eye text-orange-600 dark:text-orange-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Vues Totales</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">94.3k</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+12% ce mois</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Nouvelle Collection</span>
            </button>
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-magic"></i>
                <span>Collection Auto</span>
            </button>
            <select class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option>Toutes les collections</option>
                <option>Publiques</option>
                <option>Privées</option>
                <option>Populaires</option>
                <option>Récentes</option>
            </select>
        </div>
        
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="text" placeholder="Rechercher une collection..." 
                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Collections Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Collection Card 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="relative h-48 bg-gradient-to-br from-blue-400 to-blue-600">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                <div class="absolute top-4 right-4">
                    <span class="px-2 py-1 bg-white bg-opacity-90 text-blue-800 text-xs rounded-full font-medium">Publique</span>
                </div>
                <div class="absolute bottom-4 left-4 right-4">
                    <h3 class="text-xl font-bold text-white mb-2">Intelligence Artificielle</h3>
                    <p class="text-blue-100 text-sm">Les dernières avancées en IA et machine learning</p>
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">23</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Livres</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">12.4k</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Vues</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">4.8</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Note</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <button class="text-gray-400 hover:text-blue-600 p-1">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="text-gray-400 hover:text-green-600 p-1">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-gray-400 hover:text-red-600 p-1">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center space-x-2">
                        <img class="w-6 h-6 rounded-full" src="https://ui-avatars.com/api/?name=Marie+Dubois&background=6366f1&color=fff" alt="Marie Dubois">
                        <span>Marie Dubois</span>
                    </div>
                    <span>Mise à jour il y a 2j</span>
                </div>
            </div>
        </div>

        <!-- Collection Card 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="relative h-48 bg-gradient-to-br from-green-400 to-green-600">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                <div class="absolute top-4 right-4">
                    <span class="px-2 py-1 bg-white bg-opacity-90 text-green-800 text-xs rounded-full font-medium">Populaire</span>
                </div>
                <div class="absolute bottom-4 left-4 right-4">
                    <h3 class="text-xl font-bold text-white mb-2">Développement Durable</h3>
                    <p class="text-green-100 text-sm">Écologie, environnement et solutions durables</p>
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">18</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Livres</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">8.7k</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Vues</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">4.6</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Note</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <button class="text-gray-400 hover:text-blue-600 p-1">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="text-gray-400 hover:text-green-600 p-1">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-gray-400 hover:text-red-600 p-1">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center space-x-2">
                        <img class="w-6 h-6 rounded-full" src="https://ui-avatars.com/api/?name=Jean+Martin&background=10b981&color=fff" alt="Jean Martin">
                        <span>Jean Martin</span>
                    </div>
                    <span>Mise à jour il y a 1j</span>
                </div>
            </div>
        </div>

        <!-- Collection Card 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="relative h-48 bg-gradient-to-br from-purple-400 to-purple-600">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                <div class="absolute top-4 right-4">
                    <span class="px-2 py-1 bg-white bg-opacity-90 text-purple-800 text-xs rounded-full font-medium">Privée</span>
                </div>
                <div class="absolute bottom-4 left-4 right-4">
                    <h3 class="text-xl font-bold text-white mb-2">Philosophie Moderne</h3>
                    <p class="text-purple-100 text-sm">Penseurs contemporains et réflexions actuelles</p>
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">15</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Livres</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">3.2k</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Vues</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">4.9</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Note</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <button class="text-gray-400 hover:text-blue-600 p-1">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="text-gray-400 hover:text-green-600 p-1">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-gray-400 hover:text-red-600 p-1">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center space-x-2">
                        <img class="w-6 h-6 rounded-full" src="https://ui-avatars.com/api/?name=Sophie+Laurent&background=8b5cf6&color=fff" alt="Sophie Laurent">
                        <span>Sophie Laurent</span>
                    </div>
                    <span>Mise à jour il y a 5j</span>
                </div>
            </div>
        </div>

        <!-- Collection Card 4 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="relative h-48 bg-gradient-to-br from-orange-400 to-orange-600">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                <div class="absolute top-4 right-4">
                    <span class="px-2 py-1 bg-white bg-opacity-90 text-orange-800 text-xs rounded-full font-medium">Publique</span>
                </div>
                <div class="absolute bottom-4 left-4 right-4">
                    <h3 class="text-xl font-bold text-white mb-2">Histoire Contemporaine</h3>
                    <p class="text-orange-100 text-sm">Événements marquants du 20e et 21e siècle</p>
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">31</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Livres</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">15.6k</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Vues</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">4.7</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Note</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <button class="text-gray-400 hover:text-blue-600 p-1">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="text-gray-400 hover:text-green-600 p-1">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-gray-400 hover:text-red-600 p-1">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center space-x-2">
                        <img class="w-6 h-6 rounded-full" src="https://ui-avatars.com/api/?name=Pierre+Durand&background=f59e0b&color=fff" alt="Pierre Durand">
                        <span>Pierre Durand</span>
                    </div>
                    <span>Mise à jour il y a 3j</span>
                </div>
            </div>
        </div>

        <!-- Collection Card 5 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="relative h-48 bg-gradient-to-br from-pink-400 to-pink-600">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                <div class="absolute top-4 right-4">
                    <span class="px-2 py-1 bg-white bg-opacity-90 text-pink-800 text-xs rounded-full font-medium">Populaire</span>
                </div>
                <div class="absolute bottom-4 left-4 right-4">
                    <h3 class="text-xl font-bold text-white mb-2">Romance & Amour</h3>
                    <p class="text-pink-100 text-sm">Les plus belles histoires d'amour contemporaines</p>
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">42</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Livres</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">28.9k</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Vues</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">4.5</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Note</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <button class="text-gray-400 hover:text-blue-600 p-1">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="text-gray-400 hover:text-green-600 p-1">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-gray-400 hover:text-red-600 p-1">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center space-x-2">
                        <img class="w-6 h-6 rounded-full" src="https://ui-avatars.com/api/?name=Anne+Moreau&background=ec4899&color=fff" alt="Anne Moreau">
                        <span>Anne Moreau</span>
                    </div>
                    <span>Mise à jour il y a 1j</span>
                </div>
            </div>
        </div>

        <!-- Collection Card 6 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="relative h-48 bg-gradient-to-br from-indigo-400 to-indigo-600">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                <div class="absolute top-4 right-4">
                    <span class="px-2 py-1 bg-white bg-opacity-90 text-indigo-800 text-xs rounded-full font-medium">Publique</span>
                </div>
                <div class="absolute bottom-4 left-4 right-4">
                    <h3 class="text-xl font-bold text-white mb-2">Sciences & Découvertes</h3>
                    <p class="text-indigo-100 text-sm">Vulgarisation scientifique et grandes découvertes</p>
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">27</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Livres</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">11.3k</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Vues</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">4.8</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Note</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <button class="text-gray-400 hover:text-blue-600 p-1">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="text-gray-400 hover:text-green-600 p-1">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-gray-400 hover:text-red-600 p-1">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center space-x-2">
                        <img class="w-6 h-6 rounded-full" src="https://ui-avatars.com/api/?name=Thomas+Bernard&background=6366f1&color=fff" alt="Thomas Bernard">
                        <span>Thomas Bernard</span>
                    </div>
                    <span>Mise à jour il y a 4j</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between">
        <div class="text-sm text-gray-700 dark:text-gray-300">
            Affichage de <span class="font-medium">1</span> à <span class="font-medium">6</span> sur <span class="font-medium">47</span> collections
        </div>
        <div class="flex items-center space-x-2">
            <button class="px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                Précédent
            </button>
            <button class="px-3 py-2 text-sm bg-indigo-600 text-white rounded-lg">1</button>
            <button class="px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">2</button>
            <button class="px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">3</button>
            <button class="px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                Suivant
            </button>
        </div>
    </div>
@endsection
