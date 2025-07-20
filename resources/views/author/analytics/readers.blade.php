@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Analytics - Lecteurs</h1>
            <p class="text-gray-600 dark:text-gray-400">Analysez votre audience et vos lecteurs</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('author.analytics') }}" 
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Retour aux analytics
            </a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-download mr-2"></i>Exporter
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Lecteurs uniques</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['unique_readers'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="fas fa-redo text-green-600 dark:text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Récurrents</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['returning_readers'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                    <i class="fas fa-user-plus text-purple-600 dark:text-purple-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Nouveaux</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['new_readers'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg">
                    <i class="fas fa-clock text-orange-600 dark:text-orange-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Temps moyen</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['avg_session_time'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 dark:bg-red-900 rounded-lg">
                    <i class="fas fa-sign-out-alt text-red-600 dark:text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Taux de rebond</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['bounce_rate'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Demographics Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Age Groups -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Répartition par âge</h3>
            <div class="space-y-3">
                @foreach($demographics['age_groups'] as $age => $percentage)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $age }} ans</span>
                    <div class="flex items-center flex-1 mx-4">
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">{{ $percentage }}%</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Countries -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Répartition géographique</h3>
            <div class="space-y-3">
                @foreach($demographics['countries'] as $country => $percentage)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $country }}</span>
                    <div class="flex items-center flex-1 mx-4">
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">{{ $percentage }}%</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Reader Behavior -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Comportement des lecteurs</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-book-reader text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Lecteurs assidus</h4>
                <p class="text-2xl font-bold text-blue-600 mb-1">34%</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Lisent régulièrement vos livres</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-share-alt text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Partageurs</h4>
                <p class="text-2xl font-bold text-green-600 mb-1">18%</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Partagent vos contenus</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-star text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Évaluateurs</h4>
                <p class="text-2xl font-bold text-purple-600 mb-1">12%</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Laissent des avis</p>
            </div>
        </div>
    </div>

    <!-- Reading Patterns -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Habitudes de lecture</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Période</th>
                        <th class="px-6 py-3 text-center font-medium text-gray-700 dark:text-gray-300">Lecteurs actifs</th>
                        <th class="px-6 py-3 text-center font-medium text-gray-700 dark:text-gray-300">Temps moyen</th>
                        <th class="px-6 py-3 text-center font-medium text-gray-700 dark:text-gray-300">Pages lues</th>
                        <th class="px-6 py-3 text-center font-medium text-gray-700 dark:text-gray-300">Taux de completion</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <i class="fas fa-sun text-yellow-500 mr-2"></i>
                                <span class="font-medium text-gray-900 dark:text-white">Matin (6h-12h)</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-medium text-gray-900 dark:text-white">45</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-medium text-gray-900 dark:text-white">18m</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-medium text-gray-900 dark:text-white">12</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">78%</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <i class="fas fa-sun text-orange-500 mr-2"></i>
                                <span class="font-medium text-gray-900 dark:text-white">Après-midi (12h-18h)</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-medium text-gray-900 dark:text-white">67</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-medium text-gray-900 dark:text-white">25m</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-medium text-gray-900 dark:text-white">16</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">65%</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <i class="fas fa-moon text-blue-500 mr-2"></i>
                                <span class="font-medium text-gray-900 dark:text-white">Soir (18h-24h)</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-medium text-gray-900 dark:text-white">89</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-medium text-gray-900 dark:text-white">32m</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-medium text-gray-900 dark:text-white">21</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">82%</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
