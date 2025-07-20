@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Questions fréquentes</h1>
            <p class="text-gray-600 dark:text-gray-400">Trouvez rapidement des réponses à vos questions</p>
        </div>
        <a href="{{ route('author.support') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Retour au support
        </a>
    </div>

    <!-- Search -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="relative">
            <input type="text" id="faq-search" 
                   class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
                   placeholder="Rechercher dans la FAQ...">
            <i class="fas fa-search absolute left-4 top-4 text-gray-400"></i>
        </div>
    </div>

    <!-- FAQ Categories -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Catégories</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <button onclick="filterFAQ('all')" 
                    class="faq-filter active px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                Toutes
            </button>
            <button onclick="filterFAQ('account')" 
                    class="faq-filter px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                Compte
            </button>
            <button onclick="filterFAQ('publishing')" 
                    class="faq-filter px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                Publication
            </button>
            <button onclick="filterFAQ('payment')" 
                    class="faq-filter px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                Paiements
            </button>
        </div>
    </div>

    <!-- FAQ Items -->
    <div class="space-y-4" id="faq-container">
        <!-- Account Category -->
        <div class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700" data-category="account">
            <button onclick="toggleFAQ(this)" class="w-full p-6 text-left flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Comment modifier mon profil d'auteur ?</h3>
                <i class="fas fa-chevron-down text-gray-400 transform transition-transform"></i>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600 dark:text-gray-400">
                    Pour modifier votre profil d'auteur, rendez-vous dans la section "Profil" de votre dashboard. 
                    Vous pouvez y modifier votre photo, votre biographie, vos informations de contact et vos réseaux sociaux. 
                    N'oubliez pas de sauvegarder vos modifications.
                </p>
            </div>
        </div>

        <div class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700" data-category="account">
            <button onclick="toggleFAQ(this)" class="w-full p-6 text-left flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Comment changer mon mot de passe ?</h3>
                <i class="fas fa-chevron-down text-gray-400 transform transition-transform"></i>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600 dark:text-gray-400">
                    Allez dans "Profil" > "Sécurité" et cliquez sur "Changer le mot de passe". 
                    Vous devrez saisir votre mot de passe actuel puis votre nouveau mot de passe deux fois pour confirmation.
                </p>
            </div>
        </div>

        <!-- Publishing Category -->
        <div class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700" data-category="publishing">
            <button onclick="toggleFAQ(this)" class="w-full p-6 text-left flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Quels formats de fichiers sont acceptés pour les livres ?</h3>
                <i class="fas fa-chevron-down text-gray-400 transform transition-transform"></i>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600 dark:text-gray-400">
                    Nous acceptons les formats suivants : PDF, EPUB, MOBI, et DOCX. 
                    La taille maximale par fichier est de 50 MB. Pour une meilleure expérience de lecture, 
                    nous recommandons le format EPUB pour les livres numériques.
                </p>
            </div>
        </div>

        <div class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700" data-category="publishing">
            <button onclick="toggleFAQ(this)" class="w-full p-6 text-left flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Combien de temps faut-il pour que mon livre soit publié ?</h3>
                <i class="fas fa-chevron-down text-gray-400 transform transition-transform"></i>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600 dark:text-gray-400">
                    Une fois votre livre soumis, il faut généralement 24 à 48 heures pour la validation et la publication. 
                    Ce délai peut être plus long si des modifications sont nécessaires ou pendant les périodes de forte activité.
                </p>
            </div>
        </div>

        <div class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700" data-category="publishing">
            <button onclick="toggleFAQ(this)" class="w-full p-6 text-left flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Puis-je modifier mon livre après publication ?</h3>
                <i class="fas fa-chevron-down text-gray-400 transform transition-transform"></i>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600 dark:text-gray-400">
                    Oui, vous pouvez modifier votre livre après publication. Allez dans "Mes livres", 
                    sélectionnez le livre à modifier et cliquez sur "Éditer". Les modifications seront soumises 
                    à une nouvelle validation avant d'être publiées.
                </p>
            </div>
        </div>

        <!-- Payment Category -->
        <div class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700" data-category="payment">
            <button onclick="toggleFAQ(this)" class="w-full p-6 text-left flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Comment sont calculés mes revenus ?</h3>
                <i class="fas fa-chevron-down text-gray-400 transform transition-transform"></i>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600 dark:text-gray-400">
                    Vos revenus sont calculés selon le modèle de partage suivant : 70% pour l'auteur, 30% pour la plateforme. 
                    Les revenus sont calculés sur le prix de vente hors taxes. Vous pouvez consulter le détail 
                    de vos revenus dans la section "Revenus" de votre dashboard.
                </p>
            </div>
        </div>

        <div class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700" data-category="payment">
            <button onclick="toggleFAQ(this)" class="w-full p-6 text-left flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Quand et comment suis-je payé ?</h3>
                <i class="fas fa-chevron-down text-gray-400 transform transition-transform"></i>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600 dark:text-gray-400">
                    Les paiements sont effectués mensuellement, le 15 de chaque mois, pour les revenus du mois précédent. 
                    Le montant minimum pour un paiement est de 50€. Vous pouvez choisir votre méthode de paiement 
                    (virement bancaire, PayPal) dans la section "Revenus" > "Paiements".
                </p>
            </div>
        </div>

        <div class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700" data-category="payment">
            <button onclick="toggleFAQ(this)" class="w-full p-6 text-left flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Puis-je fixer le prix de mes livres ?</h3>
                <i class="fas fa-chevron-down text-gray-400 transform transition-transform"></i>
            </button>
            <div class="faq-content hidden px-6 pb-6">
                <p class="text-gray-600 dark:text-gray-400">
                    Oui, vous avez le contrôle total sur le prix de vos livres. Vous pouvez également proposer 
                    des promotions temporaires et des réductions. Les prix peuvent être modifiés à tout moment 
                    depuis la section "Mes livres".
                </p>
            </div>
        </div>
    </div>

    <!-- Contact Support -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900 dark:to-indigo-900 rounded-xl p-6">
        <div class="text-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Vous ne trouvez pas votre réponse ?</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                Notre équipe de support est là pour vous aider avec toutes vos questions.
            </p>
            <a href="{{ route('author.support') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-headset mr-2"></i>Contacter le support
            </a>
        </div>
    </div>
</div>

<script>
function toggleFAQ(button) {
    const content = button.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        content.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}

function filterFAQ(category) {
    const items = document.querySelectorAll('.faq-item');
    const filters = document.querySelectorAll('.faq-filter');
    
    // Update filter buttons
    filters.forEach(filter => {
        filter.classList.remove('active', 'bg-blue-100', 'text-blue-700');
        filter.classList.add('bg-gray-100', 'text-gray-700');
    });
    
    event.target.classList.add('active', 'bg-blue-100', 'text-blue-700');
    event.target.classList.remove('bg-gray-100', 'text-gray-700');
    
    // Filter items
    items.forEach(item => {
        if (category === 'all' || item.dataset.category === category) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

// Search functionality
document.getElementById('faq-search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const items = document.querySelectorAll('.faq-item');
    
    items.forEach(item => {
        const title = item.querySelector('h3').textContent.toLowerCase();
        const content = item.querySelector('.faq-content p').textContent.toLowerCase();
        
        if (title.includes(searchTerm) || content.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>
@endsection
