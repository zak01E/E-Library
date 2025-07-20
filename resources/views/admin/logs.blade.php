@extends('layouts.admin-dashboard')

@section('page-title', 'Logs Système')
@section('page-description', 'Consultez et analysez les logs de votre application')

@section('content')
    <!-- Log Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                    <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Erreurs (24h)</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">3</p>
                    <p class="text-xs text-red-600 dark:text-red-400">-2 vs hier</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                    <i class="fas fa-exclamation-circle text-yellow-600 dark:text-yellow-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Avertissements</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">12</p>
                    <p class="text-xs text-yellow-600 dark:text-yellow-400">+3 vs hier</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Informations</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">847</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400">+124 vs hier</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gray-100 dark:bg-gray-700">
                    <i class="fas fa-file-alt text-gray-600 dark:text-gray-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Taille des logs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">24 MB</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">15 fichiers</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Log Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filtres</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Niveau</label>
                    <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        <option>Tous les niveaux</option>
                        <option>Erreur</option>
                        <option>Avertissement</option>
                        <option>Information</option>
                        <option>Debug</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date</label>
                    <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        <option>Aujourd'hui</option>
                        <option>Hier</option>
                        <option>7 derniers jours</option>
                        <option>30 derniers jours</option>
                        <option>Personnalisé</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Source</label>
                    <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        <option>Toutes les sources</option>
                        <option>Application</option>
                        <option>Base de données</option>
                        <option>Authentification</option>
                        <option>API</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Recherche</label>
                    <input type="text" placeholder="Rechercher dans les logs..." 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            <div class="flex justify-between items-center mt-4">
                <div class="flex space-x-2">
                    <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm transition-colors">
                        <i class="fas fa-search mr-2"></i>Filtrer
                    </button>
                    <button class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm transition-colors">
                        <i class="fas fa-undo mr-2"></i>Réinitialiser
                    </button>
                </div>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm transition-colors">
                        <i class="fas fa-download mr-2"></i>Exporter
                    </button>
                    <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm transition-colors">
                        <i class="fas fa-trash mr-2"></i>Nettoyer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Log Entries -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Entrées de Log</h3>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded-full">Auto-refresh</button>
                    <span class="text-sm text-gray-600 dark:text-gray-400">862 entrées</span>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-3 max-h-96 overflow-y-auto">
                <!-- Error Log -->
                <div class="flex items-start space-x-3 p-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-2 h-2 bg-red-500 rounded-full mt-2"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-200 text-xs rounded-full font-medium">ERROR</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">2025-01-18 14:32:15</span>
                            </div>
                            <button class="text-red-600 hover:text-red-700 text-sm">
                                <i class="fas fa-expand-alt"></i>
                            </button>
                        </div>
                        <p class="text-sm text-red-900 dark:text-red-100 mt-1">
                            <strong>Database connection failed:</strong> SQLSTATE[HY000] [2002] Connection refused
                        </p>
                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">
                            File: /app/database/Connection.php:45 | User: system
                        </p>
                    </div>
                </div>

                <!-- Warning Log -->
                <div class="flex items-start space-x-3 p-4 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-200 text-xs rounded-full font-medium">WARNING</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">2025-01-18 14:28:42</span>
                            </div>
                            <button class="text-yellow-600 hover:text-yellow-700 text-sm">
                                <i class="fas fa-expand-alt"></i>
                            </button>
                        </div>
                        <p class="text-sm text-yellow-900 dark:text-yellow-100 mt-1">
                            <strong>High memory usage detected:</strong> 85% of available memory in use
                        </p>
                        <p class="text-xs text-yellow-600 dark:text-yellow-300 mt-1">
                            File: /app/monitoring/MemoryMonitor.php:23 | User: marie.dubois@example.com
                        </p>
                    </div>
                </div>

                <!-- Info Log -->
                <div class="flex items-start space-x-3 p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 text-xs rounded-full font-medium">INFO</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">2025-01-18 14:25:18</span>
                            </div>
                            <button class="text-blue-600 hover:text-blue-700 text-sm">
                                <i class="fas fa-expand-alt"></i>
                            </button>
                        </div>
                        <p class="text-sm text-blue-900 dark:text-blue-100 mt-1">
                            <strong>User login successful:</strong> User marie.dubois@example.com logged in successfully
                        </p>
                        <p class="text-xs text-blue-600 dark:text-blue-300 mt-1">
                            File: /app/auth/LoginController.php:67 | IP: 192.168.1.100
                        </p>
                    </div>
                </div>

                <!-- Success Log -->
                <div class="flex items-start space-x-3 p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 text-xs rounded-full font-medium">SUCCESS</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">2025-01-18 14:20:33</span>
                            </div>
                            <button class="text-green-600 hover:text-green-700 text-sm">
                                <i class="fas fa-expand-alt"></i>
                            </button>
                        </div>
                        <p class="text-sm text-green-900 dark:text-green-100 mt-1">
                            <strong>Book upload completed:</strong> "Introduction to AI" by Jean Martin uploaded successfully
                        </p>
                        <p class="text-xs text-green-600 dark:text-green-300 mt-1">
                            File: /app/books/BookController.php:124 | Size: 2.4MB
                        </p>
                    </div>
                </div>

                <!-- Debug Log -->
                <div class="flex items-start space-x-3 p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-2 h-2 bg-gray-500 rounded-full mt-2"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 text-xs rounded-full font-medium">DEBUG</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">2025-01-18 14:18:55</span>
                            </div>
                            <button class="text-gray-600 hover:text-gray-700 text-sm">
                                <i class="fas fa-expand-alt"></i>
                            </button>
                        </div>
                        <p class="text-sm text-gray-900 dark:text-gray-100 mt-1">
                            <strong>Cache cleared:</strong> Application cache cleared successfully (127 entries removed)
                        </p>
                        <p class="text-xs text-gray-600 dark:text-gray-300 mt-1">
                            File: /app/cache/CacheManager.php:89 | Duration: 0.234s
                        </p>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Affichage de 1 à 50 sur 862 entrées
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded text-sm">
                        Précédent
                    </button>
                    <button class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">1</button>
                    <button class="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded text-sm">2</button>
                    <button class="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded text-sm">3</button>
                    <button class="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded text-sm">
                        Suivant
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
