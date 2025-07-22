<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\User;

class TestBooksSeeder extends Seeder
{
    public function run()
    {
        // Créer un utilisateur auteur si il n'existe pas
        $author = User::firstOrCreate(
            ['email' => 'author@test.com'],
            [
                'name' => 'Test Author',
                'password' => bcrypt('password'),
                'role' => 'author'
            ]
        );

        // Livres de test avec différentes catégories et langues
        $books = [
            [
                'title' => 'Le Petit Prince',
                'author_name' => 'Antoine de Saint-Exupéry',
                'category' => 'Fiction',
                'language' => 'Français',
                'description' => 'Un conte poétique et philosophique sous l\'apparence d\'un conte pour enfants.',
                'isbn' => '978-2-07-040850-1',
                'publisher' => 'Gallimard',
                'publication_year' => 1943,
                'pages' => 96,
                'status' => 'approved',
                'views' => 150,
                'downloads' => 45
            ],
            [
                'title' => 'Une Brève Histoire du Temps',
                'author_name' => 'Stephen Hawking',
                'category' => 'Science',
                'language' => 'Français',
                'description' => 'Un livre de vulgarisation scientifique qui traite de cosmologie.',
                'isbn' => '978-2-08-081238-0',
                'publisher' => 'Flammarion',
                'publication_year' => 1988,
                'pages' => 256,
                'status' => 'approved',
                'views' => 89,
                'downloads' => 23
            ],
            [
                'title' => 'Clean Code',
                'author_name' => 'Robert C. Martin',
                'category' => 'Technologie',
                'language' => 'Anglais',
                'description' => 'A Handbook of Agile Software Craftsmanship.',
                'isbn' => '978-0-13-235088-4',
                'publisher' => 'Prentice Hall',
                'publication_year' => 2008,
                'pages' => 464,
                'status' => 'approved',
                'views' => 234,
                'downloads' => 67
            ],
            [
                'title' => 'Sapiens',
                'author_name' => 'Yuval Noah Harari',
                'category' => 'Histoire',
                'language' => 'Français',
                'description' => 'Une brève histoire de l\'humanité.',
                'isbn' => '978-2-226-25701-7',
                'publisher' => 'Albin Michel',
                'publication_year' => 2015,
                'pages' => 512,
                'status' => 'approved',
                'views' => 312,
                'downloads' => 89
            ],
            [
                'title' => 'Steve Jobs',
                'author_name' => 'Walter Isaacson',
                'category' => 'Biographie',
                'language' => 'Anglais',
                'description' => 'The exclusive biography of Steve Jobs.',
                'isbn' => '978-1-4516-4853-9',
                'publisher' => 'Simon & Schuster',
                'publication_year' => 2011,
                'pages' => 656,
                'status' => 'approved',
                'views' => 198,
                'downloads' => 54
            ],
            [
                'title' => 'Don Quijote de la Mancha',
                'author_name' => 'Miguel de Cervantes',
                'category' => 'Fiction',
                'language' => 'Espagnol',
                'description' => 'La obra cumbre de la literatura española.',
                'isbn' => '978-84-376-0494-7',
                'publisher' => 'Cátedra',
                'publication_year' => 2005, // Édition moderne
                'pages' => 1200,
                'status' => 'approved',
                'views' => 76,
                'downloads' => 21
            ],
            [
                'title' => 'JavaScript: The Good Parts',
                'author_name' => 'Douglas Crockford',
                'category' => 'Technologie',
                'language' => 'Anglais',
                'description' => 'Unearthing the Excellence in JavaScript.',
                'isbn' => '978-0-596-51774-8',
                'publisher' => 'O\'Reilly Media',
                'publication_year' => 2008,
                'pages' => 176,
                'status' => 'approved',
                'views' => 145,
                'downloads' => 38
            ],
            [
                'title' => 'L\'Art de la Guerre',
                'author_name' => 'Sun Tzu',
                'category' => 'Histoire',
                'language' => 'Français',
                'description' => 'Traité de stratégie militaire et politique.',
                'isbn' => '978-2-253-06829-8',
                'publisher' => 'Le Livre de Poche',
                'publication_year' => 2010, // Édition moderne
                'pages' => 128,
                'status' => 'approved',
                'views' => 267,
                'downloads' => 72
            ]
        ];

        foreach ($books as $bookData) {
            Book::create(array_merge($bookData, [
                'uploaded_by' => $author->id,
                'pdf_path' => 'books/sample.pdf', // Fichier fictif
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(1, 30))
            ]));
        }

        $this->command->info('Test books created successfully!');
    }
}
