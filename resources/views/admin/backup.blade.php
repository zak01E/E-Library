@extends('layouts.admin-dashboard')

@section('page-title', 'Sauvegarde & Restauration')
@section('page-description', 'Gérez les sauvegardes de votre base de données et fichiers')

@section('content')
    <!-- Messages de succès/erreur -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Backup Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Dernière sauvegarde</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">
                        @if($stats['last_backup'])
                            {{ $stats['last_backup']->diffForHumans() }}
                        @else
                            Aucune
                        @endif
                    </p>
                    <p class="text-xs text-green-600 dark:text-green-400">
                        @if($stats['last_backup'])
                            Succès
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-database text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Taille totale</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['total_size'] }}</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400">{{ $stats['total_backups'] }} sauvegarde(s)</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                    <i class="fas fa-clock text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Prochaine sauvegarde</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['next_backup']->diffForHumans() }}</p>
                    <p class="text-xs text-purple-600 dark:text-purple-400">Automatique</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Create Backup -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Créer une Sauvegarde</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.backup.create') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type de sauvegarde</label>
                            <select name="type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <option value="full">Sauvegarde complète (Base de données + Fichiers)</option>
                                <option value="database">Base de données uniquement</option>
                                <option value="files">Fichiers uniquement</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description (optionnel)</label>
                            <input type="text" name="description" placeholder="Ex: Sauvegarde avant mise à jour..."
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="compress" id="compress" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="compress" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Compresser la sauvegarde</label>
                        </div>

                        <button type="submit" class="w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-download mr-2"></i>
                            Créer la sauvegarde
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Backup Settings -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Paramètres de Sauvegarde</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Sauvegarde automatique</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Sauvegarde quotidienne à 2h00</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fréquence</label>
                        <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option>Quotidienne</option>
                            <option>Hebdomadaire</option>
                            <option>Mensuelle</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Conserver</label>
                        <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option>7 dernières sauvegardes</option>
                            <option>15 dernières sauvegardes</option>
                            <option>30 dernières sauvegardes</option>
                            <option>Toutes les sauvegardes</option>
                        </select>
                    </div>

                    <button type="button" class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors" onclick="alert('Fonctionnalité à venir')">
                        Sauvegarder les paramètres
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup History -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Historique des Sauvegardes</h3>
                <form action="{{ route('admin.backup.cleanup') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-red-600 hover:text-red-700 text-sm" onclick="return confirm('Êtes-vous sûr de vouloir nettoyer les anciennes sauvegardes ?')">
                        <i class="fas fa-trash mr-2"></i>Nettoyer les anciennes
                    </button>
                </form>
            </div>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-3 text-sm font-medium text-gray-600 dark:text-gray-400">Date</th>
                            <th class="text-left py-3 text-sm font-medium text-gray-600 dark:text-gray-400">Type</th>
                            <th class="text-left py-3 text-sm font-medium text-gray-600 dark:text-gray-400">Taille</th>
                            <th class="text-left py-3 text-sm font-medium text-gray-600 dark:text-gray-400">Statut</th>
                            <th class="text-left py-3 text-sm font-medium text-gray-600 dark:text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="space-y-2">
                        @forelse($backups as $backup)
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <td class="py-3 text-sm text-gray-900 dark:text-white">{{ $backup['date']->format('Y-m-d H:i') }}</td>
                                <td class="py-3 text-sm text-gray-600 dark:text-gray-400">
                                    @if(str_contains($backup['filename'], 'database'))
                                        Base de données
                                    @elseif(str_contains($backup['filename'], 'files'))
                                        Fichiers
                                    @else
                                        Complète
                                    @endif
                                </td>
                                <td class="py-3 text-sm text-gray-600 dark:text-gray-400">{{ $backup['size'] }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Succès</span>
                                </td>
                                <td class="py-3">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.backup.download', $backup['filename']) }}"
                                           class="text-blue-600 hover:text-blue-700 text-sm"
                                           title="Télécharger">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button class="text-green-600 hover:text-green-700 text-sm"
                                                title="Restaurer (à venir)"
                                                onclick="alert('Fonctionnalité de restauration à venir')">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                        <form action="{{ route('admin.backup.delete', $backup['filename']) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette sauvegarde ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700 text-sm" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-inbox text-4xl mb-4"></i>
                                    <p>Aucune sauvegarde trouvée</p>
                                    <p class="text-sm">Créez votre première sauvegarde pour commencer</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
