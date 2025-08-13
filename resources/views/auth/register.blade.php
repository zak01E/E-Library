<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="mb-4">
            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <img src="{{ site_logo() }}"
                     alt="{{ site_name() }}"
                     class="max-w-full max-h-full object-contain">
            </div>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Créer un compte</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Rejoignez notre communauté de lecteurs</p>
        <div class="mt-3 flex items-center justify-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Gratuit
            </span>
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Accès immédiat
            </span>
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Sécurisé
            </span>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input id="name"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
                placeholder="Votre nom complet" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse email')" />
            <x-text-input id="email"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
                placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                <p>Le mot de passe doit contenir au moins 8 caractères</p>
            </div>
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

        <!-- Terms and Conditions -->
        <div class="flex items-start">
            <input id="terms" type="checkbox" class="mt-1 rounded border-gray-300 dark:border-gray-600 text-emerald-600 shadow-sm focus:ring-emerald-500 dark:focus:ring-emerald-400" required>
            <label for="terms" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                J'accepte les
                <a href="#" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-teal-300 underline">conditions d'utilisation</a>
                et la
                <a href="#" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-teal-300 underline">politique de confidentialité</a>
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                {{ __('Créer mon compte') }}
            </x-primary-button>
        </div>

        <!-- Login Link -->
        <div class="text-center mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Vous avez déjà un compte ?
                <a href="{{ route('login') }}" class="font-medium text-emerald-600 dark:text-emerald-400 hover:text-emerald-500 dark:hover:text-teal-300 transition-colors">
                    Se connecter
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>