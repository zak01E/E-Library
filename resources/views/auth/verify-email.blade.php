<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="mb-4">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Vérifiez votre email</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Nous avons envoyé un lien de vérification à votre adresse</p>
    </div>

    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            <div class="text-sm text-blue-800 dark:text-blue-200">
                <p class="font-medium">Étapes suivantes :</p>
                <ol class="mt-1 list-decimal list-inside space-y-1">
                    <li>Vérifiez votre boîte de réception</li>
                    <li>Cliquez sur le lien de vérification</li>
                    <li>Revenez ici pour accéder à votre compte</li>
                </ol>
                <p class="mt-2 text-xs">Pensez à vérifier vos spams si vous ne trouvez pas l'email.</p>
            </div>
        </div>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                    {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                </p>
            </div>
        </div>
    @endif

    <div class="space-y-4">
        <!-- Resend Email Button -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                {{ __('Renvoyer l\'email de vérification') }}
            </x-primary-button>
        </form>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-secondary-button type="submit" class="w-full">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                {{ __('Se déconnecter') }}
            </x-secondary-button>
        </form>
    </div>

    <!-- Help Section -->
    <div class="text-center mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Besoin d'aide ?</p>
        <div class="flex justify-center space-x-4 text-xs">
            <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                Contacter le support
            </a>
            <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                FAQ
            </a>
        </div>
    </div>
</x-guest-layout>