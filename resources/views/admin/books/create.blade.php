@extends('layouts.admin-dashboard')

@section('page-title', 'Ajouter un nouveau livre')
@section('page-description', 'Créez et publiez un nouveau livre dans votre bibliothèque')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ admin_route('books') }}"
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                <i class="fas fa-plus-circle text-emerald-500 mr-3"></i>
                Nouveau Livre
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

            <form method="POST" action="{{ admin_route('books.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Titre du livre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           required>
                </div>

                <!-- Author -->
                <div>
                    <label for="author_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom de l'auteur <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="author_name" 
                           id="author_name" 
                           value="{{ old('author_name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           required>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <select name="category" 
                            id="category" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required>
                        <option value="">Sélectionner une catégorie</option>
                        @if(isset($categories) && $categories->count() > 0)
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}" {{ old('category') == $category->name ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        @else
                            <option value="Fiction">Fiction</option>
                            <option value="Non-Fiction">Non-Fiction</option>
                            <option value="Science">Science</option>
                            <option value="Histoire">Histoire</option>
                            <option value="Technologie">Technologie</option>
                            <option value="Arts">Arts</option>
                            <option value="Business">Business</option>
                            <option value="Éducation">Éducation</option>
                        @endif
                    </select>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="5"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                              required>{{ old('description') }}</textarea>
                </div>

                <!-- Pages -->
                <div>
                    <label for="pages" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre de pages
                    </label>
                    <input type="number" 
                           name="pages" 
                           id="pages" 
                           value="{{ old('pages') }}"
                           min="1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- PDF File -->
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                        Fichier PDF <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-emerald-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-file-pdf text-4xl text-gray-400 mb-3"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                    <span>Télécharger un fichier PDF</span>
                                    <input id="file" 
                                           name="file" 
                                           type="file" 
                                           class="sr-only" 
                                           accept=".pdf"
                                           required>
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500">PDF jusqu'à 20MB</p>
                        </div>
                    </div>
                </div>

                <!-- Cover Image -->
                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Image de couverture
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-emerald-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-image text-4xl text-gray-400 mb-3"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="cover_image" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                    <span>Télécharger une image</span>
                                    <input id="cover_image" 
                                           name="cover_image" 
                                           type="file" 
                                           class="sr-only" 
                                           accept="image/*">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG jusqu'à 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <a href="{{ admin_route('books') }}"
                       class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg hover:from-emerald-600 hover:to-teal-700 transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Créer le livre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // File input preview
    document.getElementById('file').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            const label = e.target.closest('div').querySelector('span');
            label.textContent = fileName;
        }
    });

    document.getElementById('cover_image').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            const label = e.target.closest('div').querySelector('span');
            label.textContent = fileName;
        }
    });
</script>
@endpush
@endsection