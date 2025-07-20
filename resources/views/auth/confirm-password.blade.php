<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="mb-4">
            <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Zone sécurisée</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Confirmez votre mot de passe pour continuer</p>
    </div>

    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <div class="text-sm text-red-800 dark:text-red-200">
                <p class="font-medium">Accès à une zone sensible</p>
                <p class="mt-1">Pour votre sécurité, nous devons vérifier votre identité avant de vous donner accès à cette section.</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Mot de passe actuel')" />
            <x-text-input id="password"
                type="password"
                name="password"
                required
                autofocus
                autocomplete="current-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Saisissez votre mot de passe actuel pour confirmer votre identité
            </p>
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ __('Confirmer et continuer') }}
            </x-primary-button>
        </div>

        <!-- Security Info -->
        <div class="text-center mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                    Connexion sécurisée
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Données protégées
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>