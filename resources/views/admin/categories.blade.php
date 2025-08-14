@extends('layouts.admin-dashboard')

@section('page-title', 'Gestion des Catégories')
@section('page-description', 'Gérez les catégories de livres de votre bibliothèque')

@section('content')
    <!-- Header de la page -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Tableau de bord complet</h1>
                <p class="text-gray-600 dark:text-gray-400">Vue d'ensemble de toutes les variables de la bibliothèque</p>
            </div>
            <div class="flex space-x-2">
                <button 
                    x-data
                    @click="$dispatch('open-modal', { name: 'add-category' })"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200"
                >
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter une catégorie
                </button>
            </div>
        </div>
    </div>

    <!-- Vue d'ensemble globale -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Statistiques globales</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <div class="text-center">
                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalBooks }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Total livres</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalCategories }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Catégories</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $totalWithLevel }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Avec niveau</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $percentWithLevel }}%</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">% avec niveau</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ count($languageStats) }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Langues</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $averagePerCategory }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Moy/catégorie</div>
            </div>
        </div>
    </div>

    <!-- Grille de statistiques combinées -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Statistiques par niveau -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-graduation-cap mr-2 text-purple-600"></i>
                Répartition par Niveau
            </h3>
            <div class="space-y-3">
                @php
                    $levelIcons = [
                        'primaire' => 'fa-child',
                        'college' => 'fa-school',
                        'lycee' => 'fa-graduation-cap',
                        'superieur' => 'fa-university',
                        'professionnel' => 'fa-briefcase'
                    ];
                    $levelColors = [
                        'primaire' => 'green',
                        'college' => 'blue',
                        'lycee' => 'purple',
                        'superieur' => 'indigo',
                        'professionnel' => 'gray'
                    ];
                @endphp
                @foreach(['primaire', 'college', 'lycee', 'superieur', 'professionnel'] as $level)
                    @if(isset($levelStats[$level]))
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas {{ $levelIcons[$level] }} text-{{ $levelColors[$level] }}-600 dark:text-{{ $levelColors[$level] }}-400 mr-2 w-4"></i>
                                <span class="text-sm text-gray-700 dark:text-gray-300 capitalize">{{ ucfirst($level) }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm font-bold text-gray-900 dark:text-white mr-2">{{ $levelStats[$level] }}</span>
                                <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-{{ $levelColors[$level] }}-600 h-2 rounded-full" style="width: {{ $totalWithLevel > 0 ? round(($levelStats[$level] / $totalWithLevel) * 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @if($booksWithoutLevel > 0)
                    <div class="flex items-center justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <i class="fas fa-question-circle text-gray-500 mr-2 w-4"></i>
                            <span class="text-sm text-gray-500 italic">Sans niveau</span>
                        </div>
                        <span class="text-sm text-gray-500">{{ $booksWithoutLevel }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistiques par langue -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-language mr-2 text-blue-600"></i>
                Répartition par Langue
            </h3>
            <div class="space-y-2 max-h-64 overflow-y-auto">
                @foreach($languageStats as $lang)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $languageNames[$lang->language] ?? $lang->language }}
                            </span>
                            <span class="text-xs text-gray-500 ml-2">({{ $lang->language }})</span>
                        </div>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $lang->count }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Statistiques par statut -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-check-circle mr-2 text-green-600"></i>
                Répartition par Statut
            </h3>
            <div class="space-y-3">
                @php
                    $statusColors = [
                        'approved' => 'green',
                        'pending' => 'yellow',
                        'rejected' => 'red',
                        'under_review' => 'blue',
                        'suspended' => 'orange'
                    ];
                    $statusLabels = [
                        'approved' => 'Approuvés',
                        'pending' => 'En attente',
                        'rejected' => 'Rejetés',
                        'under_review' => 'En révision',
                        'suspended' => 'Suspendus'
                    ];
                @endphp
                @foreach($statusStats as $status => $count)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-{{ $statusColors[$status] ?? 'gray' }}-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $statusLabels[$status] ?? ucfirst($status) }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-bold text-gray-900 dark:text-white mr-2">{{ $count }}</span>
                            <span class="text-xs text-gray-500">{{ $totalBooks > 0 ? round(($count / $totalBooks) * 100) : 0 }}%</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Top catégories par niveau -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-chart-bar mr-2 text-indigo-600"></i>
            Top 5 Catégories par Niveau Éducatif
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach(['primaire', 'college', 'lycee', 'superieur', 'professionnel'] as $level)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-3">
                    <h4 class="font-medium text-sm text-gray-900 dark:text-white mb-2 capitalize flex items-center">
                        <i class="fas {{ $levelIcons[$level] }} text-{{ $levelColors[$level] }}-600 mr-2 text-xs"></i>
                        {{ ucfirst($level) }}
                    </h4>
                    @if(isset($categoriesByLevel[$level]) && count($categoriesByLevel[$level]) > 0)
                        <ul class="space-y-1">
                            @foreach($categoriesByLevel[$level] as $cat)
                                <li class="flex justify-between items-center">
                                    <span class="text-xs text-gray-600 dark:text-gray-400 truncate mr-1">{{ Str::limit($cat->category, 15) }}</span>
                                    <span class="text-xs font-semibold text-gray-900 dark:text-white">{{ $cat->count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-xs text-gray-500 italic">Aucune donnée</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Liste des catégories avec barres de progression -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-list mr-2 text-green-600"></i>
                Liste complète des catégories ({{ $totalCategories }} catégories)
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Catégorie
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Nombre de livres
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Répartition
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
                        @php
                            $maxBooks = $categories->max('books_count');
                        @endphp
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xs mr-3">
                                            {{ substr($category->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $category->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $category->slug }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white mr-2">
                                            {{ $category->books_count }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            ({{ $totalBooks > 0 ? round(($category->books_count / $totalBooks) * 100, 1) : 0 }}%)
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-48">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full transition-all duration-500" 
                                                 style="width: {{ $maxBooks > 0 ? round(($category->books_count / $maxBooks) * 100) : 0 }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $category->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a
                                        href="{{ admin_route('categories.edit', $category) }}"
                                        class="text-emerald-600 hover:text-indigo-900 mr-3"
                                    >
                                        Éditer
                                    </a>
                                    <button
                                        type="button"
                                        onclick="showDeleteConfirmation('{{ $category->name }}', {{ $category->books_count }}, '{{ admin_route('categories.delete', $category) }}')"
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

            <form method="POST" action="{{ admin_route('categories.store') }}" class="mt-6 space-y-4">
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
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 dark:focus:border-emerald-600 focus:ring-emerald-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        placeholder="Description de la catégorie..."
                    ></textarea>
                </div>

                <div class="flex items-center">
                    <input
                        id="category-active"
                        name="is_active"
                        type="checkbox"
                        value="1"
                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-emerald-600 shadow-sm focus:ring-emerald-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
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