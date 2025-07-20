@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Promotions</h1>
            <p class="text-gray-600 dark:text-gray-400">Gérez vos campagnes promotionnelles</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('author.promotions.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>Nouvelle promotion
            </a>
            <a href="{{ route('author.promotions.history') }}" 
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-history mr-2"></i>Historique
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="fas fa-bullhorn text-green-600 dark:text-green-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Actives</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <i class="fas fa-eye text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Vues totales</p>
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
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Clics</p>
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
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Taux de conversion</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">0%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Promotions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Promotions actives</h3>
        </div>
        <div class="p-6">
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-bullhorn text-4xl mb-4"></i>
                <p>Aucune promotion active</p>
                <p class="text-sm mb-4">Créez votre première campagne promotionnelle pour augmenter vos ventes</p>
                <a href="{{ route('author.promotions.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Créer une promotion
                </a>
            </div>
        </div>
    </div>

    <!-- Promotion Templates -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Modèles de promotion</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-colors">
                <div class="flex items-center mb-3">
                    <i class="fas fa-percentage text-blue-600 text-xl mr-3"></i>
                    <h4 class="font-medium text-gray-900 dark:text-white">Réduction</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Offrez une réduction sur vos livres pour une période limitée</p>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-colors">
                <div class="flex items-center mb-3">
                    <i class="fas fa-gift text-green-600 text-xl mr-3"></i>
                    <h4 class="font-medium text-gray-900 dark:text-white">Livre gratuit</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Proposez un livre gratuit pour attirer de nouveaux lecteurs</p>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-colors">
                <div class="flex items-center mb-3">
                    <i class="fas fa-layer-group text-purple-600 text-xl mr-3"></i>
                    <h4 class="font-medium text-gray-900 dark:text-white">Pack</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Créez un pack de plusieurs livres à prix réduit</p>
            </div>
        </div>
    </div>

    <!-- Performance Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Performance des promotions</h3>
        <div class="h-64 flex items-center justify-center text-gray-500">
            <div class="text-center">
                <i class="fas fa-chart-bar text-4xl mb-4"></i>
                <p>Graphique de performance</p>
                <p class="text-sm">Les données apparaîtront après la création de promotions</p>
            </div>
        </div>
    </div>
</div>
@endsection
