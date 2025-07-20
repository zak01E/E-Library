@extends('layouts.main-dashboard')

@section('title', 'Dashboard Principal')
@section('page-title', 'Dashboard Principal')
@section('page-description', 'Vue d\'ensemble de votre plateforme E-Library')

@section('content')
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-book text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Livres</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">2,847</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+12% ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <i class="fas fa-users text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Utilisateurs Actifs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">18,492</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+8% ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                    <i class="fas fa-download text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Téléchargements</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">94,328</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+23% ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900">
                    <i class="fas fa-star text-orange-600 dark:text-orange-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Note Moyenne</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">4.8</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+0.2 ce mois</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Activity Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Activité des 7 derniers jours</h3>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded-full">Téléchargements</button>
                    <button class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">Lectures</button>
                </div>
            </div>
            <div class="h-64 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                <p class="text-gray-500 dark:text-gray-400">Graphique d'activité (Chart.js)</p>
            </div>
        </div>

        <!-- Popular Categories -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Catégories Populaires</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Fiction</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-3">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">85%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Science</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-3">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 72%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">72%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Histoire</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-3">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: 68%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">68%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-orange-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Technologie</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-3">
                            <div class="bg-orange-500 h-2 rounded-full" style="width: 54%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">54%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Top Books -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activity -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Activité Récente</h3>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-book text-blue-600 dark:text-blue-400 text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900 dark:text-white">Nouveau livre ajouté</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">"Les Mystères de l'IA" par Marie Dubois</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">Il y a 2 heures</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-plus text-green-600 dark:text-green-400 text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900 dark:text-white">Nouvel utilisateur inscrit</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Jean Martin a rejoint la plateforme</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">Il y a 4 heures</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-star text-purple-600 dark:text-purple-400 text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900 dark:text-white">Nouvelle évaluation</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">5 étoiles pour "Guide du Développeur"</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">Il y a 6 heures</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Books -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Livres les Plus Populaires</h3>
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-white"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">L'Art de la Programmation</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">par Donald Knuth</p>
                        <div class="flex items-center mt-1">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star text-xs"></i>
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">4.9 (234 avis)</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">1,247</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">téléchargements</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-white"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">Intelligence Artificielle Moderne</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">par Stuart Russell</p>
                        <div class="flex items-center mt-1">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star-half-alt text-xs"></i>
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">4.7 (189 avis)</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">892</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">téléchargements</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-white"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">Design Patterns</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">par Gang of Four</p>
                        <div class="flex items-center mt-1">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star text-xs"></i>
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">4.8 (156 avis)</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">743</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">téléchargements</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
