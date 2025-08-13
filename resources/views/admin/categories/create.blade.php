@extends('layouts.admin-dashboard')

@section('page-title', 'Créer une catégorie')
@section('page-description', 'Ajouter une nouvelle catégorie de livres')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ admin_route('categories') }}"
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                <i class="fas fa-folder-plus text-emerald-500 mr-3"></i>
                Nouvelle Catégorie
            </h2>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Des erreurs sont survenues
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ admin_route('categories.store') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom de la catégorie <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           placeholder="Ex: Science Fiction, Histoire, Technologie..."
                           required>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                              placeholder="Description de la catégorie (optionnel)">{{ old('description') }}</textarea>
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                        Icône (classe FontAwesome)
                    </label>
                    <input type="text" 
                           name="icon" 
                           id="icon" 
                           value="{{ old('icon', 'fas fa-book') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           placeholder="Ex: fas fa-book, fas fa-flask, fas fa-history">
                    <p class="mt-1 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Utilisez les classes FontAwesome pour l'icône
                    </p>
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                        Couleur
                    </label>
                    <select name="color" 
                            id="color" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="emerald" {{ old('color') == 'emerald' ? 'selected' : '' }}>Emeraude</option>
                        <option value="blue" {{ old('color') == 'blue' ? 'selected' : '' }}>Bleu</option>
                        <option value="purple" {{ old('color') == 'purple' ? 'selected' : '' }}>Violet</option>
                        <option value="red" {{ old('color') == 'red' ? 'selected' : '' }}>Rouge</option>
                        <option value="yellow" {{ old('color') == 'yellow' ? 'selected' : '' }}>Jaune</option>
                        <option value="green" {{ old('color') == 'green' ? 'selected' : '' }}>Vert</option>
                        <option value="gray" {{ old('color') == 'gray' ? 'selected' : '' }}>Gris</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active" class="flex items-center space-x-3">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                        <span class="text-sm font-medium text-gray-700">Catégorie active</span>
                    </label>
                    <p class="mt-1 text-sm text-gray-500 ml-7">
                        Les catégories inactives ne seront pas visibles aux utilisateurs
                    </p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <a href="{{ admin_route('categories') }}"
                       class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg hover:from-emerald-600 hover:to-teal-700 transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Créer la catégorie
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection