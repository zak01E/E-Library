@extends('layouts.main-dashboard')

@section('title', 'Campagnes Marketing')
@section('page-title', 'Campagnes Marketing')
@section('page-description', 'Créez et gérez vos campagnes de promotion pour augmenter l\'engagement')

@section('content')
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-rocket text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Campagnes Actives</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">12</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+3 ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <i class="fas fa-eye text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Impressions</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">847.2k</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+23% ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-teal-100 dark:bg-purple-900">
                    <i class="fas fa-mouse-pointer text-teal-600 dark:text-purple-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Taux de Clic</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">4.7%</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+0.8% ce mois</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900">
                    <i class="fas fa-dollar-sign text-orange-600 dark:text-orange-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">ROI Moyen</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">312%</p>
                    <p class="text-xs text-green-600 dark:text-green-400">+45% ce mois</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Nouvelle Campagne</span>
            </button>
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-play"></i>
                <span>Lancer Sélectionnées</span>
            </button>
            <select class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option>Tous les statuts</option>
                <option>Actives</option>
                <option>En pause</option>
                <option>Terminées</option>
                <option>Brouillons</option>
            </select>
        </div>
        
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="text" placeholder="Rechercher une campagne..." 
                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Campaigns Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Campaign Card 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="p-3 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg">
                        <i class="fas fa-book-open text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Promotion Livres Tech</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Email + Social Media</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition 
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600 z-10">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Modifier</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Dupliquer</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Mettre en pause</a>
                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">247.3k</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Impressions</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">11.6k</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Clics</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">4.7%</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">CTR</div>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Budget utilisé</span>
                    <span class="font-medium text-gray-900 dark:text-white">€2,340 / €3,000</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 78%"></div>
                </div>
            </div>
            
            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                <span>Lancée il y a 5 jours</span>
                <span>Se termine dans 9 jours</span>
            </div>
        </div>

        <!-- Campaign Card 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="p-3 bg-gradient-to-br from-green-400 to-green-600 rounded-lg">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Rentrée Étudiante</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Display + Search</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">189.7k</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Impressions</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">8.9k</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Clics</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">4.7%</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">CTR</div>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Budget utilisé</span>
                    <span class="font-medium text-gray-900 dark:text-white">€1,890 / €2,500</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 75.6%"></div>
                </div>
            </div>
            
            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                <span>Lancée il y a 12 jours</span>
                <span>Se termine dans 3 jours</span>
            </div>
        </div>

        <!-- Campaign Card 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="p-3 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg">
                        <i class="fas fa-heart text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Saint-Valentin Romance</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Social Media</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">En pause</span>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">156.2k</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Impressions</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">7.3k</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Clics</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white">4.7%</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">CTR</div>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Budget utilisé</span>
                    <span class="font-medium text-gray-900 dark:text-white">€890 / €1,500</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-teal-500 h-2 rounded-full" style="width: 59.3%"></div>
                </div>
            </div>
            
            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                <span>Mise en pause il y a 2 jours</span>
                <span>Budget restant: €610</span>
            </div>
        </div>

        <!-- Campaign Card 4 -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="p-3 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg">
                        <i class="fas fa-leaf text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Développement Durable</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Email Newsletter</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Brouillon</span>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-400">-</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Impressions</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-400">-</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Clics</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-400">-</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">CTR</div>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Budget alloué</span>
                    <span class="font-medium text-gray-900 dark:text-white">€0 / €2,000</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-gray-400 h-2 rounded-full" style="width: 0%"></div>
                </div>
            </div>
            
            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                <span>Créée il y a 1 jour</span>
                <button class="text-emerald-600 hover:text-emerald-700 font-medium">Lancer la campagne</button>
            </div>
        </div>
    </div>

    <!-- Performance Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Performance des Campagnes</h3>
            <div class="flex items-center space-x-2">
                <button class="px-3 py-1 text-sm bg-emerald-100 text-emerald-700 rounded-full">7 jours</button>
                <button class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200">30 jours</button>
                <button class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200">90 jours</button>
            </div>
        </div>
        <div class="h-64 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center">
            <div class="text-center">
                <i class="fas fa-chart-line text-4xl text-gray-400 mb-2"></i>
                <p class="text-gray-500 dark:text-gray-400">Graphique de performance des campagnes (Chart.js)</p>
            </div>
        </div>
    </div>

    <!-- Campaign Templates -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Modèles de Campagne</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:border-indigo-300 cursor-pointer transition-colors">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <i class="fas fa-envelope text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h4 class="font-medium text-gray-900 dark:text-white">Email Marketing</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Campagne email ciblée avec segmentation automatique</p>
                <button class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">Utiliser ce modèle</button>
            </div>
            
            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:border-indigo-300 cursor-pointer transition-colors">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                        <i class="fas fa-share-alt text-green-600 dark:text-green-400"></i>
                    </div>
                    <h4 class="font-medium text-gray-900 dark:text-white">Réseaux Sociaux</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Promotion multi-plateformes avec contenu adapté</p>
                <button class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">Utiliser ce modèle</button>
            </div>
            
            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:border-indigo-300 cursor-pointer transition-colors">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="p-2 bg-teal-100 dark:bg-purple-900 rounded-lg">
                        <i class="fas fa-bullhorn text-teal-600 dark:text-purple-400"></i>
                    </div>
                    <h4 class="font-medium text-gray-900 dark:text-white">Display Ads</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Bannières publicitaires avec retargeting intelligent</p>
                <button class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">Utiliser ce modèle</button>
            </div>
        </div>
    </div>
@endsection
