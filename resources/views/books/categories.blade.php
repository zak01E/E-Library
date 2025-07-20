@extends('layouts.main-dashboard')

@section('title', 'Catégories de Livres')
@section('page-title', 'Gestion des Catégories')
@section('page-description', 'Organisez et gérez les catégories de votre bibliothèque')

@section('content')
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Nouvelle Catégorie</span>
            </button>
            <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-download"></i>
                <span>Exporter</span>
            </button>
        </div>
        
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="text" placeholder="Rechercher une catégorie..." 
                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <select class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option>Toutes les catégories</option>
                <option>Actives</option>
                <option>Inactives</option>
            </select>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        <!-- Fiction Category -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <i class="fas fa-magic text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Fiction</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Romans, nouvelles et œuvres imaginaires</p>
            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <span class="font-medium text-gray-900 dark:text-white">1,247</span>
                    <span class="text-gray-500 dark:text-gray-400">livres</span>
                </div>
                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
            </div>
        </div>

        <!-- Science Category -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="fas fa-flask text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Science</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Recherche scientifique et découvertes</p>
            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <span class="font-medium text-gray-900 dark:text-white">892</span>
                    <span class="text-gray-500 dark:text-gray-400">livres</span>
                </div>
                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
            </div>
        </div>

        <!-- Technology Category -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                    <i class="fas fa-laptop-code text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Technologie</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Programmation, IA et innovations tech</p>
            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <span class="font-medium text-gray-900 dark:text-white">743</span>
                    <span class="text-gray-500 dark:text-gray-400">livres</span>
                </div>
                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
            </div>
        </div>

        <!-- History Category -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-orange-100 dark:bg-orange-900 rounded-lg">
                    <i class="fas fa-landmark text-orange-600 dark:text-orange-400 text-xl"></i>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Histoire</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Événements historiques et biographies</p>
            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <span class="font-medium text-gray-900 dark:text-white">634</span>
                    <span class="text-gray-500 dark:text-gray-400">livres</span>
                </div>
                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
            </div>
        </div>

        <!-- Art Category -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-pink-100 dark:bg-pink-900 rounded-lg">
                    <i class="fas fa-palette text-pink-600 dark:text-pink-400 text-xl"></i>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Art & Design</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Beaux-arts, design et créativité</p>
            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <span class="font-medium text-gray-900 dark:text-white">456</span>
                    <span class="text-gray-500 dark:text-gray-400">livres</span>
                </div>
                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
            </div>
        </div>

        <!-- Business Category -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                    <i class="fas fa-briefcase text-indigo-600 dark:text-indigo-400 text-xl"></i>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Business</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Entrepreneuriat et gestion d'entreprise</p>
            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <span class="font-medium text-gray-900 dark:text-white">389</span>
                    <span class="text-gray-500 dark:text-gray-400">livres</span>
                </div>
                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
            </div>
        </div>

        <!-- Philosophy Category -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                    <i class="fas fa-brain text-yellow-600 dark:text-yellow-400 text-xl"></i>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Philosophie</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Réflexions et pensées philosophiques</p>
            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <span class="font-medium text-gray-900 dark:text-white">267</span>
                    <span class="text-gray-500 dark:text-gray-400">livres</span>
                </div>
                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Inactive</span>
            </div>
        </div>

        <!-- Health Category -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg">
                    <i class="fas fa-heartbeat text-red-600 dark:text-red-400 text-xl"></i>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-gray-400 hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Santé & Bien-être</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Médecine, nutrition et développement personnel</p>
            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <span class="font-medium text-gray-900 dark:text-white">523</span>
                    <span class="text-gray-500 dark:text-gray-400">livres</span>
                </div>
                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
            </div>
        </div>
    </div>

    <!-- Category Statistics -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Statistiques des Catégories</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mb-2">8</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Catégories Actives</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">5,151</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Total Livres</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-orange-600 dark:text-orange-400 mb-2">643</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Moyenne par Catégorie</div>
            </div>
        </div>
    </div>
@endsection
