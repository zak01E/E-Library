<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="mb-4">
            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}"
                     alt="{{ $siteSettings['site_name'] ?? 'E-Library' }}"
                     class="max-w-full max-h-full object-contain">
            </div>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Mot de passe oublié</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Pas de problème ! Nous vous enverrons un lien de réinitialisation</p>
    </div>

    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            <div class="text-sm text-blue-800 dark:text-blue-200">
                <p class="font-medium">Comment ça fonctionne :</p>
                <ul class="mt-1 list-disc list-inside space-y-1">
                    <li>Saisissez votre adresse email</li>
                    <li>Vérifiez votre boîte de réception</li>
                    <li>Cliquez sur le lien reçu</li>
                    <li>Créez votre nouveau mot de passe</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse email')" />
            <x-text-input id="email"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Nous vous enverrons un lien de réinitialisation à cette adresse
            </p>
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                {{ __('Envoyer le lien de réinitialisation') }}
            </x-primary-button>
        </div>

        <!-- Back to Login -->
        <div class="text-center mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Vous vous souvenez de votre mot de passe ?
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-colors">
                    Retour à la connexion
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>