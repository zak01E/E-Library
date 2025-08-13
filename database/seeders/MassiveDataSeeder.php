<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class MassiveDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('fr_FR');
        
        // Désactiver les contraintes de clés étrangères temporairement
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Vider les tables existantes
        DB::table('books')->truncate();
        DB::table('users')->truncate();
        DB::table('categories')->truncate();
        
        // Réactiver les contraintes
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('🚀 Génération de données massives...');
        
        // 1. Créer les catégories principales
        $categories = [
            'Roman' => ['icon' => 'fas fa-book', 'description' => 'Romans classiques et contemporains'],
            'Science-Fiction' => ['icon' => 'fas fa-rocket', 'description' => 'Explorez des mondes futuristes'],
            'Fantasy' => ['icon' => 'fas fa-dragon', 'description' => 'Mondes magiques et créatures fantastiques'],
            'Thriller' => ['icon' => 'fas fa-mask', 'description' => 'Suspense et mystères captivants'],
            'Romance' => ['icon' => 'fas fa-heart', 'description' => 'Histoires d\'amour passionnantes'],
            'Histoire' => ['icon' => 'fas fa-landmark', 'description' => 'Récits historiques et biographies'],
            'Science' => ['icon' => 'fas fa-atom', 'description' => 'Découvertes scientifiques'],
            'Philosophie' => ['icon' => 'fas fa-brain', 'description' => 'Réflexions philosophiques'],
            'Psychologie' => ['icon' => 'fas fa-head-side-virus', 'description' => 'Comprendre l\'esprit humain'],
            'Économie' => ['icon' => 'fas fa-chart-line', 'description' => 'Théories économiques et finance'],
            'Informatique' => ['icon' => 'fas fa-laptop-code', 'description' => 'Programmation et technologies'],
            'Art' => ['icon' => 'fas fa-palette', 'description' => 'Arts visuels et créativité'],
            'Musique' => ['icon' => 'fas fa-music', 'description' => 'Théorie musicale et histoire'],
            'Cuisine' => ['icon' => 'fas fa-utensils', 'description' => 'Recettes et gastronomie'],
            'Voyage' => ['icon' => 'fas fa-globe', 'description' => 'Guides et récits de voyage'],
            'Sport' => ['icon' => 'fas fa-running', 'description' => 'Sports et performances'],
            'Santé' => ['icon' => 'fas fa-heartbeat', 'description' => 'Bien-être et médecine'],
            'Éducation' => ['icon' => 'fas fa-graduation-cap', 'description' => 'Pédagogie et apprentissage'],
            'Jeunesse' => ['icon' => 'fas fa-child', 'description' => 'Livres pour enfants et ados'],
            'BD & Manga' => ['icon' => 'fas fa-comments', 'description' => 'Bandes dessinées et mangas'],
            'Poésie' => ['icon' => 'fas fa-feather-alt', 'description' => 'Poèmes et vers'],
            'Théâtre' => ['icon' => 'fas fa-theater-masks', 'description' => 'Pièces de théâtre'],
            'Religion' => ['icon' => 'fas fa-praying-hands', 'description' => 'Textes religieux et spiritualité'],
            'Développement Personnel' => ['icon' => 'fas fa-user-graduate', 'description' => 'Croissance personnelle'],
            'Business' => ['icon' => 'fas fa-briefcase', 'description' => 'Entrepreneuriat et management']
        ];
        
        $categoryIds = [];
        $position = 1;
        foreach ($categories as $name => $data) {
            $id = DB::table('categories')->insertGetId([
                'category' => $name,
                'icon' => $data['icon'],
                'description' => $data['description'],
                'slug' => Str::slug($name),
                'position' => $position++,
                'is_featured' => $position <= 10,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $categoryIds[$name] = $id;
        }
        
        $this->command->info('✅ ' . count($categories) . ' catégories créées');
        
        // 2. Créer 500 utilisateurs (auteurs)
        $users = [];
        for ($i = 1; $i <= 500; $i++) {
            $users[] = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => $faker->randomElement(['admin', 'author', 'user', 'user', 'user']), // Plus d'utilisateurs normaux
                'bio' => $faker->paragraph(3),
                'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at' => now(),
            ];
        }
        DB::table('users')->insert($users);
        $userIds = DB::table('users')->pluck('id')->toArray();
        
        $this->command->info('✅ 500 utilisateurs créés');
        
        // 3. Créer 10,000 livres avec des données réalistes
        $titresPrefixes = [
            'Le', 'La', 'Les', 'Un', 'Une', 'L\'', 'Au', 'Du', 'De la', 
            'Mon', 'Ma', 'Mes', 'Notre', 'Votre', 'Leur'
        ];
        
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
            'Livre', 'Grimoire', 'Prophétie', 'Malédiction', 'Bénédiction', 'Sort', 'Magie'
        ];
        
        $titresSuffixes = [
            'Perdu', 'Oublié', 'Ancien', 'Nouveau', 'Éternel', 'Immortel', 'Mortel',
            'Sacré', 'Maudit', 'Béni', 'Interdit', 'Secret', 'Caché', 'Révélé',
            'Brisé', 'Restauré', 'Noir', 'Blanc', 'Rouge', 'Bleu', 'Vert', 'Doré',
            'de Fer', 'de Pierre', 'de Verre', 'de Cristal', 'de Sang', 'de Feu',
            'du Nord', 'du Sud', 'de l\'Est', 'de l\'Ouest', 'Central', 'Lointain',
            'Premier', 'Dernier', 'Final', 'Ultime', 'Suprême', 'Divin', 'Infernal'
        ];
        
        $auteursPrenoms = [
            'Jean', 'Pierre', 'Marie', 'François', 'Michel', 'Jacques', 'André',
            'Philippe', 'Alain', 'Bernard', 'Claude', 'Robert', 'Louis', 'Henri',
            'Sophie', 'Isabelle', 'Nathalie', 'Catherine', 'Christine', 'Françoise',
            'Alexandre', 'Thomas', 'Nicolas', 'Antoine', 'Maxime', 'Guillaume',
            'Emma', 'Léa', 'Chloé', 'Sarah', 'Julie', 'Camille', 'Charlotte'
        ];
        
        $auteursNoms = [
            'Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert', 'Richard', 'Petit',
            'Durand', 'Leroy', 'Moreau', 'Simon', 'Laurent', 'Lefebvre', 'Michel',
            'Garcia', 'David', 'Bertrand', 'Roux', 'Vincent', 'Fournier', 'Morel',
            'Girard', 'André', 'Lefèvre', 'Mercier', 'Dupont', 'Lambert', 'Bonnet',
            'François', 'Martinez', 'Legrand', 'Garnier', 'Faure', 'Rousseau'
        ];
        
        $languages = ['Français', 'Anglais', 'Espagnol', 'Allemand', 'Italien', 'Portugais', 'Russe', 'Chinois', 'Japonais', 'Arabe'];
        $publishers = [
            'Gallimard', 'Flammarion', 'Grasset', 'Albin Michel', 'Le Seuil', 'Stock',
            'Fayard', 'Calmann-Lévy', 'Plon', 'Robert Laffont', 'JC Lattès', 'Actes Sud',
            'Éditions de Minuit', 'P.O.L', 'Verticales', 'L\'Olivier', 'Rivages', 'Zulma',
            'Hachette', 'Larousse', 'Nathan', 'Hatier', 'Dunod', 'Eyrolles', 'Pearson'
        ];
        
        $booksData = [];
        $batchSize = 500;
        
        for ($i = 1; $i <= 10000; $i++) {
            // Générer un titre réaliste
            $titre = $faker->randomElement($titresPrefixes) . ' ' . 
                    $faker->randomElement($titresCores) . ' ' . 
                    $faker->randomElement($titresSuffixes);
            
            // Générer un nom d'auteur réaliste
            $auteur = $faker->randomElement($auteursPrenoms) . ' ' . 
                     $faker->randomElement($auteursNoms);
            
            $categoryName = $faker->randomElement(array_keys($categories));
            $year = $faker->numberBetween(1800, 2024);
            
            $booksData[] = [
                'title' => $titre,
                'slug' => Str::slug($titre . '-' . $i),
                'author_name' => $auteur,
                'description' => $faker->paragraphs(3, true),
                'content' => $faker->paragraphs(50, true),
                'isbn' => $faker->isbn13,
                'publisher' => $faker->randomElement($publishers),
                'publication_year' => $year,
                'pages' => $faker->numberBetween(50, 1200),
                'language' => $faker->randomElement($languages),
                'category' => $categoryName,
                'category_id' => $categoryIds[$categoryName],
                'tags' => implode(',', $faker->words(5)),
                'price' => $faker->randomFloat(2, 0, 50),
                'download_link' => 'https://example.com/download/' . Str::random(20) . '.pdf',
                'preview_link' => 'https://example.com/preview/' . Str::random(20),
                'cover_image' => null, // Pas d'image pour accélérer
                'is_featured' => $faker->boolean(5), // 5% de livres en vedette
                'is_recommended' => $faker->boolean(10), // 10% recommandés
                'is_new' => $year >= 2023,
                'status' => $faker->randomElement(['pending', 'approved', 'approved', 'approved', 'rejected']),
                'visibility' => $faker->randomElement(['public', 'public', 'public', 'private']),
                'allow_comments' => $faker->boolean(80),
                'allow_ratings' => $faker->boolean(90),
                'uploader_id' => $faker->randomElement($userIds),
                'approved_by' => $faker->boolean(70) ? $faker->randomElement($userIds) : null,
                'views' => $faker->numberBetween(0, 50000),
                'downloads' => $faker->numberBetween(0, 10000),
                'likes' => $faker->numberBetween(0, 5000),
                'rating' => $faker->randomFloat(1, 1, 5),
                'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at' => now(),
            ];
            
            // Insérer par batch pour optimiser les performances
            if (count($booksData) >= $batchSize) {
                DB::table('books')->insert($booksData);
                $booksData = [];
                $this->command->info('📚 ' . $i . ' livres créés...');
            }
        }
        
        // Insérer les derniers livres
        if (!empty($booksData)) {
            DB::table('books')->insert($booksData);
        }
        
        $this->command->info('✅ 10,000 livres créés avec succès!');
        
        // 4. Créer des statistiques de lecture (emprunts simulés)
        $bookIds = DB::table('books')->where('status', 'approved')->limit(5000)->pluck('id')->toArray();
        $readingStats = [];
        
        for ($i = 0; $i < 20000; $i++) {
            $readingStats[] = [
                'user_id' => $faker->randomElement($userIds),
                'book_id' => $faker->randomElement($bookIds),
                'started_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'finished_at' => $faker->boolean(70) ? $faker->dateTimeBetween('-6 months', 'now') : null,
                'progress' => $faker->numberBetween(0, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            if (count($readingStats) >= 1000) {
                DB::table('reading_progress')->insert($readingStats);
                $readingStats = [];
            }
        }
        
        if (!empty($readingStats)) {
            DB::table('reading_progress')->insert($readingStats);
        }
        
        $this->command->info('✅ 20,000 statistiques de lecture créées');
        
        // 5. Créer des commentaires et évaluations
        $comments = [];
        $ratings = [];
        
        $commentTemplates = [
            'Excellent livre, je le recommande vivement!',
            'Une lecture captivante du début à la fin.',
            'Un peu long mais intéressant dans l\'ensemble.',
            'Pas mal, mais j\'ai lu mieux.',
            'Un chef-d\'œuvre absolu!',
            'Très instructif et bien écrit.',
            'Je n\'ai pas pu le lâcher!',
            'Une histoire touchante et émouvante.',
            'Parfait pour se détendre.',
            'Un must-read dans cette catégorie.',
            'L\'auteur maîtrise parfaitement son sujet.',
            'Une narration fluide et agréable.',
            'Des personnages attachants et bien développés.',
            'Un univers riche et immersif.',
            'La fin m\'a beaucoup surpris!',
            'Je relirai certainement ce livre.',
            'Idéal pour les amateurs du genre.',
            'Un peu décevant par rapport à mes attentes.',
            'Le style d\'écriture est remarquable.',
            'Une intrigue bien ficelée.'
        ];
        
        for ($i = 0; $i < 5000; $i++) {
            $comments[] = [
                'user_id' => $faker->randomElement($userIds),
                'book_id' => $faker->randomElement($bookIds),
                'comment' => $faker->randomElement($commentTemplates) . ' ' . $faker->paragraph(),
                'is_approved' => $faker->boolean(90),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ];
            
            $ratings[] = [
                'user_id' => $faker->randomElement($userIds),
                'book_id' => $faker->randomElement($bookIds),
                'rating' => $faker->numberBetween(1, 5),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ];
        }
        
        DB::table('comments')->insert($comments);
        DB::table('ratings')->insert($ratings);
        
        $this->command->info('✅ 5,000 commentaires et évaluations créés');
        
        // 6. Mettre à jour les compteurs de catégories
        DB::statement('
            UPDATE categories 
            SET books_count = (
                SELECT COUNT(*) 
                FROM books 
                WHERE books.category_id = categories.id 
                AND books.status = "approved"
            )
        ');
        
        $this->command->info('✅ Compteurs de catégories mis à jour');
        
        // Afficher le résumé
        $this->command->info('');
        $this->command->info('🎉 GÉNÉRATION TERMINÉE AVEC SUCCÈS!');
        $this->command->info('====================================');
        $this->command->info('📚 Livres: 10,000');
        $this->command->info('👥 Utilisateurs: 500');
        $this->command->info('📂 Catégories: ' . count($categories));
        $this->command->info('📊 Statistiques de lecture: 20,000');
        $this->command->info('💬 Commentaires: 5,000');
        $this->command->info('⭐ Évaluations: 5,000');
        $this->command->info('====================================');
        $this->command->info('Total: Plus de 40,000 enregistrements créés!');
    }
}