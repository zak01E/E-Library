@extends('layouts.admin-dashboard')

@section('page-title', 'Utilisateurs Actifs')
@section('page-description', 'Utilisateurs inscrits dans les 30 derniers jours')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6">
            <!-- En-tête avec statistiques -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Utilisateurs Actifs (30 derniers jours)
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $users->total() }} utilisateur(s) trouvé(s)
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ admin_route('users') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-md transition-colors">
                            Tous les utilisateurs
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tableau des utilisateurs actifs -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Utilisateur
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rôle
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Inscription
                            </th>
                            <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-green-600">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <form action="{{ admin_route('users.update-role', $user) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="text-xs rounded border-gray-300 py-1 px-2 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Utilisateur</option>
                                            <option value="author" {{ $user->role === 'author' ? 'selected' : '' }}>Auteur</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        <button type="submit" class="text-emerald-600 hover:text-indigo-900 text-xs font-medium px-2 py-1 rounded hover:bg-emerald-50">
                                            ✓
                                        </button>
                                    </form>
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <div class="text-xs text-gray-900">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-green-600 font-medium">
                                        🆕 {{ $user->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ admin_route('users.show', $user) }}" class="text-emerald-600 hover:text-indigo-900 text-xs font-medium px-2 py-1 rounded hover:bg-emerald-50">
                                            👁️ Voir
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <button
                                            type="button"
                                            onclick="showDeleteConfirmation('{{ $user->name }}', '{{ admin_route('users.delete', $user) }}')"
                                            class="text-red-600 hover:text-red-900 text-xs font-medium px-2 py-1 rounded hover:bg-red-50"
                                        >
                                            🗑️ Suppr.
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun utilisateur actif</h3>
                                        <p class="mt-1 text-sm text-gray-500">Aucun utilisateur ne s'est inscrit dans les 30 derniers jours.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="mt-4">
                {{ $users->links() }}
            </div>
            @endif
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
            messageElement.innerHTML = `Êtes-vous certain de vouloir supprimer l'utilisateur <strong>"${userName}"</strong> ?<br><br>Cette action est <strong>irréversible</strong>.`;

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
