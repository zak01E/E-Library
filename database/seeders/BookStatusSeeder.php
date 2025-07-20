<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\User;

class BookStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Trouver un auteur existant ou en créer un
        $author = User::where('role', 'author')->first();

        if (!$author) {
            $author = User::create([
                'name' => 'Auteur Test',
                'email' => 'auteur@test.com',
                'password' => bcrypt('password'),
                'role' => 'author',
                'author_name' => 'Auteur Test'
            ]);
        }

        // Créer des livres avec différents statuts
        $books = [
            [
                'title' => 'Les secrets de l\'économie',
                'description' => 'Plongez dans l\'univers fascinant de l\'économie avec cet ouvrage complet.',
                'author_name' => 'Histoire',
                'category' => 'Économie',
                'language' => 'fr',
                'publication_year' => 2024,
                'status' => 'approved',
                'is_approved' => true,
                'views' => 150,
                'downloads' => 45
            ],
            [
                'title' => 'Comprendre la littérature',
                'description' => 'Explorez en profondeur la littérature avec des exemples pratiques.',
                'author_name' => 'Philosophy',
                'category' => 'Littérature',
                'language' => 'fr',
                'publication_year' => 2024,
                'status' => 'pending',
                'is_approved' => false,
                'views' => 0,
                'downloads' => 0
            ],
            [
                'title' => 'Guide de programmation avancée',
                'description' => 'Un guide complet pour maîtriser la programmation moderne.',
                'author_name' => 'Tech Expert',
                'category' => 'Informatique',
                'language' => 'fr',
                'publication_year' => 2024,
                'status' => 'rejected',
                'is_approved' => false,
                'views' => 25,
                'downloads' => 0
            ],
            [
                'title' => 'Histoire de l\'art moderne',
                'description' => 'Découvrez l\'évolution de l\'art à travers les siècles.',
                'author_name' => 'Art Historian',
                'category' => 'Art',
                'language' => 'fr',
                'publication_year' => 2023,
                'status' => 'approved',
                'is_approved' => true,
                'views' => 200,
                'downloads' => 78
            ],
            [
                'title' => 'Manuel de sciences naturelles',
                'description' => 'Un manuel complet sur les sciences naturelles pour tous.',
                'author_name' => 'Science Teacher',
                'category' => 'Sciences',
                'language' => 'fr',
                'publication_year' => 2024,
                'status' => 'rejected',
                'is_approved' => false,
                'views' => 10,
                'downloads' => 0
            ]
        ];

        foreach ($books as $bookData) {
            Book::create(array_merge($bookData, [
                'uploaded_by' => $author->id,
                'pdf_path' => 'books/sample.pdf', // Fichier fictif
            ]));
        }
    }
}
