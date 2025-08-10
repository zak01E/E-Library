<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@elibrary.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Créer un auteur de test
        $author = User::create([
            'name' => 'Author Test',
            'email' => 'author@elibrary.com',
            'password' => Hash::make('password'),
            'role' => 'author',
            'email_verified_at' => now(),
        ]);

        // Créer un utilisateur de test
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user@elibrary.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Créer des auteurs supplémentaires
        $authors = User::factory(4)->create([
            'role' => 'author',
            'email_verified_at' => now(),
        ]);
        $authors->push($author);

        // Créer des utilisateurs normaux
        User::factory(9)->create([
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Créer des livres pour chaque auteur
        foreach ($authors as $author) {
            Book::factory(rand(3, 8))->create([
                'uploaded_by' => $author->id,
                'is_approved' => rand(0, 10) > 2, // 80% approuvés
            ]);
        }

        // Créer quelques livres non approuvés pour tester
        Book::factory(5)->create([
            'uploaded_by' => $authors->random()->id,
            'is_approved' => false,
        ]);

        // Seed site settings
        $this->call([
            SiteSettingsSeeder::class,
            HomepageContentSeeder::class,
        ]);

        $this->command->info('Base de données peuplée avec succès!');
        $this->command->info('');
        $this->command->info('Comptes de test:');
        $this->command->info('Admin - Email: admin@elibrary.com | Mot de passe: password');
        $this->command->info('Auteur - Email: author@elibrary.com | Mot de passe: password');
        $this->command->info('Utilisateur - Email: user@elibrary.com | Mot de passe: password');
    }
}