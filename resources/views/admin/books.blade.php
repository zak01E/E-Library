@extends('layouts.admin-dashboard')

@section('page-title', 'Gestion des Livres')
@section('page-description', 'Gérez tous les livres de votre plateforme eLibrary')

@push('styles')
<style>
    .compact-table {
        font-size: 0.8rem;
    }
    .compact-table td {
        padding: 0.375rem 0.5rem;
        vertical-align: middle;
    }
    .compact-table th {
        padding: 0.375rem 0.5rem;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .action-btn {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.25rem;
        transition: all 0.15s ease-in-out;
    }
    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
    <!-- En-tête avec statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <i class="fas fa-book text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Livres</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $books->total() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Approuvés</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $books->where('status', 'approved')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">En Attente</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $books->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                    <i class="fas fa-download text-purple-600 dark:text-purple-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Téléchargements</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $books->sum('downloads') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 dark:bg-red-900 rounded-lg">
                    <i class="fas fa-times-circle text-red-600 dark:text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rejetés</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $books->where('status', 'rejected')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <!-- En-tête du tableau avec filtres -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Gestion des Livres</h3>
                    @if(request('search') || request('status'))
                        <div class="flex items-center space-x-2 mt-1">
                            @if(request('search'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                    <i class="fas fa-search mr-1"></i>
                                    "{{ request('search') }}"
                                </span>
                            @endif
                            @if(request('status'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <i class="fas fa-filter mr-1"></i>
                                    {{
                                        request('status') == 'approved' ? 'Approuvés' :
                                        (request('status') == 'pending' ? 'En attente' : 'Rejetés')
                                    }}
                                </span>
                            @endif
                            <a href="{{ route('admin.books') }}" class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                <i class="fas fa-times mr-1"></i>Effacer les filtres
                            </a>
                        </div>
                    @endif
                </div>
                <form method="GET" action="{{ route('admin.books') }}" class="mt-3 sm:mt-0 flex items-center space-x-3" id="filterForm">
                    <div class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Rechercher..."
                               class="w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-sm">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    </div>
                    <select name="status"
                            class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white text-sm"
                            onchange="document.getElementById('filterForm').submit()">
                        <option value="">Tous les statuts</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approuvés</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejetés</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="p-4">
            @if(session('success'))
                <div class="mb-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 compact-table">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Couverture
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Titre
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Auteur
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Publié par
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Catégorie
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Stats
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($books as $book)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-2 py-1">
                                            <div class="flex-shrink-0">
                                                @if($book->cover_image)
                                                    <img src="{{ Storage::url($book->cover_image) }}"
                                                         alt="Couverture de {{ $book->title }}"
                                                         class="w-8 h-12 object-cover rounded shadow-sm border border-gray-200 dark:border-gray-600">
                                                @else
                                                    <div class="w-8 h-12 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center border border-gray-200 dark:border-gray-600">
                                                        <i class="fas fa-book text-gray-400 dark:text-gray-500 text-xs"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-2 py-1">
                                            <div class="font-medium text-gray-900 dark:text-gray-100 text-sm">
                                                {{ Str::limit($book->title, 30) }}
                                            </div>
                                        </td>
                                        <td class="px-2 py-1">
                                            <div class="text-gray-900 dark:text-gray-100 text-sm">{{ Str::limit($book->author_name, 18) }}</div>
                                        </td>
                                        <td class="px-2 py-1">
                                            <div class="text-gray-900 dark:text-gray-100 text-sm">{{ Str::limit($book->uploader->name, 12) }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($book->uploader->email, 18) }}</div>
                                        </td>
                                        <td class="px-2 py-1">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{ Str::limit($book->category, 10) }}
                                            </span>
                                        </td>
                                        <td class="px-2 py-1">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium {{ $book->status_badge_class }} dark:bg-opacity-20">
                                                {{ $book->status_label }}
                                            </span>
                                        </td>
                                        <td class="px-2 py-1 text-xs text-gray-500 dark:text-gray-400">
                                            <div class="flex items-center space-x-2">
                                                <span class="flex items-center">
                                                    <i class="fas fa-eye w-3 h-3 mr-1"></i>
                                                    {{ $book->views ?? 0 }}
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fas fa-download w-3 h-3 mr-1"></i>
                                                    {{ $book->downloads ?? 0 }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-2 py-1">
                                            <div class="flex items-center space-x-1">
                                                <a href="{{ route('admin.books.show', $book) }}"
                                                   class="action-btn text-gray-600 hover:text-blue-600 hover:bg-blue-50"
                                                   title="Voir">
                                                    <i class="fas fa-eye text-xs"></i>
                                                </a>
                                                <a href="{{ route('admin.books.edit', $book) }}"
                                                   class="action-btn text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50"
                                                   title="Éditer">
                                                    <i class="fas fa-edit text-xs"></i>
                                                </a>
                                                @if($book->status !== 'approved')
                                                    <!-- Bouton Approuver -->
                                                    <button type="button"
                                                            onclick="showApprovalModal({{ $book->id }}, '{{ addslashes($book->title) }}')"
                                                            class="action-btn text-green-600 hover:text-green-700 hover:bg-green-50 transition-all duration-200"
                                                            title="Approuver">
                                                        <i class="fas fa-check text-xs"></i>
                                                    </button>

                                                    <!-- Bouton Rejeter -->
                                                    <form method="POST" action="{{ route('admin.books.reject', $book) }}" style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                                onclick="return confirm('Rejeter ce livre ?')"
                                                                class="action-btn text-yellow-600 hover:text-yellow-700 hover:bg-yellow-50"
                                                                title="Rejeter">
                                                            <i class="fas fa-times text-xs"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Bouton Supprimer -->
                                                <button type="button"
                                                        onclick="showDeleteConfirmation('{{ $book->title }}', '{{ $book->author }}', '{{ route('admin.books.delete', $book) }}')"
                                                        class="action-btn text-red-600 hover:text-red-700 hover:bg-red-50 border-0 bg-transparent cursor-pointer"
                                                        title="Supprimer définitivement">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

        </div>

        <!-- Pagination -->
        <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700 dark:text-gray-300">
                    Affichage de {{ $books->firstItem() }} à {{ $books->lastItem() }} sur {{ $books->total() }} résultats
                </div>
                <div class="flex items-center space-x-2">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Recherche avec délai pour éviter trop de requêtes
        let searchTimeout;
        const searchInput = document.querySelector('input[name="search"]');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 500); // Délai de 500ms
            });
        }

        // Bouton pour effacer la recherche
        if (searchInput && searchInput.value) {
            const clearButton = document.createElement('button');
            clearButton.type = 'button';
            clearButton.className = 'absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600';
            clearButton.innerHTML = '<i class="fas fa-times text-xs"></i>';
            clearButton.onclick = function() {
                searchInput.value = '';
                document.getElementById('filterForm').submit();
            };
            searchInput.parentNode.appendChild(clearButton);
        }
    </script>
