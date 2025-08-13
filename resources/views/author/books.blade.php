@extends('layouts.author-dashboard')

@section('content')
    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Supprimer le livre</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Êtes-vous sûr de vouloir supprimer "<span id="bookTitle" class="font-medium text-gray-900"></span>" ?
                    </p>
                    <p class="text-xs text-red-600 mt-2">
                        Cette action est irréversible et supprimera définitivement le livre.
                    </p>
                </div>
                <div class="flex items-center justify-center gap-3 mt-4">
                    <button id="cancelDelete"
                            class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button id="confirmDelete"
                            class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
                        Supprimer définitivement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
            <div class="mb-6">
                <a href="{{ route('author.books.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    + Publier un nouveau livre
                </a>
            </div>

            <!-- Filtres -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtrer mes livres</h3>
                    <form method="GET" action="{{ route('author.books') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:space-x-4">
                        <!-- Filtre par statut -->
                        <div class="flex-1">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                            <select name="status" id="status" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>Tous les statuts</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approuvés</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejetés</option>
                            </select>
                        </div>

                        <!-- Filtre par catégorie -->
                        <div class="flex-1">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                            <select name="category" id="category" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="all" {{ request('category', 'all') === 'all' ? 'selected' : '' }}>Toutes les catégories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tri -->
                        <div class="flex-1">
                            <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
                            <select name="sort" id="sort" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="created_at" {{ request('sort', 'created_at') === 'created_at' ? 'selected' : '' }}>Date de création</option>
                                <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Titre</option>
                                <option value="views" {{ request('sort') === 'views' ? 'selected' : '' }}>Vues</option>
                                <option value="downloads" {{ request('sort') === 'downloads' ? 'selected' : '' }}>Téléchargements</option>
                            </select>
                        </div>

                        <!-- Ordre -->
                        <div class="flex-1">
                            <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Ordre</label>
                            <select name="order" id="order" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="desc" {{ request('order', 'desc') === 'desc' ? 'selected' : '' }}>Décroissant</option>
                                <option value="asc" {{ request('order') === 'asc' ? 'selected' : '' }}>Croissant</option>
                            </select>
                        </div>

                        <!-- Boutons -->
                        <div class="flex space-x-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Filtrer
                            </button>
                            <a href="{{ route('author.books') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Indicateur des filtres actifs -->
                    @if(request()->hasAny(['status', 'category', 'sort']) && (request('status') !== 'all' || request('category') !== 'all' || request('sort') !== 'created_at'))
                        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                                    </svg>
                                    <span class="text-sm text-blue-800 font-medium">Filtres actifs :</span>
                                    @if(request('status') && request('status') !== 'all')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Statut: {{
                                                request('status') === 'approved' ? 'Approuvés' :
                                                (request('status') === 'pending' ? 'En attente' : 'Rejetés')
                                            }}
                                        </span>
                                    @endif
                                    @if(request('category') && request('category') !== 'all')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Catégorie: {{ request('category') }}
                                        </span>
                                    @endif
                                </div>
                                <span class="text-sm text-blue-600">{{ $books->total() }} résultat(s)</span>
                            </div>
                        </div>
                    @endif

                    @if($books->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Livre
                                        </th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Statut & Stats
                                        </th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($books as $book)
                                        <tr class="hover:bg-gray-50">
                                            <!-- Colonne Livre (Titre + Catégorie + Description) -->
                                            <td class="px-3 py-2">
                                                <div class="font-medium text-gray-900 text-sm">
                                                    {{ $book->title }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 mr-2">
                                                        {{ $book->category }}
                                                    </span>
                                                    <span class="text-gray-400">{{ $book->language }}</span>
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ Str::limit($book->description, 60) }}
                                                </div>
                                            </td>

                                            <!-- Colonne Statut & Stats -->
                                            <td class="px-3 py-2">
                                                <div class="mb-2">
                                                    <span class="px-2 inline-flex text-xs leading-4 font-semibold rounded-full {{ $book->status_badge_class }}">
                                                        {{ $book->status_label }}
                                                    </span>
                                                </div>
                                                <div class="text-xs text-gray-500 space-y-1">
                                                    <div class="flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                        {{ $book->views ?? 0 }} vues
                                                    </div>
                                                    <div class="flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                                        </svg>
                                                        {{ $book->downloads ?? 0 }} téléchargements
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Colonne Date -->
                                            <td class="px-3 py-2 text-xs text-gray-500">
                                                {{ $book->created_at->format('d/m/Y') }}
                                            </td>

                                            <!-- Colonne Actions -->
                                            <td class="px-3 py-2">
                                                <div class="flex items-center justify-center space-x-1">
                                                    <a href="{{ route('author.books.show', $book) }}"
                                                       class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50"
                                                       title="Voir détails">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('author.books.edit', $book) }}"
                                                       class="text-emerald-600 hover:text-indigo-900 p-1 rounded hover:bg-emerald-50"
                                                       title="Modifier">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <form id="deleteForm-{{ $book->id }}" action="{{ route('author.books.delete', $book) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                                class="delete-btn text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50"
                                                                title="Supprimer"
                                                                data-book-id="{{ $book->id }}"
                                                                data-book-title="{{ $book->title }}">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $books->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun livre publié</h3>
                            <p class="mt-1 text-sm text-gray-500">Commencez par publier votre premier livre.</p>
                            <div class="mt-6">
                                <a href="{{ route('author.books.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    + Publier un livre
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteModal');
            const bookTitleSpan = document.getElementById('bookTitle');
            const confirmDeleteBtn = document.getElementById('confirmDelete');
            const cancelDeleteBtn = document.getElementById('cancelDelete');
            const deleteButtons = document.querySelectorAll('.delete-btn');

            let currentFormId = null;

            // Ouvrir le modal de suppression
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const bookId = this.getAttribute('data-book-id');
                    const bookTitle = this.getAttribute('data-book-title');

                    currentFormId = 'deleteForm-' + bookId;
                    bookTitleSpan.textContent = bookTitle;
                    deleteModal.classList.remove('hidden');

                    // Focus sur le bouton annuler pour l'accessibilité
                    cancelDeleteBtn.focus();
                });
            });

            // Confirmer la suppression
            confirmDeleteBtn.addEventListener('click', function() {
                if (currentFormId) {
                    document.getElementById(currentFormId).submit();
                }
            });

            // Annuler la suppression
            function closeModal() {
                deleteModal.classList.add('hidden');
                currentFormId = null;
            }

            cancelDeleteBtn.addEventListener('click', closeModal);

            // Fermer avec Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            // Fermer en cliquant sur l'arrière-plan
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    closeModal();
                }
            });
        });
    </script>
@endsection