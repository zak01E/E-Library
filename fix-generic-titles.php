<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Illuminate\Support\Facades\DB;

echo "╔══════════════════════════════════════════════════════════════════╗\n";
echo "║          CORRECTION DES TITRES GÉNÉRIQUES                        ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

DB::beginTransaction();

try {
    // Compter les livres à corriger
    $genericBooks = Book::where('title', 'LIKE', 'Livre Numéro %')->get();
    $total = $genericBooks->count();
    
    echo "Nombre de livres avec titres génériques: $total\n\n";
    
    if ($total == 0) {
        echo "Aucun livre à corriger!\n";
        DB::rollBack();
        exit;
    }
    
    echo "Génération de nouveaux titres basés sur la catégorie et l'auteur...\n\n";
    
    $corrected = 0;
    $titlesUsed = [];
    
    // Tableaux de mots pour générer des titres
    $prefixes = [
        'Science' => ['Les Mystères de', 'Introduction à', 'Traité de', 'Manuel de', 'Guide de'],
        'Mathématiques' => ['Algèbre', 'Géométrie', 'Calcul', 'Statistiques', 'Analyse'],
        'Histoire-Géographie' => ['Histoire de', 'Géographie de', 'Atlas de', 'Chroniques de', 'Mémoires de'],
        'Français' => ['Grammaire', 'Littérature', 'Orthographe', 'Conjugaison', 'Expression'],
        'SVT' => ['Biologie', 'Sciences de la vie', 'Écologie', 'Anatomie', 'Botanique'],
        'Sciences Physiques' => ['Physique', 'Chimie', 'Mécanique', 'Électricité', 'Optique'],
        'Anglais' => ['English Grammar', 'Vocabulary', 'Conversation', 'Reading', 'Writing'],
        'Programming' => ['Code', 'Algorithmes', 'Programmation', 'Développement', 'Software'],
        'Technology' => ['Innovation', 'Digital', 'Tech', 'Informatique', 'Systèmes'],
        'Fiction' => ['Le Roman de', 'L\'Histoire de', 'Les Aventures de', 'Le Destin de', 'La Quête de'],
        'History' => ['L\'Époque de', 'Les Grandes Dates', 'Civilisations', 'Empires', 'Révolutions'],
        'Business' => ['Management', 'Stratégie', 'Marketing', 'Finance', 'Leadership'],
        'Philosophy' => ['Pensées sur', 'Réflexions', 'Philosophie de', 'Méditations', 'Essais sur'],
        'Art' => ['L\'Art de', 'Techniques de', 'Histoire de l\'art', 'Créativité', 'Esthétique'],
        'Religion' => ['Spiritualité', 'Foi et', 'Textes sacrés', 'Méditation', 'Prières'],
        'DEFAULT' => ['Guide de', 'Manuel de', 'Introduction à', 'Cours de', 'Traité de']
    ];
    
    $suffixes = [
        'primaire' => ['pour enfants', 'niveau débutant', 'cours élémentaire', 'premiers pas', 'initiation'],
        'college' => ['niveau collège', '6e-3e', 'cours moyen', 'adolescents', 'collégiens'],
        'lycee' => ['niveau lycée', 'baccalauréat', 'terminale', 'lycéens', 'prépa bac'],
        'superieur' => ['niveau universitaire', 'études supérieures', 'master', 'recherche', 'avancé'],
        'professionnel' => ['professionnel', 'pratique', 'appliqué', 'entreprise', 'carrière'],
        'DEFAULT' => ['général', 'complet', 'moderne', 'pratique', 'essentiel']
    ];
    
    foreach ($genericBooks as $book) {
        $category = $book->category ?: 'DEFAULT';
        $level = $book->level ?: 'DEFAULT';
        $author = explode(' ', $book->author_name)[0] ?? 'Anonyme'; // Premier nom de l'auteur
        
        // Sélectionner les mots appropriés
        $prefixList = $prefixes[$category] ?? $prefixes['DEFAULT'];
        $suffixList = $suffixes[$level] ?? $suffixes['DEFAULT'];
        
        // Générer un titre unique
        $attempts = 0;
        $newTitle = '';
        
        do {
            $prefix = $prefixList[array_rand($prefixList)];
            $suffix = $suffixList[array_rand($suffixList)];
            
            // Créer différentes variantes
            $variants = [
                "$prefix la $category - $suffix",
                "$prefix $category : $suffix",
                "$category : $prefix - Edition $suffix",
                "$prefix les sciences - $category $suffix",
                "Cours de $category - $suffix",
                "$category par $author - $suffix"
            ];
            
            $newTitle = $variants[array_rand($variants)];
            $attempts++;
            
            // Si on a essayé trop de fois, ajouter un numéro unique
            if ($attempts > 10) {
                $newTitle .= " (Edition " . rand(2020, 2025) . ")";
                break;
            }
        } while (in_array($newTitle, $titlesUsed));
        
        $titlesUsed[] = $newTitle;
        
        // Mettre à jour le livre
        $book->title = $newTitle;
        $book->save();
        
        $corrected++;
        
        // Afficher la progression
        if ($corrected % 50 == 0) {
            echo "  Progression: $corrected/$total livres corrigés...\n";
        }
        
        // Afficher quelques exemples
        if ($corrected <= 5) {
            echo "  ID {$book->id}: '{$book->getOriginal('title')}' → '$newTitle'\n";
        }
    }
    
    echo "\n✅ $corrected titres ont été corrigés avec succès!\n\n";
    
    // Vérification finale
    $remaining = Book::where('title', 'LIKE', 'Livre Numéro %')->count();
    if ($remaining > 0) {
        echo "⚠️ Attention: $remaining livres ont encore des titres génériques\n";
    } else {
        echo "✓ Tous les titres génériques ont été corrigés!\n";
    }
    
    DB::commit();
    echo "\n✅ Modifications sauvegardées dans la base de données!\n";
    
} catch (\Exception $e) {
    DB::rollBack();
    echo "\n❌ Erreur: " . $e->getMessage() . "\n";
    echo "Les modifications ont été annulées.\n";
}