@endsection

@push('scripts')
<script>
// Variables pour la gestion des modales
let deleteUrl = '';

// Fonction pour afficher la modal de confirmation de suppression
function showDeleteConfirmation(bookTitle, bookAuthor, url) {
    deleteUrl = url;

    // Mettre à jour les informations du livre dans la modal
    document.getElementById('deleteBookTitle').textContent = bookTitle;
    document.getElementById('deleteBookAuthor').textContent = `Par ${bookAuthor}`;

    // Afficher la modal avec animation
    const modal = document.getElementById('deleteModal');
    const content = document.getElementById('deleteModalContent');

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Animation d'entrée
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

// Fonction pour masquer la modal de suppression
function hideDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const content = document.getElementById('deleteModalContent');

    if (!modal || modal.classList.contains('hidden')) return;

    // Animation de sortie
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        deleteUrl = '';
    }, 300);
}

// Fonction pour confirmer la suppression
function confirmDelete() {
    if (deleteUrl) {
        // Afficher une notification de traitement
        if (typeof window.showNotification === 'function') {
            window.showNotification('🔄 Suppression en cours...', 'info', 2000);
        }

        // Créer et soumettre le formulaire
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

// Fermer les modales avec Escape et clic à l'extérieur
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideDeleteModal();
        hideApprovalModal();
    }
});

