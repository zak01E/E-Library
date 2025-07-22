<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\User;

class FixAuthorNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Liste de vrais noms d'auteurs pour remplacer les valeurs manquantes ou incorrectes
        $realAuthors = [
            'Antoine de Saint-Exupéry',
            'Stephen Hawking',
            'Robert C. Martin',
            'Yuval Noah Harari',
            'Walter Isaacson',
            'Miguel de Cervantes',
            'Douglas Crockford',
            'Sun Tzu',
            'Marie Curie',
            'Albert Einstein',
            'Charles Darwin',
            'Leonardo da Vinci',
            'Isaac Newton',
            'Galileo Galilei',
            'Nikola Tesla',
            'Alan Turing',
            'Ada Lovelace',
            'Grace Hopper',
            'Tim Berners-Lee',
            'Linus Torvalds',
            'Steve Jobs',
            'Bill Gates',
            'Mark Zuckerberg',
            'Elon Musk',
            'Jeff Bezos',
            'Warren Buffett',
            'Napoleon Bonaparte',
            'Winston Churchill',
            'Martin Luther King Jr.',
            'Nelson Mandela',
            'Mahatma Gandhi',
            'Mother Teresa',
            'Maya Angelou',
            'Toni Morrison',
            'Gabriel García Márquez',
            'Paulo Coelho',
            'J.K. Rowling',
            'George Orwell',
            'Ernest Hemingway',
            'William Shakespeare',
            'Victor Hugo',
            'Marcel Proust',
            'Simone de Beauvoir',
            'Jean-Paul Sartre',
            'Albert Camus',
            'Voltaire',
            'Molière',
            'Honoré de Balzac',
            'Émile Zola',
            'Guy de Maupassant',
            'Alexandre Dumas'
        ];

        // Trouver les livres avec des noms d'auteurs manquants ou incorrects
        $booksToFix = Book::where(function($query) {
            $query->whereNull('author_name')
                  ->orWhere('author_name', '')
                  ->orWhere('author_name', 'Histoire')
                  ->orWhere('author_name', 'Philosophy')
                  ->orWhere('author_name', 'Science Teacher')
                  ->orWhere('author_name', 'LIKE', 'Auteur%');
        })->get();

        $this->command->info("Trouvé {$booksToFix->count()} livres à corriger");

        foreach ($booksToFix as $index => $book) {
            // Assigner un nom d'auteur aléatoire de la liste
            $randomAuthor = $realAuthors[array_rand($realAuthors)];
            
            $book->update([
                'author_name' => $randomAuthor
            ]);

            $this->command->info("Livre '{$book->title}' -> Auteur: {$randomAuthor}");
        }

        $this->command->info('Correction des noms d\'auteurs terminée!');
    }
}
