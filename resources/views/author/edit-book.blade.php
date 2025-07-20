@extends('layouts.author-dashboard')

@section('content')
    <div class="space-y-6">
        <!-- En-tête avec bouton de retour -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('author.books') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-md transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour à mes livres
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Modifier le livre</h1>
                    <p class="text-sm text-gray-600 mt-1">{{ $book->title }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('author.books.update', $book) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="title" :value="__('Titre')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $book->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="author" :value="__('Auteur')" />
                            <x-text-input id="author" name="author" type="text" class="mt-1 block w-full" :value="old('author', $book->author)" required />
                            <x-input-error :messages="$errors->get('author')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description', $book->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="category" :value="__('Catégorie')" />
                                <select id="category" name="category" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Sélectionner une catégorie</option>
                                    <option value="Fiction" {{ old('category', $book->category) == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                                    <option value="Non-fiction" {{ old('category', $book->category) == 'Non-fiction' ? 'selected' : '' }}>Non-fiction</option>
                                    <option value="Science" {{ old('category', $book->category) == 'Science' ? 'selected' : '' }}>Science</option>
                                    <option value="Technologie" {{ old('category', $book->category) == 'Technologie' ? 'selected' : '' }}>Technologie</option>
                                    <option value="Histoire" {{ old('category', $book->category) == 'Histoire' ? 'selected' : '' }}>Histoire</option>
                                    <option value="Biographie" {{ old('category', $book->category) == 'Biographie' ? 'selected' : '' }}>Biographie</option>
                                    <option value="Education" {{ old('category', $book->category) == 'Education' ? 'selected' : '' }}>Éducation</option>
                                    <option value="Autre" {{ old('category', $book->category) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="language" :value="__('Langue')" />
                                <select id="language" name="language" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Sélectionner une langue</option>
                                    <option value="Français" {{ old('language', $book->language) == 'Français' ? 'selected' : '' }}>Français</option>
                                    <option value="Anglais" {{ old('language', $book->language) == 'Anglais' ? 'selected' : '' }}>Anglais</option>
                                    <option value="Espagnol" {{ old('language', $book->language) == 'Espagnol' ? 'selected' : '' }}>Espagnol</option>
                                    <option value="Allemand" {{ old('language', $book->language) == 'Allemand' ? 'selected' : '' }}>Allemand</option>
                                    <option value="Italien" {{ old('language', $book->language) == 'Italien' ? 'selected' : '' }}>Italien</option>
                                    <option value="Autre" {{ old('language', $book->language) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                <x-input-error :messages="$errors->get('language')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="year" :value="__('Année de publication')" />
                                <x-text-input id="year" name="year" type="number" class="mt-1 block w-full" :value="old('year', $book->year)" min="1900" max="{{ date('Y') }}" required />
                                <x-input-error :messages="$errors->get('year')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="isbn" :value="__('ISBN (optionnel)')" />
                                <x-text-input id="isbn" name="isbn" type="text" class="mt-1 block w-full" :value="old('isbn', $book->isbn)" />
                                <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Couverture du livre -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-700 mb-4">Couverture du livre</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Couverture actuelle -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Couverture actuelle
                                    </label>
                                    @if($book->cover_image)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                 alt="Couverture actuelle"
                                                 class="w-full max-w-32 rounded-lg shadow-sm">
                                            <div class="mt-2 text-xs text-gray-500">
                                                {{ basename($book->cover_image) }}
                                            </div>
                                            <div class="mt-2">
                                                <label class="flex items-center">
                                                    <input type="checkbox"
                                                           name="remove_cover"
                                                           value="1"
                                                           class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                                    <span class="ml-2 text-sm text-red-600">
                                                        Supprimer la couverture actuelle
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    @else
                                        <div class="w-full max-w-32 aspect-[3/4] bg-gradient-to-br from-gray-400 to-gray-600 rounded-lg shadow-sm flex items-center justify-center">
                                            <div class="text-center text-white p-2">
                                                <i class="fas fa-book text-xl mb-1"></i>
                                                <p class="text-xs">Aucune couverture</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Nouvelle couverture -->
                                <div>
                                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nouvelle couverture <span class="text-gray-500">(Optionnel)</span>
                                    </label>
                                    <input id="cover_image"
                                           type="file"
                                           name="cover_image"
                                           accept="image/jpeg,image/png,image/jpg"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    @error('cover_image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-xs text-gray-500">
                                        Max: 2MB - Formats: JPEG, PNG, JPG
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Informations du fichier</h3>
                            <div class="text-sm text-gray-600">
                                <p><strong>Fichier PDF :</strong> {{ $book->getPdfFilename() ?? 'Aucun fichier' }}</p>
                                <p><strong>Taille :</strong>
                                    @if($book->pdfExists())
                                        {{ $book->getPdfSizeMB() }} MB
                                    @else
                                        <span class="text-red-600">Fichier manquant</span>
                                    @endif
                                </p>
                                @if(!$book->pdfExists())
                                    <div class="bg-red-50 border border-red-200 rounded-md p-3 mt-2">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-red-800">Fichier PDF manquant</h3>
                                                <p class="text-sm text-red-700 mt-1">Le fichier PDF associé à ce livre n'existe plus sur le serveur. Veuillez télécharger un nouveau fichier PDF.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <p><strong>Statut :</strong>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $book->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $book->is_approved ? 'Approuvé' : 'En attente d\'approbation' }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('author.books') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Retour à mes livres
                            </a>
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('books.show', $book) }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-medium rounded-md transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Prévisualiser
                                </a>
                                <x-primary-button>
                                    {{ __('Mettre à jour') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>

    <script>
        // Raccourci clavier pour retourner à la liste (Échap)
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.location.href = "{{ route('author.books') }}";
            }
        });

        // Confirmation avant de quitter si le formulaire a été modifié
        let formChanged = false;
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, textarea, select');

        inputs.forEach(input => {
            input.addEventListener('change', () => {
                formChanged = true;
            });
        });

        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // Marquer le formulaire comme sauvegardé lors de la soumission
        form.addEventListener('submit', () => {
            formChanged = false;
        });
    </script>
@endsection