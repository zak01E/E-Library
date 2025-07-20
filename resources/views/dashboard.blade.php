@extends('layouts.admin-dashboard')

@section('page-title', 'Dashboard')
@section('page-description', 'Tableau de bord principal')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6">
            <div class="text-gray-900 dark:text-gray-100">
                {{ __("You're logged in!") }}
            </div>
        </div>
    </div>
@endsection