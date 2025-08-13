@extends('layouts.admin-dashboard')

@section('page-title', 'Gestion des Utilisateurs')
@section('page-description', 'Gérez tous les utilisateurs de votre plateforme eLibrary')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
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
@endsection