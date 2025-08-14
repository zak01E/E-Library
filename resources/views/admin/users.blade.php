@extends('layouts.admin-dashboard')

@section('page-title', 'Gestion des Utilisateurs')
@section('page-description', 'Gérez tous les utilisateurs de votre plateforme eLibrary')

@section('content')
    <!-- Statistiques en haut -->
    @if(isset($stats))
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 text-center">
            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total'] }}</div>
            <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Total</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 text-center">
            <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $stats['admins'] }}</div>
            <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Admins</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 text-center">
            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['authors'] }}</div>
            <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Auteurs</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 text-center">
            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['users'] }}</div>
            <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Utilisateurs</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 text-center">
            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['verified'] }}</div>
            <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Vérifiés</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 text-center">
            <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['unverified'] }}</div>
            <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Non vérifiés</div>
        </div>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <!-- En-tête avec filtres -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col space-y-4">
                <!-- Titre et bouton d'ajout -->
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Gestion des utilisateurs</h3>
                    <button onclick="openCreateUserModal()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-user-plus mr-2"></i>
                        Ajouter un utilisateur
                    </button>
                </div>
                
                <!-- Formulaire de filtres -->
                <form method="GET" action="{{ admin_route('users') }}" id="filterForm">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-3">
                        <!-- Recherche -->
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Nom ou email..."
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-sm">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                        </div>
                        
                        <!-- Filtre par rôle -->
                        <select name="role"
                                class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="all">Tous les rôles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateurs</option>
                            <option value="author" {{ request('role') == 'author' ? 'selected' : '' }}>Auteurs</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Utilisateurs</option>
                        </select>
                        
                        <!-- Filtre par vérification email -->
                        <select name="verified"
                                class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="">Tous les statuts</option>
                            <option value="yes" {{ request('verified') == 'yes' ? 'selected' : '' }}>Email vérifié</option>
                            <option value="no" {{ request('verified') == 'no' ? 'selected' : '' }}>Email non vérifié</option>
                        </select>
                        
                        <!-- Filtre par période -->
                        <select name="period"
                                class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="">Toutes les périodes</option>
                            <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                            <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Cette semaine</option>
                            <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Ce mois</option>
                            <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>Cette année</option>
                        </select>
                        
                        <!-- Boutons d'action -->
                        <div class="flex space-x-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-filter mr-1"></i>
                                Filtrer
                            </button>
                            <a href="{{ admin_route('users') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-undo mr-1"></i>
                                Réinitialiser
                            </a>
                        </div>
                    </div>
                    
                    <!-- Indicateurs de filtres actifs -->
                    @if(request()->hasAny(['search', 'role', 'verified', 'period']))
                        <div class="flex flex-wrap items-center gap-2 mt-3">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Filtres actifs:</span>
                            @if(request('search'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    <i class="fas fa-search mr-1"></i>
                                    {{ request('search') }}
                                </span>
                            @endif
                            @if(request('role') && request('role') !== 'all')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <i class="fas fa-user-tag mr-1"></i>
                                    {{ ucfirst(request('role')) }}
                                </span>
                            @endif
                            @if(request('verified'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    {{ request('verified') == 'yes' ? 'Vérifié' : 'Non vérifié' }}
                                </span>
                            @endif
                            @if(request('period'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ ucfirst(request('period')) }}
                                </span>
                            @endif
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <div class="p-6">

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
                                @foreach($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-3 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-emerald-600">
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
                                        <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-500">
                                            {{ $user->created_at->format('d/m/Y') }}
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Modal de création d'utilisateur -->
    <div id="createUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        <i class="fas fa-user-plus mr-2 text-green-600"></i>
                        Créer un nouvel utilisateur
                    </h3>
                    <button onclick="closeCreateUserModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ admin_route('users.store') }}" method="POST" id="createUserForm">
                    @csrf
                    <div class="space-y-4">
                        <!-- Nom -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nom complet <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                   placeholder="Jean Dupont">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Adresse email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                   placeholder="jean.dupont@example.com">
                        </div>

                        <!-- Mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       required
                                       minlength="8"
                                       class="w-full px-3 py-2 pr-10 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                       placeholder="Minimum 8 caractères">
                                <button type="button" onclick="togglePassword('password')" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-eye" id="password-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Confirmation mot de passe -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Confirmer le mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       required
                                       minlength="8"
                                       class="w-full px-3 py-2 pr-10 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                       placeholder="Répéter le mot de passe">
                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-eye" id="password_confirmation-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Rôle -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Rôle <span class="text-red-500">*</span>
                            </label>
                            <select name="role" 
                                    id="role" 
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <option value="user">Utilisateur standard</option>
                                <option value="author">Auteur (peut publier des livres)</option>
                                <option value="admin">Administrateur</option>
                            </select>
                        </div>

                        <!-- Email vérifié -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="email_verified" 
                                   id="email_verified" 
                                   class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            <label for="email_verified" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Marquer l'email comme vérifié
                            </label>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" 
                                onclick="closeCreateUserModal()"
                                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium transition-colors">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-check mr-2"></i>
                            Créer l'utilisateur
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCreateUserModal() {
            document.getElementById('createUserModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCreateUserModal() {
            document.getElementById('createUserModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('createUserForm').reset();
        }

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eye = document.getElementById(fieldId + '-eye');
            
            if (field.type === 'password') {
                field.type = 'text';
                eye.classList.remove('fa-eye');
                eye.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                eye.classList.remove('fa-eye-slash');
                eye.classList.add('fa-eye');
            }
        }

        // Fermer la modal avec Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCreateUserModal();
            }
        });

        // Fermer la modal en cliquant à l'extérieur
        document.getElementById('createUserModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateUserModal();
            }
        });

        // Validation du formulaire
        document.getElementById('createUserForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            
            if (password !== passwordConfirmation) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas!');
                return false;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                alert('Le mot de passe doit contenir au moins 8 caractères!');
                return false;
            }
        });
    </script>
@endsection