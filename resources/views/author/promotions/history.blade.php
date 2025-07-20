@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Historique des promotions</h1>
            <p class="text-gray-600 dark:text-gray-400">Consultez les performances de vos anciennes campagnes</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('author.promotions.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>Nouvelle promotion
            </a>
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-download mr-2"></i>Exporter
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filtres</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Période</label>
                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                    <option>Toutes les périodes</option>
                    <option>30 derniers jours</option>
                    <option>3 derniers mois</option>
                    <option>Cette année</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                    <option>Tous les types</option>
                    <option>Réduction</option>
                    <option>Livre gratuit</option>
                    <option>Pack</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Statut</label>
                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                    <option>Tous les statuts</option>
                    <option>Terminée</option>
                    <option>Annulée</option>
                    <option>Expirée</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Appliquer
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <i class="fas fa-bullhorn text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total promotions</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Réussies</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                    <i class="fas fa-mouse-pointer text-purple-600 dark:text-purple-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Clics totaux</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                    <i class="fas fa-percentage text-yellow-600 dark:text-yellow-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Taux moyen</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">0%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Promotions History Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Historique détaillé</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Promotion</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Période</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Vues</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Clics</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Conversion</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-history text-4xl mb-4"></i>
                            <p>Aucune promotion dans l'historique</p>
                            <p class="text-sm mb-4">Créez votre première promotion pour voir les données ici</p>
                            <a href="{{ route('author.promotions.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i>Créer une promotion
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Performance Insights -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Insights de performance</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Meilleures promotions</h4>
                <div class="space-y-3">
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-trophy text-3xl mb-3"></i>
                        <p>Aucune donnée disponible</p>
                    </div>
                </div>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Tendances par type</h4>
                <div class="h-48 flex items-center justify-center text-gray-500">
                    <div class="text-center">
                        <i class="fas fa-chart-pie text-3xl mb-3"></i>
                        <p>Graphique des tendances</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
