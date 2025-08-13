@extends('layouts.admin-dashboard')

@section('page-title', 'Éditer le Livre')
@section('page-description', 'Modifiez les informations du livre')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6">
            <!-- En-tête -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Éditer : {{ $book->title }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Modifiez les informations du livre ci-dessous
                    </p>
                </div>
                <a href="{{ admin_route('books') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour
                </a>
            </div>

            <!-- Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulaire -->
            <form method="POST" action="{{ admin_route('books.update', $book) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Informations de base -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Titre -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Titre du livre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $book->title) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Auteur -->
                    <div>
                        <label for="author_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nom de l'auteur <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="author_name" 
                               name="author_name" 
                               value="{{ old('author_name', $book->author_name) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                        @error('author_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Catégorie <span class="text-red-500">*</span>
                        </label>
                        <select id="category" 
                                name="category" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                            <option value="">Sélectionner une catégorie</option>
                            <option value="Fiction" {{ old('category', $book->category) == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                            <option value="Non-fiction" {{ old('category', $book->category) == 'Non-fiction' ? 'selected' : '' }}>Non-fiction</option>
                            <option value="Science" {{ old('category', $book->category) == 'Science' ? 'selected' : '' }}>Science</option>
                            <option value="Histoire" {{ old('category', $book->category) == 'Histoire' ? 'selected' : '' }}>Histoire</option>
                            <option value="Biographie" {{ old('category', $book->category) == 'Biographie' ? 'selected' : '' }}>Biographie</option>
                            <option value="Technologie" {{ old('category', $book->category) == 'Technologie' ? 'selected' : '' }}>Technologie</option>
                            <option value="Art" {{ old('category', $book->category) == 'Art' ? 'selected' : '' }}>Art</option>
                            <option value="Philosophie" {{ old('category', $book->category) == 'Philosophie' ? 'selected' : '' }}>Philosophie</option>
                            <option value="Religion" {{ old('category', $book->category) == 'Religion' ? 'selected' : '' }}>Religion</option>
                            <option value="Autre" {{ old('category', $book->category) == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nombre de pages -->
                    <div>
                        <label for="pages" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombre de pages
                        </label>
                        <input type="number" 
                               id="pages" 
                               name="pages" 
                               value="{{ old('pages', $book->pages) }}"
                               min="1"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                        @error('pages')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">{{ old('description', $book->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Statut d'approbation -->
                <div class="flex items-center">
                    <input type="checkbox"
                           id="is_approved"
                           name="is_approved"
                           value="1"
                           {{ old('is_approved', $book->is_approved) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_approved" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                        Livre approuvé
                    </label>
                </div>

                <!-- Fichiers actuels -->
                @if($book->cover_image || $book->pdf_path)
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Fichiers actuels</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($book->cover_image)
                                <div class="flex items-center space-x-3">
                                    <img src="{{ asset('storage/' . $book->cover_image) }}"
                                         alt="Couverture"
                                         class="w-16 h-20 object-cover rounded border">
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Image de couverture</p>
                                        <label class="flex items-center mt-1">
                                            <input type="checkbox" name="remove_cover" value="1" class="mr-2">
                                            <span class="text-sm text-red-600">Supprimer</span>
                                        </label>
                                    </div>
                                </div>
                            @endif

                            @if($book->pdf_path)
                                <div class="flex items-center space-x-3">
                                    <div class="w-16 h-20 bg-red-100 rounded flex items-center justify-center">
                                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Fichier PDF</p>
                                        <p class="text-xs text-gray-500">{{ basename($book->pdf_path) }}</p>
                                        <label class="flex items-center mt-1">
                                            <input type="checkbox" name="remove_pdf" value="1" class="mr-2">
                                            <span class="text-sm text-red-600">Supprimer</span>
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Upload de nouveaux fichiers -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Modifier les fichiers</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nouvelle image de couverture -->
                        <div>
                            <label for="cover_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ $book->cover_image ? 'Remplacer l\'image de couverture' : 'Ajouter une image de couverture' }}
                            </label>
                            <input type="file"
                                   id="cover_image"
                                   name="cover_image"
                                   accept="image/jpeg,image/png,image/jpg"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                            <p class="mt-1 text-xs text-gray-500">JPEG, PNG, JPG (max 2MB)</p>
                            @error('cover_image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nouveau fichier PDF -->
                        <div>
                            <label for="pdf_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ $book->pdf_path ? 'Remplacer le fichier PDF' : 'Ajouter un fichier PDF' }}
                            </label>
                            <input type="file"
                                   id="pdf_file"
                                   name="pdf_file"
                                   accept=".pdf"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                            <p class="mt-1 text-xs text-gray-500">PDF uniquement (max 50MB)</p>
                            @error('pdf_file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ admin_route('books') }}"
                       class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-lg transition-colors">
                        Annuler
                    </a>
                    <input type="submit"
                           value="Enregistrer"
                           class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg cursor-pointer">

                    <!-- Bouton de test alternatif -->
                    <button type="button"
                            onclick="document.forms[0].submit();"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        Test Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validation des fichiers
    const coverImageInput = document.getElementById('cover_image');
    const pdfInput = document.getElementById('pdf_file');

    // Validation de l'image de couverture
    if (coverImageInput) {
        coverImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Vérifier la taille (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert('L\'image est trop volumineuse. Taille maximale : 2MB');
                    this.value = '';
                    return;
                }

                // Vérifier le type
                if (!file.type.match(/^image\/(jpeg|jpg|png)$/)) {
                    alert('Format d\'image non supporté. Utilisez JPEG, JPG ou PNG.');
                    this.value = '';
                    return;
                }

                // Prévisualisation
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Supprimer l'ancienne prévisualisation
                    const oldPreview = document.getElementById('cover-preview');
                    if (oldPreview) oldPreview.remove();

                    // Créer la nouvelle prévisualisation
                    const preview = document.createElement('img');
                    preview.id = 'cover-preview';
                    preview.src = e.target.result;
                    preview.className = 'mt-2 w-32 h-40 object-cover rounded border';
                    coverImageInput.parentNode.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Validation du fichier PDF
    if (pdfInput) {
        pdfInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Vérifier la taille (50MB max)
                if (file.size > 50 * 1024 * 1024) {
                    alert('Le fichier PDF est trop volumineux. Taille maximale : 50MB');
                    this.value = '';
                    return;
                }

                // Vérifier le type
                if (file.type !== 'application/pdf') {
                    alert('Seuls les fichiers PDF sont acceptés.');
                    this.value = '';
                    return;
                }

                // Afficher le nom du fichier
                const fileName = document.createElement('p');
                fileName.className = 'mt-1 text-sm text-green-600';
                fileName.textContent = '✓ ' + file.name;

                // Supprimer l'ancien nom de fichier
                const oldFileName = pdfInput.parentNode.querySelector('.text-green-600');
                if (oldFileName) oldFileName.remove();

                pdfInput.parentNode.appendChild(fileName);
            }
        });
    }
});
</script>
@endpush
