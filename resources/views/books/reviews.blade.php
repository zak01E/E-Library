@extends('layouts.main-dashboard')

@section('title', 'Avis & Notes')
@section('page-title', 'Avis & Évaluations')
@section('page-description', 'Gérez les avis et notes des utilisateurs sur les livres')

@section('content')
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                    <i class="fas fa-star text-yellow-600 dark:text-yellow-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Note Moyenne</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">4.7</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+0.3 ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-comments text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Avis</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">3,247</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+156 ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <i class="fas fa-thumbs-up text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Avis Positifs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">89%</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+2% ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                    <i class="fas fa-flag text-red-600 dark:text-red-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Signalements</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">23</p>
                    <p class="text-xs text-red-600 dark:text-red-400">À traiter</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
            <select class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option>Tous les avis</option>
                <option>5 étoiles</option>
                <option>4 étoiles</option>
                <option>3 étoiles</option>
                <option>2 étoiles</option>
                <option>1 étoile</option>
            </select>
            <select class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option>Toutes les catégories</option>
                <option>Fiction</option>
                <option>Science</option>
                <option>Technologie</option>
                <option>Histoire</option>
            </select>
            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-flag"></i>
                <span>Signalés (23)</span>
            </button>
        </div>
        
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="text" placeholder="Rechercher un avis..." 
                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="space-y-6">
        <!-- Review Item 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-start space-x-4">
                <img class="w-12 h-12 rounded-full" src="https://ui-avatars.com/api/?name=Marie+Dubois&background=6366f1&color=fff" alt="Marie Dubois">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Marie Dubois</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Il y a 2 heures</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="flex items-center space-x-1">
                                <button class="text-gray-400 hover:text-green-600 p-1">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="text-gray-400 hover:text-red-600 p-1">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button class="text-gray-400 hover:text-yellow-600 p-1">
                                    <i class="fas fa-flag"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h5 class="font-medium text-gray-900 dark:text-white mb-1">L'Art de la Programmation</h5>
                        <p class="text-sm text-gray-600 dark:text-gray-400">par Donald Knuth • Technologie</p>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                        "Excellent livre pour comprendre les fondamentaux de la programmation. Les explications sont claires et les exemples très pertinents. Je le recommande vivement à tous les développeurs, débutants comme expérimentés."
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex items-center space-x-4">
                            <span><i class="fas fa-thumbs-up mr-1"></i>24 utiles</span>
                            <span><i class="fas fa-reply mr-1"></i>3 réponses</span>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Approuvé</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Item 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-start space-x-4">
                <img class="w-12 h-12 rounded-full" src="https://ui-avatars.com/api/?name=Jean+Martin&background=10b981&color=fff" alt="Jean Martin">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Jean Martin</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Il y a 5 heures</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <div class="flex items-center space-x-1">
                                <button class="text-gray-400 hover:text-green-600 p-1">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="text-gray-400 hover:text-red-600 p-1">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button class="text-gray-400 hover:text-yellow-600 p-1">
                                    <i class="fas fa-flag"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h5 class="font-medium text-gray-900 dark:text-white mb-1">Intelligence Artificielle Moderne</h5>
                        <p class="text-sm text-gray-600 dark:text-gray-400">par Stuart Russell • Science</p>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                        "Livre très complet sur l'IA. Couvre bien les aspects théoriques et pratiques. Quelques passages un peu techniques mais dans l'ensemble très accessible. Parfait pour se mettre à jour sur les dernières avancées."
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex items-center space-x-4">
                            <span><i class="fas fa-thumbs-up mr-1"></i>18 utiles</span>
                            <span><i class="fas fa-reply mr-1"></i>1 réponse</span>
                        </div>
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">En attente</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Item 3 - Flagged -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-red-200 dark:border-red-700">
            <div class="flex items-start space-x-4">
                <img class="w-12 h-12 rounded-full" src="https://ui-avatars.com/api/?name=Pierre+Durand&background=ef4444&color=fff" alt="Pierre Durand">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Pierre Durand</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Il y a 1 jour</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <div class="flex items-center space-x-1">
                                <button class="text-gray-400 hover:text-green-600 p-1">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="text-gray-400 hover:text-red-600 p-1">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button class="text-red-600 p-1">
                                    <i class="fas fa-flag"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h5 class="font-medium text-gray-900 dark:text-white mb-1">Design Patterns</h5>
                        <p class="text-sm text-gray-600 dark:text-gray-400">par Gang of Four • Technologie</p>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                        "Livre complètement dépassé, les exemples ne fonctionnent plus avec les technologies actuelles. Perte de temps totale."
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex items-center space-x-4">
                            <span><i class="fas fa-thumbs-down mr-1"></i>12 non utiles</span>
                            <span><i class="fas fa-flag mr-1 text-red-500"></i>5 signalements</span>
                        </div>
                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Signalé</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Distribution -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Distribution des Notes</h3>
        
        <div class="space-y-4">
            <div class="flex items-center">
                <div class="flex items-center w-20">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">5</span>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
                <div class="flex-1 mx-4">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-green-500 h-3 rounded-full" style="width: 68%"></div>
                    </div>
                </div>
                <span class="text-sm text-gray-600 dark:text-gray-400 w-16 text-right">2,208 (68%)</span>
            </div>
            
            <div class="flex items-center">
                <div class="flex items-center w-20">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">4</span>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
                <div class="flex-1 mx-4">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-blue-500 h-3 rounded-full" style="width: 21%"></div>
                    </div>
                </div>
                <span class="text-sm text-gray-600 dark:text-gray-400 w-16 text-right">682 (21%)</span>
            </div>
            
            <div class="flex items-center">
                <div class="flex items-center w-20">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">3</span>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
                <div class="flex-1 mx-4">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-yellow-500 h-3 rounded-full" style="width: 7%"></div>
                    </div>
                </div>
                <span class="text-sm text-gray-600 dark:text-gray-400 w-16 text-right">227 (7%)</span>
            </div>
            
            <div class="flex items-center">
                <div class="flex items-center w-20">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">2</span>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
                <div class="flex-1 mx-4">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-orange-500 h-3 rounded-full" style="width: 3%"></div>
                    </div>
                </div>
                <span class="text-sm text-gray-600 dark:text-gray-400 w-16 text-right">97 (3%)</span>
            </div>
            
            <div class="flex items-center">
                <div class="flex items-center w-20">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">1</span>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
                <div class="flex-1 mx-4">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-red-500 h-3 rounded-full" style="width: 1%"></div>
                    </div>
                </div>
                <span class="text-sm text-gray-600 dark:text-gray-400 w-16 text-right">33 (1%)</span>
            </div>
        </div>
    </div>
@endsection
