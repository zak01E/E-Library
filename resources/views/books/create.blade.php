@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin-dashboard' : 'layouts.author-dashboard')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-4">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Informations du livre</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Remplissez les informations ci-dessous pour ajouter un nouveau livre à la bibliothèque.</p>
            </div>

            <form method="POST" action="{{ auth()->check() && auth()->user()->role === 'author' && request()->routeIs('author.books.create') ? route('author.books.store') : route('books.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Title and Author in grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Titre du livre <span class="text-red-500">*</span>
                        </label>
                        <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Author Name -->
                    <div>
                        <label for="author_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nom de l'auteur <span class="text-red-500">*</span>
                        </label>
                        <input id="author_name" type="text" name="author_name" value="{{ old('author_name') }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        @error('author_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                              placeholder="Décrivez brièvement le contenu du livre...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Grid for additional fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- ISBN -->
                    <div>
                        <label for="isbn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            ISBN
                        </label>
                        <input id="isbn" type="text" name="isbn" value="{{ old('isbn') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                               placeholder="978-0-123456-78-9">
                        @error('isbn')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Publisher -->
                    <div>
                        <label for="publisher" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Éditeur
                        </label>
                        <input id="publisher" type="text" name="publisher" value="{{ old('publisher') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                               placeholder="Nom de l'éditeur">
                        @error('publisher')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Publication Year -->
                    <div>
                        <label for="publication_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Année de publication
                        </label>
                        <input id="publication_year" type="number" name="publication_year" value="{{ old('publication_year') }}"
                               min="1800" max="{{ date('Y') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        @error('publication_year')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Catégorie
                        </label>
                        <input id="category" type="text" name="category" value="{{ old('category') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                               placeholder="Fiction, Science, Technologie...">
                        @error('category')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Language and Pages in grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Language -->
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Langue
                        </label>
                        <select id="language" name="language"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option value="fr" {{ old('language', 'fr') == 'fr' ? 'selected' : '' }}>Français</option>
                            <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="ar" {{ old('language') == 'ar' ? 'selected' : '' }}>العربية</option>
                        </select>
                        @error('language')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pages -->
                    <div>
                        <label for="pages" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nombre de pages
                        </label>
                        <input id="pages" type="number" name="pages" value="{{ old('pages') }}" min="1"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        @error('pages')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- File Upload Section -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Fichiers</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- PDF File -->
                        <div>
                            <label for="pdf_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Fichier PDF <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500">(Max: 20MB)</span>
                            </label>
                            <div class="relative">
                                <input id="pdf_file" type="file" name="pdf_file" accept=".pdf" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                            </div>
                            @error('pdf_file')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cover Image -->
                        <div>
                            <label for="cover_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Image de couverture <span class="text-gray-500">(Optionnel)</span>
                                <span class="text-xs text-gray-500">(Max: 2MB)</span>
                            </label>
                            <div class="relative">
                                <input id="cover_image" type="file" name="cover_image" accept="image/jpeg,image/png,image/jpg"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                            </div>
                            @error('cover_image')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ auth()->check() && auth()->user()->role === 'author' && request()->routeIs('author.books.create') ? route('author.books') : route('admin.books') }}"
                       class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors flex items-center space-x-2">
                        <i class="fas fa-upload"></i>
                        <span>Télécharger le livre</span>
                    </button>
                </div>
                    </form>
        </div>
    </div>
@endsection