@extends('layouts.admin-dashboard')

@section('page-title', 'Profil Administrateur')
@section('page-description', 'Gérez vos informations personnelles et paramètres de compte')

@section('content')
    <div class="space-y-6">
        <!-- Profile Photo -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                @include('profile.partials.update-profile-photo-form')
            </div>
        </div>

        <!-- Profile Information -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-red-200 dark:border-red-700">
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
