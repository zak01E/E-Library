@extends('layouts.admin-dashboard')

@section('page-title', 'Détails de l\'utilisateur')
@section('page-description', 'Informations détaillées sur ' . $user->name)

@section('content')
    <div class="space-y-6">
        <!-- Bouton retour -->
        <div class="flex items-center justify-between">
            <a href="{{ admin_route('users') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-md transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Retour à la liste
            </a>
        </div>

        <!-- Informations principales -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <div class="flex items-center space-x-6">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <div class="h-20 w-20 rounded-full bg-emerald-100 flex items-center justify-center">
                            <span class="text-2xl font-bold text-emerald-600">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Informations -->
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                        <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                        
                        <div class="mt-4 flex items-center space-x-4">
                            <!-- Rôle -->
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($user->role === 'admin') bg-red-100 text-red-800
                                @elseif($user->role === 'author') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                @if($user->role === 'admin') 👑 Administrateur
                                @elseif($user->role === 'author') ✍️ Auteur
                                @else 👤 Utilisateur @endif
                            </span>
                            
                            <!-- Date d'inscription -->
                            <span class="text-sm text-gray-500">
                                Inscrit le {{ $user->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="text-blue-600 text-sm">📚</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Livres uploadés</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['books_uploaded'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="text-green-600 text-sm">✅</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Livres approuvés</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['books_approved'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <span class="text-yellow-600 text-sm">⏳</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">En attente</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['books_pending'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center">
                            <span class="text-teal-600 text-sm">📥</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Téléchargements</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($stats['total_downloads']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Livres de l'utilisateur -->
        @if($user->books->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Livres uploadés ({{ $user->books->count() }})
                </h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($user->books as $book)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $book->author_name }}</div>
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap">
                                    @if($book->is_approved)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            ✅ Approuvé
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            ⏳ En attente
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-500">
                                    {{ $book->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap text-center">
                                    <a href="{{ admin_route('books.edit', $book) }}" class="text-emerald-600 hover:text-indigo-900 text-xs font-medium px-2 py-1 rounded hover:bg-emerald-50">
                                        ✏️ Éditer
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h2>
                
                <div class="flex space-x-4">
                    <!-- Changer le rôle -->
                    <form action="{{ admin_route('users.update-role', $user) }}" method="POST" class="flex items-center space-x-2">
                        @csrf
                        @method('PATCH')
                        <select name="role" class="text-sm rounded border-gray-300 py-2 px-3 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Utilisateur</option>
                            <option value="author" {{ $user->role === 'author' ? 'selected' : '' }}>Auteur</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded hover:bg-emerald-700 transition-colors">
                            Changer le rôle
                        </button>
                    </form>
                    
                    <!-- Supprimer l'utilisateur -->
                    @if($user->id !== auth()->id())
                    <button 
                        type="button"
                        onclick="showDeleteConfirmation('{{ $user->name }}', '{{ admin_route('users.delete', $user) }}')"
                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700 transition-colors"
                    >
                        🗑️ Supprimer l'utilisateur
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                
                <h3 class="text-lg font-medium text-gray-900 text-center mt-4">
                    Confirmer la suppression
                </h3>
                
                <div class="mt-4 px-4">
                    <p class="text-sm text-gray-600 text-center" id="deleteMessage">
                        <!-- Le message sera inséré ici par JavaScript -->
                    </p>
                </div>
                
                <div class="flex justify-center gap-4 mt-6">
                    <button 
                        type="button" 
                        onclick="hideDeleteModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-400 transition-colors"
                    >
                        Annuler
                    </button>
                    <button 
                        type="button" 
                        onclick="confirmDelete()"
                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition-colors"
                    >
                        Supprimer définitivement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let deleteUrl = '';
        
        function showDeleteConfirmation(userName, url) {
            deleteUrl = url;
            
            const messageElement = document.getElementById('deleteMessage');
            messageElement.innerHTML = `Êtes-vous certain de vouloir supprimer l'utilisateur <strong>"${userName}"</strong> ?<br><br>Cette action est <strong>irréversible</strong> et supprimera également tous ses livres.`;
            
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            deleteUrl = '';
        }
        
        function confirmDelete() {
            if (deleteUrl) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideDeleteModal();
            }
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideDeleteModal();
            }
        });
    </script>
@endsection
