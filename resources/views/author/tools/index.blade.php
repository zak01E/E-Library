@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Outils d'auteur</h1>
            <p class="text-gray-600 dark:text-gray-400">Découvrez les outils pour améliorer votre productivité</p>
        </div>
    </div>

    <!-- Quick Access Tools -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('author.tools.writing') }}" 
           class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <i class="fas fa-pen-fancy text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Outils d'écriture</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Aide à la rédaction et correction</p>
                </div>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Accédez à des outils de correction, de style et d'aide à l'écriture pour améliorer vos textes.
            </p>
        </a>

        <a href="{{ route('author.tools.marketing') }}" 
           class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="fas fa-bullhorn text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Marketing</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Promotion et visibilité</p>
                </div>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Outils pour promouvoir vos livres et augmenter votre visibilité auprès des lecteurs.
            </p>
        </a>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 opacity-75">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-teal-100 dark:bg-purple-900 rounded-lg">
                    <i class="fas fa-chart-line text-teal-600 dark:text-purple-400 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Analytics</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Bientôt disponible</p>
                </div>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Outils d'analyse avancée pour comprendre votre audience et optimiser vos performances.
            </p>
        </div>
    </div>

    <!-- Featured Tools -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Outils recommandés</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <i class="fas fa-spell-check text-blue-600 text-xl mr-3"></i>
                    <h4 class="font-medium text-gray-900 dark:text-white">Correcteur orthographique</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    Vérifiez l'orthographe et la grammaire de vos textes en temps réel.
                </p>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                    Utiliser
                </button>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <i class="fas fa-palette text-green-600 text-xl mr-3"></i>
                    <h4 class="font-medium text-gray-900 dark:text-white">Générateur de couvertures</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    Créez des couvertures attrayantes pour vos livres avec nos modèles.
                </p>
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                    Créer
                </button>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <i class="fas fa-share-alt text-teal-600 text-xl mr-3"></i>
                    <h4 class="font-medium text-gray-900 dark:text-white">Partage social</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    Générez du contenu optimisé pour les réseaux sociaux.
                </p>
                <button class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm">
                    Générer
                </button>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <i class="fas fa-keywords text-orange-600 text-xl mr-3"></i>
                    <h4 class="font-medium text-gray-900 dark:text-white">Recherche de mots-clés</h4>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    Trouvez les meilleurs mots-clés pour optimiser la découverte de vos livres.
                </p>
                <button class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors text-sm">
                    Rechercher
                </button>
            </div>
        </div>
    </div>

    <!-- Resources -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Ressources utiles</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="p-4 bg-blue-50 dark:bg-blue-900 rounded-lg mb-4">
                    <i class="fas fa-book-open text-blue-600 dark:text-blue-400 text-2xl"></i>
                </div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Guide de l'auteur</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    Conseils et bonnes pratiques pour réussir en tant qu'auteur.
                </p>
                <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Lire le guide →
                </a>
            </div>

            <div class="text-center">
                <div class="p-4 bg-green-50 dark:bg-green-900 rounded-lg mb-4">
                    <i class="fas fa-video text-green-600 dark:text-green-400 text-2xl"></i>
                </div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Tutoriels vidéo</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    Apprenez à utiliser tous les outils disponibles.
                </p>
                <a href="#" class="text-green-600 hover:text-green-700 text-sm font-medium">
                    Voir les vidéos →
                </a>
            </div>

            <div class="text-center">
                <div class="p-4 bg-purple-50 dark:bg-purple-900 rounded-lg mb-4">
                    <i class="fas fa-users text-teal-600 dark:text-purple-400 text-2xl"></i>
                </div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Communauté</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    Échangez avec d'autres auteurs et partagez vos expériences.
                </p>
                <a href="#" class="text-teal-600 hover:text-purple-700 text-sm font-medium">
                    Rejoindre →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
