@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Mes Collections</h1>
            <p class="text-gray-600 dark:text-gray-400">Organisez vos livres en collections thématiques</p>
        </div>
        <a href="{{ route('author.collections.create') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Nouvelle collection
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <i class="fas fa-layer-group text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Collections</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="fas fa-book text-green-600 dark:text-green-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Livres organisés</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                    <i class="fas fa-eye text-purple-600 dark:text-purple-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Vues totales</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                    <i class="fas fa-star text-yellow-600 dark:text-yellow-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Collections populaires</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Collections Grid -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Vos collections</h3>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg">Toutes</button>
                    <button class="px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Publiques</button>
                    <button class="px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Privées</button>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-layer-group text-6xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Aucune collection créée</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Organisez vos livres en collections thématiques pour faciliter la découverte par vos lecteurs.
                </p>
                <a href="{{ route('author.collections.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Créer ma première collection
                </a>
            </div>
        </div>
    </div>

    <!-- Collection Ideas -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Idées de collections</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-colors">
                <div class="flex items-center mb-3">
                    <i class="fas fa-heart text-red-600 text-xl mr-3"></i>
                    <h4 class="font-medium text-gray-900 dark:text-white">Série Romance</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Regroupez vos romans d'amour en une série cohérente</p>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-colors">
                <div class="flex items-center mb-3">
                    <i class="fas fa-graduation-cap text-blue-600 text-xl mr-3"></i>
                    <h4 class="font-medium text-gray-900 dark:text-white">Guide Pratique</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Créez une collection de guides sur un sujet spécifique</p>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-colors">
                <div class="flex items-center mb-3">
                    <i class="fas fa-clock text-green-600 text-xl mr-3"></i>
                    <h4 class="font-medium text-gray-900 dark:text-white">Chronologique</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Organisez vos livres par ordre chronologique ou historique</p>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-colors">
                <div class="flex items-center mb-3">
                    <i class="fas fa-users text-purple-600 text-xl mr-3"></i>
                    <h4 class="font-medium text-gray-900 dark:text-white">Par Personnage</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Regroupez les livres autour d'un personnage principal</p>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-colors">
                <div class="flex items-center mb-3">
                    <i class="fas fa-map text-orange-600 text-xl mr-3"></i>
                    <h4 class="font-medium text-gray-900 dark:text-white">Par Univers</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Créez des collections basées sur un univers fictif</p>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-colors">
                <div class="flex items-center mb-3">
                    <i class="fas fa-star text-yellow-600 text-xl mr-3"></i>
                    <h4 class="font-medium text-gray-900 dark:text-white">Meilleures Ventes</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Mettez en avant vos livres les plus populaires</p>
            </div>
        </div>
    </div>

    <!-- Benefits -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900 dark:to-indigo-900 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pourquoi créer des collections ?</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-start">
                <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg mr-4">
                    <i class="fas fa-search text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-1">Meilleure découverte</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Aidez vos lecteurs à découvrir vos autres œuvres</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="p-2 bg-green-100 dark:bg-green-800 rounded-lg mr-4">
                    <i class="fas fa-chart-line text-green-600 dark:text-green-400"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-1">Augmentation des ventes</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Les collections encouragent l'achat de plusieurs livres</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="p-2 bg-purple-100 dark:bg-purple-800 rounded-lg mr-4">
                    <i class="fas fa-bookmark text-purple-600 dark:text-purple-400"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-1">Organisation claire</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Présentez votre travail de manière structurée</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="p-2 bg-orange-100 dark:bg-orange-800 rounded-lg mr-4">
                    <i class="fas fa-users text-orange-600 dark:text-orange-400"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-1">Fidélisation</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Créez une relation durable avec vos lecteurs</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
