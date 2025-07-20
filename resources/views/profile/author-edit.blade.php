@extends('layouts.author-dashboard')

@section('title', 'Mon Profil')

@section('content')
    <div class="space-y-4">
        <!-- Header Compact -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                         src="{{ auth()->user()->profile_photo_url }}"
                         alt="{{ auth()->user()->name }}">
                    <div class="ml-3">
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Auteur • Membre depuis {{ auth()->user()->created_at->format('M Y') }}</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Actif</span>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Vérifié</span>
                </div>
            </div>
        </div>

        <!-- Two Column Layout for Forms -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Left Column -->
            <div class="space-y-4">
                <!-- Profile Photo -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-4">
                        @include('profile.partials.update-profile-photo-form')
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <!-- Update Password -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-4">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Author Statistics - Compact Table -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-chart-bar w-5 h-5 mr-2 text-blue-600"></i>
                    Statistiques d'auteur
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-700 dark:text-gray-300">Métrique</th>
                            <th class="px-4 py-2 text-center font-medium text-gray-700 dark:text-gray-300">Valeur</th>
                            <th class="px-4 py-2 text-center font-medium text-gray-700 dark:text-gray-300">Évolution</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 flex items-center">
                                <i class="fas fa-book text-blue-500 mr-2"></i>
                                <span class="text-gray-900 dark:text-white">Livres publiés</span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-lg font-bold text-blue-600">{{ auth()->user()->books()->count() }}</span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">
                                    <i class="fas fa-arrow-up"></i> +2 ce mois
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 flex items-center">
                                <i class="fas fa-download text-green-500 mr-2"></i>
                                <span class="text-gray-900 dark:text-white">Téléchargements</span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-lg font-bold text-green-600">{{ number_format(auth()->user()->books()->sum('downloads')) }}</span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">
                                    <i class="fas fa-arrow-up"></i> +15%
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 flex items-center">
                                <i class="fas fa-eye text-purple-500 mr-2"></i>
                                <span class="text-gray-900 dark:text-white">Vues totales</span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-lg font-bold text-purple-600">{{ number_format(auth()->user()->books()->sum('views')) }}</span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded-full">
                                    <i class="fas fa-arrow-up"></i> +8%
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 flex items-center">
                                <i class="fas fa-star text-yellow-500 mr-2"></i>
                                <span class="text-gray-900 dark:text-white">Note moyenne</span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-lg font-bold text-yellow-600">4.2/5</span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">
                                    <i class="fas fa-minus"></i> Stable
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 flex items-center">
                                <i class="fas fa-dollar-sign text-green-500 mr-2"></i>
                                <span class="text-gray-900 dark:text-white">Revenus totaux</span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-lg font-bold text-green-600">€0.00</span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-xs px-2 py-1 bg-gray-100 text-gray-800 rounded-full">
                                    <i class="fas fa-minus"></i> N/A
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
                </div>
            </div>
        </div>

        <!-- Delete Account - Full Width -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-red-200 dark:border-red-700">
            <div class="p-4">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
