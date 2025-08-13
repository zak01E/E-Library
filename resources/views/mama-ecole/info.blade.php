<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information MAMA ÉCOLE - Documentation Complète</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-['Plus_Jakarta_Sans']">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('mama-ecole.index') }}" class="flex items-center">
                        <i class="fas fa-phone-volume text-emerald-600 text-2xl mr-3"></i>
                        <span class="text-xl font-bold text-gray-900">MAMA ÉCOLE</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('mama-ecole.index') }}" class="text-gray-600 hover:text-emerald-600">Accueil</a>
                    <a href="{{ route('mama-ecole.demo') }}" class="text-gray-600 hover:text-emerald-600">Démo</a>
                    <a href="{{ route('home') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700">
                        <i class="fas fa-home mr-2"></i>E-Library
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-indigo-50 to-violet-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Documentation MAMA ÉCOLE</h1>
                <p class="text-xl text-gray-600">Tout ce que vous devez savoir pour transformer l'éducation</p>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Introduction -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-info-circle text-emerald-600 mr-3"></i>
                    Qu'est-ce que MAMA ÉCOLE ?
                </h2>
                <p class="text-gray-600 mb-4">
                    MAMA ÉCOLE est le premier système mondial d'inclusion parentale par messages vocaux. 
                    Il permet aux parents illettrés de suivre la scolarité de leurs enfants dans leur langue maternelle.
                </p>
                <div class="grid md:grid-cols-3 gap-4 mt-6">
                    <div class="bg-emerald-50 rounded-lg p-4 text-center">
                        <div class="text-3xl font-bold text-emerald-600">47%</div>
                        <div class="text-sm text-gray-600">Parents illettrés en CI</div>
                    </div>
                    <div class="bg-emerald-50 rounded-lg p-4 text-center">
                        <div class="text-3xl font-bold text-emerald-600">5</div>
                        <div class="text-sm text-gray-600">Langues supportées</div>
                    </div>
                    <div class="bg-violet-50 rounded-lg p-4 text-center">
                        <div class="text-3xl font-bold text-violet-600">89%</div>
                        <div class="text-sm text-gray-600">Taux d'engagement</div>
                    </div>
                </div>
            </div>

            <!-- Fonctionnalités -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-star text-amber-500 mr-3"></i>
                    Fonctionnalités Principales
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <div>
                            <h3 class="font-semibold text-gray-900">Messages Vocaux Multilingues</h3>
                            <p class="text-gray-600">Support de 5 langues locales : Français, Dioula, Baoulé, Bété, Sénoufo</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <div>
                            <h3 class="font-semibold text-gray-900">Interaction Simple</h3>
                            <p class="text-gray-600">Parents répondent par touches téléphone (1 pour répéter, 2 pour détails...)</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <div>
                            <h3 class="font-semibold text-gray-900">Dashboard École</h3>
                            <p class="text-gray-600">Interface simple pour enseignants pour envoyer notifications</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <div>
                            <h3 class="font-semibold text-gray-900">Analytics Temps Réel</h3>
                            <p class="text-gray-600">Suivi engagement parents, taux de réponse, statistiques détaillées</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comment ça marche -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-cogs text-emerald-600 mr-3"></i>
                    Comment ça marche ?
                </h2>
                <div class="space-y-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                            <span class="font-bold text-emerald-600">1</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Inscription Parent</h3>
                            <p class="text-gray-600">Le parent donne son numéro et choisit sa langue préférée</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                            <span class="font-bold text-emerald-600">2</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">École Envoie Info</h3>
                            <p class="text-gray-600">Professeur utilise dashboard pour envoyer notes, absences, réunions</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                            <span class="font-bold text-emerald-600">3</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Appel Automatique</h3>
                            <p class="text-gray-600">Parent reçoit appel vocal dans sa langue maternelle</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                            <span class="font-bold text-emerald-600">4</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Interaction</h3>
                            <p class="text-gray-600">Parent peut répéter, demander détails, laisser message vocal</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarification -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-tag text-green-600 mr-3"></i>
                    Modèle Économique
                </h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="font-semibold text-xl text-gray-900 mb-3">Écoles Publiques</h3>
                        <div class="text-3xl font-bold text-green-600 mb-4">GRATUIT</div>
                        <ul class="space-y-2 text-gray-600">
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Subventionné par l'État</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>500 parents/école</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Support basique</li>
                        </ul>
                    </div>
                    <div class="border border-emerald-500 rounded-lg p-6 bg-emerald-50">
                        <h3 class="font-semibold text-xl text-gray-900 mb-3">Écoles Privées</h3>
                        <div class="text-3xl font-bold text-emerald-600 mb-4">50,000 FCFA/mois</div>
                        <ul class="space-y-2 text-gray-600">
                            <li><i class="fas fa-check text-emerald-500 mr-2"></i>Parents illimités</li>
                            <li><i class="fas fa-check text-emerald-500 mr-2"></i>Support prioritaire 24/7</li>
                            <li><i class="fas fa-check text-emerald-500 mr-2"></i>Analytics avancés</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl shadow-lg p-8 text-white">
                <h2 class="text-2xl font-bold mb-4">Prêt à commencer ?</h2>
                <p class="mb-6">Rejoignez les écoles pilotes qui transforment déjà l'éducation en Côte d'Ivoire.</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}" class="bg-white text-emerald-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition text-center">
                        <i class="fas fa-rocket mr-2"></i>Démarrer maintenant
                    </a>
                    <a href="mailto:mama.ecole@education.gouv.ci" class="bg-emerald-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-400 transition text-center">
                        <i class="fas fa-envelope mr-2"></i>Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 MAMA ÉCOLE - Une innovation E-Library Côte d'Ivoire</p>
        </div>
    </footer>
</body>
</html>