@extends('layouts.admin-dashboard')

@section('page-title', 'Permissions & Rôles')
@section('page-description', 'Gérez les rôles utilisateurs et leurs permissions sur la plateforme')

@section('content')
    <!-- Messages de succès/erreur -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Utilisateurs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_users']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <i class="fas fa-user-shield text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Administrateurs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_admins'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                    <i class="fas fa-user-edit text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Auteurs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_authors'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900">
                    <i class="fas fa-user text-orange-600 dark:text-orange-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Lecteurs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_readers'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Roles Management -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Roles List -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Rôles Système</h3>
                    <button onclick="openCreateRoleModal()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm transition-colors">
                        <i class="fas fa-plus mr-2"></i>Nouveau Rôle
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($roles as $role)
                        @php
                            $colors = [
                                'admin' => ['bg' => 'red', 'icon' => 'crown'],
                                'author' => ['bg' => 'blue', 'icon' => 'pen-fancy'],
                                'user' => ['bg' => 'green', 'icon' => 'user'],
                                'moderator' => ['bg' => 'purple', 'icon' => 'shield-alt'],
                            ];
                            $color = $colors[$role->name] ?? ['bg' => 'gray', 'icon' => 'user-tag'];
                            $bgColor = $color['bg'];
                        @endphp

                        @if($bgColor === 'red')
                            <div class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-900 rounded-lg border border-red-200 dark:border-red-700">
                                <div class="flex items-center">
                                    <div class="p-2 bg-red-100 dark:bg-red-800 rounded-lg mr-3">
                                        <i class="fas fa-{{ $color['icon'] }} text-red-600 dark:text-red-400"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-red-900 dark:text-red-100 capitalize">{{ $role->name }}</h4>
                                        <p class="text-sm text-red-600 dark:text-red-300">Accès complet au système</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-200 text-xs rounded-full">
                                        {{ $role->users_count }} utilisateur(s)
                                    </span>
                                    <button onclick="editRole({{ $role->id }}, '{{ $role->name }}')" class="text-red-600 hover:text-red-700 dark:text-red-400">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </div>
                        @elseif($bgColor === 'blue')
                            <div class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-900 rounded-lg border border-blue-200 dark:border-blue-700">
                                <div class="flex items-center">
                                    <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg mr-3">
                                        <i class="fas fa-{{ $color['icon'] }} text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-blue-900 dark:text-blue-100 capitalize">{{ $role->name }}</h4>
                                        <p class="text-sm text-blue-600 dark:text-blue-300">Peut publier et gérer ses livres</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 text-xs rounded-full">
                                        {{ $role->users_count }} utilisateur(s)
                                    </span>
                                    <button onclick="editRole({{ $role->id }}, '{{ $role->name }}')" class="text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if($role->users_count === 0)
                                        <form action="{{ route('admin.roles.delete', $role) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @elseif($bgColor === 'green')
                            <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-900 rounded-lg border border-green-200 dark:border-green-700">
                                <div class="flex items-center">
                                    <div class="p-2 bg-green-100 dark:bg-green-800 rounded-lg mr-3">
                                        <i class="fas fa-{{ $color['icon'] }} text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-green-900 dark:text-green-100 capitalize">{{ $role->name }}</h4>
                                        <p class="text-sm text-green-600 dark:text-green-300">Peut lire et télécharger des livres</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 text-xs rounded-full">
                                        {{ $role->users_count }} utilisateur(s)
                                    </span>
                                    <button onclick="editRole({{ $role->id }}, '{{ $role->name }}')" class="text-green-600 hover:text-green-700 dark:text-green-400">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if($role->users_count === 0)
                                        <form action="{{ route('admin.roles.delete', $role) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center">
                                    <div class="p-2 bg-gray-100 dark:bg-gray-800 rounded-lg mr-3">
                                        <i class="fas fa-{{ $color['icon'] }} text-gray-600 dark:text-gray-400"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100 capitalize">{{ $role->name }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">Rôle personnalisé</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-xs rounded-full">
                                        {{ $role->users_count }} utilisateur(s)
                                    </span>
                                    <button onclick="editRole({{ $role->id }}, '{{ $role->name }}')" class="text-gray-600 hover:text-gray-700 dark:text-gray-400">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if($role->name !== 'admin' && $role->users_count === 0)
                                        <form action="{{ route('admin.roles.delete', $role) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Permissions Matrix -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Matrice des Permissions</h3>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="text-left py-3 text-sm font-medium text-gray-600 dark:text-gray-400">Permission</th>
                                @foreach($roles as $role)
                                    <th class="text-center py-3 text-sm font-medium text-gray-600 dark:text-gray-400 capitalize">{{ $role->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="space-y-2">
                            @foreach($permissions as $permission)
                                <tr class="border-b border-gray-100 dark:border-gray-700">
                                    <td class="py-3 text-sm text-gray-900 dark:text-white">
                                        @switch($permission->name)
                                            @case('manage-users')
                                                Gérer les utilisateurs
                                                @break
                                            @case('publish-books')
                                                Publier des livres
                                                @break
                                            @case('approve-books')
                                                Approuver les livres
                                                @break
                                            @case('download-books')
                                                Télécharger des livres
                                                @break
                                            @case('view-reports')
                                                Voir les rapports
                                                @break
                                            @case('manage-settings')
                                                Gérer les paramètres
                                                @break
                                            @case('manage-roles')
                                                Gérer les rôles
                                                @break
                                            @case('moderate-content')
                                                Modérer le contenu
                                                @break
                                            @case('view-analytics')
                                                Voir les analyses
                                                @break
                                            @case('manage-categories')
                                                Gérer les catégories
                                                @break
                                            @default
                                                {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                                        @endswitch
                                    </td>
                                    @foreach($roles as $role)
                                        <td class="text-center py-3">
                                            @if($permissionMatrix[$permission->name][$role->name] ?? false)
                                                <i class="fas fa-check text-green-500"></i>
                                            @else
                                                <i class="fas fa-times text-red-500"></i>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Role Changes -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Modifications Récentes</h3>
                <button onclick="openAssignRoleModal()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm transition-colors">
                    <i class="fas fa-user-plus mr-2"></i>Assigner Rôle
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($recentChanges as $change)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center">
                            <img class="w-10 h-10 rounded-full" src="{{ $change['avatar'] }}" alt="{{ $change['user'] }}">
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $change['user'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $change['action'] }}</p>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Il y a {{ $change['time'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal pour créer un nouveau rôle -->
    <div id="createRoleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Créer un nouveau rôle</h3>
                <form action="{{ route('admin.roles.create') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom du rôle</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Permissions</label>
                        <div class="space-y-2 max-h-40 overflow-y-auto">
                            @foreach($permissions as $permission)
                                <label class="flex items-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        @switch($permission->name)
                                            @case('manage-users') Gérer les utilisateurs @break
                                            @case('publish-books') Publier des livres @break
                                            @case('approve-books') Approuver les livres @break
                                            @case('download-books') Télécharger des livres @break
                                            @case('view-reports') Voir les rapports @break
                                            @case('manage-settings') Gérer les paramètres @break
                                            @case('manage-roles') Gérer les rôles @break
                                            @case('moderate-content') Modérer le contenu @break
                                            @case('view-analytics') Voir les analyses @break
                                            @case('manage-categories') Gérer les catégories @break
                                            @default {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                                        @endswitch
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeCreateRoleModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                            Créer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal pour éditer un rôle -->
    <div id="editRoleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-10 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Éditer le rôle</h3>
                <form id="editRoleForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom du rôle</label>
                        <input type="text" id="editRoleName" name="name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Permissions</label>
                        <div class="space-y-2 max-h-60 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-lg p-3">
                            @foreach($permissions as $permission)
                                <label class="flex items-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 edit-permission-checkbox">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        @switch($permission->name)
                                            @case('manage-users') Gérer les utilisateurs @break
                                            @case('publish-books') Publier des livres @break
                                            @case('approve-books') Approuver les livres @break
                                            @case('download-books') Télécharger des livres @break
                                            @case('view-reports') Voir les rapports @break
                                            @case('manage-settings') Gérer les paramètres @break
                                            @case('manage-roles') Gérer les rôles @break
                                            @case('moderate-content') Modérer le contenu @break
                                            @case('view-analytics') Voir les analyses @break
                                            @case('manage-categories') Gérer les catégories @break
                                            @default {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                                        @endswitch
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditRoleModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal pour assigner un rôle -->
    <div id="assignRoleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Assigner un rôle</h3>
                <form action="{{ route('admin.assign-role') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Utilisateur</label>
                        <select name="user_id" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option value="">Sélectionner un utilisateur</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rôle</label>
                        <select name="role" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option value="">Sélectionner un rôle</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeAssignRoleModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                            Assigner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Données des rôles pour JavaScript
        const rolesData = @json($rolesData);

        function openCreateRoleModal() {
            document.getElementById('createRoleModal').classList.remove('hidden');
        }

        function closeCreateRoleModal() {
            document.getElementById('createRoleModal').classList.add('hidden');
        }

        function openAssignRoleModal() {
            document.getElementById('assignRoleModal').classList.remove('hidden');
        }

        function closeAssignRoleModal() {
            document.getElementById('assignRoleModal').classList.add('hidden');
        }

        function openEditRoleModal() {
            document.getElementById('editRoleModal').classList.remove('hidden');
        }

        function closeEditRoleModal() {
            document.getElementById('editRoleModal').classList.add('hidden');
        }

        function editRole(roleId, roleName) {
            // Trouver les données du rôle
            const roleData = rolesData.find(role => role.id === roleId);

            if (!roleData) {
                alert('Erreur: Données du rôle introuvables');
                return;
            }

            // Remplir le formulaire
            document.getElementById('editRoleName').value = roleData.name;
            document.getElementById('editRoleForm').action = `/admin/roles/${roleId}`;

            // Décocher toutes les permissions
            const checkboxes = document.querySelectorAll('.edit-permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            // Cocher les permissions du rôle
            roleData.permissions.forEach(permission => {
                const checkbox = document.querySelector(`input[name="permissions[]"][value="${permission}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });

            // Ouvrir la modal
            openEditRoleModal();
        }

        // Fermer les modales en cliquant à l'extérieur
        window.onclick = function(event) {
            const createModal = document.getElementById('createRoleModal');
            const assignModal = document.getElementById('assignRoleModal');
            const editModal = document.getElementById('editRoleModal');

            if (event.target === createModal) {
                closeCreateRoleModal();
            }
            if (event.target === assignModal) {
                closeAssignRoleModal();
            }
            if (event.target === editModal) {
                closeEditRoleModal();
            }
        }
    </script>
@endsection
