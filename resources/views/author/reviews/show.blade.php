@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Détail de l'avis</h1>
            <p class="text-gray-600 dark:text-gray-400">Gérez cet avis et répondez au lecteur</p>
        </div>
        <a href="{{ route('author.reviews') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux avis
        </a>
    </div>

    <!-- Review Details -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-start space-x-4">
            <div class="w-16 h-16 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-gray-600 dark:text-gray-400 text-xl"></i>
            </div>
            <div class="flex-1">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Jean Dupont</h3>
                        <div class="flex items-center mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">4/5 étoiles</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">Mon Livre Example</span>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Il y a 2 jours</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        "Excellent livre ! L'histoire est captivante et les personnages sont bien développés. 
                        J'ai particulièrement apprécié le style d'écriture fluide et les rebondissements. 
                        Je recommande vivement cette lecture à tous les amateurs du genre. 
                        Hâte de lire le prochain tome !"
                    </p>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex space-x-2">
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                            <i class="fas fa-thumbs-up mr-1"></i>Avis positif
                        </span>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                            <i class="fas fa-check-circle mr-1"></i>Vérifié
                        </span>
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                            <i class="fas fa-flag mr-1"></i>Signaler
                        </button>
                        <button class="px-3 py-1 bg-gray-600 text-white rounded text-sm hover:bg-gray-700">
                            <i class="fas fa-share mr-1"></i>Partager
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Author Response -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-reply mr-2 text-blue-600"></i>Votre réponse
        </h3>
        
        <!-- Existing Response (if any) -->
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg border-l-4 border-blue-500" style="display: none;" id="existing-response">
            <div class="flex justify-between items-start mb-2">
                <p class="font-medium text-blue-900 dark:text-blue-100">Votre réponse (publiée il y a 1 jour)</p>
                <button class="text-blue-600 hover:text-blue-800 text-sm">
                    <i class="fas fa-edit mr-1"></i>Modifier
                </button>
            </div>
            <p class="text-blue-800 dark:text-blue-200">
                Merci beaucoup pour ce retour positif ! Je suis ravi que l'histoire vous ait plu. 
                Le prochain tome sortira bientôt, restez connecté !
            </p>
        </div>

        <!-- Response Form -->
        <form action="{{ route('author.reviews.respond', 1) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Répondre à cet avis
                </label>
                <textarea name="response" rows="4" required
                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
                          placeholder="Rédigez votre réponse au lecteur..."></textarea>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Votre réponse sera publique et visible par tous les visiteurs.
                </p>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <input type="checkbox" name="notify_user" id="notify_user" checked
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="notify_user" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                        Notifier le lecteur par email
                    </label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="auto_thank" id="auto_thank"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="auto_thank" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                        Ajouter un remerciement automatique
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" 
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Aperçu
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i>Publier la réponse
                </button>
            </div>
        </form>
    </div>

    <!-- Response Templates -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-templates mr-2 text-green-600"></i>Modèles de réponse
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition-colors"
                 onclick="useTemplate('positive')">
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">
                    <i class="fas fa-thumbs-up text-green-500 mr-2"></i>Avis positif
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    "Merci beaucoup pour ce retour positif ! Je suis ravi que l'histoire vous ait plu..."
                </p>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition-colors"
                 onclick="useTemplate('constructive')">
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">
                    <i class="fas fa-comments text-blue-500 mr-2"></i>Critique constructive
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    "Merci pour votre retour constructif. Je prends note de vos remarques..."
                </p>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition-colors"
                 onclick="useTemplate('question')">
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">
                    <i class="fas fa-question-circle text-teal-500 mr-2"></i>Question du lecteur
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    "Merci pour votre question ! Je serais ravi de vous répondre..."
                </p>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition-colors"
                 onclick="useTemplate('general')">
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">
                    <i class="fas fa-heart text-red-500 mr-2"></i>Remerciement général
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    "Merci d'avoir pris le temps de lire et d'évaluer mon livre..."
                </p>
            </div>
        </div>
    </div>

    <!-- Related Reviews -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Autres avis sur ce livre</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user text-gray-600 dark:text-gray-400 text-sm"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white text-sm">Marie Martin</p>
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= 5 ? 'text-yellow-400' : 'text-gray-300' }} text-xs"></i>
                            @endfor
                        </div>
                    </div>
                </div>
                <span class="text-xs text-gray-500">Il y a 5 jours</span>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user text-gray-600 dark:text-gray-400 text-sm"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white text-sm">Pierre Durand</p>
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= 3 ? 'text-yellow-400' : 'text-gray-300' }} text-xs"></i>
                            @endfor
                        </div>
                    </div>
                </div>
                <span class="text-xs text-gray-500">Il y a 1 semaine</span>
            </div>
        </div>
    </div>
</div>

<script>
function useTemplate(type) {
    const templates = {
        positive: "Merci beaucoup pour ce retour positif ! Je suis ravi que l'histoire vous ait plu et que vous ayez apprécié le style d'écriture. Vos encouragements me motivent énormément pour continuer à écrire. N'hésitez pas à me suivre pour être informé de mes prochaines publications !",
        constructive: "Merci pour votre retour constructif. Je prends note de vos remarques qui m'aideront à améliorer mes prochaines œuvres. Chaque avis est précieux pour moi en tant qu'auteur, et j'apprécie que vous ayez pris le temps de partager votre opinion détaillée.",
        question: "Merci pour votre question ! Je serais ravi de vous répondre. N'hésitez pas à me contacter directement si vous souhaitez plus de détails. J'apprécie l'intérêt que vous portez à mon travail.",
        general: "Merci d'avoir pris le temps de lire et d'évaluer mon livre. Chaque avis compte énormément pour moi et m'aide à grandir en tant qu'auteur. J'espère que vous apprécierez mes prochaines œuvres !"
    };
    
    document.querySelector('textarea[name="response"]').value = templates[type];
}
</script>
@endsection
