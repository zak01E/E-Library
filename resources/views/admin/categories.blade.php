@extends('layouts.admin-dashboard')

@section('page-title', 'Gestion des Catégories')
@section('page-description', 'Gérez les catégories de livres de votre bibliothèque')

@section('content')
    <!-- Header de la page -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Gestion des catégories</h1>
                <p class="text-gray-600 dark:text-gray-400">Gérez les catégories de livres</p>
            </div>
            <button 
                x-data
                @click="$dispatch('open-modal', { name: 'add-category' })"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200"
            >
                Ajouter une catégorie
            </button>
        </div>
    </div>

    <!-- Statistiques réelles -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                    <i class="fas fa-tags text-indigo-600 dark:text-indigo-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Catégories Actives</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalCategories }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="fas fa-book text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Livres</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalBooks }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 dark:bg-orange-900 rounded-lg">
                    <i class="fas fa-chart-bar text-orange-600 dark:text-orange-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Moyenne par Catégorie</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $averagePerCategory }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des catégories -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Nom
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Slug
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Nombre de livres
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($categories as $category)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $category->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $category->slug }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $category->books_count }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $category->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a
                                        href="{{ route('admin.categories.edit', $category) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3"
                                    >
                                        Éditer
                                    </a>
                                    <button
                                        type="button"
                                        onclick="showDeleteConfirmation('{{ $category->name }}', {{ $category->books_count }}, '{{ route('admin.categories.delete', $category) }}')"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Aucune catégorie trouvée
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal d'ajout de catégorie -->
    <x-modal name="add-category" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Ajouter une nouvelle catégorie
            </h2>

            <form method="POST" action="{{ route('admin.categories.store') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <x-input-label for="category-name" value="Nom de la catégorie" />
                    <x-text-input
                        id="category-name"
                        name="name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Ex: Science-fiction"
                        required
                    />
                </div>

                <div>
                    <x-input-label for="category-slug" value="Slug" />
                    <x-text-input
                        id="category-slug"
                        name="slug"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Ex: science-fiction"
                    />
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Laissez vide pour générer automatiquement
                    </p>
                </div>

                <div>
                    <x-input-label for="category-description" value="Description" />
                    <textarea
                        id="category-description"
                        name="description"
                        rows="3"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        placeholder="Description de la catégorie..."
                    ></textarea>
                </div>

                <div class="flex items-center">
                    <input
                        id="category-active"
                        name="is_active"
                        type="checkbox"
                        value="1"
                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                        checked
                    >
                    <label for="category-active" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                        Catégorie active
                    </label>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Annuler
                    </x-secondary-button>

                    <x-primary-button type="submit">
                        Ajouter la catégorie
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>


    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <!-- Icône d'avertissement -->
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>

                <!-- Titre -->
                <h3 class="text-lg font-medium text-gray-900 text-center mt-4">
                    Confirmer la suppression
                </h3>

                <!-- Message -->
                <div class="mt-4 px-4">
                    <p class="text-sm text-gray-600 text-center" id="deleteMessage">
                        <!-- Le message sera inséré ici par JavaScript -->
                    </p>
                </div>

                <!-- Avertissement pour les livres associés -->
                <div id="booksWarning" class="mt-3 px-4 py-3 bg-amber-50 border border-amber-200 rounded-md hidden">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-amber-800">
                                <strong>Attention :</strong> <span id="booksCount"></span> livre(s) sont associés à cette catégorie. Ils seront également affectés par cette suppression.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex justify-center gap-4 mt-6">
                    <button
                        type="button"
                        onclick="hideDeleteModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors"
                    >
                        Annuler
                    </button>
                    <button
                        type="button"
                        onclick="confirmDelete()"
                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors"
                    >
                        Supprimer définitivement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let deleteUrl = '';

        function showDeleteConfirmation(categoryName, booksCount, url) {
            deleteUrl = url;

            // Mettre à jour le message
            const messageElement = document.getElementById('deleteMessage');
            messageElement.innerHTML = `Êtes-vous certain de vouloir supprimer la catégorie <strong>"${categoryName}"</strong> ?<br><br>Cette action est <strong>irréversible</strong>.`;

            // Afficher/masquer l'avertissement pour les livres
            const warningElement = document.getElementById('booksWarning');
            const booksCountElement = document.getElementById('booksCount');

            if (booksCount > 0) {
                booksCountElement.textContent = booksCount;
                warningElement.classList.remove('hidden');
            } else {
                warningElement.classList.add('hidden');
            }

            // Afficher le modal
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Empêcher le scroll
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Réactiver le scroll
            deleteUrl = '';
        }

        function confirmDelete() {
            if (deleteUrl) {
                // Créer un formulaire pour la suppression
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;

                // Ajouter le token CSRF
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);

                // Ajouter la méthode DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                // Soumettre le formulaire
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Fermer le modal en cliquant à l'extérieur
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideDeleteModal();
            }
        });

        // Fermer le modal avec la touche Échap
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideDeleteModal();
            }
        });
    </script>

@endsection