// Fermer la modal de suppression si on clique à l'extérieur
document.addEventListener('click', function(e) {
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal && e.target === deleteModal) {
        hideDeleteModal();
    }
});

// Variables pour la modale d'approbation
let currentApprovalBookId = null;
let currentApprovalBookTitle = '';

function showApprovalModal(bookId, bookTitle) {
    currentApprovalBookId = bookId;
    currentApprovalBookTitle = bookTitle;

    const modal = document.getElementById('approvalModal');
    const content = document.getElementById('approvalModalContent');
    const titleElement = document.getElementById('approvalBookTitle');

    titleElement.textContent = bookTitle;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Animation d'entrée
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function hideApprovalModal() {
    const modal = document.getElementById('approvalModal');
    const content = document.getElementById('approvalModalContent');

    if (!modal || modal.classList.contains('hidden')) return;

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentApprovalBookId = null;
        currentApprovalBookTitle = '';
    }, 300);
}

function confirmApproval() {
    if (currentApprovalBookId) {
        // Créer et soumettre le formulaire
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/books/${currentApprovalBookId}/approve`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<!-- Modal de confirmation de suppression compacte -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden transition-all duration-300">
    <div class="relative top-20 mx-auto p-4 w-full max-w-md">
        <!-- Contenu de la modale -->
        <div class="relative bg-white rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 opacity-0" id="deleteModalContent">
            <!-- En-tête avec icône -->
            <div class="flex flex-col items-center pt-6 pb-4 px-6">
                <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mb-3 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 text-center mb-1">
                    ⚠️ Suppression définitive
                </h3>
                <p class="text-sm text-gray-600 text-center">
                    Cette action est <strong class="text-red-600">irréversible</strong> et supprimera définitivement :
                </p>
            </div>

            <!-- Informations du livre -->
            <div class="px-6 pb-4">
                <div class="bg-gray-50 rounded-lg p-3 mb-3 border-l-4 border-red-500">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm" id="deleteBookTitle">Titre du livre</h4>
                            <p class="text-xs text-gray-600" id="deleteBookAuthor">Auteur</p>
                        </div>
                    </div>
                </div>

                <!-- Liste compacte des éléments supprimés -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                    <h5 class="font-medium text-red-800 text-sm mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        Éléments qui seront supprimés :
                    </h5>
                    <ul class="text-xs text-red-700 space-y-1">
                        <li>• Le livre et toutes ses métadonnées</li>
                        <li>• L'image de couverture</li>
                        <li>• Le fichier PDF</li>
                        <li>• Toutes les statistiques de téléchargement</li>
                    </ul>
                </div>

                <!-- Boutons d'action compacts -->
                <div class="flex gap-2">
                    <button type="button"
                            onclick="hideDeleteModal()"
                            class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 text-sm">
                        ✕ Annuler
                    </button>
                    <button type="button"
                            onclick="confirmDelete()"
                            class="flex-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 shadow-lg hover:shadow-xl text-sm">
                        🗑️ Supprimer définitivement
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modale d'approbation moderne -->
<div id="approvalModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 border-0 w-full max-w-md">
        <!-- Contenu de la modale -->
        <div class="relative bg-white rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 opacity-0" id="approvalModalContent">
            <!-- En-tête avec icône -->
            <div class="flex flex-col items-center pt-8 pb-6 px-6">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">
                    Approuver ce livre ?
                </h3>
                <p class="text-sm text-gray-600 text-center leading-relaxed mb-2">
                    <strong id="approvalBookTitle"></strong>
                </p>
                <p class="text-xs text-gray-500 text-center leading-relaxed">
                    Cette action rendra le livre visible à tous les utilisateurs.
                </p>
            </div>

            <!-- Boutons d'action -->
            <div class="flex gap-3 px-6 pb-6">
                <button type="button"
                        onclick="hideApprovalModal()"
                        class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Annuler
                </button>
                <button type="button"
                        onclick="confirmApproval()"
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-medium rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

@endpush