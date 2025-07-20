@extends('layouts.main-dashboard')

@section('title', 'Gestion des Auteurs')
@section('page-title', 'Auteurs')
@section('page-description', 'Gérez les auteurs et leurs publications sur votre plateforme')

@section('content')
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Auteurs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">1,247</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+23 ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <i class="fas fa-user-check text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Auteurs Actifs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">892</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+18 ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                    <i class="fas fa-crown text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Auteurs Vedettes</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">47</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+3 ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900">
                    <i class="fas fa-file-alt text-orange-600 dark:text-orange-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Candidatures</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">34</p>
                    <p class="text-xs text-orange-600 dark:text-orange-400">En attente</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-user-plus"></i>
                <span>Inviter un Auteur</span>
            </button>
            <select class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option>Tous les statuts</option>
                <option>Actifs</option>
                <option>Inactifs</option>
                <option>Vedettes</option>
                <option>Nouveaux</option>
            </select>
            <select class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option>Toutes les spécialités</option>
                <option>Fiction</option>
                <option>Science</option>
                <option>Technologie</option>
                <option>Histoire</option>
            </select>
        </div>
        
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="text" placeholder="Rechercher un auteur..." 
                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Authors Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Author Card 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <img class="w-12 h-12 rounded-full" src="https://ui-avatars.com/api/?name=Marie+Dubois&background=6366f1&color=fff" alt="Marie Dubois">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Marie Dubois</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Spécialiste IA</p>
                    </div>
                </div>
                <div class="flex items-center space-x-1">
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">Vedette</span>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">23</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Livres</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">4.8</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Note</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">12.4k</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Lectures</div>
                </div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="flex text-yellow-400">
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">(234 avis)</span>
                </div>
                <div class="flex items-center space-x-1">
                    <button class="text-gray-400 hover:text-blue-600 p-1">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="text-gray-400 hover:text-green-600 p-1">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-600 p-1">
                        <i class="fas fa-ban"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Author Card 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <img class="w-12 h-12 rounded-full" src="https://ui-avatars.com/api/?name=Jean+Martin&background=10b981&color=fff" alt="Jean Martin">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Jean Martin</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Historien</p>
                    </div>
                </div>
                <div class="flex items-center space-x-1">
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Actif</span>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">18</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Livres</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">4.6</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Note</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">8.7k</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Lectures</div>
                </div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="flex text-yellow-400">
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star-half-alt text-xs"></i>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">(156 avis)</span>
                </div>
                <div class="flex items-center space-x-1">
                    <button class="text-gray-400 hover:text-blue-600 p-1">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="text-gray-400 hover:text-green-600 p-1">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-600 p-1">
                        <i class="fas fa-ban"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Author Card 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <img class="w-12 h-12 rounded-full" src="https://ui-avatars.com/api/?name=Sophie+Laurent&background=f59e0b&color=fff" alt="Sophie Laurent">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Sophie Laurent</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Romancière</p>
                    </div>
                </div>
                <div class="flex items-center space-x-1">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Nouveau</span>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">3</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Livres</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">4.9</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Note</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">2.1k</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Lectures</div>
                </div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="flex text-yellow-400">
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">(47 avis)</span>
                </div>
                <div class="flex items-center space-x-1">
                    <button class="text-gray-400 hover:text-blue-600 p-1">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="text-gray-400 hover:text-green-600 p-1">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-600 p-1">
                        <i class="fas fa-ban"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Author Card 4 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <img class="w-12 h-12 rounded-full" src="https://ui-avatars.com/api/?name=Pierre+Durand&background=ef4444&color=fff" alt="Pierre Durand">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Pierre Durand</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Scientifique</p>
                    </div>
                </div>
                <div class="flex items-center space-x-1">
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">Vedette</span>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">31</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Livres</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">4.7</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Note</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">18.9k</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Lectures</div>
                </div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="flex text-yellow-400">
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star-half-alt text-xs"></i>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">(389 avis)</span>
                </div>
                <div class="flex items-center space-x-1">
                    <button class="text-gray-400 hover:text-blue-600 p-1">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="text-gray-400 hover:text-green-600 p-1">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-600 p-1">
                        <i class="fas fa-ban"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Author Card 5 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <img class="w-12 h-12 rounded-full" src="https://ui-avatars.com/api/?name=Anne+Moreau&background=8b5cf6&color=fff" alt="Anne Moreau">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Anne Moreau</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Philosophe</p>
                    </div>
                </div>
                <div class="flex items-center space-x-1">
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Actif</span>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">12</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Livres</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">4.5</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Note</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">5.3k</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Lectures</div>
                </div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="flex text-yellow-400">
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star-half-alt text-xs"></i>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">(98 avis)</span>
                </div>
                <div class="flex items-center space-x-1">
                    <button class="text-gray-400 hover:text-blue-600 p-1">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="text-gray-400 hover:text-green-600 p-1">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-600 p-1">
                        <i class="fas fa-ban"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Author Card 6 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <img class="w-12 h-12 rounded-full" src="https://ui-avatars.com/api/?name=Thomas+Bernard&background=06b6d4&color=fff" alt="Thomas Bernard">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Thomas Bernard</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Développeur</p>
                    </div>
                </div>
                <div class="flex items-center space-x-1">
                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Inactif</span>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">7</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Livres</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">4.3</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Note</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">3.2k</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Lectures</div>
                </div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="flex text-yellow-400">
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="fas fa-star text-xs"></i>
                        <i class="far fa-star text-xs"></i>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">(67 avis)</span>
                </div>
                <div class="flex items-center space-x-1">
                    <button class="text-gray-400 hover:text-blue-600 p-1">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="text-gray-400 hover:text-green-600 p-1">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-600 p-1">
                        <i class="fas fa-ban"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between">
        <div class="text-sm text-gray-700 dark:text-gray-300">
            Affichage de <span class="font-medium">1</span> à <span class="font-medium">6</span> sur <span class="font-medium">1,247</span> auteurs
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
