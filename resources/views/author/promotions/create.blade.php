@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Créer une promotion</h1>
            <p class="text-gray-600 dark:text-gray-400">Configurez votre campagne promotionnelle</p>
        </div>
        <a href="{{ route('author.promotions') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <form action="{{ route('author.promotions.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Basic Information -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informations de base</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom de la promotion</label>
                    <input type="text" name="name" required 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
                           placeholder="Ex: Promotion d'été 2024">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type de promotion</label>
                    <select name="type" required 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                        <option value="">Sélectionner un type</option>
                        <option value="discount">Réduction</option>
                        <option value="free">Livre gratuit</option>
                        <option value="bundle">Pack de livres</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <textarea name="description" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
                          placeholder="Décrivez votre promotion..."></textarea>
            </div>
        </div>

        <!-- Promotion Details -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Détails de la promotion</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Livres concernés</label>
                    <select name="books[]" multiple 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                        <option value="all">Tous mes livres</option>
                        <option value="1">Livre Example 1</option>
                        <option value="2">Livre Example 2</option>
                    </select>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Maintenez Ctrl pour sélectionner plusieurs livres</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Valeur de la promotion</label>
                    <div class="flex">
                        <input type="number" name="value" min="0" max="100" 
                               class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
                               placeholder="20">
                        <select name="value_type" 
                                class="px-3 py-2 border border-l-0 border-gray-300 dark:border-gray-600 rounded-r-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                            <option value="percent">%</option>
                            <option value="fixed">€</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Planification</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date de début</label>
                    <input type="datetime-local" name="start_date" required 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date de fin</label>
                    <input type="datetime-local" name="end_date" required 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                </div>
            </div>
        </div>

        <!-- Targeting -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ciblage</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Audience cible</label>
                    <select name="target_audience" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                        <option value="all">Tous les utilisateurs</option>
                        <option value="new">Nouveaux lecteurs</option>
                        <option value="existing">Lecteurs existants</option>
                        <option value="subscribers">Abonnés</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Limite d'utilisation</label>
                    <input type="number" name="usage_limit" min="1" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
                           placeholder="Illimité">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Laissez vide pour illimité</p>
                </div>
            </div>
        </div>

        <!-- Marketing -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Marketing</h3>
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" name="email_notification" id="email_notification" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="email_notification" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                        Envoyer une notification email aux abonnés
                    </label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="social_media" id="social_media" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="social_media" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                        Partager sur les réseaux sociaux
                    </label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="featured" id="featured" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="featured" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                        Mettre en avant sur la page d'accueil
                    </label>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('author.promotions') }}" 
               class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                Annuler
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-save mr-2"></i>Créer la promotion
            </button>
        </div>
    </form>
</div>
@endsection
