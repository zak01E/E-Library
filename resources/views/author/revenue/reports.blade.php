@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Rapports de revenus</h1>
            <p class="text-gray-600 dark:text-gray-400">Analyses détaillées de vos performances</p>
        </div>
        <div class="flex space-x-3">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-download mr-2"></i>Exporter PDF
            </button>
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-file-excel mr-2"></i>Exporter Excel
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
                    <option>7 derniers jours</option>
                    <option>30 derniers jours</option>
                    <option>3 derniers mois</option>
                    <option>Cette année</option>
                    <option>Personnalisé</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Livre</label>
                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                    <option>Tous les livres</option>
                    <option>Livre 1</option>
                    <option>Livre 2</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                    <option>Tous les types</option>
                    <option>Ventes</option>
                    <option>Royalties</option>
                    <option>Bonus</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Appliquer
                </button>
            </div>
        </div>
    </div>

    <!-- Performance Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Performance par livre</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Livre Example 1</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">125 téléchargements</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-green-600">$245.50</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">+12%</p>
                    </div>
                </div>
                <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Livre Example 2</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">89 téléchargements</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-green-600">$178.00</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">+8%</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tendances</h3>
            <div class="h-48 flex items-center justify-center text-gray-500">
                <div class="text-center">
                    <i class="fas fa-chart-area text-4xl mb-4"></i>
                    <p>Graphique des tendances</p>
                    <p class="text-sm">Fonctionnalité à implémenter</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Report Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Rapport détaillé</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Livre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Statut</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-table text-4xl mb-4"></i>
                            <p>Aucune donnée disponible</p>
                            <p class="text-sm">Les rapports détaillés apparaîtront ici</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
