<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="mb-4">
            <div class="w-16 h-16 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Nouveau mot de passe</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Créez un mot de passe sécurisé pour votre compte</p>
    </div>

    <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <div class="text-sm text-emerald-800 dark:text-emerald-200">
                <p class="font-medium">Conseils pour un mot de passe sécurisé :</p>
                <ul class="mt-1 list-disc list-inside space-y-1">
                    <li>Au moins 8 caractères</li>
                    <li>Mélange de lettres, chiffres et symboles</li>
                    <li>Évitez les informations personnelles</li>
                </ul>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse email')" />
            <x-text-input id="email"
                type="email"
                name="email"
                :value="old('email', $request->email)"
                required
                autofocus
                autocomplete="username"
                readonly
                class="bg-gray-50 dark:bg-gray-600" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Nouveau mot de passe')" />
            <x-text-input id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ __('Réinitialiser le mot de passe') }}
            </x-primary-button>
        </div>

        <!-- Security Notice -->
        <div class="text-center mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-center text-xs text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
                Connexion sécurisée SSL
            </div>
        </div>
    </form>
</x-guest-layout>