@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Paiements</h1>
            <p class="text-gray-600 dark:text-gray-400">Gérez vos paiements et méthodes de paiement</p>
        </div>
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Demander un paiement
        </button>
    </div>

    <!-- Payment Methods -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Méthodes de paiement</h3>
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>Ajouter une méthode
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fab fa-paypal text-2xl text-blue-600 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">PayPal</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">user@example.com</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Principal</span>
                </div>
            </div>
            
            <div class="border border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <i class="fas fa-plus text-2xl mb-2"></i>
                    <p>Ajouter une méthode</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payout Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Paiements reçus</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">$0.00</p>
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
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">$0.00</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <i class="fas fa-wallet text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Disponible</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">$0.00</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payout History -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Historique des paiements</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Méthode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-money-bill-wave text-4xl mb-4"></i>
                            <p>Aucun paiement effectué</p>
                            <p class="text-sm">Vos paiements apparaîtront ici une fois configurés</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payout Settings -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Paramètres de paiement</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Seuil minimum</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 py-2 border border-r-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 text-sm rounded-l-lg">$</span>
                    <input type="number" value="50" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-r-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Montant minimum pour déclencher un paiement automatique</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fréquence</label>
                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                    <option>Mensuel</option>
                    <option>Hebdomadaire</option>
                    <option>Manuel</option>
                </select>
            </div>
        </div>
        <div class="mt-6">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Sauvegarder les paramètres
            </button>
        </div>
    </div>
</div>
@endsection
