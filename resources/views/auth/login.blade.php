<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="mb-4">
            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                @if(site_logo())
                    <img src="{{ site_logo() }}"
                         alt="{{ site_name() }}"
                         class="max-w-full max-h-full object-contain">
                @else
                    <i class="fas fa-book-open text-4xl text-emerald-600"></i>
                @endif
            </div>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Connexion</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
            Accédez à {{ site_name() }}
        </p>
        <div class="mt-3 flex items-center justify-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Accès à vos livres
            </span>
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Synchronisation multi-appareils
            </span>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
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
                autocomplete="current-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-emerald-600 shadow-sm focus:ring-emerald-500 dark:focus:ring-emerald-400" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Se souvenir de moi') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-emerald-600 dark:text-emerald-400 hover:text-teal-700 dark:hover:text-teal-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors" href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                {{ __('Se connecter') }}
            </x-primary-button>
        </div>

        <!-- Alternative Login Links -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Vous avez un autre type de compte ?</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('author.login') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Connexion Auteur
                    </a>
                    <a href="{{ route('admin.login') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Connexion Admin
                    </a>
                </div>
            </div>
        </div>

        <!-- Registration Link -->
        <div class="text-center mt-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="font-medium text-emerald-600 dark:text-emerald-400 hover:text-emerald-500 dark:hover:text-teal-300 transition-colors">
                    Créer un compte
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>