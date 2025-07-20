@extends('layouts.admin-dashboard')

@section('page-title', 'Modifier la Catégorie')
@section('page-description', 'Modifiez les informations de la catégorie')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Modifier la catégorie</h1>
                    <p class="text-gray-600 dark:text-gray-400">Modifiez les informations de la catégorie "{{ $category->name }}"</p>
                </div>
                <a href="{{ route('admin.categories') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                    Retour
                </a>
            </div>
        </div>

        <!-- Formulaire d'édition -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
            <div class="p-6">
                <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" value="Nom de la catégorie" />
                        <x-text-input 
                            id="name" 
                            name="name" 
                            type="text" 
                            class="mt-1 block w-full" 
                            value="{{ old('name', $category->name) }}"
                            required 
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="slug" value="Slug" />
                        <x-text-input 
                            id="slug" 
                            name="slug" 
                            type="text" 
                            class="mt-1 block w-full" 
                            value="{{ old('slug', $category->slug) }}"
                        />
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Laissez vide pour générer automatiquement à partir du nom
                        </p>
                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Description" />
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            placeholder="Description de la catégorie..."
                        >{{ old('description', $category->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center">
                        <input 
                            id="is_active" 
                            name="is_active" 
                            type="checkbox" 
                            value="1"
                            class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                            {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                        >
                        <label for="is_active" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                            Catégorie active
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.categories') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition duration-200">
                            Annuler
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistiques de la catégorie -->
        <div class="mt-8 bg-white dark:bg-gray-800 shadow-sm rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Statistiques</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $category->books_count ?? 0 }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Livres associés</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $category->is_active ? 'Actif' : 'Inactif' }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Statut</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $category->created_at->format('d/m/Y') }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Date de création</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
