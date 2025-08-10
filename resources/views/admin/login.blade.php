<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur - {{ $siteSettings['site_name'] ?? 'E-Library' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicon -->
    @if(isset($siteSettings['site_favicon']) && $siteSettings['site_favicon'])
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings['site_favicon']) }}">
    @else
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
    @endif
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo et titre -->
            <div class="text-center">
                @if(isset($siteSettings['admin_logo']) && $siteSettings['admin_logo'])
                    <div class="mx-auto h-16 w-16 mb-4 flex items-center justify-center">
                        <img src="{{ asset('storage/' . $siteSettings['admin_logo']) }}"
                             alt="{{ $siteSettings['site_name'] ?? 'E-Library' }} Admin"
                             class="max-w-full max-h-full object-contain">
                    </div>
                @elseif(isset($siteSettings['site_logo']) && $siteSettings['site_logo'])
                    <div class="mx-auto h-16 w-16 mb-4 flex items-center justify-center">
                        <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}"
                             alt="{{ $siteSettings['site_name'] ?? 'E-Library' }}"
                             class="max-w-full max-h-full object-contain">
                    </div>
                @else
                    <div class="mx-auto h-16 w-16 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                @endif
                <h2 class="text-3xl font-bold text-gray-900">{{ $siteSettings['site_name'] ?? 'E-Library' }}</h2>
                <p class="mt-2 text-lg font-semibold text-gray-700">Connexion Administrateur</p>
                <p class="text-sm text-gray-500 mt-1">Accès réservé aux administrateurs</p>
            </div>

            <!-- Formulaire -->
            <div class="bg-white py-8 px-6 shadow-xl rounded-2xl border border-gray-100">
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <p class="text-sm">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                        <div class="flex">
                            <svg class="h-5 w-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm">{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Adresse email
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('email') border-red-300 @enderror"
                            placeholder="admin@elibrary.com"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('password') border-red-300 @enderror"
                            placeholder="Votre mot de passe"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input
                            id="remember_me"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        >
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button
                            type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 transform hover:scale-[1.02]"
                        >
                            Connexion Admin
                        </button>
                    </div>

                    <!-- Links -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-500 transition duration-200">
                            ← Connexion utilisateur
                        </a>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-xs text-gray-500">© 2025 E-Library. Tous droits réservés.</p>
            </div>
        </div>
    </div>
</body>
</html>