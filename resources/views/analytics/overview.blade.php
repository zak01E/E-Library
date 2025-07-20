@extends('layouts.main-dashboard')

@section('title', 'Analytics - Vue d\'ensemble')
@section('page-title', 'Analytics & Rapports')
@section('page-description', 'Analysez les performances de votre plateforme E-Library')

@section('content')
    <!-- Time Period Selector -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center space-x-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Vue d'ensemble</h2>
            <div class="flex items-center space-x-2">
                <button class="px-3 py-1 text-sm bg-indigo-100 text-indigo-700 rounded-full">7 jours</button>
                <button class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200">30 jours</button>
                <button class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200">90 jours</button>
                <button class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200">1 an</button>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-download"></i>
                <span>Exporter</span>
            </button>
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-chart-line"></i>
                <span>Rapport Détaillé</span>
            </button>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-eye text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">247.3k</div>
                    <div class="text-sm text-green-600 dark:text-green-400 flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i>+12.5%
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Pages Vues</h3>
                <p class="text-xs text-gray-500 dark:text-gray-500">vs période précédente</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <i class="fas fa-users text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">18.4k</div>
                    <div class="text-sm text-green-600 dark:text-green-400 flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i>+8.2%
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Utilisateurs Uniques</h3>
                <p class="text-xs text-gray-500 dark:text-gray-500">vs période précédente</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                    <i class="fas fa-download text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">94.3k</div>
                    <div class="text-sm text-green-600 dark:text-green-400 flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i>+23.1%
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Téléchargements</h3>
                <p class="text-xs text-gray-500 dark:text-gray-500">vs période précédente</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900">
                    <i class="fas fa-clock text-orange-600 dark:text-orange-400 text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">4m 32s</div>
                    <div class="text-sm text-red-600 dark:text-red-400 flex items-center">
                        <i class="fas fa-arrow-down mr-1"></i>-2.3%
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Temps Moyen</h3>
                <p class="text-xs text-gray-500 dark:text-gray-500">sur la plateforme</p>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Traffic Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Trafic des 7 derniers jours</h3>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Visiteurs</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Pages vues</span>
                    </div>
                </div>
            </div>
            <div class="h-64 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-chart-area text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-500 dark:text-gray-400">Graphique de trafic (Chart.js)</p>
                </div>
            </div>
        </div>

        <!-- Device Breakdown -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Répartition par Appareil</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <i class="fas fa-desktop text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Desktop</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">12,847 visiteurs</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900 dark:text-white">58.3%</p>
                        <div class="w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 58.3%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                            <i class="fas fa-mobile-alt text-green-600 dark:text-green-400"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Mobile</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">7,234 visiteurs</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900 dark:text-white">32.8%</p>
                        <div class="w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 32.8%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                            <i class="fas fa-tablet-alt text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Tablette</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">1,956 visiteurs</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900 dark:text-white">8.9%</p>
                        <div class="w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: 8.9%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Top Categories -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Catégories Populaires</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Fiction</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">34.2%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Science</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">28.7%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Technologie</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">19.4%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Histoire</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">17.7%</span>
                </div>
            </div>
        </div>

        <!-- Geographic Distribution -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Répartition Géographique</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg">🇫🇷</span>
                        <span class="text-sm text-gray-700 dark:text-gray-300">France</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">45.3%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg">🇨🇦</span>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Canada</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">18.7%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg">🇧🇪</span>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Belgique</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">12.4%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg">🇨🇭</span>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Suisse</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">9.8%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg">🌍</span>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Autres</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">13.8%</span>
                </div>
            </div>
        </div>

        <!-- User Engagement -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Engagement Utilisateurs</h3>
            <div class="space-y-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-1">73.2%</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Taux de rétention</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400 mb-1">2.4</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Pages par session</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400 mb-1">68.7%</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Taux de conversion</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Activité Récente</h3>
            <button class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Voir tout</button>
        </div>
        
        <div class="space-y-4">
            <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-book text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Nouveau livre publié</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">"Les Secrets de l'IA" par Marie Dubois • Il y a 2 heures</p>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">+247 vues</div>
            </div>
            
            <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-plus text-green-600 dark:text-green-400"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Pic d'inscriptions</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">+127 nouveaux utilisateurs aujourd'hui</p>
                </div>
                <div class="text-sm text-green-600 dark:text-green-400">+23% vs hier</div>
            </div>
            
            <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-purple-600 dark:text-purple-400"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Évaluation exceptionnelle</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">"Design Patterns" a reçu une note de 5/5</p>
                </div>
                <div class="text-sm text-purple-600 dark:text-purple-400">Note moyenne: 4.9</div>
            </div>
        </div>
    </div>
@endsection
