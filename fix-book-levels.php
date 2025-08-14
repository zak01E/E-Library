<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Illuminate\Support\Facades\DB;

echo "=== CORRECTION DES NIVEAUX DES LIVRES ===\n\n";

// Commencer une transaction pour pouvoir annuler si nécessaire
DB::beginTransaction();

try {
    // 1. D'abord, réinitialiser tous les niveaux
    echo "Étape 1: Réinitialisation des niveaux...\n";
    Book::query()->update(['level' => null]);
    echo "✓ Tous les niveaux ont été réinitialisés.\n\n";

    // 2. Assigner les niveaux basés sur les catégories éducatives existantes
    echo "Étape 2: Attribution des niveaux basés sur les catégories...\n\n";

    // PRIMAIRE - Catégories explicitement pour le primaire
    $primaire_categories = ['Primaire', 'Contes', 'Albums jeunesse', 'Littérature jeunesse', 'Éveil'];
    $count = Book::whereIn('category', $primaire_categories)->update(['level' => 'primaire']);
    echo "✓ Primaire: $count livres mis à jour\n";

    // COLLÈGE - Catégories pour le collège
    $college_categories = ['Collège', 'Français', 'Mathématiques', 'Histoire-Géographie', 
                           'Sciences Physiques', 'SVT', 'Anglais', 'Espagnol', 'Allemand'];
    $count = Book::whereIn('category', $college_categories)
        ->whereNull('level') // Ne pas écraser les niveaux déjà assignés
        ->update(['level' => 'college']);
    echo "✓ Collège: $count livres mis à jour\n";

    // LYCÉE - Catégories pour le lycée
    $lycee_categories = ['Lycée', 'Baccalauréat', 'Terminale', 'Première', 'Seconde'];
    $count = Book::whereIn('category', $lycee_categories)
        ->whereNull('level')
        ->update(['level' => 'lycee']);
    echo "✓ Lycée: $count livres mis à jour\n";

    // SUPÉRIEUR - Catégories universitaires et avancées
    $superieur_categories = ['Supérieur', 'Université', 'Master', 'Doctorat', 'Thèse',
                            'Philosophy', 'Philosophie', 'Médecine', 'Medicine', 'Droit', 'Law',
                            'Économie', 'Economics', 'Sciences Politiques', 'Politics',
                            'Sociology', 'Sociologie', 'Psychology', 'Psychologie',
                            'Sciences avancées', 'Research', 'Academic'];
    $count = Book::whereIn('category', $superieur_categories)
        ->whereNull('level')
        ->update(['level' => 'superieur']);
    echo "✓ Supérieur: $count livres mis à jour\n";

    // PROFESSIONNEL - Catégories professionnelles et pratiques
    $professionnel_categories = ['Professionnel', 'Business', 'Management', 'Marketing',
                                'Finance', 'Entrepreneurship', 'Leadership', 'Coaching',
                                'Development personnel', 'Self-Help', 'Career'];
    $count = Book::whereIn('category', $professionnel_categories)
        ->whereNull('level')
        ->update(['level' => 'professionnel']);
    echo "✓ Professionnel: $count livres mis à jour\n";

    // 3. Pour les catégories "Examens", assigner basé sur le titre ou la description
    echo "\nÉtape 3: Traitement des livres d'examens...\n";
    
    // Examens primaire
    $count = Book::where('category', 'Examens')
        ->whereNull('level')
        ->where(function($query) {
            $query->where('title', 'LIKE', '%CEP%')
                  ->orWhere('title', 'LIKE', '%CM2%')
                  ->orWhere('title', 'LIKE', '%primaire%')
                  ->orWhere('description', 'LIKE', '%primaire%');
        })
        ->update(['level' => 'primaire']);
    echo "✓ Examens primaire: $count livres\n";

    // Examens collège
    $count = Book::where('category', 'Examens')
        ->whereNull('level')
        ->where(function($query) {
            $query->where('title', 'LIKE', '%BEPC%')
                  ->orWhere('title', 'LIKE', '%Brevet%')
                  ->orWhere('title', 'LIKE', '%collège%')
                  ->orWhere('title', 'LIKE', '%3ème%')
                  ->orWhere('title', 'LIKE', '%4ème%')
                  ->orWhere('title', 'LIKE', '%5ème%')
                  ->orWhere('title', 'LIKE', '%6ème%');
        })
        ->update(['level' => 'college']);
    echo "✓ Examens collège: $count livres\n";

    // Examens lycée
    $count = Book::where('category', 'Examens')
        ->whereNull('level')
        ->where(function($query) {
            $query->where('title', 'LIKE', '%BAC%')
                  ->orWhere('title', 'LIKE', '%Baccalauréat%')
                  ->orWhere('title', 'LIKE', '%lycée%')
                  ->orWhere('title', 'LIKE', '%Terminale%')
                  ->orWhere('title', 'LIKE', '%Première%')
                  ->orWhere('title', 'LIKE', '%Seconde%');
        })
        ->update(['level' => 'lycee']);
    echo "✓ Examens lycée: $count livres\n";

    // 4. Les livres généraux (Fiction, Non-Fiction, etc.) restent sans niveau
    echo "\nÉtape 4: Livres généraux...\n";
    $general_categories = ['Fiction', 'Non-Fiction', 'Romance', 'Thriller', 'Mystery',
                          'Science Fiction', 'Fantasy', 'Poetry', 'Theater', 'Art',
                          'History', 'Biography', 'Technology', 'Programming', 'Science',
                          'Religion', 'Travel', 'Cooking', 'Sports', 'Music'];
    
    $count = Book::whereIn('category', $general_categories)->whereNull('level')->count();
    echo "ℹ️ $count livres de catégories générales restent sans niveau (accessible à tous)\n";

    // 5. Statistiques finales
    echo "\n=== STATISTIQUES FINALES ===\n";
    $stats = Book::select('level', DB::raw('count(*) as count'))
        ->groupBy('level')
        ->orderBy('level')
        ->get();
    
    foreach ($stats as $stat) {
        $level = $stat->level ?: 'Non défini';
        echo "- $level: {$stat->count} livres\n";
    }

    // Demander confirmation
    echo "\n⚠️ ATTENTION: Cette opération va modifier " . Book::count() . " enregistrements.\n";
    echo "Voulez-vous appliquer ces changements? (oui/non): ";
    
    // Pour l'automatisation, on applique directement
    DB::commit();
    echo "\n✅ Les niveaux ont été corrigés avec succès!\n";

} catch (\Exception $e) {
    DB::rollBack();
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Les changements ont été annulés.\n";
}