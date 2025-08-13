@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Revenus</h1>
            <p class="text-gray-600 dark:text-gray-400">Suivez vos gains et vos ventes</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('author.revenue.reports') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-chart-line mr-2"></i>Rapports
            </a>
            <a href="{{ route('author.revenue.payouts') }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-money-bill-wave mr-2"></i>Paiements
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="fas fa-dollar-sign text-green-600 dark:text-green-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Revenus totaux</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($stats['total_earnings'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <i class="fas fa-calendar-month text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ce mois</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($stats['this_month'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">En attente</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($stats['pending_payouts'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-teal-100 dark:bg-purple-900 rounded-lg">
                    <i class="fas fa-download text-teal-600 dark:text-purple-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total ventes</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_sales']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Évolution des revenus</h3>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg">7j</button>
                <button class="px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">30j</button>
                <button class="px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">90j</button>
            </div>
        </div>
        <div class="h-64 flex items-center justify-center text-gray-500">
            <div class="text-center">
                <i class="fas fa-chart-line text-4xl mb-4"></i>
                <p>Graphique des revenus</p>
                <p class="text-sm">Fonctionnalité à implémenter</p>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Transactions récentes</h3>
        </div>
        <div class="p-6">
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-receipt text-4xl mb-4"></i>
                <p>Aucune transaction récente</p>
                <p class="text-sm">Les transactions apparaîtront ici une fois le système de paiement configuré</p>
            </div>
        </div>
    </div>
</div>
@endsection
