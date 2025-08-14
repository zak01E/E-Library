@extends('layouts.admin-dashboard')

@section('page-title', 'Profil Administrateur')
@section('page-description', 'Gérez vos informations personnelles et paramètres de compte')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-1 lg:grid-cols-3 divide-y lg:divide-y-0 lg:divide-x divide-gray-200 dark:divide-gray-700">
            <!-- Colonne gauche : Photo + Infos -->
            <div class="p-4 lg:p-6">
                <div class="space-y-6">
                    <!-- Photo de profil -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Photo de profil</h3>
                        @include('profile.partials.update-profile-photo-form')
                    </div>
                    
                    <!-- Informations -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Informations</h3>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Colonne centre : Sécurité -->
            <div class="p-4 lg:p-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Sécurité</h3>
                @include('profile.partials.update-password-form')
            </div>

            <!-- Colonne droite : Zone dangereuse -->
            <div class="p-4 lg:p-6">
                <div class="bg-red-50 dark:bg-red-900/10 rounded-lg p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
