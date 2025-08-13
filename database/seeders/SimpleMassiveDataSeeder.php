<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class SimpleMassiveDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('fr_FR');
        
        $this->command->info('🚀 Génération de milliers de livres...');
        
        // Titres de livres réalistes
        $titresPrefixes = ['Le', 'La', 'Les', 'Un', 'Une', 'L\'', 'Au', 'Du'];
        
        $titresCores = [
            'Voyage', 'Secret', 'Mystère', 'Aventure', 'Destin', 'Histoire', 'Légende',
            'Royaume', 'Empire', 'Chemin', 'Quête', 'Promesse', 'Serment', 'Alliance',
            'Monde', 'Univers', 'Galaxie', 'Étoile', 'Océan', 'Montagne', 'Forêt',
            'Château', 'Tour', 'Pont', 'Jardin', 'Labyrinthe', 'Temple', 'Sanctuaire',
            'Guerrier', 'Mage', 'Roi', 'Reine', 'Prince', 'Princesse', 'Chevalier',
            'Dragon', 'Phoenix', 'Loup', 'Lion', 'Aigle', 'Serpent', 'Tigre',
            'Amour', 'Passion', 'Trahison', 'Vengeance', 'Rédemption', 'Espoir', 'Rêve',
            'Ombre', 'Lumière', 'Feu', 'Glace', 'Vent', 'Terre', 'Eau',
            'Temps', 'Espace', 'Dimension', 'Portail', 'Miroir', 'Cristal', 'Pierre',
            'Livre', 'Grimoire', 'Prophétie', 'Malédiction', 'Bénédiction', 'Sort', 'Magie',
            'Nuit', 'Jour', 'Aube', 'Crépuscule', 'Soleil', 'Lune', 'Éclipse',
            'Silence', 'Cri', 'Murmure', 'Chant', 'Mélodie', 'Symphonie', 'Harmonie',
            'Guerre', 'Paix', 'Bataille', 'Victoire', 'Défaite', 'Conquête', 'Résistance',
            'Héros', 'Héroïne', 'Mentor', 'Disciple', 'Sage', 'Oracle', 'Prophète'
        ];
        
        $titresSuffixes = [
            'Perdu', 'Oublié', 'Ancien', 'Nouveau', 'Éternel', 'Immortel', 'Mortel',
            'Sacré', 'Maudit', 'Béni', 'Interdit', 'Secret', 'Caché', 'Révélé',
            'Brisé', 'Restauré', 'Noir', 'Blanc', 'Rouge', 'Bleu', 'Vert', 'Doré',
            'de Fer', 'de Pierre', 'de Verre', 'de Cristal', 'de Sang', 'de Feu',
            'du Nord', 'du Sud', 'de l\'Est', 'de l\'Ouest', 'Central', 'Lointain',
            'Premier', 'Dernier', 'Final', 'Ultime', 'Suprême', 'Divin', 'Infernal',
            'Sans Fin', 'Sans Nom', 'Sans Visage', 'Sans Âme', 'Sans Retour', 'Sans Espoir',
            'des Ténèbres', 'de la Lumière', 'des Étoiles', 'des Cieux', 'des Enfers'
        ];
        
        $auteursPrenoms = [
            'Jean', 'Pierre', 'Marie', 'François', 'Michel', 'Jacques', 'André', 'Claude',
            'Philippe', 'Alain', 'Bernard', 'Robert', 'Louis', 'Henri', 'Georges', 'Paul',
            'Sophie', 'Isabelle', 'Nathalie', 'Catherine', 'Christine', 'Françoise', 'Anne',
            'Alexandre', 'Thomas', 'Nicolas', 'Antoine', 'Maxime', 'Guillaume', 'Lucas',
            'Emma', 'Léa', 'Chloé', 'Sarah', 'Julie', 'Camille', 'Charlotte', 'Lucie'
        ];
        
        $auteursNoms = [
            'Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert', 'Richard', 'Petit',
            'Durand', 'Leroy', 'Moreau', 'Simon', 'Laurent', 'Lefebvre', 'Michel',
            'Garcia', 'David', 'Bertrand', 'Roux', 'Vincent', 'Fournier', 'Morel',
            'Girard', 'André', 'Lefèvre', 'Mercier', 'Dupont', 'Lambert', 'Bonnet',
            'François', 'Martinez', 'Legrand', 'Garnier', 'Faure', 'Rousseau', 'Blanc'
        ];
        
        $categories = [
            'Roman', 'Science-Fiction', 'Fantasy', 'Thriller', 'Romance', 
            'Histoire', 'Science', 'Philosophie', 'Psychologie', 'Économie',
            'Informatique', 'Art', 'Musique', 'Cuisine', 'Voyage',
            'Sport', 'Santé', 'Éducation', 'Jeunesse', 'BD & Manga',
            'Poésie', 'Théâtre', 'Religion', 'Développement Personnel', 'Business'
        ];
        
        $descriptions = [
            "Un récit captivant qui vous transportera dans un univers extraordinaire.",
            "Une histoire émouvante qui touche le cœur et l'âme.",
            "Un chef-d'œuvre littéraire qui redéfinit le genre.",
            "Une aventure épique pleine de rebondissements inattendus.",
            "Un voyage initiatique à travers des mondes inconnus.",
            "Une exploration profonde de la condition humaine.",
            "Un thriller haletant qui vous tiendra en haleine jusqu'à la dernière page.",
            "Une romance passionnée entre deux âmes destinées à se rencontrer.",
            "Une fresque historique magistrale et richement documentée.",
            "Un guide pratique pour améliorer votre quotidien.",
            "Une analyse philosophique profonde et accessible.",
            "Un manuel technique complet et détaillé.",
            "Une collection de récits inspirants et motivants.",
            "Un ouvrage de référence incontournable dans son domaine.",
            "Une histoire pour enfants pleine de magie et d'émerveillement."
        ];
        
        // Générer 5000 livres par batch de 500
        $totalBooks = 5000;
        $batchSize = 500;
        
        for ($batch = 0; $batch < ($totalBooks / $batchSize); $batch++) {
            $booksData = [];
            
            for ($i = 1; $i <= $batchSize; $i++) {
                $bookNumber = $batch * $batchSize + $i;
                
                // Générer un titre unique et réaliste
                $titre = $faker->randomElement($titresPrefixes) . ' ' . 
                        $faker->randomElement($titresCores) . ' ' . 
                        $faker->randomElement($titresSuffixes);
                
                // Si le titre existe déjà, ajouter un numéro
                if ($bookNumber > 1000) {
                    $titre .= ' - Tome ' . $faker->numberBetween(1, 10);
                }
                
                // Générer un nom d'auteur réaliste
                $auteur = $faker->randomElement($auteursPrenoms) . ' ' . 
                         $faker->randomElement($auteursNoms);
                
                $category = $faker->randomElement($categories);
                $year = $faker->numberBetween(1950, 2024);
                
                $booksData[] = [
                    'title' => $titre,
                    'slug' => Str::slug($titre . '-' . $bookNumber),
                    'author_name' => $auteur,
                    'description' => $faker->randomElement($descriptions) . ' ' . $faker->paragraph(2),
                    'category' => $category,
                    'pdf_path' => 'books/sample-book-' . $bookNumber . '.pdf',
                    'cover_image' => 'covers/cover-' . $bookNumber . '.jpg',
                    'status' => $faker->randomElement(['approved', 'approved', 'approved', 'pending']),
                    'views' => $faker->numberBetween(0, 50000),
                    'downloads' => $faker->numberBetween(0, 10000),
                    'uploaded_by' => 1, // Admin user ID
                    'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                    'updated_at' => now(),
                ];
            }
            
            DB::table('books')->insert($booksData);
            $this->command->info('📚 ' . ($batch + 1) * $batchSize . ' livres créés...');
        }
        
        $this->command->info('✅ ' . $totalBooks . ' livres créés avec succès!');
        
        // Créer quelques utilisateurs supplémentaires
        $users = [];
        for ($i = 1; $i <= 100; $i++) {
            $users[] = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ];
        }
        DB::table('users')->insert($users);
        $this->command->info('✅ 100 utilisateurs créés');
        
        // Afficher le résumé
        $this->command->info('');
        $this->command->info('🎉 GÉNÉRATION TERMINÉE AVEC SUCCÈS!');
        $this->command->info('====================================');
        $this->command->info('📚 ' . $totalBooks . ' livres créés');
        $this->command->info('👥 100 utilisateurs créés');
        $this->command->info('📂 ' . count($categories) . ' catégories utilisées');
        $this->command->info('====================================');
    }
}