@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Créer une collection</h1>
            <p class="text-gray-600 dark:text-gray-400">Organisez vos livres en collection thématique</p>
        </div>
        <a href="{{ route('author.collections') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <form action="{{ route('author.collections.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <!-- Basic Information -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informations de base</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom de la collection *</label>
                    <input type="text" name="name" required 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
                           placeholder="Ex: Série Romance Contemporaine">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea name="description" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
                              placeholder="Décrivez votre collection et ce qui unit les livres qu'elle contient..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catégorie</label>
                        <select name="category" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                            <option value="">Sélectionner une catégorie</option>
                            <option value="series">Série</option>
                            <option value="theme">Thématique</option>
                            <option value="genre">Genre</option>
                            <option value="character">Personnage</option>
                            <option value="universe">Univers</option>
                            <option value="chronological">Chronologique</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Visibilité</label>
                        <select name="visibility" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                            <option value="public">Publique</option>
                            <option value="private">Privée</option>
                            <option value="unlisted">Non listée</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cover Image -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Image de couverture</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-center w-full">
                    <label for="cover-upload" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Cliquez pour télécharger</span> ou glissez-déposez</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG ou JPEG (MAX. 2MB)</p>
                        </div>
                        <input id="cover-upload" name="cover_image" type="file" class="hidden" accept="image/*" />
                    </label>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    L'image de couverture représentera votre collection. Dimensions recommandées : 400x600px.
                </p>
            </div>
        </div>

        <!-- Books Selection -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Sélection des livres</h3>
            <div class="space-y-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Choisissez les livres à inclure dans cette collection. Vous pourrez modifier cette sélection plus tard.
                </p>
                
                <!-- Search Books -->
                <div class="relative">
                    <input type="text" id="book-search" 
                           class="w-full px-3 py-2 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
                           placeholder="Rechercher parmi vos livres...">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>

                <!-- Books List -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-64 overflow-y-auto">
                    <!-- Exemple de livre -->
                    <div class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg">
                        <input type="checkbox" name="books[]" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <div class="ml-3 flex-1">
                            <div class="flex items-center">
                                <div class="w-12 h-16 bg-gray-200 dark:bg-gray-600 rounded mr-3 flex items-center justify-center">
                                    <i class="fas fa-book text-gray-400"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Exemple de livre 1</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Fiction • 2024</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg">
                        <input type="checkbox" name="books[]" value="2" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <div class="ml-3 flex-1">
                            <div class="flex items-center">
                                <div class="w-12 h-16 bg-gray-200 dark:bg-gray-600 rounded mr-3 flex items-center justify-center">
                                    <i class="fas fa-book text-gray-400"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Exemple de livre 2</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Romance • 2024</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center py-8 text-gray-500" id="no-books" style="display: none;">
                    <i class="fas fa-book text-4xl mb-4"></i>
                    <p>Aucun livre trouvé</p>
                    <p class="text-sm">Vous devez d'abord publier des livres pour créer une collection</p>
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Paramètres</h3>
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" name="featured" id="featured" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="featured" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                        Mettre en avant cette collection
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="allow_suggestions" id="allow_suggestions" checked
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="allow_suggestions" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                        Permettre les suggestions automatiques de livres similaires
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="notify_followers" id="notify_followers" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="notify_followers" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                        Notifier mes abonnés de la création de cette collection
                    </label>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('author.collections') }}" 
               class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                Annuler
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-save mr-2"></i>Créer la collection
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('book-search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const bookItems = document.querySelectorAll('.grid > div');
    let visibleCount = 0;
    
    bookItems.forEach(item => {
        const bookTitle = item.querySelector('p.font-medium').textContent.toLowerCase();
        if (bookTitle.includes(searchTerm)) {
            item.style.display = 'flex';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });
    
    document.getElementById('no-books').style.display = visibleCount === 0 ? 'block' : 'none';
});

// Preview cover image
document.getElementById('cover-upload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const label = document.querySelector('label[for="cover-upload"]');
            label.innerHTML = `<img src="${e.target.result}" class="w-full h-64 object-cover rounded-lg" alt="Preview">`;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
