<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class UpdateCategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            // Catégories Niveau Scolaire
            ['name' => 'Primaire', 'slug' => 'primaire', 'description' => 'Ressources pour l\'enseignement primaire'],
            ['name' => 'Collège', 'slug' => 'college', 'description' => 'Ressources pour le collège'],
            ['name' => 'Lycée', 'slug' => 'lycee', 'description' => 'Ressources pour le lycée'],
            ['name' => 'Supérieur', 'slug' => 'superieur', 'description' => 'Ressources pour l\'enseignement supérieur'],
            ['name' => 'Professionnel', 'slug' => 'professionnel', 'description' => 'Formation professionnelle et technique'],
            
            // Matières scolaires
            ['name' => 'Mathématiques', 'slug' => 'mathematiques', 'description' => 'Cours et exercices de mathématiques'],
            ['name' => 'Français', 'slug' => 'francais', 'description' => 'Langue française et littérature'],
            ['name' => 'Anglais', 'slug' => 'anglais', 'description' => 'Langue anglaise'],
            ['name' => 'Histoire-Géographie', 'slug' => 'histoire-geographie', 'description' => 'Histoire et géographie'],
            ['name' => 'Sciences Physiques', 'slug' => 'sciences-physiques', 'description' => 'Physique et chimie'],
            ['name' => 'SVT', 'slug' => 'svt', 'description' => 'Sciences de la Vie et de la Terre'],
            ['name' => 'Philosophie', 'slug' => 'philosophie', 'description' => 'Cours de philosophie'],
            ['name' => 'Économie-Gestion', 'slug' => 'economie-gestion', 'description' => 'Économie et gestion'],
            
            // Examens spécifiques
            ['name' => 'BAC', 'slug' => 'bac', 'description' => 'Préparation au Baccalauréat'],
            ['name' => 'BEPC', 'slug' => 'bepc', 'description' => 'Préparation au BEPC'],
            ['name' => 'CEPE', 'slug' => 'cepe', 'description' => 'Préparation au CEPE'],
            ['name' => 'Concours', 'slug' => 'concours', 'description' => 'Préparation aux concours'],
            
            // Catégories culturelles ivoiriennes
            ['name' => 'Histoire de Côte d\'Ivoire', 'slug' => 'histoire-cote-ivoire', 'description' => 'Histoire nationale ivoirienne'],
            ['name' => 'Culture Ivoirienne', 'slug' => 'culture-ivoirienne', 'description' => 'Culture et traditions ivoiriennes'],
            ['name' => 'Langues Locales', 'slug' => 'langues-locales', 'description' => 'Langues nationales de Côte d\'Ivoire'],
            
            // Manuels officiels
            ['name' => 'Manuels MENET-FP', 'slug' => 'manuels-menet-fp', 'description' => 'Manuels officiels du Ministère de l\'Éducation'],
            ['name' => 'Programme Officiel', 'slug' => 'programme-officiel', 'description' => 'Programmes scolaires officiels'],
            
            // Catégories supplémentaires
            ['name' => 'Orientation', 'slug' => 'orientation', 'description' => 'Orientation scolaire et professionnelle'],
            ['name' => 'Méthodologie', 'slug' => 'methodologie', 'description' => 'Méthodes de travail et révision'],
            ['name' => 'Parascolaire', 'slug' => 'parascolaire', 'description' => 'Activités parascolaires'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'description' => $category['description'] ?? null,
                ]
            );
        }

        // Supprimer les catégories en anglais en double si elles existent déjà en français
        $duplicatesToRemove = [
            'history', // on garde histoire-geographie et histoire-cote-ivoire
            'science', // on garde sciences et sciences-physiques
            'education', // on garde les catégories niveau scolaire
            'economics', // on garde economie-gestion
            'philosophy', // on garde philosophie en français
            'literature', // on garde litterature en français
        ];

        foreach ($duplicatesToRemove as $slug) {
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                // Vérifier s'il n'y a pas de livres associés avant de supprimer
                if ($category->books()->count() == 0) {
                    $category->delete();
                    echo "Supprimé : {$slug}\n";
                }
            }
        }

        echo "Catégories mises à jour avec succès!\n";
    }
}